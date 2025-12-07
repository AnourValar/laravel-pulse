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
class LatencyJobs extends Card
{
    use Thresholds;

    /**
     * Ordering.
     *
     * @var 'longest'|'count'
     */
    #[Url(as: 'latency-jobs')]
    public string $orderBy = 'longest';

    /**
     * Render the component.
     */
    public function render()
    {
        [$latencyJobs, $time, $runAt] = $this->remember(
            fn () => $this->aggregate(
                'anourvalar_latency_jobs',
                ['max', 'count'],
                match ($this->orderBy) {
                    'count' => 'count',
                    default => 'max',
                },
            )->map(function ($row) {
                return (object) [
                    'job' => $row->key,
                    'longest' => $row->max,
                    'count' => $row->count,
                    'threshold' => $this->threshold($row->key, \AnourValar\LaravelPulse\Recorders\LatencyJobsRecorder::class),
                ];
            }),
            $this->orderBy,
        );

        return view('anourvalar.pulse::latency-jobs', [
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\LatencyJobsRecorder::class),
            'latencyJobs' => $latencyJobs,
        ]);
    }
}
