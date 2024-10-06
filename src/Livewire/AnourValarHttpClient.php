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
class AnourValarHttpClient extends Card
{
    use Thresholds;

    /**
     * Ordering.
     *
     * @var 'slowest'|'count'
     */
    #[Url(as: 'anourvalar-httpclient')]
    public string $orderBy = 'slowest';

    /**
     * Render the component.
     */
    public function render()
    {
        [$slowOutgoingRequests, $time, $runAt] = $this->remember(
            fn () => $this->aggregate(
                'anourvalar_anourvalar_httpclient',
                ['max', 'count'],
                match ($this->orderBy) {
                    'count' => 'count',
                    default => 'max',
                },
            )->map(function ($row) {
                [$method, $uri] = json_decode($row->key, flags: JSON_THROW_ON_ERROR);

                return (object) [
                    'method' => $method,
                    'uri' => $uri,
                    'slowest' => $row->max,
                    'count' => $row->count,
                    'threshold' => $this->threshold($uri, \AnourValar\LaravelPulse\Recorders\AnourValarHttpClientRecorder::class),
                ];
            }),
            $this->orderBy,
        );

        return view('anourvalar.pulse::anourvalar-httpclient', [
            'time' => $time,
            'runAt' => $runAt,
            'config' => \Config::get('pulse.recorders.'.\AnourValar\LaravelPulse\Recorders\AnourValarHttpClientRecorder::class),
            'slowOutgoingRequests' => $slowOutgoingRequests,
        ]);
    }
}
