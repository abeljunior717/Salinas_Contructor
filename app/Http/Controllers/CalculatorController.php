<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.index');
    }

    public function calculate(Request $request)
    {
        // Parsear el body JSON
        $data = $request->json()->all();
        
        $length = isset($data['length']) ? floatval($data['length']) : null;
        $height = isset($data['height']) ? floatval($data['height']) : null;
        $thickness = isset($data['thickness']) ? floatval($data['thickness']) : null;

        // Validar valores
        if (!$length || $length < 0.1 || !$height || $height < 0.1 || !$thickness || $thickness < 0.05) {
            return response()->json([
                'success' => false,
                'message' => 'Los valores deben ser mayores a: Largo 0.1m, Alto 0.1m, Espesor 0.05m'
            ], 400);
        }

        // Paso 1: Calcular volumen del muro
        $volume = $length * $height * $thickness;

        // Paso 2: Materiales de concreto (mezcla 1:2:3)
        $cement_bags = $volume * 7; // 7 bolsas por m³
        $sand = $volume * 0.56; // m³
        $gravel = $volume * 0.84; // m³

        // Agregar 10% por desperdicio
        $cement_bags_with_waste = $cement_bags * 1.10;
        $sand_with_waste = $sand * 1.10;
        $gravel_with_waste = $gravel * 1.10;

        // Paso 3: Cálculo de varilla de acero
        // Verticales: (Largo / 0.30 + 1) × Altura
        $vertical_rods = ($length / 0.30 + 1) * $height;

        // Horizontales: (Altura / 0.50 + 1) × Largo
        $horizontal_rods = ($height / 0.50 + 1) * $length;

        // Total metros lineales
        $total_linear_meters = $vertical_rods + $horizontal_rods;

        // Número de varillas de 6m
        $number_of_rods = ceil($total_linear_meters / 6);

        // Peso estimado (0.99 kg/m para varilla #4 1/2")
        $rod_weight_per_meter = 0.99;
        $total_rod_weight = $total_linear_meters * $rod_weight_per_meter;

        return response()->json([
            'success' => true,
            'volume' => round($volume, 2),
            'cement' => [
                'bags' => round($cement_bags, 2),
                'bags_with_waste' => round($cement_bags_with_waste, 2),
            ],
            'sand' => [
                'm3' => round($sand, 2),
                'm3_with_waste' => round($sand_with_waste, 2),
            ],
            'gravel' => [
                'm3' => round($gravel, 2),
                'm3_with_waste' => round($gravel_with_waste, 2),
            ],
            'steel' => [
                'total_linear_meters' => round($total_linear_meters, 2),
                'number_of_rods' => $number_of_rods,
                'total_weight_kg' => round($total_rod_weight, 2),
            ],
        ]);
    }
}
