-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: agrigento-db.id.domainesia.com:3306
-- Waktu pembuatan: 21 Jul 2025 pada 09.05
-- Versi server: 8.0.42-0ubuntu0.24.04.1
-- Versi PHP: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zshotaic_bladeware`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen_users`
--

CREATE TABLE `absen_users` (
  `id` int NOT NULL,
  `id_users` bigint NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absen_users`
--

INSERT INTO `absen_users` (`id`, `id_users`, `created_at`) VALUES
(1, 27, '2025-05-01 09:33:59'),
(5, 26, '2025-05-01 10:34:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `combination_users`
--

CREATE TABLE `combination_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `id_produk` varchar(255) NOT NULL,
  `sequence` int NOT NULL,
  `set_boost` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `combination_users`
--

INSERT INTO `combination_users` (`id`, `id_users`, `id_produk`, `sequence`, `set_boost`, `created_at`, `updated_at`) VALUES
(88, 24, '10', 4, 1, '2025-04-30 07:45:05', '2025-04-30 07:45:05'),
(89, 24, '12', 4, 1, '2025-04-30 07:45:05', '2025-04-30 07:45:05'),
(179, 29, '7', 3, 1, '2025-05-01 16:45:13', '2025-05-01 16:45:13'),
(180, 29, '8', 3, 1, '2025-05-01 16:45:14', '2025-05-01 16:45:14'),
(181, 26, '7', 14, 1, '2025-06-17 12:10:40', '2025-06-17 12:10:40'),
(182, 26, '12', 14, 1, '2025-06-17 12:10:40', '2025-06-17 12:10:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposit_users`
--

CREATE TABLE `deposit_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `deposit_image` text COLLATE utf8mb4_general_ci,
  `network_address` text COLLATE utf8mb4_general_ci,
  `currency` text COLLATE utf8mb4_general_ci,
  `wallet_address` text COLLATE utf8mb4_general_ci,
  `amount` decimal(20,2) NOT NULL,
  `status` int DEFAULT '0',
  `category_deposit` enum('Deposit','Bonus') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `baca` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `deposit_users`
--

INSERT INTO `deposit_users` (`id`, `id_users`, `deposit_image`, `network_address`, `currency`, `wallet_address`, `amount`, `status`, `category_deposit`, `baca`, `created_at`, `updated_at`) VALUES
(216, 30, NULL, '-', '-', '-', 100.00, 1, 'Deposit', 0, '2025-05-01 15:22:13', '2025-05-01 15:22:13'),
(217, 29, NULL, '-', '-', '-', 100.00, 1, 'Deposit', 0, '2025-05-01 15:42:46', '2025-05-01 15:42:46'),
(218, 29, NULL, '-', '-', '-', 100.00, 1, 'Bonus', 0, '2025-05-01 16:24:29', '2025-05-01 16:24:29'),
(219, 24, NULL, '-', '-', '-', 100.00, 1, 'Deposit', 0, '2025-05-01 16:46:58', '2025-05-01 16:46:58'),
(220, 29, NULL, '-', '-', '-', 20000.00, 1, 'Deposit', 0, '2025-05-02 08:43:52', '2025-05-02 08:43:52'),
(221, 29, NULL, '-', '-', '-', 5000.00, 1, 'Bonus', 0, '2025-05-02 08:43:59', '2025-05-02 08:43:59'),
(222, 24, NULL, '-', '-', '-', 174.00, 1, 'Deposit', 0, '2025-06-14 06:31:46', '2025-06-14 06:31:46'),
(223, 24, NULL, '-', '-', '-', 15.00, 1, 'Deposit', 0, '2025-06-17 12:04:03', '2025-06-17 12:04:03'),
(224, 26, NULL, '-', '-', '-', 1500.00, 1, 'Deposit', 0, '2025-06-17 12:04:40', '2025-06-17 12:04:40'),
(225, 26, NULL, '-', '-', '-', 120.00, 1, 'Bonus', 0, '2025-06-17 12:04:50', '2025-06-17 12:04:50'),
(226, 26, NULL, '-', '-', '-', 1500.00, 1, 'Deposit', 0, '2025-06-17 12:05:32', '2025-06-17 12:05:32'),
(227, 26, NULL, '-', '-', '-', 15.00, 1, 'Deposit', 0, '2025-06-17 12:05:53', '2025-06-17 12:05:53'),
(228, 26, NULL, '-', '-', '-', 120.00, 1, 'Bonus', 0, '2025-06-17 12:06:02', '2025-06-17 12:06:02'),
(229, 26, NULL, '-', '-', '-', 9.00, 1, 'Deposit', 0, '2025-06-17 12:11:07', '2025-06-17 12:11:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance_users`
--

CREATE TABLE `finance_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `saldo` decimal(20,2) DEFAULT '0.00',
  `saldo_beku` decimal(20,2) NOT NULL DEFAULT '0.00',
  `saldo_misi` decimal(20,2) NOT NULL DEFAULT '0.00',
  `komisi` decimal(20,5) DEFAULT '0.00000',
  `temp_balance` decimal(20,2) NOT NULL DEFAULT '0.00',
  `price_akhir` decimal(20,2) NOT NULL DEFAULT '0.00',
  `profit_akhir` decimal(20,2) NOT NULL DEFAULT '0.00',
  `withdrawal_password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance_users`
--

INSERT INTO `finance_users` (`id`, `id_users`, `saldo`, `saldo_beku`, `saldo_misi`, `komisi`, `temp_balance`, `price_akhir`, `profit_akhir`, `withdrawal_password`, `created_at`, `updated_at`) VALUES
(1, 1, 100060.76, 0.00, 0.00, 60.76000, 0.00, 0.00, 0.00, '123321', '2025-03-13 14:03:38', '2025-05-24 12:16:26'),
(23, 24, 15.95, 340.48, 1.48, 0.95000, 0.00, 0.00, 12.07, '123456', '2025-04-25 12:37:49', '2025-06-17 12:14:47'),
(24, 25, 65.00, 0.00, 0.00, 0.00000, 0.00, 0.00, 0.00, '123321', '2025-04-25 12:43:38', '2025-04-29 12:10:11'),
(25, 26, 113.77, 0.00, 4.77, 0.00000, 0.00, 0.00, 0.00, '123456', '2025-04-25 16:51:39', '2025-06-17 12:14:47'),
(26, 27, 65.00, 0.00, 0.00, 0.00000, 0.00, 0.00, 0.00, '123321', '2025-04-26 09:19:48', '2025-05-01 11:02:46'),
(28, 29, 25555.38, 0.00, 290.38, 0.00000, 0.00, 0.00, 0.00, '123456', '2025-04-30 08:07:51', '2025-06-27 09:57:38'),
(29, 30, 100.00, 0.00, 0.00, 0.00000, 0.00, 0.00, 0.00, '123456', '2025-05-01 14:33:59', '2025-05-01 15:27:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_admin`
--

CREATE TABLE `log_admin` (
  `id` int UNSIGNED NOT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_admin`
--

INSERT INTO `log_admin` (`id`, `keterangan`, `created_at`, `updated_at`) VALUES
(147, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-27 13:12:39', '2025-04-27 13:12:39'),
(148, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-27 13:12:47', '2025-04-27 13:12:47'),
(149, 'Admin Masmut updated user \"trainingwinter\" Bonus 120.', '2025-04-27 13:12:54', '2025-04-27 13:12:54'),
(150, 'Admin Masmut has logged in.', '2025-04-28 03:41:26', '2025-04-28 03:41:26'),
(151, 'Admin Masmut has logged in.', '2025-04-28 11:45:54', '2025-04-28 11:45:54'),
(152, 'Admin Masmut has logged in.', '2025-04-28 11:56:22', '2025-04-28 11:56:22'),
(153, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 11:57:07', '2025-04-28 11:57:07'),
(154, 'Admin Masmut updated user \"trainingwinter\" Bonus 120.', '2025-04-28 11:57:15', '2025-04-28 11:57:15'),
(155, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-28 11:57:29', '2025-04-28 11:57:29'),
(156, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 12:28:11', '2025-04-28 12:28:11'),
(157, 'Admin Masmut updated user \"trainingwinter\" Bonus 120.', '2025-04-28 12:28:18', '2025-04-28 12:28:18'),
(158, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-28 12:28:26', '2025-04-28 12:28:26'),
(159, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 12:47:42', '2025-04-28 12:47:42'),
(160, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-28 12:48:00', '2025-04-28 12:48:00'),
(161, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-28 12:48:09', '2025-04-28 12:48:09'),
(162, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-28 12:48:20', '2025-04-28 12:48:20'),
(163, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 12:49:20', '2025-04-28 12:49:20'),
(164, 'Admin Masmut updated user \"trainingwinter\" Bonus 200.', '2025-04-28 12:49:38', '2025-04-28 12:49:38'),
(165, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 12:53:53', '2025-04-28 12:53:53'),
(166, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-28 13:21:59', '2025-04-28 13:21:59'),
(167, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 13:47:53', '2025-04-28 13:47:53'),
(168, 'Admin Masmut has logged in.', '2025-04-28 19:34:30', '2025-04-28 19:34:30'),
(169, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 19:43:25', '2025-04-28 19:43:25'),
(170, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 19:52:06', '2025-04-28 19:52:06'),
(171, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 19:52:56', '2025-04-28 19:52:56'),
(172, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 20:04:54', '2025-04-28 20:04:54'),
(173, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 20:10:06', '2025-04-28 20:10:06'),
(174, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-28 20:10:59', '2025-04-28 20:10:59'),
(175, 'Admin Masmut has logged in.', '2025-04-29 05:55:09', '2025-04-29 05:55:09'),
(176, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 05:55:30', '2025-04-29 05:55:30'),
(177, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 05:55:50', '2025-04-29 05:55:50'),
(178, 'Admin Masmut updated user \"trainingwinter\" Bonus 120.', '2025-04-29 05:56:00', '2025-04-29 05:56:00'),
(179, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 06:03:10', '2025-04-29 06:03:10'),
(180, 'Admin Masmut has logged in.', '2025-04-29 07:22:50', '2025-04-29 07:22:50'),
(181, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 07:55:12', '2025-04-29 07:55:12'),
(182, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 07:56:16', '2025-04-29 07:56:16'),
(183, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 07:59:20', '2025-04-29 07:59:20'),
(184, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:00:04', '2025-04-29 08:00:04'),
(185, 'Admin Masmut updated user \"trainingwinter\" Withdrawal.', '2025-04-29 08:00:14', '2025-04-29 08:00:14'),
(186, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:00:38', '2025-04-29 08:00:38'),
(187, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:00:44', '2025-04-29 08:00:44'),
(188, 'Admin Masmut updated user \"trainingwinter\" Bonus 120.', '2025-04-29 08:00:50', '2025-04-29 08:00:50'),
(189, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 08:00:57', '2025-04-29 08:00:57'),
(190, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:05:43', '2025-04-29 08:05:43'),
(191, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-29 08:19:28', '2025-04-29 08:19:28'),
(192, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 08:23:18', '2025-04-29 08:23:18'),
(193, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 08:23:46', '2025-04-29 08:23:46'),
(194, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-29 08:23:54', '2025-04-29 08:23:54'),
(195, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-29 08:26:31', '2025-04-29 08:26:31'),
(196, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-29 08:28:46', '2025-04-29 08:28:46'),
(197, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 08:29:00', '2025-04-29 08:29:00'),
(198, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-29 08:29:00', '2025-04-29 08:29:00'),
(199, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 08:29:34', '2025-04-29 08:29:34'),
(200, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:29:57', '2025-04-29 08:29:57'),
(201, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 08:41:05', '2025-04-29 08:41:05'),
(202, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 08:41:17', '2025-04-29 08:41:17'),
(203, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 08:41:27', '2025-04-29 08:41:27'),
(204, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:41:41', '2025-04-29 08:41:41'),
(205, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-04-29 08:41:47', '2025-04-29 08:41:47'),
(206, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:47:43', '2025-04-29 08:47:43'),
(207, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 08:48:47', '2025-04-29 08:48:47'),
(208, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 09:14:09', '2025-04-29 09:14:09'),
(209, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-04-29 09:14:15', '2025-04-29 09:14:15'),
(210, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 09:14:23', '2025-04-29 09:14:23'),
(211, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 09:14:24', '2025-04-29 09:14:24'),
(212, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 09:14:32', '2025-04-29 09:14:32'),
(213, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 09:14:45', '2025-04-29 09:14:45'),
(214, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 09:15:00', '2025-04-29 09:15:00'),
(215, 'Admin Masmut updated user \"winter\" Withdrawal.', '2025-04-29 09:15:07', '2025-04-29 09:15:07'),
(216, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 09:15:27', '2025-04-29 09:15:27'),
(217, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 09:19:45', '2025-04-29 09:19:45'),
(218, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 09:20:15', '2025-04-29 09:20:15'),
(219, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 10:19:58', '2025-04-29 10:19:58'),
(220, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 10:20:25', '2025-04-29 10:20:25'),
(221, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 10:25:29', '2025-04-29 10:25:29'),
(222, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 10:30:49', '2025-04-29 10:30:49'),
(223, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 10:48:43', '2025-04-29 10:48:43'),
(224, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 11:23:04', '2025-04-29 11:23:04'),
(225, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 11:37:12', '2025-04-29 11:37:12'),
(226, 'Admin Masmut updated user \"masmut\" Deposit.', '2025-04-29 12:02:07', '2025-04-29 12:02:07'),
(227, 'Admin Masmut updated user \"masmut\" Deposit.', '2025-04-29 12:06:09', '2025-04-29 12:06:09'),
(228, 'Admin Masmut has logged in.', '2025-04-29 12:18:33', '2025-04-29 12:18:33'),
(229, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 12:18:47', '2025-04-29 12:18:47'),
(230, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:19:41', '2025-04-29 12:19:41'),
(231, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 12:21:25', '2025-04-29 12:21:25'),
(232, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 12:21:36', '2025-04-29 12:21:36'),
(233, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:26:50', '2025-04-29 12:26:50'),
(234, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:26:52', '2025-04-29 12:26:52'),
(235, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:28:09', '2025-04-29 12:28:09'),
(236, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-04-29 12:33:59', '2025-04-29 12:33:59'),
(237, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:38:53', '2025-04-29 12:38:53'),
(238, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 12:39:03', '2025-04-29 12:39:03'),
(239, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-29 12:41:12', '2025-04-29 12:41:12'),
(240, 'Admin Masmut updated user \"winter\" Deposit.', '2025-04-29 12:43:22', '2025-04-29 12:43:22'),
(241, 'Admin Masmut has added a new user named \"Test Regist\".', '2025-04-29 13:47:08', '2025-04-29 13:47:08'),
(242, 'Admin Masmut has logged in.', '2025-04-29 19:58:03', '2025-04-29 19:58:03'),
(243, 'Admin Masmut has logged in.', '2025-04-30 07:04:10', '2025-04-30 07:04:10'),
(244, 'Admin Masmut has logged in.', '2025-04-30 07:39:20', '2025-04-30 07:39:20'),
(245, 'Admin Masmut has deleted a user named \"Test Regist\".', '2025-04-30 07:43:22', '2025-04-30 07:43:22'),
(246, 'Admin Masmut has added a new user named \"trainingaaaa\".', '2025-04-30 08:07:51', '2025-04-30 08:07:51'),
(247, 'Admin Masmut has edited user \"trainingwinter\" (Changed: Membership).', '2025-04-30 08:23:19', '2025-04-30 08:23:19'),
(248, 'Admin Masmut has edited user \"trainingwinter\" (Changed: Membership).', '2025-04-30 08:23:39', '2025-04-30 08:23:39'),
(249, 'Admin Masmut has edited user \"trainingwinter\" (Changed: Membership).', '2025-04-30 08:23:55', '2025-04-30 08:23:55'),
(250, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:26:53', '2025-04-30 08:26:53'),
(251, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:35:59', '2025-04-30 08:35:59'),
(252, 'Admin Masmut has edited user \"trainingwinter\" (Changed: Membership).', '2025-04-30 08:36:38', '2025-04-30 08:36:38'),
(253, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:42:02', '2025-04-30 08:42:02'),
(254, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:42:13', '2025-04-30 08:42:13'),
(255, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:56:37', '2025-04-30 08:56:37'),
(256, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 08:59:52', '2025-04-30 08:59:52'),
(257, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 09:01:49', '2025-04-30 09:01:49'),
(258, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 09:12:49', '2025-04-30 09:12:49'),
(259, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 09:15:04', '2025-04-30 09:15:04'),
(260, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-04-30 09:15:43', '2025-04-30 09:15:43'),
(261, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 09:47:07', '2025-04-30 09:47:07'),
(262, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-04-30 09:51:35', '2025-04-30 09:51:35'),
(263, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-04-30 09:57:38', '2025-04-30 09:57:38'),
(264, 'Admin Masmut updated user \"trainingaaaa\" Deposit.', '2025-04-30 12:26:30', '2025-04-30 12:26:30'),
(265, 'Admin Masmut updated user \"trainingaaaa\" Bonus.', '2025-04-30 12:26:44', '2025-04-30 12:26:44'),
(266, 'Admin Masmut has logged in.', '2025-04-30 23:16:55', '2025-04-30 23:16:55'),
(267, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-04-30 23:35:34', '2025-04-30 23:35:34'),
(268, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-05-01 01:02:13', '2025-05-01 01:02:13'),
(269, 'Admin Masmut updated user \"masmut2\" Bonus.', '2025-05-01 01:02:26', '2025-05-01 01:02:26'),
(270, 'Admin Masmut has logged in.', '2025-05-01 03:00:50', '2025-05-01 03:00:50'),
(271, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-05-01 03:01:12', '2025-05-01 03:01:12'),
(272, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-05-01 03:07:12', '2025-05-01 03:07:12'),
(273, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-05-01 03:10:42', '2025-05-01 03:10:42'),
(274, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-05-01 03:14:02', '2025-05-01 03:14:02'),
(275, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-05-01 03:18:17', '2025-05-01 03:18:17'),
(276, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-05-01 03:18:30', '2025-05-01 03:18:30'),
(277, 'Admin Masmut has logged in.', '2025-05-01 09:21:58', '2025-05-01 09:21:58'),
(278, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-05-01 09:24:39', '2025-05-01 09:24:39'),
(279, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-05-01 09:31:09', '2025-05-01 09:31:09'),
(280, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-05-01 10:22:14', '2025-05-01 10:22:14'),
(281, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-05-01 10:40:06', '2025-05-01 10:40:06'),
(282, 'Admin Masmut updated user \"masmut2\" Deposit.', '2025-05-01 11:00:38', '2025-05-01 11:00:38'),
(283, 'Admin Masmut has logged in.', '2025-05-01 11:08:30', '2025-05-01 11:08:30'),
(284, 'Admin Masmut has exported user data to Excel.', '2025-05-01 12:38:40', '2025-05-01 12:38:40'),
(285, 'Admin Masmut has logged in.', '2025-05-01 13:24:53', '2025-05-01 13:24:53'),
(286, 'Admin Masmut has added a new user named \"Winwin\".', '2025-05-01 14:33:59', '2025-05-01 14:33:59'),
(287, 'Admin Masmut has edited user \"Winwin\" (Changed: Credibility, Network Address).', '2025-05-01 15:04:12', '2025-05-01 15:04:12'),
(288, 'Admin Masmut updated user \"Winwin\" Deposit.', '2025-05-01 15:22:13', '2025-05-01 15:22:13'),
(289, 'Admin Masmut has edited user \"Winwin\" (Changed: Withdrawal Password).', '2025-05-01 15:23:54', '2025-05-01 15:23:54'),
(290, 'Admin Masmut has edited user \"Winwin\" (Changed: Wallet address).', '2025-05-01 15:27:56', '2025-05-01 15:27:56'),
(291, 'Admin Masmut updated user \"trainingaaaa\" Deposit.', '2025-05-01 15:42:46', '2025-05-01 15:42:46'),
(292, 'Admin Masmut has edited user \"trainingaaaa\" (Changed: Wallet address, Network Address, Withdrawal Password).', '2025-05-01 15:43:05', '2025-05-01 15:43:05'),
(293, 'Admin Masmut updated user \"trainingaaaa\" Bonus.', '2025-05-01 16:24:29', '2025-05-01 16:24:29'),
(294, 'Admin Masmut updated user \"winter\" Deposit.', '2025-05-01 16:46:58', '2025-05-01 16:46:58'),
(295, 'Admin Masmut has logged in.', '2025-05-02 07:41:07', '2025-05-02 07:41:07'),
(296, 'Admin Masmut updated user \"trainingaaaa\" Deposit.', '2025-05-02 08:43:52', '2025-05-02 08:43:52'),
(297, 'Admin Masmut updated user \"trainingaaaa\" Bonus.', '2025-05-02 08:43:59', '2025-05-02 08:43:59'),
(298, 'Admin Masmut has logged in.', '2025-05-20 16:51:30', '2025-05-20 16:51:30'),
(299, 'Admin Masmut has exported user data to Excel.', '2025-05-20 18:16:41', '2025-05-20 18:16:41'),
(300, 'Admin Masmut has logged in.', '2025-05-23 13:23:44', '2025-05-23 13:23:44'),
(301, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:28:35', '2025-05-23 13:28:35'),
(302, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:30:00', '2025-05-23 13:30:00'),
(303, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:32:31', '2025-05-23 13:32:31'),
(304, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:33:31', '2025-05-23 13:33:31'),
(305, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:33:56', '2025-05-23 13:33:56'),
(306, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:36:47', '2025-05-23 13:36:47'),
(307, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:37:44', '2025-05-23 13:37:44'),
(308, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:38:54', '2025-05-23 13:38:54'),
(309, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:40:35', '2025-05-23 13:40:35'),
(310, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:40:41', '2025-05-23 13:40:41'),
(311, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:44:34', '2025-05-23 13:44:34'),
(312, 'Admin Masmut has exported user data to Excel.', '2025-05-23 13:47:31', '2025-05-23 13:47:31'),
(313, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:49:32', '2025-05-23 13:49:32'),
(314, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:52:33', '2025-05-23 13:52:33'),
(315, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:55:03', '2025-05-23 13:55:03'),
(316, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:56:07', '2025-05-23 13:56:07'),
(317, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:56:56', '2025-05-23 13:56:56'),
(318, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:57:47', '2025-05-23 13:57:47'),
(319, 'Admin Masmut has exported user data to PDF.', '2025-05-23 13:59:47', '2025-05-23 13:59:47'),
(320, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:05:08', '2025-05-23 14:05:08'),
(321, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:05:44', '2025-05-23 14:05:44'),
(322, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:06:44', '2025-05-23 14:06:44'),
(323, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:09:40', '2025-05-23 14:09:40'),
(324, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:09:47', '2025-05-23 14:09:47'),
(325, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:10:26', '2025-05-23 14:10:26'),
(326, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:12:21', '2025-05-23 14:12:21'),
(327, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:14:10', '2025-05-23 14:14:10'),
(328, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:17:17', '2025-05-23 14:17:17'),
(329, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:20:02', '2025-05-23 14:20:02'),
(330, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:21:15', '2025-05-23 14:21:15'),
(331, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:23:18', '2025-05-23 14:23:18'),
(332, 'Admin Masmut has exported user data to PDF.', '2025-05-23 14:25:55', '2025-05-23 14:25:55'),
(333, 'Admin Masmut has logged in.', '2025-05-24 04:43:02', '2025-05-24 04:43:02'),
(334, 'Admin Masmut has logged in.', '2025-05-24 04:50:36', '2025-05-24 04:50:36'),
(335, 'Admin Masmut has exported user data to Excel.', '2025-05-24 04:56:00', '2025-05-24 04:56:00'),
(336, 'Admin Masmut has logged in.', '2025-05-24 12:11:16', '2025-05-24 12:11:16'),
(337, 'Admin Masmut has logged in.', '2025-06-14 06:28:55', '2025-06-14 06:28:55'),
(338, 'Admin Masmut updated user \"winter\" Deposit.', '2025-06-14 06:31:46', '2025-06-14 06:31:46'),
(339, 'Admin Masmut has logged in.', '2025-06-17 12:01:50', '2025-06-17 12:01:50'),
(340, 'Admin Masmut updated user \"winter\" Deposit.', '2025-06-17 12:04:03', '2025-06-17 12:04:03'),
(341, 'Admin Masmut updated user \"trainingwinter\" Withdrawal.', '2025-06-17 12:04:22', '2025-06-17 12:04:22'),
(342, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-06-17 12:04:40', '2025-06-17 12:04:40'),
(343, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-06-17 12:04:50', '2025-06-17 12:04:50'),
(344, 'Admin Masmut updated user \"trainingwinter\" Withdrawal.', '2025-06-17 12:05:22', '2025-06-17 12:05:22'),
(345, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-06-17 12:05:32', '2025-06-17 12:05:32'),
(346, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-06-17 12:05:53', '2025-06-17 12:05:53'),
(347, 'Admin Masmut updated user \"trainingwinter\" Bonus.', '2025-06-17 12:06:02', '2025-06-17 12:06:02'),
(348, 'Admin Masmut updated user \"trainingwinter\" Withdrawal.', '2025-06-17 12:07:16', '2025-06-17 12:07:16'),
(349, 'Admin Masmut updated user \"trainingwinter\" Deposit.', '2025-06-17 12:11:07', '2025-06-17 12:11:07'),
(350, 'Admin Masmut has logged in.', '2025-06-25 13:14:28', '2025-06-25 13:14:28'),
(351, 'Admin Masmut has logged in.', '2025-06-27 09:55:27', '2025-06-27 09:55:27'),
(352, 'Admin Masmut has edited user \"trainingaaaa\" (Changed: Membership).', '2025-06-27 09:56:53', '2025-06-27 09:56:53'),
(353, 'Admin Masmut has edited user \"trainingaaaa\" (Changed: Membership).', '2025-06-27 09:57:13', '2025-06-27 09:57:13'),
(354, 'Admin Masmut has edited user \"trainingaaaa\" (Changed: Membership).', '2025-06-27 09:57:38', '2025-06-27 09:57:38'),
(355, 'Admin Masmut has logged in.', '2025-06-27 13:29:35', '2025-06-27 13:29:35'),
(356, 'Admin Masmut has logged in.', '2025-06-27 17:28:05', '2025-06-27 17:28:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_06_184547_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint NOT NULL,
  `product_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` text COLLATE utf8mb4_general_ci,
  `status` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_image`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Grimvalor', '1744596735_Grimvalor.png', 1, '2025-04-13 13:16:06', '2025-04-14 02:12:15'),
(6, 'Dead Cells', '1744597041_Dead Cells.jpg', 1, '2025-04-13 13:36:34', '2025-04-14 02:17:21'),
(7, 'Way of Retribution', '1744597071_Way of Retribution.jpg', 1, '2025-04-13 13:36:44', '2025-04-14 02:17:51'),
(8, 'Cat Quest II', '1744597098_Cat Quest 2.jpg', 1, '2025-04-13 13:36:54', '2025-04-14 02:18:18'),
(9, 'ICEY', '1744597141_Icey.jpg', 1, '2025-04-13 13:37:07', '2025-04-14 02:19:01'),
(10, 'Evoland 2', '1744597180_Evoland 2.jpg', 1, '2025-04-13 13:37:16', '2025-04-14 02:19:40'),
(11, 'Shadow Fight 3', '1744597710_Shadow fight 3.jpg', 1, '2025-04-13 13:37:26', '2025-04-14 02:28:30'),
(12, 'Oddmar', '1744597933_Oddmar.jpg', 1, '2025-04-13 13:37:37', '2025-04-14 02:32:13'),
(13, 'Dead Raid', '1744598040_Dead Raid.jpg', 1, '2025-04-13 13:37:47', '2025-04-14 02:34:00'),
(14, 'Beat Street', '1744598131_Beat Street.jpg', 1, '2025-04-13 13:38:00', '2025-04-14 02:35:31'),
(15, 'Soul Knight', '1744598162_Soul Knight.jpg', 1, '2025-04-13 13:38:19', '2025-04-14 02:36:02'),
(25, 'Tiny Guardians', '1744598199_Tiny Guardians.jpg', 1, '2025-04-13 13:45:26', '2025-04-14 02:36:39'),
(26, 'Nonstop Knight 2', '1744598254_Nonstop Knight 2.jpg', 1, '2025-04-13 13:45:35', '2025-04-14 02:37:34'),
(27, 'Dungeon Hunter 5', '1744598320_Dungeon hunter 5.jpg', 1, '2025-04-13 13:45:44', '2025-04-14 02:38:40'),
(28, 'Tap Titans 2', '1744598357_Tap Titan 2.jpg', 1, '2025-04-13 13:45:58', '2025-04-14 02:39:17'),
(29, 'Knighthood', '1744598399_Knighthood.jpg', 1, '2025-04-13 13:46:10', '2025-04-14 02:39:59'),
(30, 'Postknight', '1744598434_Postknight.jpg', 1, '2025-04-13 13:46:20', '2025-04-14 02:40:34'),
(31, 'AFK Arena', '1744598951_AFK Arena.jpg', 1, '2025-04-13 13:46:27', '2025-04-14 02:49:11'),
(32, 'Summoner’s Greed', '1744598615_Summoner\'s Greed.jpg', 1, '2025-04-13 13:46:39', '2025-04-14 02:43:35'),
(33, 'Battleheart Legacy', '1744598646_Battleheart Legacy.jpg', 1, '2025-04-13 13:46:47', '2025-04-14 02:44:06'),
(34, 'Monument Valley 2', '1744598734_Monument Valley 2.jpg', 1, '2025-04-13 13:47:03', '2025-04-14 02:45:34'),
(35, 'ELOH', '1744598799_ELOH.jpg', 1, '2025-04-13 13:47:10', '2025-04-14 02:46:39'),
(36, 'The Room: Old Sins', '1744598877_The Room Old Sins.jpg', 1, '2025-04-13 13:47:18', '2025-04-14 02:47:57'),
(37, 'Hook', '1744599022_Hook.jpg', 1, '2025-04-13 13:47:25', '2025-04-14 02:50:22'),
(38, 'Mekorama', '1744599078_Mekorama.jpg', 1, '2025-04-13 13:47:38', '2025-04-14 02:51:18'),
(39, 'Blue', '1744599110_Blue.jpg', 1, '2025-04-13 13:47:57', '2025-04-14 02:51:50'),
(40, 'Two Dots', '1744599150_Two Dots.jpg', 1, '2025-04-13 13:48:05', '2025-04-14 02:52:30'),
(41, 'Brain It On!', '1744599196_Brain It On.jpg', 1, '2025-04-13 13:48:12', '2025-04-14 02:53:16'),
(42, 'Shadowmatic', '1744599223_Shadowmatic.jpg', 1, '2025-04-13 13:48:18', '2025-04-14 02:53:43'),
(43, 'Zenge', '1744599256_Zenge.jpg', 1, '2025-04-13 13:48:25', '2025-04-14 02:54:16'),
(44, 'Rebel Racing', '1744599283_Rebel Racing.jpg', 1, '2025-04-13 13:48:43', '2025-04-14 02:54:43'),
(45, 'F1 Clash', '1744599355_F1 Clash.jpg', 1, '2025-04-13 13:48:50', '2025-04-14 02:55:55'),
(46, 'OTR - Offroad Car Driving Game', '1744599453_Off The Road - OTR.jpg', 1, '2025-04-13 13:48:59', '2025-04-14 02:58:32'),
(47, 'Rush Rally 3', '1744599842_Rush Rally 3.jpg', 1, '2025-04-13 13:49:08', '2025-04-14 03:04:02'),
(48, 'Bike Race', '1744599822_Bike Race.jpg', 1, '2025-04-13 13:49:16', '2025-04-14 03:03:42'),
(49, 'Gravity Rider Zero', '1744599758_Gravity Rider Zero.jpg', 1, '2025-04-13 13:49:25', '2025-04-14 03:02:38'),
(50, 'Mad Skills Motocross 2', '1744599876_Mad Skills Motorcross 2.jpg', 1, '2025-04-13 13:49:36', '2025-04-14 03:04:36'),
(51, 'CarX Drift Racing 2', '1744599908_Carx Drift Racing 2.jpg', 1, '2025-04-13 13:49:42', '2025-04-14 03:05:08'),
(52, 'Thumb Drift Fast Furious Cars', '1744599934_Thumb Drift Fast Furious Cars.jpg', 1, '2025-04-13 13:49:51', '2025-04-14 03:05:34'),
(53, 'FR Legends', '1744599970_FR Legends.jpg', 1, '2025-04-13 13:50:00', '2025-04-14 03:06:10'),
(54, 'Tennis Clash', '1744600004_Tennis Clash.jpg', 1, '2025-04-13 13:50:11', '2025-04-14 03:06:44'),
(55, 'Golf Battle', '1744600035_Gold Battle.jpg', 1, '2025-04-13 13:50:24', '2025-04-14 03:07:15'),
(56, 'Head Ball 2', '1744600064_Head Ball 2.jpg', 1, '2025-04-13 13:50:30', '2025-04-14 03:07:44'),
(57, 'Retro Bowl', '1744600090_Retro Bowl.jpg', 1, '2025-04-13 13:50:37', '2025-04-14 03:08:10'),
(58, 'eFootball', '1744600115_eFootball.jpg', 1, '2025-04-13 13:50:44', '2025-04-14 03:08:35'),
(59, 'Basketball Arena', '1744600141_Basketball Arena.jpg', 1, '2025-04-13 13:50:51', '2025-04-14 03:09:01'),
(60, 'Soccer Superstar', '1744600187_Soccer Superstar.jpg', 1, '2025-04-13 13:50:57', '2025-04-14 03:09:47'),
(61, 'Madden NFL 25 Mobile Football', '1744600520_Madden NFL 25 Mobile Football.jpg', 1, '2025-04-13 13:51:08', '2025-04-14 03:15:20'),
(62, 'Mini Football', '1744600545_Mini Football.jpg', 1, '2025-04-13 13:51:15', '2025-04-14 03:15:45'),
(63, 'Flip Diving', '1744600571_Flip Diving.jpg', 1, '2025-04-13 13:51:22', '2025-04-14 03:16:11'),
(64, 'Alto\'s Odyssey', '1744600598_Alto\'s Odyssey.jpg', 1, '2025-04-13 13:51:38', '2025-04-14 03:16:38'),
(65, 'Alto\'s Adventure', '1744600836_Alto\'s Adventure.jpg', 1, '2025-04-13 13:51:44', '2025-04-14 03:20:36'),
(66, 'Tiny Wings', '1744600859_Tiny Wings.jpg', 1, '2025-04-13 13:51:54', '2025-04-14 03:20:59'),
(67, 'Penguin Isle', '1744600909_Penguin Isle.jpg', 1, '2025-04-13 13:52:42', '2025-04-14 03:21:49'),
(68, 'Tsuki Adventure', '1744600934_Tsuki Adventure.jpg', 1, '2025-04-13 13:52:49', '2025-04-14 03:22:14'),
(69, 'My Oasis', '1744600964_My Oasis.jpg', 1, '2025-04-13 13:52:57', '2025-04-14 03:22:44'),
(70, 'Terrarium: Garden Idle', '1744601010_Terrarium Garden Idle.jpg', 1, '2025-04-13 13:53:04', '2025-04-14 03:23:30'),
(71, 'Adorable Home', '1744601039_Adorable Home.jpg', 1, '2025-04-13 13:53:11', '2025-04-14 03:23:59'),
(72, 'Zen Koi 2', '1744601149_Zen Koi 2.jpg', 1, '2025-04-13 13:53:19', '2025-04-14 03:25:49'),
(73, 'KleptoCats', '1744601170_KleptoCats.jpg', 1, '2025-04-13 13:53:35', '2025-04-14 03:26:10'),
(74, 'Pocket Build', '1744601202_Pocket Build.jpg', 1, '2025-04-13 13:54:05', '2025-04-14 03:26:42'),
(75, 'TheoTown', '1744601235_TheoTown.jpg', 1, '2025-04-13 13:54:12', '2025-04-14 03:27:15'),
(76, 'Egg, Inc.', '1744601260_Egg, Inc.jpg', 1, '2025-04-13 13:54:19', '2025-04-14 03:27:40'),
(77, 'Tropico', '1744601304_Tropico.jpg', 1, '2025-04-13 13:54:26', '2025-04-14 03:28:24'),
(78, 'Game Dev Tycoon', '1744601338_Game Dev Tycoon.jpg', 1, '2025-04-13 13:54:33', '2025-04-14 03:28:58'),
(79, 'Idle Theme Park Tycoon', '1744601358_Idle Theme Park Tycoon.jpg', 1, '2025-04-13 13:54:42', '2025-04-14 03:29:18'),
(80, 'SimCity BuildIt', '1744601381_SimCity BuildIt.jpg', 1, '2025-04-13 13:54:49', '2025-04-14 03:29:41'),
(81, 'Idle Minor Tycoon: Gold Games', '1744601422_Idle Minor Tycoon Gold Games.jpg', 1, '2025-04-13 13:54:56', '2025-04-14 03:30:22'),
(82, 'Fallout Shelter Online', '1744601449_Fallout Shelter Online.jpg', 1, '2025-04-13 13:55:03', '2025-04-14 03:30:49'),
(83, 'Tiny Tower: Tap Idle Evolution', '1744601485_Tiny Tower Tap Idle Evolution.jpg', 1, '2025-04-13 13:55:10', '2025-04-14 03:31:25'),
(84, 'Downwell', '1744601506_Downwell.jpg', 1, '2025-04-13 13:55:22', '2025-04-14 03:31:46'),
(85, 'Dan the Man: Action Platformer', '1744601560_Dan the Man Action Platformer.jpg', 1, '2025-04-13 13:55:29', '2025-04-14 03:32:40'),
(86, 'Jetpack Joyride', '1744697141_Jetpack Joyride.jpg', 1, '2025-04-13 13:55:35', '2025-04-15 06:05:41'),
(87, 'BLUK - A Relaxing Physics Game', '1744697345_BLUK - A Relaxing Physics Game.jpg', 1, '2025-04-13 13:55:41', '2025-04-15 06:09:05'),
(88, 'Super Phantom Cat 2', '1744697422_Super Phantom Cat 2.jpg', 1, '2025-04-13 13:55:49', '2025-04-15 06:10:22'),
(89, 'Vector', '1744697448_Vector.jpg', 1, '2025-04-13 13:55:55', '2025-04-15 06:10:48'),
(90, 'Duet', '1744697477_Duet.jpg', 1, '2025-04-13 13:56:05', '2025-04-15 06:11:17'),
(91, 'Leap Day', '1744697507_Leap Day.jpg', 1, '2025-04-13 13:56:11', '2025-04-15 06:11:47'),
(92, 'Magic Rampage', '1744697534_Magic Rampage.jpg', 1, '2025-04-13 13:56:18', '2025-04-15 06:12:14'),
(93, 'One More Line', '1744697573_One More Line.jpg', 1, '2025-04-13 13:56:26', '2025-04-15 06:12:53'),
(103, 'Shadowgun Legends: Online FPS', '1744697709_Shadowgun Legends Online FPS.jpg', 1, '2025-04-13 14:00:34', '2025-04-15 06:15:09'),
(104, 'World War Heroes - WW2 PvP FPS', '1744697682_World War Heroes - WW2 PvP FPS.jpg', 1, '2025-04-13 14:00:40', '2025-04-15 06:14:42'),
(105, 'Tacticool: PVP Pro Shooter', '1744697764_Tacticool PVP Pro Shooter.jpg', 1, '2025-04-13 14:00:49', '2025-04-15 06:16:04'),
(106, 'FRAG Pro Shooter', '1744697790_FRAG Pro Shooter.jpg', 1, '2025-04-13 14:00:56', '2025-04-15 06:16:30'),
(107, 'Modern Combat 5: mobile FPS', '1744697847_Modern Combat 5 mobile FPS.jpg', 1, '2025-04-13 14:01:06', '2025-04-15 06:17:27'),
(108, 'DEAD TRIGGER 2: Zombie Games', '1744697885_DEAD TRIGGER 2 Zombie Games.jpg', 1, '2025-04-13 14:01:15', '2025-04-15 06:18:05'),
(109, 'Sniper 3D: Gun Shooting Games', '1744697921_Sniper 3D Gun Shooting Games.jpg', 1, '2025-04-13 14:01:26', '2025-04-15 06:18:41'),
(110, 'Major Mayhem 2: Action Shooter', '1744697962_Major Mayhem 2 Action Shooter.jpg', 1, '2025-04-13 14:01:33', '2025-04-15 06:19:22'),
(111, 'Infinity Ops: FPS Shooter Game', '1744698004_Infinity Ops FPS Shooter Game.jpg', 1, '2025-04-13 14:01:42', '2025-04-15 06:20:04'),
(112, 'Nova Empire: Space Commander', '1744698056_Nova Empire Space Commander.jpg', 1, '2025-04-13 14:01:49', '2025-04-15 06:20:56'),
(113, 'Stick Hero Fight', '1744698094_Stick Hero Fight.jpg', 1, '2025-04-13 14:02:38', '2025-04-15 06:21:34'),
(114, 'Stumble Guys', '1744698121_Stumble Guys.jpg', 1, '2025-04-13 14:02:48', '2025-04-15 06:22:01'),
(115, 'Blast Royale: Battle Online', '1744698892_Blast Royale Battle Online.jpg', 1, '2025-04-13 14:02:56', '2025-04-15 06:34:52'),
(116, 'Zooba: Fun Battle Royale Games', '1744698929_Zooba Fun Battle Royale Games.jpg', 1, '2025-04-13 14:03:03', '2025-04-15 06:35:29'),
(117, 'Sky: Children of the Light', '1744698970_Sky Children of the Light.jpg', 1, '2025-04-13 14:03:12', '2025-04-15 06:36:10'),
(118, 'Brawlhalla', '1744699183_Brawlhalla.jpg', 1, '2025-04-13 14:03:22', '2025-04-15 06:39:43'),
(119, 'Mini Militia - Doodle Army 2', '1744699208_Mini Militia - Doodle Army 2.png', 1, '2025-04-13 14:03:31', '2025-04-15 06:40:08'),
(120, 'Among Us', '1744699771_Among Us.jpg', 1, '2025-04-13 14:03:40', '2025-04-15 06:49:31'),
(121, 'Roblox', '1744699795_Roblox.jpg', 1, '2025-04-13 14:03:47', '2025-04-15 06:49:55'),
(122, 'T3 Arena', '1744699814_T3 Arena.jpg', 1, '2025-04-13 14:03:55', '2025-04-15 06:50:14'),
(123, 'Facebook', '1744699836_Facebook.jpg', 1, '2025-04-13 14:36:14', '2025-04-15 06:50:36'),
(124, 'Instagram', '1744699913_Instagram.jpg', 1, '2025-04-13 14:36:22', '2025-04-15 06:51:53'),
(125, 'X', '1744699953_Twitter (X).jpg', 1, '2025-04-13 14:36:39', '2025-04-15 06:52:33'),
(126, 'TikTok', '1744700012_TikTok.jpg', 1, '2025-04-13 14:37:40', '2025-04-15 06:53:32'),
(127, 'Snapchat', '1744700029_Snapchat.jpg', 1, '2025-04-13 14:37:49', '2025-04-15 06:53:49'),
(128, 'Pinterest', '1744700046_Pinterest.jpg', 1, '2025-04-13 14:37:58', '2025-04-15 06:54:06'),
(129, 'YouTube', '1744700065_YouTube.jpg', 1, '2025-04-13 14:38:04', '2025-04-15 06:54:25'),
(130, 'LinkedIn', '1744700084_LinkedIn.jpg', 1, '2025-04-13 14:38:16', '2025-04-15 06:54:44'),
(131, 'WhatsApp', '1744700103_WhatsApp.jpg', 1, '2025-04-13 14:38:26', '2025-04-15 06:55:03'),
(132, 'Telegram', '1744700128_Telegram.jpg', 1, '2025-04-13 14:38:35', '2025-04-15 06:55:28'),
(133, 'Viber', '1744700206_Viber.jpg', 1, '2025-04-13 14:38:50', '2025-04-15 06:56:46'),
(134, 'WeChat', '1744700228_WeChat.jpg', 1, '2025-04-13 14:38:58', '2025-04-15 06:57:08'),
(135, 'Line', '1744700268_Line.jpg', 1, '2025-04-13 14:39:06', '2025-04-15 06:57:48'),
(136, 'Reddit', '1744700293_Reddit.jpg', 1, '2025-04-13 14:39:13', '2025-04-15 06:58:13'),
(137, 'Tumblr', '1744700315_Tumblr.jpg', 1, '2025-04-13 14:39:25', '2025-04-15 06:58:35'),
(138, 'Discord', '1744700351_Discord.jpg', 1, '2025-04-13 14:39:42', '2025-04-15 06:59:11'),
(139, 'Quora', '1744700371_Quora.jpg', 1, '2025-04-13 14:39:51', '2025-04-15 06:59:31'),
(141, 'Vone', '1744700427_Vone.jpg', 1, '2025-04-13 14:40:08', '2025-04-15 07:00:27'),
(142, 'Clubhouse', '1744700449_Clubhouse.jpg', 1, '2025-04-13 14:40:15', '2025-04-15 07:00:49'),
(143, 'Skype', '1744700473_Skype.jpg', 1, '2025-04-13 14:40:23', '2025-04-15 07:01:13'),
(144, 'Flickr', '1744700494_Flickr.jpg', 1, '2025-04-13 14:48:40', '2025-04-15 07:01:34'),
(145, 'Twitch', '1744700585_Twitch.jpg', 1, '2025-04-13 14:48:47', '2025-04-15 07:03:05'),
(146, 'Weibo', '1744700687_Weibo.jpg', 1, '2025-04-13 14:48:53', '2025-04-15 07:04:47'),
(147, 'Snapseed', '1744700706_Snapseed.jpg', 1, '2025-04-13 14:49:06', '2025-04-15 07:05:06'),
(148, 'Foursquare Swarm', '1744700743_Foursquare Swarm.jpg', 1, '2025-04-13 14:49:14', '2025-04-15 07:05:43'),
(149, 'House Party', '1744700953_House Party.jpg', 1, '2025-04-13 14:49:27', '2025-04-15 07:09:13'),
(151, 'Habbo', '1744700981_Habbo.jpg', 1, '2025-04-13 14:49:44', '2025-04-15 07:09:41'),
(152, 'Paltalk', '1744701004_Paltalk.jpg', 1, '2025-04-13 14:49:52', '2025-04-15 07:10:04'),
(153, 'VERO', '1744701034_VERO.jpg', 1, '2025-04-13 14:50:00', '2025-04-15 07:10:34'),
(154, 'KakaoTalk', '1744701090_KakaoTalk.jpg', 1, '2025-04-13 14:50:18', '2025-04-15 07:11:30'),
(155, 'Hago', '1744701140_Hago.jpg', 1, '2025-04-13 14:50:26', '2025-04-15 07:12:20'),
(156, 'Buzz App', '1744701292_Buzz App.jpg', 1, '2025-04-13 14:50:33', '2025-04-15 07:14:52'),
(157, 'Hootsuite', '1744701319_Hootsuite.jpg', 1, '2025-04-13 14:50:39', '2025-04-15 07:15:19'),
(158, 'Buffer', '1744701340_Buffer.jpg', 1, '2025-04-13 14:50:46', '2025-04-15 07:15:40'),
(160, 'Zoho Social', '1744701367_Zoho Social.jpg', 1, '2025-04-13 14:56:14', '2025-04-15 07:16:07'),
(161, 'Revolt', '1744701395_Revolt.jpg', 1, '2025-04-13 14:56:21', '2025-04-15 07:16:35'),
(162, 'VivaVideo', '1744701419_VivaVideo.jpg', 1, '2025-04-13 14:56:27', '2025-04-15 07:16:59'),
(163, 'Wink App', '1744701442_Wink.jpg', 1, '2025-04-13 14:56:34', '2025-04-15 07:17:22'),
(164, 'TRIBE Influencer', '1744701476_TRIBE Influencer.jpg', 1, '2025-04-13 14:56:40', '2025-04-15 07:17:56'),
(165, 'Tinder', '1744701648_Tinder.jpg', 1, '2025-04-13 14:57:06', '2025-04-15 07:20:48'),
(166, 'Bumble', '1744701565_Bumble.jpg', 1, '2025-04-13 14:57:14', '2025-04-15 07:19:25'),
(167, 'OkCupid', '1744701607_OkCupid.jpg', 1, '2025-04-13 14:57:20', '2025-04-15 07:20:07'),
(168, 'Grindr', '1744701714_Grindr.jpg', 1, '2025-04-13 14:57:27', '2025-04-15 07:21:54'),
(169, 'Match Dating App', '1744701747_Match Dating App.jpg', 1, '2025-04-13 14:57:38', '2025-04-15 07:22:27'),
(170, 'Badoo', '1744701813_Badoo.jpg', 1, '2025-04-13 14:57:46', '2025-04-15 07:23:33'),
(171, 'Tantan', '1744701849_TanTan.jpg', 1, '2025-04-13 14:57:53', '2025-04-15 07:24:09'),
(172, 'happn', '1744701891_happn.jpg', 1, '2025-04-13 14:58:00', '2025-04-15 07:24:51'),
(173, 'Omega', '1744706623_Omega.jpg', 1, '2025-04-13 14:58:09', '2025-04-15 08:43:43'),
(174, 'Coffee Meets Bagel', '1744706595_Coffee Meets Bagel.jpg', 1, '2025-04-13 14:58:15', '2025-04-15 08:43:15'),
(175, 'Her', '1744706655_HER.jpg', 1, '2025-04-13 14:58:34', '2025-04-15 08:44:15'),
(176, 'Omi', '1744706707_Omi.jpg', 1, '2025-04-13 15:01:54', '2025-04-15 08:45:07'),
(177, 'MeetMe', '1744706730_MeetMe.jpg', 1, '2025-04-13 15:02:02', '2025-04-15 08:45:30'),
(178, 'Litmatch', '1744706808_Litmatch.jpg', 1, '2025-04-13 15:02:14', '2025-04-15 08:46:48'),
(179, 'BeFriend', '1744706837_BeFriend.jpg', 1, '2025-04-13 15:02:22', '2025-04-15 08:47:17'),
(180, 'Wingman', '1744706858_Wingman.jpg', 1, '2025-04-13 15:02:30', '2025-04-15 08:47:38'),
(181, 'Flutter', '1744706881_Flutter.jpg', 1, '2025-04-13 15:02:38', '2025-04-15 08:48:01'),
(182, 'Bumpy', '1744706921_Bumpy.jpg', 1, '2025-04-13 15:02:45', '2025-04-15 08:48:41'),
(183, 'Luxy', '1744706944_Luxy.jpg', 1, '2025-04-13 15:02:52', '2025-04-15 08:49:04'),
(184, 'Seeking', '1744706972_Seeking.jpg', 1, '2025-04-13 15:02:58', '2025-04-15 08:49:32'),
(185, 'Spotted', '1744706991_Spotted.jpg', 1, '2025-04-13 15:03:16', '2025-04-15 08:49:51'),
(186, 'bubble with STARS', '1744707046_bubble with STARS.jpg', 1, '2025-04-13 15:03:22', '2025-04-15 08:50:46'),
(187, 'SDC Adult Dating', '1744707073_SDC Adult Dating.jpg', 1, '2025-04-13 15:03:30', '2025-04-15 08:51:13'),
(188, 'Amigos', '1744707091_Amigos.jpg', 1, '2025-04-13 15:03:37', '2025-04-15 08:51:31'),
(189, 'My Flirt', '1744707136_My Flirt.jpg', 1, '2025-04-13 15:03:48', '2025-04-15 08:52:16'),
(190, 'Whispers', '1744707162_Whispers.jpg', 1, '2025-04-13 15:03:55', '2025-04-15 08:52:42'),
(191, 'Boo', '1744707208_Boo.jpg', 1, '2025-04-13 15:04:01', '2025-04-15 08:53:28'),
(192, 'iris Dating', '1744707485_iris Dating.jpg', 1, '2025-04-13 15:04:11', '2025-04-15 08:58:05'),
(193, 'DateMyAge', '1744707424_DateMyAge.jpg', 1, '2025-04-13 15:04:20', '2025-04-15 08:57:04'),
(194, 'PopUp', '1744707455_PopUp.jpg', 1, '2025-04-13 15:04:28', '2025-04-15 08:57:35'),
(195, 'Netflix', '1744707508_Netflix.jpg', 1, '2025-04-13 15:25:14', '2025-04-15 08:58:28'),
(196, 'Disney+ Hotstar', '1744707532_Disney+ Hotstar.jpg', 1, '2025-04-13 15:25:23', '2025-04-15 08:58:52'),
(197, 'Amazon Prime Video', '1744707551_Amazon Prime Video.jpg', 1, '2025-04-13 15:25:33', '2025-04-15 08:59:11'),
(198, 'Hulu', '1744707587_Hulu.jpg', 1, '2025-04-13 15:25:42', '2025-04-15 08:59:47'),
(199, 'HBO Max', '1744707678_HBO Max.jpg', 1, '2025-04-13 15:25:50', '2025-04-15 09:01:18'),
(200, 'Viu', '1744707701_Viu.jpg', 1, '2025-04-13 15:25:56', '2025-04-15 09:01:41'),
(201, 'MX Player', '1744707719_MX Player.jpg', 1, '2025-04-13 15:26:05', '2025-04-15 09:01:59'),
(202, 'iQIYI', '1744707740_iQIYI.jpg', 1, '2025-04-13 15:26:12', '2025-04-15 09:02:20'),
(203, 'WeTV', '1744707764_WeTV.jpg', 1, '2025-04-13 15:26:20', '2025-04-15 09:02:44'),
(204, 'Mubi', '1744707784_MUBI.jpg', 1, '2025-04-13 15:26:59', '2025-04-15 09:03:04'),
(205, 'NAVER TV', '1744707815_NAVER TV.jpg', 1, '2025-04-13 15:27:14', '2025-04-15 09:03:35'),
(206, 'ShortMax', '1744707851_ShortMax.jpg', 1, '2025-04-13 15:27:20', '2025-04-15 09:04:11'),
(207, 'Catchplay', '1744707881_CATCHPLAY.jpg', 1, '2025-04-13 15:27:27', '2025-04-15 09:04:41'),
(208, 'BiliBili', '1744707914_BiliBili.jpg', 1, '2025-04-13 15:27:34', '2025-04-15 09:05:14'),
(209, 'MovieBox', '1744707933_MovieBox.jpg', 1, '2025-04-13 15:27:42', '2025-04-15 09:05:33'),
(210, 'Vidio', '1744708012_Vidio.jpg', 1, '2025-04-13 15:27:48', '2025-04-15 09:06:52'),
(211, 'iflix', '1744708031_iflix.jpg', 1, '2025-04-13 15:27:55', '2025-04-15 09:07:11'),
(212, 'Spotify', '1744708048_Spotify.jpg', 1, '2025-04-13 16:15:56', '2025-04-15 09:07:28'),
(213, 'Apple Music', '1744708103_Apple Music.jpg', 1, '2025-04-13 16:16:02', '2025-04-15 09:08:23'),
(214, 'YouTube Music', '1744708120_YouTube Music.jpg', 1, '2025-04-13 16:16:12', '2025-04-15 09:08:40'),
(215, 'SoundCloud', '1744708141_SoundCloud.jpg', 1, '2025-04-13 16:16:20', '2025-04-15 09:09:01'),
(216, 'Amazon Music for Artists', '1744708166_Amazon Music for Artists.jpg', 1, '2025-04-13 16:16:29', '2025-04-15 09:09:26'),
(218, 'Pandora', '1744708189_Pandora.jpg', 1, '2025-04-13 16:17:39', '2025-04-15 09:09:49'),
(219, 'JOOX Music', '1744708210_JOOX Music.jpg', 1, '2025-04-13 16:17:45', '2025-04-15 09:10:10'),
(220, 'Musixmatch', '1744708230_Musixmatch.jpg', 1, '2025-04-13 16:17:51', '2025-04-15 09:10:30'),
(221, 'Mixcloud', '1744708363_Mixcloud.jpg', 1, '2025-04-13 16:17:58', '2025-04-15 09:12:43'),
(222, 'Bandcamp', '1744708382_Bandcamp.jpg', 1, '2025-04-13 16:18:04', '2025-04-15 09:13:02'),
(224, 'PicsArt', '1744708475_Picsart.jpg', 1, '2025-04-13 16:20:04', '2025-04-15 09:14:35'),
(225, 'VSCO', '1744708494_VSCO.jpg', 1, '2025-04-13 16:20:11', '2025-04-15 09:14:54'),
(226, 'Lightroom', '1744708513_Lightroom.jpg', 1, '2025-04-13 16:20:19', '2025-04-15 09:15:13'),
(227, 'InShot', '1744708537_InShot.jpg', 1, '2025-04-13 16:20:26', '2025-04-15 09:15:37'),
(228, 'Kinemaster', '1744708557_KineMaster.jpg', 1, '2025-04-13 16:21:05', '2025-04-15 09:15:57'),
(229, 'Canva', '1744708578_Canva.jpg', 1, '2025-04-13 16:21:23', '2025-04-15 09:16:18'),
(230, 'Pixlr', '1744708599_Pixlr.jpg', 1, '2025-04-13 16:21:29', '2025-04-15 09:16:39'),
(231, 'Afterlight', '1744708614_Afterlight.jpg', 1, '2025-04-13 16:21:36', '2025-04-15 09:16:54'),
(232, 'Funimate', '1744708630_Funimate.jpg', 1, '2025-04-13 16:21:44', '2025-04-15 09:17:10'),
(233, 'Filmora', '1744708654_Filmora.jpg', 1, '2025-04-13 16:21:52', '2025-04-15 09:17:34'),
(234, 'Facetune', '1744708689_Facetune.jpg', 1, '2025-04-13 16:22:00', '2025-04-15 09:18:09'),
(235, 'Life Lapse', '1744708853_Life Lapse.jpeg', 1, '2025-04-13 16:22:07', '2025-04-15 09:20:53'),
(236, 'Remini', '1744708876_Remini.jpg', 1, '2025-04-13 16:22:13', '2025-04-15 09:21:16'),
(237, 'Smule', '1744708894_Smule.jpg', 1, '2025-04-13 16:22:51', '2025-04-15 09:21:34'),
(238, 'Sing Karaoke', '1744708923_Sing Karaoke.png', 1, '2025-04-13 16:22:57', '2025-04-15 09:22:03'),
(239, 'StarMaker', '1744708941_StarMaker.jpg', 1, '2025-04-13 16:23:05', '2025-04-15 09:22:21'),
(240, 'Karaoke Lite', '1744708972_Karaoke Lite.jpg', 1, '2025-04-13 16:23:12', '2025-04-15 09:22:52'),
(241, 'WeSing', '1744708987_WeSing.jpg', 1, '2025-04-13 16:23:18', '2025-04-15 09:23:07'),
(242, 'Amazon', '1744709019_Amazon.jpg', 1, '2025-04-13 16:25:26', '2025-04-15 09:23:39'),
(243, 'eBay', '1744709039_eBay.jpg', 1, '2025-04-13 16:25:39', '2025-04-15 09:23:59'),
(244, 'Walmart', '1744709057_Walmart.jpg', 1, '2025-04-13 16:25:46', '2025-04-15 09:24:17'),
(245, 'AliExpress', '1744709081_AliExpress.jpg', 1, '2025-04-13 16:25:54', '2025-04-15 09:24:41'),
(246, 'Lazada', '1744709144_Lazada.jpg', 1, '2025-04-13 16:26:01', '2025-04-15 09:25:44'),
(247, 'Shopee', '1744709173_Shopee.jpg', 1, '2025-04-13 16:26:07', '2025-04-15 09:26:13'),
(248, 'Tokopedia', '1744709199_Tokopedia.jpg', 1, '2025-04-13 16:26:15', '2025-04-15 09:26:39'),
(249, 'Flipkart', '1744709216_Flipkart.jpg', 1, '2025-04-13 16:26:24', '2025-04-15 09:26:56'),
(250, 'Best Buy', '1744709358_Best Buy.jpg', 1, '2025-04-13 16:26:32', '2025-04-15 09:29:18'),
(251, 'Meesho', '1744709399_Meesho.jpg', 1, '2025-04-13 16:26:42', '2025-04-15 09:29:59'),
(252, 'noon', '1744709421_noon.jpg', 1, '2025-04-13 16:26:58', '2025-04-15 09:30:21'),
(253, 'Talabat', '1744709439_talabat.jpg', 1, '2025-04-13 16:27:06', '2025-04-15 09:30:39'),
(254, 'SHEIN', '1744709459_SHEIN.jpg', 1, '2025-04-13 16:27:12', '2025-04-15 09:30:59'),
(255, 'MAF Carrefour', '1744716056_MAF Carrefour.jpg', 1, '2025-04-13 16:27:19', '2025-04-15 11:20:56'),
(256, 'JD', '1744716081_JD.jpg', 1, '2025-04-13 16:27:32', '2025-04-15 11:21:21'),
(257, 'Target', '1744716101_Target.jpg', 1, '2025-04-13 16:27:39', '2025-04-15 11:21:41'),
(258, 'Uber Eats', '1744716125_Uber Eats.jpg', 1, '2025-04-13 16:27:46', '2025-04-15 11:22:05'),
(259, 'Just Eat', '1744716145_Just Eat.jpg', 1, '2025-04-13 16:27:53', '2025-04-15 11:22:25'),
(260, 'Uber', '1744716182_Uber.jpg', 1, '2025-04-13 16:28:03', '2025-04-15 11:23:02'),
(261, 'Lyft', '1744716230_Lyft.jpg', 1, '2025-04-13 16:28:10', '2025-04-15 11:23:50'),
(262, 'Grab', '1744716250_Grab.jpg', 1, '2025-04-13 16:28:16', '2025-04-15 11:24:10'),
(263, 'Ola', '1744716269_Ola.jpg', 1, '2025-04-13 16:28:24', '2025-04-15 11:24:29'),
(264, 'Bolt', '1744716288_Bolt.jpg', 1, '2025-04-13 16:28:30', '2025-04-15 11:24:48'),
(265, 'Didi', '1744716309_DiDi.jpg', 1, '2025-04-13 16:28:36', '2025-04-15 11:25:09'),
(266, 'Gojek', '1744716329_Gojek.jpg', 1, '2025-04-13 16:28:51', '2025-04-15 11:25:29'),
(267, 'Yandex Go', '1744716360_Yandex Go.jpg', 1, '2025-04-13 16:28:58', '2025-04-15 11:26:00'),
(268, 'Cabify', '1744716378_Cabify.jpg', 1, '2025-04-13 16:29:05', '2025-04-15 11:26:18'),
(269, 'inDrive', '1744716413_inDrive.jpg', 1, '2025-04-13 16:29:11', '2025-04-15 11:26:53'),
(270, 'Taxify', '1744716430_Taxify.jpg', 1, '2025-04-13 16:29:20', '2025-04-15 11:27:10'),
(271, 'FREENOW', '1744716467_FREENOW.jpg', 1, '2025-04-13 16:29:27', '2025-04-15 11:27:47'),
(272, 'Curb', '1744716484_Curb.jpg', 1, '2025-04-13 16:29:33', '2025-04-15 11:28:04'),
(273, 'MyTaxi', '1744716502_MyTaxi.jpg', 1, '2025-04-13 16:29:40', '2025-04-15 11:28:22'),
(274, 'Gett', '1744716536_Gett.jpg', 1, '2025-04-13 16:29:46', '2025-04-15 11:28:56'),
(275, 'Maxim', '1744716569_Maxim.jpg', 1, '2025-04-13 16:29:52', '2025-04-15 11:29:29'),
(276, 'Careem', '1744716606_Careem.jpg', 1, '2025-04-13 16:29:59', '2025-04-15 11:30:06'),
(277, 'PayPal', '1744716623_PayPal.jpg', 1, '2025-04-13 16:30:29', '2025-04-15 11:30:23'),
(278, 'Venmo', '1744716653_Venmo.jpg', 1, '2025-04-13 16:30:35', '2025-04-15 11:30:53'),
(279, 'Cash App', '1744716730_Cash App.jpg', 1, '2025-04-13 16:30:41', '2025-04-15 11:32:10'),
(280, 'Wise', '1744716813_Wise.jpg', 1, '2025-04-13 16:30:48', '2025-04-15 11:33:33'),
(281, 'Dana', '1744716936_DANA.jpg', 1, '2025-04-13 16:30:56', '2025-04-15 11:35:36'),
(282, 'OVO', '1744716955_OVO.jpg', 1, '2025-04-13 16:31:03', '2025-04-15 11:35:55'),
(283, 'GoPay', '1744716985_GoPay.jpg', 1, '2025-04-13 16:31:10', '2025-04-15 11:36:25'),
(284, 'QIWI Wallet', '1744717014_QIWI Wallet.jpg', 1, '2025-04-13 16:31:16', '2025-04-15 11:36:54'),
(285, 'Jenius', '1744717031_Jenius.jpg', 1, '2025-04-13 16:31:22', '2025-04-15 11:37:11'),
(286, 'ticket.com', '1744717063_ticket.com', 1, '2025-04-14 01:28:20', '2025-04-15 11:37:43'),
(287, 'Booking.com', '1744717090_Booking.com', 1, '2025-04-14 01:28:30', '2025-04-15 11:38:10'),
(288, 'Airbnb', '1744717114_Airbnb.jpg', 1, '2025-04-14 01:28:41', '2025-04-15 11:38:34'),
(289, 'Agoda', '1744717132_Agoda.jpg', 1, '2025-04-14 01:28:49', '2025-04-15 11:38:52'),
(290, 'Expedia', '1744717171_Expedia.jpg', 1, '2025-04-14 01:28:57', '2025-04-15 11:39:31'),
(291, 'Hotels.com', '1744717200_Hotels.com', 1, '2025-04-14 01:29:10', '2025-04-15 11:40:00'),
(292, 'trivago', '1744717627_trivago.jpg', 1, '2025-04-14 01:29:18', '2025-04-15 11:47:07'),
(293, 'Trip.com', '1744717663_Trip.com', 1, '2025-04-14 01:29:37', '2025-04-15 11:47:43'),
(294, 'Priceline', '1744717680_Priceline.jpg', 1, '2025-04-14 01:30:00', '2025-04-15 11:48:00'),
(295, 'OYO', '1744717713_OYO.jpg', 1, '2025-04-14 01:30:10', '2025-04-15 11:48:33'),
(296, 'Traveloka', '1744717735_Traveloka.jpg', 1, '2025-04-14 01:30:20', '2025-04-15 11:48:55'),
(297, 'Hotwire', '1744717966_Hotwire.jpg', 1, '2025-04-14 01:30:31', '2025-04-15 11:52:46'),
(298, 'MakeMyTrip', '1744717995_MakeMyTrip.jpg', 1, '2025-04-14 01:31:08', '2025-04-15 11:53:15'),
(299, 'Hostelworld', '1744718012_Hostelworld.jpg', 1, '2025-04-14 01:31:15', '2025-04-15 11:53:32'),
(300, 'RedDoorz', '1744718030_RedDoorz.jpg', 1, '2025-04-14 01:31:22', '2025-04-15 11:53:50'),
(301, 'AirAsia MOVE', '1744718057_AirAsia MOVE.jpg', 1, '2025-04-14 01:31:31', '2025-04-15 11:54:17'),
(302, 'Rakuten Travel', '1744718076_Rakuten Travel.jpg', 1, '2025-04-14 01:31:38', '2025-04-15 11:54:36'),
(303, 'Mobile Legends: Bang Bang', '1744718112_Mobile Legends Bang Bang.jpg', 1, '2025-04-14 01:39:46', '2025-04-15 11:55:12'),
(304, 'Free Fire', '1744718134_Free Fire.jpg', 1, '2025-04-14 01:39:55', '2025-04-15 11:55:34'),
(305, 'PUBG Mobile', '1744718157_PUBG MOBILE.jpg', 1, '2025-04-14 01:40:02', '2025-04-15 11:55:57'),
(306, 'Call of Duty Mobile - Garena', '1744718205_Call of Duty Mobile - Garena.jpg', 1, '2025-04-14 01:40:10', '2025-04-15 11:56:45'),
(307, 'Candy Crush Saga', '1744718225_Candy Crush Saga.jpg', 1, '2025-04-14 01:40:17', '2025-04-15 11:57:05'),
(308, 'Genshin Impact', '1744718246_Genshin Impact.jpg', 1, '2025-04-14 01:40:24', '2025-04-15 11:57:26'),
(309, 'Clash of Clans', '1744718274_Clash of Clans.jpg', 1, '2025-04-14 01:40:33', '2025-04-15 11:57:54'),
(310, 'Clash Royale', '1744718298_Clash Royale.jpg', 1, '2025-04-14 01:40:40', '2025-04-15 11:58:18'),
(311, 'Brawl Stars', '1744718326_Brawl Stars.jpg', 1, '2025-04-14 01:40:47', '2025-04-15 11:58:46'),
(312, 'Subway Surfers', '1744718351_Subway Surfers.jpg', 1, '2025-04-14 01:40:53', '2025-04-15 11:59:11'),
(313, 'Matchington Mansion', '1744718368_Matchington Mansion.jpg', 1, '2025-04-14 01:41:53', '2025-04-15 11:59:28'),
(314, 'Gardenscapes', '1744718394_Gardenscapes.jpg', 1, '2025-04-14 01:41:59', '2025-04-15 11:59:54'),
(315, 'Homescapes', '1744718414_Homescapes.jpg', 1, '2025-04-14 01:42:05', '2025-04-15 12:00:14'),
(316, 'Angry Birds 2', '1744718448_Angry Birds 2.jpg', 1, '2025-04-14 01:42:12', '2025-04-15 12:00:48'),
(317, 'Hill Climb Racing', '1744718466_Hill Climb Racing.jpg', 1, '2025-04-14 01:42:21', '2025-04-15 12:01:06'),
(319, 'Fruit Ninja', '1744718497_Fruit Ninja.jpg', 1, '2025-04-14 01:42:37', '2025-04-15 12:01:37'),
(320, 'Asphalt Legends Unite', '1744718550_Asphalt Legends Unite.jpg', 1, '2025-04-14 01:42:43', '2025-04-15 12:02:30'),
(321, 'EA SPORTS FC Mobile Football', '1744718603_EA SPORTS FC Mobile Football.jpg', 1, '2025-04-14 01:42:50', '2025-04-15 12:03:23'),
(322, 'NBA LIVE Mobile Basketball', '1744718628_NBA LIVE Mobile Basketball.jpg', 1, '2025-04-14 01:42:57', '2025-04-15 12:03:48'),
(323, 'Worms Zone .io', '1744718703_Worms Zone .io.jpg', 1, '2025-04-14 01:47:08', '2025-04-15 12:05:03'),
(324, 'Ludo Club', '1744718738_Ludo Club.jpg', 1, '2025-04-14 01:47:16', '2025-04-15 12:05:38'),
(325, '8 Ball Pool', '1744775106_8 Ball Pool.jpg', 1, '2025-04-14 01:47:23', '2025-04-16 03:45:06'),
(326, 'Carrom Pool', '1744775167_Carrom Pool.jpg', 1, '2025-04-14 01:47:30', '2025-04-16 03:46:07'),
(327, 'Bubble Shooter: Panda Pop!', '1744775233_Bubble Shooter Panda Pop!.jpg', 1, '2025-04-14 01:47:37', '2025-04-16 03:47:13'),
(328, 'Farm Heroes Saga', '1744775261_Farm Heroes Saga.jpg', 1, '2025-04-14 01:47:44', '2025-04-16 03:47:41'),
(329, 'MONOPOLY GO!', '1744775314_MONOPOLY GO!.jpg', 1, '2025-04-14 01:47:54', '2025-04-16 03:48:34'),
(330, 'Bubble Witch 3 Saga', '1744775519_Bubble Witch 3 Saga.jpg', 1, '2025-04-14 01:48:04', '2025-04-16 03:51:59'),
(331, 'Pet Rescue Saga', '1744775467_Pet Rescue Saga.jpg', 1, '2025-04-14 01:48:10', '2025-04-16 03:51:07'),
(332, 'Bejeweled Blitz', '1744775557_Bejeweled Blitz.jpg', 1, '2025-04-14 01:48:17', '2025-04-16 03:52:37'),
(333, 'Solitaire', '1744775578_Solitaire.jpg', 1, '2025-04-14 01:48:26', '2025-04-16 03:52:58'),
(334, 'Spider Solitaire', '1744775598_Spider Solitaire.jpg', 1, '2025-04-14 01:48:32', '2025-04-16 03:53:18'),
(335, 'Chess', '1744775633_Chess.jpg', 1, '2025-04-14 01:48:38', '2025-04-16 03:53:53'),
(336, 'Checkers', '1744775667_Checkers.jpg', 1, '2025-04-14 01:48:44', '2025-04-16 03:54:27'),
(337, 'Backgammon', '1744775697_Backgammon.jpg', 1, '2025-04-14 01:48:49', '2025-04-16 03:54:57'),
(338, 'Rummikub', '1744775723_Rummikub.jpg', 1, '2025-04-14 01:48:55', '2025-04-16 03:55:23'),
(339, 'UNO!', '1744775803_UNO!.jpg', 1, '2025-04-14 01:49:00', '2025-04-16 03:56:43'),
(340, 'Monument Valley', '1744775835_Monument Valley.jpg', 1, '2025-04-14 01:49:12', '2025-04-16 03:57:15'),
(342, 'Crossy Road', '1744775863_Crossy Road.jpg', 1, '2025-04-14 01:49:25', '2025-04-16 03:57:43'),
(343, 'Paper.io 2', '1744775888_Paper.io 2.jpg', 1, '2025-04-14 01:49:41', '2025-04-16 03:58:08'),
(344, 'Snake.io', '1744783683_Snake.io.jpg', 1, '2025-04-14 01:49:49', '2025-04-16 06:08:03'),
(345, 'Doodle Jump', '1744783708_Doodle Jump.jpg', 1, '2025-04-14 01:49:59', '2025-04-16 06:08:28'),
(346, 'Royal Match', '1744783740_Royal Match.jpg', 1, '2025-04-14 01:50:05', '2025-04-16 06:09:00'),
(347, 'Honor of Kings', '1744783767_Honor of Kings.jpg', 1, '2025-04-14 01:50:13', '2025-04-16 06:09:27'),
(348, 'Headspace', '1744783914_Headspace.jpg', 1, '2025-04-14 02:05:06', '2025-04-16 06:11:54'),
(349, 'Calm', '1744783961_Calm.jpg', 1, '2025-04-14 02:05:14', '2025-04-16 06:12:41'),
(350, 'Simple Habit', '1744784045_Simple Habit.jpg', 1, '2025-04-14 02:05:24', '2025-04-16 06:14:05'),
(351, 'Insight Timer', '1744784148_Insight Timer.jpg', 1, '2025-04-14 02:05:30', '2025-04-16 06:15:48'),
(352, 'Fabulous Daily Routine Planner', '1744784275_Fabulous Daily Routine Planner.jpg', 1, '2025-04-14 02:05:37', '2025-04-16 06:17:55'),
(353, 'Moodfit', '1744784297_Moodfit.jpg', 1, '2025-04-14 02:05:45', '2025-04-16 06:18:17'),
(354, 'Wysa', '1744784337_Wysa.jpg', 1, '2025-04-14 02:05:51', '2025-04-16 06:18:57'),
(355, 'BetterHelp', '1744784375_BetterHelp.jpg', 1, '2025-04-14 02:05:58', '2025-04-16 06:19:35'),
(356, 'Youper', '1744784399_Youper.jpg', 1, '2025-04-14 02:06:04', '2025-04-16 06:19:59'),
(357, 'Alodokter', '1744810129_Alodokter.jpg', 1, '2025-04-14 02:06:14', '2025-04-16 13:28:49'),
(358, 'KlikDokter', '1744810177_KlikDokter.jpg', 1, '2025-04-14 02:06:20', '2025-04-16 13:29:37'),
(359, 'Q-DOC', '1744810305_Q-DOC.jpg', 1, '2025-04-14 02:06:25', '2025-04-16 13:31:45'),
(360, 'Yesdok', '1744810410_Yesdok.jpg', 1, '2025-04-14 02:06:31', '2025-04-16 13:33:30'),
(361, 'HealthTap', '1744810436_HealthTap.jpg', 1, '2025-04-14 02:06:37', '2025-04-16 13:33:56'),
(362, 'Doctor on Demand', '1744810635_Doctor on Demand.jpg', 1, '2025-04-14 02:06:44', '2025-04-16 13:37:15'),
(363, 'Amwell', '1744810664_Amwell.jpg', 1, '2025-04-14 02:06:55', '2025-04-16 13:37:44'),
(364, 'MDLIVE', '1744887439_MDLIVE.jpg', 1, '2025-04-14 02:07:01', '2025-04-17 10:57:19'),
(365, 'Lemonaid Primary Care Complete', '1744887483_Lemonaid Primary Care Complete.jpg', 1, '2025-04-14 02:07:11', '2025-04-17 10:58:03'),
(366, 'PlushCare', '1744887502_PlushCare.jpg', 1, '2025-04-14 02:07:18', '2025-04-17 10:58:22'),
(367, 'Zocdoc', '1744887602_Zocdoc.jpg', 1, '2025-04-14 02:07:26', '2025-04-17 11:00:02'),
(368, 'Practo', '1744887624_Practo.jpg', 1, '2025-04-14 02:07:38', '2025-04-17 11:00:24'),
(369, 'Teladoc Health', '1744887652_Teladoc Health.jpg', 1, '2025-04-14 02:07:49', '2025-04-17 11:00:52'),
(370, 'Maple', '1744887671_Maple.jpg', 1, '2025-04-14 02:07:57', '2025-04-17 11:01:11'),
(371, 'Tappytoon Comics & Novels', '1744887698_Tappytoon Comics & Novels.jpg', 1, '2025-04-14 09:45:39', '2025-04-17 11:01:38'),
(372, 'Manta', '1744887720_Manta.jpg', 1, '2025-04-14 09:45:46', '2025-04-17 11:02:00'),
(373, 'Manga Up!', '1744887739_Manga UP!.jpg', 1, '2025-04-14 09:45:59', '2025-04-17 11:02:19'),
(374, 'Izneo', '1744887762_izneo.jpg', 1, '2025-04-14 09:46:05', '2025-04-17 11:02:42'),
(375, 'Manga Plus', '1744887781_MANGA Plus.jpg', 1, '2025-04-14 09:46:12', '2025-04-17 11:03:01'),
(376, 'BOOK WALKER', '1744887854_BOOK WALKER.jpg', 1, '2025-04-14 09:46:18', '2025-04-17 11:04:14'),
(377, 'Manga Box', '1744887877_Manga Box.jpg', 1, '2025-04-14 09:46:25', '2025-04-17 11:04:37'),
(378, 'Dark Horse Comics', '1744887951_Dark Horse Comics.jpg', 1, '2025-04-14 09:46:33', '2025-04-17 11:05:51'),
(379, 'WebNovel', '1744888007_WebNovel.jpg', 1, '2025-04-14 09:46:40', '2025-04-17 11:06:47'),
(380, 'Pocket Toons', '1744888048_Pocket Toons.jpg', 1, '2025-04-14 09:46:46', '2025-04-17 11:07:28'),
(381, 'WebComics', '1744888074_WebComics.jpg', 1, '2025-04-14 09:46:53', '2025-04-17 11:07:54'),
(382, 'Komiku', '1744888090_Komiku.jpg', 1, '2025-04-14 09:46:59', '2025-04-17 11:08:10'),
(383, 'Crunchyroll', '1744888109_Crunchyroll.jpg', 1, '2025-04-14 09:47:06', '2025-04-17 11:08:29'),
(384, 'MangaToon', '1744888128_MangaToon.jpg', 1, '2025-04-14 09:47:17', '2025-04-17 11:08:48'),
(385, 'KAKAO WEBTOON', '1744888154_KAKAO WEBTOON.jpg', 1, '2025-04-14 09:47:24', '2025-04-17 11:09:14'),
(386, 'GoodNovel', '1744888265_GoodNovel.jpg', 1, '2025-04-14 09:47:30', '2025-04-17 11:11:05'),
(387, 'Marvel Unlimited', '1744888283_Marvel Unlimited.jpg', 1, '2025-04-14 09:47:37', '2025-04-17 11:11:23'),
(388, 'Amazon Kindle', '1744888324_Amazon Kindle.jpg', 1, '2025-04-14 09:47:44', '2025-04-17 11:12:04'),
(389, 'Shonen Jump', '1744888387_Shonen Jump.jpg', 1, '2025-04-14 09:47:54', '2025-04-17 11:13:07'),
(390, 'GlobalComix', '1744888416_GlobalComix.jpg', 1, '2025-04-14 09:48:00', '2025-04-17 11:13:36'),
(391, 'WEBTOON', '1744888440_WEBTOON.jpg', 1, '2025-04-14 09:48:08', '2025-04-17 11:14:00'),
(392, 'VIZ Manga', '1744888489_VIZ Manga.jpg', 1, '2025-04-14 09:48:14', '2025-04-17 11:14:49'),
(393, 'Bookmate', '1744888506_Bookmate.jpg', 1, '2025-04-14 09:48:20', '2025-04-17 11:15:06'),
(394, 'Kobo Books', '1744888524_Kobo Books.jpg', 1, '2025-04-14 09:48:26', '2025-04-17 11:15:24'),
(395, 'Headway', '1744888554_Headway.jpg', 1, '2025-04-14 09:48:32', '2025-04-17 11:15:54'),
(396, 'Audible', '1744888572_Audible.jpg', 1, '2025-04-14 09:48:38', '2025-04-17 11:16:12'),
(397, 'Scribd', '1744888588_Scribd.jpg', 1, '2025-04-14 09:48:44', '2025-04-17 11:16:28'),
(398, 'Libby', '1744888603_Libby.jpg', 1, '2025-04-14 09:49:56', '2025-04-17 11:16:43'),
(399, 'PocketBook Reader', '1744888621_PocketBook reader.jpg', 1, '2025-04-14 09:50:22', '2025-04-17 11:17:01'),
(400, 'Moon+ Reader', '1744888638_Moon+ Reader.jpg', 1, '2025-04-14 09:50:35', '2025-04-17 11:17:18'),
(401, 'Cantook by Aldiko', '1744888665_Cantook by Aldiko.jpg', 1, '2025-04-14 09:50:42', '2025-04-17 11:17:45'),
(402, 'FBReader', '1744888715_FBReader.jpg', 1, '2025-04-14 09:50:48', '2025-04-17 11:18:35'),
(403, 'CLZ Comics', '1744888754_CLZ Comics.jpg', 1, '2025-04-14 09:50:59', '2025-04-17 11:19:14'),
(404, 'Cool PDF Reader', '1744888796_Cool PDF Reader.jpg', 1, '2025-04-14 09:51:11', '2025-04-17 11:19:56'),
(405, 'Lithium: EPUB Reader', '1744888831_Lithium EPUB Reader.jpg', 1, '2025-04-14 09:51:21', '2025-04-17 11:20:31'),
(406, 'AIReader', '1744888859_AIReader.jpg', 1, '2025-04-14 09:51:28', '2025-04-17 11:20:59'),
(407, 'EBookDroid', '1744888876_EBookDroid.jpg', 1, '2025-04-14 09:51:35', '2025-04-17 11:21:16'),
(408, 'ReadEra', '1744888893_ReadEra.jpg', 1, '2025-04-14 09:51:46', '2025-04-17 11:21:33'),
(409, 'Fizzo', '1744889438_Fizzo.jpg', 1, '2025-04-14 09:51:53', '2025-04-17 11:30:38'),
(410, 'Wattpad', '1744889307_Wattpad.jpg', 1, '2025-04-14 09:52:02', '2025-04-17 11:28:27'),
(411, 'Inkitt', '1744889330_Inkitt.jpg', 1, '2025-04-14 09:52:19', '2025-04-17 11:28:50'),
(412, 'Radish Fiction', '1744889356_Radish Fiction.jpg', 1, '2025-04-14 09:52:28', '2025-04-17 11:29:16'),
(413, 'Tapas', '1744889375_Tapas.jpg', 1, '2025-04-14 09:52:36', '2025-04-17 11:29:35'),
(414, 'Lezhin Comics', '1744889404_Lezhin Comics.jpg', 1, '2025-04-14 09:52:47', '2025-04-17 11:30:04'),
(415, 'MangaEvo', '1744889480_MangaEvo.jpg', 1, '2025-04-14 09:52:53', '2025-04-17 11:31:20'),
(416, 'Manga Reader', '1744889504_Manga Reader.jpg', 1, '2025-04-14 09:52:59', '2025-04-17 11:31:44'),
(417, 'Manga Zone', '1744889525_Manga Zone.jpg', 1, '2025-04-14 09:53:07', '2025-04-17 11:32:05'),
(418, 'Manga Fox', '1744889569_Manga Fox.jpg', 1, '2025-04-14 09:53:16', '2025-04-17 11:32:49'),
(419, 'Manga Guys', '1744889597_Manga Guys.jpg', 1, '2025-04-14 09:53:21', '2025-04-17 11:33:17'),
(420, 'Ur Manga', '1744889641_Ur Manga.jpg', 1, '2025-04-14 09:53:32', '2025-04-17 11:34:01'),
(421, 'Manga Mania', '1744889667_Manga Mania.jpg', 1, '2025-04-14 09:53:42', '2025-04-17 11:34:27'),
(422, 'MangaPin', '1744889718_MangaPin.jpg', 1, '2025-04-14 09:53:51', '2025-04-17 11:35:18'),
(423, 'Storytel', '1744889749_Storytel.jpg', 1, '2025-04-14 09:53:58', '2025-04-17 11:35:49'),
(424, 'Yousician', '1744889873_Yousician.jpg', 1, '2025-04-14 10:58:19', '2025-04-17 11:37:53'),
(425, 'Skoove', '1744889889_Skoove.jpg', 1, '2025-04-14 10:58:49', '2025-04-17 11:38:09'),
(426, 'GarageBand', '1744889909_GarageBand.jpg', 1, '2025-04-14 10:58:55', '2025-04-17 11:38:29'),
(427, 'EarMaster', '1744889924_EarMaster.jpg', 1, '2025-04-14 10:59:27', '2025-04-17 11:38:44'),
(428, 'Simply Piano', '1744889941_Simply Piano.jpg', 1, '2025-04-14 10:59:41', '2025-04-17 11:39:01'),
(429, 'flowkey', '1744889974_flowkey.jpg', 1, '2025-04-14 10:59:49', '2025-04-17 11:39:34'),
(430, 'Ultimate Guitar', '1744889993_Ultimate Guitar.jpg', 1, '2025-04-14 10:59:57', '2025-04-17 11:39:53'),
(431, 'BandLab', '1744890008_BandLab.jpg', 1, '2025-04-14 11:00:04', '2025-04-17 11:40:08'),
(432, 'Fender Play', '1744890025_Fender Play.jpg', 1, '2025-04-14 11:00:11', '2025-04-17 11:40:25'),
(433, 'Melodics', '1744890043_Melodics.jpg', 1, '2025-04-14 11:00:29', '2025-04-17 11:40:43'),
(434, 'Music Tutor', '1744890065_Music Tutor.jpg', 1, '2025-04-14 11:00:48', '2025-04-17 11:41:05'),
(435, 'Tenuto', '1744890080_Tenuto.jpg', 1, '2025-04-14 11:00:57', '2025-04-17 11:41:20'),
(436, 'Piano Academy', '1744890096_Piano Academy.jpg', 1, '2025-04-14 11:01:03', '2025-04-17 11:41:36'),
(437, 'Piano Marvel', '1744890122_Piano Marvel.jpg', 1, '2025-04-14 11:01:09', '2025-04-17 11:42:02'),
(438, 'GuitarTuna', '1744890138_GuitarTuna.jpg', 1, '2025-04-14 11:01:14', '2025-04-17 11:42:18'),
(439, 'Tunable', '1744890157_Tunable.jpg', 1, '2025-04-14 11:01:21', '2025-04-17 11:42:37'),
(440, 'Auralia', '1744890173_Auralia.jpg', 1, '2025-04-14 11:01:27', '2025-04-17 11:42:53'),
(441, 'MyEarTraining', '1744890201_MyEarTraining.jpg', 1, '2025-04-14 11:01:35', '2025-04-17 11:43:21'),
(442, 'Perfect Ear', '1744890221_Perfect Ear.jpg', 1, '2025-04-14 11:01:40', '2025-04-17 11:43:41'),
(443, 'Chordify', '1744890236_Chordify.jpg', 1, '2025-04-14 11:01:49', '2025-04-17 11:43:56'),
(444, 'Songsterr Guitar Tabs & Chords', '1744890276_Songsterr Guitar Tabs & Chords.jpg', 1, '2025-04-14 11:02:05', '2025-04-17 11:44:36'),
(445, 'MyChord', '1745112936_MyChord.jpg', 1, '2025-04-14 11:02:14', '2025-04-20 01:35:36'),
(446, 'Mini Piano Lite', '1745112968_Mini Piano Lite.jpg', 1, '2025-04-14 11:02:19', '2025-04-20 01:36:08'),
(447, 'Music Theory Helper', '1745112987_Music Theory Helper.jpg', 1, '2025-04-14 11:02:27', '2025-04-20 01:36:27'),
(448, 'Musical U', '1745113009_Musical U.jpg', 1, '2025-04-14 11:02:34', '2025-04-20 01:36:49'),
(449, 'Music Pro', '1745113756_Music Pro.jpg', 1, '2025-04-14 11:02:40', '2025-04-20 01:49:16'),
(450, 'Band-in-a-Box', '1745113779_Band-in-a-Box.jpg', 1, '2025-04-14 11:02:46', '2025-04-20 01:49:39'),
(451, 'Musescore', '1745113798_MuseScore.jpg', 1, '2025-04-14 11:02:52', '2025-04-20 01:49:58'),
(452, 'Maestro', '1745113825_Maestro.jpg', 1, '2025-04-14 11:03:04', '2025-04-20 01:50:25'),
(453, 'ScoreCloud Express', '1745113927_ScoreCloud Express.jpg', 1, '2025-04-14 11:03:10', '2025-04-20 01:52:07'),
(454, 'Flat', '1745113946_Flat.jpg', 1, '2025-04-14 11:03:19', '2025-04-20 01:52:26'),
(455, 'Notion', '1745113975_Notion.jpg', 1, '2025-04-14 11:03:25', '2025-04-20 01:52:55'),
(456, 'Symphony Pro', '1745113993_Symphony Pro.jpg', 1, '2025-04-14 11:03:31', '2025-04-20 01:53:13'),
(457, 'StaffPad', '1745114010_StaffPad.jpg', 1, '2025-04-14 11:03:36', '2025-04-20 01:53:30'),
(458, 'Tonic', '1745114029_Tonic.jpg', 1, '2025-04-14 11:03:42', '2025-04-20 01:53:49'),
(459, 'Blues Guitar Lessons', '1745114060_Blues Guitar Lessons.jpg', 1, '2025-04-14 11:03:48', '2025-04-20 01:54:20'),
(460, 'Piano Scales & Chords', '1745114128_Piano Scales & Chords.jpg', 1, '2025-04-14 11:03:54', '2025-04-20 01:55:28'),
(461, 'Scale, Chord Progressions', '1745114193_Scale, Chord Progressions.jpg', 1, '2025-04-14 11:04:01', '2025-04-20 01:56:33'),
(462, 'Music Maker JAM', '1745114211_Music Maker JAM.jpg', 1, '2025-04-14 11:04:08', '2025-04-20 01:56:51'),
(463, 'Korg Kaossilator', '1745114234_KORG Kaossilator.jpg', 1, '2025-04-14 11:04:13', '2025-04-20 01:57:14'),
(464, 'FL STUDIO MOBILE', '1745114258_FL STUDIO MOBILE.jpg', 1, '2025-04-14 11:04:21', '2025-04-20 01:57:38'),
(465, 'Moises', '1745114326_Moises.jpg', 1, '2025-04-14 11:04:29', '2025-04-20 01:58:46'),
(466, 'Cubasis 3', '1745114356_Cubasis 3.jpg', 1, '2025-04-14 11:04:36', '2025-04-20 01:59:16'),
(467, 'Audio Evolution Mobile TRIAL', '1745115297_Audio Evolution Mobile TRIAL.jpg', 1, '2025-04-14 11:04:42', '2025-04-20 02:14:57'),
(468, 'AUM - Audio Mixer', '1745115315_AUM - Audio Mixer.jpg', 1, '2025-04-14 11:04:48', '2025-04-20 02:15:15'),
(469, 'SunVox', '1745115333_SunVox.jpg', 1, '2025-04-14 11:04:54', '2025-04-20 02:15:33'),
(470, 'BeatMaker 3', '1745115354_BeatMaker 3.jpg', 1, '2025-04-14 11:05:00', '2025-04-20 02:15:54'),
(471, 'n-Track Studio', '1745115387_n-Track Studio.jpg', 1, '2025-04-14 11:05:07', '2025-04-20 02:16:27'),
(472, 'AudioStretch', '1745115602_AudioStretch.jpg', 1, '2025-04-14 11:05:17', '2025-04-20 02:20:02'),
(473, 'Drum Pad Machine', '1745115618_Drum Pad Machine.jpg', 1, '2025-04-14 11:05:23', '2025-04-20 02:20:18'),
(474, 'Musora', '1745638389_Musora.jpg', 1, '2025-04-14 11:05:29', '2025-04-26 03:33:09'),
(475, 'Groovepad', '1745638451_Groovepad.jpg', 1, '2025-04-14 11:05:34', '2025-04-26 03:34:11'),
(476, 'Walk Band', '1745638490_Walk Band.jpg', 1, '2025-04-14 11:05:41', '2025-04-26 03:34:50'),
(478, 'Real Piano', '1745638653_Real Piano.jpg', 1, '2025-04-14 11:05:53', '2025-04-26 03:37:33'),
(479, 'Magic Piano', '1745638700_Magic Piano.jpg', 1, '2025-04-14 11:06:01', '2025-04-26 03:38:20'),
(480, 'Piano Tiles', '1745638726_Piano Tiles.jpg', 1, '2025-04-14 11:06:09', '2025-04-26 03:38:46'),
(481, 'Real Guitar', '1745638749_Real Guitar.jpg', 1, '2025-04-14 11:06:16', '2025-04-26 03:39:09'),
(482, 'Piano Keyboard', '1745638772_Piano Keyboard.jpg', 1, '2025-04-14 11:06:22', '2025-04-26 03:39:32'),
(483, 'Guitar Songs', '1745640266_Guitar Songs.jpg', 1, '2025-04-14 11:06:28', '2025-04-26 04:04:26'),
(484, 'Chord ai', '1745640315_Chord ai.jpg', 1, '2025-04-14 11:06:35', '2025-04-26 04:05:15'),
(485, 'Pro Guitar Tuner', '1745811967_Pro Guitar Tuner.jpg', 1, '2025-04-14 11:06:42', '2025-04-28 03:46:07'),
(486, 'Peak', '1745811996_Peak.jpg', 1, '2025-04-14 13:15:31', '2025-04-28 03:46:36'),
(487, 'Rosetta Stone', '1745812039_Rosetta Stone.jpg', 1, '2025-04-14 13:15:41', '2025-04-28 03:47:19'),
(488, 'Memrise', '1745812068_Memrise.jpg', 1, '2025-04-14 13:15:53', '2025-04-28 03:47:48'),
(489, 'Busuu', '1745812087_Busuu.jpg', 1, '2025-04-14 13:16:04', '2025-04-28 03:48:07'),
(490, 'LingQ', '1745812115_LingQ.jpg', 1, '2025-04-14 13:16:16', '2025-04-28 03:48:35'),
(491, 'Drops', '1745812137_Drops.jpg', 1, '2025-04-14 13:16:25', '2025-04-28 03:48:57'),
(492, 'Beelinguapp', '1745812163_Beelinguapp.jpg', 1, '2025-04-14 13:16:32', '2025-04-28 03:49:23'),
(493, 'Mondly', '1745812183_Mondly.jpg', 1, '2025-04-14 13:16:39', '2025-04-28 03:49:43'),
(494, 'Pimsleur', '1745812203_Pimsleur.jpg', 1, '2025-04-14 13:16:47', '2025-04-28 03:50:03'),
(495, 'LingoDeer', '1745812224_LingoDeer.jpg', 1, '2025-04-14 13:17:00', '2025-04-28 03:50:24'),
(496, 'FluentU', '1745812240_FluentU.jpg', 1, '2025-04-14 13:17:15', '2025-04-28 03:50:40'),
(497, 'Mango Languages', '1745812296_Mango Languages.jpg', 1, '2025-04-14 13:17:20', '2025-04-28 03:51:36'),
(498, 'Duolingo', '1745812339_Duolingo.jpg', 1, '2025-04-14 13:17:38', '2025-04-28 03:52:19'),
(499, 'Quizlet', '1745812361_Quizlet.jpg', 1, '2025-04-14 13:18:01', '2025-04-28 03:52:41'),
(501, 'ArtFlow', '1745812389_ArtFlow.jpg', 1, '2025-04-14 13:18:18', '2025-04-28 03:53:09'),
(503, 'Adobe Fresco', '1745812406_Adobe Fresco.jpg', 1, '2025-04-14 13:18:55', '2025-04-28 03:53:26'),
(504, 'Sketchbook', '1745812426_Sketchbook.jpg', 1, '2025-04-14 13:19:02', '2025-04-28 03:53:46'),
(505, 'Sketchbook', '1745812462_Sketchbook.jpg', 1, '2025-04-14 13:19:11', '2025-04-28 03:54:22'),
(506, 'CorelDraw', '1745812494_CorelDraw.jpg', 1, '2025-04-14 13:19:18', '2025-04-28 03:54:54'),
(507, 'PowerDirector - Video Editor', '1745812524_PowerDirector - Video Editor.jpg', 1, '2025-04-14 13:19:26', '2025-04-28 03:55:24'),
(508, 'STEEZY', '1745812547_STEEZY.jpg', 1, '2025-04-14 13:19:33', '2025-04-28 03:55:47'),
(509, 'Seesaw', '1745812567_Seesaw.jpg', 1, '2025-04-14 13:19:39', '2025-04-28 03:56:07'),
(510, 'GoTube', '1745812590_GoTube.jpg', 1, '2025-04-14 13:19:48', '2025-04-28 03:56:30'),
(511, 'EF Hello', '1745812610_EF Hello.jpg', 1, '2025-04-14 13:19:54', '2025-04-28 03:56:50'),
(512, 'DailyArt', '1745812627_DailyArt.jpg', 1, '2025-04-14 13:20:05', '2025-04-28 03:57:07'),
(513, 'NYT Games', '1745812647_NYT Games.jpg', 1, '2025-04-14 13:20:11', '2025-04-28 03:57:27'),
(514, 'The Wreck', '1745812663_The Wreck.jpg', 1, '2025-04-14 13:20:18', '2025-04-28 03:57:43'),
(516, 'ArtRage', '1745812681_ArtRage.jpg', 1, '2025-04-14 13:20:31', '2025-04-28 03:58:01'),
(517, 'Infinite Painter', '1745812698_Infinite Painter.jpg', 1, '2025-04-14 13:20:40', '2025-04-28 03:58:18'),
(518, 'Adobe Capture: Illustrator,Ps', '1745812772_Adobe Capture Illustrator,Ps.jpg', 1, '2025-04-14 13:20:47', '2025-04-28 03:59:32'),
(519, 'Procreate Pocket', '1745812965_Procreate Pocket.jpg', 1, '2025-04-14 13:20:53', '2025-04-28 04:02:45'),
(520, 'Adobe Scan', '1745812995_Adobe Scan.jpg', 1, '2025-04-14 13:21:00', '2025-04-28 04:03:15'),
(521, 'Adobe Connect', '1745813027_Adobe Connect.jpg', 1, '2025-04-14 13:21:06', '2025-04-28 04:03:47'),
(522, 'Color & Palette', '1745813061_Color & Palette.jpg', 1, '2025-04-14 13:21:14', '2025-04-28 04:04:21'),
(523, 'Adobe Aero', '1745813087_Adobe Aero.jpg', 1, '2025-04-14 13:21:20', '2025-04-28 04:04:47'),
(525, 'Adobe Photoshop', '1745813108_Adobe Photoshop.jpg', 1, '2025-04-14 13:21:34', '2025-04-28 04:05:08'),
(526, 'Adobe XD', '1745813178_Adobe XD.jpg', 1, '2025-04-14 13:21:41', '2025-04-28 04:06:18'),
(527, 'Adobe Premiere Rush', '1745813201_Adobe Premiere Rush.jpg', 1, '2025-04-14 13:21:50', '2025-04-28 04:06:41'),
(528, 'Affinity Photo 2', '1745813231_Affinity Photo 2.jpg', 1, '2025-04-14 13:21:56', '2025-04-28 04:07:11'),
(529, 'Affinity Designer 2', '1745813286_Affinity Designer 2.jpg', 1, '2025-04-14 13:22:03', '2025-04-28 04:08:06'),
(533, 'Autodesk Construction Cloud', '1745813322_Autodesk Construction Cloud.jpg', 1, '2025-04-14 13:22:41', '2025-04-28 04:08:42'),
(534, 'Home AI', '1745813350_Home AI.jpg', 1, '2025-04-14 13:22:52', '2025-04-28 04:09:10'),
(535, 'Autodesk Vault Mobile', '1745813398_Autodesk Vault Mobile.jpg', 1, '2025-04-14 13:23:01', '2025-04-28 04:09:58'),
(536, 'MagiScan - AI 3D', '1745813425_MagiScan - AI 3D.jpg', 1, '2025-04-14 13:23:08', '2025-04-28 04:10:25'),
(537, '3D Modeling App', '1745813455_3D Modeling App.jpg', 1, '2025-04-14 13:23:18', '2025-04-28 04:10:55'),
(538, 'Autodesk Fusion', '1745813478_Autodesk Fusion.jpg', 1, '2025-04-14 13:23:25', '2025-04-28 04:11:18'),
(539, 'Alias', '1745813503_Alias.jpg', 1, '2025-04-14 13:23:31', '2025-04-28 04:11:43'),
(540, 'Nomad Sculpt', '1745813568_Nomad Sculpt.jpg', 1, '2025-04-14 13:23:37', '2025-04-28 04:12:48'),
(542, 'Pixelcut AI Photo Editor', '1745813613_Pixelcut AI Photo Editor.jpg', 1, '2025-04-14 13:25:12', '2025-04-28 04:13:33'),
(543, 'AutoCAD', '1745813851_AutoCAD.jpg', 1, '2025-04-14 13:25:20', '2025-04-28 04:17:31'),
(579, 'Khan Academy', '1745813868_Khan Academy.jpg', 1, '2025-04-14 13:31:08', '2025-04-28 04:17:48');
INSERT INTO `products` (`id`, `product_name`, `product_image`, `status`, `created_at`, `updated_at`) VALUES
(580, 'Coursera', '1745814350_Coursera.jpg', 1, '2025-04-14 13:31:17', '2025-04-28 04:25:50'),
(583, 'Educate', '1745814377_Educate.jpg', 1, '2025-04-14 13:31:48', '2025-04-28 04:26:17'),
(584, 'Mimo', '1745814407_Mimo.jpg', 1, '2025-04-14 13:31:59', '2025-04-28 04:26:47'),
(593, 'Elevate', '1745814443_Elevate.jpg', 1, '2025-04-14 13:33:24', '2025-04-28 04:27:23'),
(594, 'Math Workout', '1745814472_Math Workout.jpg', 1, '2025-04-14 13:33:32', '2025-04-28 04:27:52'),
(595, 'Photoshop Express', '1745814505_Photoshop Express.jpg', 1, '2025-04-14 13:33:39', '2025-04-28 04:28:25'),
(598, 'MediBang Paint', '1745814533_MediBang Paint.jpg', 1, '2025-04-14 13:34:03', '2025-04-28 04:28:53'),
(599, 'Sekolah.mu', '1745814732_Sekolah.mu.jpg', 1, '2025-04-14 13:34:10', '2025-04-28 04:32:12'),
(600, 'Ruangguru', '1745814888_Ruangguru.jpg', 1, '2025-04-14 13:34:16', '2025-04-28 04:34:48'),
(601, 'Zenius', '1745814906_Zenius.jpg', 1, '2025-04-14 13:34:22', '2025-04-28 04:35:06'),
(602, 'Brainly', '1745814923_Brainly.jpg', 1, '2025-04-14 13:34:28', '2025-04-28 04:35:23'),
(603, 'Alison', '1745814955_Alison.jpg', 1, '2025-04-14 13:34:34', '2025-04-28 04:35:55'),
(604, 'Udemy', '1745814993_Edemy.jpg', 1, '2025-04-14 13:34:40', '2025-04-28 04:36:33'),
(605, 'Skillshare', '1745815013_Skillshare.jpg', 1, '2025-04-14 13:34:48', '2025-04-28 04:36:53'),
(607, 'Photomath', '1745815030_Photomath.jpg', 1, '2025-04-14 13:35:03', '2025-04-28 04:37:10'),
(608, 'WolframAlpha', '1745815057_WolframAlpha.jpg', 1, '2025-04-14 13:35:10', '2025-04-28 04:37:37'),
(610, 'NeuroNation', '1745815084_NeuroNation.jpg', 1, '2025-04-14 13:35:22', '2025-04-28 04:38:04'),
(611, 'Lumosity', '1745815101_Lumosity.jpg', 1, '2025-04-14 13:35:27', '2025-04-28 04:38:21'),
(613, 'Babbel', '1745815163_Babbel.jpg', 1, '2025-04-14 13:35:39', '2025-04-28 04:39:23'),
(619, 'HelloTalk', '1745815208_HelloTalk.jpg', 1, '2025-04-14 13:36:18', '2025-04-28 04:40:08'),
(620, 'Tandem', '1745815645_Tandem.jpg', 1, '2025-04-14 13:36:28', '2025-04-28 04:47:25'),
(622, 'Clozemaster', '1748090315_Clozemaster.jpg', 1, '2025-04-14 13:36:40', '2025-05-24 12:38:35'),
(623, 'Quizizz', '1748090417_Quizizz.jpg', 1, '2025-04-14 13:36:45', '2025-05-24 12:40:17'),
(624, 'Trello', '1748090499_Trello.jpg', 1, '2025-04-14 13:36:51', '2025-05-24 12:41:39'),
(625, 'Slack', '1748090517_Slack.jpg', 1, '2025-04-14 13:36:57', '2025-05-24 12:41:57'),
(626, 'Zoom', '1748090546_Zoom.jpg', 1, '2025-04-14 13:37:05', '2025-05-24 12:42:26'),
(627, 'Dropbox', '1748090562_Dropbox.jpg', 1, '2025-04-14 13:37:11', '2025-05-24 12:42:42'),
(628, 'Adobe Acrobat Reader', '1748090589_Adobe Acrobat Reader.jpg', 1, '2025-04-14 13:37:17', '2025-05-24 12:43:09'),
(629, 'Foxit PDF Editor', '1748090615_Foxit PDF Editor.jpg', 1, '2025-04-14 13:37:23', '2025-05-24 12:43:35'),
(630, 'WPS Office', '1748090633_WPS Office.jpg', 1, '2025-04-14 13:37:29', '2025-05-24 12:43:53'),
(631, 'CamScanner', '1748090648_CamScanner.jpg', 1, '2025-04-14 13:37:38', '2025-05-24 12:44:08'),
(632, 'OfficeSuite Pro', '1748090673_OfficeSuite Pro.jpg', 1, '2025-04-14 13:37:44', '2025-05-24 12:44:33'),
(633, 'Notability', '1748090689_Notability.jpg', 1, '2025-04-14 13:37:49', '2025-05-24 12:44:49'),
(634, 'Easy Notes', '1748090720_Easy Notes.jpg', 1, '2025-04-14 13:37:55', '2025-05-24 12:45:20'),
(635, 'Explain Everything Whiteboard', '1748090763_Explain Everything Whiteboard.jpg', 1, '2025-04-14 13:38:09', '2025-05-24 12:46:03'),
(636, 'Padlet', '1748090781_Padlet.jpg', 1, '2025-04-14 13:38:17', '2025-05-24 12:46:21'),
(637, 'FLIP', '1748090814_FLIP.jpg', 1, '2025-04-14 13:38:26', '2025-05-24 12:46:54'),
(639, 'ClassDojo', '1748090832_ClassDojo.jpg', 1, '2025-04-14 13:38:42', '2025-05-24 12:47:12'),
(640, 'Kahoot!', '1748090850_Kahoot!.jpg', 1, '2025-04-14 13:38:49', '2025-05-24 12:47:30'),
(641, 'Socrative Student', '1748090893_Socrative Student.jpg', 1, '2025-04-14 13:38:57', '2025-05-24 12:48:13'),
(642, 'IXL - Math and English', '1750861007_IXL - Math and English.jpg', 1, '2025-04-14 13:39:03', '2025-06-25 14:16:47'),
(643, 'Gimkit', '1748090969_Gimkit.jpg', 1, '2025-04-14 13:39:11', '2025-05-24 12:49:29'),
(644, 'Edpuzzle', '1748090989_Edpuzzle.jpg', 1, '2025-04-14 13:39:19', '2025-05-24 12:49:49'),
(645, 'Nearpod', '1748091032_Nearpod.jpg', 1, '2025-04-14 13:39:25', '2025-05-24 12:50:32'),
(646, 'Edulastic', '1748091053_Edulastic.jpg', 1, '2025-04-14 13:39:31', '2025-05-24 12:50:53'),
(647, 'Classcraft', '1748091074_Classcraft.jpg', 1, '2025-04-14 13:39:37', '2025-05-24 12:51:14'),
(649, 'Canvas Student', '1748091120_Canvas Student.jpg', 1, '2025-04-14 13:39:49', '2025-05-24 12:52:00'),
(650, 'Adobe Express', '1748091180_Adobe Express.jpg', 1, '2025-04-14 13:39:59', '2025-05-24 12:53:00'),
(651, 'Animoto', '1748091202_Animoto.jpg', 1, '2025-04-14 13:40:05', '2025-05-24 12:53:22'),
(652, 'Toca Boca World', '1748091242_Toca Boca World.jpg', 1, '2025-04-14 13:51:40', '2025-05-24 12:54:02'),
(653, 'PBS Kids Games', '1748091261_PBS KIDS Games.jpg', 1, '2025-04-14 13:51:47', '2025-05-24 12:54:21'),
(654, 'ABCmouse.com', '1748091276_ABCmouse.jpg', 1, '2025-04-14 13:51:57', '2025-05-24 12:54:36'),
(656, 'Pepi Hospital', '1748091365_Pepi Hospital.jpg', 1, '2025-04-14 13:52:12', '2025-05-24 12:56:05'),
(657, 'Pepi Super Stores', '1748091384_Pepi Super Stores.jpg', 1, '2025-04-14 13:52:18', '2025-05-24 12:56:24'),
(658, 'My Town: Home', '1748091448_My Town Home.jpg', 1, '2025-04-14 13:52:26', '2025-05-24 12:57:28'),
(659, 'My Town: School', '1748091474_My Town School.jpg', 1, '2025-04-14 13:52:57', '2025-05-24 12:57:54'),
(660, 'My Town : Airport', '1748091782_My Town  Airport.jpg', 1, '2025-04-14 13:53:05', '2025-05-24 13:03:02'),
(661, 'My Town : Hospital', '1748091824_My Town Hospital.jpg', 1, '2025-04-14 13:53:12', '2025-05-24 13:03:44'),
(662, 'Dr. Panda Restaurant', '1748091847_Dr. Panda Restaurant.jpg', 1, '2025-04-14 13:53:21', '2025-05-24 13:04:07'),
(663, 'Dr. Panda Town Tales', '1748091926_Dr. Panda Town Tales.jpg', 1, '2025-04-14 13:53:30', '2025-05-24 13:05:26'),
(664, 'Dr. Panda Daycare', '1748091943_Dr. Panda Daycare.jpg', 1, '2025-04-14 13:53:37', '2025-05-24 13:05:43'),
(665, 'Sago Mini Friends', '1748092875_Sago Mini Friends.jpg', 1, '2025-04-14 13:53:45', '2025-05-24 13:21:15'),
(666, 'Sago Mini World', '1748092895_Sago Mini World.jpg', 1, '2025-04-14 13:53:53', '2025-05-24 13:21:35'),
(667, 'Sago Mini Babies', '1748092915_Sago Mini Babies.jpg', 1, '2025-04-14 13:54:01', '2025-05-24 13:21:55'),
(668, 'Sago Mini School', '1748092938_Sago Mini School.jpg', 1, '2025-04-14 13:54:10', '2025-05-24 13:22:18'),
(669, 'LEGO DUPLO World', '1748092958_LEGO DUPLO World.jpg', 1, '2025-04-14 13:54:20', '2025-05-24 13:22:38'),
(670, 'LEGO Tower', '1748092977_LEGO Tower.jpg', 1, '2025-04-14 13:54:28', '2025-05-24 13:22:57'),
(671, 'LEGO Play', '1748093032_LEGO Play.jpg', 1, '2025-04-14 13:54:40', '2025-05-24 13:23:52'),
(672, 'LEGO Friends: Heartlake Rush', '1748093087_LEGO Friends Heartlake Rush.jpg', 1, '2025-04-14 13:54:57', '2025-05-24 13:24:47'),
(673, 'LEGO HIDDEN SIDE', '1748093340_LEGO HIDDEN SIDE.png', 1, '2025-04-14 13:55:09', '2025-05-24 13:29:00'),
(674, 'LEGO Super Mario', '1748093499_LEGO Super Mario.jpg', 1, '2025-04-14 13:55:18', '2025-05-24 13:31:39'),
(675, 'LEGO Legacy: Heroes Unboxed', '1748093530_LEGO Legacy Heroes Unboxed.jpg', 1, '2025-04-14 13:55:25', '2025-05-24 13:32:10'),
(676, 'LEGO Ninjago: Shadow of Ronin', '1748093586_LEGO Ninjago Shadow of Ronin.jpg', 1, '2025-04-14 13:55:33', '2025-05-24 13:33:06'),
(677, 'LEGO Brawls', '1748093605_LEGO Brawls.jpg', 1, '2025-04-14 13:55:43', '2025-05-24 13:33:25'),
(678, 'BabyBus Kids: Baby Game World', '1748093700_BabyBus Kids Baby Game World.jpg', 1, '2025-04-14 13:55:54', '2025-05-24 13:35:00'),
(679, 'Baby Panda\'s Supermarket', '1748093739_Baby Panda\'s Supermarket.jpg', 1, '2025-04-14 13:56:03', '2025-05-24 13:35:39'),
(680, 'Baby Panda\'s School Bus', '1748093799_Baby Panda\'s School Bus.jpg', 1, '2025-04-14 13:56:13', '2025-05-24 13:36:39'),
(681, 'Baby Panda Earthquake Safety 1', '1748093941_Baby Panda Earthquake Safety 1.jpg', 1, '2025-04-14 13:56:20', '2025-05-24 13:39:01'),
(682, 'Baby Panda Earthquake Safety 2', '1748093974_Baby Panda Earthquake Safety 2.jpg', 1, '2025-04-14 13:56:27', '2025-05-24 13:39:34'),
(683, 'Baby Panda: Cooking Party', '1750859011_Baby Panda Cooking Party.jpg', 1, '2025-04-14 13:56:34', '2025-06-25 13:43:31'),
(684, 'Baby Panda World-Learning Game', '1750859075_Baby Panda World-Learning Game.jpg', 1, '2025-04-14 13:56:40', '2025-06-25 13:44:35'),
(685, 'Disney Colouring World', '1750859168_Disney Colouring World.jpg', 1, '2025-04-14 13:56:49', '2025-06-25 13:46:08'),
(686, 'Disney Story Realms', '1750859304_Disney Story Realms.jpg', 1, '2025-04-14 13:56:59', '2025-06-25 13:48:24'),
(687, 'Disney Frozen Free Fall', '1750859329_Disney Frozen Free Fall.jpg', 1, '2025-04-14 13:57:06', '2025-06-25 13:48:49'),
(688, 'Math Makers: Kids School Games', '1750859379_Math Makers Kids School Games.jpg', 1, '2025-04-14 13:57:13', '2025-06-25 13:49:39'),
(689, 'Moana Island Life', '1750859413_Moana Island Life.jpg', 1, '2025-04-14 13:57:20', '2025-06-25 13:50:13'),
(690, 'Hello Kitty Lunchbox', '1750859450_Hello Kitty Lunchbox.jpg', 1, '2025-04-14 13:57:26', '2025-06-25 13:50:50'),
(691, 'Hello Kitty Nail Salon', '1750859484_Hello Kitty Nail Salon.jpg', 1, '2025-04-14 13:57:34', '2025-06-25 13:51:24'),
(692, 'Barbie Dreamhouse Adventures', '1750859536_Barbie Dreamhouse Adventures.jpg', 1, '2025-04-14 13:57:43', '2025-06-25 13:52:16'),
(693, 'Barbie Magical Fashion', '1750859560_Barbie Magical Fashion.jpg', 1, '2025-04-14 13:57:51', '2025-06-25 13:52:40'),
(694, 'Barbie Fashion Closet', '1750859599_Barbie Fashion Closet.jpg', 1, '2025-04-14 13:57:57', '2025-06-25 13:53:19'),
(695, 'Barbie Dreamtopia', '1750859640_Barbie Dreamtopia.jpg', 1, '2025-04-14 13:58:08', '2025-06-25 13:54:00'),
(696, 'PJ Masks : Moonlight Heroes', '1750859705_PJ Masks Moonlight Heroes.jpg', 1, '2025-04-14 13:58:15', '2025-06-25 13:55:05'),
(697, 'PJ Masks : Racing Heroes', '1750859776_PJ Masks Racing Heroes.jpg', 1, '2025-04-14 13:58:22', '2025-06-25 13:56:16'),
(698, 'PJ Masks : Power Heroes', '1750859822_PJ Masks Power Heroes.jpg', 1, '2025-04-14 13:58:29', '2025-06-25 13:57:02'),
(699, 'Peppa Pig: Peppa and Her Golden Boots', '1750859890_Peppa Pig Peppa and Her Golden Boots.jpg', 1, '2025-04-14 13:58:40', '2025-06-25 13:58:10'),
(700, 'Peppa Pig Theme Park Florida', '1750859923_Peppa Pig Theme Park Florida.jpg', 1, '2025-04-14 13:58:45', '2025-06-25 13:58:43'),
(701, 'Peppa Pig: Holiday Adventures', '1750859975_Peppa Pig Holiday Adventures.jpg', 1, '2025-04-14 13:58:52', '2025-06-25 13:59:35'),
(702, 'Thomas & Friends: Go Go Thomas', '1750860013_Thomas & Friends Go Go Thomas.jpg', 1, '2025-04-14 14:02:48', '2025-06-25 14:00:13'),
(703, 'Thomas & Friends: Magic Tracks', '1750860083_Thomas & Friends Magic Tracks.jpg', 1, '2025-04-14 14:02:55', '2025-06-25 14:01:23'),
(704, 'PAW Patrol Rescue World', '1750860119_PAW Patrol Rescue World.jpg', 1, '2025-04-14 14:03:02', '2025-06-25 14:01:59'),
(705, 'PAW Patrol Air and Sea Adventures', '1750860186_PAW Patrol Air and Sea Adventures.jpg', 1, '2025-04-14 14:03:10', '2025-06-25 14:03:06'),
(706, 'PAW Patrol: Pups to the Rescue', '1750860243_PAW Patrol Pups to the Rescue.jpg', 1, '2025-04-14 14:03:19', '2025-06-25 14:04:03'),
(707, 'Nick Jr Play', '1750860293_Nick Jr Play.jpg', 1, '2025-04-14 14:03:26', '2025-06-25 14:04:53'),
(708, 'Bluey: Let\'s Play!', '1750860340_Bluey Let\'s Play!.jpg', 1, '2025-04-14 14:03:32', '2025-06-25 14:05:40'),
(709, 'SpongeBob: Krusty Cook-Off', '1750860388_SpongeBob Krusty Cook-Off.jpg', 1, '2025-04-14 14:03:39', '2025-06-25 14:06:28'),
(710, 'SpongeBob SquarePants', '1750860428_SpongeBob SquarePants.jpg', 1, '2025-04-14 14:03:47', '2025-06-25 14:07:08'),
(711, 'Talking Tom Cat', '1750860490_Talking Tom Cat.jpg', 1, '2025-04-14 14:03:52', '2025-06-25 14:08:10'),
(712, 'Talking Tom Gold Run', '1750860514_Talking Tom Gold Run.jpg', 1, '2025-04-14 14:03:58', '2025-06-25 14:08:34'),
(713, 'Talking Angela', '1750860543_Talking Angela.jpg', 1, '2025-04-14 14:04:04', '2025-06-25 14:09:03'),
(714, 'Talking Ben the Dog', '1750860598_Talking Ben the Dog.jpg', 1, '2025-04-14 14:04:15', '2025-06-25 14:09:58'),
(715, 'Taking Ginger', '1750860667_Taking Ginger.jpg', 1, '2025-04-14 14:04:30', '2025-06-25 14:11:07'),
(716, 'My Talking Tom Friends', '1750860734_My Talking Tom Friends.jpg', 1, '2025-04-14 14:04:36', '2025-06-25 14:12:14'),
(717, 'Animal Jam', '1750860785_Animal Jam.jpg', 1, '2025-04-14 14:04:45', '2025-06-25 14:13:05'),
(718, 'WildCraft: Animal Sim Online', '1750860848_WildCraft Animal Sim Online.jpg', 1, '2025-04-14 14:04:52', '2025-06-25 14:14:08'),
(719, 'Zoo Craft: Animal Park Tycoon', '1750861199_Zoo Craft Animal Park Tycoon.jpg', 1, '2025-04-14 14:04:59', '2025-06-25 14:19:59'),
(720, 'Toca Boca Jr', '1750861234_Toca Boca Jr.jpg', 1, '2025-04-14 14:05:12', '2025-06-25 14:20:34'),
(721, 'Toca Hair Salon 3', '1750861264_Toca Hair Salon 3.jpg', 1, '2025-04-14 14:05:29', '2025-06-25 14:21:04'),
(722, 'Toca Nature', '1750861295_Toca Nature.jpg', 1, '2025-04-14 14:05:36', '2025-06-25 14:21:35'),
(723, 'Toca Life: Hospital', '1750861341_Toca Life Hospital.jpg', 1, '2025-04-14 14:05:44', '2025-06-25 14:22:21'),
(724, 'Toca Life: School', '1750861378_Toca Life School.jpg', 1, '2025-04-14 14:05:50', '2025-06-25 14:22:58'),
(725, 'Toca Life: Office', '1750861453_Toca Life Office.jpg', 1, '2025-04-14 14:05:56', '2025-06-25 14:24:13'),
(726, 'Toca Life: Pets', '1750861493_Toca Life Pets.jpg', 1, '2025-04-14 14:06:03', '2025-06-25 14:24:53'),
(727, 'Toca Life: Farm', '1750861526_Toca Life Farm.jpg', 1, '2025-04-14 14:06:09', '2025-06-25 14:25:26'),
(728, 'Toca Life: Vacation', '1750861565_Toca Life Vacation.jpg', 1, '2025-04-14 14:06:18', '2025-06-25 14:26:05'),
(729, 'Toca Life: Stable', '1750861613_Toca Life Stable.jpg', 1, '2025-04-14 14:06:24', '2025-06-25 14:26:53'),
(730, 'Toca Lab: Elements', '1750861654_Toca Lab Elements.jpg', 1, '2025-04-14 14:06:31', '2025-06-25 14:27:34'),
(731, 'Toca Lab: Plants', '1750861684_Toca Lab Plants.jpg', 1, '2025-04-14 14:06:36', '2025-06-25 14:28:04'),
(732, 'Masha and the Bear Educational', '1750861779_Masha and the Bear Educational.jpg', 1, '2025-04-14 14:06:44', '2025-06-25 14:29:39'),
(733, 'Masha and the Bear: Cooking', '1750861819_Masha and the Bear Cooking.jpg', 1, '2025-04-14 14:06:50', '2025-06-25 14:30:19'),
(734, 'Masha and the Bear: Good Night', NULL, 1, '2025-04-14 14:06:57', '2025-04-14 14:06:57'),
(735, 'Booba: Educational Games', NULL, 1, '2025-04-14 14:07:04', '2025-04-14 14:07:04'),
(736, 'Booba: Food Puzzle', NULL, 1, '2025-04-14 14:07:10', '2025-04-14 14:07:10'),
(737, 'Booba: Coloring Book', NULL, 1, '2025-04-14 14:07:16', '2025-04-14 14:07:16'),
(738, 'Fishing Kids', NULL, 1, '2025-04-14 14:07:25', '2025-04-14 14:07:25'),
(739, 'Hide and Seek: Cat Escape!', NULL, 1, '2025-04-14 14:07:37', '2025-04-14 14:07:37'),
(740, 'Animal Hair Salon', NULL, 1, '2025-04-14 14:07:51', '2025-04-14 14:07:51'),
(741, 'Pet World – My Animal Hospital', NULL, 1, '2025-04-14 14:08:06', '2025-04-14 14:08:06'),
(742, 'Animal Rescue', NULL, 1, '2025-04-14 14:08:13', '2025-04-14 14:08:13'),
(743, 'Little Panda’s Restaurant', NULL, 1, '2025-04-14 14:08:24', '2025-04-14 14:08:24'),
(744, 'Bini Super ABC', NULL, 1, '2025-04-14 14:08:31', '2025-04-14 14:08:31'),
(745, 'Bini Toddler Drawing', NULL, 1, '2025-04-14 14:08:38', '2025-04-14 14:08:38'),
(746, 'Funny Food: Kids Learning Games', NULL, 1, '2025-04-14 14:08:44', '2025-04-14 14:08:44'),
(747, 'Kids Piano', NULL, 1, '2025-04-14 14:08:50', '2025-04-14 14:08:50'),
(748, 'Kids Doodle', NULL, 1, '2025-04-14 14:08:55', '2025-04-14 14:08:55'),
(749, 'Coloring & Learn', NULL, 1, '2025-04-14 14:09:02', '2025-04-14 14:09:02'),
(750, 'Kids Learn to Read', NULL, 1, '2025-04-14 14:09:08', '2025-04-14 14:09:08'),
(751, 'Starfall ABCs', NULL, 1, '2025-04-14 14:09:15', '2025-04-14 14:09:15'),
(752, 'Starfall Learn to Read', NULL, 1, '2025-04-14 14:09:27', '2025-04-14 14:09:27'),
(753, 'Duck Duck Moose Reading', NULL, 1, '2025-04-14 14:09:34', '2025-04-14 14:09:34'),
(754, 'Duck Duck Moose Trucks', NULL, 1, '2025-04-14 14:09:40', '2025-04-14 14:09:40'),
(755, 'Duck Duck Moose Fish School', NULL, 1, '2025-04-14 14:09:46', '2025-04-14 14:09:46'),
(756, 'Duck Duck Moose Puzzle Pop', NULL, 1, '2025-04-14 14:09:51', '2025-04-14 14:09:51'),
(757, 'Duck Duck Moose Superhero School', NULL, 1, '2025-04-14 14:09:58', '2025-04-14 14:09:58'),
(758, 'Endless Alphabet', NULL, 1, '2025-04-14 14:10:04', '2025-04-14 14:10:04'),
(759, 'Endless Reader', NULL, 1, '2025-04-14 14:10:11', '2025-04-14 14:10:11'),
(760, 'Endless Numbers', NULL, 1, '2025-04-14 14:10:19', '2025-04-14 14:10:19'),
(761, 'Endless Wordplay', NULL, 1, '2025-04-14 14:10:27', '2025-04-14 14:10:27'),
(762, 'Endless Spanish', NULL, 1, '2025-04-14 14:10:34', '2025-04-14 14:10:34'),
(763, 'ABC Kids – Tracing & Phonics', NULL, 1, '2025-04-14 14:10:40', '2025-04-14 14:10:40'),
(764, 'ABC Tracing Preschool', NULL, 1, '2025-04-14 14:10:47', '2025-04-14 14:10:47'),
(765, 'Phonics Genius', NULL, 1, '2025-04-14 14:10:53', '2025-04-14 14:10:53'),
(766, 'Sight Words – Dolch List', NULL, 1, '2025-04-14 14:11:05', '2025-04-14 14:11:05'),
(767, 'Montessori Preschool', NULL, 1, '2025-04-14 14:11:13', '2025-04-14 14:11:13'),
(768, 'Montessorium: Intro to Letters', NULL, 1, '2025-04-14 14:11:27', '2025-04-14 14:11:27'),
(769, 'Montessorium: Intro to Math', NULL, 1, '2025-04-14 14:11:33', '2025-04-14 14:11:33'),
(770, 'Montessorium: Geography', NULL, 1, '2025-04-14 14:11:40', '2025-04-14 14:11:40'),
(771, 'Montessori Math City', NULL, 1, '2025-04-14 14:11:47', '2025-04-14 14:11:47'),
(772, 'Montessori Numbers', NULL, 1, '2025-04-14 14:11:56', '2025-04-14 14:11:56'),
(773, 'Busy Shapes', NULL, 1, '2025-04-14 14:12:03', '2025-04-14 14:12:03'),
(774, 'Busy Water', NULL, 1, '2025-04-14 14:12:10', '2025-04-14 14:12:10'),
(775, 'Shapes Toddler Preschool', NULL, 1, '2025-04-14 14:12:16', '2025-04-14 14:12:16'),
(776, 'Colors & Shapes - Kids Learn Color and Shape', NULL, 1, '2025-04-14 14:12:22', '2025-04-14 14:12:22'),
(777, 'Math Kids', NULL, 1, '2025-04-14 14:12:30', '2025-04-14 14:12:30'),
(778, 'Moose Math', NULL, 1, '2025-04-14 14:12:39', '2025-04-14 14:12:39'),
(779, 'Todo Math', NULL, 1, '2025-04-14 14:12:47', '2025-04-14 14:12:47'),
(780, 'Counting Caterpillar', NULL, 1, '2025-04-14 14:12:58', '2025-04-14 14:12:58'),
(781, 'Count the Animals', NULL, 1, '2025-04-14 14:13:03', '2025-04-14 14:13:03'),
(782, 'GCompris', NULL, 1, '2025-04-14 14:13:08', '2025-04-14 14:13:08'),
(783, 'Khan Kids: Early Learning', NULL, 1, '2025-04-14 14:13:14', '2025-04-14 14:13:14'),
(784, 'LooLoo Kids: Learning App', NULL, 1, '2025-04-14 14:13:21', '2025-04-14 14:13:21'),
(785, 'Lingokids – Playlearning™', NULL, 1, '2025-04-14 14:13:28', '2025-04-14 14:13:28'),
(786, 'Puzzingo Kids Puzzles', NULL, 1, '2025-04-14 14:13:34', '2025-04-14 14:13:34'),
(787, 'Kids Puzzles Game', NULL, 1, '2025-04-14 14:13:42', '2025-04-14 14:13:42'),
(788, 'Jigsaw Puzzles for Kids', NULL, 1, '2025-04-14 14:14:20', '2025-04-14 14:14:20'),
(789, 'Animal Puzzles for Kids', NULL, 1, '2025-04-14 14:14:28', '2025-04-14 14:14:28'),
(790, 'Puzzle Kids – Animals Shapes and Jigsaw Puzzles', NULL, 1, '2025-04-14 14:14:37', '2025-04-14 14:14:37'),
(791, 'Bimi Boo Kids Learning Academy', NULL, 1, '2025-04-14 14:14:44', '2025-04-14 14:14:44'),
(792, 'Bimi Boo Kids Games', NULL, 1, '2025-04-14 14:14:51', '2025-04-14 14:14:51'),
(793, 'Baby Games for 2, 3, 4 Year Olds', NULL, 1, '2025-04-14 14:14:58', '2025-04-14 14:14:58'),
(794, 'Kids Academy', NULL, 1, '2025-04-14 14:15:05', '2025-04-14 14:15:05'),
(795, 'Learn to Draw & Coloring', NULL, 1, '2025-04-14 14:15:13', '2025-04-14 14:15:13'),
(796, 'Drawing for Kids', NULL, 1, '2025-04-14 14:15:19', '2025-04-14 14:15:19'),
(797, 'Doodle Coloring Book', NULL, 1, '2025-04-14 14:15:31', '2025-04-14 14:15:31'),
(798, 'Little Panda’s Drawing Board', NULL, 1, '2025-04-14 14:15:38', '2025-04-14 14:15:38'),
(799, 'Drawing Desk', NULL, 1, '2025-04-14 14:15:46', '2025-04-14 14:15:46'),
(800, 'ABCya Games', NULL, 1, '2025-04-14 14:15:52', '2025-04-14 14:15:52'),
(801, 'Funbrain Jr.', NULL, 1, '2025-04-14 14:15:58', '2025-04-14 14:15:58'),
(802, 'Curious George: Letters', NULL, 1, '2025-04-14 14:16:06', '2025-04-14 14:16:06'),
(803, 'Curious World', NULL, 1, '2025-04-14 14:16:15', '2025-04-14 14:16:15'),
(804, 'Clifford the Big Red Dog', NULL, 1, '2025-04-14 14:16:23', '2025-04-14 14:16:23'),
(805, 'Elmo Loves ABCs', NULL, 1, '2025-04-14 14:16:50', '2025-04-14 14:16:50'),
(806, 'Elmo Loves 123s', NULL, 1, '2025-04-14 14:16:57', '2025-04-14 14:16:57'),
(807, 'Sesame Street Alphabet Kitchen', NULL, 1, '2025-04-14 14:17:17', '2025-04-14 14:17:17'),
(808, 'Grover’s Daily Routine', NULL, 1, '2025-04-14 14:17:25', '2025-04-14 14:17:25'),
(809, 'Daniel Tiger’s Day & Night', NULL, 1, '2025-04-14 14:17:32', '2025-04-14 14:17:32'),
(810, 'Daniel Tiger’s Stop & Go', NULL, 1, '2025-04-14 14:17:37', '2025-04-14 14:17:37'),
(811, 'Daniel Tiger’s Neighborhood', NULL, 1, '2025-04-14 14:17:44', '2025-04-14 14:17:44'),
(812, 'Daniel Tiger’s Grr-ific Feelings', NULL, 1, '2025-04-14 14:17:50', '2025-04-14 14:17:50'),
(813, 'Caillou House of Puzzles', NULL, 1, '2025-04-14 14:18:00', '2025-04-14 14:18:00'),
(814, 'Caillou Check Up', NULL, 1, '2025-04-14 14:18:09', '2025-04-14 14:18:09'),
(815, 'Caillou Let\'s Pretend', NULL, 1, '2025-04-14 14:18:15', '2025-04-14 14:18:15'),
(816, 'Bob the Builder: Build It', NULL, 1, '2025-04-14 14:18:23', '2025-04-14 14:18:23'),
(817, 'Bob the Builder: Playtime Fun', NULL, 1, '2025-04-14 14:18:33', '2025-04-14 14:18:33'),
(818, 'Dora the Explorer Adventures', NULL, 1, '2025-04-14 14:18:43', '2025-04-14 14:18:43'),
(819, 'Diego’s Animal Rescue', NULL, 1, '2025-04-14 14:18:50', '2025-04-14 14:18:50'),
(820, 'Go Diego Go! Safari Rescue', NULL, 1, '2025-04-14 14:18:57', '2025-04-14 14:18:57'),
(821, 'Strawberry Shortcake BerryRush', NULL, 1, '2025-04-14 14:19:03', '2025-04-14 14:19:03'),
(822, 'Strawberry Shortcake Bake Shop', NULL, 1, '2025-04-14 14:19:10', '2025-04-14 14:19:10'),
(823, 'My Little Pony: Harmony Quest', NULL, 1, '2025-04-14 14:19:19', '2025-04-14 14:19:19'),
(824, 'My Little Pony: Magic Princess', NULL, 1, '2025-04-14 14:19:25', '2025-04-14 14:19:25'),
(825, 'Littlest Pet Shop', NULL, 1, '2025-04-14 14:19:31', '2025-04-14 14:19:31'),
(826, 'FurReal Friends', NULL, 1, '2025-04-14 14:19:37', '2025-04-14 14:19:37'),
(827, 'LOL Surprise! Ball Pop', NULL, 1, '2025-04-14 14:19:48', '2025-04-14 14:19:48'),
(828, 'LOL Surprise! House of Surprises', NULL, 1, '2025-04-14 14:19:55', '2025-04-14 14:19:55'),
(829, 'Unicorn Dress Up', NULL, 1, '2025-04-14 14:20:02', '2025-04-14 14:20:02'),
(830, 'Unicorn Coloring Book', NULL, 1, '2025-04-14 14:20:10', '2025-04-14 14:20:10'),
(831, 'Princess Salon', NULL, 1, '2025-04-14 14:20:19', '2025-04-14 14:20:19'),
(832, 'Princess Makeup Salon', NULL, 1, '2025-04-14 14:20:30', '2025-04-14 14:20:30'),
(833, 'Princess Puzzle', NULL, 1, '2025-04-14 14:20:43', '2025-04-14 14:20:43'),
(834, 'Fairy Tales – Bedtime Stories', NULL, 1, '2025-04-14 14:20:51', '2025-04-14 14:20:51'),
(835, 'Fairy Tale Coloring Game', NULL, 1, '2025-04-14 14:20:59', '2025-04-14 14:20:59'),
(836, 'Cinderella Storybook Deluxe', NULL, 1, '2025-04-14 14:21:06', '2025-04-14 14:21:06'),
(837, 'Snow White and the Seven Dwarfs Game', NULL, 1, '2025-04-14 14:21:15', '2025-04-14 14:21:15'),
(838, 'Beauty and the Beast: Storybook', NULL, 1, '2025-04-14 14:21:30', '2025-04-14 14:21:30'),
(839, 'Frozen Adventures', NULL, 1, '2025-04-14 14:21:37', '2025-04-14 14:21:37'),
(840, 'Olaf’s Adventures', NULL, 1, '2025-04-14 14:21:44', '2025-04-14 14:21:44'),
(841, 'Tangled: The Game', NULL, 1, '2025-04-14 14:21:50', '2025-04-14 14:21:50'),
(842, 'Minions Paradise', NULL, 1, '2025-04-14 14:22:03', '2025-04-14 14:22:03'),
(843, 'Despicable Me: Minion Rush', NULL, 1, '2025-04-14 14:22:10', '2025-04-14 14:22:10'),
(844, 'Ice Age Adventures', NULL, 1, '2025-04-14 14:22:17', '2025-04-14 14:22:17'),
(845, 'Madagascar: Join the Circus!', NULL, 1, '2025-04-14 14:22:24', '2025-04-14 14:22:24'),
(846, 'Madagascar Preschool Surf n\' Slide', NULL, 1, '2025-04-14 14:22:31', '2025-04-14 14:22:31'),
(847, 'Turbo FAST', NULL, 1, '2025-04-14 14:22:47', '2025-04-14 14:22:47'),
(848, 'Croods: Prehistoric Party', NULL, 1, '2025-04-14 14:22:54', '2025-04-14 14:22:54'),
(849, 'Hotel Transylvania Adventures', NULL, 1, '2025-04-14 14:23:36', '2025-04-14 14:23:36'),
(850, 'Kung Fu Panda: Battle of Destiny', NULL, 1, '2025-04-14 14:23:45', '2025-04-14 14:23:45'),
(851, 'Kung Fu Panda Academy', NULL, 1, '2025-04-14 14:23:52', '2025-04-14 14:23:52'),
(852, 'Shimmer and Shine: Genie Games', NULL, 1, '2025-04-14 14:24:03', '2025-04-14 14:24:03'),
(853, 'Blaze and the Monster Machines', NULL, 1, '2025-04-14 14:24:10', '2025-04-14 14:24:10'),
(854, 'Bubble Guppies: Animal School Day', NULL, 1, '2025-04-14 14:24:17', '2025-04-14 14:24:17'),
(855, 'Team Umizoomi Math: Zoom into Numbers', NULL, 1, '2025-04-14 14:24:24', '2025-04-14 14:24:24'),
(856, 'Dora Saves the Crystal Kingdom', NULL, 1, '2025-04-14 14:24:31', '2025-04-14 14:24:31'),
(857, 'Dora’s Dress-Up Adventures', NULL, 1, '2025-04-14 14:24:39', '2025-04-14 14:24:39'),
(858, 'Toca Boo', NULL, 1, '2025-04-14 14:24:46', '2025-04-14 14:24:46'),
(859, 'Toca Band', NULL, 1, '2025-04-14 14:24:55', '2025-04-14 14:24:55'),
(860, 'Toca Builders', NULL, 1, '2025-04-14 14:25:02', '2025-04-14 14:25:02'),
(861, 'Toca Cars', NULL, 1, '2025-04-14 14:25:10', '2025-04-14 14:25:10'),
(862, 'Toca Dance', NULL, 1, '2025-04-14 14:25:16', '2025-04-14 14:25:16'),
(863, 'Toca Blocks', NULL, 1, '2025-04-14 14:25:29', '2025-04-14 14:25:29'),
(864, 'Toca Tailor', NULL, 1, '2025-04-14 14:25:36', '2025-04-14 14:25:36'),
(865, 'Toca Store', NULL, 1, '2025-04-14 14:25:45', '2025-04-14 14:25:45'),
(866, 'Toca House', NULL, 1, '2025-04-14 14:25:53', '2025-04-14 14:25:53'),
(867, 'Toca Train', NULL, 1, '2025-04-14 14:25:59', '2025-04-14 14:25:59'),
(868, 'Toca Birthday Party', NULL, 1, '2025-04-14 14:26:06', '2025-04-14 14:26:06'),
(869, 'Toca Robot Lab', NULL, 1, '2025-04-14 14:26:14', '2025-04-14 14:26:14'),
(870, 'Toca Kitchen Monsters', NULL, 1, '2025-04-14 14:26:19', '2025-04-14 14:26:19'),
(871, 'Toca Pet Doctor', NULL, 1, '2025-04-14 14:26:25', '2025-04-14 14:26:25'),
(872, 'Baby Panda’s Train Driver', NULL, 1, '2025-04-14 14:26:31', '2025-04-14 14:26:31'),
(873, 'Baby Panda\'s Coloring Book', NULL, 1, '2025-04-14 14:26:41', '2025-04-14 14:26:41'),
(874, 'Baby Panda’s Fire Safety', NULL, 1, '2025-04-14 14:26:52', '2025-04-14 14:26:52'),
(875, 'Baby Panda’s House Cleaning', NULL, 1, '2025-04-14 14:27:50', '2025-04-14 14:27:50'),
(876, 'Baby Panda’s Ice Cream Shop', NULL, 1, '2025-04-14 14:27:56', '2025-04-14 14:27:56'),
(877, 'Baby Panda’s Little Dentist', NULL, 1, '2025-04-14 14:28:04', '2025-04-14 14:28:04'),
(878, 'Baby Panda’s Art Class', NULL, 1, '2025-04-14 14:28:12', '2025-04-14 14:28:12'),
(879, 'Baby Panda’s Kids Safety', NULL, 1, '2025-04-14 14:28:18', '2025-04-14 14:28:18'),
(880, 'Baby Panda’s Airport', NULL, 1, '2025-04-14 14:28:26', '2025-04-14 14:28:26'),
(881, 'Baby Panda’s Daily Habits', NULL, 1, '2025-04-14 14:28:34', '2025-04-14 14:28:34'),
(882, 'BabyBus World', NULL, 1, '2025-04-14 14:28:49', '2025-04-14 14:28:49'),
(883, 'BabyBus Kids Science', NULL, 1, '2025-04-14 14:28:56', '2025-04-14 14:28:56'),
(884, 'BabyBus Kids Art', NULL, 1, '2025-04-14 14:29:04', '2025-04-14 14:29:04'),
(885, 'BabyBus Dinosaur World', NULL, 1, '2025-04-14 14:29:11', '2025-04-14 14:29:11'),
(886, 'BabyBus Shapes & Colors', NULL, 1, '2025-04-14 14:29:19', '2025-04-14 14:29:19'),
(887, 'Little Panda\'s Fashion Dress Up', NULL, 1, '2025-04-14 14:30:21', '2025-04-14 14:30:21'),
(888, 'Little Panda’s Birthday Party', NULL, 1, '2025-04-14 14:30:30', '2025-04-14 14:30:30'),
(889, 'Little Panda’s Toy Repair Master', NULL, 1, '2025-04-14 14:30:41', '2025-04-14 14:30:41'),
(890, 'Little Panda’s School Lunch', NULL, 1, '2025-04-14 14:30:49', '2025-04-14 14:30:49'),
(891, 'Little Panda’s Weather Station', NULL, 1, '2025-04-14 14:30:55', '2025-04-14 14:30:55'),
(892, 'Kids Balloon Pop Game', NULL, 1, '2025-04-14 14:31:04', '2025-04-14 14:31:04'),
(893, 'Kids Toy Car Racing', NULL, 1, '2025-04-14 14:31:10', '2025-04-14 14:31:10'),
(894, 'Car Wash for Kids', NULL, 1, '2025-04-14 14:31:17', '2025-04-14 14:31:17'),
(895, 'Fire Truck Games for Kids', NULL, 1, '2025-04-14 14:31:23', '2025-04-14 14:31:23'),
(896, 'Police Car Game for Kids', NULL, 1, '2025-04-14 14:31:29', '2025-04-14 14:31:29'),
(897, 'Train Games for Toddlers', NULL, 1, '2025-04-14 14:31:38', '2025-04-14 14:31:38'),
(898, 'Helicopter Rescue', NULL, 1, '2025-04-14 14:31:46', '2025-04-14 14:31:46'),
(899, 'Kids Airplane Adventure', NULL, 1, '2025-04-14 14:31:53', '2025-04-14 14:31:53'),
(900, 'Kids Construction Trucks', NULL, 1, '2025-04-14 14:32:00', '2025-04-14 14:32:00'),
(901, 'Dump Truck Games for Kids', NULL, 1, '2025-04-14 14:32:07', '2025-04-14 14:32:07'),
(902, 'Garbage Truck Kids Game', NULL, 1, '2025-04-14 14:32:13', '2025-04-14 14:32:13'),
(903, 'Ice Cream Truck Game', NULL, 1, '2025-04-14 14:32:19', '2025-04-14 14:32:19'),
(904, 'Kids Cooking Games', NULL, 1, '2025-04-14 14:32:25', '2025-04-14 14:32:25'),
(905, 'Cake Maker for Kids', NULL, 1, '2025-04-14 14:32:32', '2025-04-14 14:32:32'),
(906, 'Pizza Maker Kids', NULL, 1, '2025-04-14 14:32:40', '2025-04-14 14:32:40'),
(907, 'Burger Maker for Kids', NULL, 1, '2025-04-14 14:32:46', '2025-04-14 14:32:46'),
(908, 'Smoothie Maker', NULL, 1, '2025-04-14 14:32:53', '2025-04-14 14:32:53'),
(909, 'Cotton Candy Maker', NULL, 1, '2025-04-14 14:32:59', '2025-04-14 14:32:59'),
(910, 'Donut Maker', NULL, 1, '2025-04-14 14:33:05', '2025-04-14 14:33:05'),
(911, 'Kids Kitchen - Cooking Game', NULL, 1, '2025-04-14 14:33:10', '2025-04-14 14:33:10'),
(912, 'Restaurant Game for Kids', NULL, 1, '2025-04-14 14:33:21', '2025-04-14 14:33:21'),
(913, 'Pretend Play: Kids Café', NULL, 1, '2025-04-14 14:33:27', '2025-04-14 14:33:27'),
(914, 'My Pretend Hospital', NULL, 1, '2025-04-14 14:33:33', '2025-04-14 14:33:33'),
(915, 'My Pretend Grocery Store', NULL, 1, '2025-04-14 14:33:43', '2025-04-14 14:33:43'),
(916, 'My Pretend Preschool', NULL, 1, '2025-04-14 14:33:49', '2025-04-14 14:33:49'),
(917, 'My Pretend Family Mansion', NULL, 1, '2025-04-14 14:33:55', '2025-04-14 14:33:55'),
(918, 'My Pretend Airport', NULL, 1, '2025-04-14 14:34:01', '2025-04-14 14:34:01'),
(919, 'Baby Care Game', NULL, 1, '2025-04-14 14:34:07', '2025-04-14 14:34:07'),
(920, 'Baby Doctor Game', NULL, 1, '2025-04-14 14:34:16', '2025-04-14 14:34:16'),
(921, 'Baby Daycare', NULL, 1, '2025-04-14 14:34:23', '2025-04-14 14:34:23'),
(922, 'Babysitter Game', NULL, 1, '2025-04-14 14:34:29', '2025-04-14 14:34:29'),
(923, 'Kid-E-Cats: Picnic', NULL, 1, '2025-04-14 14:34:38', '2025-04-14 14:34:38'),
(924, 'Kid-E-Cats: Educational Games', NULL, 1, '2025-04-14 14:34:50', '2025-04-14 14:34:50'),
(925, 'Kid-E-Cats: Cooking Games', NULL, 1, '2025-04-14 14:34:59', '2025-04-14 14:34:59'),
(926, 'Kid-E-Cats: Sea Adventure', NULL, 1, '2025-04-14 14:35:07', '2025-04-14 14:35:07'),
(927, 'Pango Playground', NULL, 1, '2025-04-14 14:35:15', '2025-04-14 14:35:15'),
(928, 'Pango Build Park', NULL, 1, '2025-04-14 14:35:22', '2025-04-14 14:35:22'),
(929, 'Pango Kumo', NULL, 1, '2025-04-14 14:35:30', '2025-04-14 14:35:30'),
(930, 'Pango One Road', NULL, 1, '2025-04-14 14:35:38', '2025-04-14 14:35:38'),
(931, 'Pango Hide & Seek', NULL, 1, '2025-04-14 14:35:47', '2025-04-14 14:35:47'),
(932, 'Pango Storytime', NULL, 1, '2025-04-14 14:35:53', '2025-04-14 14:35:53'),
(933, 'Pango Blocks', NULL, 1, '2025-04-14 14:35:59', '2025-04-14 14:35:59'),
(934, 'Pango Bakery', NULL, 1, '2025-04-14 14:36:06', '2025-04-14 14:36:06'),
(935, 'Pet Doctor - Vet Hospital', NULL, 1, '2025-04-14 14:36:15', '2025-04-14 14:36:15'),
(936, 'Animal Doctor Game', NULL, 1, '2025-04-14 14:36:22', '2025-04-14 14:36:22'),
(937, 'My Virtual Pet Shop', NULL, 1, '2025-04-14 14:36:28', '2025-04-14 14:36:28'),
(938, 'Puppy Patrol Game', NULL, 1, '2025-04-14 14:36:36', '2025-04-14 14:36:36'),
(939, 'Cat Simulator for Kids', NULL, 1, '2025-04-14 14:36:43', '2025-04-14 14:36:43'),
(940, 'Talking Puppy', NULL, 1, '2025-04-14 14:36:49', '2025-04-14 14:36:49'),
(941, 'Talking Cat Lily', NULL, 1, '2025-04-14 14:36:56', '2025-04-14 14:36:56'),
(942, 'Virtual Pet: My Boo', NULL, 1, '2025-04-14 14:37:06', '2025-04-14 14:37:06'),
(943, 'Moy - Virtual Pet Game', NULL, 1, '2025-04-14 14:37:20', '2025-04-14 14:37:20'),
(944, 'Pou', NULL, 1, '2025-04-14 14:37:27', '2025-04-14 14:37:27'),
(945, 'Bubbu – My Virtual Pet', NULL, 1, '2025-04-14 14:37:34', '2025-04-14 14:37:34'),
(946, 'Duddu – My Virtual Pet Dog', NULL, 1, '2025-04-14 14:37:40', '2025-04-14 14:37:40'),
(947, 'Talking Gummy Bear', NULL, 1, '2025-04-14 14:37:47', '2025-04-14 14:37:47'),
(948, 'Tom & Jerry: Mouse Maze', NULL, 1, '2025-04-14 14:37:53', '2025-04-14 14:37:53'),
(949, 'Garfield’s Pet Force', NULL, 1, '2025-04-14 14:38:02', '2025-04-14 14:38:02'),
(950, 'Garfield Snack Time', NULL, 1, '2025-04-14 14:38:08', '2025-04-14 14:38:08'),
(951, 'Looney Tunes™ World of Mayhem', NULL, 1, '2025-04-14 14:38:14', '2025-04-14 14:38:14'),
(953, 'Breethe', '1744784446_Breethe.jpg', 1, '2025-04-16 06:20:46', '2025-04-16 06:20:46'),
(954, 'Halodoc', '1744810081_Halodoc.jpg', 1, '2025-04-16 13:28:01', '2025-04-16 13:28:01'),
(955, 'Perfect Piano', '1745638627_Perfect Piano.jpg', 1, '2025-04-26 03:37:07', '2025-04-26 03:37:07'),
(956, 'PaperColor', '1745814755_PaperColor.jpg', 1, '2025-04-28 04:32:35', '2025-04-28 04:32:35'),
(957, 'Sketchar AR Draw', '1745814790_Sketchar AR Draw.jpg', 1, '2025-04-28 04:33:10', '2025-04-28 04:33:10'),
(958, 'Play Tube', '1745814847_Play Tube.jpg', 1, '2025-04-28 04:34:07', '2025-04-28 04:34:07'),
(959, 'Pahamify', '1745814870_Pahamify.jpg', 1, '2025-04-28 04:34:30', '2025-04-28 04:34:30'),
(960, 'AnkiDroid', '1748090389_AnkiDroid.jpg', 1, '2025-05-24 12:39:49', '2025-05-24 12:39:49'),
(961, 'Khan Academy Kids', '1748091344_Khan Academy Kids.jpg', 1, '2025-05-24 12:55:44', '2025-05-24 12:55:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0lpuLyqarM7O05Ec57bCjkRjo3yMZpe3b5oPCFyI', NULL, '167.71.71.26', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzlCU1NsbllMMVFTMmJxN1F0bFFKS0dTYnJLazZEQ2RLektLOW84WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9ibGFkZXdhcmUuenNob3QtYWkuY29tL2xvZ2luIjt9fQ==', 1752931544),
('1m40pK5UmmUUAumQGQ460csh7SWMQVNHJijYg7zV', 1, '182.253.51.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVZPM2V5VDV4RjdIUWdvb2RIRFlJWW9IejNaMFFmV2d5QXRCMExkMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751018307),
('2R72heoAlzwD97OkEKcYAgQLev0CQWB4WfsDx9Fv', NULL, '114.5.247.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUFNd3oydVZ3VlVMYzhFNVJ5VWNzY1lpUDNZS1VJZlFqdWlzSHdmZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752122473),
('3kQxz8323zzWH1fYLHwFdlXOHEnp5jmSQsEWQJIK', NULL, '180.247.198.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNngxbWpqVDQ4bTZWVlVxN0Ewak5vVDZDeUxJYmFLajJ3UG4yb2VYTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751868307),
('3v7i150ZeWjw77GFzTxl0yPSFboWFlA8IDNTAVSb', NULL, '205.210.31.145', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVdUUkw2SXVSNmt3N3A0alY1cUZhQ1ZOR2txUXdHaVlkMklYZ01tYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752449893),
('3XbD37SNgLhfGa3NnCTm3PKN9avsCpY6mULfzB6s', NULL, '178.128.247.65', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3M4Qk5TQmlhUmtEVFg4ZFlWdWpMbnFJU2EwcWhCYkpvMGl4a2FyciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly93d3cuYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1752999402),
('78eCP8y1AWPsA1xC2YBpXTp3QPPYAJkdoK56pG5K', 1, '182.253.51.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ2puU0tpd3kzQThkZDllVldTZDdXR3hzM3NiRXdvaUFWMjhPSDE2MSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9hZG1pbi9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751045757),
('7MuzQqHTwWPoddY5aq5IkmnAVURhrOxcvgwANPv8', NULL, '206.189.123.54', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibmJjTG1NNGM1OTVGOTF2SU1HVXVaeW9XZFY5TGU3Mlh4T0x4NjMwTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LmJsYWRld2FyZS56c2hvdC1haS5jb20vbG9naW4iO319', 1751768090),
('8kENA4YXrHta8YA3cDphpV77FRQBUCjwQYVFjImQ', NULL, '167.71.71.26', 'Mozilla/5.0 (X11; Linux x86_64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiczAxYXhHb29jaWdqc01wZW5hMUYzc1FWRVZSUFNxUzJSTjViQnJHYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1752931550),
('ASfiOARK1SIev5WhlRPTVOPQNAaZteFAIuFHRcBk', NULL, '198.235.24.244', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMVJNelFWTEFCenVzRUp1c2RLRFExZ0IzejhNNVR5YUdPemhBajFIbSI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbSI7fX0=', 1752584098),
('AzEKVLS0m8MN8JTpjQkogZJYD2CUsMx3VyX8Gp0t', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidk5iZDR1WEtXQUVvT1JMaXJUOXNZMVQ1THNXVmcwUmxWenJyREdDYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751608166),
('b5kct70Msl4ETKSNK7ahwBxMuoGo4YhCmRS4ML57', 1, '182.253.51.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUEFpRVJUMkNWaTViUGpWSUVWWDhXdDRXOUNJejhST1VLOTdUc0trZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9hZG1pbi91c2Vycz9wYWdlPTEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751031003),
('bVudD314CfjKgUT4DFhcQGjbx0w1h4rgBwuILlDg', NULL, '198.235.24.129', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmNmcVc0cHZZdmZwNXJFMlNBR1dMcTBUTVhYSnViQ2k1NnhxM1NNQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751855972),
('C79byg6fCTsdhMhWryLNdhldhiDAulGp6t2PPzXf', NULL, '180.247.198.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmxoU1NxVkRzb3FvUVdzdngybVFYTEkxN2pieVpNTnNVazZkSEtHNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751889908),
('cxjnFZA0kPVSw112ChZm1KxgBe2G8ofNoWhAsPaj', NULL, '180.247.198.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlpmNXVsRXc1azNpV3laa09aVkQ2VzRJb1ltSjNlSE9OZTF4MEJSdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751906869),
('DqIIypBUKiEjx1rDUOHJDtFoxGzEE6Dfh7KIHDtw', NULL, '54.216.249.241', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmFQbjlFTFdNT2lOMHFiVzl0YmExbDFrc0FuS2hLNXZhYzAyOWZabCI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwczovL2JsYWRld2FyZS56c2hvdC1haS5jb20iO319', 1751934172),
('e2DK9o20l0SCiLi1Xg90kJqzNUeIdT3H9ts6BcYo', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFpONDZpS0xFVkJ1Wk1tcEVKMUFaOXlGNDkyTUhPbnVyN2dXcUtTSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751448841),
('IuHg5Wy2Ztnh4kJRhwSv9dt08GTVojK7vbcuIVbh', NULL, '44.250.213.72', 'Mozilla/5.0 (compatible; wpbot/1.3; +https://forms.gle/ajBaxygz9jSR8p8G9)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEtJVG5OdkZ0M0Q0M3FjQ2IyVFE0NVUxS1ZsajVPTGtWc3l0V3FRYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751925233),
('KGDniJNhUZ1izBfMjre5Uio9yV3IEUAPzmjbPTYW', NULL, '3.252.216.112', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmZsamlIdkZtSUE0cURLcUUxSVRaUTV5NXl5b0tuMGMwRlJsOHhOdiI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vd3d3LmJsYWRld2FyZS56c2hvdC1haS5jb20iO319', 1751478641),
('kIP7iujkynzIVK4yS2TGswpOIV1iiH4tfMzXb5af', NULL, '16.78.8.227', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUFpR0ViQ05oUDVQWUdHMkFuaWlrbWcyYTl2YzBjeUFYS05zN1dSVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LmJsYWRld2FyZS56c2hvdC1haS5jb20vbG9naW4iO319', 1751533672),
('kkWyvM3VVcviPKv3RDr0FwfDc3gM0iRuhr6a9J91', NULL, '3.252.216.112', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaE12c09XSkFKSUFrZktnVGVVTzZtU3FjSGZTdWNsSU1nN2tFcFVxSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly93d3cuYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751478643),
('LjJZ7YHUqrhE5CP0oabqo7xW4T24sQJUPS4VP9il', NULL, '149.154.161.214', 'TelegramBot (like TwitterBot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidE94WjREOThqMVJYNjhONVlXbVRpWE1WQ1Zac01NWkZYTVNUWTFVNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751030904),
('NvOGZEQOeqAQBPfkpYJFHIUss07dmpuxgLsLFFOn', NULL, '120.188.81.22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXRPUDVRcW1ST0k4WkprdzAxN3pMbnpyNmdBeHJLN1JEbUZoeExwQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752600337),
('o2EtVDp50CSweiUE5wC8cler13jdzVU2k8c8KzBM', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUU9qaFQ4U1pzUk1YMGhUUDFweUNFbUo5c3Q1Sm1IMUtoNUZnZk1pbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1752968278),
('q6TFAGFjn99D91ELif5ITH3lIjkuuxccITJ7x9kE', NULL, '16.78.73.226', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkZLdTZ2MlE4NG5BWGpyM2pSUkxTUXN0dG9VYjlTZHA4dTdnRmZUYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LmJsYWRld2FyZS56c2hvdC1haS5jb20vbG9naW4iO319', 1752750251),
('QqFHtkUmdfqYKo8agbKMNFN9oGuzztbytWPh4pB7', NULL, '149.154.161.251', 'TelegramBot (like TwitterBot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFRaaFQycHh4NWJIN085UDRjN0xJUGxhd3U3Tk5hbzhmZzEySzRwSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751030910),
('RiRM0to9azFxuaK5lEWN1UW4zQsHKJcUzQw0ktck', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3lJSGg4UlZsSzZmdkhJOHVDUVo4MHFOeEphWExWZkptRWpoZ1hFUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751593223),
('S1rbeZ9bJ4EdlUFqWbBfhJ6SISub0FtTYHttfq4S', NULL, '198.235.24.129', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUjBxMWt3WDNGa1NHOEJmdnpobXdlYnhybm1aWFR6eDlLUGloVUdWUyI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwczovL2JsYWRld2FyZS56c2hvdC1haS5jb20iO319', 1751855971),
('sqarEfDKPz3ptfTwxEEv5XDzCWxpxbIZ40EUoJL2', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzFKY1MzbUtDaVpBYkZ0NHJJVXVSajlwaTJZQjExRW14QjMxVVJVViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751621948),
('suDPLTjXJnz815o3h0rQNZE11NjOns0GKgiehNIa', NULL, '84.252.115.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGpUWXpoWjIwNGo1VFFteGljc1hRNFVtcjhKME1OaVo0SnIxWTIwUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1752147386),
('UQhv5qeTP9x7W4gIoTVKYZqLqTxPJZSfaAoE5TCt', NULL, '182.253.51.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTlXc3lXRUVYdnd3cHY3Sm1QU2w4SzVUTUVUTG1HcjhRSnhYTk84ayI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ1OiJodHRwczovL2JsYWRld2FyZS56c2hvdC1haS5jb20vYWRtaW4vcHJvZHVjdHMiO319', 1751017680),
('utVmnlUKg2E4lmQBFOMgNZddwTiheGZsqaYkbWgX', NULL, '205.210.31.145', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidWVOVldFMno0czVQcWdtQzk3azluV0xBdW0yMmRVQjNwdGZOQjI4bCI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMwOiJodHRwczovL2JsYWRld2FyZS56c2hvdC1haS5jb20iO319', 1752449892),
('X6UgUZFWRtdFXYNmeCYtew9tR2gGnMCdb9WHGWfV', NULL, '206.189.123.54', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibExiM3lIMzl5RXNqYWRIV2o5ekpkbW5DRVRrT203QnlCNjhvcGxaSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly93d3cuYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751768084),
('xNiLTwh0nmxeJkTu1AFO1YIQlZeSJGyZRY8bOruP', NULL, '54.175.74.27', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXBvMXhUajVudHZYT0dUTkhkdGN6Nk50NUFHWlFOR09hb0lCZThLTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751597441),
('YmI7wxRBQ4glWVfpvRgo34MeON0LnmxbxOvWPHUt', NULL, '178.128.247.65', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSnF4amN2MVgyUUFrdTdjeE5lUnlVbkdKMDZRVkR0cDJOYTMwUUtjMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LmJsYWRld2FyZS56c2hvdC1haS5jb20vbG9naW4iO319', 1752999408),
('YNqQppO1DDSIuiOX5e2FhiEah75TUrzimcQrvIZI', NULL, '54.171.44.203', 'Mozilla/5.0 (compatible; NetcraftSurveyAgent/1.0; +info@netcraft.com)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3ZMcnQyd1BoM0Z3STNOV3pEVkFTNnJSdkpNWG9jOFlBRFFoZ09MYSI7czo1OiJlcnJvciI7czoxOToiUGxlYXNlIGxvZ2luIGZpcnN0ISI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjE6e2k6MDtzOjU6ImVycm9yIjt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM0OiJodHRwczovL3d3dy5ibGFkZXdhcmUuenNob3QtYWkuY29tIjt9fQ==', 1751915023),
('z6V74bpjeziegEfC8CVInyVSlLyvEawZgUlFSDyD', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieExpdk9ZUk1WZ3FJbzd3Ym9CUnM1WjIzUUplR3c5RlVJV3M0OWZZUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vYmxhZGV3YXJlLnpzaG90LWFpLmNvbS9sb2dpbiI7fX0=', 1751767136);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `work_time` varchar(100) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `work_time`, `timezone`, `closed`, `created_at`, `updated_at`) VALUES
(1, '10:00 - 22:00', 'UTC-4', 0, '2025-04-24 12:20:14', '2025-05-01 11:48:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions_users`
--

CREATE TABLE `transactions_users` (
  `id` bigint NOT NULL,
  `urutan` int NOT NULL,
  `id_users` bigint NOT NULL,
  `id_products` bigint NOT NULL,
  `set` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `profit` decimal(20,2) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions_users`
--

INSERT INTO `transactions_users` (`id`, `urutan`, `id_users`, `id_products`, `set`, `type`, `price`, `profit`, `status`, `created_at`, `updated_at`) VALUES
(1400, 1, 29, 608, '3', 'normal', 119.25, 0.60, 0, '2025-05-01 16:45:21', '2025-05-01 16:45:25'),
(1401, 2, 29, 739, '3', 'normal', 119.52, 0.60, 0, '2025-05-01 16:45:29', '2025-05-01 16:45:37'),
(1402, 3, 29, 416, '3', 'normal', 119.79, 0.60, 0, '2025-05-01 16:45:41', '2025-05-01 16:45:43'),
(1403, 4, 29, 13, '3', 'normal', 120.06, 0.60, 0, '2025-05-01 16:45:47', '2025-05-01 16:45:49'),
(1404, 5, 29, 266, '3', 'normal', 120.33, 0.60, 0, '2025-05-01 16:45:53', '2025-05-01 16:45:55'),
(1405, 6, 29, 640, '3', 'normal', 120.60, 0.60, 0, '2025-05-01 16:46:16', '2025-05-01 16:46:18'),
(1406, 7, 29, 162, '3', 'normal', 120.87, 0.60, 0, '2025-05-01 16:46:22', '2025-05-01 16:46:24'),
(1407, 1, 24, 230, '1', 'normal', 74.25, 0.37, 0, '2025-05-01 16:47:21', '2025-05-01 16:47:23'),
(1408, 2, 24, 166, '1', 'normal', 74.42, 0.37, 0, '2025-05-01 16:47:27', '2025-05-01 16:47:29'),
(1409, 3, 24, 697, '1', 'normal', 74.58, 0.37, 0, '2025-05-01 16:47:34', '2025-05-01 16:47:36'),
(1410, 4, 24, 907, '1', 'normal', 74.75, 0.37, 0, '2025-05-01 16:47:40', '2025-05-01 16:47:43'),
(1411, 5, 24, 10, '1', 'combination', 116.54, 5.83, 1, '2025-05-01 16:47:47', '2025-05-01 16:47:47'),
(1412, 5, 24, 12, '1', 'combination', 124.86, 6.24, 1, '2025-05-01 16:47:47', '2025-05-01 16:47:47'),
(1413, 1, 29, 158, '3', 'normal', 121.14, 0.61, 0, '2025-05-02 08:09:34', '2025-05-02 08:10:43'),
(1414, 2, 29, 726, '3', 'normal', 11371.41, 56.86, 0, '2025-05-02 08:54:59', '2025-05-02 08:55:53'),
(1415, 3, 29, 209, '3', 'normal', 11397.00, 56.99, 0, '2025-05-02 08:57:11', '2025-05-02 08:57:14'),
(1416, 4, 29, 679, '3', 'normal', 11422.65, 57.11, 0, '2025-05-02 08:57:19', '2025-05-02 08:57:22'),
(1417, 1, 29, 81, '3', 'normal', 11448.35, 57.24, 0, '2025-05-24 12:13:19', '2025-05-24 12:16:20'),
(1418, 2, 29, 179, '3', 'normal', 11474.10, 57.37, 0, '2025-05-24 12:16:24', '2025-05-24 12:16:26'),
(1419, 3, 29, 7, '3', 'normal', 11499.92, 57.50, 1, '2025-05-24 12:33:59', '2025-05-24 12:33:59'),
(1420, 1, 26, 52, '2', 'normal', 49.05, 0.25, 0, '2025-06-17 12:11:26', '2025-06-17 12:11:28'),
(1421, 2, 26, 118, '2', 'normal', 49.16, 0.25, 0, '2025-06-17 12:11:37', '2025-06-17 12:11:38'),
(1422, 3, 26, 538, '2', 'normal', 49.28, 0.25, 0, '2025-06-17 12:11:42', '2025-06-17 12:11:43'),
(1423, 4, 26, 355, '2', 'normal', 49.39, 0.25, 0, '2025-06-17 12:11:47', '2025-06-17 12:11:48'),
(1424, 5, 26, 289, '2', 'normal', 49.50, 0.25, 0, '2025-06-17 12:11:54', '2025-06-17 12:11:56'),
(1425, 6, 26, 181, '2', 'normal', 49.61, 0.25, 0, '2025-06-17 12:11:59', '2025-06-17 12:12:00'),
(1426, 7, 26, 926, '2', 'normal', 49.73, 0.25, 0, '2025-06-17 12:12:04', '2025-06-17 12:12:05'),
(1427, 8, 26, 417, '2', 'normal', 49.84, 0.25, 0, '2025-06-17 12:12:09', '2025-06-17 12:12:10'),
(1428, 9, 26, 281, '2', 'normal', 49.95, 0.25, 0, '2025-06-17 12:12:14', '2025-06-17 12:12:15'),
(1429, 10, 26, 437, '2', 'normal', 50.06, 0.25, 0, '2025-06-17 12:12:18', '2025-06-17 12:12:19'),
(1430, 11, 26, 418, '2', 'normal', 50.18, 0.25, 0, '2025-06-17 12:12:23', '2025-06-17 12:12:24'),
(1431, 12, 26, 779, '2', 'normal', 50.29, 0.25, 0, '2025-06-17 12:12:27', '2025-06-17 12:12:29'),
(1432, 13, 26, 158, '2', 'normal', 50.40, 0.25, 0, '2025-06-17 12:12:32', '2025-06-17 12:12:33'),
(1433, 14, 26, 50, '2', 'normal', 50.51, 0.25, 0, '2025-06-17 12:12:37', '2025-06-17 12:12:37'),
(1434, 15, 26, 401, '2', 'normal', 50.63, 0.25, 0, '2025-06-17 12:12:41', '2025-06-17 12:12:42'),
(1435, 16, 26, 335, '2', 'normal', 50.74, 0.25, 0, '2025-06-17 12:12:46', '2025-06-17 12:12:47'),
(1436, 17, 26, 171, '2', 'normal', 50.85, 0.25, 0, '2025-06-17 12:12:52', '2025-06-17 12:12:54'),
(1437, 18, 26, 167, '2', 'normal', 50.96, 0.26, 0, '2025-06-17 12:14:41', '2025-06-17 12:14:42'),
(1438, 19, 26, 725, '2', 'normal', 51.08, 0.26, 0, '2025-06-17 12:14:46', '2025-06-17 12:14:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `uid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_only` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `referral` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `referral_upline` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profile` text COLLATE utf8mb4_general_ci,
  `status` int DEFAULT '0',
  `level` int DEFAULT '1',
  `membership` enum('Normal','Gold','Platinum','Crown') COLLATE utf8mb4_general_ci DEFAULT 'Normal',
  `credibility` int DEFAULT '100',
  `network_address` text COLLATE utf8mb4_general_ci,
  `currency` text COLLATE utf8mb4_general_ci,
  `wallet_address` text COLLATE utf8mb4_general_ci,
  `jwt` text COLLATE utf8mb4_general_ci,
  `position_set` int NOT NULL DEFAULT '1',
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `uid`, `name`, `phone_email`, `email_only`, `password`, `referral`, `referral_upline`, `profile`, `status`, `level`, `membership`, `credibility`, `network_address`, `currency`, `wallet_address`, `jwt`, `position_set`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 'UID123456', 'Admin Masmut', '081234567890', 'masmutofficial@gmail.com', '$2y$12$b4s/BU9sED/7DG/H2.ITq.4RZhzo16OsfwZGapQADdthXQ0wwM7cy', 'x3HJCA', NULL, NULL, 0, 0, 'Normal', 100, 'ERC-20', 'USDC', 'tes perubahan sekarang', NULL, 1, '182.253.51.148', '2025-03-13 14:03:38', '2025-06-25 13:14:28'),
(24, 'UID911808', 'winter', '6282276840801', 'winterishere2022@gmail.com', '$2y$12$WJXnwQrmhUB/o2ZQ57XOkODLlBFbytXsaU0demXdETK.he3eRPvJO', 'OP3YLV', 'x3HJCA', NULL, 1, 1, 'Normal', 100, 'ERC-20', 'Paypal USD', 'sadjasjdkasdasd', NULL, 1, '114.122.164.97', '2025-04-25 12:37:49', '2025-06-17 12:02:52'),
(25, 'UID388284', 'masmut', '089510056758', 'masmut@gmail.com', '$2y$12$euCeCFrWBoyAqxYj7JIgmePGnEqFWCu/ongR5RRIu239IumMmHRSG', 'M2ZIWM', 'x3HJCA', NULL, 1, 1, 'Normal', 100, NULL, NULL, NULL, NULL, 1, '110.138.99.107', '2025-04-25 12:43:38', '2025-04-29 12:00:55'),
(26, 'UID632861', 'trainingwinter', '082234567890', 'trainingwinter@gmail.com', '$2y$12$sJegyMMIiBBa04RpzNPI4ON8zPlaU2ySUirog2Qzl47GOV/EmW/FW', 'HWHA7W', 'OP3YLV', NULL, 1, 2, 'Normal', 100, 'ERC-20', 'Paypal USD', 'ds;flksd;lfdf', NULL, 2, '114.122.164.97', '2025-04-25 16:51:39', '2025-06-17 12:03:30'),
(27, 'UID190294', 'masmut2', '12345678909', 'masmut2@gmail.com', '$2y$12$UpPxR69dpfVCv0312cSrSeGPmWziSbWq/b9/hPN1swIGFYcrlMQ7q', 'LW0GPY', 'x3HJCA', NULL, 1, 1, 'Normal', 100, NULL, NULL, NULL, NULL, 1, '114.5.110.153', '2025-04-26 09:19:48', '2025-05-01 09:27:37'),
(29, 'bd01ad58-9eff-415a-ad41-c7284233b852', 'trainingaaaa', '082222222233', 'testregist12@gmail.com', '$2y$12$MiQu.qHo8eOtGE.hexqBuOOabT1ftgRKUiP8F96RTA1h.I6HKqXAG', 'diRecB', 'x3HJCA', NULL, 0, 2, 'Crown', 100, 'ERC-20', 'USDC', 'qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm', NULL, 3, '182.253.51.148', '2025-04-30 08:07:51', '2025-06-27 09:57:38'),
(30, '6426bf78-e326-429a-a02e-198632262aff', 'Winwin', '093726476328', 'akjndjasd@gmail.com', '$2y$12$b29ez4k4KWAGKz0OKn1YlO73WQal5caSS6wwyFdLvtJG9eMfPHIiq', '4mmiEF', 'OP3YLV', NULL, 0, 1, 'Normal', 50, 'ERC-20', 'Paypal USD', 'qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm', NULL, 1, '114.122.132.79', '2025-05-01 14:33:59', '2025-05-02 07:42:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `withdrawal_users`
--

CREATE TABLE `withdrawal_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `network_address` text COLLATE utf8mb4_general_ci,
  `currency` text COLLATE utf8mb4_general_ci,
  `wallet_address` text COLLATE utf8mb4_general_ci,
  `amount` decimal(20,2) NOT NULL,
  `status` int DEFAULT '0',
  `baca` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `withdrawal_users`
--

INSERT INTO `withdrawal_users` (`id`, `id_users`, `network_address`, `currency`, `wallet_address`, `amount`, `status`, `baca`, `created_at`, `updated_at`) VALUES
(52, 30, 'ERC-20', 'Paypal USD', 'ASDFGHJKL', 100.00, 0, 1, '2025-05-01 15:24:13', '2025-05-01 15:49:00'),
(53, 29, 'ERC-20', 'USDC', 'qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnm', 100.00, 1, 1, '2025-05-01 15:45:37', '2025-05-20 17:25:03'),
(54, 26, 'ERC-20', 'Paypal USD', 'ds;flksd;lfdf', 65.00, 1, 1, '2025-06-17 12:04:22', '2025-06-25 13:14:47'),
(55, 26, 'ERC-20', 'Paypal USD', 'ds;flksd;lfdf', 1620.00, 1, 1, '2025-06-17 12:05:22', '2025-06-25 13:14:47'),
(56, 26, 'ERC-20', 'Paypal USD', 'ds;flksd;lfdf', 1535.00, 1, 1, '2025-06-17 12:07:16', '2025-06-25 13:14:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen_users`
--
ALTER TABLE `absen_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `combination_users`
--
ALTER TABLE `combination_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`),
  ADD KEY `idx_id_users` (`id_users`);

--
-- Indeks untuk tabel `deposit_users`
--
ALTER TABLE `deposit_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `finance_users`
--
ALTER TABLE `finance_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_admin`
--
ALTER TABLE `log_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transactions_users`
--
ALTER TABLE `transactions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_products` (`id_products`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indeks untuk tabel `withdrawal_users`
--
ALTER TABLE `withdrawal_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen_users`
--
ALTER TABLE `absen_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `combination_users`
--
ALTER TABLE `combination_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT untuk tabel `deposit_users`
--
ALTER TABLE `deposit_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `finance_users`
--
ALTER TABLE `finance_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_admin`
--
ALTER TABLE `log_admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=357;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=962;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `transactions_users`
--
ALTER TABLE `transactions_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1439;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `withdrawal_users`
--
ALTER TABLE `withdrawal_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absen_users`
--
ALTER TABLE `absen_users`
  ADD CONSTRAINT `absen_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `combination_users`
--
ALTER TABLE `combination_users`
  ADD CONSTRAINT `fk_boost_users_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `deposit_users`
--
ALTER TABLE `deposit_users`
  ADD CONSTRAINT `deposit_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `finance_users`
--
ALTER TABLE `finance_users`
  ADD CONSTRAINT `finance_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions_users`
--
ALTER TABLE `transactions_users`
  ADD CONSTRAINT `transactions_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_users_ibfk_2` FOREIGN KEY (`id_products`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `withdrawal_users`
--
ALTER TABLE `withdrawal_users`
  ADD CONSTRAINT `withdrawal_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
