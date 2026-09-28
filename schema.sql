CREATE DATABASE IF NOT EXISTS appdb;
CREATE USER IF NOT EXISTS 'appuser'@'localhost' IDENTIFIED BY 'apppass';
GRANT ALL ON appdb.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE appdb;

CREATE TABLE IF NOT EXISTS clients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(40) DEFAULT '',
  note VARCHAR(255) DEFAULT ''
);

INSERT INTO clients (name, phone, note) VALUES
('Ada Okonkwo', '08031112222', 'Incorporation'),
('Chinedu Bello', '08053334444', 'Tenancy');
