# Timesheet API

This is a Laravel-based API for managing users, projects, and timesheets.

## Setup Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database settings
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan serve` to start the development server

## API Documentation

### Authentication

- Register: POST /api/register
- Login: POST /api/login
- Logout: POST /api/logout (requires authentication)

### Users

- Get all users: GET /api/users (requires authentication)
- Create user: POST /api/users (requires authentication)
- Get user: GET /api/users/{id} (requires authentication)
- Update user: POST /api/users/update (requires authentication)
- Delete user: POST /api/users/delete (requires authentication)

### Projects

- Get all projects: GET /api/projects (requires authentication)
- Create project: POST /api/projects (requires authentication)
- Get project: GET /api/projects/{id} (requires authentication)
- Update project: POST /api/projects/update (requires authentication)
- Delete project: POST /api/projects/delete (requires authentication)

### Timesheets

- Get all timesheets: GET /api/timesheets (requires authentication)
- Create timesheet: POST /api/timesheets (requires authentication)
- Get timesheet: GET /api/timesheets/{id} (requires authentication)
- Update timesheet: POST /api/timesheets/update (requires authentication)
- Delete timesheet: POST /api/timesheets/delete (requires authentication)

## Filtering

For the "Read all records" endpoints, you can add query parameters to filter the results. For example:

- Filter users by first name and gender: GET /api/users?first_name=John&gender=male
- Filter projects by name and status: GET /api/projects?name=ProjectX&status=active
- Filter timesheets by date and user_id: GET /api/timesheets?date=2023-05-01&user_id=1

## Authentication

To access protected endpoints, you need to include the Bearer token in the Authorization header of your requests. You can obtain this token by registering or logging in.
