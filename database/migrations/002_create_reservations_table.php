<?php

use Illuminate\Database\Schema\Blueprint;

return function ($capsule) {
    $capsule->schema()->create('reservations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('salle_id');
        $table->string('responsable', 120);
        $table->string('email', 255);
        $table->string('motif', 255);
        $table->dateTime('date_debut');
        $table->dateTime('date_fin');
        $table->string('statut', 20)->default('confirmée');
        $table->timestamps();

        $table->foreign('salle_id')
            ->references('id')
            ->on('salles')
            ->restrictOnDelete()
            ->cascadeOnUpdate();
    });
};
