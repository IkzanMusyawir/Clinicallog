The application uses the standard Laravel configuration system, which relies on PHP array-based configuration files located in the `config/` directory. These files define default values and structure for various subsystems (database, mail, cache, etc.), while actual runtime values are injected via environment variables loaded from a `.env` file.

### Core Approach
- **Environment-Driven**: The `.env` file is the primary source of truth for sensitive or environment-specific settings (credentials, URLs, debug flags). It is not committed to version control; `.env.example` serves as a template.
- **Config Caching**: In production, `php artisan config:cache` should be used to merge all config files into a single cached file for performance. This means `env()` calls outside of config files will return `null` in cached environments.
- **Fallback Defaults**: Every `env()` call in config files includes a sensible default (e.g., `env('APP_DEBUG', false)`), ensuring the app can boot even if specific env vars are missing.

### Key Configuration Areas
1. **Application (`config/app.php`)**: Defines name, URL, locale, timezone, and encryption key. Debug mode is controlled by `APP_DEBUG`.
2. **Database (`config/database.php`)**: Defaults to SQLite (`database/database.sqlite`) for local development but supports MySQL, PostgreSQL, and SQL Server via env vars. Connection details are fully externalized.
3. **Services (`config/services.php`)**: Holds credentials for third-party APIs like Postmark, Resend, AWS SES, and Slack. These are strictly env-var driven.
4. **Filesystem (`config/filesystems.php`)**: Configures storage disks. The `public` disk links to `storage/app/public` for web-accessible assets (like landing page images), while `local` is private. S3 is supported for cloud storage.
5. **Cache & Session (`config/cache.php`, `config/session.php`)**: Both default to `database` drivers, leveraging the main DB connection. Redis and Memcached are available as alternatives.
6. **Mail (`config/mail.php`)**: Defaults to `log` driver for local development. Supports SMTP, SES, Postmark, and Resend for production.
7. **Logging (`config/logging.php`)**: Uses Monolog. Defaults to a `stack` channel that writes to a `single` log file. Supports daily logs, Slack alerts, and stderr output.

### Developer Rules
- **Never hardcode secrets**: Always use `env('KEY')` in config files, never in business logic.
- **Access config via `config()` helper**: In controllers and services, use `config('app.name')` instead of `env('APP_NAME')`. The `env()` function only works reliably during the config loading phase.
- **Update `.env.example`**: When adding new environment variables, always add them to `.env.example` with dummy values to document requirements for other developers.
- **Sensitive Data**: Ensure `.env` is listed in `.gitignore` (it is by default in Laravel) to prevent leaking credentials.