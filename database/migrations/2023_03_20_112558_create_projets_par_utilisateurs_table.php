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
        Schema::create('projets_par_utilisateurs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('projet_id')->unsigned();
            $table->foreign('projet_id')
                ->references('id')
                ->on('projets')
                ->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projets_par_taches', function (Blueprint $table) { 
            $table->dropColumn('projet_id');
            $table->dropColumn('user_id');
        });
    }
};
