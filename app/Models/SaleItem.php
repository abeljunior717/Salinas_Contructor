<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo SaleItem (Item de Venta)
 * 
 * Representa un producto individual dentro de una venta (Sale).
 * Almacena el detalle de cada producto vendido:
 * - Producto y cantidad vendida
 * - Precio unitario al momento de la venta
 * - Total de la línea (precio * cantidad)
 * 
 * Relaciones:
 * - Pertenece a una Venta (Sale)
 * - Pertenece a un Producto (Product)
 * 
 * @package App\Models
 * @author Abel Luna Pérez
 * @version 1.0
 */
class SaleItem extends Model
{
    use HasFactory;

    /**
     * Atributos asignables en masa
     * 
     * @var array
     */
    protected $fillable = [
        'sale_id',      // ID de la venta a la que pertenece
        'product_id',   // ID del producto vendido
        'quantity',     // Cantidad vendida del producto
        'unit_price',   // Precio unitario al momento de la venta
        'line_total',   // Total de la línea (unit_price * quantity)
    ];

    /**
     * Conversión de tipos para atributos
     * 
     * @var array
     */
    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    /**
     * Relación: Item pertenece a una Venta
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relación: Item pertenece a un Producto
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
