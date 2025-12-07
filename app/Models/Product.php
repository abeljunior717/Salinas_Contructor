<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'technical_specs',
        'price',
        'unit',
        'stock_quantity',
        'sku',
        'image_url',
        'images',
        'brand',
        'weight',
        'dimensions',
        'benefits',
        'materials',
        'intended_use',
        'other_qualities',
        'detailed_specs',
        'color',
        'performance',
        'material_type',
        'weight_spec',
        'accessories',
        'warranty',
        'package_content',
        'model_spec',
        'height_spec',
        'width_spec',
        'length_spec',
        'depth_spec',
        'capacity',
        'pieces_count',
        'status',
        'is_active',
        'stock_min',
    ];

    protected $casts = [
        'technical_specs' => 'json',
        'images' => 'json',
        'detailed_specs' => 'json',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function isAvailable()
    {
        return $this->status === 'disponible' && $this->stock_quantity > 0;
    }

    public function isLowStock()
    {
        return $this->stock_quantity < $this->stock_min;
    }
}
