<div class="fi-widget p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Clima de Colombia</h3>
            <button
                wire:click="$dispatch('refresh-weather')"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
            >
                🔄 Actualizar Clima
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($cities as $city)
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl p-5 text-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 hover:from-blue-600 hover:to-blue-800 cursor-pointer border-2 border-transparent hover:border-amber-400">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">{{ $city["city"] }}, {{ $city["country"] }}</p>
                            <p class="text-4xl font-bold mt-1">{{ $city["temperature"] }}°C</p>
                            <p class="text-blue-100 text-xs mt-1">{{ $city["weather_description"] }}</p>
                        </div>
                        <div class="text-5xl transition-transform duration-300 group-hover:scale-110">
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
                    <div class="flex gap-3 mt-4 pt-3 border-t border-blue-400/50">
                        <span class="text-green-300 text-xs">↑ {{ $city["temperature_max"] }}°</span>
                        <span class="text-blue-200 text-xs">↓ {{ $city["temperature_min"] }}°</span>
                    </div>
                    <div class="flex gap-3 mt-2 text-xs text-blue-100">
                        <span>💧 {{ $city["humidity"] }}%</span>
                        <span>💨 {{ $city["wind_speed"] }} km/h</span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-gray-100 dark:bg-gray-800 rounded-xl p-6 text-center">
                    <p class="text-gray-500">No hay datos del clima</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
