SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `absen_users` (
  `id` int NOT NULL,
  `id_users` bigint NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `combination_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `id_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sequence` int NOT NULL,
  `set_boost` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `deposit_users` (
  `id` bigint NOT NULL,
  `id_users` bigint NOT NULL,
  `deposit_image` text COLLATE utf8mb4_general_ci,
  `network_address` text COLLATE utf8mb4_general_ci,
  `currency` text COLLATE utf8mb4_general_ci,
  `wallet_address` text COLLATE utf8mb4_general_ci,
  `amount` decimal(20,2) NOT NULL,
  `status` int DEFAULT '0',
  `category_deposit` enum('Deposit','Bonus') COLLATE utf8mb4_general_ci NOT NULL,
  `baca` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `log_admin` (
  `id` int UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `products` (
  `id` bigint NOT NULL,
  `product_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` text COLLATE utf8mb4_general_ci,
  `status` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `registered_bonus` (
  `id` bigint UNSIGNED NOT NULL,
  `id_users` bigint NOT NULL,
  `total_bonus` decimal(20,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `work_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `transactions_users` (
  `id` bigint NOT NULL,
  `urutan` int NOT NULL,
  `id_users` bigint NOT NULL,
  `id_products` bigint NOT NULL,
  `set` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(20,2) DEFAULT NULL,
  `profit` decimal(20,2) DEFAULT NULL,
  `ratio_profit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `currency_manual` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `network_address_manual` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jwt` text COLLATE utf8mb4_general_ci,
  `position_set` int NOT NULL DEFAULT '1',
  `registered_banner` tinyint NOT NULL DEFAULT '0',
  `ip_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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


ALTER TABLE `absen_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`);

ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

ALTER TABLE `combination_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_id` (`id`),
  ADD KEY `idx_id_users` (`id_users`);

ALTER TABLE `deposit_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

ALTER TABLE `finance_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `log_admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

ALTER TABLE `registered_bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registered_bonus_id_users_index` (`id_users`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `transactions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_products` (`id_products`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `uid` (`uid`);

ALTER TABLE `withdrawal_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_users` (`id_users`);


ALTER TABLE `absen_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `combination_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `deposit_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `finance_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `log_admin`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `products`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `registered_bonus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `transactions_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

ALTER TABLE `withdrawal_users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;


ALTER TABLE `absen_users`
  ADD CONSTRAINT `absen_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `combination_users`
  ADD CONSTRAINT `fk_boost_users_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `deposit_users`
  ADD CONSTRAINT `deposit_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `finance_users`
  ADD CONSTRAINT `finance_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `registered_bonus`
  ADD CONSTRAINT `registered_bonus_id_users_foreign` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `transactions_users`
  ADD CONSTRAINT `transactions_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_users_ibfk_2` FOREIGN KEY (`id_products`) REFERENCES `products` (`id`) ON DELETE CASCADE;

ALTER TABLE `withdrawal_users`
  ADD CONSTRAINT `withdrawal_users_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
