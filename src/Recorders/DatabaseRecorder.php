<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Database\Events\QueryExecuted;
use Laravel\Pulse\Pulse;

class DatabaseRecorder
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
        QueryExecuted::class,
    ];

    /**
     * Record the event
     */
    public function record(QueryExecuted $event): void
    {
        $this->pulse->lazy(function () use ($event) {
            if (! $this->shouldSample() || $this->shouldIgnore($event->sql)) {
                return;
            }

            $this->pulse->record(
                type: 'anourvalar_database_' . $this->getType($event->sql),
                key: $event->connectionName,
                timestamp:  now()->subMilliseconds((int) floor($event->time))->getTimestamp(),
            )->count()->onlyBuckets();
        });
    }

    /**
     * @param string $sql
     * @return string
     */
    private function getType(string $sql): string
    {
        $map = [
            'select' => 'read',
            'replace' => 'write',
            'insert' => 'write',
            'update' => 'write',
            'delete' => 'write',
            'drop' => 'write',
            'create' => 'write',
            'alter' => 'write',
        ];

        $position = null;
        $result = 'read';
        foreach ($map as $keyword => $type) {
            $curr = stripos($sql, $keyword);
            if ($curr !== false && ($curr < $position || $position === null)) {
                $position = $curr;
                $result = $type;
            }
        }

        return $result;
    }
}
