# Implementation Plan: Replace Custom Debugger with clcbws/laravel-agents-debug Package

This plan outlines the steps required to replace the existing custom Zero-Touch Debug Activity Logger with the newly provided local package `clcbws/laravel-agents-debug` from `/mnt/BWS/public_projects/Local_Debug_Activity/`.

## Proposed Changes

### 1. Configure Local Composer Path Repository
- Modify `composer.json` of the project to add the local repository of type `path` pointing to `/mnt/BWS/public_projects/Local_Debug_Activity`.
- Add `"clcbws/laravel-agents-debug": "*"` (or `3.1.0`) under the `require-dev` section.
- Run `composer update clcbws/laravel-agents-debug` to register and install the package with local symlinking.

### 2. Remove Custom/Basic Local Debugger Code
- Delete the custom middleware file: `app/Http/Middleware/DebugActivityLoggerMiddleware.php`.
- Remove registration of `DebugActivityLoggerMiddleware` from `bootstrap/app.php`.
- Remove the POST `debug-log` route block from `routes/web.php`.
- Delete the old helper function `debug_log` definition inside `app/Helper/GlobalHelper.php` (as the package provides its own version of `debug_log` in `src/Helpers/functions.php`).

### 3. Register and Enable the New Package
- Configure the `.env` file to include `AGENT_DEBUGGER_ENABLED=true`.
- Publish the package configuration using:
  ```bash
  php artisan vendor:publish --provider="LaravelAgentDebugger\DebugActivityServiceProvider"
  ```
- Run the package enablement command:
  ```bash
  php artisan agent:debug-on
  ```

## Verification Plan

### Command Line Verification
1. Run `composer show clcbws/laravel-agents-debug` to ensure the package is registered from the correct path.
2. Run `php artisan agent:debug-status` to verify that the agent-debugger is active.

### Live/Manual Verification
1. Visit the dashboard route at `/login` or any page, and verify the glassmorphic status badge appears in the bottom right corner showing the execution time and database queries count.
2. Visit the debugger dashboard at `http://localhost:8000/_agent_debug/dashboard` (or mapped host URL) to confirm the full UI diagnostic dashboard is running.
