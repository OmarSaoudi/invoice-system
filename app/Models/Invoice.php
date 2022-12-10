<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product_id',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
    ];
    protected $table = 'invoices';
    public $timestamps = true;


    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id');
    }
}
