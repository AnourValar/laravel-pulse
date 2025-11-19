<?php

namespace AnourValar\LaravelPulse\Recorders;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Carbon;
use Laravel\Pulse\Pulse;
use Symfony\Component\HttpFoundation\Response;

class FpmRecorder
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
     */
    public function record(Carbon $startedAt, Request $request, Response $response): void
    {
        $this->pulse->lazy(function () use ($startedAt, $request) {
            if (! $request->route() instanceof Route || ! $this->shouldSample() || ! function_exists('fpm_get_status')) {
                return;
            }

            $status = fpm_get_status();
            $name = config('pulse.recorders.' . \Laravel\Pulse\Recorders\Servers::class . '.server_name');

            $this->pulse->record(
                type: 'anourvalar_fpm_total_processes',
                key: $name,
                value: $status['total-processes'],
                timestamp: $startedAt,
            )->max()->onlyBuckets();

            $this->pulse->record(
                type: 'anourvalar_fpm_idle_processes',
                key: $name,
                value: $status['idle-processes'],
                timestamp: $startedAt,
            )->max()->onlyBuckets();
        });
    }
}
