<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Laravel\Pulse\Pulse;
use Symfony\Component\HttpFoundation\Response;

class HttpRequestsRecorder
{
    use \Laravel\Pulse\Recorders\Concerns\Ignores;
    use \Laravel\Pulse\Recorders\Concerns\Sampling;
    use \Laravel\Pulse\Recorders\Concerns\LivewireRoutes;
    use \Laravel\Pulse\Concerns\ConfiguresAfterResolving;

    /**
     * Create a new recorder instance.
     */
    public function __construct(
        protected Pulse $pulse,
    ) {
        //
    }

    /**
     * Register the recorder.
     */
    public function register(callable $record, Application $app): void
    {
        $this->afterResolving(
            $app,
            Kernel::class,
            fn (Kernel $kernel) => $kernel->whenRequestLifecycleIsLongerThan(-1, $record) // @phpstan-ignore method.notFound
        );
    }

    /**
     * Record the request.
     * @psalm-suppress UnusedVariable
     */
    public function record(Carbon $startedAt, Request $request, Response $response): void
    {
        $this->pulse->lazy(function () use ($startedAt, $request, $response) {
            if (! $request->route() instanceof Route || ! $this->shouldSample()) {
                return;
            }

            [$path, $via] = $this->resolveRoutePath($request);
            if ($this->shouldIgnore($path)) {
                return;
            }

            $this->pulse->record(
                type: 'anourvalar_http_requests',
                key: (string) $response->getStatusCode(),
                value: (int) round($startedAt->diffInMilliseconds()),
                timestamp: $startedAt,
            )->avg()->count()->onlyBuckets();

            if ($queued = $request->header('X-Request-Start')) {
                $this->pulse->record(
                    type: 'anourvalar_http_requests_latency',
                    key: (string) $response->getStatusCode(),
                    value: (int) round($startedAt->getTimestampMs() - ($queued * 1000)),
                    timestamp: $startedAt,
                )->avg()->onlyBuckets();
            }
        });
    }
}
