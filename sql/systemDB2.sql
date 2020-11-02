-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 02, 2020 at 02:24 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `systemDB2`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `absence_date` date NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('absence','permit') COLLATE utf8_unicode_ci NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acceptance_tests`
--

CREATE TABLE `acceptance_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_test_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_test_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `active_days_request`
--

CREATE TABLE `active_days_request` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `working_day` int(11) NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` enum('ar','en') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ar',
  `image_profile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable',
  `adminGroupId` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `lang`, `image_profile`, `status`, `adminGroupId`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Amr', 'admin', NULL, '2020-11-02 11:24:14', '$2y$10$VJDuHJzOUox0GLtpaQ95NuS9fR84L118uKe4uOWbPvuRgT.OuTs7m', 'ar', NULL, 'enable', NULL, 'RyxM6pvtekTIk9l9fBSGajD5AnvL9bDCoDd506SwrBYyph4QJfGVtOTc9lw0', '2020-11-02 11:24:14', '2020-11-02 11:24:14'),
(2, 'Karina Reilly', 'voboxetiz', 'zupebu@mailinator.com', NULL, '$2y$10$o7wLx.onMDGxYPb4MTE9P.PLsk.rzcH0sgk4KlMxHzd0a39dC77sm', 'ar', NULL, 'enable', NULL, NULL, '2020-11-02 11:27:06', '2020-11-02 11:27:06');

-- --------------------------------------------------------

--
-- Table structure for table `admission_documents`
--

CREATE TABLE `admission_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_document_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_document_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_type` set('new','transfer','returning','arrival') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admission_reports`
--

CREATE TABLE `admission_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `report` text COLLATE utf8_unicode_ci NOT NULL,
  `father_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `archives`
--

CREATE TABLE `archives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `acceptance` enum('accepted','rejected') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'accepted',
  `assessment_type` enum('assessment','re-assessment') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'assessment',
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mode` enum('insert','import') COLLATE utf8_unicode_ci DEFAULT 'insert',
  `attendance_id` bigint(20) UNSIGNED NOT NULL,
  `status_attendance` enum('In','Out') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'In',
  `time_attendance` datetime NOT NULL,
  `attendance_sheet_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `attendance_sheet`
-- (See below for the actual view)
--
CREATE TABLE `attendance_sheet` (
`attendance_id` bigint(20) unsigned
,`Date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(1)
,`no_leave` int(1)
,`time_overtime` varchar(10)
,`overtime` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sheets`
--

CREATE TABLE `attendance_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sheet_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `attendance_sheet_dates`
-- (See below for the actual view)
--
CREATE TABLE `attendance_sheet_dates` (
`attendance_id` int(11)
,`selected_date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(11)
,`no_leave` int(11)
,`overtime` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `attendance_view`
-- (See below for the actual view)
--
CREATE TABLE `attendance_view` (
`attendance_id` bigint(20) unsigned
,`employee_id` bigint(20) unsigned
,`timetable_id` bigint(20) unsigned
,`clock_in` datetime
,`clock_out` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_name_classroom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_name_classroom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_students` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commissioners`
--

CREATE TABLE `commissioners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commissioner_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relation` enum('relative','driver') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'driver',
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `relative_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `relative_mobile` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `relative_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relative_relation` enum('grand_pa','grand_ma','uncle','aunt','neighbor','other') COLLATE utf8_unicode_ci NOT NULL,
  `father_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_requests`
--

CREATE TABLE `daily_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leave_time` time NOT NULL,
  `recipient_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `date_lists`
--

CREATE TABLE `date_lists` (
  `selected_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `date_lists`
--

INSERT INTO `date_lists` (`selected_date`) VALUES
('2020-09-15');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `ar_day`, `en_day`, `sort`) VALUES
(1, 'السبت', 'Saturday', 1),
(2, 'الاحد', 'Sunday', 2),
(3, 'الاثنين', 'Monday', 3),
(4, 'الثلاثاء', 'Tuesday', 4),
(5, 'الاربعاء', 'Wednesday', 5),
(6, 'الخميس', 'Thursday', 6),
(7, 'الجمعه', 'Friday', 7);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_deduction` date NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `days` double(4,2) NOT NULL,
  `approval1` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `approval2` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_one_user` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_two_user` bigint(20) UNSIGNED DEFAULT NULL,
  `leave_permission_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_department` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_department` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sector_id` bigint(20) UNSIGNED NOT NULL,
  `leave_allocate` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designs`
--

CREATE TABLE `designs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `design_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `default_design` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_division_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_division_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_students` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ar_school_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_school_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_document` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_document` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents_grades`
--

CREATE TABLE `documents_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_document_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attendance_id` int(11) NOT NULL,
  `ar_st_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ar_nd_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_st_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_nd_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile1` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile2` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci DEFAULT 'male',
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` enum('muslim','christian') COLLATE utf8_unicode_ci DEFAULT 'muslim',
  `native` enum('Arabic','English','French','German','Italy') COLLATE utf8_unicode_ci DEFAULT 'Arabic',
  `marital_status` enum('Single','Married','Separated','Divorced','Widowed') COLLATE utf8_unicode_ci DEFAULT 'Single',
  `health_details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `national_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `military_service` enum('Exempted','Finished') COLLATE utf8_unicode_ci DEFAULT NULL,
  `hiring_date` date DEFAULT NULL,
  `job_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `has_contract` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `contract_type` enum('Full Time','Part Time') COLLATE utf8_unicode_ci DEFAULT 'Full Time',
  `contract_date` date DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `previous_experience` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_insurance` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `social_insurance_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `social_insurance_date` date DEFAULT NULL,
  `medical_insurance` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `medical_insurance_num` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_insurance_date` date DEFAULT NULL,
  `exit_interview_feedback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leave_date` date DEFAULT NULL,
  `leave_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `leaved` enum('Yes','No') COLLATE utf8_unicode_ci DEFAULT 'No',
  `salary` decimal(8,2) DEFAULT NULL,
  `salary_suspend` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `salary_mode` enum('Cash','Bank') COLLATE utf8_unicode_ci DEFAULT 'Cash',
  `salary_bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `leave_balance` int(11) DEFAULT NULL,
  `bus_value` int(11) DEFAULT NULL,
  `vacation_allocated` int(11) DEFAULT NULL,
  `sector_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position_id` bigint(20) UNSIGNED DEFAULT NULL,
  `timetable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `direct_manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ar_rd_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ar_th_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_rd_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_th_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `attendance_id`, `ar_st_name`, `ar_nd_name`, `en_st_name`, `en_nd_name`, `email`, `mobile1`, `mobile2`, `dob`, `gender`, `address`, `religion`, `native`, `marital_status`, `health_details`, `national_id`, `military_service`, `hiring_date`, `job_description`, `has_contract`, `contract_type`, `contract_date`, `contract_end_date`, `previous_experience`, `institution`, `qualification`, `social_insurance`, `social_insurance_num`, `social_insurance_date`, `medical_insurance`, `medical_insurance_num`, `medical_insurance_date`, `exit_interview_feedback`, `leave_date`, `leave_reason`, `leaved`, `salary`, `salary_suspend`, `salary_mode`, `salary_bank_name`, `bank_account`, `leave_balance`, `bus_value`, `vacation_allocated`, `sector_id`, `department_id`, `section_id`, `position_id`, `timetable_id`, `user_id`, `admin_id`, `direct_manager_id`, `deleted_at`, `created_at`, `updated_at`, `employee_image`, `ar_rd_name`, `ar_th_name`, `en_rd_name`, `en_th_name`) VALUES
(1774, 2, 'اشرقت', 'محمود', 'Ashraqat', 'Mahmoud', 'null', '1153197527', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28512130100763', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1775, 5, 'ايمان', 'اسماعيل', 'Eman', 'Ismail', 'null', '1098834482', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29402240100061', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1776, 6, 'رغدة', 'محمود', 'Raghda', 'Mahmoud', 'null', '1021364719', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29506080103841', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محيي الدين', 'null', 'Mohy Eldin', 'null'),
(1777, 8, 'مي ', 'مصطفى', 'MAi', 'Mostafa', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29001110200507', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1778, 9, 'ياسمين', 'رضا', 'Yasmeen', 'reda', 'null', '1060797080', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28803240104084', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مهدي', 'null', 'Mahdy', 'null'),
(1779, 13, 'ايناس', 'احمد', 'Enas', 'Ahmed ', 'null', '1012446587', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, 'a11716831', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ايوب', 'null', 'Ayoub', 'null'),
(1780, 15, 'ريم', 'محمد', 'Reem', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28207170104705', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1781, 17, 'انوار', 'علي', 'Anwar', 'Ali', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '561862212', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1782, 19, 'ريم', 'محروس', 'Reem', 'Mahrous', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29508100104141', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1783, 22, 'هويدا', 'احمد', 'Hwaida', 'Ahmed ', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28012178800306', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1784, 23, 'محمود', 'سعد', 'Mahmoudsaad', 'Abd Elhamid', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28505180103341', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الحميد', 'null', 'null', 'null'),
(1785, 24, 'دينا', 'طارق', 'dina', 'tarek', 'null', '1005331409', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29311290102264', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Moahmed', 'null'),
(1786, 25, 'هميس', 'محمد', 'Hamees', 'Mohamed', 'null', '1092446034', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29009042102187', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1787, 26, 'سلمى', 'اشرف', 'Salma', 'Ashraf', 'null', '1112338316', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28911110102982', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رضوان', 'null', 'Radwan', 'null'),
(1788, 28, 'نورهان', 'احمد', 'Norhan', 'Ahmed ', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '2907310102561', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1789, 29, 'ابتسام', 'علي', 'Ibtisam', 'Ali', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28009010113205', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1790, 34, 'هناء', 'حامد', 'Hanaa', 'Hamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29207168800609', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مسعد', 'null', 'Mosaad', 'null'),
(1791, 35, 'هشام', 'ابراهيم', 'Hisham', 'Ibrahim', 'null', '1002447829', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28203210104449', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1792, 36, 'جيهان', 'شافعي', 'Jihan', 'Shafiee', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28903080100049', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1793, 37, 'كريمان', 'خميس', 'Kareman', 'Khames', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28908128800708', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ابو سمرة', 'null', 'Abo Samra', 'null'),
(1794, 38, 'فاطمة', 'روق', 'Fatma', 'rook', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28912082100401', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'روق', 'null', 'rook', 'null'),
(1795, 39, 'شيماء', 'عادل', 'Shaimaa', 'Adel', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29111231400902', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الهادي', 'null', 'Abd Elhady', 'null'),
(1796, 40, 'نسمة', 'حسين', 'Nessma', 'Hussien', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29308180101822', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'الشاذلي', 'null', 'Shazly', 'null'),
(1797, 41, 'نجاة', 'خميس', 'Nagat', 'Khames', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29404160103984', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الرحمن', 'null', 'AbdElrahman', 'null'),
(1798, 43, 'حنان', 'ريان', 'Hanan', 'Rayan', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28509300108925', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1799, 44, 'اسماء ', 'ريان', 'Asmaa', 'Rayan', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '27511050100196', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1800, 45, 'ايه ', 'عماد', 'Aya', 'Emad', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1801, 46, 'هند', 'سيد', 'Hend', 'Sayed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29401011600909', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'فخري', 'null', 'Fakhry', 'null'),
(1802, 47, 'شيماء ', 'عيد', 'Shaimaa', 'Eid', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28712180104289', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مصطفى', 'null', 'Mostafa', 'null'),
(1803, 48, 'هنا', 'رضا', 'Hana', 'Reda', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29709270102067', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الله', 'null', 'Abdallah', 'null'),
(1804, 49, 'هدى', 'سيد', 'Huda', 'Sayed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28809280100128', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1805, 50, 'زهرة', 'سليمان', 'Zahraa', 'Soliman', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29705200101505', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'خليل', 'null', 'Khalil', 'null'),
(1806, 52, 'ايمان', 'احمد', 'Eman', 'Ahmed ', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '2980206210444', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سعد', 'null', 'Saad', 'null'),
(1807, 53, 'ندى', 'محمد', 'Nada', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28909110101761', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1808, 54, 'ريهام', 'عماد', 'Riham', 'Emad', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28802070101763', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عثمان', 'null', 'Othman', 'null'),
(1809, 55, 'هدى', 'فتحي', 'Hoda', 'Fathi', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29712070103647', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'غريب', 'null', 'Ghareeb', 'null'),
(1810, 57, 'وفاء', 'رشدي', 'Wafaa', 'Roshdy', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29412188800284', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رشاد', 'null', 'Rashad', 'null'),
(1811, 59, 'نورة', 'محمد', 'Noura', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29410010119785', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الشافي', 'null', 'Abd Elshafie', 'null'),
(1812, 61, 'شيماء', 'صابر', 'Shaima', 'Saber', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29804142103207', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الباسط', 'null', 'Abd Elbaset', 'null'),
(1813, 62, 'فاطمة', 'احمد', 'Fatma', 'Ahmed ', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29703030105362', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الموجود', 'null', 'AbdElmawgod', 'null'),
(1814, 63, 'هايدي', 'جهاد', 'Haidy', 'Gehad', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28709030103721', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1815, 65, 'نيرة', 'رضا', 'Nayra', 'Reda', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '7716988', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسين', 'null', 'Hussien', 'null'),
(1816, 66, 'امنية', 'محمد', 'Omnia ', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29712262100064', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الحكيم', 'null', 'Abd Elhakim', 'null'),
(1817, 67, 'مروة', 'محمود', 'Marwa', 'Mahmoud', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29711260100249', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1818, 68, 'ضحى', 'عبد النبي', 'Doha', 'AbdElnabi', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29901210104824', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ابو حديد', 'null', 'Abo Hadid', 'null'),
(1819, 70, 'شروق', 'عادل', 'Shrouk', 'Adel', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29607101900809', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'طنطاوي', 'null', 'Tantawy', 'null'),
(1820, 71, 'بسنت', 'محمد', 'Bassant', 'Mohamed', 'null', '1100460259', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29810180101242', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الحميد', 'null', 'AbdElhamid', 'null'),
(1821, 73, 'عايدة', 'نفادي', 'Aida', 'Nafadi', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29805172100063', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سعد الدين', 'null', 'Saad Eldien', 'null'),
(1822, 74, 'الفت', 'صبحي', 'Olfat', 'Sobhi', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28504040103477', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبدالحميد', 'null', 'AbdElhamid', 'null'),
(1823, 75, 'نوران', 'حسن', 'Nora', 'Hassan', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28905272402513', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1824, 76, 'امال', 'عادل', 'Amal', 'Adel', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1825, 77, 'بخيتة', 'فاروق', 'Bekheta', 'Farouk', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29104178800735', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1826, 78, 'رحمة', 'ياسر', 'Rahma', 'Yasser', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '27607060100245', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1827, 79, 'اماني ', 'مصطفى', 'Amany', 'Mostafa', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28110151401843', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمدي', 'null', 'Mohamady', 'null'),
(1828, 80, 'نهى', 'جلال', 'Noha', 'Galaa', 'null', '1151720024', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28509040104106', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1829, 81, 'عمر', 'محمد', 'Omar', 'Mohamed', 'null', '1003021596', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28910010103268', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مجدي', 'null', 'Mady', 'null'),
(1830, 82, 'عمر', 'محمد', 'Omar', 'Mohamed', 'null', '1128890005', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28902202104869', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد اللطيف', 'null', 'Abdellatif', 'null'),
(1831, 83, 'هدير', 'فؤاد', 'Hadeer', 'Fouad', 'null', '1124433120', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29807210201742', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1832, 84, 'ماهي نور', 'يسري', 'Mahinour', 'yousri', 'null', '1000843402', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29708150106844', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'شلبي', 'null', 'shalaby', 'null'),
(1833, 85, 'عبده', 'وليم', 'Abdu', 'William', 'null', '1284570324', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29602031305186', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عويضه', 'null', 'Ouida', 'null'),
(1834, 86, 'سماء', 'محمود', 'samaa', 'mahmoud', 'null', '1005398447', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28706090101043', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'شحاته', 'null', 'shehata', 'null'),
(1835, 87, 'احمد', 'سيد', 'Ahmed', 'Sayed', 'null', '1555162411', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29009260102881', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عيد', 'null', 'Eid', 'null'),
(1836, 88, 'محمد', 'طارق', 'Mohamed', 'Tarek', 'null', '1155529995', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29606172101725', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'الهامي', 'null', 'Elhamy', 'null'),
(1837, 90, 'منة الله', 'علي', 'Menatallah', 'ali', 'null', '1024484980', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29509028800664', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'mohamed', 'null'),
(1838, 91, 'عبد السلام', 'حميد', 'Abdelsalam', 'Hamid', 'null', '1158472877', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28509200300161', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '8000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبدالخبير', 'null', 'Abdelkhaber', 'null'),
(1839, 92, 'سارة', 'علي', 'Sara', 'Ali', 'null', '1006365454', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28609150102944', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '10000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'الداخلي', 'null', 'EL Dakhly', 'null'),
(1840, 94, 'لبنى', 'جمال ', 'Lobna', 'Gamal eldin', 'null', '1150265594', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29210182102869', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عفيفي', 'null', 'Afifi', 'null'),
(1841, 98, 'روان', 'زكريا', 'Rawan', 'Zakaria', 'null', '1153667603', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29303290102709', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohammed', 'null'),
(1842, 99, 'دينا', 'محمود', 'Dina', 'Mahmoud', 'null', '1016658694', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28711020103662', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'طه', 'null', 'Taha', 'null'),
(1843, 101, 'امنية', 'محد', 'Omnia', 'Mohamed', 'null', '1144752919', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28003310100425', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مصطفى', 'null', 'Mostafa', 'null'),
(1844, 102, 'شيروت', 'مبروك', 'Sherwt', 'Mabrook', 'null', '1144874769', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29404041401934', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1845, 103, 'نادية', 'ابراهيم', 'Nadia', 'Ibrahim', 'null', '1061512011', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29310010119306', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'لبيب', 'null', 'Labib', 'null'),
(1846, 104, 'دعاء', 'نبيل', 'Doaa', 'Nabil', 'null', '1060474852', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28710121300314', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hasan', 'null'),
(1847, 106, 'مروة', 'منصور', 'Marwa', 'Mansour', 'null', '1002088209', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29509302103339', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '17500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1848, 109, 'بانسيه', 'عماد', 'Panse', 'Emad', 'null', '1009274895', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29101011700136', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'انور', 'null', 'Anwar', 'null'),
(1849, 110, 'رضوى', 'محمد', 'Radwa', 'Mohamed', 'null', '1110065507', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29507081500858', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مسلم', 'null', 'Mosalam', 'null'),
(1850, 111, 'ندا', 'صلاح', 'Nada', 'Salah', 'null', '1017166114', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29307032202575', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1851, 113, 'الاء', 'سعيد', 'Alaa', 'Saied', 'null', '1008636373', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28808052100758', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سعد', 'null', 'Saad', 'null'),
(1852, 114, 'لمى', 'محمد', 'Lama', 'Mohamed', 'null', '1118757621', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29210241701534', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمود', 'null', 'Mahmoud', 'null'),
(1853, 115, 'انجي', 'فوزي', 'enjy', 'Fawzy', 'null', '1005056689', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29206271302271', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1854, 116, 'شيماء', 'عبد الفتاح', 'shaimaa', 'Abdelfatah', 'null', '1023260933', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1855, 117, 'رضوى ', 'خالد', 'Radwa', 'khaled', 'null', '1003545946', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29005150105898', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1856, 118, 'اسماء ', 'محمد', 'Asmaa', 'Mohamed', 'null', '1006159797', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '27103120100403', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'فهمي', 'null', 'Fahmy', 'null'),
(1857, 119, 'منة الله', 'مجدي', 'Mennatullah', 'Magdy', 'null', '1116761026', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28603050104607', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1858, 120, 'اسراء ', 'محمد', 'Esraa', 'Mohamed', 'null', '1121134358', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29010280101804', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مصطفى', 'null', 'Mostafa', 'null'),
(1859, 121, 'رقية', 'ابو العلا', 'Rokaya', 'Aboelela', 'null', '1063833975', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29005112101641', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمود', 'null', 'Mahmoud', 'null'),
(1860, 123, 'مي ', 'محمد', 'Mai', 'Mohamed', 'null', '1012626460', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29309012307462', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سليمان', 'null', 'soliman', 'null'),
(1861, 124, 'احمد', 'صلاح', 'Ahmed ', 'Salah', 'null', '1032337831', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28510230104119', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'توفيق', 'null', 'Tawfik', 'null'),
(1862, 125, 'احمد', 'عصام', 'Ahmed', 'Essam', 'null', '1145839136', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29107230101149', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سعد', 'null', 'Saad', 'null'),
(1863, 126, 'فتيحة', 'حويشي', 'Fatiha', 'Hwaishy', 'null', '1065978722', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29508280104828', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1864, 128, 'ناني', 'صليب', 'NaNy', 'Saleb', 'null', '1007685578', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '21912012701871', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'جاد', 'null', 'Gad', 'null'),
(1865, 130, 'فاطمة', 'سليم', 'fatma', 'selim', 'null', '1145034342', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29401010130071', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الغني', 'null', 'Abd Elghany', 'null'),
(1866, 131, 'زينب', 'علي', 'Zainb', 'Ali', 'null', '1012045459', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29004202300221', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1867, 132, 'جمال', 'ناجي', 'Gamal', 'Nagy', 'null', '1110992807', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28705010109549', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد اللطيف', 'null', 'Abdellatif', 'null'),
(1868, 133, 'رجاء', 'السرحي', 'Raga', 'Elsarhi', 'null', '1009397990', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28411120103283', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '10000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1869, 135, 'رانا', 'اكرم', 'Rana', 'Akram', 'null', '1123664449', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29602030101145', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رضوان', 'null', 'Radwan', 'null'),
(1870, 136, 'معتز', 'اكرم', 'Moataz', 'Akram', 'null', '1119959000', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29802210104761', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رضوان', 'null', 'Radwan', 'null'),
(1871, 137, 'شيماء', 'نبيل', 'shaima', 'Nabil', 'null', '1020528292', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29211010105706', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'يوسف', 'null', 'Youssef', 'null'),
(1872, 138, 'يسرى', 'محمد', 'Yosra', 'Mohamed', 'null', '1282541946', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29604012111608', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'نجيب', 'null', 'Nagib', 'null'),
(1873, 139, 'رضا', 'غالب', 'Reda', 'Ghaleb', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28002251300087', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الغني', 'null', 'AbdElghani', 'null'),
(1874, 140, 'اصالة', 'اشرف', 'Asala', 'Ashraf', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29603060103581', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ربيع', 'null', 'Rabee', 'null'),
(1875, 141, 'داليا', 'سعود', 'Dalia', 'Soud', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '26801010300186', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سالم', 'null', 'Salem', 'null'),
(1876, 146, 'انجي', 'عبدالسلام', 'Injy', 'Abdelsalam', 'null', '1098624888', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28510260100967', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1877, 147, 'منة الله', 'ابراهيم', 'Menatullah', 'Ibrahim', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '9503211403361', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد النبي', 'null', 'Abd Elnabi', 'null'),
(1878, 148, 'نوران', 'مصطفى', 'Nouran', 'Mostafa', 'null', '1026905378', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '3030504', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الصادق', 'null', 'AbdElsadek', 'null'),
(1879, 149, 'شذى', 'مصطفى', 'Shaza', 'Mostafa', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '156486934', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الصادق', 'null', 'Abd Elsadek', 'null'),
(1880, 150, 'اسراء ', 'علي', 'esraa', 'Ali', 'null', '1096733037', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28607040103438', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سنوسي', 'null', 'Snosy', 'null'),
(1881, 151, 'هبة الله', 'جمال', 'Hebatallah', 'Gamal eldin', 'null', '1155414739', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28807140101563', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عفيفي', 'null', 'Afifi', 'null'),
(1882, 152, 'زينب', 'احمد', 'Zainb', 'Ahmed ', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29103041602034', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'نجيب', 'null', 'Nagib', 'null'),
(1883, 154, 'ايه ', 'سليمان', 'Aya', 'Soliman', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29612180102706', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1884, 155, 'فوقية', 'محمد', 'Fawkia', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29801170101962', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'يوسف', 'null', 'Youssef', 'null'),
(1885, 156, 'اسراء ', 'جمال الدين', 'Esraa', 'Gamal eldin', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29810061801104', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الصادق', 'null', 'Hussien', 'null'),
(1886, 158, 'فاطمة', 'محمود', 'Fatma', 'Mahmoud', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29802092501467', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عثمان', 'null', 'Othman', 'null'),
(1887, 159, 'نجلاء', 'عزت', 'Naglaa', 'Ezzat', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29602232101414', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الستار', 'null', 'AbdElsattar', 'null'),
(1888, 160, 'نوال', 'عبد الرحمن', 'Nawal', 'Abdelrahman', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29008112101562', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1889, 161, 'زهرة', 'بخيت', 'Zahraa', 'Bekhet', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29512190102076', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عمر', 'null', 'Omar', 'null');
INSERT INTO `employees` (`id`, `attendance_id`, `ar_st_name`, `ar_nd_name`, `en_st_name`, `en_nd_name`, `email`, `mobile1`, `mobile2`, `dob`, `gender`, `address`, `religion`, `native`, `marital_status`, `health_details`, `national_id`, `military_service`, `hiring_date`, `job_description`, `has_contract`, `contract_type`, `contract_date`, `contract_end_date`, `previous_experience`, `institution`, `qualification`, `social_insurance`, `social_insurance_num`, `social_insurance_date`, `medical_insurance`, `medical_insurance_num`, `medical_insurance_date`, `exit_interview_feedback`, `leave_date`, `leave_reason`, `leaved`, `salary`, `salary_suspend`, `salary_mode`, `salary_bank_name`, `bank_account`, `leave_balance`, `bus_value`, `vacation_allocated`, `sector_id`, `department_id`, `section_id`, `position_id`, `timetable_id`, `user_id`, `admin_id`, `direct_manager_id`, `deleted_at`, `created_at`, `updated_at`, `employee_image`, `ar_rd_name`, `ar_th_name`, `en_rd_name`, `en_th_name`) VALUES
(1890, 162, 'حنان', 'يونس', 'Hanan', 'Younes', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28807118800687', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1891, 163, 'محمود', 'عمر', 'Mahmoud', 'Omar', 'null', '1066600283', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29704070104241', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1892, 164, 'حسناء ', 'محمد', 'Hassna', 'Mohamed', 'null', '1145936921', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28702261301083', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'متولي', 'null', 'Metwally', 'null'),
(1893, 165, 'امل', 'عبد العزيز', 'Aml', 'Abd elaziz', 'null', '1141158612', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29407182101526', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1894, 166, 'همت', 'يوسف', 'Hemt', 'youssef', 'null', '1099796274', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28607132103141', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '25000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1895, 167, 'احمد', 'عبد العزيز', 'Ahmed', 'Abdelaziz', 'null', '1003524836', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29308202101678', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '8000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'السيد', 'null', 'Elsaayed', 'null'),
(1896, 168, 'احمد', 'عبدالعطي', 'Ahmed', 'Abd Ellatif', 'null', '1154383108', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29702122101065', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الرازق', 'null', 'Abd Elraziq', 'null'),
(1897, 169, 'ولاء', 'زكريا ', 'Walaa', 'Zakria', 'null', '1111181733', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '26906190100764', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'البصري', 'null', 'Elbasry', 'null'),
(1898, 170, 'مي ', 'عبد الناصر', 'Mai', 'Abdelnasr', 'null', '1140676034', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohammed', 'null'),
(1899, 171, 'ايه ', 'محمد ', 'Aya', 'Mohamed', 'null', '1023905522', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الرازق', 'null', 'Abdelraziq', 'null'),
(1900, 172, 'حنان ', 'حمدي', 'Hanan', 'Hamdy', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1901, 173, 'حنان', 'علي', 'Hanan', 'Ali', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1902, 174, 'غادة', 'حمدي', 'Ghada', 'Hamdy', 'null', '1032265887', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1903, 175, 'ايمان', 'فؤاد', 'Eman', 'Fouad', 'null', '1555587128', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1904, 176, 'ابراهيم', 'حسن', 'Ibrahim', 'Hassan', 'null', '1008832395', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1905, 177, 'عايدة', 'علي', 'Aida', 'Ali', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'جاد', 'null', 'Gad', 'null'),
(1906, 178, 'دينا', 'عادل', 'Dina', 'Adel', 'null', '1030234521', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '27808180104941', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'اسماعيل', 'null', 'Ismail', 'null'),
(1907, 179, 'نيفين', 'عبد الرحمن', 'Neven', 'Abdelrahman', 'null', '1141477088', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '27903121602387', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan Ahmed', 'null'),
(1908, 180, 'علياء', 'منصور', 'Aliaa', 'Mansour', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1909, 181, 'بسنت', 'محمد', 'Bassant', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'جمال', 'null', 'Gamal', 'null'),
(1910, 182, 'هاجر', 'سالم', 'Hagar', 'Salem', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29006100104722', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1911, 183, 'شروق', 'حسين', 'Shrouk', 'Hussien', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '28604230103508', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1912, 184, 'امل ', 'روق', 'Amal ', 'Rouk', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29205111402337', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'روق', 'null', 'Rouk', 'null'),
(1913, 185, 'احمد', 'محمد', 'Ahmed', 'Mohamed', 'null', '1271554464', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '295040811974', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسام', 'null', 'Hossam', 'null'),
(1914, 186, 'رنا', 'احمد', 'Rana', 'Ahmed ', 'null', '1288644083', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, '29112100101931', NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حمدي', 'null', 'Hamdy', 'null'),
(1915, 188, 'زينب ', 'احمد', 'Zainb', 'Ahmed ', 'null', '1147203441', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حنفي', 'null', 'Hanafy', 'null'),
(1916, 189, 'نبأ', 'نديم', 'Nabaa', 'Nadim', 'null', '1011006237', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'نبيل', 'null', 'Nabil', 'null'),
(1917, 190, 'نورهان', 'حموده', 'Norhan', 'Hamouda', 'null', '1024488829', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبدالحافظ', 'null', 'Abdelhafez', 'null'),
(1918, 191, 'الاء', 'محمد', 'Alaa', 'Mohamed', 'null', '1140099110', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد القادر', 'null', 'AbdelKadeer', 'null'),
(1919, 192, 'منةالله', 'نهاد', 'Menatallah', 'Nehad ', 'null', '1100068265', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5700.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسن', 'null', 'Hassan', 'null'),
(1920, 193, 'عبير', 'احمد', 'Abeer', 'Ahmed ', 'null', '1152244884', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حلمي', 'null', 'Helmy', 'null'),
(1921, 194, 'هند', 'احمد', 'Hind', 'Ahmed ', 'null', '1118212341', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1922, 195, 'مادونا ', 'ميلاد', 'Madona', 'Milad', 'null', '1277261924', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ميائيل', 'null', 'Mikhail', 'null'),
(1923, 196, 'علي', 'محمد', 'Ali', 'Mohamed', 'null', '1117477276', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1924, 197, 'احمد', 'حسن', 'Ahmed', 'Hassan', 'null', '1126167950', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد السميع', 'null', 'AbdElsamee', 'null'),
(1925, 198, 'ياسمين', 'احمد', 'Yasmin', 'Ahmed ', 'null', '1014955311', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سيد', 'null', 'Sayed', 'null'),
(1926, 199, 'احمد ', 'السيد', 'Ahmed', 'ElSayed', 'null', '1007456070', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'العربي', 'null', 'ElAraby', 'null'),
(1927, 200, 'احمد', 'رجائي ', 'Ahmed', 'Ragaay', 'null', '1017712736', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ابراهيم', 'null', 'Ibrahim', 'null'),
(1928, 201, 'احمد', 'محمد', 'Ahmed', 'Mohamed', 'null', '1030402800', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'نبوي', 'null', 'Nabwi', 'null'),
(1929, 202, 'باسم', 'محسن', 'Bassem', 'Mohsen', 'null', '1114507700', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'Ahmed', 'null'),
(1930, 203, 'اسلام', 'حسن', 'Eslam', 'Hassan', 'null', '1143989252', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'قطب', 'null', 'Kotb', 'null'),
(1931, 204, 'ياسمين', 'شريف', 'Yasmeen', 'sherif', 'null', '1225643332', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '15000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'ali', 'null'),
(1932, 205, 'محمد', 'ابوالعلا', 'Mohammed', 'Ahmed ', 'null', '1552360325', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ابراهيم', 'null', 'Mohamed', 'null'),
(1933, 206, 'محمد', 'جمعة', 'Mohamed ', 'Gomaa', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'طلبة', 'null', 'Tolbaa', 'null'),
(1934, 207, 'رحاب', 'عبد المطلب', 'Rehab', 'Abd Elmotelb', 'null', '1277821899', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1935, 208, 'دعاء', 'نظمي', 'Doaa', 'Nazmy', 'null', '1152603331', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '9500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'بيومي', 'null', 'Baioumy', 'null'),
(1936, 211, 'عماد', 'صالح', 'Emad', 'Saleh', 'null', '1027034700', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الخالق', 'null', 'AbdElKhaleq', 'null'),
(1937, 212, 'محمد', 'ياسر', 'Mohamed', 'Yasser', 'null', '1011312920', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد اللطيف', 'null', 'AbdEllatif', 'null'),
(1938, 214, 'ايات', 'عادل', 'Ayat', 'Adel', 'null', '1061464605', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4300.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رجب', 'null', 'Ragab', 'null'),
(1939, 215, 'اسماء ', 'احمد', 'Asmaa', 'Ahmed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبدالحميد', 'null', 'Abdelhamid', 'null'),
(1940, 216, 'نيفين', 'السيد', 'Neveen', 'ElSayed', 'null', '1001498726', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'راضي', 'null', 'Rady', 'null'),
(1941, 218, 'شيماء', 'عبد الغفور', 'Shaima', 'AbdElghafour', 'null', '1010072262', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الظاهر', 'null', 'AbdElzaher', 'null'),
(1942, 219, 'هاجر', 'احمد', 'Hagar', 'Ahmed ', 'null', '1112160005', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مصطفى', 'null', 'Mostafa', 'null'),
(1943, 220, 'تسنيم', 'علاء الدين', 'Tasnem', 'Alaaeldien', 'null', '1009697202', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'شحاتة', 'null', 'Shehata', 'null'),
(1944, 221, 'اسماء ', 'محمود', 'Asmaa', 'mahmoud', 'null', '1000602604', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '7500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مختار', 'null', 'Mokhtar', 'null'),
(1945, 223, 'رانية', 'سمير', 'Rania', 'Samir', 'null', '1063116285', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'الاشرم', 'null', 'AlAshram', 'null'),
(1946, 224, 'ايمان', 'عبد الله', 'Eman', 'Abdallah', 'null', '1001535947', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مرسي', 'null', 'Morsi', 'null'),
(1947, 225, 'سارة', 'طارق', 'Sara', 'Tarek', 'null', '1013701430', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد الهادي', 'null', 'Abdelhady', 'null'),
(1948, 227, 'سارة', 'رؤوف', 'Sara', 'Raouf', 'null', '1147458838', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1949, 228, 'منة الله', 'السيد', 'Menatuallah', 'Elsayed', 'null', '01005830051', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1950, 229, 'اميرة', 'محمود', 'Amira', 'Mahmoud', 'null', '01009389520', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1951, 230, 'نورهان', 'ياسر', 'Nourhan ', 'Yasser', 'null', '01014153206', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سمير', 'null', 'Samir', 'null'),
(1952, 231, 'مي ', 'عبد اللطيف', 'Mai', 'Abdulatif', 'null', '01004371625', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1953, 232, 'مها', 'نبيل', 'Maha', 'Nabil', 'null', '1090499960', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبدالله', 'null', 'Abdallah', 'null'),
(1954, 233, 'دينا', 'محمود', 'dina', 'mahmoud', 'null', '01005784114', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'طه', 'null', 'taha', 'null'),
(1955, 234, 'هدير', 'سعيد', 'Hadeer', 'Saeed', 'null', '1008135949', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حسين', 'null', 'Hussien', 'null'),
(1956, 236, 'هبة الله ', 'خالد', 'Hebatullah', 'Khaled', 'null', '01127766527', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'احمد', 'null', 'ahmed', 'null'),
(1957, 237, 'دينا', 'خالد', 'dina', 'Khaled', 'null', '01067972270', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'mohamed', 'null'),
(1958, 238, 'دينا', 'علاء الدين', 'Dina', 'Alaaeldien', 'null', '1154246211', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد المنعم', 'null', 'AbdElmenem', 'null'),
(1959, 240, 'ايمان', 'سعيد', 'Eman', 'Saeed', 'null', '1095085511', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1960, 241, 'دينا', 'محمد', 'dina', 'Mohammed', 'null', '01066835794', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد السميع', 'null', 'AbdElsame', 'null'),
(1961, 242, 'هايدي', 'جمال', 'haidy', 'gamal', 'null', '01062401569', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'مصطفى', 'null', 'mostafa', 'null'),
(1962, 243, 'دعاء', 'احمد', 'Doaa', 'Ahmed', 'null', '10612379701', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'خالد', 'null', 'Khaled', 'null'),
(1963, 244, 'حنان', 'بسي', 'Hanan', 'Bessy', 'null', '1009397990', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'null', 'null', 'null', 'null'),
(1964, 247, 'دعاء', 'نبيل', 'doaa', 'Nabil', 'null', '1150854294', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سيد', 'null', 'Sayed', 'null'),
(1965, 248, 'دعاء ', 'احمد', 'Doaa', 'Ahmed ', 'null', '1001235370', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عادل', 'null', 'Adel', 'null'),
(1966, 250, 'مريم', 'عيد', 'Mariam', 'Eid', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1967, 253, 'يارا', 'احمد', 'yara', 'Ahmed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محفوظ', 'null', 'Mahfouz', 'null'),
(1968, 254, 'خد', 'عصام الدين', 'Khadeja', 'Essam Eldien', 'null', '1005864946', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1969, 256, 'هبة الله', 'فتحي', 'Hbatullah', 'fathy', 'null', '01152720075', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عبد المنعم', 'null', 'AbdElmenem', 'null'),
(1970, 258, 'شهلاء', 'عمر', 'Shahlaa', 'omar', 'null', '01122982939', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'سليمان', 'null', 'soliman', 'null'),
(1971, 259, 'منة الله', 'عبد اللطيف', 'Menatuallah', 'Abdellatif', 'null', '01100633315', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'ابو الحجاج', 'null', 'Abo Elhagag', 'null'),
(1972, 262, 'احمد', 'محمد', 'Ahmed', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عوض', 'null', 'Awad', 'null'),
(1973, 263, 'مريم', 'سعيد', 'Mariam', 'Saied', 'null', '01099788412', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1974, 264, 'ميادة', 'ناصر', 'Mayada', 'Nasser', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1975, 269, 'نهال', 'عصام', 'Nehal', 'Essam', 'null', '1159508634', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عباس', 'null', 'Abass', 'null'),
(1976, 270, 'لمى', 'يحيى', 'Lama', 'Yehia ', 'null', '1018109174', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'كامل', 'null', 'kame', 'null'),
(1977, 271, 'نسمة', 'سامح', 'Nesma', 'Sameh', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1978, 272, 'اسماء ', 'محمد', 'asmaa', 'Mohamed', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'خلف', 'null', 'Khalaf', 'null'),
(1979, 273, 'فارس', 'عبد الناصر', 'fares', 'Abdelnasser', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'شعبان', 'null', 'shabaan', 'null'),
(1980, 276, 'نوران', 'محمد', 'Nouran', 'Mohamed', 'null', '1005632800', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '6000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'رضوان', 'null', 'Radwan', 'null'),
(1981, 277, 'ناديين', 'محيي الدين', 'Nadeen', 'Mohey Eldien', 'null', '1149887014', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'حمدان', 'null', 'Hemdan', 'null'),
(1982, 278, 'ياسمين', 'احمد', 'yasmeen', 'Ahmed', 'null', '1125161516', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1983, 279, 'نهال', 'محمد', 'Nehal', 'Mohamed', 'null', '1123788585', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1984, 280, 'سلمى', 'عز الدين', 'Salma', 'EzzEldien', 'null', '1064404411', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'طه', 'null', 'Taha', 'null'),
(1985, 281, 'راندا', 'عصام', 'Randa', 'Essam', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '2400.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1986, 284, 'نورهان', 'هشام', 'Norhan', 'Hisham', 'null', '1062997124', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'كمال', 'null', 'Kamal', 'null'),
(1987, 285, 'يسرا', 'كمال', 'Yousra', 'Kamal', 'null', '1005423894', NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '4500.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'فتحي', 'null', 'Fathi', 'null'),
(1988, 287, 'داليا', 'خالد', 'Dalia', 'Khaled', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'علي', 'null', 'Ali', 'null'),
(1989, 288, 'صباح', 'كمال', 'Sabah', 'Kamal', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'محمد', 'null', 'Mohamed', 'null'),
(1990, 289, 'عادل', 'مصطفى', 'Adel', 'Mostafa', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'اسماعيل', 'null', 'Ismail', 'null'),
(1991, 290, 'جيهان', 'جمال', 'Jihan', 'gamal', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '5000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'عزيز', 'null', 'aziz', 'null'),
(1992, 8000, 'محمود', 'شعبان', 'Mahmoud ', 'Shabaan', 'null', NULL, NULL, NULL, 'male', NULL, 'muslim', 'Arabic', 'Single', NULL, NULL, NULL, NULL, NULL, 'No', 'Full Time', NULL, NULL, NULL, NULL, NULL, 'No', NULL, NULL, NULL, 'No', NULL, NULL, NULL, NULL, 'No', '3000.00', 'No', 'Cash', NULL, NULL, 2, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'كامل', 'null', 'Kamel', 'null');

-- --------------------------------------------------------

--
-- Table structure for table `employee_documents`
--

CREATE TABLE `employee_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `document_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_holidays`
--

CREATE TABLE `employee_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `holiday_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee_holiday_dates`
-- (See below for the actual view)
--
CREATE TABLE `employee_holiday_dates` (
`attendance_id` int(11)
,`date_holiday` date
);

-- --------------------------------------------------------

--
-- Table structure for table `employee_skills`
--

CREATE TABLE `employee_skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `external_codes`
--

CREATE TABLE `external_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pattern` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `replacement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fathers`
--

CREATE TABLE `fathers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_st_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ar_nd_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ar_rd_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ar_th_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_st_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_nd_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_rd_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_th_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `id_type` enum('national_id','passport') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'national_id',
  `id_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `home_phone` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualification` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id` bigint(20) UNSIGNED NOT NULL,
  `religion` enum('muslim','non_muslim') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'muslim',
  `educational_mandate` enum('father','mother') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'father',
  `block_no` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `street_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `government` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `marital_status` enum('married','divorced','separated','widower') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'married',
  `recognition` enum('facebook','street','parent','school_hub') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'facebook',
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `father_mother`
--

CREATE TABLE `father_mother` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `father_id` bigint(20) UNSIGNED NOT NULL,
  `mother_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `finalSheet`
-- (See below for the actual view)
--
CREATE TABLE `finalSheet` (
`en_st_name` varchar(25)
,`en_nd_name` varchar(25)
,`employee_id` bigint(20) unsigned
,`ar_timetable` varchar(50)
,`en_timetable` varchar(50)
,`on_duty_time` time
,`off_duty_time` time
,`beginning_in` time
,`ending_in` time
,`beginning_out` time
,`ending_out` time
,`saturday` varchar(255)
,`sunday` varchar(255)
,`monday` varchar(255)
,`tuesday` varchar(255)
,`wednesday` varchar(255)
,`thursday` varchar(255)
,`friday` varchar(255)
,`saturday_value` int(11)
,`sunday_value` int(11)
,`monday_value` int(11)
,`wednesday_value` int(11)
,`tuesday_value` int(11)
,`thursday_value` int(11)
,`friday_value` int(11)
,`daily_late_minutes` int(11)
,`leave_min` bigint(21)
,`day_absent_value` double(4,1)
,`noAttend` int(11)
,`noLeave` double(4,1)
,`attendance_id` int(11)
,`selected_date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(11)
,`no_leave` int(11)
,`overtime` bigint(21)
,`absent` varchar(4)
,`date_holiday` date
,`date_leave` date
,`time_leave` time
,`absent_after_holidays` varchar(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `final_attendance_sheet`
-- (See below for the actual view)
--
CREATE TABLE `final_attendance_sheet` (
`en_st_name` varchar(25)
,`en_nd_name` varchar(25)
,`employee_id` bigint(20) unsigned
,`ar_timetable` varchar(50)
,`en_timetable` varchar(50)
,`on_duty_time` time
,`off_duty_time` time
,`beginning_in` time
,`ending_in` time
,`beginning_out` time
,`ending_out` time
,`saturday` varchar(255)
,`sunday` varchar(255)
,`monday` varchar(255)
,`tuesday` varchar(255)
,`wednesday` varchar(255)
,`thursday` varchar(255)
,`friday` varchar(255)
,`saturday_value` int(11)
,`sunday_value` int(11)
,`monday_value` int(11)
,`wednesday_value` int(11)
,`tuesday_value` int(11)
,`thursday_value` int(11)
,`friday_value` int(11)
,`daily_late_minutes` int(11)
,`leave_min` bigint(21)
,`day_absent_value` double(4,1)
,`noAttend` int(11)
,`noLeave` double(4,1)
,`attendance_id` int(11)
,`selected_date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(11)
,`no_leave` int(11)
,`overtime` bigint(21)
,`absent` varchar(4)
);

-- --------------------------------------------------------

--
-- Table structure for table `fixed_components`
--

CREATE TABLE `fixed_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary_component_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `full_employee_data`
-- (See below for the actual view)
--
CREATE TABLE `full_employee_data` (
`id` bigint(20) unsigned
,`attendance_id` int(11)
,`ar_st_name` varchar(25)
,`ar_nd_name` varchar(25)
,`ar_rd_name` varchar(255)
,`ar_th_name` varchar(255)
,`en_st_name` varchar(25)
,`en_nd_name` varchar(25)
,`en_rd_name` varchar(255)
,`en_th_name` varchar(255)
,`email` varchar(50)
,`mobile1` varchar(12)
,`mobile2` varchar(12)
,`dob` date
,`gender` enum('male','female')
,`address` varchar(100)
,`religion` enum('muslim','christian')
,`native` enum('Arabic','English','French','German','Italy')
,`marital_status` enum('Single','Married','Separated','Divorced','Widowed')
,`health_details` varchar(255)
,`national_id` varchar(255)
,`military_service` enum('Exempted','Finished')
,`hiring_date` date
,`job_description` varchar(255)
,`has_contract` enum('Yes','No')
,`contract_type` enum('Full Time','Part Time')
,`contract_date` date
,`contract_end_date` date
,`previous_experience` text
,`institution` varchar(255)
,`qualification` varchar(255)
,`social_insurance` enum('Yes','No')
,`social_insurance_num` varchar(255)
,`social_insurance_date` date
,`medical_insurance` enum('Yes','No')
,`medical_insurance_num` varchar(255)
,`medical_insurance_date` date
,`exit_interview_feedback` varchar(255)
,`leave_date` date
,`leave_reason` text
,`leaved` enum('Yes','No')
,`salary` decimal(8,2)
,`salary_suspend` enum('Yes','No')
,`salary_mode` enum('Cash','Bank')
,`salary_bank_name` varchar(255)
,`bank_account` varchar(255)
,`leave_balance` int(11)
,`bus_value` int(11)
,`vacation_allocated` int(11)
,`sector_id` bigint(20) unsigned
,`department_id` bigint(20) unsigned
,`section_id` bigint(20) unsigned
,`position_id` bigint(20) unsigned
,`timetable_id` bigint(20) unsigned
,`user_id` bigint(20) unsigned
,`admin_id` bigint(20) unsigned
,`direct_manager_id` bigint(20) unsigned
,`deleted_at` timestamp
,`created_at` timestamp
,`updated_at` timestamp
,`employee_image` varchar(255)
,`en_department` varchar(25)
,`ar_department` varchar(25)
,`en_sector` varchar(25)
,`ar_sector` varchar(25)
,`en_section` varchar(25)
,`ar_section` varchar(25)
,`en_position` varchar(25)
,`ar_position` varchar(25)
,`en_timetable` varchar(50)
,`ar_timetable` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `full_student_data`
-- (See below for the actual view)
--
CREATE TABLE `full_student_data` (
`student_id` bigint(20) unsigned
,`student_type` enum('applicant','student')
,`ar_student_name` varchar(20)
,`en_student_name` varchar(20)
,`student_id_number` varchar(15)
,`student_id_type` enum('national_id','passport')
,`student_number` varchar(15)
,`gender` enum('male','female')
,`nationality_id` bigint(20) unsigned
,`religion` enum('muslim','non_muslim')
,`native_lang_id` bigint(20) unsigned
,`second_lang_id` bigint(20) unsigned
,`term` enum('all','first','second')
,`dob` date
,`code` int(11)
,`reg_type` enum('return','arrival','new','transfer')
,`grade_id` bigint(20) unsigned
,`division_id` bigint(20) unsigned
,`student_image` varchar(75)
,`submitted_application` varchar(75)
,`submitted_name` varchar(75)
,`submitted_id_number` varchar(15)
,`submitted_mobile` varchar(15)
,`school_id` bigint(20) unsigned
,`transfer_reason` varchar(255)
,`application_date` date
,`guardian_id` bigint(20) unsigned
,`place_birth` varchar(30)
,`return_country` varchar(30)
,`registration_status_id` bigint(20) unsigned
,`father_id` bigint(20) unsigned
,`ar_st_name` varchar(30)
,`ar_nd_name` varchar(30)
,`ar_rd_name` varchar(30)
,`ar_th_name` varchar(30)
,`en_st_name` varchar(30)
,`en_nd_name` varchar(30)
,`en_rd_name` varchar(30)
,`en_th_name` varchar(30)
,`id_number` varchar(15)
,`home_phone` varchar(11)
,`mobile1` varchar(15)
,`mobile2` varchar(15)
,`job` varchar(75)
,`email` varchar(75)
,`qualification` varchar(75)
,`facebook` varchar(50)
,`whatsapp_number` varchar(15)
,`educational_mandate` enum('father','mother')
,`block_no` varchar(5)
,`street_name` varchar(50)
,`state` varchar(30)
,`government` varchar(30)
,`marital_status` enum('married','divorced','separated','widower')
,`recognition` enum('facebook','street','parent','school_hub')
,`ar_father_name` varchar(123)
,`en_father_name` varchar(123)
,`full_name` varchar(75)
,`id_number_m` varchar(15)
,`mobile1_m` varchar(15)
,`mobile2_m` varchar(15)
,`job_m` varchar(75)
,`email_m` varchar(75)
,`qualification_m` varchar(75)
,`facebook_m` varchar(50)
,`whatsapp_number_m` varchar(15)
,`block_no_m` varchar(5)
,`street_name_m` varchar(50)
,`state_m` varchar(30)
,`ar_name_nat_female` varchar(50)
,`ar_name_nat_male` varchar(50)
,`en_name_nationality` varchar(50)
,`ar_grade_name` varchar(30)
,`en_grade_name` varchar(30)
,`ar_division_name` varchar(50)
,`en_division_name` varchar(50)
,`school_name` varchar(50)
,`guardian_full_name` varchar(75)
,`ar_name_status` varchar(50)
,`en_name_status` varchar(50)
,`ar_name_lang` varchar(50)
,`en_name_lang` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_grade_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_grade_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ar_grade_parent` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_grade_parent` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_age_year` int(11) DEFAULT NULL,
  `from_age_month` int(11) DEFAULT NULL,
  `to_age_year` int(11) DEFAULT NULL,
  `to_age_month` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guardian_full_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_guardian_type` enum('guardian','grand_pa','grand_ma','uncle','aunt') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'guardian',
  `guardian_id_type` enum('national_id','passport') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'national_id',
  `guardian_id_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_mobile1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_mobile2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardian_job` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_email` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guardian_block_no` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_street_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_state` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `guardian_government` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section` enum('system','staff','students','school_fees','public_relations','buses','accounting','school_control','clinic','inventory') COLLATE utf8_unicode_ci NOT NULL,
  `history` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crud` enum('index','store','update','destroy','import') COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_holiday` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_holiday` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_days`
--

CREATE TABLE `holiday_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_holiday` date NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `holiday_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_reports`
--

CREATE TABLE `hr_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hr_letter` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_leave` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_experience` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_vacation` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_loan` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `header` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `footer` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hr_reports`
--

INSERT INTO `hr_reports` (`id`, `hr_letter`, `employee_leave`, `employee_experience`, `employee_vacation`, `admin_id`, `created_at`, `updated_at`, `employee_loan`, `header`, `footer`) VALUES
(1, '', '', '', '', 1, '2020-11-02 11:24:15', '2020-11-02 11:24:15', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_name_interview` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_name_interview` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_name_lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_name_lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lang_type` enum('speak','study','speak_study') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'speak_study',
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `last_main_view`
-- (See below for the actual view)
--
CREATE TABLE `last_main_view` (
`en_st_name` varchar(25)
,`en_nd_name` varchar(25)
,`employee_id` bigint(20) unsigned
,`ar_timetable` varchar(50)
,`en_timetable` varchar(50)
,`on_duty_time` time
,`off_duty_time` time
,`beginning_in` time
,`ending_in` time
,`beginning_out` time
,`ending_out` time
,`saturday` varchar(255)
,`sunday` varchar(255)
,`monday` varchar(255)
,`tuesday` varchar(255)
,`wednesday` varchar(255)
,`thursday` varchar(255)
,`friday` varchar(255)
,`saturday_value` int(11)
,`sunday_value` int(11)
,`monday_value` int(11)
,`wednesday_value` int(11)
,`tuesday_value` int(11)
,`thursday_value` int(11)
,`friday_value` int(11)
,`daily_late_minutes` int(11)
,`leave_min` bigint(21)
,`day_absent_value` double(4,1)
,`noAttend` int(11)
,`noLeave` double(4,1)
,`attendance_id` int(11)
,`selected_date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(11)
,`no_leave` int(11)
,`overtime` bigint(21)
,`absent` varchar(4)
,`week` varchar(9)
,`date_holiday` date
,`vacation_type` varchar(20)
,`absent_after_holidays` varchar(4)
,`date_leave` date
,`time_leave` time
,`minutes_lates_after_request` varchar(21)
,`leave_early_after_request` varchar(21)
,`absentValue` double(12,1)
,`main_lates` varchar(21)
,`leave_mins` varchar(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `leave_permissions`
--

CREATE TABLE `leave_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_leave` date NOT NULL,
  `time_leave` time NOT NULL,
  `approval_one_user` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_two_user` bigint(20) UNSIGNED DEFAULT NULL,
  `approval1` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `approval2` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_type` enum('father','mother','others') COLLATE utf8_unicode_ci NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `leave_requests_view`
-- (See below for the actual view)
--
CREATE TABLE `leave_requests_view` (
`id` bigint(20) unsigned
,`date_leave` date
,`time_leave` time
,`approval_one_user` bigint(20) unsigned
,`approval_two_user` bigint(20) unsigned
,`approval1` enum('Accepted','Rejected','Canceled','Pending')
,`approval2` enum('Accepted','Rejected','Canceled','Pending')
,`leave_type_id` bigint(20) unsigned
,`employee_id` bigint(20) unsigned
,`admin_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`attendance_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_leave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_leave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `have_balance` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `activation` enum('active','inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `target` enum('late','early') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'late',
  `deduction` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `deduction_allocated` int(11) NOT NULL DEFAULT 0,
  `from_day` int(11) NOT NULL DEFAULT 1,
  `to_day` int(11) NOT NULL DEFAULT 31,
  `period` enum('this month','next month') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'this month',
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_loan` date NOT NULL,
  `amount` int(11) NOT NULL,
  `approval1` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `approval2` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_one_user` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_two_user` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `main_attendance_sheet`
-- (See below for the actual view)
--
CREATE TABLE `main_attendance_sheet` (
`en_st_name` varchar(25)
,`en_nd_name` varchar(25)
,`employee_id` bigint(20) unsigned
,`ar_timetable` varchar(50)
,`en_timetable` varchar(50)
,`on_duty_time` time
,`off_duty_time` time
,`beginning_in` time
,`ending_in` time
,`beginning_out` time
,`ending_out` time
,`saturday` varchar(255)
,`sunday` varchar(255)
,`monday` varchar(255)
,`tuesday` varchar(255)
,`wednesday` varchar(255)
,`thursday` varchar(255)
,`friday` varchar(255)
,`saturday_value` int(11)
,`sunday_value` int(11)
,`monday_value` int(11)
,`wednesday_value` int(11)
,`tuesday_value` int(11)
,`thursday_value` int(11)
,`friday_value` int(11)
,`daily_late_minutes` int(11)
,`leave_min` bigint(21)
,`day_absent_value` double(4,1)
,`noAttend` int(11)
,`noLeave` double(4,1)
,`attendance_id` int(11)
,`selected_date` date
,`clock_in` varchar(10)
,`clock_out` varchar(10)
,`work_time` varchar(10)
,`lates` varchar(10)
,`minutes` bigint(21)
,`leave_early` varchar(10)
,`leave_minutes` bigint(21)
,`no_attend` int(11)
,`no_leave` int(11)
,`overtime` bigint(21)
,`absent` varchar(4)
,`week` varchar(9)
,`date_holiday` date
,`vacation_type` varchar(20)
,`absent_after_holidays` varchar(4)
,`date_leave` date
,`time_leave` time
,`minutes_lates_after_request` varchar(21)
,`leave_early_after_request` varchar(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `medicals`
--

CREATE TABLE `medicals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blood_type` enum('unknown','-O','+O','-A','+A','-B','+B','-AB','+AB') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknown',
  `food_sensitivity` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `medicine_sensitivity` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `other_sensitivity` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `have_medicine` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `vision_problem` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `use_glasses` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `hearing_problems` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `speaking_problems` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `chest_pain` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `breath_problem` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `asthma` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `have_asthma_medicine` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `heart_problem` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `hypertension` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `diabetic` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `anemia` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `cracking_blood` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `coagulation` enum('yes','no') COLLATE utf8_unicode_ci DEFAULT 'no',
  `food_sensitivity_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicine_sensitivity_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_sensitivity_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `have_medicine_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vision_problem_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_glasses_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hearing_problems_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `speaking_problems_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chest_pain_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `breath_problem_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `asthma_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `have_asthma_medicine_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heart_problem_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hypertension_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diabetic_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anemia_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cracking_blood_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coagulation_note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meeting_status` enum('done','canceled','pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `interview_id` bigint(20) UNSIGNED NOT NULL,
  `father_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_07_15_203454_create_admins_table', 1),
(5, '2020_07_16_192242_create_settings_table', 1),
(6, '2020_07_18_203427_create_histories_table', 1),
(7, '2020_08_23_193547_create_table_years', 1),
(8, '2020_08_23_211707_create_table_divisions', 1),
(9, '2020_08_23_224111_create_table_grades', 1),
(10, '2020_08_24_175046_create_table_admission_documents', 1),
(11, '2020_08_24_205423_create_table_admission_steps', 1),
(12, '2020_08_25_075532_create_table_acceptance_tests', 1),
(13, '2020_08_25_100528_create_table_documents_grades', 1),
(14, '2020_08_25_181757_create_table_registration_status', 1),
(15, '2020_08_25_205458_create_table_nationalities', 1),
(16, '2020_08_25_213942_create_table_interviews', 1),
(17, '2020_08_25_224615_create_table_languages', 1),
(18, '2020_08_26_064357_add_column_ar_national_female', 1),
(19, '2020_08_26_072446_create_table_classrooms', 1),
(20, '2020_08_26_173145_create_table_designs', 1),
(21, '2020_08_28_054225_add_column_status_table_years', 1),
(22, '2020_08_28_065107_create_table_father', 1),
(23, '2020_08_28_065121_create_table_mother', 1),
(24, '2020_08_28_065155_create_pivot_table_father_mother', 1),
(25, '2020_08_30_073213_create_table_schools', 1),
(26, '2020_08_30_084942_create_table_guaridans', 1),
(27, '2020_08_30_104641_create_table_students', 1),
(28, '2020_08_30_104742_create_table_student_steps', 1),
(29, '2020_08_30_104907_create_table_student_doc_delivers', 1),
(30, '2020_08_30_105140_create_table_medicals', 1),
(31, '2020_08_30_105212_create_table_student_address', 1),
(32, '2020_09_03_155759_create_table_contacts', 1),
(33, '2020_09_03_225737_create_table_meetings', 1),
(34, '2020_09_05_090259_create_table_parent_reports', 1),
(35, '2020_09_07_163201_add_column_employee_open_addmission', 1),
(36, '2020_09_08_172546_create_view_full_student_data', 1),
(37, '2020_09_12_092053_create_table_assessments', 1),
(38, '2020_09_12_092139_create_table_tests', 1),
(39, '2020_09_13_091353_add_column_employee_tests_table', 1),
(40, '2020_09_15_212527_crete_table_students_statements', 1),
(41, '2020_09_17_184349_add_column-year_status', 1),
(42, '2020_09_18_131337_create_table', 1),
(43, '2020_09_20_185222_add_columns_divisions', 1),
(44, '2020_09_20_190548_add_columns_classes', 1),
(45, '2020_09_20_191719_create_table_stages', 1),
(46, '2020_09_20_201329_add_column_education_admin', 1),
(47, '2020_09_20_204733_add_column_divisions', 1),
(48, '2020_09_21_211052_create_table_stage_grades', 1),
(49, '2020_09_23_114854_create_table_authorizations', 1),
(50, '2020_09_23_115245_create_table_students_authorizations', 1),
(51, '2020_09_24_230533_create_table_rooms', 1),
(52, '2020_09_27_211719_create_table_leave_requests', 1),
(53, '2020_09_28_082005_create_report_contents_table', 1),
(54, '2020_09_29_192558_create_table_transfers', 1),
(55, '2020_09_30_195435_create_daily_requests_table', 1),
(56, '2020_09_30_211642_add_columns_table_report_contents', 1),
(57, '2020_09_30_234939_drop_column_endorsement', 1),
(58, '2020_09_30_235211_add_column_parent_request', 1),
(59, '2020_10_02_071534_create_parent_requests_table', 1),
(60, '2020_10_03_172825_create_table_notes', 1),
(61, '2020_10_06_053734_create_table_absences', 1),
(62, '2020_10_09_052554_create_table_archives', 1),
(63, '2020_10_10_123115_add_column_table_stages', 1),
(64, '2020_10_14_212107_add_column_default_table_designs', 1),
(65, '2020_10_15_042858_add_column_statement_request_to_tables_report_contents', 1),
(66, '2020_10_16_051657_add_columns_table_students', 1),
(67, '2020_10_17_084304_create_table_sectors', 1),
(68, '2020_10_17_093152_create_table_departments', 1),
(69, '2020_10_17_110317_create_table_sections', 1),
(70, '2020_10_17_113148_create_table_positions', 1),
(71, '2020_10_17_125735_create_table_documents', 1),
(72, '2020_10_17_133033_create_table_skills', 1),
(73, '2020_10_17_154154_create_table_holidays', 1),
(74, '2020_10_17_161654_create_table_holiday_days', 1),
(75, '2020_10_17_221622_create_table_leave_types', 1),
(76, '2020_10_18_050132_create_table_machines', 1),
(77, '2020_10_18_053526_create_table-hr_reports', 1),
(78, '2020_10_18_072329_create_table_external_codes', 1),
(79, '2020_10_18_122137_create_table_salary_components', 1),
(80, '2020_10_18_154525_create_table_days', 1),
(81, '2020_10_18_154602_create_table_timetables', 1),
(82, '2020_10_18_185740_create_table_employees', 1),
(83, '2020_10_19_113539_create_table_employee_documents', 1),
(84, '2020_10_19_113721_create_table_employee_holidays', 1),
(85, '2020_10_19_113908_create_table_employee_skills', 1),
(86, '2020_10_20_220317_add_column_employee_image', 1),
(87, '2020_10_20_231044_add_column_table_hr_reports', 1),
(88, '2020_10_21_064942_add_columns_table_hr_reports', 1),
(89, '2020_10_21_172757_create_view_full_employee_data', 1),
(90, '2020_10_21_184042_create_table_attachments', 1),
(91, '2020_10_21_211656_create_table_loans', 1),
(92, '2020_10_22_064433_create_table_deductions', 1),
(93, '2020_10_22_091337_create_table_vacations', 1),
(94, '2020_10_22_091351_create_vacation_periods_table', 1),
(95, '2020_10_22_200656_create_notifications_table', 1),
(96, '2020_10_23_085636_add_columns_vacations', 1),
(97, '2020_10_23_171050_add_columns_table_loans', 1),
(98, '2020_10_23_171141_add_columns_table_deduction', 1),
(99, '2020_10_23_173540_create_table_active_days_request', 1),
(100, '2020_10_24_055353_create_table_leave_permissions', 1),
(101, '2020_10_25_181027_create_attendance_sheets_table', 1),
(102, '2020_10_25_181028_create_table_attendances', 1),
(103, '2020_10_25_181242_create_table_date_lists', 1),
(104, '2020_10_25_181412_create_view_attendance_view', 1),
(105, '2020_10_25_181718_create_view_employee_holiday_dates', 1),
(106, '2020_10_25_182509_create_view_request_leave_types', 1),
(107, '2020_10_26_181828_create_view_attendance_sheet', 1),
(108, '2020_10_26_182240_create_view_period', 1),
(109, '2020_10_26_182431_create_view_attendance_sheet_dates', 1),
(110, '2020_10_26_182949_create_view_final_attendance_sheet', 1),
(111, '2020_10_26_195910_create_view_leave_requests_view', 1),
(112, '2020_10_26_200117_create_view_vacation_period_view', 1),
(113, '2020_10_26_201118_create_view_final_sheet', 1),
(114, '2020_10_26_201736_create_view_main_attendance_sheet', 1),
(115, '2020_10_26_202633_create_view_last_main_view', 1),
(116, '2020_10_27_174140_create_fixed_components_table', 1),
(117, '2020_10_27_174618_create_temporary_components_table', 1),
(118, '2020_10_27_175155_create_payroll_sheets_table', 1),
(119, '2020_10_27_175258_create_payroll_components_table', 1),
(120, '2020_10_27_175427_create_payroll_sheet_employees_table', 1),
(121, '2020_10_30_055420_add_column_table_payroll_component', 1),
(122, '2020_10_30_082913_add_column_calculate_payroll_components', 1),
(123, '2020_10_30_090830_create_view_total_payroll_view', 1),
(124, '2020_11_01_120034_change_columns_employees_status', 1),
(125, '2020_11_02_074738_edit_view_total_payroll_view', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mothers`
--

CREATE TABLE `mothers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `id_type_m` enum('national_id','passport') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'national_id',
  `id_number_m` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `home_phone_m` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile1_m` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile2_m` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `job_m` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `email_m` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qualification_m` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `facebook_m` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `whatsapp_number_m` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality_id_m` bigint(20) UNSIGNED NOT NULL,
  `religion_m` enum('muslim','non_muslim') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'muslim',
  `block_no_m` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `street_name_m` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state_m` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `government_m` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `en_name_nationality` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ar_name_nat_male` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ar_name_nat_female` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parent_requests`
--

CREATE TABLE `parent_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_request` date NOT NULL,
  `time_request` time NOT NULL,
  `notes` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_components`
--

CREATE TABLE `payroll_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `period` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` double(10,2) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `salary_mode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salary_bank_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salary_bank_account` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary_component_id` bigint(20) UNSIGNED NOT NULL,
  `payroll_sheet_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `calculate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_employees` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_sheets`
--

CREATE TABLE `payroll_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_sheet_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_sheet_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_day` int(11) DEFAULT NULL,
  `to_day` int(11) DEFAULT NULL,
  `end_period` enum('End Month','Next Month') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'End Month',
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_sheet_employees`
--

CREATE TABLE `payroll_sheet_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `payroll_sheet_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `period`
-- (See below for the actual view)
--
CREATE TABLE `period` (
`employee_id` bigint(20) unsigned
,`attendance_id` int(11)
,`selected_date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_position` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_position` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_status`
--

CREATE TABLE `registration_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_name_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_name_status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shown` enum('show','hidden') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'hidden',
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_contents`
--

CREATE TABLE `report_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `endorsement` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `daily_request` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `proof_enrollment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_request` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `statement_request` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `report_contents`
--

INSERT INTO `report_contents` (`id`, `endorsement`, `admin_id`, `created_at`, `updated_at`, `daily_request`, `proof_enrollment`, `parent_request`, `statement_request`) VALUES
(1, '', 1, '2020-11-02 11:24:15', '2020-11-02 11:24:15', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `request_leave_types`
-- (See below for the actual view)
--
CREATE TABLE `request_leave_types` (
`id` bigint(20) unsigned
,`ar_leave` varchar(50)
,`en_leave` varchar(50)
,`have_balance` enum('yes','no')
,`activation` enum('active','inactive')
,`target` enum('late','early')
,`deduction` enum('yes','no')
,`deduction_allocated` int(11)
,`from_day` int(11)
,`to_day` int(11)
,`period` enum('this month','next month')
,`sort` int(11)
,`admin_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`employee_id` bigint(20) unsigned
,`date_leave` date
,`time_leave` time
,`approval2` enum('Accepted','Rejected','Canceled','Pending')
);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `classroom_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_components`
--

CREATE TABLE `salary_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `en_item` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `formula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `type` enum('fixed','variable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fixed',
  `registration` enum('employee','payroll') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'payroll',
  `calculate` enum('net','earn','info','deduction') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'info',
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `school_government` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `school_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school_type` enum('private','lang','international') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'private',
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_section` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_section` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_sector` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_sector` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `ar_sector`, `en_sector`, `sort`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Eius blanditiis quae', 'Natus iure asperiore', 65, 1, '2020-11-02 11:35:44', '2020-11-02 11:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_school_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_school_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `fb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yt` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('open','close') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `msg_maintenance` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ar_education_administration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_education_administration` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ar_governorate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `en_governorate` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `ar_school_name`, `en_school_name`, `logo`, `icon`, `email`, `address`, `contact1`, `contact2`, `contact3`, `open_time`, `close_time`, `fb`, `yt`, `status`, `msg_maintenance`, `admin_id`, `created_at`, `updated_at`, `ar_education_administration`, `en_education_administration`, `ar_governorate`, `en_governorate`) VALUES
(1, 'مدرستي', 'My School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'open', NULL, 1, '2020-11-02 11:24:14', '2020-11-02 11:24:14', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `set_migration`
--

CREATE TABLE `set_migration` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_grade_id` bigint(20) UNSIGNED NOT NULL,
  `to_grade_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_skill` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `en_skill` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stages`
--

CREATE TABLE `stages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_stage_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_stage_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `signature` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stage_grades`
--

CREATE TABLE `stage_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `end_stage` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `stage_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_step` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `en_step` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `father_id` bigint(20) UNSIGNED NOT NULL,
  `mother_id` bigint(20) UNSIGNED NOT NULL,
  `student_type` enum('applicant','student') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'applicant',
  `ar_student_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `en_student_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `student_id_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `student_id_type` enum('national_id','passport') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'national_id',
  `student_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `nationality_id` bigint(20) UNSIGNED NOT NULL,
  `religion` enum('muslim','non_muslim') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'muslim',
  `native_lang_id` bigint(20) UNSIGNED NOT NULL,
  `second_lang_id` bigint(20) UNSIGNED NOT NULL,
  `term` enum('all','first','second') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all',
  `dob` date NOT NULL,
  `reg_type` enum('return','arrival','new','transfer') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `student_image` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submitted_application` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submitted_name` varchar(75) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submitted_id_number` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submitted_mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `school_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `guardian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `place_birth` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `return_country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_status_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `twins` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false',
  `siblings` enum('true','false') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_commissioners`
--

CREATE TABLE `students_commissioners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `commissioner_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students_statements`
--

CREATE TABLE `students_statements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dd` int(11) NOT NULL,
  `mm` int(11) NOT NULL,
  `yy` int(11) NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `grade_id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `year_id` bigint(20) UNSIGNED NOT NULL,
  `registration_status_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_address`
--

CREATE TABLE `student_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `full_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_doc_delivers`
--

CREATE TABLE `student_doc_delivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admission_document_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_steps`
--

CREATE TABLE `student_steps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admission_step_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_components`
--

CREATE TABLE `temporary_components` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary_component_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `assessment_id` bigint(20) UNSIGNED NOT NULL,
  `acceptance_test_id` bigint(20) UNSIGNED NOT NULL,
  `test_result` enum('excellent','very good','good','weak') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'very good',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ar_timetable` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `en_timetable` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `on_duty_time` time NOT NULL,
  `off_duty_time` time NOT NULL,
  `beginning_in` time NOT NULL,
  `ending_in` time NOT NULL,
  `beginning_out` time NOT NULL,
  `ending_out` time NOT NULL,
  `saturday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `sunday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `monday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `tuesday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `wednesday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `thursday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `friday` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'Enable',
  `saturday_value` int(11) DEFAULT 1,
  `sunday_value` int(11) DEFAULT 1,
  `monday_value` int(11) DEFAULT 1,
  `tuesday_value` int(11) DEFAULT 1,
  `wednesday_value` int(11) DEFAULT 1,
  `thursday_value` int(11) DEFAULT 1,
  `friday_value` int(11) DEFAULT 1,
  `daily_late_minutes` int(11) DEFAULT NULL,
  `day_absent_value` double(4,1) DEFAULT NULL,
  `no_attend` int(11) DEFAULT NULL,
  `no_leave` double(4,1) DEFAULT NULL,
  `check_in_before_leave` double(4,1) DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `ar_timetable`, `en_timetable`, `description`, `on_duty_time`, `off_duty_time`, `beginning_in`, `ending_in`, `beginning_out`, `ending_out`, `saturday`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday_value`, `sunday_value`, `monday_value`, `tuesday_value`, `wednesday_value`, `thursday_value`, `friday_value`, `daily_late_minutes`, `day_absent_value`, `no_attend`, `no_leave`, `check_in_before_leave`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Repudiandae reprehen', 'Qui laboris voluptat', 'Mollit quis esse iu', '02:37:00', '00:10:00', '02:33:00', '19:43:00', '17:15:00', '18:43:00', '', 'Enable', 'Enable', 'Enable', 'Enable', 'Enable', 'Enable', 16, 13, 17, 5, 19, 7, 12, 47, 25.0, 59, 51.0, 8.0, 1, '2020-11-02 11:35:52', '2020-11-02 11:35:52');

-- --------------------------------------------------------

--
-- Stand-in structure for view `total_payroll_view`
-- (See below for the actual view)
--
CREATE TABLE `total_payroll_view` (
`code` varchar(255)
,`payroll_sheet_id` bigint(20) unsigned
,`period` varchar(255)
,`from_date` date
,`to_date` date
,`ar_sheet_name` varchar(255)
,`en_sheet_name` varchar(255)
,`total_employees` int(11)
,`total_Payroll` double(19,2)
,`username` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leaved_date` date NOT NULL,
  `leave_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school_fees` enum('payed','not_payed') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'payed',
  `school_books` enum('received','not_received') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'received',
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `current_grade_id` bigint(20) UNSIGNED NOT NULL,
  `next_grade_id` bigint(20) UNSIGNED NOT NULL,
  `current_year_id` bigint(20) UNSIGNED NOT NULL,
  `next_year_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preferredLanguage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `status` enum('enable','disable') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enable',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

CREATE TABLE `vacations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_vacation` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `count` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approval1` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `approval2` enum('Accepted','Rejected','Canceled','Pending') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
  `vacation_type` enum('Start work','End work','Sick leave','Regular vacation','Vacation without pay','Work errand','Training','Casual vacation') COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `substitute_employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_one_user` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_two_user` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vacation_periods`
--

CREATE TABLE `vacation_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_vacation` date NOT NULL,
  `vacation_type` enum('Start work','End work','Sick leave','Regular vacation','Vacation without pay','Work errand','Training','Casual vacation') COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `vacation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vacation_period_view`
-- (See below for the actual view)
--
CREATE TABLE `vacation_period_view` (
`id` bigint(20) unsigned
,`date_vacation` date
,`vacation_type` enum('Start work','End work','Sick leave','Regular vacation','Vacation without pay','Work errand','Training','Casual vacation')
,`employee_id` bigint(20) unsigned
,`vacation_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`approval2` enum('Accepted','Rejected','Canceled','Pending')
);

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `start_from` date NOT NULL,
  `end_from` date NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('current','not current') COLLATE utf8_unicode_ci NOT NULL,
  `year_status` enum('open','close') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `attendance_sheet`
--
DROP TABLE IF EXISTS `attendance_sheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `attendance_sheet`  AS  select `attendance_view`.`attendance_id` AS `attendance_id`,if(`attendance_view`.`clock_in` is not null,cast(`attendance_view`.`clock_in` as date),cast(`attendance_view`.`clock_out` as date)) AS `Date`,if(`attendance_view`.`clock_in` is not null,cast(`attendance_view`.`clock_in` as time),'') AS `clock_in`,if(`attendance_view`.`clock_out` is not null,cast(`attendance_view`.`clock_out` as time),'') AS `clock_out`,if(`attendance_view`.`clock_in` is not null and `attendance_view`.`clock_out` is not null,timediff(cast(`attendance_view`.`clock_out` as time),cast(`attendance_view`.`clock_in` as time)),'') AS `work_time`,if(timediff(cast(`attendance_view`.`clock_in` as time),`timetables`.`on_duty_time`) > 0,timediff(cast(`attendance_view`.`clock_in` as time),`timetables`.`on_duty_time`),'') AS `lates`,if(`attendance_view`.`clock_in` is not null and timediff(cast(`attendance_view`.`clock_in` as time),`timetables`.`on_duty_time`) > 0,cast(time_to_sec(timediff(cast(`attendance_view`.`clock_in` as time),`timetables`.`on_duty_time`)) / 60 as signed),0) AS `minutes`,if(timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time)) > 0,timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time)),'') AS `leave_early`,if(`attendance_view`.`clock_out` is not null and timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time)) > 0,cast(time_to_sec(timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time))) / 60 as signed),0) AS `leave_minutes`,if(cast(`attendance_view`.`clock_in` as time) is null,1,0) AS `no_attend`,if(cast(`attendance_view`.`clock_out` as time) is null,1,0) AS `no_leave`,if(timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time)) > 0 or `attendance_view`.`clock_out` is null,'',timediff(`timetables`.`off_duty_time`,cast(`attendance_view`.`clock_out` as time))) AS `time_overtime`,if(`attendance_view`.`clock_out` is not null,cast(time_to_sec(timediff(cast(`attendance_view`.`clock_out` as time),`timetables`.`off_duty_time`)) / 60 as signed),0) AS `overtime` from (`timetables` join `attendance_view` on(`attendance_view`.`timetable_id` = `timetables`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `attendance_sheet_dates`
--
DROP TABLE IF EXISTS `attendance_sheet_dates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `attendance_sheet_dates`  AS  select `period`.`attendance_id` AS `attendance_id`,`period`.`selected_date` AS `selected_date`,`attendance_sheet`.`clock_in` AS `clock_in`,`attendance_sheet`.`clock_out` AS `clock_out`,`attendance_sheet`.`work_time` AS `work_time`,`attendance_sheet`.`lates` AS `lates`,`attendance_sheet`.`minutes` AS `minutes`,`attendance_sheet`.`leave_early` AS `leave_early`,`attendance_sheet`.`leave_minutes` AS `leave_minutes`,`attendance_sheet`.`no_attend` AS `no_attend`,`attendance_sheet`.`no_leave` AS `no_leave`,`attendance_sheet`.`overtime` AS `overtime` from (`attendance_sheet` left join `period` on(`period`.`selected_date` = `attendance_sheet`.`Date` and `period`.`attendance_id` = `attendance_sheet`.`attendance_id`)) union select `period`.`attendance_id` AS `attendance_id`,`period`.`selected_date` AS `selected_date`,`attendance_sheet`.`clock_in` AS `clock_in`,`attendance_sheet`.`clock_out` AS `clock_out`,`attendance_sheet`.`work_time` AS `work_time`,`attendance_sheet`.`lates` AS `lates`,`attendance_sheet`.`minutes` AS `minutes`,`attendance_sheet`.`leave_early` AS `leave_early`,`attendance_sheet`.`leave_minutes` AS `leave_minutes`,`attendance_sheet`.`no_attend` AS `no_attend`,`attendance_sheet`.`no_leave` AS `no_leave`,`attendance_sheet`.`overtime` AS `overtime` from (`period` left join `attendance_sheet` on(`period`.`selected_date` = `attendance_sheet`.`Date` and `period`.`attendance_id` = `attendance_sheet`.`attendance_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `attendance_view`
--
DROP TABLE IF EXISTS `attendance_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `attendance_view`  AS  select `attendances`.`attendance_id` AS `attendance_id`,`employees`.`id` AS `employee_id`,`employees`.`timetable_id` AS `timetable_id`,min(case when `attendances`.`status_attendance` = 'In' then `attendances`.`time_attendance` end) AS `clock_in`,max(case when `attendances`.`status_attendance` = 'Out' then `attendances`.`time_attendance` end) AS `clock_out` from (`attendances` join `employees` on(`attendances`.`attendance_id` = `employees`.`attendance_id`)) where `employees`.`deleted_at` is null group by cast(`attendances`.`time_attendance` as date),`attendances`.`attendance_id`,`employees`.`id`,`employees`.`timetable_id` ;

-- --------------------------------------------------------

--
-- Structure for view `employee_holiday_dates`
--
DROP TABLE IF EXISTS `employee_holiday_dates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee_holiday_dates`  AS  select `employees`.`attendance_id` AS `attendance_id`,`holiday_days`.`date_holiday` AS `date_holiday` from ((`holiday_days` join `employee_holidays` on(`holiday_days`.`holiday_id` = `employee_holidays`.`holiday_id`)) join `employees` on(`employee_holidays`.`employee_id` = `employees`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `finalSheet`
--
DROP TABLE IF EXISTS `finalSheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `finalSheet`  AS  select `final_attendance_sheet`.`en_st_name` AS `en_st_name`,`final_attendance_sheet`.`en_nd_name` AS `en_nd_name`,`final_attendance_sheet`.`employee_id` AS `employee_id`,`final_attendance_sheet`.`ar_timetable` AS `ar_timetable`,`final_attendance_sheet`.`en_timetable` AS `en_timetable`,`final_attendance_sheet`.`on_duty_time` AS `on_duty_time`,`final_attendance_sheet`.`off_duty_time` AS `off_duty_time`,`final_attendance_sheet`.`beginning_in` AS `beginning_in`,`final_attendance_sheet`.`ending_in` AS `ending_in`,`final_attendance_sheet`.`beginning_out` AS `beginning_out`,`final_attendance_sheet`.`ending_out` AS `ending_out`,`final_attendance_sheet`.`saturday` AS `saturday`,`final_attendance_sheet`.`sunday` AS `sunday`,`final_attendance_sheet`.`monday` AS `monday`,`final_attendance_sheet`.`tuesday` AS `tuesday`,`final_attendance_sheet`.`wednesday` AS `wednesday`,`final_attendance_sheet`.`thursday` AS `thursday`,`final_attendance_sheet`.`friday` AS `friday`,`final_attendance_sheet`.`saturday_value` AS `saturday_value`,`final_attendance_sheet`.`sunday_value` AS `sunday_value`,`final_attendance_sheet`.`monday_value` AS `monday_value`,`final_attendance_sheet`.`wednesday_value` AS `wednesday_value`,`final_attendance_sheet`.`tuesday_value` AS `tuesday_value`,`final_attendance_sheet`.`thursday_value` AS `thursday_value`,`final_attendance_sheet`.`friday_value` AS `friday_value`,`final_attendance_sheet`.`daily_late_minutes` AS `daily_late_minutes`,`final_attendance_sheet`.`leave_min` AS `leave_min`,`final_attendance_sheet`.`day_absent_value` AS `day_absent_value`,`final_attendance_sheet`.`noAttend` AS `noAttend`,`final_attendance_sheet`.`noLeave` AS `noLeave`,`final_attendance_sheet`.`attendance_id` AS `attendance_id`,`final_attendance_sheet`.`selected_date` AS `selected_date`,`final_attendance_sheet`.`clock_in` AS `clock_in`,`final_attendance_sheet`.`clock_out` AS `clock_out`,`final_attendance_sheet`.`work_time` AS `work_time`,`final_attendance_sheet`.`lates` AS `lates`,`final_attendance_sheet`.`minutes` AS `minutes`,`final_attendance_sheet`.`leave_early` AS `leave_early`,`final_attendance_sheet`.`leave_minutes` AS `leave_minutes`,`final_attendance_sheet`.`no_attend` AS `no_attend`,`final_attendance_sheet`.`no_leave` AS `no_leave`,`final_attendance_sheet`.`overtime` AS `overtime`,`final_attendance_sheet`.`absent` AS `absent`,`employee_holiday_dates`.`date_holiday` AS `date_holiday`,`leave_requests_view`.`date_leave` AS `date_leave`,`leave_requests_view`.`time_leave` AS `time_leave`,if(`final_attendance_sheet`.`absent` = 'True' and `employee_holiday_dates`.`date_holiday` is not null or `final_attendance_sheet`.`absent` = '' and `employee_holiday_dates`.`date_holiday` is null,'','True') AS `absent_after_holidays` from ((`final_attendance_sheet` left join `employee_holiday_dates` on(`final_attendance_sheet`.`attendance_id` = `employee_holiday_dates`.`attendance_id` and `final_attendance_sheet`.`selected_date` = `employee_holiday_dates`.`date_holiday`)) left join `leave_requests_view` on(`final_attendance_sheet`.`attendance_id` = `leave_requests_view`.`attendance_id` and `final_attendance_sheet`.`employee_id` = `leave_requests_view`.`employee_id` and `final_attendance_sheet`.`selected_date` = `leave_requests_view`.`date_leave`)) ;

-- --------------------------------------------------------

--
-- Structure for view `final_attendance_sheet`
--
DROP TABLE IF EXISTS `final_attendance_sheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `final_attendance_sheet`  AS  select `employees`.`en_st_name` AS `en_st_name`,`employees`.`en_nd_name` AS `en_nd_name`,`employees`.`id` AS `employee_id`,(select `timetables`.`ar_timetable` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `ar_timetable`,(select `timetables`.`en_timetable` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `en_timetable`,(select `timetables`.`on_duty_time` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `on_duty_time`,(select `timetables`.`off_duty_time` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `off_duty_time`,(select `timetables`.`beginning_in` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `beginning_in`,(select `timetables`.`ending_in` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `ending_in`,(select `timetables`.`beginning_out` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `beginning_out`,(select `timetables`.`ending_out` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `ending_out`,(select `timetables`.`saturday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `saturday`,(select `timetables`.`sunday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `sunday`,(select `timetables`.`monday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `monday`,(select `timetables`.`tuesday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `tuesday`,(select `timetables`.`wednesday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `wednesday`,(select `timetables`.`thursday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `thursday`,(select `timetables`.`friday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `friday`,(select `timetables`.`saturday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `saturday_value`,(select `timetables`.`sunday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `sunday_value`,(select `timetables`.`monday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `monday_value`,(select `timetables`.`tuesday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `wednesday_value`,(select `timetables`.`wednesday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `tuesday_value`,(select `timetables`.`thursday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `thursday_value`,(select `timetables`.`friday_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `friday_value`,(select `timetables`.`daily_late_minutes` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `daily_late_minutes`,(select `attendance_sheet_dates`.`leave_minutes` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `leave_min`,(select `timetables`.`day_absent_value` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `day_absent_value`,(select `timetables`.`no_attend` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `noAttend`,(select `timetables`.`no_leave` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) AS `noLeave`,`attendance_sheet_dates`.`attendance_id` AS `attendance_id`,`attendance_sheet_dates`.`selected_date` AS `selected_date`,`attendance_sheet_dates`.`clock_in` AS `clock_in`,`attendance_sheet_dates`.`clock_out` AS `clock_out`,`attendance_sheet_dates`.`work_time` AS `work_time`,`attendance_sheet_dates`.`lates` AS `lates`,`attendance_sheet_dates`.`minutes` AS `minutes`,`attendance_sheet_dates`.`leave_early` AS `leave_early`,`attendance_sheet_dates`.`leave_minutes` AS `leave_minutes`,`attendance_sheet_dates`.`no_attend` AS `no_attend`,`attendance_sheet_dates`.`no_leave` AS `no_leave`,`attendance_sheet_dates`.`overtime` AS `overtime`,if(`attendance_sheet_dates`.`clock_in` is null and `attendance_sheet_dates`.`clock_out` is null and (dayname(`attendance_sheet_dates`.`selected_date`) = 'Saturday' and (select `timetables`.`saturday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Sunday' and (select `timetables`.`sunday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Monday' and (select `timetables`.`monday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Tuesday' and (select `timetables`.`tuesday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Wednesday' and (select `timetables`.`wednesday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Thursday' and (select `timetables`.`thursday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable' or dayname(`attendance_sheet_dates`.`selected_date`) = 'Friday' and (select `timetables`.`friday` from `timetables` where `timetables`.`id` = `employees`.`timetable_id`) = 'Enable'),'True','') AS `absent` from (`attendance_sheet_dates` join `employees` on(`attendance_sheet_dates`.`attendance_id` = `employees`.`attendance_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_employee_data`
--
DROP TABLE IF EXISTS `full_employee_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `full_employee_data`  AS  select `employees`.`id` AS `id`,`employees`.`attendance_id` AS `attendance_id`,`employees`.`ar_st_name` AS `ar_st_name`,`employees`.`ar_nd_name` AS `ar_nd_name`,`employees`.`ar_rd_name` AS `ar_rd_name`,`employees`.`ar_th_name` AS `ar_th_name`,`employees`.`en_st_name` AS `en_st_name`,`employees`.`en_nd_name` AS `en_nd_name`,`employees`.`en_rd_name` AS `en_rd_name`,`employees`.`en_th_name` AS `en_th_name`,`employees`.`email` AS `email`,`employees`.`mobile1` AS `mobile1`,`employees`.`mobile2` AS `mobile2`,`employees`.`dob` AS `dob`,`employees`.`gender` AS `gender`,`employees`.`address` AS `address`,`employees`.`religion` AS `religion`,`employees`.`native` AS `native`,`employees`.`marital_status` AS `marital_status`,`employees`.`health_details` AS `health_details`,`employees`.`national_id` AS `national_id`,`employees`.`military_service` AS `military_service`,`employees`.`hiring_date` AS `hiring_date`,`employees`.`job_description` AS `job_description`,`employees`.`has_contract` AS `has_contract`,`employees`.`contract_type` AS `contract_type`,`employees`.`contract_date` AS `contract_date`,`employees`.`contract_end_date` AS `contract_end_date`,`employees`.`previous_experience` AS `previous_experience`,`employees`.`institution` AS `institution`,`employees`.`qualification` AS `qualification`,`employees`.`social_insurance` AS `social_insurance`,`employees`.`social_insurance_num` AS `social_insurance_num`,`employees`.`social_insurance_date` AS `social_insurance_date`,`employees`.`medical_insurance` AS `medical_insurance`,`employees`.`medical_insurance_num` AS `medical_insurance_num`,`employees`.`medical_insurance_date` AS `medical_insurance_date`,`employees`.`exit_interview_feedback` AS `exit_interview_feedback`,`employees`.`leave_date` AS `leave_date`,`employees`.`leave_reason` AS `leave_reason`,`employees`.`leaved` AS `leaved`,`employees`.`salary` AS `salary`,`employees`.`salary_suspend` AS `salary_suspend`,`employees`.`salary_mode` AS `salary_mode`,`employees`.`salary_bank_name` AS `salary_bank_name`,`employees`.`bank_account` AS `bank_account`,`employees`.`leave_balance` AS `leave_balance`,`employees`.`bus_value` AS `bus_value`,`employees`.`vacation_allocated` AS `vacation_allocated`,`employees`.`sector_id` AS `sector_id`,`employees`.`department_id` AS `department_id`,`employees`.`section_id` AS `section_id`,`employees`.`position_id` AS `position_id`,`employees`.`timetable_id` AS `timetable_id`,`employees`.`user_id` AS `user_id`,`employees`.`admin_id` AS `admin_id`,`employees`.`direct_manager_id` AS `direct_manager_id`,`employees`.`deleted_at` AS `deleted_at`,`employees`.`created_at` AS `created_at`,`employees`.`updated_at` AS `updated_at`,`employees`.`employee_image` AS `employee_image`,`departments`.`en_department` AS `en_department`,`departments`.`ar_department` AS `ar_department`,`sectors`.`en_sector` AS `en_sector`,`sectors`.`ar_sector` AS `ar_sector`,`sections`.`en_section` AS `en_section`,`sections`.`ar_section` AS `ar_section`,`positions`.`en_position` AS `en_position`,`positions`.`ar_position` AS `ar_position`,`timetables`.`en_timetable` AS `en_timetable`,`timetables`.`ar_timetable` AS `ar_timetable` from (((((`employees` left join `departments` on(`employees`.`department_id` = `departments`.`id`)) left join `sectors` on(`employees`.`sector_id` = `sectors`.`id`)) left join `sections` on(`employees`.`section_id` = `sections`.`id`)) left join `positions` on(`employees`.`position_id` = `positions`.`id`)) left join `timetables` on(`employees`.`timetable_id` = `timetables`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `full_student_data`
--
DROP TABLE IF EXISTS `full_student_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `full_student_data`  AS  select `students`.`id` AS `student_id`,`students`.`student_type` AS `student_type`,`students`.`ar_student_name` AS `ar_student_name`,`students`.`en_student_name` AS `en_student_name`,`students`.`student_id_number` AS `student_id_number`,`students`.`student_id_type` AS `student_id_type`,`students`.`student_number` AS `student_number`,`students`.`gender` AS `gender`,`students`.`nationality_id` AS `nationality_id`,`students`.`religion` AS `religion`,`students`.`native_lang_id` AS `native_lang_id`,`students`.`second_lang_id` AS `second_lang_id`,`students`.`term` AS `term`,`students`.`dob` AS `dob`,`students`.`code` AS `code`,`students`.`reg_type` AS `reg_type`,`students`.`grade_id` AS `grade_id`,`students`.`division_id` AS `division_id`,`students`.`student_image` AS `student_image`,`students`.`submitted_application` AS `submitted_application`,`students`.`submitted_name` AS `submitted_name`,`students`.`submitted_id_number` AS `submitted_id_number`,`students`.`submitted_mobile` AS `submitted_mobile`,`students`.`school_id` AS `school_id`,`students`.`transfer_reason` AS `transfer_reason`,`students`.`application_date` AS `application_date`,`students`.`guardian_id` AS `guardian_id`,`students`.`place_birth` AS `place_birth`,`students`.`return_country` AS `return_country`,`students`.`registration_status_id` AS `registration_status_id`,`fathers`.`id` AS `father_id`,`fathers`.`ar_st_name` AS `ar_st_name`,`fathers`.`ar_nd_name` AS `ar_nd_name`,`fathers`.`ar_rd_name` AS `ar_rd_name`,`fathers`.`ar_th_name` AS `ar_th_name`,`fathers`.`en_st_name` AS `en_st_name`,`fathers`.`en_nd_name` AS `en_nd_name`,`fathers`.`en_rd_name` AS `en_rd_name`,`fathers`.`en_th_name` AS `en_th_name`,`fathers`.`id_number` AS `id_number`,`fathers`.`home_phone` AS `home_phone`,`fathers`.`mobile1` AS `mobile1`,`fathers`.`mobile2` AS `mobile2`,`fathers`.`job` AS `job`,`fathers`.`email` AS `email`,`fathers`.`qualification` AS `qualification`,`fathers`.`facebook` AS `facebook`,`fathers`.`whatsapp_number` AS `whatsapp_number`,`fathers`.`educational_mandate` AS `educational_mandate`,`fathers`.`block_no` AS `block_no`,`fathers`.`street_name` AS `street_name`,`fathers`.`state` AS `state`,`fathers`.`government` AS `government`,`fathers`.`marital_status` AS `marital_status`,`fathers`.`recognition` AS `recognition`,concat_ws(' ',`fathers`.`ar_st_name`,`fathers`.`ar_nd_name`,`fathers`.`ar_rd_name`,`fathers`.`ar_th_name`) AS `ar_father_name`,concat_ws(' ',`fathers`.`en_st_name`,`fathers`.`en_nd_name`,`fathers`.`en_rd_name`,`fathers`.`en_th_name`) AS `en_father_name`,`mothers`.`full_name` AS `full_name`,`mothers`.`id_number_m` AS `id_number_m`,`mothers`.`mobile1_m` AS `mobile1_m`,`mothers`.`mobile2_m` AS `mobile2_m`,`mothers`.`job_m` AS `job_m`,`mothers`.`email_m` AS `email_m`,`mothers`.`qualification_m` AS `qualification_m`,`mothers`.`facebook_m` AS `facebook_m`,`mothers`.`whatsapp_number_m` AS `whatsapp_number_m`,`mothers`.`block_no_m` AS `block_no_m`,`mothers`.`street_name_m` AS `street_name_m`,`mothers`.`state_m` AS `state_m`,`nationalities`.`ar_name_nat_female` AS `ar_name_nat_female`,`nationalities`.`ar_name_nat_male` AS `ar_name_nat_male`,`nationalities`.`en_name_nationality` AS `en_name_nationality`,`grades`.`ar_grade_name` AS `ar_grade_name`,`grades`.`en_grade_name` AS `en_grade_name`,`divisions`.`ar_division_name` AS `ar_division_name`,`divisions`.`en_division_name` AS `en_division_name`,`schools`.`school_name` AS `school_name`,`guardians`.`guardian_full_name` AS `guardian_full_name`,`registration_status`.`ar_name_status` AS `ar_name_status`,`registration_status`.`en_name_status` AS `en_name_status`,`lang`.`ar_name_lang` AS `ar_name_lang`,`lang`.`en_name_lang` AS `en_name_lang` from ((((((((((`students` join `fathers` on(`students`.`father_id` = `fathers`.`id`)) join `mothers` on(`students`.`mother_id` = `mothers`.`id`)) join `nationalities` on(`students`.`nationality_id` = `nationalities`.`id`)) join `languages` on(`students`.`native_lang_id` = `languages`.`id`)) join `languages` `lang` on(`students`.`second_lang_id` = `lang`.`id`)) join `grades` on(`students`.`grade_id` = `grades`.`id`)) join `divisions` on(`students`.`division_id` = `divisions`.`id`)) left join `schools` on(`students`.`school_id` = `schools`.`id`)) left join `guardians` on(`students`.`guardian_id` = `guardians`.`id`)) join `registration_status` on(`students`.`registration_status_id` = `registration_status`.`id`)) where `students`.`ar_student_name` <> '' ;

-- --------------------------------------------------------

--
-- Structure for view `last_main_view`
--
DROP TABLE IF EXISTS `last_main_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `last_main_view`  AS  select `main_attendance_sheet`.`en_st_name` AS `en_st_name`,`main_attendance_sheet`.`en_nd_name` AS `en_nd_name`,`main_attendance_sheet`.`employee_id` AS `employee_id`,`main_attendance_sheet`.`ar_timetable` AS `ar_timetable`,`main_attendance_sheet`.`en_timetable` AS `en_timetable`,`main_attendance_sheet`.`on_duty_time` AS `on_duty_time`,`main_attendance_sheet`.`off_duty_time` AS `off_duty_time`,`main_attendance_sheet`.`beginning_in` AS `beginning_in`,`main_attendance_sheet`.`ending_in` AS `ending_in`,`main_attendance_sheet`.`beginning_out` AS `beginning_out`,`main_attendance_sheet`.`ending_out` AS `ending_out`,`main_attendance_sheet`.`saturday` AS `saturday`,`main_attendance_sheet`.`sunday` AS `sunday`,`main_attendance_sheet`.`monday` AS `monday`,`main_attendance_sheet`.`tuesday` AS `tuesday`,`main_attendance_sheet`.`wednesday` AS `wednesday`,`main_attendance_sheet`.`thursday` AS `thursday`,`main_attendance_sheet`.`friday` AS `friday`,`main_attendance_sheet`.`saturday_value` AS `saturday_value`,`main_attendance_sheet`.`sunday_value` AS `sunday_value`,`main_attendance_sheet`.`monday_value` AS `monday_value`,`main_attendance_sheet`.`wednesday_value` AS `wednesday_value`,`main_attendance_sheet`.`tuesday_value` AS `tuesday_value`,`main_attendance_sheet`.`thursday_value` AS `thursday_value`,`main_attendance_sheet`.`friday_value` AS `friday_value`,`main_attendance_sheet`.`daily_late_minutes` AS `daily_late_minutes`,`main_attendance_sheet`.`leave_min` AS `leave_min`,`main_attendance_sheet`.`day_absent_value` AS `day_absent_value`,`main_attendance_sheet`.`noAttend` AS `noAttend`,`main_attendance_sheet`.`noLeave` AS `noLeave`,`main_attendance_sheet`.`attendance_id` AS `attendance_id`,`main_attendance_sheet`.`selected_date` AS `selected_date`,`main_attendance_sheet`.`clock_in` AS `clock_in`,`main_attendance_sheet`.`clock_out` AS `clock_out`,`main_attendance_sheet`.`work_time` AS `work_time`,`main_attendance_sheet`.`lates` AS `lates`,`main_attendance_sheet`.`minutes` AS `minutes`,`main_attendance_sheet`.`leave_early` AS `leave_early`,`main_attendance_sheet`.`leave_minutes` AS `leave_minutes`,`main_attendance_sheet`.`no_attend` AS `no_attend`,`main_attendance_sheet`.`no_leave` AS `no_leave`,`main_attendance_sheet`.`overtime` AS `overtime`,`main_attendance_sheet`.`absent` AS `absent`,`main_attendance_sheet`.`week` AS `week`,`main_attendance_sheet`.`date_holiday` AS `date_holiday`,`main_attendance_sheet`.`vacation_type` AS `vacation_type`,`main_attendance_sheet`.`absent_after_holidays` AS `absent_after_holidays`,`main_attendance_sheet`.`date_leave` AS `date_leave`,`main_attendance_sheet`.`time_leave` AS `time_leave`,`main_attendance_sheet`.`minutes_lates_after_request` AS `minutes_lates_after_request`,`main_attendance_sheet`.`leave_early_after_request` AS `leave_early_after_request`,case when (`main_attendance_sheet`.`minutes_lates_after_request` >= `main_attendance_sheet`.`daily_late_minutes` and `main_attendance_sheet`.`absent_after_holidays` = '') then `main_attendance_sheet`.`day_absent_value` when (`main_attendance_sheet`.`no_attend` = 0 and `main_attendance_sheet`.`no_leave` = 1) then `main_attendance_sheet`.`noLeave` when (`main_attendance_sheet`.`week` = 'Saturday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`saturday_value` when (`main_attendance_sheet`.`week` = 'Saturday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Sunday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`sunday_value` when (`main_attendance_sheet`.`week` = 'Sunday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Monday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`monday_value` when (`main_attendance_sheet`.`week` = 'Monday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Tuesday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`tuesday_value` when (`main_attendance_sheet`.`week` = 'Tuesday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Wednesday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`wednesday_value` when (`main_attendance_sheet`.`week` = 'Wednesday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Thursday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`thursday_value` when (`main_attendance_sheet`.`week` = 'Thursday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 when (`main_attendance_sheet`.`week` = 'Friday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and `main_attendance_sheet`.`vacation_type` = '') then `main_attendance_sheet`.`friday_value` when (`main_attendance_sheet`.`week` = 'Friday' and `main_attendance_sheet`.`absent_after_holidays` = 'True' and (`main_attendance_sheet`.`vacation_type` = 'Vacation without pay' or `main_attendance_sheet`.`vacation_type` = 'Sick leave' or `main_attendance_sheet`.`vacation_type` = 'Start work')) then 1 else 0 end AS `absentValue`,case when addtime(`main_attendance_sheet`.`time_leave`,'2:00:00') < (select date_format(`attendances`.`time_attendance`,'%H:%i:%s') from `attendances` where date_format(`attendances`.`time_attendance`,'%Y-%m-%d') = `main_attendance_sheet`.`date_leave` and date_format(`attendances`.`time_attendance`,'%H:%i:%s') > addtime(`main_attendance_sheet`.`time_leave`,'2:00:00') and date_format(`attendances`.`time_attendance`,'%H:%i:%s') < `main_attendance_sheet`.`off_duty_time` limit 1) then cast(time_to_sec(timediff((select date_format(`attendances`.`time_attendance`,'%H:%i:%s') from (`attendances` join `main_attendance_sheet` on(`attendances`.`attendance_id` = `main_attendance_sheet`.`attendance_id`)) where date_format(`attendances`.`time_attendance`,'%Y-%m-%d') = `main_attendance_sheet`.`date_leave` and date_format(`attendances`.`time_attendance`,'%H:%i:%s') > addtime(`main_attendance_sheet`.`time_leave`,'2:00:00') and date_format(`attendances`.`time_attendance`,'%H:%i:%s') < `main_attendance_sheet`.`off_duty_time` limit 1),addtime(`main_attendance_sheet`.`time_leave`,'2:00:00'))) / 60 as unsigned) when (`main_attendance_sheet`.`minutes_lates_after_request` >= `main_attendance_sheet`.`daily_late_minutes` and `main_attendance_sheet`.`absent_after_holidays` = '') then 0 when (`main_attendance_sheet`.`clock_in` = '' and `main_attendance_sheet`.`clock_out` <> '') then `main_attendance_sheet`.`noAttend` when (`main_attendance_sheet`.`no_attend` = 1 and `main_attendance_sheet`.`no_leave` = 0) then `main_attendance_sheet`.`noAttend` else `main_attendance_sheet`.`minutes_lates_after_request` end AS `main_lates`,case when (`main_attendance_sheet`.`clock_in` <> '' and `main_attendance_sheet`.`clock_out` = '') then 0 else if(`main_attendance_sheet`.`leave_early_after_request` = 0,0,`main_attendance_sheet`.`leave_early_after_request`) end AS `leave_mins` from `main_attendance_sheet` ;

-- --------------------------------------------------------

--
-- Structure for view `leave_requests_view`
--
DROP TABLE IF EXISTS `leave_requests_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `leave_requests_view`  AS  select `leave_permissions`.`id` AS `id`,`leave_permissions`.`date_leave` AS `date_leave`,`leave_permissions`.`time_leave` AS `time_leave`,`leave_permissions`.`approval_one_user` AS `approval_one_user`,`leave_permissions`.`approval_two_user` AS `approval_two_user`,`leave_permissions`.`approval1` AS `approval1`,`leave_permissions`.`approval2` AS `approval2`,`leave_permissions`.`leave_type_id` AS `leave_type_id`,`leave_permissions`.`employee_id` AS `employee_id`,`leave_permissions`.`admin_id` AS `admin_id`,`leave_permissions`.`created_at` AS `created_at`,`leave_permissions`.`updated_at` AS `updated_at`,`employees`.`attendance_id` AS `attendance_id` from (`leave_permissions` join `employees` on(`leave_permissions`.`employee_id` = `employees`.`id`)) where `leave_permissions`.`approval1` = 'Accepted' and `leave_permissions`.`approval2` = 'Accepted' ;

-- --------------------------------------------------------

--
-- Structure for view `main_attendance_sheet`
--
DROP TABLE IF EXISTS `main_attendance_sheet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `main_attendance_sheet`  AS  select `final_attendance_sheet`.`en_st_name` AS `en_st_name`,`final_attendance_sheet`.`en_nd_name` AS `en_nd_name`,`final_attendance_sheet`.`employee_id` AS `employee_id`,`final_attendance_sheet`.`ar_timetable` AS `ar_timetable`,`final_attendance_sheet`.`en_timetable` AS `en_timetable`,`final_attendance_sheet`.`on_duty_time` AS `on_duty_time`,`final_attendance_sheet`.`off_duty_time` AS `off_duty_time`,`final_attendance_sheet`.`beginning_in` AS `beginning_in`,`final_attendance_sheet`.`ending_in` AS `ending_in`,`final_attendance_sheet`.`beginning_out` AS `beginning_out`,`final_attendance_sheet`.`ending_out` AS `ending_out`,`final_attendance_sheet`.`saturday` AS `saturday`,`final_attendance_sheet`.`sunday` AS `sunday`,`final_attendance_sheet`.`monday` AS `monday`,`final_attendance_sheet`.`tuesday` AS `tuesday`,`final_attendance_sheet`.`wednesday` AS `wednesday`,`final_attendance_sheet`.`thursday` AS `thursday`,`final_attendance_sheet`.`friday` AS `friday`,`final_attendance_sheet`.`saturday_value` AS `saturday_value`,`final_attendance_sheet`.`sunday_value` AS `sunday_value`,`final_attendance_sheet`.`monday_value` AS `monday_value`,`final_attendance_sheet`.`wednesday_value` AS `wednesday_value`,`final_attendance_sheet`.`tuesday_value` AS `tuesday_value`,`final_attendance_sheet`.`thursday_value` AS `thursday_value`,`final_attendance_sheet`.`friday_value` AS `friday_value`,`final_attendance_sheet`.`daily_late_minutes` AS `daily_late_minutes`,`final_attendance_sheet`.`leave_min` AS `leave_min`,`final_attendance_sheet`.`day_absent_value` AS `day_absent_value`,`final_attendance_sheet`.`noAttend` AS `noAttend`,`final_attendance_sheet`.`noLeave` AS `noLeave`,`final_attendance_sheet`.`attendance_id` AS `attendance_id`,`final_attendance_sheet`.`selected_date` AS `selected_date`,`final_attendance_sheet`.`clock_in` AS `clock_in`,`final_attendance_sheet`.`clock_out` AS `clock_out`,`final_attendance_sheet`.`work_time` AS `work_time`,`final_attendance_sheet`.`lates` AS `lates`,`final_attendance_sheet`.`minutes` AS `minutes`,`final_attendance_sheet`.`leave_early` AS `leave_early`,`final_attendance_sheet`.`leave_minutes` AS `leave_minutes`,`final_attendance_sheet`.`no_attend` AS `no_attend`,`final_attendance_sheet`.`no_leave` AS `no_leave`,`final_attendance_sheet`.`overtime` AS `overtime`,`final_attendance_sheet`.`absent` AS `absent`,dayname(`final_attendance_sheet`.`selected_date`) AS `week`,`employee_holiday_dates`.`date_holiday` AS `date_holiday`,if(`vacation_period_view`.`approval2` = 'Accepted',`vacation_period_view`.`vacation_type`,'') AS `vacation_type`,if(`final_attendance_sheet`.`absent` = 'True' and `employee_holiday_dates`.`date_holiday` is not null or `final_attendance_sheet`.`absent` = '' and `employee_holiday_dates`.`date_holiday` is null or dayname(`final_attendance_sheet`.`selected_date`) = 'Saturday' and `final_attendance_sheet`.`saturday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Sunday' and `final_attendance_sheet`.`sunday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Monday' and `final_attendance_sheet`.`monday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Tuesday' and `final_attendance_sheet`.`tuesday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Wednesday' and `final_attendance_sheet`.`wednesday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Thursday' and `final_attendance_sheet`.`thursday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or dayname(`final_attendance_sheet`.`selected_date`) = 'Friday' and `final_attendance_sheet`.`friday` is null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training' or `vacation_period_view`.`vacation_type` is null) or `final_attendance_sheet`.`absent` = 'True' and `vacation_period_view`.`date_vacation` is not null and (`vacation_period_view`.`vacation_type` = 'Regular vacation' or `vacation_period_view`.`vacation_type` = 'Work errand' or `vacation_period_view`.`vacation_type` = 'Training') and `vacation_period_view`.`approval2` = 'Accepted' or `final_attendance_sheet`.`absent` = '' and `final_attendance_sheet`.`clock_in` <> '','','True') AS `absent_after_holidays`,`request_leave_types`.`date_leave` AS `date_leave`,`request_leave_types`.`time_leave` AS `time_leave`,if(`final_attendance_sheet`.`selected_date` = `request_leave_types`.`date_leave` and `final_attendance_sheet`.`clock_in` >= `request_leave_types`.`time_leave` and `request_leave_types`.`target` = 'lates' and `request_leave_types`.`approval2` = 'Accepted','',`final_attendance_sheet`.`minutes`) AS `minutes_lates_after_request`,if(`final_attendance_sheet`.`selected_date` = `request_leave_types`.`date_leave` and `final_attendance_sheet`.`clock_out` >= `request_leave_types`.`time_leave` and `request_leave_types`.`target` = 'leaves' and `request_leave_types`.`approval2` = 'Accepted','',`final_attendance_sheet`.`leave_min`) AS `leave_early_after_request` from (((`final_attendance_sheet` left join `employee_holiday_dates` on(`final_attendance_sheet`.`attendance_id` = `employee_holiday_dates`.`attendance_id` and `final_attendance_sheet`.`selected_date` = `employee_holiday_dates`.`date_holiday`)) left join `vacation_period_view` on(`final_attendance_sheet`.`employee_id` = `vacation_period_view`.`employee_id` and `final_attendance_sheet`.`selected_date` = `vacation_period_view`.`date_vacation`)) left join `request_leave_types` on(`final_attendance_sheet`.`employee_id` = `request_leave_types`.`employee_id` and `final_attendance_sheet`.`selected_date` = `request_leave_types`.`date_leave` and `request_leave_types`.`approval2` = 'Accepted')) ;

-- --------------------------------------------------------

--
-- Structure for view `period`
--
DROP TABLE IF EXISTS `period`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `period`  AS  select `employees`.`id` AS `employee_id`,`employees`.`attendance_id` AS `attendance_id`,`date_lists`.`selected_date` AS `selected_date` from (`employees` join `date_lists`) ;

-- --------------------------------------------------------

--
-- Structure for view `request_leave_types`
--
DROP TABLE IF EXISTS `request_leave_types`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `request_leave_types`  AS  select `leave_types`.`id` AS `id`,`leave_types`.`ar_leave` AS `ar_leave`,`leave_types`.`en_leave` AS `en_leave`,`leave_types`.`have_balance` AS `have_balance`,`leave_types`.`activation` AS `activation`,`leave_types`.`target` AS `target`,`leave_types`.`deduction` AS `deduction`,`leave_types`.`deduction_allocated` AS `deduction_allocated`,`leave_types`.`from_day` AS `from_day`,`leave_types`.`to_day` AS `to_day`,`leave_types`.`period` AS `period`,`leave_types`.`sort` AS `sort`,`leave_types`.`admin_id` AS `admin_id`,`leave_types`.`created_at` AS `created_at`,`leave_types`.`updated_at` AS `updated_at`,`leave_permissions`.`employee_id` AS `employee_id`,`leave_permissions`.`date_leave` AS `date_leave`,`leave_permissions`.`time_leave` AS `time_leave`,`leave_permissions`.`approval2` AS `approval2` from (`leave_permissions` join `leave_types` on(`leave_permissions`.`leave_type_id` = `leave_types`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `total_payroll_view`
--
DROP TABLE IF EXISTS `total_payroll_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_payroll_view`  AS  select `payroll_components`.`code` AS `code`,`payroll_sheets`.`id` AS `payroll_sheet_id`,`payroll_components`.`period` AS `period`,`payroll_components`.`from_date` AS `from_date`,`payroll_components`.`to_date` AS `to_date`,`payroll_sheets`.`ar_sheet_name` AS `ar_sheet_name`,`payroll_sheets`.`en_sheet_name` AS `en_sheet_name`,`payroll_components`.`total_employees` AS `total_employees`,(select sum(`payroll_components`.`value`) from `payroll_components` where `payroll_components`.`calculate` = 'net') AS `total_Payroll`,(select `admins`.`username` from `admins` where `admins`.`id` = `payroll_components`.`admin_id` limit 1) AS `username` from (`payroll_components` join `payroll_sheets` on(`payroll_components`.`payroll_sheet_id` = `payroll_sheets`.`id`)) group by `payroll_sheets`.`id`,`payroll_components`.`period`,`payroll_components`.`from_date`,`payroll_components`.`to_date`,`payroll_sheets`.`ar_sheet_name`,`payroll_sheets`.`en_sheet_name`,`payroll_components`.`total_employees`,`payroll_components`.`code`,`payroll_components`.`admin_id` order by `payroll_components`.`from_date` desc ;

-- --------------------------------------------------------

--
-- Structure for view `vacation_period_view`
--
DROP TABLE IF EXISTS `vacation_period_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vacation_period_view`  AS  select `vacation_periods`.`id` AS `id`,`vacation_periods`.`date_vacation` AS `date_vacation`,`vacation_periods`.`vacation_type` AS `vacation_type`,`vacation_periods`.`employee_id` AS `employee_id`,`vacation_periods`.`vacation_id` AS `vacation_id`,`vacation_periods`.`created_at` AS `created_at`,`vacation_periods`.`updated_at` AS `updated_at`,`vacations`.`approval2` AS `approval2` from (`vacations` join `vacation_periods` on(`vacations`.`employee_id` = `vacation_periods`.`employee_id` and `vacations`.`id` = `vacation_periods`.`vacation_id`)) where `vacations`.`approval1` = 'Accepted' and `vacations`.`approval2` = 'Accepted' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absences_student_id_foreign` (`student_id`),
  ADD KEY `absences_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `acceptance_tests`
--
ALTER TABLE `acceptance_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acceptance_tests_grade_id_foreign` (`grade_id`),
  ADD KEY `acceptance_tests_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `active_days_request`
--
ALTER TABLE `active_days_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active_days_request_leave_type_id_foreign` (`leave_type_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admission_documents`
--
ALTER TABLE `admission_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_documents_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `admission_reports`
--
ALTER TABLE `admission_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_reports_father_id_foreign` (`father_id`),
  ADD KEY `admission_reports_student_id_foreign` (`student_id`),
  ADD KEY `admission_reports_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `archives_student_id_foreign` (`student_id`),
  ADD KEY `archives_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_student_id_foreign` (`student_id`),
  ADD KEY `assessments_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_employee_id_foreign` (`employee_id`),
  ADD KEY `attachments_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_attendance_sheet_id_foreign` (`attendance_sheet_id`),
  ADD KEY `attendances_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `attendance_sheets`
--
ALTER TABLE `attendance_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_sheets_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classrooms_division_id_foreign` (`division_id`),
  ADD KEY `classrooms_grade_id_foreign` (`grade_id`),
  ADD KEY `classrooms_year_id_foreign` (`year_id`),
  ADD KEY `classrooms_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `commissioners`
--
ALTER TABLE `commissioners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commissioners_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `commissioners_mobile_unique` (`mobile`),
  ADD KEY `commissioners_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_father_id_foreign` (`father_id`),
  ADD KEY `contacts_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `daily_requests`
--
ALTER TABLE `daily_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daily_requests_student_id_foreign` (`student_id`),
  ADD KEY `daily_requests_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deductions_employee_id_foreign` (`employee_id`),
  ADD KEY `deductions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_sector_id_foreign` (`sector_id`),
  ADD KEY `departments_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designs_division_id_foreign` (`division_id`),
  ADD KEY `designs_grade_id_foreign` (`grade_id`),
  ADD KEY `designs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `documents_grades`
--
ALTER TABLE `documents_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_grades_admission_document_id_foreign` (`admission_document_id`),
  ADD KEY `documents_grades_grade_id_foreign` (`grade_id`),
  ADD KEY `documents_grades_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_attendance_id_unique` (`attendance_id`),
  ADD KEY `employees_sector_id_foreign` (`sector_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_section_id_foreign` (`section_id`),
  ADD KEY `employees_position_id_foreign` (`position_id`),
  ADD KEY `employees_timetable_id_foreign` (`timetable_id`),
  ADD KEY `employees_direct_manager_id_foreign` (`direct_manager_id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_documents_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_documents_document_id_foreign` (`document_id`);

--
-- Indexes for table `employee_holidays`
--
ALTER TABLE `employee_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_holidays_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_holidays_holiday_id_foreign` (`holiday_id`);

--
-- Indexes for table `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_skills_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_skills_skill_id_foreign` (`skill_id`);

--
-- Indexes for table `external_codes`
--
ALTER TABLE `external_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `external_codes_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fathers`
--
ALTER TABLE `fathers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fathers_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `fathers_mobile1_unique` (`mobile1`),
  ADD UNIQUE KEY `fathers_email_unique` (`email`),
  ADD UNIQUE KEY `fathers_whatsapp_number_unique` (`whatsapp_number`),
  ADD KEY `fathers_nationality_id_foreign` (`nationality_id`),
  ADD KEY `fathers_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `father_mother`
--
ALTER TABLE `father_mother`
  ADD PRIMARY KEY (`id`),
  ADD KEY `father_mother_father_id_foreign` (`father_id`),
  ADD KEY `father_mother_mother_id_foreign` (`mother_id`);

--
-- Indexes for table `fixed_components`
--
ALTER TABLE `fixed_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fixed_components_employee_id_foreign` (`employee_id`),
  ADD KEY `fixed_components_salary_component_id_foreign` (`salary_component_id`),
  ADD KEY `fixed_components_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guardians_guardian_id_number_unique` (`guardian_id_number`),
  ADD UNIQUE KEY `guardians_guardian_mobile1_unique` (`guardian_mobile1`),
  ADD UNIQUE KEY `guardians_guardian_email_unique` (`guardian_email`),
  ADD KEY `guardians_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histories_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holidays_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `holiday_days`
--
ALTER TABLE `holiday_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `holiday_days_holiday_id_foreign` (`holiday_id`),
  ADD KEY `holiday_days_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `hr_reports`
--
ALTER TABLE `hr_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hr_reports_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interviews_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `languages_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `leave_permissions`
--
ALTER TABLE `leave_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_permissions_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `leave_permissions_employee_id_foreign` (`employee_id`),
  ADD KEY `leave_permissions_admin_id_foreign` (`admin_id`),
  ADD KEY `leave_permissions_approval_one_user_foreign` (`approval_one_user`),
  ADD KEY `leave_permissions_approval_two_user_foreign` (`approval_two_user`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_requests_student_id_foreign` (`student_id`),
  ADD KEY `leave_requests_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_employee_id_foreign` (`employee_id`),
  ADD KEY `loans_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `machines_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `medicals`
--
ALTER TABLE `medicals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicals_student_id_foreign` (`student_id`),
  ADD KEY `medicals_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meetings_interview_id_foreign` (`interview_id`),
  ADD KEY `meetings_father_id_foreign` (`father_id`),
  ADD KEY `meetings_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mothers`
--
ALTER TABLE `mothers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mothers_id_number_m_unique` (`id_number_m`),
  ADD UNIQUE KEY `mothers_mobile1_m_unique` (`mobile1_m`),
  ADD UNIQUE KEY `mothers_email_m_unique` (`email_m`),
  ADD UNIQUE KEY `mothers_whatsapp_number_m_unique` (`whatsapp_number_m`),
  ADD KEY `mothers_nationality_id_m_foreign` (`nationality_id_m`),
  ADD KEY `mothers_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nationalities_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_father_id_foreign` (`father_id`),
  ADD KEY `notes_student_id_foreign` (`student_id`),
  ADD KEY `notes_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `parent_requests`
--
ALTER TABLE `parent_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_requests_student_id_foreign` (`student_id`),
  ADD KEY `parent_requests_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payroll_components`
--
ALTER TABLE `payroll_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_components_employee_id_foreign` (`employee_id`),
  ADD KEY `payroll_components_salary_component_id_foreign` (`salary_component_id`),
  ADD KEY `payroll_components_payroll_sheet_id_foreign` (`payroll_sheet_id`),
  ADD KEY `payroll_components_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `payroll_sheets`
--
ALTER TABLE `payroll_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_sheets_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `payroll_sheet_employees`
--
ALTER TABLE `payroll_sheet_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_sheet_employees_employee_id_foreign` (`employee_id`),
  ADD KEY `payroll_sheet_employees_payroll_sheet_id_foreign` (`payroll_sheet_id`),
  ADD KEY `payroll_sheet_employees_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `positions_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `registration_status`
--
ALTER TABLE `registration_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_status_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `report_contents`
--
ALTER TABLE `report_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_contents_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_student_id_foreign` (`student_id`),
  ADD KEY `rooms_classroom_id_foreign` (`classroom_id`),
  ADD KEY `rooms_year_id_foreign` (`year_id`),
  ADD KEY `rooms_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `salary_components`
--
ALTER TABLE `salary_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_components_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schools_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sectors_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `set_migration`
--
ALTER TABLE `set_migration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `set_migration_from_grade_id_foreign` (`from_grade_id`),
  ADD KEY `set_migration_to_grade_id_foreign` (`to_grade_id`),
  ADD KEY `set_migration_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skills_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stages_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `stage_grades`
--
ALTER TABLE `stage_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stage_grades_stage_id_foreign` (`stage_id`),
  ADD KEY `stage_grades_grade_id_foreign` (`grade_id`),
  ADD KEY `stage_grades_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `steps_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_number_unique` (`student_id_number`),
  ADD UNIQUE KEY `students_student_number_unique` (`student_number`),
  ADD KEY `students_school_id_foreign` (`school_id`),
  ADD KEY `students_native_lang_id_foreign` (`native_lang_id`),
  ADD KEY `students_second_lang_id_foreign` (`second_lang_id`),
  ADD KEY `students_grade_id_foreign` (`grade_id`),
  ADD KEY `students_guardian_id_foreign` (`guardian_id`),
  ADD KEY `students_division_id_foreign` (`division_id`),
  ADD KEY `students_registration_status_id_foreign` (`registration_status_id`),
  ADD KEY `students_nationality_id_foreign` (`nationality_id`),
  ADD KEY `students_father_id_foreign` (`father_id`),
  ADD KEY `students_mother_id_foreign` (`mother_id`),
  ADD KEY `students_year_id_foreign` (`year_id`),
  ADD KEY `students_admin_id_foreign` (`admin_id`),
  ADD KEY `students_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `students_commissioners`
--
ALTER TABLE `students_commissioners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_commissioners_student_id_foreign` (`student_id`),
  ADD KEY `students_commissioners_commissioner_id_foreign` (`commissioner_id`),
  ADD KEY `students_commissioners_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `students_statements`
--
ALTER TABLE `students_statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_statements_student_id_foreign` (`student_id`),
  ADD KEY `students_statements_grade_id_foreign` (`grade_id`),
  ADD KEY `students_statements_division_id_foreign` (`division_id`),
  ADD KEY `students_statements_year_id_foreign` (`year_id`),
  ADD KEY `students_statements_registration_status_id_foreign` (`registration_status_id`),
  ADD KEY `students_statements_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `student_address`
--
ALTER TABLE `student_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_address_student_id_foreign` (`student_id`),
  ADD KEY `student_address_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `student_doc_delivers`
--
ALTER TABLE `student_doc_delivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_doc_delivers_student_id_foreign` (`student_id`),
  ADD KEY `student_doc_delivers_admission_document_id_foreign` (`admission_document_id`),
  ADD KEY `student_doc_delivers_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `student_steps`
--
ALTER TABLE `student_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_steps_student_id_foreign` (`student_id`),
  ADD KEY `student_steps_admission_step_id_foreign` (`admission_step_id`),
  ADD KEY `student_steps_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `temporary_components`
--
ALTER TABLE `temporary_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temporary_components_employee_id_foreign` (`employee_id`),
  ADD KEY `temporary_components_salary_component_id_foreign` (`salary_component_id`),
  ADD KEY `temporary_components_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_assessment_id_foreign` (`assessment_id`),
  ADD KEY `tests_acceptance_test_id_foreign` (`acceptance_test_id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetables_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_school_id_foreign` (`school_id`),
  ADD KEY `transfers_current_grade_id_foreign` (`current_grade_id`),
  ADD KEY `transfers_next_grade_id_foreign` (`next_grade_id`),
  ADD KEY `transfers_current_year_id_foreign` (`current_year_id`),
  ADD KEY `transfers_next_year_id_foreign` (`next_year_id`),
  ADD KEY `transfers_student_id_foreign` (`student_id`),
  ADD KEY `transfers_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacations_employee_id_foreign` (`employee_id`),
  ADD KEY `vacations_substitute_employee_id_foreign` (`substitute_employee_id`),
  ADD KEY `vacations_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `vacation_periods`
--
ALTER TABLE `vacation_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacation_periods_employee_id_foreign` (`employee_id`),
  ADD KEY `vacation_periods_vacation_id_foreign` (`vacation_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`),
  ADD KEY `years_admin_id_foreign` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acceptance_tests`
--
ALTER TABLE `acceptance_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `active_days_request`
--
ALTER TABLE `active_days_request`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admission_documents`
--
ALTER TABLE `admission_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admission_reports`
--
ALTER TABLE `admission_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `archives`
--
ALTER TABLE `archives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_sheets`
--
ALTER TABLE `attendance_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commissioners`
--
ALTER TABLE `commissioners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_requests`
--
ALTER TABLE `daily_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designs`
--
ALTER TABLE `designs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents_grades`
--
ALTER TABLE `documents_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1993;

--
-- AUTO_INCREMENT for table `employee_documents`
--
ALTER TABLE `employee_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_holidays`
--
ALTER TABLE `employee_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_skills`
--
ALTER TABLE `employee_skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_codes`
--
ALTER TABLE `external_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fathers`
--
ALTER TABLE `fathers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `father_mother`
--
ALTER TABLE `father_mother`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fixed_components`
--
ALTER TABLE `fixed_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_days`
--
ALTER TABLE `holiday_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_reports`
--
ALTER TABLE `hr_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_permissions`
--
ALTER TABLE `leave_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicals`
--
ALTER TABLE `medicals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meetings`
--
ALTER TABLE `meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `mothers`
--
ALTER TABLE `mothers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parent_requests`
--
ALTER TABLE `parent_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_components`
--
ALTER TABLE `payroll_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_sheets`
--
ALTER TABLE `payroll_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_sheet_employees`
--
ALTER TABLE `payroll_sheet_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_status`
--
ALTER TABLE `registration_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_contents`
--
ALTER TABLE `report_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_components`
--
ALTER TABLE `salary_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `set_migration`
--
ALTER TABLE `set_migration`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stages`
--
ALTER TABLE `stages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stage_grades`
--
ALTER TABLE `stage_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `steps`
--
ALTER TABLE `steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_commissioners`
--
ALTER TABLE `students_commissioners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students_statements`
--
ALTER TABLE `students_statements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_address`
--
ALTER TABLE `student_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_doc_delivers`
--
ALTER TABLE `student_doc_delivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_steps`
--
ALTER TABLE `student_steps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temporary_components`
--
ALTER TABLE `temporary_components`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vacation_periods`
--
ALTER TABLE `vacation_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `absences_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `acceptance_tests`
--
ALTER TABLE `acceptance_tests`
  ADD CONSTRAINT `acceptance_tests_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `acceptance_tests_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `active_days_request`
--
ALTER TABLE `active_days_request`
  ADD CONSTRAINT `active_days_request_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admission_documents`
--
ALTER TABLE `admission_documents`
  ADD CONSTRAINT `admission_documents_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `admission_reports`
--
ALTER TABLE `admission_reports`
  ADD CONSTRAINT `admission_reports_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `admission_reports_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admission_reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `archives_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `archives_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `assessments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `attachments_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `attendances_attendance_sheet_id_foreign` FOREIGN KEY (`attendance_sheet_id`) REFERENCES `attendance_sheets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance_sheets`
--
ALTER TABLE `attendance_sheets`
  ADD CONSTRAINT `attendance_sheets_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD CONSTRAINT `classrooms_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `classrooms_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classrooms_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classrooms_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commissioners`
--
ALTER TABLE `commissioners`
  ADD CONSTRAINT `commissioners_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `contacts_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `daily_requests`
--
ALTER TABLE `daily_requests`
  ADD CONSTRAINT `daily_requests_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `daily_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `deductions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `departments_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designs`
--
ALTER TABLE `designs`
  ADD CONSTRAINT `designs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `designs_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `designs_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `divisions`
--
ALTER TABLE `divisions`
  ADD CONSTRAINT `divisions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `documents_grades`
--
ALTER TABLE `documents_grades`
  ADD CONSTRAINT `documents_grades_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `documents_grades_admission_document_id_foreign` FOREIGN KEY (`admission_document_id`) REFERENCES `admission_documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documents_grades_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_direct_manager_id_foreign` FOREIGN KEY (`direct_manager_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_sector_id_foreign` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_timetable_id_foreign` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `employee_documents`
--
ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_documents_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_holidays`
--
ALTER TABLE `employee_holidays`
  ADD CONSTRAINT `employee_holidays_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_holidays_holiday_id_foreign` FOREIGN KEY (`holiday_id`) REFERENCES `holidays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD CONSTRAINT `employee_skills_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `external_codes`
--
ALTER TABLE `external_codes`
  ADD CONSTRAINT `external_codes_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `fathers`
--
ALTER TABLE `fathers`
  ADD CONSTRAINT `fathers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fathers_nationality_id_foreign` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `father_mother`
--
ALTER TABLE `father_mother`
  ADD CONSTRAINT `father_mother_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `father_mother_mother_id_foreign` FOREIGN KEY (`mother_id`) REFERENCES `mothers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fixed_components`
--
ALTER TABLE `fixed_components`
  ADD CONSTRAINT `fixed_components_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `fixed_components_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixed_components_salary_component_id_foreign` FOREIGN KEY (`salary_component_id`) REFERENCES `salary_components` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `holidays`
--
ALTER TABLE `holidays`
  ADD CONSTRAINT `holidays_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `holiday_days`
--
ALTER TABLE `holiday_days`
  ADD CONSTRAINT `holiday_days_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `holiday_days_holiday_id_foreign` FOREIGN KEY (`holiday_id`) REFERENCES `holidays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hr_reports`
--
ALTER TABLE `hr_reports`
  ADD CONSTRAINT `hr_reports_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `languages`
--
ALTER TABLE `languages`
  ADD CONSTRAINT `languages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `leave_permissions`
--
ALTER TABLE `leave_permissions`
  ADD CONSTRAINT `leave_permissions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `leave_permissions_approval_one_user_foreign` FOREIGN KEY (`approval_one_user`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `leave_permissions_approval_two_user_foreign` FOREIGN KEY (`approval_two_user`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `leave_permissions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `leave_permissions_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `leave_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `loans_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `medicals`
--
ALTER TABLE `medicals`
  ADD CONSTRAINT `medicals_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `medicals_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `meetings_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `meetings_interview_id_foreign` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mothers`
--
ALTER TABLE `mothers`
  ADD CONSTRAINT `mothers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `mothers_nationality_id_m_foreign` FOREIGN KEY (`nationality_id_m`) REFERENCES `nationalities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD CONSTRAINT `nationalities_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `notes_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_requests`
--
ALTER TABLE `parent_requests`
  ADD CONSTRAINT `parent_requests_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `parent_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payroll_components`
--
ALTER TABLE `payroll_components`
  ADD CONSTRAINT `payroll_components_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `payroll_components_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payroll_components_payroll_sheet_id_foreign` FOREIGN KEY (`payroll_sheet_id`) REFERENCES `payroll_sheets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payroll_components_salary_component_id_foreign` FOREIGN KEY (`salary_component_id`) REFERENCES `salary_components` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payroll_sheets`
--
ALTER TABLE `payroll_sheets`
  ADD CONSTRAINT `payroll_sheets_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `payroll_sheet_employees`
--
ALTER TABLE `payroll_sheet_employees`
  ADD CONSTRAINT `payroll_sheet_employees_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `payroll_sheet_employees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payroll_sheet_employees_payroll_sheet_id_foreign` FOREIGN KEY (`payroll_sheet_id`) REFERENCES `payroll_sheets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `registration_status`
--
ALTER TABLE `registration_status`
  ADD CONSTRAINT `registration_status_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `report_contents`
--
ALTER TABLE `report_contents`
  ADD CONSTRAINT `report_contents_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `rooms_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rooms_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salary_components`
--
ALTER TABLE `salary_components`
  ADD CONSTRAINT `salary_components_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `sectors_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `set_migration`
--
ALTER TABLE `set_migration`
  ADD CONSTRAINT `set_migration_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `set_migration_from_grade_id_foreign` FOREIGN KEY (`from_grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_migration_to_grade_id_foreign` FOREIGN KEY (`to_grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `stages`
--
ALTER TABLE `stages`
  ADD CONSTRAINT `stages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `stage_grades`
--
ALTER TABLE `stage_grades`
  ADD CONSTRAINT `stage_grades_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `stage_grades_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stage_grades_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `steps`
--
ALTER TABLE `steps`
  ADD CONSTRAINT `steps_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `students_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_father_id_foreign` FOREIGN KEY (`father_id`) REFERENCES `fathers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_guardian_id_foreign` FOREIGN KEY (`guardian_id`) REFERENCES `guardians` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_mother_id_foreign` FOREIGN KEY (`mother_id`) REFERENCES `mothers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_nationality_id_foreign` FOREIGN KEY (`nationality_id`) REFERENCES `nationalities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_native_lang_id_foreign` FOREIGN KEY (`native_lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_registration_status_id_foreign` FOREIGN KEY (`registration_status_id`) REFERENCES `registration_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_second_lang_id_foreign` FOREIGN KEY (`second_lang_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_commissioners`
--
ALTER TABLE `students_commissioners`
  ADD CONSTRAINT `students_commissioners_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `students_commissioners_commissioner_id_foreign` FOREIGN KEY (`commissioner_id`) REFERENCES `commissioners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_commissioners_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_statements`
--
ALTER TABLE `students_statements`
  ADD CONSTRAINT `students_statements_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `students_statements_division_id_foreign` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_statements_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_statements_registration_status_id_foreign` FOREIGN KEY (`registration_status_id`) REFERENCES `registration_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_statements_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_statements_year_id_foreign` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_address`
--
ALTER TABLE `student_address`
  ADD CONSTRAINT `student_address_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `student_address_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_doc_delivers`
--
ALTER TABLE `student_doc_delivers`
  ADD CONSTRAINT `student_doc_delivers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `student_doc_delivers_admission_document_id_foreign` FOREIGN KEY (`admission_document_id`) REFERENCES `admission_documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_doc_delivers_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_steps`
--
ALTER TABLE `student_steps`
  ADD CONSTRAINT `student_steps_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `student_steps_admission_step_id_foreign` FOREIGN KEY (`admission_step_id`) REFERENCES `steps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_steps_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temporary_components`
--
ALTER TABLE `temporary_components`
  ADD CONSTRAINT `temporary_components_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `temporary_components_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `temporary_components_salary_component_id_foreign` FOREIGN KEY (`salary_component_id`) REFERENCES `salary_components` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_acceptance_test_id_foreign` FOREIGN KEY (`acceptance_test_id`) REFERENCES `acceptance_tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tests_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `transfers_current_grade_id_foreign` FOREIGN KEY (`current_grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_current_year_id_foreign` FOREIGN KEY (`current_year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_next_grade_id_foreign` FOREIGN KEY (`next_grade_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_next_year_id_foreign` FOREIGN KEY (`next_year_id`) REFERENCES `years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfers_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacations`
--
ALTER TABLE `vacations`
  ADD CONSTRAINT `vacations_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `vacations_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vacations_substitute_employee_id_foreign` FOREIGN KEY (`substitute_employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacation_periods`
--
ALTER TABLE `vacation_periods`
  ADD CONSTRAINT `vacation_periods_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vacation_periods_vacation_id_foreign` FOREIGN KEY (`vacation_id`) REFERENCES `vacations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `years`
--
ALTER TABLE `years`
  ADD CONSTRAINT `years_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
