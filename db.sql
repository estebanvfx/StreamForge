CREATE DATABASE StreamForge;

USE StreamForge;

CREATE TABLE users (
    user_id INT PRIMARY KEY,
    mail VARCHAR(100) UNIQUE,
    passhash VARCHAR(140),
    user_role ENUM('admin', 'user'),
    user_status TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE temp_accounts (
    id INT PRIMARY KEY,
    account_email VARCHAR(100),
    account_password VARCHAR(100),
    account_type VARCHAR(100)
);

CREATE TABLE bank_accounts (
    account_id INT PRIMARY KEY,
    account_email VARCHAR(100),
    account_password VARCHAR(100),
    account_type VARCHAR(100)
);

CREATE TABLE music_urls (
    id INT PRIMARY KEY,
    url VARCHAR(255),
    url_type VARCHAR(100)
);
