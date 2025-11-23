<?php

namespace AnourValar\LaravelPulse\Livewire;

use Laravel\Pulse\Recorders\Concerns\Thresholds;
use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Url;

/**
 * @internal
 */
#[Lazy]
class SlowCommands extends Card
{
    use Thresholds;

    /**
     * Ordering.
     *
     * @var 'slowest'|'count'
     */
    #[Url(as: 'slow-commands')]
    public string $orderBy = 'slowest';

    /**
     * Render the component.
     */
    public function render()
    {
        [$slowCommands, $time, $runAt] = $this->remember(
            fn () => $this->aggregate(
                'anourvalar_slow_commands',
                ['max', 'count'],
                match ($this->orderBy) {
                    'count' => 'count',
                    default => 'max',
                },
            )->map(function ($row) {
                return (object) [
                    'command' => $row->key,
                    'slowest' => $row->max,
                    'count' => $row->count,
                    'threshold' => $this->threshold($row->key, \AnourValar\LaravelPulse\Recorders\SlowCommandsRecorder::class),
                ];
            }),
            $this->orderBy,
        );

        return view('anourvalar.pulse::slow-commands', [
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\SlowCommandsRecorder::class),
            'slowCommands' => $slowCommands,
        ]);
    }
}
