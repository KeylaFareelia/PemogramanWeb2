
-- Buat database dbsiak (jika belum ada)
CREATE DATABASE IF NOT EXISTS dbsiak;
USE dbsiak;

-- Buat tabel pasien
CREATE TABLE IF NOT EXISTS pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL,
    nama VARCHAR(45) NOT NULL,
    tmp_lahir VARCHAR(30),
    tgl_lahir DATE,
    gender CHAR(1),
    email VARCHAR(100),
    alamat VARCHAR(100),
    klurahan VARCHAR(100)
);

-- Contoh data dummy (opsional)
INSERT INTO pasien (kode, nama, tmp_lahir, tgl_lahir, gender, klurahan, email, alamat) VALUES
('A002', 'Sagara Dewansa', 'Jakarta', '1997-02-14', 'Laki-laki', 'Hilir', 'Saga@mail.com', 'Jl. Mawar No.1'),
('A003', 'Kaluna Qiani', 'Surabaya', '1999-04-14', 'Perempuan', 'Putat', 'Qiani@mail.com', 'Jl. Tulip No.14');
