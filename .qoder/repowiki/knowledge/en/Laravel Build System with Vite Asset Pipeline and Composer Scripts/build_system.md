# Laravel Build System with Vite Asset Pipeline

## Overview

ClinicalLog CMS uses a **dual-package-manager build system** combining Composer (PHP) and npm (JavaScript) orchestrated through Laravel's convention-based scripts. The frontend asset pipeline is powered by **Vite** with the `laravel-vite-plugin`, processing CSS through **PostCSS** and **Tailwind CSS**, while JavaScript leverages **Alpine.js** for interactivity.

## Build Tools and Dependencies

### PHP/Backend (Composer)
- **Framework**: Laravel 13.8
- **PHP Version**: ^8.3
- **Package Manager**: Composer with lockfile (`composer.lock`)
- **Key Dev Dependencies**: Laravel Breeze, PHPUnit 12.5, Laravel Pint (code style), Faker

### JavaScript/Frontend (npm)
- **Bundler**: Vite ^8.0.0
- **CSS Framework**: Tailwind CSS ^3.1.0 with @tailwindcss/forms
- **JS Library**: Alpine.js ^3.4.2
- **Build Plugins**: laravel-vite-plugin ^3.1, PostCSS ^8.4.31, Autoprefixer ^10.4.2
- **Dev Tooling**: concurrently ^9.0.1 (for parallel process management)
- **Lockfile Enforcement**: `.npmrc` sets `ignore-scripts=true` and `audit=true`

## Key Build Files

### Core Configuration Files
- **`composer.json`**: Defines PHP dependencies and orchestrates build lifecycle through custom scripts
- **`package.json`**: Defines JS dependencies and exposes `build` and `dev` npm scripts
- **`vite.config.js`**: Configures Vite with laravel-vite-plugin, specifying entry points (`resources/css/app.css`, `resources/js/app.js`) and enabling automatic browser refresh
- **`postcss.config.js`**: Activates Tailwind CSS and Autoprefixer plugins
- **`tailwind.config.js`**: Scans Blade templates for used classes, configures Figtree font family
- **`phpunit.xml`**: Configures test suites (Unit/Feature) with in-memory SQLite for testing

### Entry Points
- **CSS**: `resources/css/app.css` (imports Tailwind directives)
- **JavaScript**: `resources/js/app.js` (initializes Alpine.js globally)

## Build Commands and Workflows

### Composer Scripts (Primary Orchestration)

#### `composer setup`
Full project initialization sequence:
1. Install PHP dependencies (`composer install`)
2. Create `.env` from `.env.example` if missing
3. Generate application key (`php artisan key:generate`)
4. Run database migrations (`php artisan migrate --force`)
5. Install JS dependencies (`npm install --ignore-scripts`)
6. Build production assets (`npm run build`)

#### `composer dev`
Development environment with concurrent processes:
- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen --tries=1 --timeout=0`)
- Log tailing (`php artisan pail --timeout=0`)
- Vite dev server (`npm run dev`)

Uses `concurrently` with color-coded output and automatic process killing on exit.

#### `composer test`
Testing workflow:
1. Clear configuration cache
2. Run PHPUnit via `php artisan test`

### NPM Scripts (Asset Pipeline)

#### `npm run build`
Production asset compilation:
- Minifies and optimizes CSS/JS
- Generates hashed filenames for cache busting
- Outputs to `public/build/` directory
- Creates manifest file for Laravel integration

#### `npm run dev`
Development server with Hot Module Replacement (HMR):
- Fast incremental rebuilds
- Automatic browser refresh on file changes
- Source maps enabled for debugging

### Lifecycle Hooks

Composer automatically executes post-install/update hooks:
- **`post-autoload-dump`**: Discovers Laravel packages
- **`post-update-cmd`**: Publishes Laravel vendor assets
- **`post-create-project-cmd`**: Generates app key, creates SQLite database, runs migrations

## Architecture and Conventions

### Asset Pipeline Flow

```
Source Assets → Vite Processing → PostCSS/Tailwind → public/build/
```

1. **Input**: `resources/css/app.css` and `resources/js/app.js`
2. **Processing**: Vite bundles with laravel-vite-plugin, PostCSS applies Tailwind utilities and autoprefixing
3. **Output**: Hashed assets in `public/build/` with manifest.json
4. **Runtime**: Blade templates use `@vite()` directive to load compiled assets

### Development vs Production

**Development Mode:**
- Vite dev server serves assets directly
- HMR enables instant updates without full page reload
- No minification or tree-shaking
- Source maps available for debugging

**Production Mode:**
- Static assets pre-built to `public/build/`
- Minified and optimized bundles
- Hashed filenames for long-term caching
- Tree-shaking removes unused Tailwind classes
- Manifest file maps logical names to hashed filenames

### Testing Strategy

- **PHPUnit** configured with two test suites: Unit and Feature
- **In-memory SQLite** database for isolated tests
- Test environment variables set in `phpunit.xml`:
  - `APP_ENV=testing`
  - `DB_CONNECTION=sqlite`
  - `DB_DATABASE=:memory:`
  - Cache/session/mail drivers set to `array` (no persistence)
- Tests located in `tests/Unit` and `tests/Feature` directories

## Deployment Process

### Standard Deployment Steps

1. **Install Dependencies**:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   ```

2. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Configure DB_*, REDIS_*, APP_URL in .env
   ```

3. **Build Assets**:
   ```bash
   npm run build
   ```

4. **Database Preparation**:
   ```bash
   php artisan storage:link
   php artisan migrate --force
   ```

5. **Optimization**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. **Queue Workers** (if using async jobs):
   ```bash
   php artisan queue:work --sleep=3 --tries=3
   ```

### Performance Optimizations

- **Opcode Caching**: OPcache enabled in production
- **Autoloader Optimization**: `--optimize-autoloader` flag in production installs
- **Cache Warming**: Config, route, and view caches pre-generated
- **Redis Backend**: Recommended for cache/sessions in horizontal scaling scenarios
- **CDN Integration**: Static assets can be served from CDN via filesystem configuration

## Rules and Conventions for Developers

### Build Workflow Rules

1. **Always use Composer scripts** for common tasks rather than running individual commands manually
2. **Run `composer setup`** when cloning the repository for first-time setup
3. **Use `composer dev`** during development to get all services running concurrently
4. **Never commit `node_modules/`** or `vendor/` directories (enforced by `.gitignore`)
5. **Commit lockfiles** (`composer.lock` and `package-lock.json`) to ensure reproducible builds

### Asset Management Rules

1. **Place source assets** in `resources/css/` and `resources/js/`
2. **Static files** (images, fonts) go in `public/assets/` and are referenced via `asset()` helper
3. **Compiled output** lands in `public/build/` — never edit these files directly
4. **Tailwind scanning** only includes files matching patterns in `tailwind.config.js` content array
5. **Use `@vite()` directive** in Blade templates for automatic asset loading

### Environment Configuration Rules

1. **Never commit `.env`** — use `.env.example` as template
2. **Set `APP_DEBUG=false`** and `APP_ENV=production` in production
3. **Generate unique `APP_KEY`** per environment
4. **Use HTTPS** in production (`APP_URL=https://...`)
5. **Enable secure cookies** (`SESSION_SECURE_COOKIE=true`) with HTTPS

### Testing Rules

1. **Run `composer test`** before committing changes
2. **Tests use in-memory SQLite** — no external database required
3. **Feature tests** exercise HTTP endpoints; **Unit tests** cover isolated logic
4. **Test environment** isolates cache/session/mail to prevent side effects

### Deployment Rules

1. **Build assets before deployment** — `public/build/` must contain compiled assets
2. **Run migrations with `--force`** flag in production (required for non-interactive environments)
3. **Clear and warm caches** after deployment (config, route, view)
4. **Restart queue workers** after code changes
5. **Verify `/up` health endpoint** returns 200 after deployment

## Limitations and Missing Components

### No CI/CD Pipeline
The repository contains **no CI/CD configuration** (no `.github/workflows/`, `.gitlab-ci.yml`, or similar). Automated testing, linting, and deployment pipelines are not implemented.

### No Containerization
There are **no Dockerfiles** or `docker-compose.yml` files. Deployment assumes traditional server setup with PHP-FPM/Apache/Nginx.

### No Makefile
Build orchestration relies entirely on Composer scripts rather than a Makefile. This is conventional for Laravel projects but may be unfamiliar to developers from other ecosystems.

### No Release Versioning Strategy
No semantic versioning tags, changelog automation, or release scripting is present. Version management appears manual.

## Summary

ClinicalLog CMS employs a **standard Laravel build system** with Vite for modern frontend tooling. The dual-package-manager approach (Composer + npm) is well-integrated through Composer scripts that orchestrate the entire lifecycle from setup to testing. While the system lacks CI/CD automation and containerization, it follows Laravel conventions faithfully and provides clear, script-driven workflows for development, testing, and deployment.