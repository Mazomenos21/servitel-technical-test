<div class="fi-widget p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Colombia Weather</h3>

            <flux:button 
                wire:click="$dispatch('refresh-weather')" 
                wire:loading.attr="disabled"
                size="sm"
                icon="arrow-path"
            >
                Refresh
            </flux:button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($cities as $city)
                <div class="bg-gradient-to-br from-emerald-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 border border-gray-100 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ $city["city"] }}, {{ $city["country"] }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $city["temperature"] }}°C</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $city["weather_description"] }}</p>
                        </div>
                        <div class="text-4xl">
                            @switch($city["weather_code"])
                                @case(0) ☀️ @break
                                @case(1) 🌤️ @break
                                @case(2) ⛅ @break
                                @case(3) ☁️ @break
                                @case(45) @case(48) 🌫️ @break
                                @case(51) @case(53) @case(55) @case(61) @case(63) @case(65) @case(80) @case(81) @case(82) 🌧️ @break
                                @case(71) @case(73) @case(75) ❄️ @break
                                @case(95) @case(96) @case(99) ⛈️ @break
                                @default 🌡️
                            @endswitch
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200 dark:border-gray-500 text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex gap-3">
                            <span>↑ {{ $city["temperature_max"] }}°</span>
                            <span>↓ {{ $city["temperature_min"] }}°</span>
                        </div>
                        <div class="flex gap-3">
                            <span>💧 {{ $city["humidity"] }}%</span>
                            <span>💨 {{ $city["wind_speed"] }} km/h</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-gray-100 dark:bg-gray-700 rounded-lg p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No weather data available</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
