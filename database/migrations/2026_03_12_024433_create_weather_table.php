<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("weather", function (Blueprint $table) {
            $table->id();
            $table->string("city");
            $table->string("country");
            $table->decimal("latitude", 10, 7);
            $table->decimal("longitude", 10, 7);
            $table->decimal("temperature", 5, 1);
            $table->decimal("temperature_max", 5, 1);
            $table->decimal("temperature_min", 5, 1);
            $table->integer("weather_code");
            $table->string("weather_description")->nullable();
            $table->integer("humidity");
            $table->decimal("wind_speed", 5, 1);
            $table->timestamp("fetched_at");
            $table->timestamps();

            $table->index("city");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("weather");
    }
};
