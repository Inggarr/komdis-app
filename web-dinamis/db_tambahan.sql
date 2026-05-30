-- ============================================================
-- SQL LENGKAP untuk dbkomdis
-- Jalankan di phpMyAdmin > pilih database dbkomdis > tab SQL
-- ============================================================

-- ==============================
-- TABEL: users
-- ==============================
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL UNIQUE,
  `divisi` varchar(100) DEFAULT '',
  `jabatan` varchar(100) DEFAULT '',
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tambah kolom yang mungkin belum ada (aman dijalankan berulang)
ALTER TABLE `users`
  MODIFY COLUMN `role` enum('admin','user') NOT NULL DEFAULT 'user';

-- Tambah kolom status jika belum ada
ALTER TABLE `users` ADD COLUMN `status` varchar(20) NOT NULL DEFAULT 'aktif';
ALTER TABLE `users` ADD COLUMN `divisi` varchar(100) DEFAULT '';
ALTER TABLE `users` ADD COLUMN `jabatan` varchar(100) DEFAULT '';
ALTER TABLE `users` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT current_timestamp();

-- ==============================
-- TABEL: laporan
-- ==============================
CREATE TABLE IF NOT EXISTS `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `kronologi` text NOT NULL,
  `lokasi` varchar(255) DEFAULT '',
  `status` enum('pending','diproses','ditinjau','selesai','ditolak') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_laporan_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `laporan` ADD COLUMN `lokasi` varchar(255) DEFAULT '';
ALTER TABLE `laporan` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT current_timestamp();

-- ==============================
-- TABEL: bukti
-- ==============================
CREATE TABLE IF NOT EXISTS `bukti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laporan_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `laporan_id` (`laporan_id`),
  CONSTRAINT `fk_bukti_laporan` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `bukti` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT current_timestamp();

-- ==============================
-- TABEL: tanggapan
-- ==============================
CREATE TABLE IF NOT EXISTS `tanggapan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `laporan_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `isi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `laporan_id` (`laporan_id`),
  CONSTRAINT `fk_tanggapan_laporan` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tanggapan` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT current_timestamp();

-- ==============================
-- TABEL: notifikasi
-- ==============================
CREATE TABLE IF NOT EXISTS `notifikasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_notifikasi_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `notifikasi` ADD COLUMN `is_read` tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE `notifikasi` ADD COLUMN `created_at` timestamp NOT NULL DEFAULT current_timestamp();

-- ==============================
-- TABEL: berita
-- ==============================
CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==============================
-- TABEL: pengumuman
-- ==============================
CREATE TABLE IF NOT EXISTS `pengumuman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `pin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==============================
-- TABEL: aturan
-- ==============================
CREATE TABLE IF NOT EXISTS `aturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL DEFAULT 'Ketentuan Umum',
  `isi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==============================
-- TABEL: faq
-- ==============================
CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==============================
-- AKUN ADMIN DEFAULT
-- Password: admin123
-- ==============================
INSERT IGNORE INTO `users` (nama, nim, divisi, jabatan, password, role, status)
VALUES (
  'Admin Komdis',
  'ADMIN001',
  'Komdis',
  'Ketua Komdis',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin',
  'aktif'
);

-- CATATAN: password default admin adalah "password"
-- Ganti segera setelah login pertama!
-- Atau jalankan ini untuk password custom (admin123):
-- UPDATE users SET password = '$2y$10$YRv/R6lOe5yFH4GE68CY8.fCDKL3p/bDgaSS0kDQNH5kI0F.9lW4e' WHERE nim = 'ADMIN001';
