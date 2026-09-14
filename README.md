# Student Expense Tracker

A simple PHP OOP CRUD system for a short academic project. It stores data in a local JSON file, so no database server is required.

## Requirements
- PHP 8+
- A web browser

## Setup and Run

1. Open PowerShell in the `Student_Expense_Tracker` folder.
2. Make sure PHP can write to the `data` folder.
3. Start PHP's built-in web server:

```powershell
php -S localhost:8000
```

4. Open [http://localhost:8000](http://localhost:8000) in your browser.
5. Demo login:
   - Username: `student`
   - Password: `password`

Keep the PowerShell window open while using the system. Press `Ctrl+C` to stop the server.

No XAMPP, Apache, MySQL, or database server is required.

## Main modules
- Login/Register
- Dashboard
- Add Expense
- View/Search/Filter Expenses
- Edit Expense
- Delete Expense
- Category management
- Reports
- Profile and password

## Four OOP pillars
- Encapsulation: private/protected properties and methods inside classes.
- Abstraction: `Model` is an abstract base class defining CRUD methods.
- Inheritance: `Student` and `Admin` extend `User`.
- Polymorphism: `getDashboardTitle()` can be implemented differently by Student/Admin.

## Storage

The application uses `data/data.json` for persistence. The `Storage` class handles reading, writing, and IDs; the domain models contain the application rules. Delete the contents of that file to reset the demo data, then restore the original seed if needed.

## Notes
This is an academic starter project. Before production use, add CSRF protection, stronger authorization rules, pagination, audit logging, and more robust validation.
