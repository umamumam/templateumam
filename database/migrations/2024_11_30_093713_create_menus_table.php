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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable(); 
            $table->unsignedBigInteger('module_id'); // Relasi ke modul
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name'); // Nama menu
            $table->string('link'); // Link untuk akses menu
            $table->integer('order'); // Nomor urut
            $table->timestamps();
    
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
