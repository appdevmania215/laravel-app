<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nette\Utils\DateTime;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=['amount','payer','due_on','vat','is_vat_inclusive'];
    public function payments():HasMany{
        return  $this->hasMany(Payment::class,'transaction','id');
    }
    public function paid():float{
        $payments=$this->hasMany(Payment::class,'transaction','id');
        $tax= $payments->sum('amount')*($this->vat)*($this->is_vat_inclusive)/100;
        return $payments->sum('amount')-$tax;
    }
    public function status():string{
        if($this->paid()>=$this->amount){
            return "Paid";
        }else{
            $date1 = new DateTime($this->due_on);
            $date2 = new DateTime();
            if($date1>$date2) return "Outstanding";
            else return"Overdue";
        }
    }
}
