<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        "city",
        "country",
        "latitude",
        "longitude",
        "temperature",
        "temperature_max",
        "temperature_min",
        "weather_code",
        "weather_description",
        "humidity",
        "wind_speed",
        "fetched_at",
    ];

    protected function casts(): array
    {
        return [
            "latitude" => "decimal:7",
            "longitude" => "decimal:7",
            "temperature" => "decimal:1",
            "temperature_max" => "decimal:1",
            "temperature_min" => "decimal:1",
            "humidity" => "integer",
            "wind_speed" => "decimal:1",
            "fetched_at" => "datetime",
        ];
    }
}
