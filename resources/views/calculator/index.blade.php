@extends('layouts.app')

@section('title', 'Calculadora de Materiales - Salinas Constructor')

@section('content')
<div class="min-h-screen bg-blue-50">
    <!-- Hero Section -->
    <div class="hero">
        <div class="max-w-5xl mx-auto">
            <h1>Calculadora de Materiales</h1>
            <p>Estima los materiales necesarios para construir un muro de concreto.</p>
        </div>
    </div>

    <!-- Calculator Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Formulario -->
            <div class="bg-white rounded-lg p-8 shadow-md">
                <h2 class="text-2xl font-bold mb-6">1. Ingresa las Dimensiones del Muro</h2>
                <p class="text-gray-600 mb-6">Introduce las medidas en metros para calcular los materiales.</p>

                <form id="calculatorForm" class="space-y-6">
                    <!-- Largo -->
                    <div>
                        <label class="block text-sm font-bold mb-2">Largo (metros)</label>
                        <input type="number" id="length" name="length" step="0.1" min="0.1" 
                               placeholder="Ej: 5" class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <small class="text-gray-500">Ancho del muro</small>
                    </div>

                    <!-- Alto -->
                    <div>
                        <label class="block text-sm font-bold mb-2">Alto (metros)</label>
                        <input type="number" id="height" name="height" step="0.1" min="0.1" 
                               placeholder="Ej: 5" class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <small class="text-gray-500">Altura del muro</small>
                    </div>

                    <!-- Espesor -->
                    <div>
                        <label class="block text-sm font-bold mb-2">Espesor (metros)</label>
                        <input type="number" id="thickness" name="thickness" step="0.01" min="0.05" 
                               placeholder="Ej: 0.15" class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                               focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <small class="text-gray-500">Grosor del muro (típicamente 0.15m)</small>
                    </div>

                    <!-- Botón de cálculo -->
                    <button type="submit" class="btn-yellow w-full py-3 font-bold text-lg">
                        <i class="fas fa-calculator mr-2"></i> Calcular Materiales
                    </button>
                </form>

                <!-- Info -->
                <div class="bg-blue-50 p-4 rounded-lg mt-8">
                    <p class="text-sm text-gray-700">
                        <strong>💡 Nota:</strong> Esta es una estimación inicial para un muro de concreto simple. 
                        Se incluye un 10% extra por desperdicio. Consulta siempre con un profesional de la construcción.
                    </p>
                </div>
            </div>

            <!-- Resultados -->
            <div class="bg-blue-100 rounded-lg p-8" id="resultsContainer" style="display: none;">
                <h2 class="text-2xl font-bold mb-6">2. Materiales Necesarios (Aproximado)</h2>
                <p class="text-gray-600 mb-6">Esta es una estimación inicial para un muro de concreto simple.</p>

                <!-- Volumen -->
                <div class="bg-white p-4 rounded-lg mb-4 border-l-4 border-blue-800">
                    <p class="text-sm text-gray-600">Volumen del Muro</p>
                    <p class="text-2xl font-bold text-blue-600" id="volumeResult">0</p>
                    <p class="text-xs text-gray-500">m³</p>
                </div>

                <!-- Cemento -->
                <div class="flex items-center gap-4 mb-6 p-4 bg-white rounded-lg">
                    <div class="text-4xl text-blue-800">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Cemento (bolsas 50kg)</p>
                        <p class="text-2xl font-bold" id="cementResult">0</p>
                        <p class="text-xs text-gray-500">Incluye 10% desperdicio</p>
                    </div>
                </div>

                <!-- Arena -->
                <div class="flex items-center gap-4 mb-6 p-4 bg-white rounded-lg">
                    <div class="text-4xl text-amber-700">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Arena (m³)</p>
                        <p class="text-2xl font-bold" id="sandResult">0</p>
                        <p class="text-xs text-gray-500">Incluye 10% desperdicio</p>
                    </div>
                </div>

                <!-- Grava -->
                <div class="flex items-center gap-4 mb-6 p-4 bg-white rounded-lg">
                    <div class="text-4xl text-gray-600">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Grava (m³)</p>
                        <p class="text-2xl font-bold" id="gravelResult">0</p>
                        <p class="text-xs text-gray-500">Incluye 10% desperdicio</p>
                    </div>
                </div>

                <!-- Varilla de acero -->
                <div class="flex items-center gap-4 p-4 bg-white rounded-lg">
                    <div class="text-4xl text-orange-600">
                        <i class="fas fa-hammer"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Varilla de Acero #4 (1/2")</p>
                        <p class="text-2xl font-bold"><span id="rodCountResult">0</span> varillas de 6m</p>
                        <p class="text-xs text-gray-500" id="rodWeightResult">Peso: 0 kg</p>
                    </div>
                </div>

                <!-- Nota importante -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mt-6">
                    <p class="text-xs text-gray-700">
                        <strong>⚠️ Cálculos incluyen un 10% de desperdicio en concreto.</strong> La cantidad de varilla 
                        es una estimación estructural básica. Consulta siempre a un ingeniero para diseños específicos.
                    </p>
                </div>
            </div>

            <!-- Estado de cálculo sin resultados -->
            <div class="bg-blue-100 rounded-lg p-8" id="emptyStateContainer">
                <div class="text-center">
                    <i class="fas fa-calculator text-6xl text-blue-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">2. Materiales Necesarios (Aproximado)</h3>
                    <p class="text-gray-600 mb-4">Ingresa las dimensiones del muro y haz clic en "Calcular Materiales"</p>
                    <p class="text-sm text-gray-500">Los resultados aparecerán aquí</p>
                </div>
            </div>
        </div>

        <!-- Fórmulas de cálculo -->
        <div class="mt-16 bg-white rounded-lg p-8 shadow-md">
            <h3 class="text-2xl font-bold mb-6">📐 Cómo funciona la calculadora</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Paso 1 -->
                <div>
                    <h4 class="text-lg font-bold text-blue-600 mb-3">🔹 Paso 1: Volumen</h4>
                    <p class="text-gray-600 text-sm mb-3">Se calcula el volumen total del muro:</p>
                    <div class="bg-blue-50 p-3 rounded text-sm font-mono">
                        V = Largo × Alto × Espesor
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Unidad: m³</p>
                </div>

                <!-- Paso 2 -->
                <div>
                    <h4 class="text-lg font-bold text-blue-600 mb-3">🔹 Paso 2: Concreto</h4>
                    <p class="text-gray-600 text-sm mb-3">Por cada m³ se necesita (mezcla 1:2:3):</p>
                    <ul class="text-sm space-y-1 font-mono text-gray-700">
                        <li>• Cemento: V × 7 bolsas</li>
                        <li>• Arena: V × 0.56 m³</li>
                        <li>• Grava: V × 0.84 m³</li>
                    </ul>
                    <p class="text-xs text-gray-500 mt-2">+ 10% desperdicio</p>
                </div>

                <!-- Paso 3 -->
                <div>
                    <h4 class="text-lg font-bold text-blue-600 mb-3">🔹 Paso 3: Acero</h4>
                    <p class="text-gray-600 text-sm mb-3">Varilla de refuerzo distribuida:</p>
                    <ul class="text-sm space-y-1 font-mono text-gray-700">
                        <li>• Vertical: cada 30cm</li>
                        <li>• Horizontal: cada 50cm</li>
                        <li>• Peso: 0.99 kg/m</li>
                    </ul>
                    <p class="text-xs text-gray-500 mt-2">Varilla #4 (1/2")</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('calculatorForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const length = parseFloat(document.getElementById('length').value);
    const height = parseFloat(document.getElementById('height').value);
    const thickness = parseFloat(document.getElementById('thickness').value);

    // Validación básica en el cliente
    if (!length || length < 0.1 || !height || height < 0.1 || !thickness || thickness < 0.05) {
        showError('Por favor ingresa valores válidos: Largo y Alto mínimo 0.1m, Espesor mínimo 0.05m');
        return;
    }

    try {
        const response = await fetch('{{ route("calculator.calculate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                length: length,
                height: height,
                thickness: thickness
            })
        });

        const data = await response.json();

        if (data.success) {
            // Mostrar resultados
            document.getElementById('emptyStateContainer').style.display = 'none';
            document.getElementById('resultsContainer').style.display = 'block';
            hideError();

            // Llenar datos
            document.getElementById('volumeResult').textContent = data.volume;
            document.getElementById('cementResult').textContent = data.cement.bags_with_waste;
            document.getElementById('sandResult').textContent = data.sand.m3_with_waste;
            document.getElementById('gravelResult').textContent = data.gravel.m3_with_waste;
            document.getElementById('rodCountResult').textContent = data.steel.number_of_rods;
            document.getElementById('rodWeightResult').textContent = 'Peso: ' + data.steel.total_weight_kg + ' kg';

            // Scroll a resultados
            document.getElementById('resultsContainer').scrollIntoView({ behavior: 'smooth' });
        } else {
            showError(data.message || 'Error al calcular materiales');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('No se pudo conectar con el servidor. Por favor intenta de nuevo.');
    }
});

function showError(message) {
    let errorDiv = document.getElementById('errorMessage');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'errorMessage';
        errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mt-4';
        document.getElementById('calculatorForm').appendChild(errorDiv);
    }
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

function hideError() {
    const errorDiv = document.getElementById('errorMessage');
    if (errorDiv) {
        errorDiv.style.display = 'none';
    }
}

// Calcular automáticamente al cambiar valores
document.getElementById('length').addEventListener('change', function() {
    if (this.value) document.getElementById('calculatorForm').dispatchEvent(new Event('submit'));
});
document.getElementById('height').addEventListener('change', function() {
    if (this.value) document.getElementById('calculatorForm').dispatchEvent(new Event('submit'));
});
document.getElementById('thickness').addEventListener('change', function() {
    if (this.value) document.getElementById('calculatorForm').dispatchEvent(new Event('submit'));
});
</script>
@endsection
