<?php

namespace App\Services;

use App\Models\Weather;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    private const API_BASE_URL = "https://api.open-meteo.com/v1/forecast";

    private const WEATHER_CODES = [
        0 => "Cielo despejado",
        1 => "Mayormente despejado",
        2 => "Parcialmente nublado",
        3 => "Nublado",
        45 => "Niebla",
        48 => "Niebla",
        51 => "Llovizna ligera",
        53 => "Llovizna",
        55 => "Llovizna intensa",
        61 => "Lluvia ligera",
        63 => "Lluvia",
        65 => "Lluvia intensa",
        71 => "Nieve ligera",
        73 => "Nieve",
        75 => "Nieve intensa",
        80 => "Chubascos ligeros",
        81 => "Chubascos",
        82 => "Chubascos intensos",
        95 => "Tormenta",
        96 => "Tormenta con granizo",
        99 => "Tormenta intensa",
    ];

    public function fetchWeather(string $city = "Bogota", string $country = "Colombia"): ?Weather
    {
        $coordinates = $this->getCoordinates($city, $country);

        if (!$coordinates) {
            return null;
        }

        $cacheKey = "weather_" . strtolower($city);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($coordinates, $city, $country) {
            $response = Http::get(self::API_BASE_URL, [
                "latitude" => $coordinates["latitude"],
                "longitude" => $coordinates["longitude"],
                "current" => "temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m",
                "daily" => "temperature_2m_max,temperature_2m_min",
                "timezone" => "auto",
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();

            $weatherCode = $data["current"]["weather_code"] ?? 0;

            return Weather::updateOrCreate(
                ["city" => $city],
                [
                    "country" => $country,
                    "latitude" => $coordinates["latitude"],
                    "longitude" => $coordinates["longitude"],
                    "temperature" => $data["current"]["temperature_2m"] ?? 0,
                    "temperature_max" => $data["daily"]["temperature_2m_max"][0] ?? 0,
                    "temperature_min" => $data["daily"]["temperature_2m_min"][0] ?? 0,
                    "weather_code" => $weatherCode,
                    "weather_description" => self::WEATHER_CODES[$weatherCode] ?? "Desconocido",
                    "humidity" => $data["current"]["relative_humidity_2m"] ?? 0,
                    "wind_speed" => $data["current"]["wind_speed_10m"] ?? 0,
                    "fetched_at" => now(),
                ]
            );
        });
    }

    private function getCoordinates(string $city, string $country): ?array
    {
        $cacheKey = "coordinates_" . strtolower($city) . "_" . strtolower($country);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($city, $country) {
            $response = Http::get("https://geocoding-api.open-meteo.com/v1/search", [
                "name" => $city,
                "count" => 1,
                "language" => "es",
                "format" => "json",
            ]);

            if (!$response->successful() || empty($response->json()["results"])) {
                return [
                    "latitude" => 4.7110,
                    "longitude" => -74.0721,
                ];
            }

            $result = $response->json()["results"][0];
            return [
                "latitude" => $result["latitude"],
                "longitude" => $result["longitude"],
            ];
        });
    }

    public function getLatestWeather(): ?Weather
    {
        return Weather::orderBy("fetched_at", "desc")->first();
    }

    public function getAllWeather(): array
    {
        return Weather::orderByDesc("fetched_at")->get()->toArray();
    }

    public static function getWeatherIcon(int $code): string
    {
        return match($code) {
            0 => "☀️",
            1 => "🌤️",
            2 => "⛅",
            3 => "☁️",
            45, 48 => "🌫️",
            51, 53, 55, 61, 63, 65, 80, 81, 82 => "🌧️",
            71, 73, 75 => "❄️",
            95, 96, 99 => "⛈️",
            default => "🌡️",
        };
    }
}
