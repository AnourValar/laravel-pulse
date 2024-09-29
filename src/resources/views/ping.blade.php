@use('Illuminate\Support\Str')
<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Ping [Response time]"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
           <svg version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 32 32" xml:space="preserve"> <style type="text/css"> .blueprint_een{fill:#111918;} .st0{fill:#0B1719;} </style> <path class="blueprint_een" d="M23.092,6.261c-0.471-0.583-0.986-1.154-1.539-1.707C16.837-0.163,9.186-0.188,4.499,4.499 s-4.662,12.337,0.055,17.054c5.618,5.618,11.751,5.379,15.644,3.35l4.781,5.736c0.377,0.452,1.061,0.483,1.478,0.067l4.25-4.25 c0.417-0.417,0.385-1.101-0.067-1.478l-5.665-4.721c0.833-1.436,1.316-2.97,1.442-4.583c1.12-0.31,2.083-0.991,2.769-1.987 c1.084-1.574,1.157-3.707,0.178-5.349C28.017,6.08,25.308,5.325,23.092,6.261z M27.165,12.999c-1.172,1.172-3.078,1.172-4.25,0 c-1.172-1.172-1.172-3.078,0-4.25c1.172-1.172,3.078-1.172,4.25,0C28.337,9.921,28.337,11.827,27.165,12.999z M5.96,20.124 C2.037,16.188,2.018,9.814,5.917,5.915l0.012-0.012C9.841,2.004,16.22,2.039,20.149,5.981c0.737,0.739,1.35,1.496,1.896,2.258 c-1.385,1.574-1.341,3.965,0.162,5.468c0.625,0.625,1.406,0.989,2.218,1.115c0.004,2.409-0.96,4.711-2.939,6.69 C17.96,25.026,11.495,25.677,5.96,20.124z M25.816,28.515l-4.563-5.476c0.328-0.255,0.646-0.524,0.94-0.818 c0.005-0.005,0.011-0.011,0.016-0.016c0.304-0.304,0.584-0.618,0.847-0.939l5.459,4.549L25.816,28.515z"/> </svg>
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#e11d48]" style="background-color: #31e11d;"></div>
                    Success (200 status code)
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#e11d48]"></div>
                    Failure (etc status code)
                </div>
            </div>
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($pings->isEmpty())
            <x-pulse::no-results />
        @else
            <div class="grid gap-3 mx-px mb-px">
                @foreach ($pings as $url => $readings)
                    <div wire:key="{{ $url }}">
                        <h3 class="font-bold text-gray-700 dark:text-gray-300">
                            {{ $url }}
                        </h3>
                        @php
                            $highest = $readings->flatten()->max();
                        @endphp

                        <div class="mt-3 relative">
                            <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-purple-500 rounded after:[--triangle-size:4px] after:border-l-black-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent" style="background-color: #222222;">
                                {{ number_format($highest) }} ms
                            </div>

                            <div
                                wire:ignore
                                class="h-20"
                                x-data="pingChart({
                                    url: '{{ $url }}',
                                    readings: @js($readings),
                                })"
                            >
                                <canvas x-ref="canvas" class="ring-1 ring-gray-900/5 dark:ring-gray-100/10 bg-gray-50 dark:bg-gray-800 rounded-md shadow-sm"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-pulse::scroll>

    <style>
    .after\:border-l-black-500:after{content:var(--tw-content);--tw-border-opacity: 1;border-left-color:rgb(34 34 34 / var(--tw-border-opacity))}
    </style>
</x-pulse::card>

@script
<script>
Alpine.data('pingChart', (config) => ({
    init() {
        let chart = new Chart(
            this.$refs.canvas,
            {
                type: 'line',
                data: {
                    labels: this.labels(config.readings),
                    datasets: [
                        {
                            label: 'Success',
                            borderColor: '#31e11d',
                            data: this.scale(config.readings.anourvalar_ping_success),
                            order: 0,
                        },
                        {
                            label: 'Failure',
                            borderColor: '#e11d48',
                            data: this.scale(config.readings.anourvalar_ping_failure),
                            order: 1,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        autoPadding: false,
                        padding: {
                            top: 1,
                        },
                    },
                    datasets: {
                        line: {
                            borderWidth: 2,
                            borderCapStyle: 'round',
                            pointHitRadius: 10,
                            pointStyle: false,
                            tension: 0.2,
                            spanGaps: false,
                            segment: {
                                borderColor: (ctx) => ctx.p0.raw === 0 && ctx.p1.raw === 0 ? 'transparent' : undefined,
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false,
                        },
                        y: {
                            display: false,
                            min: 0,
                            max: this.highest(config.readings),
                        },
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            mode: 'index',
                            position: 'nearest',
                            intersect: false,
                            callbacks: {
                                beforeBody: (context) => context
                                    .map(item => `${item.dataset.label}: ${item.formattedValue} ms`)
                                    .join(', '),
                                label: () => null,
                            },
                        },
                    },
                },
            }
        )

        Livewire.on('ping-chart-update', ({ pings }) => {
            if (chart === undefined) {
                return
            }

            if (pings[config.url] === undefined && chart) {
                chart.destroy()
                chart = undefined
                return
            }

            chart.data.labels = this.labels(pings[config.url])
            chart.options.scales.y.max = this.highest(pings[config.url])
            chart.data.datasets[0].data = this.scale(pings[config.url].anourvalar_ping_success)
            chart.data.datasets[1].data = this.scale(pings[config.url].anourvalar_ping_failure)
            chart.update()
        })
    },
    labels(readings) {
        return Object.keys(readings.anourvalar_ping_success)
    },
    scale(data) {
        return Object.values(data).map(value => value * (1 / 1 ))
    },
    highest(readings) {
        return Math.max(...Object.values(readings).map(dataset => Math.max(...Object.values(dataset)))) * (1 / 1)
    }
}))
</script>
@endscript
