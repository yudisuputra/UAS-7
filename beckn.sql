-- =========================
-- DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS db_api;
USE db_api;

-- =========================
-- ROLES (RBAC)
-- =========================
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20) NOT NULL UNIQUE
);

INSERT INTO roles (name) VALUES
('admin'),
('guru'),
('siswa');

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role_id INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Password plaintext:
-- admin123 | guru123 | siswa123

INSERT INTO users (username, password_hash, role_id) VALUES
(
  'admin1',
  '$2y$10$Y9m9q8C5Y9uN1Gz5n9kU4uZP3x3MZ0N7A1E0cXx8cKk9N6FqY5pV2',
  1
),
(
  'guru1',
  '$2y$10$2c8H0yE7V7Zp6MZ8D4HkI8q1vQK6fF0Yz1r0xQJ1lN0xP9bH5J2i',
  2
),
(
  'siswa1',
  '$2y$10$X1nY3bR7Qk0J6Y1P7NQ0J3x3n5C8F8X4G5L9J7nM0C8E1N6B7Y2',
  3
);

-- =========================
-- SISWA
-- =========================
CREATE TABLE siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kelas VARCHAR(20) NOT NULL,
  nis VARCHAR(30) NOT NULL UNIQUE,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO siswa (nama, kelas, nis, user_id) VALUES
('Budi Santoso', 'XII IPA 1', '2023001', 3);

-- =========================
-- MATA PELAJARAN
-- =========================
CREATE TABLE mata_pelajaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_mapel VARCHAR(100) NOT NULL,
  kode_mapel VARCHAR(20) NOT NULL UNIQUE,
  guru_id INT NOT NULL,
  FOREIGN KEY (guru_id) REFERENCES users(id)
);

INSERT INTO mata_pelajaran (nama_mapel, kode_mapel, guru_id) VALUES
('Matematika', 'MAT101', 2);

-- =========================
-- NILAI
-- =========================
CREATE TABLE nilai (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT NOT NULL,
  mapel_id INT NOT NULL,
  tugas DECIMAL(5,2) NOT NULL,
  uts DECIMAL(5,2) NOT NULL,
  uas DECIMAL(5,2) NOT NULL,
  FOREIGN KEY (siswa_id) REFERENCES siswa(id),
  FOREIGN KEY (mapel_id) REFERENCES mata_pelajaran(id)
);

INSERT INTO nilai (siswa_id, mapel_id, tugas, uts, uas) VALUES
(1, 1, 85.00, 78.00, 90.00);
