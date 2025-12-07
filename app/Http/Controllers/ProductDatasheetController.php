<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductDatasheetController extends Controller
{
    /**
     * Generar y descargar ficha técnica en PDF
     */
    public function downloadDatasheet(Product $product)
    {
        // Preparar datos para la vista PDF
        $data = [
            'product' => $product,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ];

        // Generar PDF usando la vista
        $pdf = Pdf::loadView('products.datasheet-pdf', $data);
        
        // Descargar con nombre del producto
        $filename = 'Ficha-Tecnica-' . Str::slug($product->name) . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Ver ficha técnica en navegador (sin descargar)
     */
    public function viewDatasheet(Product $product)
    {
        $data = [
            'product' => $product,
            'generatedAt' => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('products.datasheet-pdf', $data);
        return $pdf->stream('Ficha-Tecnica-' . Str::slug($product->name) . '.pdf');
    }
}
