<?php

namespace AnourValar\LaravelPulse\Livewire;

use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Livewire;

#[Lazy]
class Fpm extends Card
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        [$fpm, $time, $runAt] = $this->remember(fn () => $this->graph(['anourvalar_fpm_total', 'anourvalar_fpm_idle'], 'max'));

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('fpm-chart-update', fpm: $fpm);
        }

        return view('anourvalar.pulse::fpm', [
            'fpm' => $fpm,
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\FpmRecorder::class),
        ]);
    }
}
