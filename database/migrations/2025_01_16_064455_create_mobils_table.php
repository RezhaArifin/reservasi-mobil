<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nopolisi')->nullable();
            $table->string('merk')->nullable();
            $table->enum('jenis', ['sedan','MPV','SUV'])->nullable();
            $table->string('harga')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->enum('status_mobil',['ready','booking','maintenance'])->default('ready');
            $table->text('foto')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
