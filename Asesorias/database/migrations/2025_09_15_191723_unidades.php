<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->foreignId('id_materia')->constrained('materias')->onDelete('cascade');
            $table->integer('numero_unidad');
            $table->integer('orden')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('unidades');
    }
};
