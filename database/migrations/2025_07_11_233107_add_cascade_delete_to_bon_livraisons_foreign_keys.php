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
        Schema::table('bon_livraisons', function (Blueprint $table) {
            // Supprimer les anciennes contraintes de clé étrangère
            $table->dropForeign(['devi_id']);
            $table->dropForeign(['client_id']);
            
            // Recréer les contraintes avec onDelete('cascade')
            $table->foreign('devi_id')->references('id')->on('devis')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_livraisons', function (Blueprint $table) {
            // Supprimer les nouvelles contraintes
            $table->dropForeign(['devi_id']);
            $table->dropForeign(['client_id']);
            
            // Recréer les anciennes contraintes sans cascade
            $table->foreign('devi_id')->references('id')->on('devis');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }
};
