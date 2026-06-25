The ClinicalLog CMS repository employs a dual package manager strategy, utilizing **Composer** for PHP backend dependencies and **npm** for frontend JavaScript/CSS tooling. This setup is typical for modern Laravel applications, ensuring strict version control and reproducible builds across both server-side and client-side environments.

### 1. Dependency Management Systems

#### Backend: Composer (PHP)
- **Manifest**: `composer.json` defines the project as a `laravel/laravel` skeleton.
- **Core Dependencies**: 
  - `laravel/framework` (^13.8): The core application framework.
  - `laravel/tinker` (^3.0): REPL for interacting with the application.
- **Development Dependencies**:
  - `laravel/breeze` (^2.4): Scaffolding for authentication.
  - `laravel/pint` (^1.27): Code style fixer (PSR-12).
  - `phpunit/phpunit` (^12.5.12): Testing framework.
  - `fakerphp/faker`, `mockery/mockery`, `nunomaduro/collision`: Testing and debugging utilities.
- **Lockfile**: `composer.lock` ensures that exact versions of all PHP packages are installed, preventing unexpected breaks from minor updates.
- **Autoloading**: PSR-4 autoloading is configured for `App\`, `Database\Factories\`, and `Database\Seeders\` namespaces.

#### Frontend: npm (Node.js)
- **Manifest**: `package.json` manages frontend assets and build tools.
- **Core Dependencies**:
  - `vite` (^8.0.0): Next-generation frontend tooling for asset bundling.
  - `laravel-vite-plugin` (^3.1): Integrates Vite with Laravel.
  - `tailwindcss` (^3.1.0) & `@tailwindcss/vite` (^4.0.0): Utility-first CSS framework.
  - `alpinejs` (^3.4.2): Lightweight JavaScript framework for interactive UIs.
  - `concurrently` (^9.0.1): Runs multiple commands simultaneously (used in dev scripts).
- **Lockfile**: `package-lock.json` locks the dependency tree for Node.js packages.
- **Configuration**: `.npmrc` is configured with `ignore-scripts=true` to prevent execution of arbitrary lifecycle scripts during installation, enhancing security and build predictability. `audit=true` enables security auditing.

### 2. Key Files and Packages

| File | Purpose |
| :--- | :--- |
| `composer.json` | Defines PHP dependencies, autoload rules, and Composer scripts. |
| `composer.lock` | Locks PHP dependency versions for reproducible installs. |
| `package.json` | Defines Node.js dependencies and npm scripts. |
| `package-lock.json` | Locks Node.js dependency versions. |
| `.npmrc` | Configures npm behavior (security and script execution). |
| `vendor/` | Directory for installed PHP packages (not committed to Git). |
| `node_modules/` | Directory for installed Node.js packages (not committed to Git). |

### 3. Architecture and Conventions

- **Script Orchestration**: The `composer.json` `scripts` section defines high-level workflows that coordinate both package managers:
  - `setup`: Installs PHP deps, copies `.env`, generates app key, runs migrations, installs Node deps (`npm install --ignore-scripts`), and builds assets (`npm run build`).
  - `dev`: Uses `concurrently` to run the PHP server, queue listener, log tailer (`pail`), and Vite dev server simultaneously.
  - `test`: Clears config and runs PHPUnit tests.
- **Security Posture**: The `.npmrc` configuration explicitly ignores scripts (`ignore-scripts=true`), which mitigates risks from malicious pre/post-install scripts in the Node ecosystem. This requires developers to manually run build steps if needed, though the `setup` script handles this via `npm run build`.
- **Version Stability**: 
  - PHP dependencies prefer stable releases (`prefer-stable: true`).
  - Frontend dependencies use caret ranges (`^`) to allow non-breaking updates while locking major versions.

### 4. Rules for Developers

- **Install Dependencies**: Always run `composer setup` for a fresh installation. This ensures both PHP and Node dependencies are installed, the environment is configured, and assets are built.
- **Development Workflow**: Use `composer dev` to start the local development environment. This command orchestrates all necessary services (server, queue, logs, vite) in one terminal window.
- **Adding Dependencies**:
  - For PHP: Use `composer require <package>` or `composer require --dev <package>`.
  - For Node: Use `npm install <package>` or `npm install --save-dev <package>`.
- **Lockfiles**: Commit both `composer.lock` and `package-lock.json` to version control to ensure team members and deployment environments use identical dependency versions.
- **Security Audits**: Regularly run `npm audit` (enabled by `.npmrc`) and `composer audit` (if available/configured) to check for known vulnerabilities in dependencies.