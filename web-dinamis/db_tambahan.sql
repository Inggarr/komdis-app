-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251108.4354f4b246
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2026 at 01:07 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbkomdis`
--

-- --------------------------------------------------------

--
-- Table structure for table `aturan`
--

DROP TABLE IF EXISTS `aturan`;
CREATE TABLE `aturan` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL DEFAULT 'Ketentuan Umum',
  `isi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `aturan`
--

INSERT INTO `aturan` (`id`, `judul`, `kategori`, `isi`, `created_at`) VALUES
(1, 'Larangan Merokok', 'Ketentuan Umum', 'Gaboleh Merokok sembarangan ', '2026-05-14 18:08:25'),
(2, 'Menguasai Elemen Tanah', 'Ketentuan Umum', 'Harus bisa menguasai setidaknya elemen tanah untuk mejaga HIMAFOR dari cacing tanah ', '2026-05-15 16:27:25'),
(3, 'Dilarang Melarang', 'Kode Etik', 'Melarang tidak di perbolehkan, karena itu ebatasi kebebasan manusia', '2026-05-15 16:28:01'),
(4, 'Fight Club', 'Pelanggaran', 'Jangan melakukan perkelahian tanpa admin', '2026-05-15 16:28:57'),
(5, 'Mabuk Tugas', 'Sanksi', 'Dapat diberi sanksi 5 tahun tanpa AI', '2026-05-15 16:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `thumbnail`, `created_at`) VALUES
(1, 'Inggar Pernah Masuk Penjara', 'Pada suatu ketika inggar terlibat perdagangan narkoboy ddi suatu daerah, dimana dia berhasil di tangkap oleh pihak berwajib', '1778782049_6a060f619f4d7.jpg', '2026-05-14 18:07:29'),
(2, 'Sosialisasi Tata Tertib Anggota Baru HIMAFOR 2026', 'Pada hari Senin, 12 Mei 2026, Komisi Disiplin Himpunan Mahasiswa Informatika (HIMAFOR) mengadakan kegiatan sosialisasi tata tertib bagi anggota baru. Kegiatan ini dilaksanakan di ruang seminar kampus dan dihadiri oleh seluruh calon anggota HIMIF angkatan 2026.\r\n\r\nDalam kegiatan tersebut, Komisi Disiplin menjelaskan mengenai pentingnya menjaga etika, kedisiplinan, serta tanggung jawab dalam berorganisasi. Selain itu, peserta juga diberikan pemahaman terkait aturan kehadiran, sikap dalam forum, dan tata cara penyampaian izin yang baik dan benar.\r\n\r\nKetua Komisi Disiplin menyampaikan bahwa kegiatan ini bertujuan membangun budaya organisasi yang tertib, profesional, dan saling menghargai antar anggota.', '1778943580_6a08865c9b260.jpg', '2026-05-16 14:51:12'),
(3, 'Komisi Disiplin HIMAFOR Gelar Evaluasi Internal Kepengurusan', 'Komisi Disiplin HIMAFOR melaksanakan evaluasi internal kepengurusan periode 2026 pada Jumat, 9 Mei 2026. Kegiatan ini dilakukan untuk meninjau tingkat kedisiplinan pengurus selama menjalankan program kerja himpunan.\r\n\r\nBeberapa aspek yang dievaluasi meliputi kehadiran rapat, ketepatan waktu pelaksanaan tugas, serta etika komunikasi antar divisi. Hasil evaluasi menunjukkan adanya peningkatan partisipasi aktif pengurus dibandingkan periode sebelumnya.\r\n\r\nMelalui evaluasi ini, Komisi Disiplin berharap seluruh pengurus dapat terus meningkatkan rasa tanggung jawab dan menjaga komitmen organisasi demi terciptanya lingkungan HIMIF yang lebih solid dan profesional.', '1778943570_6a0886527f4d3.jpg', '2026-05-16 14:52:09'),
(4, 'Peringatan Penting Mengenai Etika Penggunaan Media Sosial', 'Komisi Disiplin HIMAFOR mengeluarkan imbauan kepada seluruh anggota untuk lebih bijak dalam menggunakan media sosial. Imbauan tersebut disampaikan melalui forum koordinasi organisasi pada Selasa, 6 Mei 2026.\r\n\r\nDalam penyampaiannya, Komisi Disiplin menekankan bahwa setiap anggota HIMIF diharapkan mampu menjaga nama baik organisasi baik di lingkungan kampus maupun di media sosial. Anggota juga diingatkan untuk menghindari penyebaran informasi hoaks, ujaran kebencian, maupun konflik digital yang dapat merugikan organisasi.\r\n\r\nKegiatan ini menjadi bagian dari upaya membangun citra positif mahasiswa informatika yang berintegritas dan bertanggung jawab di era digital.', '1778943557_6a0886453f3d6.jpg', '2026-05-16 14:52:59'),
(5, 'Kedisiplinan Rapat Pengurus HIMMAFOR', 'Komisi Disiplin Himpunan Mahasiswa Informatika (HIMMAFOR) mengingatkan seluruh pengurus dan anggota untuk menjaga kedisiplinan dalam setiap kegiatan rapat organisasi. Kedisiplinan merupakan salah satu bentuk tanggung jawab dan komitmen bersama demi terciptanya lingkungan organisasi yang profesional dan kondusif.\r\n\r\nBeberapa poin penting yang perlu diperhatikan dalam pelaksanaan rapat antara lain:\r\n\r\nHadir tepat waktu sesuai jadwal yang telah ditentukan.\r\nMenggunakan pakaian yang sopan dan rapi selama kegiatan berlangsung.\r\nMenjaga etika berbicara dan menghargai pendapat peserta lain.\r\nTidak meninggalkan forum tanpa izin yang jelas.\r\nMengisi daftar hadir sebagai bentuk administrasi organisasi.\r\nMenyampaikan izin apabila tidak dapat hadir, maksimal sebelum rapat dimulai.\r\n\r\nKomisi Disiplin juga akan melakukan monitoring terhadap tingkat kehadiran dan partisipasi anggota dalam setiap rapat kerja maupun forum resmi HIMAFOR. Evaluasi kedisiplinan akan menjadi bahan penilaian internal guna meningkatkan kualitas organisasi ke depannya.', '1778943314_6a0885525eee1.jpg', '2026-05-16 14:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `bukti`
--

DROP TABLE IF EXISTS `bukti`;
CREATE TABLE `bukti` (
  `id` int NOT NULL,
  `laporan_id` int NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `bukti`
--

INSERT INTO `bukti` (`id`, `laporan_id`, `nama_file`, `uploaded_at`) VALUES
(1, 2, '6a073a0a6152a_1778858506.jpg', '2026-05-15 15:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `pertanyaan`, `jawaban`, `created_at`) VALUES
(1, 'Kenapa ya?', 'Karena ada di berbagai daerah', '2026-05-14 18:08:39'),
(2, 'Ya nda tau', 'Kenapa nda tau?', '2026-05-16 12:10:57'),
(3, 'Bingung Aku', 'Sama', '2026-05-16 12:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_aturan`
--

DROP TABLE IF EXISTS `kategori_aturan`;
CREATE TABLE `kategori_aturan` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `kategori_aturan`
--

INSERT INTO `kategori_aturan` (`id`, `nama_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Ketentuan Umum', NULL, '2026-05-15 16:22:50'),
(2, 'Pelanggaran', NULL, '2026-05-15 16:22:50'),
(3, 'Sanksi', NULL, '2026-05-15 16:22:50'),
(4, 'Kode Etik', NULL, '2026-05-15 16:22:50');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

DROP TABLE IF EXISTS `laporan`;
CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `kronologi` text,
  `lokasi` varchar(100) DEFAULT NULL,
  `status` enum('pending','ditinjau','diproses','selesai','ditolak') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `judul`, `kategori`, `kronologi`, `lokasi`, `status`, `created_at`) VALUES
(1, 3, 'Pemalakan Anggota Himpunan Oleh Preman Pasar ', 'Pelanggaran Etika', 'Gatau pokonya tiba tiba ada orang datang minta duit', 'Pasar Majasem', 'ditolak', '2026-05-15 15:07:40'),
(2, 3, 'Pemalakan Anggota Himpunan Oleh Preman Pasar ', 'Pelanggaran Etika', 'Gatau pokonya tiba tiba ada orang datang minta duit', 'Pasar Majasem', 'selesai', '2026-05-15 15:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

DROP TABLE IF EXISTS `notifikasi`;
CREATE TABLE `notifikasi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `pesan` text,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `pesan`, `status`, `created_at`) VALUES
(1, 3, 'Laporan Anda telah berhasil dikirim dan sedang menunggu proses.', 'unread', '2026-05-15 15:21:46'),
(2, 3, 'Laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" mendapat tanggapan dari admin.', 'unread', '2026-05-15 15:23:32'),
(3, 3, 'Status laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" telah diperbarui menjadi: pending.', 'unread', '2026-05-15 15:23:38'),
(4, 3, 'Status laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" telah diperbarui menjadi: diproses.', 'unread', '2026-05-15 15:24:22'),
(5, 3, 'Status laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" telah diperbarui menjadi: pending.', 'unread', '2026-05-15 15:24:33'),
(6, 3, 'Status laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" telah diperbarui menjadi: ditolak.', 'unread', '2026-05-15 15:24:46'),
(7, 3, 'Status laporan \"Pemalakan Anggota Himpunan Oleh Preman Pasar \" telah diperbarui menjadi: selesai.', 'unread', '2026-05-15 16:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

DROP TABLE IF EXISTS `pengumuman`;
CREATE TABLE `pengumuman` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `pin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `pin`, `created_at`) VALUES
(1, 'RAPAT HIMAFOR', 'Besok akan ada rapat Himpunan Mahasiswa Informatika', 1, '2026-05-14 18:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

DROP TABLE IF EXISTS `tanggapan`;
CREATE TABLE `tanggapan` (
  `id` int NOT NULL,
  `laporan_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `isi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `tanggapan`
--

INSERT INTO `tanggapan` (`id`, `laporan_id`, `admin_id`, `isi`, `created_at`) VALUES
(1, 2, 6, 'Baik akan segera kami proses', '2026-05-15 15:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `divisi` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('aktif','suspended') DEFAULT 'aktif',
  `foto` varchar(255) DEFAULT ''
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `nim`, `divisi`, `jabatan`, `password`, `role`, `status`, `foto`) VALUES
(2, 'sibonn', '123', 'DELTA', 'admin', '$2y$10$esTLd7ekjZZ2AypVKtpX0.Y0gswB02Kiz8ZyCF1YksQYCQ3wwIsfm', 'user', 'aktif', ''),
(3, 'sibon', '222', 'DELTA', 'user', '$2y$10$iUvzXNRVu0YIq.bYAn/Lp.yrJzRi0h3eA2t3OtXtKgBFupnSnKUl.', 'user', 'aktif', '1778936888_3.jpg'),
(6, 'Admin Komdis', 'ADMIN001', 'Komdis', 'Ketua Komdis', '$2y$10$KSC1HdYJC54MjK/ZAHdepe42EY1qotBW4xUd3L/ULcednM8TqzC7S', 'admin', 'aktif', ''),
(8, 'Inggar', '2388010052', 'KADEP', NULL, '$2y$10$Fl.aN4JQdSoF2R8JuU0gzuuqPfOOnvW1LqPAN1Ci5/cAPBLFf5L7W', 'admin', 'aktif', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bukti`
--
ALTER TABLE `bukti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_aturan`
--
ALTER TABLE `kategori_aturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aturan`
--
ALTER TABLE `aturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bukti`
--
ALTER TABLE `bukti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_aturan`
--
ALTER TABLE `kategori_aturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
