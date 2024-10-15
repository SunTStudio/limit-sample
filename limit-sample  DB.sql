-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 07:38 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limit-sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_parts`
--

CREATE TABLE `area_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_part_id` bigint(20) UNSIGNED NOT NULL,
  `part_id` bigint(20) UNSIGNED NOT NULL,
  `part_area_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `characteristics` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `effective_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appearance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metode_pengecekan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `penolak_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penolak_posisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penolakan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penolakan_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'create',
  `foto_ke_satu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_ke_dua` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_ke_tiga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_ke_empat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_head_approval_date1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sec_head_approval_date2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_head_approval_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submit_date` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `count_visit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area_parts`
--

INSERT INTO `area_parts` (`id`, `model_part_id`, `part_id`, `part_area_id`, `name`, `part_number`, `document_number`, `characteristics`, `effective_date`, `expired_date`, `deskripsi`, `dimension`, `appearance`, `jumlah`, `metode_pengecekan`, `penolak_id`, `penolak_posisi`, `penolakan`, `penolakan_date`, `status`, `foto_ke_satu`, `foto_ke_dua`, `foto_ke_tiga`, `foto_ke_empat`, `sec_head_approval_date1`, `sec_head_approval_date2`, `dept_head_approval_date`, `submit_date`, `deleted_at`, `created_at`, `updated_at`, `count_visit`) VALUES
(1, 1, 1, 1, 'Part A', 'PN-001', 'AJI/LS/D26A/Reflektor/Area Kuning/01', 'gosong', '2024-10-09', '2024-10-19', 'Description A', '10x10x10', 'Red', '100', 'Method A', '16', 'Supervisor', 'Tolong benerin lagi', '2024-10-14', 'tolak', 'konten1.jpg', 'konten2.jpg', 'konten3.jpg', 'konten4.jpg', NULL, NULL, NULL, '2024-10-14', NULL, '2024-10-14 06:40:13', '2024-10-15 04:01:35', 44),
(2, 1, 1, 1, 'Part B', 'PN-002', 'AJI/LS/D26A/Reflektor/Area Kuning/02', 'goresan', '2024-10-10', '2024-10-17', 'Description B', '20x20x20', 'Blue', '200', 'Method B', '15', 'Supervisor', 'Tolong benerin lagi', '2024-10-14', 'tolak', 'konten2.jpg', 'konten3.jpg', 'konten4.jpg', 'konten1.jpg', NULL, NULL, NULL, '2024-10-14', NULL, '2024-10-14 06:40:13', '2024-10-15 04:44:15', 15),
(3, 1, 1, 2, 'Part A', 'PN-001', 'AJI/LS/D26A/Reflektor/Area Hijau/02', 'Char A', '2024-10-09', '2024-10-19', 'Description A', '10x10x10', 'Red', '100', 'Method A', NULL, NULL, NULL, NULL, 'approve', 'konten1.jpg', 'konten2.jpg', 'konten3.jpg', 'konten4.jpg', '2024-10-15', '2024-10-15', '2024-10-15', '2024-10-14', NULL, '2024-10-14 07:34:20', '2024-10-15 04:32:45', 0),
(4, 1, 1, 2, 'Part B', 'PN-002', 'AJI/LS/D26A/Reflektor/Area Hijau/04', 'Char B', '2024-10-10', '2024-10-17', 'Description B', '20x20x20', 'Blue', '200', 'Method B', NULL, NULL, NULL, NULL, 'approve', 'konten2.jpg', 'konten3.jpg', 'konten4.jpg', 'konten1.jpg', '2024-10-15', NULL, NULL, '2024-10-14', NULL, '2024-10-14 07:34:20', '2024-10-15 04:44:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `characteristics`
--

CREATE TABLE `characteristics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `characteristics`
--

INSERT INTO `characteristics` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Char B', '2024-10-11 03:11:14', '2024-10-11 03:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_depthead` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_spv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_members` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `email_depthead`, `email_spv`, `email_members`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'MKT', 'Marketing', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(2, 'PE', 'Process Engineering', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(3, 'PRODENG', 'Product Engineering', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(4, 'PROD', 'Produksi', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(5, 'HRGAEI', 'HRGA EHS IT', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(6, 'PUR', 'Purchasing', NULL, NULL, NULL, '2024-10-14 06:38:44', '2024-10-14 06:38:44', NULL),
(7, 'FA', 'Finance', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(8, 'QUALITY', 'Quality', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(9, 'PPIC', 'Product Plan Inventory Control', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(10, 'ME', 'Maintenance Engineering', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(11, 'BOD', 'Board Of Director', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(12, 'PPM', 'PRODPPICME', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(13, 'PEQA', 'PEQUALITY', NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_departements`
--

CREATE TABLE `detail_departements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departement_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_depthead` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_director` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_spv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_members` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_departements`
--

INSERT INTO `detail_departements` (`id`, `departement_id`, `name`, `code`, `email_depthead`, `email_director`, `email_spv`, `email_members`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marketing', 'MKT', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(2, 13, 'Process Engineering', 'PE', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(3, 3, 'New Product Development', 'NPD', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(4, 3, 'Research And Development', 'RND', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(5, 12, 'Assy Koja', 'ASSY', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(6, 12, 'Injection Surface', 'INJ', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(7, 5, 'Human Resource', 'HR', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(8, 5, 'General Affair', 'GA', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(9, 5, 'Environtment Health Safety', 'EHS', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(10, 5, 'Information Technology', 'IT', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(11, 5, 'Export Import', 'EXIM', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(12, 5, 'Legal', 'LA', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(13, 6, 'Purchasing', 'PUR', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(14, 7, 'Finance', 'FA', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(15, 13, 'Quality Control', 'QC', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(16, 13, 'Quality Assurance', 'QA', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(17, 12, 'Delivery', 'DEL', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(18, 12, 'Warehouse', 'WH', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(19, 12, 'Maintanance Engineering', 'ME', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(20, 11, 'Board Of Direction', 'BOD', NULL, NULL, NULL, NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `count_visit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `guest_name`, `login_date`, `count_visit`, `created_at`, `updated_at`) VALUES
(1, '00032', '2024-10-08', 6, '2024-10-08 03:16:39', '2024-10-11 04:05:51'),
(3, '0021', '2024-10-08', 2, '2024-10-08 03:32:23', '2024-10-08 03:32:42'),
(4, '00036', '2024-10-08', 3, '2024-10-08 08:00:24', '2024-10-09 01:35:40'),
(5, '00032', '2024-10-09', NULL, '2024-10-09 00:36:41', '2024-10-09 00:36:41'),
(6, '00036', '2024-10-09', NULL, '2024-10-09 01:35:40', '2024-10-09 01:35:40'),
(7, '00032', '2024-10-09', NULL, '2024-10-09 04:37:40', '2024-10-09 04:37:40'),
(9, '10002', '2024-10-10', 1, '2024-10-10 06:43:06', '2024-10-10 06:43:06'),
(10, '00026', '2024-10-10', 1, '2024-10-10 08:11:30', '2024-10-10 08:11:30'),
(11, '00032', '2024-10-11', NULL, '2024-10-11 03:20:15', '2024-10-11 03:20:15'),
(12, '00032', '2024-10-11', NULL, '2024-10-11 04:05:51', '2024-10-11 04:05:51'),
(13, '00036', '2024-10-14', NULL, '2024-10-14 06:50:26', '2024-10-14 06:50:26'),
(14, '00032', '2024-10-15', NULL, '2024-10-15 04:32:57', '2024-10-15 04:32:57'),
(15, '0021', '2024-10-15', NULL, '2024-10-15 04:44:23', '2024-10-15 04:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2012_09_26_031448_create_positions_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_09_26_031336_create_model_parts_table', 1),
(7, '2024_09_26_031359_create_parts_table', 1),
(8, '2024_09_26_031435_create_guests_table', 1),
(9, '2024_09_27_021452_create_part_areas_table', 1),
(10, '2024_09_28_031411_create_area_parts_table', 1),
(11, '2024_10_02_091602_create_permission_tables', 1),
(12, '2024_10_04_145013_create_characteristics_table', 1),
(13, '2024_10_14_074217_create_departments_table', 1),
(14, '2024_10_14_074426_create_detail_departements_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 26),
(5, 'App\\Models\\User', 27),
(5, 'App\\Models\\User', 28),
(5, 'App\\Models\\User', 29),
(5, 'App\\Models\\User', 32),
(5, 'App\\Models\\User', 33),
(5, 'App\\Models\\User', 34),
(6, 'App\\Models\\User', 35),
(6, 'App\\Models\\User', 36),
(6, 'App\\Models\\User', 37),
(6, 'App\\Models\\User', 38),
(6, 'App\\Models\\User', 39),
(6, 'App\\Models\\User', 40),
(7, 'App\\Models\\User', 41),
(7, 'App\\Models\\User', 42),
(7, 'App\\Models\\User', 43),
(7, 'App\\Models\\User', 44),
(7, 'App\\Models\\User', 45),
(7, 'App\\Models\\User', 46),
(8, 'App\\Models\\User', 47),
(8, 'App\\Models\\User', 48),
(8, 'App\\Models\\User', 49),
(8, 'App\\Models\\User', 50),
(8, 'App\\Models\\User', 51),
(8, 'App\\Models\\User', 52),
(9, 'App\\Models\\User', 53);

-- --------------------------------------------------------

--
-- Table structure for table `model_parts`
--

CREATE TABLE `model_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `count_visit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_parts`
--

INSERT INTO `model_parts` (`id`, `name`, `foto_model`, `created_at`, `updated_at`, `deleted_at`, `count_visit`) VALUES
(1, 'D26A', 'backD26A.jpg', '2024-10-01 07:30:35', '2024-10-15 05:35:52', NULL, 5),
(2, 'D30D', '1728895147.jpg', '2024-10-11 07:30:40', '2024-10-14 08:39:07', NULL, 0),
(3, 'D12L', '1728895157.jpg', '2024-10-05 07:30:42', '2024-10-14 08:39:17', NULL, 0),
(4, '660A', '1728895166.jpg', '2024-10-01 07:30:44', '2024-10-15 04:33:10', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_part_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_part` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `count_visit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `model_part_id`, `name`, `foto_part`, `created_at`, `updated_at`, `deleted_at`, `count_visit`) VALUES
(1, 1, 'Reflektor', 'D26AV3.png', '2024-10-09 07:30:50', '2024-10-15 04:33:15', NULL, 7),
(2, 1, 'RCL', 'D26AV3.png', '2024-10-01 07:30:53', NULL, NULL, 0),
(3, 1, 'CBDG', 'D26AV3.png', '2024-10-04 07:30:55', '2024-10-15 05:35:28', NULL, 2),
(4, 1, 'BDG', 'D26AV3.png', '2024-10-03 07:30:57', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `part_areas`
--

CREATE TABLE `part_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `part_id` bigint(20) UNSIGNED NOT NULL,
  `nameArea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat_x` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koordinat_y` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `count_visit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `part_areas`
--

INSERT INTO `part_areas` (`id`, `part_id`, `nameArea`, `koordinat_x`, `koordinat_y`, `created_at`, `updated_at`, `deleted_at`, `count_visit`) VALUES
(1, 1, 'Area Kuning', '40.77849860982391%', '46.05402542372881%', '2024-10-08 03:38:04', '2024-10-14 06:51:40', NULL, 3),
(2, 1, 'Area Hijau', '22.42817423540315%', '65.18235472154964%', '2024-10-08 03:38:04', '2024-10-15 04:33:17', NULL, 5),
(3, 1, 'Area Merah', '25.208526413345687%', '15.424485472154965%', '2024-10-10 07:46:32', '2024-10-10 07:46:32', NULL, 0),
(4, 1, 'Area Biru', '54.49490268767377%', '50.291313559322035%', '2024-10-10 07:46:32', '2024-10-10 07:46:32', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(5, 'App\\Models\\User', 53, 'API Token', '421fa4b04984c5eca6c1600b5f225f504850e9209f4fef47d6a22c41a423afe1', '[\"*\"]', NULL, '2024-10-14 06:50:26', '2024-10-14 06:50:26'),
(8, 'App\\Models\\User', 2, 'API Token', 'c4a9c4c6ab28e90fe4e9eb144891c5538c70371d79ce89c0a9f16924d128c015', '[\"*\"]', NULL, '2024-10-14 07:33:58', '2024-10-14 07:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Dept Head', 'DEPT', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(2, 'Supervisor', 'SPV', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(3, 'Staff', 'STAFF', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(4, 'SUB', 'SUB', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(5, 'BOD', 'BOD', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(6, 'Leader', 'LEAD', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(7, 'Foreman', 'FRM', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(8, 'Member', 'OP', '2024-10-14 06:38:45', '2024-10-14 06:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(2, 'Board of Directors', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(3, 'Department Head', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(4, 'Supervisor', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(5, 'Staff', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(6, 'Foreman', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(7, 'Leader', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(8, 'Member', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45'),
(9, 'Guest', 'web', '2024-10-14 06:38:45', '2024-10-14 06:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `detail_dept_id` int(11) DEFAULT NULL,
  `golongan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `npk`, `username`, `gender`, `dept_id`, `position_id`, `detail_dept_id`, `golongan`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '', 'admin', 'Perempuan', 5, NULL, 7, '1', '2024-10-14 06:38:45', '$2y$10$V4pThbc7j5XQ70Q2xj/B2eImcDqRD2uIhLJKjogOo5wp/DC4w2qHu', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(2, 'Admin Limit Sample', 'adminLS@gmail.com', '00100', 'adminLS', 'Perempuan', 13, NULL, 15, '1', '2024-10-14 06:38:45', '$2y$10$5x/QJ467ro1yNnyNHakqMePWinnLXsBuFM6DulVenUdPFHeQkx1gi', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(3, '[Board of Directors]', 'bod@gmail.com', '10001', 'bod', 'Laki-Laki', 11, 5, 20, '5', '2024-10-14 06:38:45', '$2y$10$UBGup5ceT/jiHjm8eDySHOCakSkBbJ45ffiwitMW/ZdAHiZmcQKGm', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(4, 'Cindy Tirta', 'cindy@gmail.com', '10104', 'cindy.t', 'Perempuan', 11, 5, 20, '5', '2024-10-14 06:38:45', '$2y$10$qHU5gQ8UYUG4PuTMCFBok.jsilMZrknEMc/Ju2ecJ1D/zBpMmTaTC', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(5, '[Department Head Marketing]', 'dhMkt@gmail.com', '10002', 'dhMkt', 'Laki-Laki', 1, 1, 1, '3', '2024-10-14 06:38:45', '$2y$10$EUyXxkSsFAds1suwGDorFeqIOrWCRhxDXCaKcR6veiMqLTnNpSPem', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(6, '[Department Head PEQA]', 'dhPeQa@gmail.com', '10003', 'dhPeQa', 'Laki-Laki', 13, 1, 2, '3', '2024-10-14 06:38:45', '$2y$10$W8/Xk.VbuCbjz3k08uDvRuV7ahoTnTxcAX0L3lJZG7UJhLGa0dU/C', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(7, '[Department Head Product Engineering]', 'dhPRODENG@gmail.com', '10004', 'dhPRODENG', 'Laki-Laki', 3, 1, 3, '3', '2024-10-14 06:38:45', '$2y$10$yBw9B680GDh1AlQ1Q1a1lO0uw3BvZTOc40dgdosmI.bWiNms1v4/C', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(8, '[Department Head PRODPPICME]', 'dhPPM@gmail.com', '10005', 'dhPPM', 'Laki-Laki', 12, 1, 5, '3', '2024-10-14 06:38:45', '$2y$10$y/Oi0ZntoVeNEZYOhWdFKuAP4g3iEiolprAkbJdzl.KLi8SJ9Ryda', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(9, 'Pandu Azaria G', 'pandu@gmail.com', '10006', 'pandu.a', 'Laki-Laki', 5, 1, 7, '3', '2024-10-14 06:38:45', '$2y$10$Q1j5bno9kGOk2UMysZF6r.xbf5VzlVaVdZq3fAv9RWnCKiDdavA7S', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(10, '[Department Head Purchasing]', 'dhPUR@gmail.com', '10007', 'dhPUR', 'Laki-Laki', 6, 1, 13, '3', '2024-10-14 06:38:45', '$2y$10$SMZm9imxOvDOZjYN9BP0vumV8frqItAcINID6JfVNm7lTaBZ8hJS6', NULL, '2024-10-14 06:38:45', '2024-10-14 06:38:45', NULL),
(11, '[Department Head Finance]', 'dhFA@gmail.com', '10008', 'dhFA', 'Laki-Laki', 7, 1, 14, '3', '2024-10-14 06:38:46', '$2y$10$dQ51Nvd6IDrOLHMZnpkCle3rafwWxqT.IMvSLzOmBSpaHIr3ZlwWK', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(12, '[Department Head Quality Care]', 'dhQC@gmail.com', '10128', 'dhQC', 'Laki-Laki', 13, 1, 15, '3', '2024-10-14 06:38:46', '$2y$10$N3Muz6cxh54hcs/l2Ob/l.Iu2UAuw2.yJad9AbwNamiiFUW9rscwq', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(13, '[Supervisor Marketing]', 'spvMkt@gmail.com', '10009', 'spvMkt', 'Laki-Laki', 1, 2, 1, '3', '2024-10-14 06:38:46', '$2y$10$QQ6I0TkUv1oQkbmtP1gGUO0cf6t03ZQYY9KmXJBi/uikOf.vkmElm', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(14, '[Supervisor PEQA]', 'spvPeQa@gmail.com', '10010', 'spvPeQa', 'Laki-Laki', 13, 2, 2, '3', '2024-10-14 06:38:46', '$2y$10$Gy1uvph1SmCLw.beQuwb4uOex8h82y3JgJl9XRz96jmXZ3447Uwji', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(15, '[Supervisor QC]', 'spvQC@gmail.com', '10129', 'spvQC', 'Laki-Laki', 13, 2, 15, '3', '2024-10-14 06:38:46', '$2y$10$apRnrLgI4bYhz3LG0OSUu.EZgZUL9r9xw8.6/BaFaQZfofuIsdusq', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(16, '[Supervisor QC 2]', 'spvQC2@gmail.com', '11129', 'spvQC2', 'Laki-Laki', 13, 2, 16, '3', '2024-10-14 06:46:56', '$2y$10$8sEvqkoDNsa7n4BXiwy00emr6qaZwuvUvmZrij3EY/E.A7Jos1dWi', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(17, '[Supervisor Product Engineering]', 'spvPRODENG@gmail.com', '10011', 'spvPRODENG', 'Laki-Laki', 3, 2, 3, '3', '2024-10-14 06:38:46', '$2y$10$u.iHlg29JfRMkXuVKXwkQeGtx9rIneqjSVDYJkbm0GcIi58ua3QiC', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(18, '[Supervisor PRODPPICME]', 'spvPPM@gmail.com', '10012', 'spvPPM', 'Laki-Laki', 12, 2, 5, '3', '2024-10-14 06:38:46', '$2y$10$OFukHZ41InTI7erqdMxnTeK97VCo9EimC6N6RSdo9R.S/9IGc6w76', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(19, 'Tanya Mutia', 'tanya@gmail.com', '10100', 'tanya.m', 'Perempuan', 5, 2, 7, '3', '2024-10-14 06:38:46', '$2y$10$feWNzzgyi2cZlsxAAEb1r.HfLPIQs4upYPOYnn436vYJkxvSp75X2', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(20, 'Septin Kisriyani', 'septin@gmail.com', '10101', 'septin.k', 'Perempuan', 5, 2, 7, '3', '2024-10-14 06:38:46', '$2y$10$wR8kv3cpzFr48lC9AeWd3.4Gn0KhdsRFM2r4hZsu5m0KzrijWlBIG', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(21, 'Dewi Kartika', 'dewi@gmail.com', '00828', 'dewi.k', 'Perempuan', 5, 2, 8, '3', '2024-10-14 06:38:46', '$2y$10$WO.TVKauugqZ2PRrJZjxHen7FVnLfMPVYpz6TL1gGfKvz.OhPGk4u', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(22, 'Iwan Muhdi', 'iwan@gmail.com', '10102', 'iwan.m', 'Laki-Laki', 5, 2, 8, '3', '2024-10-14 06:38:46', '$2y$10$5eES4VrEG/CzX4ldzXTvie9qaz6EEA3kr24fyrdmqeONnl/eFxuPW', NULL, '2024-10-14 06:38:46', '2024-10-14 06:38:46', NULL),
(23, 'Miqdad Agil A', 'miqdad@gmail.com', '00801', 'miqdad.a', 'Laki-Laki', 5, 2, 10, '3', '2024-10-14 06:38:47', '$2y$10$SY39I3GoDi8qR6Eumf6qleHuYCJtab7mdMGwHc48K7pFnzSmGYW6W', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(24, '[Supervisor Purchasing]', 'spvPUR@gmail.com', '10014', 'spvPUR', 'Laki-Laki', 6, 2, 13, '3', '2024-10-14 06:38:47', '$2y$10$h1sgD3fqY.E6rvUJfGKqVO7BM2CwiH6t.Ib3LoT635d8U8m03DdTG', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(25, '[Supervisor Finance]', 'spvFA@gmail.com', '10015', 'spvFA', 'Laki-Laki', 7, 2, 14, '3', '2024-10-14 06:38:47', '$2y$10$dew/.P/R4kHApglW4t5LJeA2DPT1Zt3U9KrmTyKdQkZZt8586Rcdu', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(26, '[Staff Marketing]', 'staffMkt@gmail.com', '10016', 'staffMkt', 'Laki-Laki', 1, 3, 1, '3', '2024-10-14 06:38:47', '$2y$10$/.yMMtHnifwnW3UgoMFYSeleHasO049zzV2ddH63/Tu3JNkovhGwu', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(27, '[Staff PEQA]', 'staffPeQa@gmail.com', '10017', 'staffPeQa', 'Laki-Laki', 13, 3, 2, '3', '2024-10-14 06:38:47', '$2y$10$596Cvm0jI5.mCdCa7cmuXuBaTcpaOVAeS6azvRrel9kQBQPqdG6Wq', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(28, '[Staff Product Engineering]', 'staffPRODENG@gmail.com', '10018', 'staffPRODENG', 'Laki-Laki', 3, 3, 3, '3', '2024-10-14 06:38:47', '$2y$10$kCewP09PAlLl9efT0ioqS.x/rlWQqB4FH/ZimKyzR6mgZ6QJUZkIu', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(29, '[Staff PRODPPICME]', 'staffPPM@gmail.com', '10019', 'staffPPM', 'Laki-Laki', 12, 3, 5, '3', '2024-10-14 06:38:47', '$2y$10$t7AA2apsJpe57rsm2GB4suFnM9WnB56PUxEPgEM6HOGsi5Cq/qIge', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(30, 'Susilo Hendro N', 'susilo@gmail.com', '10020', 'susilo.h', 'Laki-Laki', 5, 3, 8, '3', '2024-10-14 06:38:47', '$2y$10$LOygTqhoTUYW7EPP5bMo9ul1G/ibtzFQx9CIW5t8c8sWuVC9B94nu', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(31, 'Sahril W', 'sahril@gmail.com', '10105', 'sahril.w', 'Laki-Laki', 5, 3, 10, '3', '2024-10-14 06:38:47', '$2y$10$7i0ATCl0ddxFYo60wslQVuhibcX645PQWhgeum20yKoGa8/NThXmG', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(32, 'Adela Rosya A', 'adela@gmail.com', '10106', 'adela.r', 'Perempuan', 5, 3, 9, '3', '2024-10-14 06:38:47', '$2y$10$OFwGb9RkB5DaeYScew01iOgfCGasI8edqZ4aJIiR4BeBiUYMEA8Za', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(33, '[Staff Purchasing]', 'staffPUR@gmail.com', '10021', 'staffPUR', 'Laki-Laki', 6, 3, 13, '3', '2024-10-14 06:38:47', '$2y$10$XY2jCdMIrPKaXKeOaIRoGO5nU.21KP9Lq/1hMmMBG7W2.i0x5On2W', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(34, '[Staff Finance]', 'staffFA@gmail.com', '10022', 'staffFA', 'Laki-Laki', 7, 3, 14, '3', '2024-10-14 06:38:47', '$2y$10$TaB8lTD0G7dO84jyvWNINO.I/.TdjYA5mwPvkya5dlUoEkJkS5I72', NULL, '2024-10-14 06:38:47', '2024-10-14 06:38:47', NULL),
(35, '[Foreman Marketing]', 'foremanMkt@gmail.com', '10023', 'foremanMkt', 'Laki-Laki', 1, 7, 1, '3', '2024-10-14 06:38:48', '$2y$10$xH3QT/q0fAk8EHdO0.tsfel/UG.mywqmdM2twg.Jte.aKrSYchJsy', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(36, '[Foreman PEQA]', 'foremanPeQa@gmail.com', '10024', 'foremanPeQa', 'Laki-Laki', 13, 7, 2, '3', '2024-10-14 06:38:48', '$2y$10$v5FbPAVbDckqvvm5.v/UsOOLgwJUkNCkgsXTmYlppO3/kWf7YedYi', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(37, '[Foreman Product Engineering]', 'foremanPRODENG@gmail.com', '10025', 'foremanPRODENG', 'Laki-Laki', 3, 7, 3, '3', '2024-10-14 06:38:48', '$2y$10$Aw/dvvSxfsGeg4NlIHCSn.Vi0mv4cYZXJyKswPS.qf6ZDYHNuDrR2', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(38, '[Foreman PRODPPICME]', 'foremanPPM@gmail.com', '10026', 'foremanPPM', 'Laki-Laki', 12, 7, 5, '3', '2024-10-14 06:38:48', '$2y$10$tCD9k/mJAORN3E/qf0LPMuHCH1mql/LgY2cqMzQySvsAih9TLe70u', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(39, '[Foreman Purchasing]', 'foremanPUR@gmail.com', '10028', 'foremanPUR', 'Laki-Laki', 6, 7, 13, '3', '2024-10-14 06:38:48', '$2y$10$xZuIEHJTQGXM52cMcgPikugfxwzROk6VTuDm5cKDwuXu9h3gFHaIm', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(40, '[Foreman Finance]', 'foremanFA@gmail.com', '10029', 'foremanFA', 'Laki-Laki', 7, 7, 14, '3', '2024-10-14 06:38:48', '$2y$10$jvNTM9gT.3CsJmj1BATJNuwNNBpoRkmTltyjrhwtwtbP7MlfTD.P.', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(41, '[Leader Marketing]', 'leaderMkt@gmail.com', '10030', 'leaderMkt', 'Laki-Laki', 1, 6, 1, '3', '2024-10-14 06:38:48', '$2y$10$iENVzojkt48RmPCNT6YSeuYi5N7BwfGV9F3Jn1weHQfC8VC1v2vGi', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(42, '[Leader PEQA]', 'leaderPeQa@gmail.com', '10031', 'leaderPeQa', 'Laki-Laki', 13, 6, 2, '3', '2024-10-14 06:38:48', '$2y$10$OQB94SorczfH9n6L28QhCO9DJnYyXVAXFU/0viADwL6wT9zofv9bS', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(43, '[Leader Product Engineering]', 'leaderPRODENG@gmail.com', '10032', 'leaderPRODENG', 'Laki-Laki', 3, 6, 3, '3', '2024-10-14 06:38:48', '$2y$10$LxaiETMRfKU6fzgDn5.ln.KQhSRVEi2A.roAq.iuoUNPYrHmJW42C', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(44, '[Leader PRODPPICME]', 'leaderPPM@gmail.com', '10033', 'leaderPPM', 'Laki-Laki', 12, 6, 5, '3', '2024-10-14 06:38:48', '$2y$10$DrdTg/2JR1JI1ib/WiD7LOylQTOINxp0TYfOZUKMTyaktsSwMvzK.', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(45, '[Leader Purchasing]', 'leaderPUR@gmail.com', '10035', 'leaderPUR', 'Laki-Laki', 6, 6, 13, '3', '2024-10-14 06:38:48', '$2y$10$G7YFloVngHAdpjmFHSW/h.1NdF8BIjmBlbm8StyYzQFwcU.G6PQPu', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(46, '[Leader Finance]', 'leaderFA@gmail.com', '10036', 'leaderFA', 'Laki-Laki', 7, 6, 14, '3', '2024-10-14 06:38:48', '$2y$10$l3uNIg6/xWFGMh/L6XR0FuaR2fVyzV/3P/Erp.uXiLU0TKb3Zu0E2', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(47, '[Member Marketing]', 'memberMkt@gmail.com', '10037', 'memberMkt', 'Laki-Laki', 1, 8, 1, '3', '2024-10-14 06:38:48', '$2y$10$tpx0iN2whSsx/pMUwDH.YO0GcJ8yH.4zrKii.efbebCVw/GerEw2G', NULL, '2024-10-14 06:38:48', '2024-10-14 06:38:48', NULL),
(48, '[Member PEQA]', 'memberPeQa@gmail.com', '10038', 'memberPeQa', 'Laki-Laki', 13, 8, 2, '3', '2024-10-14 06:38:49', '$2y$10$IccLCHZ83AhL6ZGk232RWe9Z/jVzS51Dhw6j986OpEw2yXkn8D3CW', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL),
(49, '[Member Product Engineering]', 'memberPRODENG@gmail.com', '10039', 'memberPRODENG', 'Laki-Laki', 3, 8, 3, '3', '2024-10-14 06:38:49', '$2y$10$45miarF7P7.xfpZhai0oW.uIUp.NzoQ/93bM4m/HG.H7lwhTQuwQa', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL),
(50, '[Member PRODPPICME]', 'memberPPM@gmail.com', '10040', 'memberPPM', 'Laki-Laki', 12, 8, 5, '3', '2024-10-14 06:38:49', '$2y$10$iiMd.hwS/M52nbyMQmY.xug66HOtP131GPwPqTqiSTCA2mC0FejlG', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL),
(51, '[Member Purchasing]', 'memberPUR@gmail.com', '10042', 'memberPUR', 'Laki-Laki', 6, 8, 13, '3', '2024-10-14 06:38:49', '$2y$10$1zTV3RrTsV58fCm9CTmaUOkAdh0EhxIOOKSIOXcmgjcfvtBhTvTYO', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL),
(52, '[Member Finance]', 'memberFA@gmail.com', '10043', 'memberFA', 'Laki-Laki', 7, 8, 14, '3', '2024-10-14 06:38:49', '$2y$10$1y7hkvcYADR4Pya1wOmTTeTXsLo65dBTakbrcvbN/7Hjb.m8vZSd6', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL),
(53, 'Guest', 'guest@gmail.com', NULL, 'guest', 'Custom', NULL, NULL, NULL, NULL, '2024-10-14 06:38:49', '$2y$10$zvyFnvGsXqEn63PXj1ClBuTQIBx6r8D7MI0QLzQPRYrkZeWh1J3BC', NULL, '2024-10-14 06:38:49', '2024-10-14 06:38:49', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_parts`
--
ALTER TABLE `area_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_parts_model_part_id_foreign` (`model_part_id`),
  ADD KEY `area_parts_part_id_foreign` (`part_id`),
  ADD KEY `area_parts_part_area_id_foreign` (`part_area_id`);

--
-- Indexes for table `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_departements`
--
ALTER TABLE `detail_departements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_parts`
--
ALTER TABLE `model_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parts_model_part_id_foreign` (`model_part_id`);

--
-- Indexes for table `part_areas`
--
ALTER TABLE `part_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `part_areas_part_id_foreign` (`part_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_npk_unique` (`npk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_parts`
--
ALTER TABLE `area_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `detail_departements`
--
ALTER TABLE `detail_departements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `model_parts`
--
ALTER TABLE `model_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `part_areas`
--
ALTER TABLE `part_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area_parts`
--
ALTER TABLE `area_parts`
  ADD CONSTRAINT `area_parts_model_part_id_foreign` FOREIGN KEY (`model_part_id`) REFERENCES `model_parts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `area_parts_part_area_id_foreign` FOREIGN KEY (`part_area_id`) REFERENCES `part_areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `area_parts_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_model_part_id_foreign` FOREIGN KEY (`model_part_id`) REFERENCES `model_parts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `part_areas`
--
ALTER TABLE `part_areas`
  ADD CONSTRAINT `part_areas_part_id_foreign` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
