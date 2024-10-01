Basic Level:
1. Task Management System
Problem: Build a task management system using core PHP. The system should allow users to add, edit, delete, and view tasks. Each task should have a title (required) and description (optional). The system must ensure no duplicate task titles.

Features:
Task title (required) and description (optional)
Add task: JSON data via POST
Edit task: Task title and description can be updated
Delete task: Remove a task by its id
View all tasks: Display all tasks
No duplicate task titles allowed
Logic:

Database Setup: Create a tasks table with fields: id, title, description.
Duplicate Validation: When adding a task, check if the title already exists. If yes, return an error message.
CRUD Operations: Use core PHP functions to handle adding, editing, deleting, and displaying tasks.
