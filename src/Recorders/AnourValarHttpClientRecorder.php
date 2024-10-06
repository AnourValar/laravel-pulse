<?php

namespace AnourValar\LaravelPulse\Recorders;

use AnourValar\HttpClient\Events\HttpRequestComplete;
use Laravel\Pulse\Pulse;

class AnourValarHttpClientRecorder
{
    use \Laravel\Pulse\Recorders\Concerns\Groups;
    use \Laravel\Pulse\Recorders\Concerns\Ignores;
    use \Laravel\Pulse\Recorders\Concerns\Sampling;
    use \Laravel\Pulse\Recorders\Concerns\Thresholds;

    /**
     * Create a new recorder instance.
     */
    public function __construct(
        protected Pulse $pulse,
    ) {
        //
    }

    /**
     * The events to listen for.
     *
     * @var array<int, class-string>
     */
    public array $listen = [
        HttpRequestComplete::class,
    ];

    /**
     * Record the event
     */
    public function record(HttpRequestComplete $event): void
    {
        $this->pulse->lazy(function () use ($event) {
            if (
                ! $this->shouldSample()
                || $this->shouldIgnore($event->uri)
                || $this->underThreshold($duration = ($event->finishedAt - $event->startedAt) * 1000, $event->uri)
            ) {
                return;
            }

            $timestamp = now()->getTimestamp();

            $this->pulse->record(
                type: 'anourvalar_anourvalar_httpclient',
                key: json_encode([$event->method, $this->group($event->uri)], flags: JSON_THROW_ON_ERROR),
                value: $duration,
                timestamp: $timestamp,
            )->max()->count();
        });
    }
}
