# Web development 1 project


## Authors

- [Viacheslav Onishchenko 704453]



## Login

#### Admin account

login: artur@gmail.com \
password: artur123

#### User account

login: dima@gmail.com \
password: dima123

## SQL script

```bash
-- 1. USERS TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    phone_number VARCHAR(50) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. HAIRDRESSERS TABLE
CREATE TABLE IF NOT EXISTS hairdressers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(50) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    specialization VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. APPOINTMENTS TABLE
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hairdresser_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status VARCHAR(50) DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (hairdresser_id) REFERENCES hairdressers(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Insert demo users
INSERT INTO users (email, username, password, phone_number, address, profile_picture, is_admin)
VALUES
('alice@example.com', 'alice', '$2y$10$HJ0AWiv8x.BAk47NHFz.h.v7lf7H6sY7O5WpAnJC8GVTKp67kmYOm', '1234567890', '123 Main St', NULL, 0),
('bob@example.com', 'bob', '$2y$10$MdrNVPEaCt3cktuXRx.tH.LuCtaXfTNeCYQETcqFKv58QXYfjP7XO', '0987654321', '456 Oak St', '/uploads/bob.jpg', 0),
('admin@example.com', 'admin', '$2y$10$gNfIBkCpkovvQXvbOf6Ww.3Y/tj5Q.HEy6ISwdTFkH1lCDuPVOOdW', '5555555555', 'Admin HQ', NULL, 1);

-- Insert demo hairdressers
INSERT INTO hairdressers (email, name, password, phone_number, address, profile_picture, specialization)
VALUES
('mary@example.com', 'Mary', '$2y$10$KK0AWiv8x.BAk47NHFz.h.v7lf7H6sY7O5WpAnJC8GVTKp67kmYOm', '1112223333', '789 Pine Ave', NULL, 'Coloring'),
('dan@example.com', 'Daniel', '$2y$10$SdrNVPEaCt3cktuXRx.tH.LuCtaXfTNeCYQETcqFKv58QXYfjP7XO', '2223334444', '12th St, Suite 101', '/uploads/dan.png', 'Styling'),
('emma@example.com', 'Emma', '$2y$10$gNfIBkCpkovvQXvbOf6Ww.3Y/tj5Q.HEy6ISwdTFkH1lCDuPVOOdW', '3334445555', 'Apt 12, Maple Rd', NULL, 'Haircutting');

```