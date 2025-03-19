# Laravel Ticket System Documentation

## Project Overview

The Laravel Ticket System is a web application that provides CRUD (Create, Read, Update, Delete) functionality for support tickets. Each ticket contains a title, description, priority level, and status. The system includes search and filtering capabilities to help users quickly find relevant tickets.

## System Requirements

- PHP 8.4 or higher
- MySQL 5.7 or higher
- Composer
- Laravel 12.x
- PDO PHP Extension
- Fileinfo PHP Extension
- MySQL PHP Extension

## Database Structure

### Tickets Table

| Column      | Type                                | Description                           |
|-------------|-------------------------------------|---------------------------------------|
| id          | BIGINT UNSIGNED AUTO_INCREMENT (PK) | Unique identifier                     |
| title       | VARCHAR(255)                        | Short description of the issue        |
| description | TEXT                                | Detailed explanation of the issue     |
| priority    | ENUM('Low', 'Medium', 'High')       | Priority level of the ticket         |
| status      | ENUM('Open', 'In Progress', 'Closed')| Current status (defaults to 'Open')  |
| created_at  | TIMESTAMP                           | When the ticket was created           |
| updated_at  | TIMESTAMP                           | When the ticket was last updated      |

### Sessions Table (for database sessions)

| Column      | Type          | Description                         |
|-------------|---------------|-------------------------------------|
| id          | VARCHAR(255)  | Session identifier (Primary Key)    |
| user_id     | BIGINT        | User ID (nullable)                  |
| ip_address  | VARCHAR(45)   | IP address                          |
| user_agent  | TEXT          | User agent                          |
| payload     | TEXT          | Session data payload                |
| last_activity| INTEGER      | Timestamp of last activity          |

## Project Structure

```
TicketSystem/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TicketController.php
│   ├── Models/
│   │   └── Ticket.php
├── database/
│   ├── migrations/
│   │   ├── YYYY_MM_DD_create_tickets_table.php
│   │   └── YYYY_MM_DD_create_sessions_table.php
├── public/
│   ├── css/
│   │   └── custom.css
├── resources/
│   ├── views/
│   │   ├── tickets/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
├── routes/
│   └── web.php
└── .env
```

## Models

### Ticket.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'priority', 'status'];
}
```

## Controllers

### TicketController.php

| Method    | Purpose                                      | Parameters                    | Returns                           |
|-----------|----------------------------------------------|-------------------------------|-----------------------------------|
| index()   | Display all tickets with search and filtering | Request $request             | index view with filtered tickets  |
| create()  | Show form to create a new ticket             | None                          | create view                       |
| store()   | Save new ticket to database                  | Request $request              | Redirect to index with success message |
| edit()    | Show form to edit existing ticket            | $id (ticket ID)               | edit view with ticket data        |
| update()  | Save changes to existing ticket              | Request $request, $id         | Redirect to index with success message |
| destroy() | Delete existing ticket                       | $id (ticket ID)               | Redirect to index with success message |

## Routes

| Method | URL                   | Controller Action                | Purpose                  |
|--------|----------------------|----------------------------------|--------------------------|
| GET    | /                     | TicketController@index           | Show all tickets         |
| GET    | /ticket/create        | TicketController@create          | Show creation form       |
| POST   | /ticket/store         | TicketController@store           | Save new ticket          |
| GET    | /ticket/{id}/edit     | TicketController@edit            | Show edit form           |
| POST   | /ticket/{id}/update   | TicketController@update          | Update existing ticket   |
| POST   | /ticket/{id}/delete   | TicketController@destroy         | Delete ticket            |

## Views

### Index View (index.blade.php)

- Lists all tickets in the system
- Provides search functionality for finding tickets by title or description
- Includes filters for status (Open, In Progress, Closed) and priority (Low, Medium, High)
- Shows ticket title, priority, and status with color-coded badges
- Provides links to edit and delete each ticket
- Shows success messages after operations

### Create View (create.blade.php)

- Form to create a new ticket with the following fields:
  - Title (text input)
  - Description (textarea)
  - Priority (dropdown: Low, Medium, High)
- Submit button to save the ticket
- Cancel link to return to index

### Edit View (edit.blade.php)

- Form to edit existing ticket with the following fields:
  - Title (text input)
  - Description (textarea)
  - Priority (dropdown: Low, Medium, High)
  - Status (dropdown: Open, In Progress, Closed)
- Submit button to update the ticket
- Cancel link to return to index

## New Feature: Search and Filtering

### Search Functionality

- Users can search for tickets by entering keywords that match ticket titles or descriptions
- Search is case-insensitive and matches partial text
- The search form is located at the top of the index page

### Filtering Options

- **Status Filter**: Filter tickets by their current status (Open, In Progress, Closed)
- **Priority Filter**: Filter tickets by their priority level (Low, Medium, High)
- **Default Sorting**: Tickets are sorted by creation date (newest first)

### Implementation Details

The search and filtering functionality is implemented in the `index()` method of the `TicketController`:

```php
public function index(Request $request)
{
    $query = Ticket::query();

    // Search by keyword (title or description)
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', "%$searchTerm%")
              ->orWhere('description', 'LIKE', "%$searchTerm%");
        });
    }

    // Filter by status (Open, In Progress, Closed)
    if ($request->has('status') && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    // Filter by priority (Low, Medium, High)
    if ($request->has('priority') && $request->priority != 'all') {
        $query->where('priority', $request->priority);
    }

    // Sort by date (Newest First)
    $query->orderBy('created_at', 'desc');

    // Get the filtered tickets
    $tickets = $query->get();

    return view('tickets.index', compact('tickets'));
}
```

## Installation Guide

1. Clone or download the project files to your server
2. Install dependencies:
   ```bash
   composer install
   ```
3. Copy .env.example to .env and configure database settings:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ticketsystem
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```
4. Create the 'ticketsystem' database in MySQL
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Configure session driver in .env:
   ```
   SESSION_DRIVER=file  # or database if you prefer
   ```
7. Generate application key:
   ```bash
   php artisan key:generate
   ```
8. Start the development server:
   ```bash
   php artisan serve
   ```
9. Access the application at http://127.0.0.1:8000

## Usage Guide

### Creating a New Ticket
1. Click "Create New Ticket" on the home page
2. Fill in the title, description, and select priority
3. Click the "Create Ticket" button
4. System will display the new ticket in the list with a success message

### Searching for Tickets
1. Enter keywords in the search box at the top of the page
2. The system will find tickets with titles or descriptions containing your search terms
3. Results update automatically when you click the Search button

### Filtering Tickets
1. Use the Status dropdown to filter by Open, In Progress, or Closed tickets
2. Use the Priority dropdown to filter by Low, Medium, or High priority
3. Combine search and filters to narrow down results further

### Editing a Ticket
1. Click "Edit" next to the ticket you want to modify
2. Update any of the fields (title, description, priority, status)
3. Click the "Update Ticket" button
4. System will display the updated ticket in the list with a success message

### Deleting a Ticket
1. Click "Delete" next to the ticket you want to remove
2. Confirm the deletion when prompted
3. System will remove the ticket and display a success message

## Troubleshooting

### Sessions Table Error
If you receive an error about the sessions table not existing:
1. Run `php artisan session:table` to create the migration
2. Run `php artisan migrate` to create the table
3. Or change SESSION_DRIVER to 'file' in your .env file

### Missing PHP Extensions
If you receive errors about missing PHP extensions:
1. Open your php.ini file
2. Uncomment the following lines by removing the semicolon (;):
   ```
   extension=pdo_mysql
   extension=mysqli
   extension=fileinfo
   ```
3. Restart your PHP server

### Database Connection Issues
1. Verify your MySQL service is running
2. Check the credentials in your .env file
3. Ensure your database exists with the correct name

## Security Considerations

- CSRF protection is enabled for all forms using the `@csrf` directive
- Input validation is implemented for all form submissions
- Error messages are properly handled and displayed
- Search input is sanitized to prevent SQL injection

## Future Enhancements

- User authentication system
- Email notifications for ticket updates
- File attachments for tickets
- Comment system for ticket discussions
- Dashboard with ticket statistics
- Ticket assignment to specific users
- Advanced search options (date ranges, multiple statuses)
- Export functionality (CSV, PDF)

Similar code found with 1 license type