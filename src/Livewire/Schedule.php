<?php

namespace AnourValar\LaravelPulse\Livewire;

use Laravel\Pulse\Livewire\Card;
use Livewire\Attributes\Lazy;

#[Lazy]
class Schedule extends Card
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        [$runs, $time, $runAt] = $this->remember(
            fn () => $this->aggregate(
                'anourvalar_schedule',
                ['max', 'count'],
                'max',
            )->map(function ($row) {
                [$expression, $command, $success] = json_decode($row->key, flags: JSON_THROW_ON_ERROR);

                return (object) [
                    'expression' => $expression,
                    'command' => $command,
                    'success' => $success,
                    'latest' => \Date::createFromTimestamp($row->max),
                    'count' => $row->count,
                ];
            }),
            'count'
        );

        return view('anourvalar.pulse::schedule', [
            'runs' => $runs,
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\ScheduleRecorder::class),
        ]);
    }
}
