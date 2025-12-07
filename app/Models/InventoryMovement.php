<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reason',
        'reference',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relación con producto
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación con usuario que realizó el movimiento
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el color del badge según el tipo
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'entrada' => 'green',
            'salida' => 'red',
            'ajuste' => 'yellow',
            default => 'gray',
        };
    }

    /**
     * Obtener el icono según el tipo
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'entrada' => 'fa-arrow-up',
            'salida' => 'fa-arrow-down',
            'ajuste' => 'fa-edit',
            default => 'fa-question',
        };
    }
}
