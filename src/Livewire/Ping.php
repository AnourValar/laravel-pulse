<?php

namespace AnourValar\LaravelPulse\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Config;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Livewire;

/**
 * @internal
 */
#[Lazy]
class Ping extends Card
{
    /**
     * Render the component.
     */
    public function render(): Renderable
    {
        [$pings, $time, $runAt] = $this->remember(fn () => $this->graph(
            ['anourvalar_ping_success', 'anourvalar_ping_failure'],
            'avg',
        ));

        // Remove last minute
        foreach ($pings as &$urls) {
            foreach ($urls as &$items) {
                if (! $items->last()) {
                    $items->pop();
                }
            }
            unset($items);
        }
        unset($urls);

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('ping-chart-update', pings: $pings);
        }

        return view('anourvalar.pulse::ping', [
            'pings' => $pings,
            'time' => $time,
            'runAt' => $runAt,
            'config' => Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\PingRecorder::class),
        ]);
    }
}
