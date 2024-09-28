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
class Database extends Card
{
    /**
     * Render the component.
     */
    public function render(): Renderable
    {
        [$queries, $time, $runAt] = $this->remember(fn () => $this->graph(
            ['anourvalar_database_read', 'anourvalar_database_write'],
            'count',
        ));

        if (Livewire::isLivewireRequest()) {
            $this->dispatch('database-chart-update', queries: $queries);
        }

        return view('anourvalar.pulse::database', [
            'queries' => $queries,
            'time' => $time,
            'runAt' => $runAt,
            'config' => Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\DatabaseRecorder::class),
        ]);
    }
}
