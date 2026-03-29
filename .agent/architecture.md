# Laravel Backend Architecture

## Overview
Laravel 12 application serving as the API provider for the mobile app and admin dashboard.

## Tech Stack
- **Framework**: Laravel 12
- **Database**: MySQL
- **Admin Panel**: Custom Livewire/Blade architecture (administrator.php)
- **Auth**: Laravel Sanctum

## Core Modules
- **API**: `APIController.php` (Mobile endpoints)
- **Exams**: `ExamsController.php`
- **Franchise**: `FranchiseController.php`
- **Settings**: `SettingsController.php`

## API Endpoints
- `/api/gethomepagedata`: Consolidated homepage data.
- `/api/studentLogin`: Student authentication.
- `/api/studentSignup`: Student registration.
