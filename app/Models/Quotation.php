<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_number',
        'subtotal',
        'tax_amount',
        'total_amount',
        'discount_amount',
        'status',
        'notes',
        'valid_until',
        'approved_at',
        'rejected_at',
        'payment_deadline',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'payment_deadline' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public static function generateReferenceNumber()
    {
        return 'COT-' . date('Ymd') . '-' . str_pad(self::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
    }
}
