@use('Illuminate\Support\Str')
<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="FPM Workers"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
          <svg width="800px" height="800px" id="anourvalar-fpm-svg" viewBox="0 0 1024 1024" fill="#000000" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M471.2 566.4c-9.6 0-17.6-8-17.6-17.6s8-17.6 17.6-17.6h81.6c9.6 0 17.6 8 17.6 17.6s-8 17.6-17.6 17.6H471.2zM186.4 361.6c-14.4 0-27.2-12.8-27.2-27.2 0-14.4 12.8-27.2 27.2-27.2h24.8c8.8 0 16-6.4 16-15.2 7.2-99.2 67.2-189.6 156.8-234.4 4-2.4 8.8-3.2 12-3.2 14.4 0 27.2 12.8 27.2 27.2v56c0 8.8 7.2 16 16 16s16-7.2 16-16V55.2c0-13.6 10.4-25.6 23.2-27.2 10.4-1.6 21.6-1.6 32-1.6 12 0 24.8 0.8 35.2 1.6 13.6 1.6 23.2 12.8 23.2 27.2v81.6c0 8.8 7.2 16 16 16s16-7.2 16-16v-55.2c0-14.4 12.8-27.2 27.2-27.2 3.2 0 8 0.8 12.8 3.2C732 104.8 790.4 192 797.6 292c0.8 8.8 7.2 15.2 16 15.2h24.8c14.4 0 27.2 12.8 27.2 27.2 0 14.4-12.8 27.2-27.2 27.2H186.4z m567.2-48c-2.4-6.4-3.2-12-4-18.4-4.8-69.6-41.6-134.4-98.4-176v17.6c0 35.2-28.8 64-64 64s-64-28.8-64-64V74.4H504V136c0 35.2-28.8 64-64 64s-64-28.8-64-64v-18.4c-59.2 41.6-96 107.2-101.6 177.6-0.8 6.4-1.6 12-4 18.4h483.2z" fill="" /><path d="M83.2 1022.4c-20.8 0-40-8.8-52.8-24-11.2-13.6-16-31.2-12-48 32-164 181.6-298.4 376-336.8-74.4-48-120-136-120-234.4v-5.6h476.8v5.6c0 97.6-45.6 186.4-120.8 234.4 194.4 39.2 344 173.6 376 336.8 3.2 16.8-0.8 34.4-12 48-12.8 15.2-32 24-52.8 24H83.2zM512 649.6c-109.6 0-215.2 32-297.6 91.2-79.2 56.8-132 134.4-148.8 218.4-0.8 4 0.8 7.2 2.4 8 4 4.8 8.8 7.2 15.2 7.2h859.2c6.4 0 12-2.4 15.2-6.4 0.8-0.8 3.2-4 1.6-8-16-84.8-68.8-162.4-148.8-219.2C727.2 681.6 621.6 649.6 512 649.6zM324.8 421.6c17.6 104 95.2 179.2 186.4 179.2S680 525.6 697.6 421.6H324.8z" fill="" /></svg>
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#9333ea]"></div>
                    Total
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#e11d48]" style="background-color: #31e11d;"></div>
                    Idle
                </div>
            </div>
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($fpm->isEmpty())
            <x-pulse::no-results />
        @else
            <div class="grid gap-3 mx-px mb-px">
                @foreach ($fpm as $node => $readings)
                    <div wire:key="max-{{ $node }}">
                        <h3 class="font-bold text-gray-700 dark:text-gray-300">
                            {{ $node }}
                        </h3>
                        @php
                            $highest0 = $readings['anourvalar_fpm_total']->max();
                            $highest1 = $readings['anourvalar_fpm_idle']->max();
                        @endphp

                        <div class="mt-3 relative">
                            <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-purple-500 rounded after:[--triangle-size:4px] after:border-l-purple-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent">
                                @if ($config['sample_rate'] < 1)
                                    <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($highest0) }}">~{{ number_format($highest0) }}</span>
                                @else
                                    {{ number_format($highest0) }}
                                @endif
                            </div>
                           <div class="mt-3 absolute -left-px -top-4 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-green-500 rounded after:[--triangle-size:4px] after:border-l-green-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent">
                                @if ($config['sample_rate'] < 1)
                                    <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($highest1) }}">~{{ number_format($highest1) }}</span>
                                @else
                                    {{ number_format($highest1) }}
                                @endif
                            </div>

                            <div
                                wire:ignore
                                class="h-20"
                                x-data="requestChart({
                                    node: '{{ $node }}',
                                    readings: @js($readings),
                                    sampleRate: {{ $config['sample_rate'] }},
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
    html.dark #anourvalar-fpm-svg {fill: #9ca3af !important;}
    html:not(.dark) #anourvalar-fpm-svg {fill: #4b5563 !important;}
    </style>
</x-pulse::card>

@script
<script>
Alpine.data('requestChart', (config) => ({
    init() {
        let chart = new Chart(
            this.$refs.canvas,
            {
                type: 'line',
                data: {
                    labels: this.labels(config.readings),
                    datasets: [
                        {
                            label: 'Total',
                            borderColor: '#9333ea',
                            data: this.scale(config.readings.anourvalar_fpm_total),
                            order: 0,
                        },
                        {
                          label: 'Idle',
                          borderColor: '#31e11d',
                          data: this.scale(config.readings.anourvalar_fpm_idle),
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
                                    .map(item => `${item.dataset.label}: ${config.sampleRate < 1 ? '~' : ''}${item.formattedValue}`)
                                    .join(', '),
                                label: () => null,
                            },
                        },
                    },
                },
            }
        )

        Livewire.on('fpm-chart-update', ({ fpm }) => {
            if (chart === undefined) {
                return
            }

            if (fpm[config.node] === undefined && chart) {
                chart.destroy()
                chart = undefined
                return
            }

            chart.data.labels = this.labels(fpm[config.node])
            chart.options.scales.y.max = this.highest(fpm[config.node])
            chart.data.datasets[0].data = this.scale(fpm[config.node].anourvalar_fpm_total)
            chart.data.datasets[1].data = this.scale(fpm[config.node].anourvalar_fpm_idle)
            chart.update()
        })
    },
    labels(readings) {
        return Object.keys(readings.anourvalar_fpm_total)
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
