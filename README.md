# Student Expense Tracker

A simple PHP + MySQL OOP CRUD system for a short academic project.

## Requirements
- XAMPP/WAMP/LAMP
- PHP 8+
- MySQL/MariaDB
- PDO MySQL extension

## Setup
1. Copy the `student-expense-tracker` folder into `htdocs` (XAMPP).
2. Start Apache and MySQL.
3. Open phpMyAdmin.
4. Import `database.sql`.
5. Check `config/Database.php` and change the MySQL username/password if needed.
6. Visit `http://localhost/student-expense-tracker/`.
7. Demo login:
   - Username: `student`
   - Password: `password`

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

## Notes
This is an academic starter project. Before production use, add CSRF protection, stronger authorization rules, pagination, audit logging, and more robust validation.
