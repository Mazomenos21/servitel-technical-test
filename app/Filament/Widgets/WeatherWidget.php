<?php

namespace App\Filament\Widgets;

use App\Models\Weather;
use App\Services\WeatherService;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;

class WeatherWidget extends Widget
{
    protected string $view = "filament.widgets.weather-widget";

    public array $cities = [];

    public function mount(): void
    {
        $this->loadWeather();
    }

    public function loadWeather(): void
    {
        $this->cities = Weather::orderByDesc("fetched_at")->get()->toArray();
    }

    #[On('refresh-weather')]
    public function refresh(): void
    {
        $weatherService = new WeatherService();
        
        foreach (['Bogotá', 'Medellín', 'Cúcuta'] as $city) {
            $weatherService->fetchWeather($city, 'Colombia');
        }

        $this->loadWeather();
    }

    public static function canView(): bool
    {
        return true;
    }
}
