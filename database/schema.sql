-- CourseHub database schema
-- Run this file in phpMyAdmin / MySQL Workbench / mysql CLI

CREATE DATABASE IF NOT EXISTS coursehub_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE coursehub_db;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(120) NOT NULL,
    description TEXT,
    duration_weeks INT NOT NULL
);

CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_enrollment_student
        FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_enrollment_course
        FOREIGN KEY (course_id)
        REFERENCES courses(id)
        ON DELETE CASCADE,

    UNIQUE (student_id, course_id)
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Sample data

INSERT INTO students (full_name, email, phone) VALUES
('Amina Dlamini', 'amina@example.com', '0710000001'),
('Thabo Nkosi', 'thabo@example.com', '0710000002');

INSERT INTO courses (course_name, description, duration_weeks) VALUES
('Web Development', 'PHP and web fundamentals', 8),
('Database Fundamentals', 'Relational database concepts', 6);

INSERT INTO enrollments (student_id, course_id) VALUES
(1, 1),
(2, 2);
