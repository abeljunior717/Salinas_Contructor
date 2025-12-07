<?php
/**
 * Script para exportar la base de datos SQLite a formato SQL
 * Ejecutar: php export_database.php
 */

$dbPath = __DIR__ . '/database/database.sqlite';
$outputFile = __DIR__ . '/salinas_database.sql';

if (!file_exists($dbPath)) {
    die("Error: No se encuentra la base de datos en: $dbPath\n");
}

try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $output = "-- =====================================================\n";
    $output .= "-- BASE DE DATOS: Salinas Constructor\n";
    $output .= "-- Fecha de exportación: " . date('Y-m-d H:i:s') . "\n";
    $output .= "-- Sistema: SQLite\n";
    $output .= "-- =====================================================\n\n";
    
    // Obtener todas las tablas
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        $output .= "\n-- =====================================================\n";
        $output .= "-- Tabla: $table\n";
        $output .= "-- =====================================================\n\n";
        
        // Obtener estructura de la tabla
        $createTable = $db->query("SELECT sql FROM sqlite_master WHERE type='table' AND name='$table'")->fetchColumn();
        $output .= $createTable . ";\n\n";
        
        // Obtener datos de la tabla
        $rows = $db->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) {
            $output .= "-- Datos de la tabla $table\n";
            foreach ($rows as $row) {
                $columns = implode(', ', array_keys($row));
                $values = array_map(function($val) use ($db) {
                    if ($val === null) return 'NULL';
                    return $db->quote($val);
                }, array_values($row));
                $valuesStr = implode(', ', $values);
                $output .= "INSERT INTO $table ($columns) VALUES ($valuesStr);\n";
            }
            $output .= "\n";
        }
    }
    
    file_put_contents($outputFile, $output);
    echo "✓ Base de datos exportada exitosamente a: salinas_database.sql\n";
    echo "✓ Tamaño del archivo: " . round(filesize($outputFile) / 1024, 2) . " KB\n";
    
} catch (Exception $e) {
    die("Error al exportar: " . $e->getMessage() . "\n");
}
