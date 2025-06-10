CREATE DATABASE voting_system;

USE voting_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    email VARCHAR(100),
    aadhar VARCHAR(12),
    image_path VARCHAR(255)
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    party VARCHAR(50),
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
