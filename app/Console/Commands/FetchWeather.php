<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Illuminate\Console\Command;

class FetchWeather extends Command
{
    protected $signature = "weather:fetch {city=Bogota : Ciudad} {country=Colombia : País}";
    protected $description = "Obtiene el clima actual de una ciudad";

    public function __construct(private WeatherService $weatherService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $city = $this->argument("city");
        $country = $this->argument("country");

        $this->info("Obteniendo clima para {$city}, {$country}...");

        $weather = $this->weatherService->fetchWeather($city, $country);

        if ($weather) {
            $this->info("✓ Clima guardado exitosamente!");
            $this->table(
                ["Ciudad", "País", "Temp", "Máx", "Mín", "Descripción", "Humedad", "Viento"],
                [[
                    $weather->city,
                    $weather->country,
                    $weather->temperature . "°C",
                    $weather->temperature_max . "°C",
                    $weather->temperature_min . "°C",
                    $weather->weather_description,
                    $weather->humidity . "%",
                    $weather->wind_speed . " km/h",
                ]]
            );
            return Command::SUCCESS;
        }

        $this->error("No se pudo obtener el clima.");
        return Command::FAILURE;
    }
}
