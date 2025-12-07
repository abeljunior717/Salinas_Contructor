<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use App\Models\Product;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = \Illuminate\Http\Request::capture());

// Buscar y actualizar el producto de Cemento Portland
$product = Product::where('name', 'Cemento Portland 50kg')->first();

if ($product) {
    $product->image_url = 'https://toolstoremexico.com.mx/img/p/2/0/4/1/5/20415-large_default.jpg';
    $product->save();
    echo "Producto actualizado exitosamente.\n";
} else {
    echo "Producto no encontrado.\n";
}
?>
