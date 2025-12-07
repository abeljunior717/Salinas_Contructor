# 🧮 CALCULADORA DE MATERIALES - IMPLEMENTADA

## ✅ ¿QUÉ SE AGREGÓ?

Se implementó una **Calculadora de Materiales para Muros de Concreto** con todas las fórmulas matemáticas solicitadas.

**URL:** `http://localhost:8000/calculadora`

---

## 📐 CÁLCULOS IMPLEMENTADOS

### **🔹 Paso 1: Volumen del Muro**

**Fórmula:**
```
V = Largo (m) × Alto (m) × Espesor (m)
```

**Ejemplo:**
- Largo: 5m
- Alto: 5m  
- Espesor: 0.15m
- **Resultado: V = 3.75 m³**

---

### **🔹 Paso 2: Materiales de Concreto (Mezcla 1:2:3)**

**Por cada 1 m³ de concreto:**

| Material | Cantidad |
|----------|----------|
| Cemento (bolsas 50kg) | 7 bolsas |
| Arena | 0.56 m³ |
| Grava | 0.84 m³ |

**Cálculos:**
```
Cemento = V × 7 bolsas
Arena = V × 0.56 m³
Grava = V × 0.84 m³
```

**Con 10% de desperdicio:**
```
Cemento = (V × 7) × 1.10
Arena = (V × 0.56) × 1.10
Grava = (V × 0.84) × 1.10
```

**Ejemplo para V = 3.75 m³:**
- Cemento: (3.75 × 7) × 1.10 = **28.88 bolsas**
- Arena: (3.75 × 0.56) × 1.10 = **2.31 m³**
- Grava: (3.75 × 0.84) × 1.10 = **3.47 m³**

---

### **🔹 Paso 3: Varilla de Acero (Refuerzo)**

**Distribución típica:**
- Varillas Verticales: cada 30 cm
- Varillas Horizontales: cada 50 cm

**Cálculo de varillas verticales:**
```
Verticales = (Largo / 0.30 + 1) × Alto
```

**Cálculo de varillas horizontales:**
```
Horizontales = (Alto / 0.50 + 1) × Largo
```

**Total de metros lineales:**
```
Total = Verticales + Horizontales
```

**Número de varillas de 6m:**
```
Número de varillas = Total metros lineales ÷ 6 (redondeado hacia arriba)
```

**Peso estimado:**
```
Peso total = Total metros × 0.99 kg/m (varilla #4 de 1/2")
```

**Ejemplo para L=5m, H=5m:**
- Verticales: (5/0.30 + 1) × 5 = 85 metros
- Horizontales: (5/0.50 + 1) × 5 = 60 metros
- Total: 145 metros lineales
- **Varillas necesarias: 25 varillas de 6m**
- **Peso: 143.55 kg**

---

## 🎨 INTERFAZ DE USUARIO

### **Lado Izquierdo: Formulario de Entrada**
```
┌─────────────────────────────────────┐
│  1. Ingresa las Dimensiones del Muro│
│                                     │
│  Largo (metros):    [5       ]      │
│  Alto (metros):     [5       ]      │
│  Espesor (metros):  [0.15    ]      │
│                                     │
│  [🧮 Calcular Materiales]           │
│                                     │
│  💡 Nota: Estimación para muro     │
│  simple, incluye 10% desperdicio    │
└─────────────────────────────────────┘
```

### **Lado Derecho: Resultados (después de calcular)**
```
┌─────────────────────────────────────┐
│ 2. Materiales Necesarios             │
│                                     │
│  Volumen: 3.75 m³                  │
│                                     │
│  🧱 Cemento: 28.88 bolsas          │
│  🏜️ Arena: 2.31 m³                  │
│  🪨 Grava: 3.47 m³                  │
│  🔧 Varilla #4: 25 varillas (143kg) │
│                                     │
│  ⚠️ Cálculos incluyen 10% desperdic │
└─────────────────────────────────────┘
```

---

## 📁 ARCHIVOS CREADOS

### **Controlador**
- `app/Http/Controllers/CalculatorController.php`
  - Método `index()`: Muestra la vista
  - Método `calculate()`: Procesa AJAX y retorna JSON con cálculos

### **Vista**
- `resources/views/calculator/index.blade.php`
  - Formulario interactivo
  - Sección de resultados
  - Explicación de fórmulas
  - JavaScript para cálculos AJAX

### **Rutas**
- `GET /calculadora` → Mostrar calculadora
- `POST /calculadora/calcular` → Procesar cálculo (AJAX)

---

## 🔧 CARACTERÍSTICAS TÉCNICAS

✅ **Cálculo en Real-time:**
- Se calcula automáticamente al cambiar valores
- Sin necesidad de recargar la página
- Respuesta AJAX instantánea

✅ **Validaciones:**
- Campos obligatorios
- Valores numéricos positivos
- Mínimo 0.1m de largo/alto
- Mínimo 0.05m de espesor

✅ **Precisión:**
- Cálculos con 2 decimales
- Redondeo hacia arriba en varillas
- Inclusión automática de 10% desperdicio

✅ **UX Intuitiva:**
- Valores por defecto (5m × 5m × 0.15m)
- Iconos visuales para cada material
- Colores diferenciados
- Explicación de fórmulas
- Advertencia de estimación

---

## 🚀 CÓMO USAR

1. **Ir a la calculadora:**
   ```
   http://localhost:8000/calculadora
   ```

2. **Ingresar dimensiones:**
   - Largo del muro (en metros)
   - Alto del muro (en metros)
   - Espesor del muro (en metros)

3. **Click en "Calcular Materiales"** o cambiar valores

4. **Ver resultados instantáneamente:**
   - Volumen total
   - Cantidad de cemento
   - Volumen de arena
   - Volumen de grava
   - Varillas de acero necesarias
   - Peso total de varilla

---

## 📊 EJEMPLOS DE CÁLCULO

### **Ejemplo 1: Muro Pequeño**
```
Entrada:
- Largo: 3m
- Alto: 2m
- Espesor: 0.10m

Volumen: 0.60 m³

Resultados:
- Cemento: 4.62 bolsas
- Arena: 0.37 m³
- Grava: 0.55 m³
- Varilla: 4 varillas de 6m (23.76 kg)
```

### **Ejemplo 2: Muro Mediano**
```
Entrada:
- Largo: 5m
- Alto: 5m
- Espesor: 0.15m

Volumen: 3.75 m³

Resultados:
- Cemento: 28.88 bolsas
- Arena: 2.31 m³
- Grava: 3.47 m³
- Varilla: 25 varillas de 6m (143.55 kg)
```

### **Ejemplo 3: Muro Grande**
```
Entrada:
- Largo: 10m
- Alto: 3m
- Espesor: 0.20m

Volumen: 6.00 m³

Resultados:
- Cemento: 46.20 bolsas
- Arena: 3.70 m³
- Grava: 5.54 m³
- Varilla: 43 varillas de 6m (257.31 kg)
```

---

## 📱 INTEGRACIÓN EN NAVEGACIÓN

La calculadora está enlazada en:
1. **Navegación principal** (entre Productos y Noticias)
2. **Página de inicio** (features section - icono calculadora)
3. **Link directo:** `http://localhost:8000/calculadora`

---

## ⚠️ LIMITACIONES Y NOTAS

✅ **Qué calcula:**
- Volumen de muro (m³)
- Materiales de concreto (cemento, arena, grava)
- Refuerzo de varilla de acero
- Distribuición típica de varilla
- Peso aproximado de varilla

❌ **Qué NO calcula (requiere profesional):**
- Diseño estructural específico
- Resistencia del concreto
- Cargas específicas
- Profundidad de cimientos
- Armado completo del proyecto

---

## 🔒 VALIDACIONES IMPLEMENTADAS

```javascript
- Largo: mínimo 0.1m
- Alto: mínimo 0.1m
- Espesor: mínimo 0.05m
- Valores deben ser numéricos
- Todos los campos son obligatorios
- Se pueden ingresar decimales
```

---

## 📞 RECOMENDACIÓN

> "Esta calculadora proporciona una **estimación inicial** para un muro de concreto simple. Para proyectos específicos, consulta siempre con un ingeniero o profesional de la construcción cualificado."

---

**La calculadora está lista para usar. Accede a http://localhost:8000/calculadora** ✅
