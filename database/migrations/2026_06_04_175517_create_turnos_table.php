<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id(); // Genera la clave primaria autoincrementable
            
            // CARDINALIDAD: Relación 1 a Muchos con la tabla de usuarios (Clientes)
            // Crea la clave foránea 'user_id' que conecta el turno con el cliente logueado
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Columnas para los datos que captura tu formulario de Livewire Volt
            $table->string('servicio');    // Guarda 'Corte', 'Balayage', etc.
            $table->string('profesional'); // Guarda 'Ana', 'Clara', etc.
            $table->date('fecha');         // Guarda el año-mes-día seleccionado
            $table->string('hora');        // Guarda el horario ('10:00', '11:00', etc.)
            
            // Columna administrativa esencial para el Panel de la Recepcionista
            $table->string('estado')->default('pendiente'); // Valores: pendiente, confirmado, cancelado
            
            $table->timestamps(); // Columnas de auditoría (created_at y updated_at)
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('turnos');
    }
};