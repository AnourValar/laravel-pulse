<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Queue\Events\JobProcessing;
use Laravel\Pulse\Pulse;

class LatencyJobsRecorder
{
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
        JobProcessing::class,
    ];

    /**
     * Record the event
     */
    public function record(JobProcessing $event): void
    {
        if (get_class($event->job) != \Illuminate\Queue\Jobs\RedisJob::class) {
            return;
        }
        $startedAt = now();

        $this->pulse->lazy(function () use ($event, $startedAt) {
            $command = $event->job->payload()['data']['commandName'];

            if ($event->job->payload()['attempts']) {
                return; // retry
            }

            $payload = unserialize($event->job->payload()['data']['command']);
            if ($payload->delay instanceof \Carbon\CarbonInterface) {
                $scheduledAt = ($payload->delay->getTimestampMs() / 1000);
            } else {
                $scheduledAt = $event->job->payload()['createdAt'] + $payload->delay;
            }

            $duration = ($startedAt->getTimestampMs() / 1000) - $scheduledAt;
            $duration = (int) round($duration * 1000);

            if (! $this->shouldSample() || $this->shouldIgnore($command) || $this->underThreshold($duration, $command)) {
                return;
            }

            $this->pulse->record(
                type: 'anourvalar_latency_jobs',
                key: $command,
                timestamp: now()->getTimestamp(),
                value: $duration,
            )->max()->count();
        });
    }
}
