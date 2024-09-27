# Additional cards for Laravel Pulse

## Installation

```bash
composer require anourvalar/laravel-pulse
```


## Schedule (cron)

![Demo](https://anour.ru/resources/pulse-schedule.png)

Add recorder to the config/pulse.php:

```php
AnourValar\LaravelPulse\Recorders\ScheduleRecorder::class => [
    'enabled' => env('PULSE_ANOURVALAR_SCHEDULE_ENABLED', true),
    'sample_rate' => env('PULSE_ANOURVALAR_SCHEDULE_RATE', 1),
    'ignore' => [],
],
```

Add card to the vendor/pulse/dashboard.blade.php:

```html
<livewire:anourvalar.pulse.schedule cols="6" />
```

## HTTP Requests (count & response time)

![Demo](https://anour.ru/resources/pulse-http-requests.png)

Add recorder to the config/pulse.php:

```php
AnourValar\LaravelPulse\Recorders\HttpRequestsRecorder::class => [
    'enabled' => env('PULSE_ANOURVALAR_HTTP_REQUESTS_ENABLED', true),
    'sample_rate' => env('PULSE_ANOURVALAR_HTTP_REQUESTS_RATE', 1),
    'ignore' => ['#/admin/#', '#/livewire/#'],
],
```

Add cards to the vendor/pulse/dashboard.blade.php:

```html
<livewire:anourvalar.pulse.http-requests-count cols="6" />
<livewire:anourvalar.pulse.http-requests-avg cols="6" />
```
