# UI
![image](https://github.com/user-attachments/assets/4b227ef9-0859-4d74-952c-2d0ba4368496)

# SQL 
```sql
CREATE DATABASE manidlangan_crud;

USE manidlangan_crud;

CREATE TABLE students (
    student_id VARCHAR(20) PRIMARY KEY,
    student_name VARCHAR(100),
    contact_number VARCHAR(15),
    sex ENUM('Male', 'Female'),
    address TEXT,
    profile_picture TEXT
);

CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,  
    student_id VARCHAR(20), 
    date DATE,
    status ENUM('Present', 'Absent', 'Late', 'Excuse'),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
        ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);
```
