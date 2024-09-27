<?php

namespace AnourValar\LaravelPulse\Livewire;

use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Livewire;

#[Lazy]
class HttpRequestsCount extends Card
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        [$requests, $time, $runAt] = $this->remember(fn () => $this->graph(['anourvalar_http_requests'], 'count'));

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('requests-count-chart-update', requests: $requests);
        }

        return view('anourvalar.pulse::http-requests-count', [
            'requests' => $requests,
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\HttpRequestsRecorder::class),
        ]);
    }
}
