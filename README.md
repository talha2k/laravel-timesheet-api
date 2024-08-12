# Laravel - Timesheet API

This is a Laravel-based API for managing users, projects, and timesheets.

## Brief (Task2 Laravel)

By using Laravel, please do the following:

- Create the following models: User, Project, Timesheet: the user Should have: first name, last name, date of birth, gender, email, password. The project should have: name, department, start date, end date, status. Timesheet should have: task name, date, hours.
- You need to create the proper relationships between the models, user can be assigned to more than one project, and each project can have many users, every user can log his timesheets to many projects, but each timesheets record should be linked with only one project and only one user.
- Create API endpoints for each model:
  - Create: POST /api/{model\_name}, you should pass the data of that model.
  - Read a record: GET /api/{model\_name}/{id}, it brings all the data from the select record.
  - Read all records: GET /api/{model\_name}, it brings all the records of that model
  - Update: POST /api/{model\_name}/update, it updates the record, you should pass the record id and updated data.
  - Delete: POST /api/{model\_name}/delete, you should pass the id of the record you need to delete, it should delete the timesheets records related to him.
- We need to have filtering system in “Read all records” endpoint, you need to send the filter value with the request, it should include the fields you need to filter with “AND” operation, so you may filter users by first name AND gender AND date.
- All endpoints cannot be accessible by public, you should build authentication for the users after login (please create the needed endpoints for register, login and logout) and if the user is not logged-in then cannot access the API. 
- Please upload your work on GitHub and share the repository link.
- Please attach the database in SQL format.
- Please share the username, passwords, instructions to access the API.

## Database

Create an empty database named "timesheet_api" and import the database file named "timesheet_api.sql" located in project root directory.

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

## Postman Collection
Use this file in project root directory to import the postman collection: Timesheet API.postman_collection.json


# Implementation

This Laravel API application manages users, projects, and timesheets. It includes models for User, Project, and Timesheet and provides a RESTful API for creating, reading, updating, and deleting records. The application also includes authentication for API access.

**Models**

**User**

- **Fields:**
  - first\_name
  - last\_name
  - date\_of\_birth
  - gender
  - email
  - password

**Project**

- **Fields:**
  - name
  - department
  - start\_date
  - end\_date
  - status

**Timesheet**

- **Fields:**
  - task\_name
  - date
  - hours

**Relationships**

- A User can be assigned to more than one Project.
- A Project can have many Users.
- Each User can log their timesheets to multiple Projects, but each timesheet record should be linked to only one Project and one User.

**User API Endpoints**

- **Create User:**
  - POST /api/user
  - Payload: { first\_name, last\_name, date\_of\_birth, gender, email, password }
- **Get User:**
  - GET /api/user/{id}
  - Fetches the details of the specified user.
- **Get All Users:**
  - GET /api/user
  - Fetches all users, with optional filtering by first\_name, gender, and date\_of\_birth.
- **Update User:**
  - POST /api/user/update
  - Payload: { id, first\_name, last\_name, date\_of\_birth, gender, email, password }
  - Updates the specified user's information.
- **Delete User:**
  - POST /api/user/delete
  - Payload: { id }
  - Deletes the specified user and all related timesheet records.

**Project API Endpoints**

- **Create Project:**
  - POST /api/project
  - Payload: { name, department, start\_date, end\_date, status }
- **Get Project:**
  - GET /api/project/{id}
  - Fetches the details of the specified project.
- **Get All Projects:**
  - GET /api/project
  - Fetches all projects, with optional filtering.
- **Update Project:**
  - POST /api/project/update
  - Payload: { id, name, department, start\_date, end\_date, status }
  - Updates the specified project's information.
- **Delete Project:**
  - POST /api/project/delete
  - Payload: { id }
  - Deletes the specified project.

**Timesheet API Endpoints**

- **Create Timesheet:**
  - POST /api/timesheet
  - Payload: { task\_name, date, hours, project\_id, user\_id }
- **Get Timesheet:**
  - GET /api/timesheet/{id}
  - Fetches the details of the specified timesheet.
- **Get All Timesheets:**
  - GET /api/timesheet
  - Fetches all timesheets, with optional filtering.
- **Update Timesheet:**
  - POST /api/timesheet/update
  - Payload: { id, task\_name, date, hours, project\_id, user\_id }
  - Updates the specified timesheet's information.
- **Delete Timesheet:**
  - POST /api/timesheet/delete
  - Payload: { id }
  - Deletes the specified timesheet.

**Authentication API Endpoints**

- **Register:**
  - POST /api/register
  - Payload: { first\_name, last\_name, date\_of\_birth, gender, email, password }
  - Registers a new user.
- **Login:**
  - POST /api/login
  - Payload: { email, password }
  - Logs in a user and returns an authentication token.
- **Logout:**
  - POST /api/logout
  - Invalidates the current user's authentication token.

All API endpoints (except: register and login) are protected and require authentication. Users must log in to access the API. If the user is not authenticated, access to the API is denied.
