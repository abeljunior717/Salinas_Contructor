<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Sale (Venta)
 * 
 * Representa una venta realizada en el sistema de Punto de Venta (POS).
 * Almacena información completa de la transacción incluyendo:
 * - Folio único de venta
 * - Datos del cliente
 * - Totales (subtotal, IVA, total)
 * - Método de pago
 * - Usuario que registró la venta
 * 
 * Relaciones:
 * - Pertenece a un Usuario (vendedor)
 * - Tiene muchos SaleItems (productos vendidos)
 * 
 * @package App\Models
 * @author Abel Luna Pérez
 * @version 1.0
 */
class Sale extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa
     * 
     * @var array
     */
    protected $fillable = [
        'user_id',           // ID del usuario que registró la venta
        'sale_number',       // Folio único (VTA-YYYYMMDD-####)
        'customer_name',     // Nombre del cliente (opcional)
        'customer_phone',    // Teléfono del cliente (opcional)
        'subtotal',          // Subtotal antes de impuestos
        'tax_amount',        // Monto del IVA (19%)
        'total_amount',      // Total final de la venta
        'payment_method',    // Método de pago: efectivo, tarjeta, transferencia
        'status',            // Estado: completada, cancelada, pendiente
        'notes',             // Notas adicionales (opcional)
    ];

    /**
     * Conversión de tipos para atributos
     * 
     * @var array
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Relación: Venta pertenece a un Usuario (vendedor)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Venta tiene muchos Items (productos vendidos)
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
