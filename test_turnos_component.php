<?php
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    // Crear una instancia de la clase Turnos
    $component = new \App\Http\Livewire\Turnos();
    echo "Turnos component created successfully\n";
    
    // Intentar renderizar
    $rendered = $component->render();
    echo "Component rendered: " . class_basename($rendered) . "\n";
    echo "View name: " . $rendered->getName() . "\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Class: " . class_basename($e) . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>