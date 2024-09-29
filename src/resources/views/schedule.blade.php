<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="Schedule"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <svg version="1.1" id="anourvalar-schedule-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 120.06" style="enable-background:new 0 0 122.88 120.06" xml:space="preserve"><g><path d="M69.66,4.05c0-2.23,2.2-4.05,4.94-4.05c2.74,0,4.94,1.81,4.94,4.05v17.72c0,2.23-2.2,4.05-4.94,4.05 c-2.74,0-4.94-1.81-4.94-4.05V4.05L69.66,4.05z M91.37,57.03c4.26,0,8.33,0.85,12.05,2.39c3.87,1.6,7.34,3.94,10.24,6.84 c2.9,2.9,5.24,6.38,6.84,10.23c1.54,3.72,2.39,7.79,2.39,12.05c0,4.26-0.85,8.33-2.39,12.05c-1.6,3.87-3.94,7.34-6.84,10.24 c-2.9,2.9-6.38,5.24-10.23,6.84c-3.72,1.54-7.79,2.39-12.05,2.39c-4.26,0-8.33-0.85-12.05-2.39c-3.87-1.6-7.34-3.94-10.24-6.84 c-2.9-2.9-5.24-6.38-6.84-10.24c-1.54-3.72-2.39-7.79-2.39-12.05c0-4.26,0.85-8.33,2.39-12.05c1.6-3.87,3.94-7.34,6.84-10.24 c2.9-2.9,6.38-5.24,10.23-6.84C83.04,57.88,87.1,57.03,91.37,57.03L91.37,57.03z M89.01,75.37c0-0.76,0.31-1.45,0.81-1.95l0,0l0,0 c0.5-0.5,1.19-0.81,1.96-0.81c0.77,0,1.46,0.31,1.96,0.81c0.5,0.5,0.81,1.19,0.81,1.96v14.74l11.02,6.54l0.09,0.06 c0.61,0.39,1.01,0.98,1.17,1.63c0.17,0.68,0.09,1.42-0.28,2.06l-0.02,0.03c-0.02,0.04-0.04,0.07-0.07,0.1 c-0.39,0.6-0.98,1-1.62,1.16c-0.68,0.17-1.42,0.09-2.06-0.28l-12.32-7.29c-0.43-0.23-0.79-0.58-1.05-0.99 c-0.26-0.42-0.41-0.91-0.41-1.43h0L89.01,75.37L89.01,75.37L89.01,75.37z M109.75,70.16c-2.4-2.4-5.26-4.33-8.43-5.64 c-3.06-1.27-6.42-1.96-9.95-1.96s-6.89,0.7-9.95,1.96c-3.17,1.31-6.03,3.24-8.43,5.64c-2.4,2.4-4.33,5.26-5.64,8.43 c-1.27,3.06-1.96,6.42-1.96,9.95c0,3.53,0.7,6.89,1.96,9.95c1.31,3.17,3.24,6.03,5.64,8.43c2.4,2.4,5.26,4.33,8.43,5.64 c3.06,1.27,6.42,1.96,9.95,1.96s6.89-0.7,9.95-1.96c3.17-1.31,6.03-3.24,8.43-5.64c4.71-4.71,7.61-11.2,7.61-18.38 c0-3.53-0.7-6.89-1.96-9.95C114.08,75.42,112.15,72.56,109.75,70.16L109.75,70.16z M13.45,57.36c-0.28,0-0.53-1.23-0.53-2.74 c0-1.51,0.22-2.73,0.53-2.73h13.48c0.28,0,0.53,1.23,0.53,2.73c0,1.51-0.22,2.74-0.53,2.74H13.45L13.45,57.36z M34.94,57.36 c-0.28,0-0.53-1.23-0.53-2.74c0-1.51,0.22-2.73,0.53-2.73h13.48c0.28,0,0.53,1.23,0.53,2.73c0,1.51-0.22,2.74-0.53,2.74H34.94 L34.94,57.36z M56.43,57.36c-0.28,0-0.53-1.23-0.53-2.74c0-1.51,0.22-2.73,0.53-2.73h13.48c0.28,0,0.53,1.22,0.53,2.72 c-1.35,0.84-2.65,1.76-3.89,2.75H56.43L56.43,57.36z M13.48,73.04c-0.28,0-0.53-1.23-0.53-2.74c0-1.51,0.22-2.74,0.53-2.74h13.48 c0.28,0,0.53,1.23,0.53,2.74c0,1.51-0.22,2.74-0.53,2.74H13.48L13.48,73.04z M34.97,73.04c-0.28,0-0.53-1.23-0.53-2.74 c0-1.51,0.22-2.74,0.53-2.74h13.48c0.28,0,0.53,1.23,0.53,2.74c0,1.51-0.22,2.74-0.53,2.74H34.97L34.97,73.04z M13.51,88.73 c-0.28,0-0.53-1.23-0.53-2.74c0-1.51,0.22-2.74,0.53-2.74h13.48c0.28,0,0.53,1.23,0.53,2.74c0,1.51-0.22,2.74-0.53,2.74H13.51 L13.51,88.73z M35,88.73c-0.28,0-0.53-1.23-0.53-2.74c0-1.51,0.22-2.74,0.53-2.74h13.48c0.28,0,0.53,1.23,0.53,2.74 c0,1.51-0.22,2.74-0.53,2.74H35L35,88.73z M25.29,4.05c0-2.23,2.2-4.05,4.94-4.05c2.74,0,4.94,1.81,4.94,4.05v17.72 c0,2.23-2.21,4.05-4.94,4.05c-2.74,0-4.94-1.81-4.94-4.05V4.05L25.29,4.05z M5.44,38.74h94.08v-20.4c0-0.7-0.28-1.31-0.73-1.76 c-0.45-0.45-1.09-0.73-1.76-0.73h-9.02c-1.51,0-2.74-1.23-2.74-2.74c0-1.51,1.23-2.74,2.74-2.74h9.02c2.21,0,4.19,0.89,5.64,2.34 c1.45,1.45,2.34,3.43,2.34,5.64v32.39c-1.8-0.62-3.65-1.12-5.55-1.49v-5.06h0.06H5.44v52.83c0,0.7,0.28,1.31,0.73,1.76 c0.45,0.45,1.09,0.73,1.76,0.73h44.71c0.51,1.9,1.15,3.75,1.92,5.53H7.98c-2.2,0-4.19-0.89-5.64-2.34C0.89,101.26,0,99.28,0,97.07 V18.36c0-2.2,0.89-4.19,2.34-5.64c1.45-1.45,3.43-2.34,5.64-2.34h9.63c1.51,0,2.74,1.23,2.74,2.74c0,1.51-1.23,2.74-2.74,2.74H7.98 c-0.7,0-1.31,0.28-1.76,0.73c-0.45,0.45-0.73,1.09-0.73,1.76v20.4H5.44L5.44,38.74z M43.07,15.85c-1.51,0-2.74-1.23-2.74-2.74 c0-1.51,1.23-2.74,2.74-2.74h18.36c1.51,0,2.74,1.23,2.74,2.74c0,1.51-1.23,2.74-2.74,2.74H43.07L43.07,15.85z"/></g></svg>
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        <div class="min-h-full flex flex-col">
            @if ($runs->isEmpty())
                <x-pulse::no-results />
            @else
                <x-pulse::table>
                    <colgroup>
                        <col width="100%" />
                        <col width="0%" />
                        <col width="0%" />
                    </colgroup>
                    <x-pulse::thead>
                        <tr>
                            <x-pulse::th>Command</x-pulse::th>
                            <x-pulse::th class="text-right">Latest</x-pulse::th>
                            <x-pulse::th class="text-right">Count</x-pulse::th>
                        </tr>
                    </x-pulse::thead>
                    <tbody>
                        @foreach ($runs->take(100) as $run)
                            <tr wire:key="{{ $run->command.$run->expression.($run->success ? 't' : 'f') }}-spacer" class="h-2 first:h-0"></tr>
                            <tr wire:key="{{ $run->command.$run->expression.($run->success ? 't' : 'f') }}-row">
                                <x-pulse::td @class(['max-w-[1px]', 'bg-red-50' => !$run->success])>
                                    <code class="block text-xs text-gray-900 dark:text-gray-100 truncate" title="{{ $run->command }}">
                                        {{ $run->command }}
                                    </code>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 truncate" title="{{ $run->expression }}">
                                        {{ $run->expression }}
                                    </p>
                                </x-pulse::td>
                                <x-pulse::td numeric @class(['text-gray-700 dark:text-gray-300 font-bold', 'bg-red-50' => !$run->success])>
                                    @if ($config['sample_rate'] < 1)
                                        <span title="Sample rate: {{ $config['sample_rate'] }}">~{{ $run->latest->ago(syntax: Carbon\CarbonInterface::DIFF_ABSOLUTE, short: true) }}</span>
                                    @else
                                        {{ $run->latest->ago(syntax: Carbon\CarbonInterface::DIFF_ABSOLUTE, short: true) }}
                                    @endif
                                </x-pulse::td>
                                <x-pulse::td numeric @class(['text-gray-700 dark:text-gray-300 font-bold', 'bg-red-50' => !$run->success])>
                                    @if ($config['sample_rate'] < 1)
                                        <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($run->count) }}">~{{ number_format($run->count * (1 / $config['sample_rate'])) }}</span>
                                    @else
                                        {{ number_format($run->count) }}
                                    @endif
                                </x-pulse::td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-pulse::table>
            @endif

            @if ($runs->count() > 100)
                <div class="mt-2 text-xs text-gray-400 text-center">Limited to 100 entries</div>
            @endif
        </div>
    </x-pulse::scroll>

    <style>
    html.dark #anourvalar-schedule-svg {fill: #9ca3af !important;}
    html:not(.dark) #anourvalar-schedule-svg {fill: #4b5563 !important;}
    </style>
</x-pulse::card>
