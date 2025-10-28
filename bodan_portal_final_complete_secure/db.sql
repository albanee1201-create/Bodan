-- db.sql - run this in phpMyAdmin or mysql
CREATE DATABASE IF NOT EXISTS bodan_portal_db;
USE bodan_portal_db;

-- admins
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- teachers
CREATE TABLE IF NOT EXISTS teachers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  subject VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- students
CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  class VARCHAR(50),
  session_year VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- announcements
CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  body TEXT NOT NULL,
  posted_by VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- results
CREATE TABLE IF NOT EXISTS results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_email VARCHAR(100) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    score INT NOT NULL,
    grade CHAR(2) NOT NULL,
    term VARCHAR(20) NOT NULL,
    session VARCHAR(20) NOT NULL,
    remark TEXT,
    teacher_email VARCHAR(100),
    date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- payments
CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_email VARCHAR(150) NOT NULL,
  items TEXT NOT NULL,
  amount_kobo BIGINT NOT NULL,
  reference VARCHAR(255) UNIQUE,
  status VARCHAR(50) DEFAULT 'pending',
  paystack_response TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- attendance
CREATE TABLE IF NOT EXISTS attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_email VARCHAR(150) NOT NULL,
  class VARCHAR(50),
  date DATE NOT NULL,
  status ENUM('present','absent','late') DEFAULT 'present',
  marked_by VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- messages (simple messaging between teacher and student)
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_email VARCHAR(150) NOT NULL,
  receiver_email VARCHAR(150) NOT NULL,
  subject VARCHAR(255),
  body TEXT,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- file uploads (assignments, notes, results files)
CREATE TABLE IF NOT EXISTS uploads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  uploaded_by VARCHAR(150),
  filename VARCHAR(255),
  filepath VARCHAR(255),
  filetype VARCHAR(100),
  description TEXT,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- seed a default admin (email: admin@bodan.edu / password: 123)
-- WARNING: change this password after install. The seed below uses MD5 for quick demo: replace with password_hash() in production
INSERT INTO admins (name, email, password) VALUES
('Super Admin','admin@bodan.edu', '202cb962ac59075b964b07152d234b70'); -- md5('123')

-- You should create proper passwords with PASSWORD_HASH in your environment after import.
