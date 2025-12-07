<?php

namespace App\Http\Controllers\Admin;

use App\Services\ProductDataScraperService;
use Illuminate\Http\Request;

class ProductDataController extends \App\Http\Controllers\Controller
{
    protected $scraperService;

    public function __construct(ProductDataScraperService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    /**
     * Obtener datos sugeridos para un producto
     * Endpoint: GET /api/admin/products/data-suggestions?product_name=...
     */
    public function getSuggestions(Request $request)
    {
        $productName = $request->query('product_name');

        if (!$productName || strlen($productName) < 3) {
            return response()->json(['error' => 'Product name too short'], 400);
        }

        $data = $this->scraperService->getProductData($productName);

        if (!$data) {
            // Si no hay datos específicos, devuelve estructura vacía
            $data = [
                'benefits' => '',
                'materials' => '',
                'intended_use' => '',
                'other_qualities' => '',
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Datos encontrados. Puedes editarlos antes de guardar.',
        ]);
    }
}
