<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Illuminate\Console\Command;

class FetchWeather extends Command
{
    protected $signature = 'weather:fetch {city=Bogota : City} {country=Colombia : Country}';

    protected $description = 'Fetches current weather for a city';

    public function __construct(private WeatherService $weatherService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $city = $this->argument('city');
        $country = $this->argument('country');

        $this->info("Fetching weather for {$city}, {$country}...");

        $weather = $this->weatherService->fetchWeather($city, $country);

        if ($weather) {
            $this->info('Weather saved successfully!');
            $this->table(
                ['City', 'Country', 'Temp', 'Max', 'Min', 'Description', 'Humidity', 'Wind'],
                [[
                    $weather->city,
                    $weather->country,
                    $weather->temperature.'°C',
                    $weather->temperature_max.'°C',
                    $weather->temperature_min.'°C',
                    $weather->weather_description,
                    $weather->humidity.'%',
                    $weather->wind_speed.' km/h',
                ]]
            );

            return Command::SUCCESS;
        }

        $this->error('Failed to fetch weather.');

        return Command::FAILURE;
    }
}
