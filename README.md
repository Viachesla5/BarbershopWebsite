# Web development 1 project - Barbershop Website
https://github.com/Viachesla5/BarbershopWebsite

## Student Information

- [Viacheslav Onishchenko 704453]

## Features

#### For Clients
- Create and manage personal accounts
- Browse available hairdressers and their specializations
- Book appointments with preferred hairdressers
- View upcoming appointments
- Personal profile management with customizable profile pictures

#### For Hairdressers
- Personal profile management
- View and their appointment schedule
- View other hairdressers' profiles

#### For Administrators
- Complete system management
- User profile management
- Hairdresser profile management
- Appointment monitoring and management

#### Security Features
- Secure user authentication
- Password encryption
- Rate limiting to prevent abuse
- CSRF protection
- Input sanitization
- Secure session management



## Login

#### Admin account

login: admin@gmail.com \
password: Admin!123

#### User account

login: bober@gmail.com \
password: Bober!123

## Database Access

#### phpMyAdmin credentials
- URL: localhost:8080
- login: developer
- password: secret123

#### Usage
1. Open a terminal in the project root directory
2. Run the following command to start the database:
   ```bash
   docker-compose up
   ```
3. Once the containers are running, you can access phpMyAdmin at http://localhost:8080



## SQL script - Create Database

```bash
CREATE DATABASE IF NOT EXISTS developmentdb;
USE developmentdb;
```

```bash
-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    address TEXT,
    profile_picture VARCHAR(255),
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create hairdressers table
CREATE TABLE hairdressers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20),
    address TEXT,
    profile_picture VARCHAR(255),
    specialization VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hairdresser_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status VARCHAR(50) DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (hairdresser_id) REFERENCES hairdressers(id) ON DELETE CASCADE
);
```
## SQL script - Insert Data

```bash
-- Insert Admin User
INSERT INTO users (email, username, password, is_admin, profile_picture) VALUES
('admin@gmail.com', 'Sherlock', '$2y$12$Ry2Tuh42KfqH7/qVl8Nxoe/b68EDquFrKUSsWm9WPwS1LXfhvpVKu', TRUE, '/uploads/profile_pictures/profile_67f18e0b9d277.jpg'); -- password: Admin!123

-- Insert Regular Users (passwords should be hashed in real application)
INSERT INTO users (email, username, password, phone_number, address) VALUES
('bober@gmail.com', 'Bober', '$2y$12$krpOHbBIjHRcW9mpiuXztu5aqKG2oASAgb7qpz.VtlbZ2ArFQvT6O', '+31612345678', 'Amsterdam Street 1'), -- password: Bober!123
('eva@gmail.com', 'Eva', '$2y$12$ezn4aGg8O03zQ4QlqNfHLOv4FNyz9KmeOjHNg6rHPbVOOCmEjsLMC', '+31634567890', 'Utrecht Road 3'), -- password: EvaEva!123
('puss@gmail.com', 'Puss', '$2y$12$cebOsDfcfmO3ye6pNJPgCu7.UXtdSS3SUY67q9aQHWwaqeHczn8V.', '+31689012345', 'Breda Lane 8'); -- password: Puss!123

-- Insert Hairdressers
INSERT INTO hairdressers (email, name, password, phone_number, address, specialization, profile_picture) VALUES
('olenka@gmail.com', 'Olenka', '$2y$12$7AiTXwh3oy0u2F7UnjZJ7.IXZxv2.wU.pBdSZjoJspnSy1XAFkXHe', '+31690123456', 'Salon Street 1', 'Color Specialist', '/uploads/hairdressers/hairdresser_12_67f18ba89aff1.png'), -- password: Olenka!123
('rafal@gmail.com', 'Rafal', '$2y$12$RM/0qNCZlMa4THWqPNlgPOgfH5r.dT69avxneq8YJI0OONKdjuM.C', '+31601234567', 'Salon Avenue 2', 'Men''s Hair Specialist', '/uploads/hairdressers/hairdresser_13_67f18b8d759c4.png'), -- password: Rafal!123
('cezar@gmail.com', 'Cezar', '$2y$12$2SAuCvIguFqDwJOEcrx/qu6qS3qW/8B4kJCpiHKek.UidNbELZCyS', '+31612345678', 'Salon Road 3', 'Men''s Hair Specialist', '/uploads/hairdressers/hairdresser_14_67f18c86e0c1d.png'); -- password: Cezar!123

```