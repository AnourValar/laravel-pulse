@use('Illuminate\Support\Str')
<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Database [Queries]"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
          <svg fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 55 55" xml:space="preserve"> <path d="M52.354,8.51C51.196,4.22,42.577,0,27.5,0C12.423,0,3.803,4.22,2.646,8.51C2.562,8.657,2.5,8.818,2.5,9v0.5V21v0.5V22v11 v0.5V34v12c0,0.162,0.043,0.315,0.117,0.451C3.798,51.346,14.364,55,27.5,55c13.106,0,23.655-3.639,24.875-8.516 C52.455,46.341,52.5,46.176,52.5,46V34v-0.5V33V22v-0.5V21V9.5V9C52.5,8.818,52.438,8.657,52.354,8.51z M50.421,33.985 c-0.028,0.121-0.067,0.241-0.116,0.363c-0.04,0.099-0.089,0.198-0.143,0.297c-0.067,0.123-0.142,0.246-0.231,0.369 c-0.066,0.093-0.141,0.185-0.219,0.277c-0.111,0.131-0.229,0.262-0.363,0.392c-0.081,0.079-0.17,0.157-0.26,0.236 c-0.164,0.143-0.335,0.285-0.526,0.426c-0.082,0.061-0.17,0.12-0.257,0.18c-0.226,0.156-0.462,0.311-0.721,0.463 c-0.068,0.041-0.141,0.08-0.212,0.12c-0.298,0.168-0.609,0.335-0.945,0.497c-0.043,0.021-0.088,0.041-0.132,0.061 c-0.375,0.177-0.767,0.351-1.186,0.519c-0.012,0.005-0.024,0.009-0.036,0.014c-2.271,0.907-5.176,1.67-8.561,2.17 c-0.017,0.002-0.034,0.004-0.051,0.007c-0.658,0.097-1.333,0.183-2.026,0.259c-0.113,0.012-0.232,0.02-0.346,0.032 c-0.605,0.063-1.217,0.121-1.847,0.167c-0.288,0.021-0.59,0.031-0.883,0.049c-0.474,0.028-0.943,0.059-1.429,0.076 C29.137,40.984,28.327,41,27.5,41s-1.637-0.016-2.432-0.044c-0.486-0.017-0.955-0.049-1.429-0.076 c-0.293-0.017-0.595-0.028-0.883-0.049c-0.63-0.046-1.242-0.104-1.847-0.167c-0.114-0.012-0.233-0.02-0.346-0.032 c-0.693-0.076-1.368-0.163-2.026-0.259c-0.017-0.002-0.034-0.004-0.051-0.007c-3.385-0.5-6.29-1.263-8.561-2.17 c-0.012-0.004-0.024-0.009-0.036-0.014c-0.419-0.168-0.812-0.342-1.186-0.519c-0.043-0.021-0.089-0.041-0.132-0.061 c-0.336-0.162-0.647-0.328-0.945-0.497c-0.07-0.04-0.144-0.079-0.212-0.12c-0.259-0.152-0.495-0.307-0.721-0.463 c-0.086-0.06-0.175-0.119-0.257-0.18c-0.191-0.141-0.362-0.283-0.526-0.426c-0.089-0.078-0.179-0.156-0.26-0.236 c-0.134-0.13-0.252-0.26-0.363-0.392c-0.078-0.092-0.153-0.184-0.219-0.277c-0.088-0.123-0.163-0.246-0.231-0.369 c-0.054-0.099-0.102-0.198-0.143-0.297c-0.049-0.121-0.088-0.242-0.116-0.363C4.541,33.823,4.5,33.661,4.5,33.5 c0-0.113,0.013-0.226,0.031-0.338c0.025-0.151,0.011-0.302-0.031-0.445v-7.424c0.028,0.026,0.063,0.051,0.092,0.077 c0.218,0.192,0.44,0.383,0.69,0.567C9.049,28.786,16.582,31,27.5,31c10.872,0,18.386-2.196,22.169-5.028 c0.302-0.22,0.574-0.447,0.83-0.678l0.001-0.001v7.424c-0.042,0.143-0.056,0.294-0.031,0.445c0.019,0.112,0.031,0.225,0.031,0.338 C50.5,33.661,50.459,33.823,50.421,33.985z M50.5,13.293v7.424c-0.042,0.143-0.056,0.294-0.031,0.445 c0.019,0.112,0.031,0.225,0.031,0.338c0,0.161-0.041,0.323-0.079,0.485c-0.028,0.121-0.067,0.241-0.116,0.363 c-0.04,0.099-0.089,0.198-0.143,0.297c-0.067,0.123-0.142,0.246-0.231,0.369c-0.066,0.093-0.141,0.185-0.219,0.277 c-0.111,0.131-0.229,0.262-0.363,0.392c-0.081,0.079-0.17,0.157-0.26,0.236c-0.164,0.143-0.335,0.285-0.526,0.426 c-0.082,0.061-0.17,0.12-0.257,0.18c-0.226,0.156-0.462,0.311-0.721,0.463c-0.068,0.041-0.141,0.08-0.212,0.12 c-0.298,0.168-0.609,0.335-0.945,0.497c-0.043,0.021-0.088,0.041-0.132,0.061c-0.375,0.177-0.767,0.351-1.186,0.519 c-0.012,0.005-0.024,0.009-0.036,0.014c-2.271,0.907-5.176,1.67-8.561,2.17c-0.017,0.002-0.034,0.004-0.051,0.007 c-0.658,0.097-1.333,0.183-2.026,0.259c-0.113,0.012-0.232,0.02-0.346,0.032c-0.605,0.063-1.217,0.121-1.847,0.167 c-0.288,0.021-0.59,0.031-0.883,0.049c-0.474,0.028-0.943,0.059-1.429,0.076C29.137,28.984,28.327,29,27.5,29 s-1.637-0.016-2.432-0.044c-0.486-0.017-0.955-0.049-1.429-0.076c-0.293-0.017-0.595-0.028-0.883-0.049 c-0.63-0.046-1.242-0.104-1.847-0.167c-0.114-0.012-0.233-0.02-0.346-0.032c-0.693-0.076-1.368-0.163-2.026-0.259 c-0.017-0.002-0.034-0.004-0.051-0.007c-3.385-0.5-6.29-1.263-8.561-2.17c-0.012-0.004-0.024-0.009-0.036-0.014 c-0.419-0.168-0.812-0.342-1.186-0.519c-0.043-0.021-0.089-0.041-0.132-0.061c-0.336-0.162-0.647-0.328-0.945-0.497 c-0.07-0.04-0.144-0.079-0.212-0.12c-0.259-0.152-0.495-0.307-0.721-0.463c-0.086-0.06-0.175-0.119-0.257-0.18 c-0.191-0.141-0.362-0.283-0.526-0.426c-0.089-0.078-0.179-0.156-0.26-0.236c-0.134-0.13-0.252-0.26-0.363-0.392 c-0.078-0.092-0.153-0.184-0.219-0.277c-0.088-0.123-0.163-0.246-0.231-0.369c-0.054-0.099-0.102-0.198-0.143-0.297 c-0.049-0.121-0.088-0.242-0.116-0.363C4.541,21.823,4.5,21.661,4.5,21.5c0-0.113,0.013-0.226,0.031-0.338 c0.025-0.151,0.011-0.302-0.031-0.445v-7.424c0.12,0.109,0.257,0.216,0.387,0.324c0.072,0.06,0.139,0.12,0.215,0.18 c0.3,0.236,0.624,0.469,0.975,0.696c0.073,0.047,0.155,0.093,0.231,0.14c0.294,0.183,0.605,0.362,0.932,0.538 c0.121,0.065,0.242,0.129,0.367,0.193c0.365,0.186,0.748,0.367,1.151,0.542c0.066,0.029,0.126,0.059,0.193,0.087 c0.469,0.199,0.967,0.389,1.485,0.573c0.143,0.051,0.293,0.099,0.44,0.149c0.412,0.139,0.838,0.272,1.279,0.401 c0.159,0.046,0.315,0.094,0.478,0.138c0.585,0.162,1.189,0.316,1.823,0.458c0.087,0.02,0.181,0.036,0.269,0.055 c0.559,0.122,1.139,0.235,1.735,0.341c0.202,0.036,0.407,0.07,0.613,0.104c0.567,0.093,1.151,0.178,1.75,0.256 c0.154,0.02,0.301,0.043,0.457,0.062c0.744,0.09,1.514,0.167,2.305,0.233c0.195,0.016,0.398,0.028,0.596,0.042 c0.633,0.046,1.28,0.084,1.942,0.114c0.241,0.011,0.481,0.022,0.727,0.031C25.712,18.979,26.59,19,27.5,19s1.788-0.021,2.65-0.05 c0.245-0.009,0.485-0.02,0.727-0.031c0.662-0.03,1.309-0.068,1.942-0.114c0.198-0.015,0.4-0.026,0.596-0.042 c0.791-0.065,1.561-0.143,2.305-0.233c0.156-0.019,0.303-0.042,0.457-0.062c0.599-0.078,1.182-0.163,1.75-0.256 c0.206-0.034,0.411-0.068,0.613-0.104c0.596-0.106,1.176-0.219,1.735-0.341c0.088-0.019,0.182-0.036,0.269-0.055 c0.634-0.142,1.238-0.297,1.823-0.458c0.163-0.045,0.319-0.092,0.478-0.138c0.441-0.129,0.867-0.262,1.279-0.401 c0.147-0.05,0.297-0.098,0.44-0.149c0.518-0.184,1.017-0.374,1.485-0.573c0.067-0.028,0.127-0.058,0.193-0.087 c0.403-0.176,0.786-0.356,1.151-0.542c0.125-0.064,0.247-0.128,0.367-0.193c0.327-0.175,0.638-0.354,0.932-0.538 c0.076-0.047,0.158-0.093,0.231-0.14c0.351-0.227,0.675-0.459,0.975-0.696c0.075-0.06,0.142-0.12,0.215-0.18 C50.243,13.509,50.38,13.402,50.5,13.293z M27.5,2c13.555,0,23,3.952,23,7.5s-9.445,7.5-23,7.5s-23-3.952-23-7.5S13.945,2,27.5,2z M50.5,45.703c-0.014,0.044-0.024,0.089-0.032,0.135C49.901,49.297,40.536,53,27.5,53S5.099,49.297,4.532,45.838 c-0.008-0.045-0.019-0.089-0.032-0.131v-8.414c0.028,0.026,0.063,0.051,0.092,0.077c0.218,0.192,0.44,0.383,0.69,0.567 C9.049,40.786,16.582,43,27.5,43c10.872,0,18.386-2.196,22.169-5.028c0.302-0.22,0.574-0.447,0.83-0.678l0.001-0.001V45.703z"/> </svg>
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#e11d48]" style="background-color: #31e11d;"></div>
                    Read
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 font-medium">
                    <div class="h-0.5 w-3 rounded-full bg-[#e11d48]"></div>
                    Write
                </div>
            </div>
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($queries->isEmpty())
            <x-pulse::no-results />
        @else
            <div class="grid gap-3 mx-px mb-px">
                @foreach ($queries as $connection => $readings)
                    <div wire:key="{{ $connection }}">
                        <h3 class="font-bold text-gray-700 dark:text-gray-300">
                            {{ $connection }}
                        </h3>
                        @php
                            $highest = $readings->flatten()->max();
                        @endphp

                        <div class="mt-3 relative">
                            <div class="absolute -left-px -top-2 max-w-fit h-4 flex items-center px-1 text-xs leading-none text-white font-bold bg-purple-500 rounded after:[--triangle-size:4px] after:border-l-black-500 after:absolute after:right-[calc(-1*var(--triangle-size))] after:top-[calc(50%-var(--triangle-size))] after:border-t-[length:var(--triangle-size)] after:border-b-[length:var(--triangle-size)] after:border-l-[length:var(--triangle-size)] after:border-transparent" style="background-color: #222222;">
                                @if ($config['sample_rate'] < 1)
                                    <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($highest) }}">~{{ number_format($highest * (1 / $config['sample_rate'])) }}</span>
                                @else
                                    {{ number_format($highest) }}
                                @endif
                            </div>

                            <div
                                wire:ignore
                                class="h-20"
                                x-data="databaseChart({
                                    connection: '{{ $connection }}',
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
    .after\:border-l-black-500:after{content:var(--tw-content);--tw-border-opacity: 1;border-left-color:rgb(34 34 34 / var(--tw-border-opacity))}
    </style>
</x-pulse::card>

@script
<script>
Alpine.data('databaseChart', (config) => ({
    init() {
        let chart = new Chart(
            this.$refs.canvas,
            {
                type: 'line',
                data: {
                    labels: this.labels(config.readings),
                    datasets: [
                        {
                            label: 'Read',
                            borderColor: '#31e11d',
                            data: this.scale(config.readings.anourvalar_database_read),
                            order: 0,
                        },
                        {
                            label: 'Write',
                            borderColor: '#e11d48',
                            data: this.scale(config.readings.anourvalar_database_write),
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

        Livewire.on('database-chart-update', ({ queries }) => {
            if (chart === undefined) {
                return
            }

            if (queries[config.connection] === undefined && chart) {
                chart.destroy()
                chart = undefined
                return
            }

            chart.data.labels = this.labels(queries[config.connection])
            chart.options.scales.y.max = this.highest(queries[config.connection])
            chart.data.datasets[0].data = this.scale(queries[config.connection].anourvalar_database_read)
            chart.data.datasets[1].data = this.scale(queries[config.connection].anourvalar_database_write)
            chart.update()
        })
    },
    labels(readings) {
        return Object.keys(readings.anourvalar_database_read)
    },
    scale(data) {
        return Object.values(data).map(value => value * (1 / config.sampleRate ))
    },
    highest(readings) {
        return Math.max(...Object.values(readings).map(dataset => Math.max(...Object.values(dataset)))) * (1 / config.sampleRate)
    }
}))
</script>
@endscript
