<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change the column to string so we can update the values without enum restrictions
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
        });

        // Migrate existing values
        DB::table('orders')->where('status', 'ordered')->update(['status' => 'pendiente']);
        DB::table('orders')->where('status', 'in_process')->update(['status' => 'en-proceso']);
        DB::table('orders')->where('status', 'in_route')->update(['status' => 'en-transito']);
        DB::table('orders')->where('status', 'delivered')->update(['status' => 'entregado']);

        // Change back to enum with new values
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['pendiente', 'en-proceso', 'en-transito', 'entregado'])->default('pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
        });

        DB::table('orders')->where('status', 'pendiente')->update(['status' => 'ordered']);
        DB::table('orders')->where('status', 'en-proceso')->update(['status' => 'in_process']);
        DB::table('orders')->where('status', 'en-transito')->update(['status' => 'in_route']);
        DB::table('orders')->where('status', 'entregado')->update(['status' => 'delivered']);

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['ordered', 'in_process', 'in_route', 'delivered'])->default('ordered')->change();
        });
    }
};
