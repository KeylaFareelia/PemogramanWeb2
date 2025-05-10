
-- Buat database dbsiak (jika belum ada)
CREATE DATABASE IF NOT EXISTS dbsiak;
USE dbsiak;

DROP TABLE IF EXISTS pasien;

CREATE TABLE pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tmp_lahir VARCHAR(50),
    tgl_lahir DATE,
    gender ENUM('L','P') NOT NULL,
    kelurahan VARCHAR(100),
    email VARCHAR(100),
    alamat TEXT
);


-- Contoh data dummy (opsional)
INSERT INTO pasien (kode, nama, tmp_lahir, tgl_lahir, gender, klurahan, email, alamat) VALUES
('A002', 'Sagara Dewansa', 'Jakarta', '1997-02-14', 'Laki-laki', 'Hilir', 'Saga@mail.com', 'Jl. Mawar No.1'),
('A003', 'Kaluna Qiani', 'Surabaya', '1999-04-14', 'Perempuan', 'Putat', 'Qiani@mail.com', 'Jl. Tulip No.14');
