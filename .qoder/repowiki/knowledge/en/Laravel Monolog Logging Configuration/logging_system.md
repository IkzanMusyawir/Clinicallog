## Overview

This repository uses **Laravel's built-in Monolog-based logging system**, configured through the standard `config/logging.php` file. The application relies entirely on Laravel's default logging infrastructure with no custom loggers, structured logging implementations, or application-level logging calls.

## System Architecture

### Framework and Library
- **Logging Framework**: Monolog (via Laravel's logging facade)
- **Configuration File**: `config/logging.php`
- **Log Facade**: `Illuminate\Support\Facades\Log` (available but unused in application code)
- **Default Channel**: `stack` (environment-variable driven via `LOG_CHANNEL`)

### Log Channels Configured

The application defines eight log channels:

1. **stack** — Composite channel that aggregates multiple channels (default). Composed of channels listed in `LOG_STACK` environment variable (defaults to `single`).
2. **single** — Single-file logger writing to `storage/logs/laravel.log`. Level controlled by `LOG_LEVEL` (default: `debug`).
3. **daily** — Rotating daily log files written to `storage/logs/laravel.log`. Retention period controlled by `LOG_DAILY_DAYS` (default: 14 days).
4. **slack** — Sends critical-level messages to a Slack webhook URL. Requires `LOG_SLACK_WEBHOOK_URL` to be set. Default level: `critical`.
5. **papertrail** — Remote syslog handler for Papertrail service. Uses TLS connection.
6. **stderr** — Writes to standard error stream. Suitable for containerized deployments.
7. **syslog** — System syslog facility integration.
8. **errorlog** — PHP's native error_log function.
9. **null** — Discards all log messages (used for deprecation suppression).
10. **emergency** — Fallback emergency log path pointing to `storage/logs/laravel.log`.

### Environment Configuration

Logging behavior is controlled via `.env` variables (from `.env.example`):

```
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
```

Key environment variables:
- `LOG_CHANNEL` — Selects the default channel (default: `stack`)
- `LOG_STACK` — Comma-separated list of channels for the stack driver (default: `single`)
- `LOG_LEVEL` — Minimum log level to capture (default: `debug`)
- `LOG_DEPRECATIONS_CHANNEL` — Channel for PHP/library deprecation warnings (default: `null`, i.e., suppressed)
- `LOG_DEPRECATIONS_TRACE` — Whether to include stack traces in deprecation logs (default: `false`)

### Deprecation Handling

A dedicated deprecations channel configuration exists:
```php
'deprecations' => [
    'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
    'trace' => env('LOG_DEPRECATIONS_TRACE', false),
],
```

By default, deprecation warnings are discarded (`null` channel), which is typical for development environments where framework-level deprecations may be noisy.

## Key Files

| File | Purpose |
|------|---------|
| `config/logging.php` | Central logging configuration defining all channels, handlers, and defaults |
| `.env.example` | Documents available logging environment variables |
| `storage/logs/laravel.log` | Active log file (343 KB observed) |

## Application Usage Patterns

### No Explicit Logging in Application Code

A repository-wide search for `Log::`, `logger()`, `use Illuminate\Support\Facades\Log`, and common logging method calls (`info()`, `debug()`, `error()`, `warning()`) across all PHP files in the `app/` directory returned **zero matches**. This indicates:

- Controllers do not emit explicit log statements
- No custom error logging beyond Laravel's built-in exception handling
- No structured logging or contextual data attachment
- No domain-specific logging conventions established

### Implicit Logging

Logging occurs implicitly through:
1. **Laravel's exception handler** — Uncaught exceptions are logged automatically
2. **Validation failures** — Logged by the framework when validation errors occur
3. **Mail queue failures** — The mail driver is set to `log` in `.env.example`, meaning outbound emails are written to the log instead of being sent
4. **Broadcast events** — The broadcast connection is set to `log`, meaning events are logged rather than transmitted

## Conventions and Developer Guidance

### Current State

The logging system is **purely infrastructure-level** with no application-layer conventions. Developers should be aware of the following:

1. **No structured logging** — All log output uses Monolog's default line format. No JSON structured logging is configured.
2. **No contextual fields** — No processors are attached to the default `single` or `daily` channels to add request IDs, user IDs, or other context.
3. **Debug-level default** — `LOG_LEVEL=debug` means all severity levels are captured in development. This should be raised to `warning` or `error` in production.
4. **Single-file accumulation** — The default `single` channel appends to one file indefinitely. For production, consider switching to `daily` rotation via `LOG_STACK=daily`.
5. **Slack alerts available but unconfigured** — The Slack channel exists but requires `LOG_SLACK_WEBHOOK_URL` to be set. It only triggers on `critical` level, suitable for production incident notification.

### Recommended Practices (Not Currently Enforced)

If developers need to add logging:
- Use the `Log` facade: `use Illuminate\Support\Facades\Log;`
- Prefer contextual arrays: `Log::info('User logged in', ['user_id' => $id])`
- Use appropriate levels: `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency`
- For request-scoped context, consider adding a middleware that attaches request identifiers via Monolog processors

## Confidence Assessment

Confidence is **high** because:
- The `config/logging.php` file provides complete, explicit configuration
- The `.env.example` documents all logging-related environment variables
- The `storage/logs/laravel.log` file confirms active log output
- Repository-wide grep confirms absence of application-level logging calls, establishing a clear pattern (or lack thereof)