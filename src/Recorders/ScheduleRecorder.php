<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Console\Events\ScheduledBackgroundTaskFinished;
use Illuminate\Console\Events\ScheduledTaskFailed;
use Laravel\Pulse\Pulse;

class ScheduleRecorder
{
    use \Laravel\Pulse\Recorders\Concerns\Ignores;
    use \Laravel\Pulse\Recorders\Concerns\Sampling;

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
        ScheduledTaskFinished::class,
        ScheduledBackgroundTaskFinished::class,
        ScheduledTaskFailed::class,
    ];

    /**
     * Record the event
     */
    public function record(ScheduledTaskFinished|ScheduledBackgroundTaskFinished|ScheduledTaskFailed $event): void
    {
        if ($event->task->exitCode === null) {
            return;
        }

        $this->pulse->lazy(function () use ($event) {
            $command = $event->task->getSummaryForDisplay();
            if (! $command) {
                $command = $event->task->command;
            }

            if (! $this->shouldSample() || $this->shouldIgnore($command)) {
                return;
            }

            $timestamp = now()->getTimestamp();

            $command = explode(' > ', $command)[0];
            $command = explode("'artisan'", $command);
            $command = trim(array_pop($command));

            $data = [
                $event->task->expression, // 20 11 * * *
                $command, // health:queue-check-heartbeat
                //$event->task->nextRunDate(), // 2024-09-25 11:00:00
                ($event->task->exitCode === 0 && ! $event instanceof ScheduledTaskFailed) ? true : false,
            ];

            $this->pulse->record(
                type: 'anourvalar_schedule',
                key: json_encode($data, flags: JSON_THROW_ON_ERROR),
                timestamp: $timestamp,
                value: $timestamp,
            )->max()->count();

            if ($event instanceof ScheduledTaskFinished) {
                $this->pulse->record(
                    type: 'anourvalar_schedule_duration',
                    key: json_encode($data, flags: JSON_THROW_ON_ERROR),
                    timestamp: $timestamp,
                    value: (int) ($event->runtime * 1000),
                )->max();
            }
        });
    }
}
