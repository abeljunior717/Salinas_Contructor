# 🚨 SOLUCIÓN RÁPIDA: ERROR "Compress-Archive no se reconoce"

## ❌ PROBLEMA
```
"Compress-Archive" no se reconoce como un comando interno o externo,
programa o archivo por lotes ejecutable.
```

## ✅ CAUSA
Estás usando **CMD** (Símbolo del Sistema - ventana negra) en lugar de **PowerShell** (ventana azul).

---

## 🎯 SOLUCIÓN MÁS FÁCIL (RECOMENDADA)

### Método 1: Usar el Explorador de Windows (SIN COMANDOS)

1. **Abrir Explorador de Windows**
   - Presiona `Windows + E`

2. **Ir a la carpeta**
   - Navegar a: `C:\laragon\www`

3. **Comprimir la carpeta**
   - Click derecho en la carpeta `salinas`
   - Seleccionar: **"Enviar a"** → **"Carpeta comprimida (en zip)"**
   - Renombrar a: `salinas_entrega.zip`

**¡LISTO!** Ya tienes tu archivo comprimido ✅

---

## 🔧 SOLUCIÓN ALTERNATIVA 1: Usar PowerShell Correctamente

### Paso 1: Abrir PowerShell (NO CMD)

**Opción A:**
- Click derecho en el botón de Inicio
- Seleccionar: **"Windows PowerShell"** o **"Terminal"**
- (La ventana será AZUL, no negra)

**Opción B:**
- Presionar `Windows + X`
- Elegir: **"Windows PowerShell"**

**Opción C:**
- Presionar `Windows + R`
- Escribir: `powershell`
- Enter

### Paso 2: Ejecutar el Comando
```powershell
cd C:\laragon\www
Compress-Archive -Path salinas -DestinationPath salinas_entrega.zip -Force
```

---

## 🔧 SOLUCIÓN ALTERNATIVA 2: Ejecutar PowerShell desde CMD

Si ya estás en CMD y no quieres cambiar de ventana:

```cmd
cd C:\laragon\www
powershell -Command "Compress-Archive -Path salinas -DestinationPath salinas_entrega.zip -Force"
```

---

## 🔧 SOLUCIÓN ALTERNATIVA 3: Usar 7-Zip

Si tienes 7-Zip instalado:

1. Click derecho en carpeta `salinas`
2. **7-Zip** → **"Añadir al archivo..."**
3. Configurar:
   - Formato: ZIP
   - Nombre: `salinas_entrega.zip`
4. Click en **OK**

**Descargar 7-Zip:** https://www.7-zip.org/

---

## 🔧 SOLUCIÓN ALTERNATIVA 4: Usar WinRAR

Si tienes WinRAR instalado:

1. Click derecho en carpeta `salinas`
2. **"Agregar al archivo..."**
3. Configurar:
   - Formato: ZIP
   - Nombre: `salinas_entrega.zip`
4. Click en **Aceptar**

---

## ✅ VERIFICAR QUE FUNCIONÓ

### Ver el tamaño del archivo creado:

**En Explorador de Windows:**
1. Ir a `C:\laragon\www`
2. Click derecho en `salinas_entrega.zip`
3. "Propiedades"
4. Ver el tamaño

**En PowerShell:**
```powershell
cd C:\laragon\www
$size = (Get-Item salinas_entrega.zip).Length / 1MB
Write-Host "Tamaño: $([math]::Round($size, 2)) MB"
```

**Tamaño Esperado:** 20-30 MB

---

## 📊 DECISIÓN SEGÚN TAMAÑO

- **< 5 MB:** ✅ Subir directo a Moodle
- **> 5 MB:** 📤 Subir a Google Drive y compartir enlace

---

## 🆘 SI NADA FUNCIONA

### Crear archivo ZIP manualmente en Laragon:

1. **Abrir Laragon**
2. Click en **"Menu"** → **"Quick app"** → **"Terminal"**
3. Ejecutar:
   ```bash
   cd /c/laragon/www
   zip -r salinas_entrega.zip salinas -x "*/vendor/*" "*/node_modules/*" "*/.git/*"
   ```

**Nota:** Laragon incluye herramientas Unix como `zip`

---

## 🎓 DIFERENCIA ENTRE CMD Y POWERSHELL

| Característica | CMD | PowerShell |
|----------------|-----|------------|
| **Color de ventana** | Negra | Azul |
| **Comandos** | Antiguos (DOS) | Modernos (.NET) |
| **Compress-Archive** | ❌ No funciona | ✅ Funciona |
| **Extensión** | .bat / .cmd | .ps1 |
| **Abrir** | `cmd` | `powershell` |

---

## 📝 RESUMEN RÁPIDO

**SI ESTÁS EN CMD (ventana negra):**
```cmd
powershell -Command "Compress-Archive -Path salinas -DestinationPath salinas_entrega.zip -Force"
```

**O MEJOR AÚN:**
1. Ir a `C:\laragon\www` en Explorador
2. Click derecho en `salinas`
3. "Enviar a" → "Carpeta comprimida"
4. Renombrar a `salinas_entrega.zip`

---

## ✅ PRÓXIMOS PASOS DESPUÉS DE COMPRIMIR

1. **Verificar tamaño** del archivo ZIP
2. **Si < 5 MB:** Subir a Moodle directamente
3. **Si > 5 MB:** 
   - Subir a Google Drive
   - Compartir con "Cualquiera con el enlace"
   - Copiar enlace
   - Subir archivo de texto con el enlace a Moodle

---

**¡PROBLEMA RESUELTO!** ✅

Si tienes más problemas, consulta: `GUIA_PASO_A_PASO.md` sección TROUBLESHOOTING
