<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Events\CommandFinished;
use Laravel\Pulse\Pulse;

class SlowCommandsRecorder
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
        CommandStarting::class,
        CommandFinished::class,
    ];

    /**
     * Record the event
     */
    public function record(CommandStarting|CommandFinished $event): void
    {
        $command = trim((string) $event->input, "'");
        $command = trim(preg_replace('#^([^\s]+)\\\'#', '$1', $command));

        static $marker;
        if ($event instanceof CommandStarting) {
            $marker[$command] = microtime(true);
            return;
        }

        $this->pulse->lazy(function () use ($marker, $command) {
            $duration = (int) round((microtime(true) - $marker[$command]) * 1000);
            unset($marker[$command]);

            $timestamp = now()->getTimestamp();

            if (! $this->shouldSample() || $this->shouldIgnore($command) || $this->underThreshold($duration, $command)) {
                return;
            }

            $this->pulse->record(
                type: 'anourvalar_slow_commands',
                key: $command,
                timestamp: $timestamp,
                value: $duration,
            )->max()->count();
        });
    }
}
