<?php

namespace AnourValar\LaravelPulse\Livewire;

use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Livewire;

#[Lazy]
class HttpRequestsAvg extends Card
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        [$requests, $time, $runAt] = $this->remember(fn () => $this->graph(['anourvalar_http_requests', 'anourvalar_http_requests_latency'], 'avg'));

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('requests-avg-chart-update', requests: $requests);
        }

        return view('anourvalar.pulse::http-requests-avg', [
            'requests' => $requests,
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\HttpRequestsRecorder::class),
        ]);
    }
}
