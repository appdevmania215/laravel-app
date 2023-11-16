<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ResearchMonth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ]
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function saveTransaction(Request $request){
        $payer=User::where('name', $request->payer)->first();
        if(!$payer) return response()->json([
            'status'=>'error',
            'data'=>'NO USER'
        ]);
        $newTransaction=new Transaction;
        $newTransaction->amount=$request->amount;
        $newTransaction->payer=$request->payer;
        $newTransaction->due_on=$request->due_on;
        $newTransaction->vat=$request->vat;
        $newTransaction->is_vat_inclusive=$request->is_vat_inclusive=="on"?true:false;
        $newTransaction->save();
        return response()->json([
            'status'=>'success'
        ]);
    }
    public  function  getTransaction(Request $request,string $id){
        $transaction=Transaction::findOrFail($id);
        if($request->user()->role!="admin"&&$request->user()->name!=$transaction->payer)
            return response()->json([
                'status'=>'error',
                'data'=>'NO PERMISSION'
            ]);
        $payments=$transaction->payments;
        return response()->json([
            'status'=>'success',
            'data'=>[
                'transaction'=>$transaction,
                'payments'=>$payments
            ]
        ]);
    }
    public function savePayment(Request $request){
        $transaction=Transaction::findOrFail($request->transaction);
        if($transaction->paid()>=$transaction->amount)
            return response()->json([
                'status'=>'error',
                'data'=>'ALREADY PAID'
            ]);
        Payment::create($request->all());
        return response()->json([
            'status'=>'success'
        ]);
    }
    public function makeResearch(Request $request){
        $startDateTime = Carbon::parse($request->start);
        $endDateTime = Carbon::parse($request->to);

        $researchResults=[];

        // Loop through each month
        while ($startDateTime->lessThanOrEqualTo($endDateTime)) {
            // Get the last day of the current month
            $lastDayOfMonth = $startDateTime->copy()->endOfMonth();
            $firstDayOfMonth=$startDateTime->copy()->startOfMonth();
            $researchMonth=new APIResearchMonth();

            $researchMonth->year=$lastDayOfMonth->year;
            $researchMonth->month=$lastDayOfMonth->month;

            $paidMonth=Payment::where('paid_on','<',$lastDayOfMonth)
                ->where('paid_on',">",$firstDayOfMonth)
                ->sum('amount');
            $researchMonth->paid=$paidMonth;

            $transactionsMonth=Transaction::where('due_on','<',$lastDayOfMonth)
                ->get();

            $outstandingMonth=0;
            $overdueMonth=0;

            foreach ($transactionsMonth as $transaction){
                $status=$transaction->status();
                if($status=="Outstanding"){
                    $outstandingMonth+=$transaction->amount-$transaction->paid();
                }else if($status=="Overdue"){
                    $overdueMonth+=$transaction->amount-$transaction->paid();
                }
                else continue;
            }
            $researchMonth->outstanding=$outstandingMonth;
            $researchMonth->overdue=$overdueMonth;

            $researchResults[]=$researchMonth;

            $startDateTime->firstOfMonth()->addMonth();
        }
        return response()->json([
            'status'=>'success',
            'data'=>$researchResults
        ]);
    }
}
class APIResearchMonth{
    public $year;
    public $month;
    public $paid=0;
    public $outstanding=0;
    public $overdue=0;
}
