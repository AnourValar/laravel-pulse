<?php

namespace AnourValar\LaravelPulse\Recorders;

use Laravel\Pulse\Events\IsolatedBeat;
use Laravel\Pulse\Pulse;

class PingRecorder
{
    use \Laravel\Pulse\Recorders\Concerns\Throttling;

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
        IsolatedBeat::class,
    ];

    /**
     * Record the event
     */
    public function record(IsolatedBeat $event): void
    {
        $this->throttle(55, $event, function ($event) {
            foreach (\Config::get('pulse.recorders.'.static::class.'.urls', []) as $url) {
                $timestamp = now()->getTimestamp();
                $url = url($url);
                [$success, $responseTimeMs] = $this->ping($url);

                $this->pulse->record(
                    type: 'anourvalar_ping_' . $success,
                    key: $url,
                    value: $responseTimeMs,
                    timestamp: $timestamp,
                )->avg()->onlyBuckets();
            }
        });
    }

    /**
     * @param string $url
     * @return array
     */
    protected function ping(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);

        $curlGetInfo = curl_getinfo($ch);
        curl_close($ch);

        $httpCode = (int) $curlGetInfo['http_code']; // 0 - if no response,
        $responseTimeMs = (int) round(($curlGetInfo['total_time'] - $curlGetInfo['namelookup_time'])  * 1000);
        if ($responseTimeMs === 0) {
            $responseTimeMs = 1;
        }

        return [$httpCode == 200 ? 'success' : 'failure', $responseTimeMs];
    }
}
