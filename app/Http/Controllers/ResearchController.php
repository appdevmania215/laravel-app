<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class ResearchController extends Controller
{
    //
    public function index():view
    {
        $transactions=Transaction::all();
        $payments=Payment::all();
        return view('research.index',['researchResults'=>[]]);
    }
    public function research(Request $request):view{

        $startDateTime = Carbon::parse($request->start);
        $endDateTime = Carbon::parse($request->to);

        $researchResults=[];

        // Loop through each month
        while ($startDateTime->lessThanOrEqualTo($endDateTime)) {
            // Get the last day of the current month
            $lastDayOfMonth = $startDateTime->copy()->endOfMonth();
            $firstDayOfMonth=$startDateTime->copy()->startOfMonth();
            $researchMonth=new ResearchMonth();

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


        return view('research.index',['researchResults'=>$researchResults]);

    }

}
class ResearchMonth{
    public $year;
    public $month;
    public $paid=0;
    public $outstanding=0;
    public $overdue=0;
}
