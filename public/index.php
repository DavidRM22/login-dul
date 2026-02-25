<?php

/* =========================================
   CONFIGURACIÓN INICIAL
========================================= */

// Iniciar sesión SIEMPRE
session_start();

// Mostrar errores (solo desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar configuración global
require_once __DIR__ . '/../config.php';


/* =========================================
   OBTENER CONTROLLER Y ACTION
========================================= */

$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action']     ?? 'login';

// Sanitización básica
$controller = preg_replace('/[^a-zA-Z0-9_-]/', '', $controller);
$action     = preg_replace('/[^a-zA-Z0-9_-]/', '', $action);

// Construir nombre del controlador
$controllerName = ucfirst(strtolower($controller)) . 'Controller';

// Ruta del archivo controlador
$controllerFile = CONTROLLER_PATH . '/' . $controllerName . '.php';


/* =========================================
   VALIDAR CONTROLADOR
========================================= */

if (!file_exists($controllerFile)) {
    http_response_code(404);
    echo "<h2>Error 404</h2>";
    echo "Controlador no encontrado: <b>$controllerName</b>";
    exit;
}

// Cargar archivo
require_once $controllerFile;

// Verificar clase
if (!class_exists($controllerName)) {
    http_response_code(500);
    echo "<h2>Error 500</h2>";
    echo "La clase <b>$controllerName</b> no está definida.";
    exit;
}

// Crear instancia
$controllerObject = new $controllerName();


/* =========================================
   VALIDAR ACCIÓN
========================================= */

if (!method_exists($controllerObject, $action)) {
    http_response_code(404);
    echo "<h2>Error 404</h2>";
    echo "Acción no encontrada: <b>$action</b>";
    exit;
}


/* =========================================
   EJECUTAR ACCIÓN
========================================= */

try {
    $controllerObject->$action();
} catch (Throwable $e) {
    http_response_code(500);
    echo "<h2>Error 500</h2>";
    echo "Ocurrió un error interno.<br><br>";
    echo "<strong>Mensaje:</strong> " . $e->getMessage();
}