<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('ruta', 255);
            $table->enum('tipo', ['imagen','video','documento','audio']);
            $table->integer('tamano')->nullable();
            
            // Relación con contenido (opcional)
            $table->foreignId('id_contenido')->nullable()->constrained('contenido')->onDelete('cascade');

            // Relación con materia (para imágenes de materia)
            $table->foreignId('id_materia')->nullable()->constrained('materias')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('multimedia');
    }
};
