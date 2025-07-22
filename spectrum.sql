-- Drop and recreate the database for a clean setup
DROP DATABASE IF EXISTS spectrum_db;
CREATE DATABASE spectrum_db;
USE spectrum_db;

-- Users table (for login system & member details)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    post VARCHAR(100),  -- Position in Spectrum (e.g., President, Member)
    password_hash VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    role ENUM('admin','member') DEFAULT 'member'
);

-- Events table (for upcoming/past events)
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    image_url VARCHAR(255)
);

-- Blog posts table (for articles/news)
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Team members table (for team page)
CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100),
    photo_url VARCHAR(255)
);

-- Contact messages table (for storing contact form submissions)
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a sample admin user (password: admin123)
INSERT INTO users (username, email, post, password_hash, role)
VALUES 
('admin', 'admin@spectrum.com', 'President', MD5('admin123'), 'admin');

-- Insert a sample member
INSERT INTO users (username, email, post, password_hash, role)
VALUES 
('johndoe', 'john@spectrum.com', 'Member', MD5('password123'), 'member');

-- Insert a sample event
INSERT INTO events (title, description, event_date, image_url)
VALUES 
('Welcome Event', 'Kickoff event for Spectrum club members.', '2025-08-01', 'images/event1.jpg');

-- Insert a sample blog post
INSERT INTO blog_posts (title, content, author)
VALUES 
('Hello from Spectrum', 'This is the first blog post for Spectrum website!', 'Admin');

-- Insert sample team members
INSERT INTO team_members (name, role, photo_url)
VALUES
('John Doe', 'President', 'images/john.jpg'),
('Jane Smith', 'Vice President', 'images/jane.jpg');

-- Insert a sample contact message
INSERT INTO contact_messages (name, email, message)
VALUES ('Test User', 'test@example.com', 'This is a sample contact message.');
