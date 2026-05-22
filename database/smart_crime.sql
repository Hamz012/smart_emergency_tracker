CREATE DATABASE smart_crime;

USE smart_crime;

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nama VARCHAR(100),

    email VARCHAR(100),

    password VARCHAR(255),

    role ENUM('user','admin') DEFAULT 'user'

);

CREATE TABLE polisi (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nama VARCHAR(100),

    latitude VARCHAR(100),

    longitude VARCHAR(100),

    status_online ENUM('online','offline') DEFAULT 'offline'

);

CREATE TABLE laporan (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT,

    polisi_id INT,

    latitude VARCHAR(100),

    longitude VARCHAR(100),

    kecepatan VARCHAR(50),

    status VARCHAR(100),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);