<?php

use Illuminate\Database\Schema\Blueprint;

return function ($capsule) {
    $capsule->schema()->create('salles', function (Blueprint $table) {
        $table->id();
        $table->string('nom', 100);
        $table->string('batiment', 100);
        $table->integer('capacite');
        $table->string('type', 30);
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
};