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
        Schema::table('users', function (Blueprint $table) {
            
            $table->unsignedBigInteger('client_id')->nullable(); 
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->boolean('is_primary')->default(0)->comment('0->not primary, 1->primary');
            $table->string('display_name')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
