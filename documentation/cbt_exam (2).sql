-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2023 at 01:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbt_exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `access_level`, `created_at`, `update_at`) VALUES
(2, 'Tatiana Escort', 'Tatiana_134@gmail.com', 'Tatiana_134', '$2y$10$Z.Hz.RacjS7KO65DoTPBLeUNg5eVZMFp/ztWvCN1v67Fl3Gy7R1zG', 2, '2023-08-05 15:48:47', '2023-08-05 15:48:47'),
(3, 'Kenneth Enobakhare', 'kenenobas@gmail.com', 'ken24ever', '$2y$10$xWQ/nppL5BmoEERiA2DAhOut7XGdBzJCKhL.W4dfjyjqyP3uzgaBa', 1, '2023-08-05 15:50:33', '2023-08-05 15:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `audit_tray`
--

CREATE TABLE `audit_tray` (
  `id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `audit_tray`
--

INSERT INTO `audit_tray` (`id`, `user_name`, `user_id`, `description`, `action`, `created_at`) VALUES
(1, 'Kenneth Enobakhare', 3, 'User name field was empty when logged in user: (Kenneth Enobakhare) clicked the submit button', 'Add User', '2023-08-05 17:25:03'),
(2, 'Kenneth Enobakhare', 3, 'Logged in user: (Kenneth Enobakhare) created this record with the name of: Daniel meeks', 'Add User', '2023-08-05 17:27:51'),
(3, 'Kenneth Enobakhare', 3, 'Logged in user: (Kenneth Enobakhare) may have successfully uploaded file with name: C:\\fakepath\\questions (1).xlsx', 'Batch User Upload', '2023-08-05 22:38:07'),
(4, 'Kenneth Enobakhare', 3, 'Search user field was empty when logged in user: (Kenneth Enobakhare) clicked the submit button', 'Search User', '2023-08-05 22:55:28'),
(5, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for : ken', 'Search User', '2023-08-05 22:55:59'),
(6, 'Kenneth Enobakhare', 3, 'Search user field was empty when logged in user: (Kenneth Enobakhare) clicked the submit button', 'Search User', '2023-08-06 00:05:58'),
(26, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) did not perform any action', 'No Action', '2023-08-06 08:03:40'),
(29, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) created this record with the name of: \"Ruth Kadiri\"', 'Add User', '2023-08-06 08:23:09'),
(30, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) created this record with the name of: \"Sarah Cornor\"', 'Add User', '2023-08-06 08:25:39'),
(31, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch User Upload', '2023-08-06 08:26:42'),
(32, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) searched for: \"Sarah Cornor\"', 'Search User', '2023-08-06 08:27:33'),
(33, 'Tatiana Escort', 2, 'User name field was empty when logged in user: (Tatiana Escort) clicked the submit button', 'Add User', '2023-08-06 08:28:00'),
(34, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) created this record with the name of: \"Daniel meeks\"', 'Add User', '2023-08-07 03:01:58'),
(35, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"ken\"', 'Search User', '2023-08-07 03:03:30'),
(36, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock1234\"', 'Search User', '2023-08-07 03:09:43'),
(37, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"fletcherFrank123\"', 'Search User', '2023-08-07 03:18:01'),
(38, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"joan_greg1234\"', 'Search User', '2023-08-07 03:22:54'),
(39, 'Kenneth Enobakhare', 3, 'User name field was empty when logged in user: (Kenneth Enobakhare) clicked the submit button', 'Add User', '2023-08-07 03:30:52'),
(40, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"dan\"', 'Search User', '2023-08-07 03:31:04'),
(41, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) searched for: \"ken24ever\"', 'Search User', '2023-08-07 03:57:23'),
(42, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"thomas_david@gmail.com\"', 'Search User', '2023-08-07 10:34:58'),
(43, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:19:22'),
(44, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:28:51'),
(45, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited or altered user with name: \"Kent Dock\"', 'Edit User', '2023-08-07 12:29:00'),
(46, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock1234\"', 'Search User', '2023-08-07 12:33:57'),
(47, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:37:09'),
(48, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:39:52'),
(49, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:47:50'),
(50, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) deleted user record with username: \"kentdock1234\"', 'Single User Delete', '2023-08-07 12:48:23'),
(51, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-07 12:50:08'),
(52, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"dan\"', 'Search User', '2023-08-07 12:50:31'),
(53, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"dan\"', 'Search User', '2023-08-07 13:06:58'),
(54, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) reseted exam title: \"PHP\" for user with username: \"daniel_meeks1234\" ', 'Single User Reset', '2023-08-07 13:07:17'),
(55, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) added these numbers (\"1\") of questions to exam title: \"PHP\"', 'More Questions Added', '2023-08-07 13:54:30'),
(56, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) added these numbers (\"1\") of questions to exam title: \"Maths \"', 'More Questions Added', '2023-08-07 13:56:53'),
(57, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) created exam title: \"Maths \" and added these numbers (\"1\") of questions', 'Exam Creation', '2023-08-07 13:59:37'),
(58, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) uploaded batch questions for exam title : \"maths\"', 'Batch Questions Upload', '2023-08-07 21:47:56'),
(59, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited exam title \"PHP\"', 'Exam details Edited', '2023-08-07 22:16:32'),
(60, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) uploaded batch questions for exam title : \"Blabla\"', 'Batch Questions Upload', '2023-08-07 22:17:18'),
(61, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) deleted details of exam with title: \"Blabla\"', 'Exam details Deleted', '2023-08-07 22:22:35'),
(62, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited exam question ID: \"22\" ', 'Question Edit', '2023-08-08 11:49:36'),
(63, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) downloaded exam questions with title: \"Maths \"', 'Exam Questions Downloaded', '2023-08-08 11:52:48'),
(64, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"18\"', 'Batch Users Reset', '2023-08-08 12:31:46'),
(65, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"19\"', 'Batch Users Reset', '2023-08-08 12:31:46'),
(66, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"20\"', 'Batch Users Reset', '2023-08-08 12:31:46'),
(67, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"21\"', 'Batch Users Reset', '2023-08-08 12:31:47'),
(68, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"23\"', 'Batch Users Reset', '2023-08-08 12:31:47'),
(69, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"24\"', 'Batch Users Reset', '2023-08-08 12:31:47'),
(70, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"27\"', 'Batch Users Reset', '2023-08-08 12:31:47'),
(71, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for IDs: \"28\"', 'Batch Users Reset', '2023-08-08 12:31:47'),
(72, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for these numbers of users: \"8\"', 'Batch Users Reset', '2023-08-08 12:36:24'),
(73, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user delete for these number of users: \"4\"', 'Batch Users Delete', '2023-08-08 12:43:16'),
(74, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch User Upload', '2023-08-08 13:00:20'),
(87, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) exported these number: (2) of users scores and details for exam with title: \"PHP\"', 'Export Users Scores', '2023-08-08 19:49:34'),
(88, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user delete for these number of users: \"1\"', 'Batch Users Delete', '2023-08-08 19:53:55'),
(89, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch Users Upload', '2023-08-08 19:54:51'),
(90, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch Users Upload', '2023-08-08 19:57:06'),
(91, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"kentdock\"', 'Search User', '2023-08-08 19:58:23'),
(92, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited or altered details of user with name: \"Kent Dock\"', 'Edit User', '2023-08-08 19:58:31'),
(93, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) reseted exam title: \"php\" for user with username: \"kentdock1234\" ', 'Single User Reset', '2023-08-08 19:58:46'),
(94, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user reset for these number of users: \"1\"', 'Batch Users Reset', '2023-08-08 19:59:37'),
(95, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user delete for these number of users: \"1\"', 'Batch Users Delete', '2023-08-08 20:00:32'),
(96, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch Users Upload', '2023-08-08 20:01:24'),
(97, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) did a batch user delete for these number of users: \"1\"', 'Batch Users Delete', '2023-08-08 20:01:46'),
(98, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch Users Upload', '2023-08-08 20:02:44'),
(99, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) edited exam question ID: \"22\" ', 'Question Edit', '2023-08-08 20:03:42'),
(100, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) searched for: \"ken24ever\"', 'Search User', '2023-08-08 20:04:02'),
(101, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) may have successfully created users by uploading file with filename: \"C:\\fakepath\\users_template.xlsx\"', 'Batch Users Upload', '2023-08-08 20:04:20'),
(102, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) searched for: \"ken24ever\"', 'Search User', '2023-08-08 20:04:36'),
(103, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"ken24ever\"', 'Search User', '2023-08-08 20:06:53'),
(104, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited or altered details of user with name: \"Kenneth Enobakhare\"', 'Edit User', '2023-08-08 20:07:48'),
(105, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) edited or altered details of user with name: \"Kenneth Enobakhare\"', 'Edit User', '2023-08-08 20:08:10'),
(106, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) searched for: \"ken24ever\"', 'Search User', '2023-08-08 20:08:44'),
(107, 'Tatiana Escort', 2, 'Logged in admin user: (Tatiana Escort) edited or altered details of user with name: \"Kenneth Enobakhare\"', 'Edit User', '2023-08-08 20:09:01'),
(108, 'Kenneth Enobakhare', 3, 'Logged in admin user: (Kenneth Enobakhare) searched for: \"ken\"', 'Search User', '2023-08-08 20:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `title`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'Server Side Web Programming Language Exam.', 60, '2023-08-03 23:55:53', '2023-08-03 23:55:53'),
(3, 'Maths ', 'Simple Maths exam', 60, '2023-08-07 13:59:37', '2023-08-07 13:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `option_e` varchar(255) NOT NULL,
  `image_ques` varchar(255) DEFAULT NULL,
  `option_a_image_path` varchar(255) DEFAULT NULL,
  `option_b_image_path` varchar(255) DEFAULT NULL,
  `option_c_image_path` varchar(255) DEFAULT NULL,
  `option_d_image_path` varchar(255) DEFAULT NULL,
  `option_e_image_path` varchar(255) DEFAULT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `option_e`, `image_ques`, `option_a_image_path`, `option_b_image_path`, `option_c_image_path`, `option_d_image_path`, `option_e_image_path`, `answer`, `created_at`, `updated_at`) VALUES
(3, 1, 'what are the various ways to output in PHP?', 'Print_r()', 'c>>out', 'document.write()', 'getElementById().innerHTML=OUTPUT', 'Echo()', '', '', '', '', '', '', 'A,E', '2023-08-05 10:03:11', '2023-08-05 10:03:11'),
(4, 1, 'What does unlink() do in PHP?', 'It is used to created a link in HTML', 'It is used to delete a record from a database table', 'It is used to delete a file from a directory', 'It create a LINK in an app.', 'It is used to save a file in a directory', '', '', '', '', '', '', 'C', '2023-08-05 10:03:11', '2023-08-05 10:03:11'),
(5, 1, 'What does a PREPARED STATEMENT basically do in terms of security?', 'It is used to prepare SQL statement', 'It is basically used to prevent SQL INJECTION into the database.', 'It is used to loop through an array of items', 'SQL prepared statement is for detecting SQL errors during operations', 'It functions as a defense against anti virus.', '', '', '', '', '', '', 'B', '2023-08-05 10:03:11', '2023-08-05 10:03:11'),
(6, 1, 'What does the function mkdir() do?', 'It is used to delete files from a directory/folder. ', 'It is used to create an empty directory/folder.', 'It is used to create a link to the directory/folder.', 'It is used to delete records from a file inside a directory/folder.', 'Mkdir() is simply used to record data inside a file.', '', '', '', '', '', '', 'B', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(7, 1, 'Select the right differences between static and dynamic websites.', 'Static websites: The content cannot be manipulated after the script is executed;  Dynamic websites: The content can be changed even at the runtime', 'Static websites are most attractive while dynamic websites are just too unattractive', 'Static websites: No way to change the content as it is predefined; Dynamic websites: The content can be changed easily by manipulation and reloading', 'The both are the same in features and appearances', 'Static website have more content than that of a dynamic website', '', '', '', '', '', '', 'A,C', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(8, 1, 'How is a PHP script executed? Select the right options in this question.', 'With PHP you can send request to the client side for data. ', 'With PHP, It becomes very easy to provide restricted access to the required content of the website.', 'It allows users to access individual cookies and set them as per requirement.', 'Database manipulation operations, such as addition, deletion, and modification, can be done easily.', 'The system module allows users to perform a variety of system functions such as open, read, write, etc.', '', '', '', '', '', '', 'B,C,D,E', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(9, 1, 'Is PHP a case-sensitive scripting language? ', 'Yes', 'No', 'Yes and No', 'True', 'False', '', '', '', '', '', '', 'C', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(10, 1, 'What is the full meaning of PEAR in PHP?', 'Path Execution and Application Extention', 'Processing Extention at Runtime', 'Preprocessor End Application Runtime.', 'Pear Extension And Application Repository.', 'Parse Execution And Application Repo', '', '', '', '', '', '', 'D', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(11, 1, 'How is a PHP script executed in a command line Interface (CLI)?', 'PPP filename.php', 'php filename.php', 'parse php filename.php', 'run php filename.php', 'run parse php filename.php', '', '', '', '', '', '', 'B', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(12, 1, 'The following are TYPES of PHP VARIABLES.', 'Integer', 'NULL', 'Boolean ', 'Resource', 'Object', '', '', '', '', '', '', 'A,B,C,D,E', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(13, 1, 'What are the main characteristics of a PHP variable?', 'Variable can be declared before the value assignment.', 'A variable value assignment happens using the \'=\' operator.', 'Variables are Not temporal store houses rather permanent store houses.', 'The value of a variable depends on it\'s latest assigned value.', 'Variables could be used to delete arrays in a script.', '', '', '', '', '', '', 'A,B,D', '2023-08-05 10:52:15', '2023-08-05 10:52:15'),
(15, 1, 'What is NULL in PHP?', 'NULL is a special data type in PHP used to denote the presence of only one value, NULL.', 'NULL is a special data type in PHP used to denote the presence of only two values, NULL and void.', 'NULL is a special data type in PHP used to denote the presence of only one value, void.', 'NULL is a special data type in PHP used to denote the presence of only three values, NULL, void and Empty.', 'NULL is a special data type in PHP used to denote the presence of only one value, empty.', '', '', '', '', '', '', 'A', '2023-08-05 11:01:46', '2023-08-05 11:01:46'),
(22, 1, 'What is the full meaning of PHP?', 'Hypertext preloaded language', 'Predefined Hyperlinks', 'Hypertext Preprocessor', 'Processor Run time language', 'Syntax Preprocessor language', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-08-07 13:53:58', '2023-08-08 11:49:36'),
(25, 3, 'what is 20-5?', '13', '14', '12', '16', '15', '', '', '', '', '', '', 'E', '2023-08-07 13:59:37', '2023-08-07 13:59:37'),
(26, 3, 'what is 20-5?', '13', '14', '12', '16', '15', NULL, NULL, NULL, NULL, NULL, NULL, 'E', '2023-08-07 21:47:56', '2023-08-07 21:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `selected_options`
--

CREATE TABLE `selected_options` (
  `id` int(11) NOT NULL,
  `user_exam_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `selected_options`
--

INSERT INTO `selected_options` (`id`, `user_exam_id`, `exam_id`, `question_id`, `selected_option`, `created_at`, `updated_at`) VALUES
(9, 1, 1, 1, 'a,c,d,e', '2023-08-04 15:00:09', '2023-08-04 15:01:03'),
(17, 5, 1, 1, 'a,c,d,e', '2023-08-04 16:03:57', '2023-08-04 16:04:01'),
(18, 5, 1, 2, 'c', '2023-08-04 16:04:10', '2023-08-04 16:04:10'),
(19, 10, 1, 2, 'c', '2023-08-04 23:11:34', '2023-08-04 23:11:34'),
(20, 10, 1, 1, 'a,c,d,e', '2023-08-04 23:12:08', '2023-08-04 23:12:22'),
(33, 33, 1, 5, 'b', '2023-08-08 13:17:55', '2023-08-08 13:17:55'),
(34, 33, 1, 12, 'a,b,c,d,e', '2023-08-08 13:18:00', '2023-08-08 13:18:04'),
(35, 33, 1, 15, 'a', '2023-08-08 13:18:09', '2023-08-08 13:18:09'),
(36, 33, 1, 8, 'b,c,d,e', '2023-08-08 13:18:27', '2023-08-08 13:18:38'),
(37, 33, 1, 13, 'a,b,d', '2023-08-08 13:19:06', '2023-08-08 13:19:17'),
(38, 33, 1, 9, 'c', '2023-08-08 13:19:31', '2023-08-08 13:19:31'),
(39, 33, 1, 22, 'c', '2023-08-08 13:19:44', '2023-08-08 13:19:44'),
(40, 33, 1, 6, 'b', '2023-08-08 13:19:59', '2023-08-08 13:20:02'),
(41, 33, 1, 10, 'd', '2023-08-08 13:20:21', '2023-08-08 13:20:21'),
(42, 33, 1, 7, 'a,c,e', '2023-08-08 13:20:31', '2023-08-08 13:21:01'),
(43, 33, 1, 11, 'b', '2023-08-08 13:21:12', '2023-08-08 13:21:12'),
(44, 32, 1, 15, 'a', '2023-08-08 13:22:06', '2023-08-08 13:22:06'),
(45, 32, 1, 7, 'a,c,e', '2023-08-08 13:22:14', '2023-08-08 13:22:27'),
(46, 32, 1, 9, 'c', '2023-08-08 13:22:30', '2023-08-08 13:22:30'),
(47, 32, 1, 13, 'a,b,d', '2023-08-08 13:22:35', '2023-08-08 13:22:38'),
(48, 32, 1, 5, 'b', '2023-08-08 13:22:52', '2023-08-08 13:22:52'),
(49, 32, 1, 10, 'd', '2023-08-08 13:22:57', '2023-08-08 13:22:57'),
(50, 32, 1, 8, 'b,c,d,e', '2023-08-08 13:23:10', '2023-08-08 13:23:40'),
(51, 32, 1, 12, 'a,b,c,d,e', '2023-08-08 13:23:45', '2023-08-08 13:23:48'),
(52, 32, 1, 22, 'c', '2023-08-08 13:23:52', '2023-08-08 13:23:52'),
(53, 32, 1, 6, 'b', '2023-08-08 13:24:00', '2023-08-08 13:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `application` varchar(255) NOT NULL,
  `examName` varchar(255) NOT NULL,
  `userPassport` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `gender`, `application`, `examName`, `userPassport`, `created_at`, `update_at`) VALUES
(23, 'Daniel meeks', 'daniel_meeks1234@gmail.com', 'daniel_meeks1234', 'daniel_meeks1234', 'male', 'web designer', 'PHP', 'usersPassport/user_passport_64ce7887ebc6f.jpg', '2023-08-05 17:27:51', '2023-08-05 17:27:51'),
(24, 'Daniel freebie', 'Dani_freebie123@gmail.com', 'Dani_freebie123', 'Dani_freebie123', 'male', 'Admin II', 'PHP', 'usersPassport/user_passport_64ceda7ec59f2.jpg', '2023-08-06 00:25:50', '2023-08-06 00:25:50'),
(27, 'Ruth Kadiri', 'ruth24ever@gmail.com', 'ruth24ever', 'ruth24ever', 'female', 'Admin II', 'PHP', 'usersPassport/user_passport_64cf494ee3893.jpg', '2023-08-06 08:18:38', '2023-08-06 08:18:38'),
(28, 'Sarah Cornor', 'sara_cornor123@gmail.com', 'sara_cornor123', 'sara_cornor123', 'female', 'Accountant I', 'PHP', 'usersPassport/user_passport_64cf4af371444.jpg', '2023-08-06 08:25:39', '2023-08-06 08:25:39'),
(29, 'Kent Dock', 'kentdock1234@gmail.com', 'kentdock1234', 'kentdock1234', 'male', 'Admin II', 'PHP', 'usersPassport/kentdock123464d22e55602e6Screenshot_12.jpg', '2023-08-08 13:00:21', '2023-08-08 13:00:21'),
(30, 'Joan Greg', 'joan_greg@gmail.com', 'joan_greg1234', 'joan_greg1234', 'female', 'web designer', 'PHP', 'usersPassport/joan_greg123464d22e557928eEMMANUEL.jpg', '2023-08-08 13:00:21', '2023-08-08 13:00:21'),
(31, 'Thomas David', 'thomas_david@gmail.com', 'thomasDavid1234', 'thomasDavid1234', 'male', 'doctor', 'PHP', 'usersPassport/thomasDavid123464d22e55a5d2fScreenshot_11.jpg', '2023-08-08 13:00:21', '2023-08-08 13:00:21'),
(32, 'Frank Fletcher', 'fletcherFrank123@hotmail.com', 'fletcherFrank123', 'fletcherFrank123', 'male', 'Programmer', 'PHP', 'usersPassport/fletcherFrank12364d22e55b6399Screenshot_10.jpg', '2023-08-08 13:00:21', '2023-08-08 13:00:21'),
(36, 'Kenneth Enobakhare', 'kenenobas@gmail.com', 'ken24ever', 'osasumwen24', 'male', 'Programmer', 'PHP,maths', 'usersPassport/ken24ever64d2915506c37ken.jpg', '2023-08-08 20:02:45', '2023-08-08 20:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `users_exam`
--

CREATE TABLE `users_exam` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('pending','in_progress','completed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scores` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_exam`
--

INSERT INTO `users_exam` (`id`, `user_id`, `exam_id`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`, `scores`) VALUES
(23, 23, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-05 17:27:52', '2023-08-05 17:27:52', ''),
(24, 24, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-06 00:25:51', '2023-08-06 00:25:51', ''),
(27, 27, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-06 08:18:38', '2023-08-06 08:18:38', ''),
(28, 28, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-06 08:25:39', '2023-08-06 08:25:39', ''),
(29, 29, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-08 13:00:21', '2023-08-08 13:00:21', ''),
(30, 30, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-08 13:00:21', '2023-08-08 13:00:21', ''),
(31, 31, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-08 13:00:21', '2023-08-08 13:00:21', ''),
(32, 32, 1, '2023-08-08 13:22:02', '2023-08-08 18:58:53', 'completed', '2023-08-08 13:00:21', '2023-08-08 18:58:53', '70'),
(36, 36, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-08 20:02:45', '2023-08-08 20:02:45', ''),
(38, 36, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-08-08 20:09:01', '2023-08-08 20:09:01', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_tray`
--
ALTER TABLE `audit_tray`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_options`
--
ALTER TABLE `selected_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_exam`
--
ALTER TABLE `users_exam`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `audit_tray`
--
ALTER TABLE `audit_tray`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `selected_options`
--
ALTER TABLE `selected_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users_exam`
--
ALTER TABLE `users_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
