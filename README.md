<h1>Basic Level:</h1>
1. Task Management System</br>
Problem: Build a task management system using core PHP. The system should allow users to add, edit, delete, and view tasks. Each task should have a title (required) and description (optional). The system must ensure no duplicate task titles.</br>

Features:</br>
Task title (required) and description (optional)</br>
Add task: JSON data via POST</br>
Edit task: Task title and description can be updated</br>
Delete task: Remove a task by its id</br>
View all tasks: Display all tasks</br>
No duplicate task titles allowed</br>

Logic:</br>
Database Setup: Create a tasks table with fields: id, title, description.</br>
Duplicate Validation: When adding a task, check if the title already exists. If yes, return an error message.</br>
CRUD Operations: Use core PHP functions to handle adding, editing, deleting, and displaying tasks.</br>
