-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 12:53 PM
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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`, `created_at`, `update_at`) VALUES
(1, 'Kenneth Enobakhare', 'kenenobas@gmail.com', 'ken24ever', '12345678', '2023-04-17 16:50:05', '2023-04-17 16:50:05');

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
(1, 'JAVASCRIPT ECMASCRIPT', 'Javascript exam for front end developer', 60, '2023-04-19 09:06:09', '2023-07-07 12:38:28'),
(2, 'JAVASCRIPT', 'Javascript exam for front end developer', 60, '2023-04-19 09:30:37', '2023-07-07 12:38:37'),
(3, 'PHP', 'SERVER SIDE EXAM', 60, '2023-04-19 09:39:47', '2023-07-07 12:38:49'),
(8, 'ENGLISH', 'General English exam', 60, '2023-04-21 12:52:04', '2023-07-07 12:38:59'),
(105, 'JAVA', 'testing beta', 60, '2023-05-16 12:46:36', '2023-07-07 12:39:10'),
(113, 'JAMB', 'Jamb exam for secondary school leavers who wants to enroll / apply for university course..', 60, '2023-05-28 13:27:49', '2023-07-07 12:39:22'),
(114, 'Maths ', 'maths quiz', 60, '2023-06-29 00:18:06', '2023-07-09 14:59:57');

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
(1, 1, 'Inside which HTML element do we put the JavaScript?', '< script >', '< Java >', '< src >', '< crumb >', '< HEAD >', '', '', '', '', '', '', 'A', '2023-04-19 09:06:09', '2023-05-22 15:44:38'),
(2, 2, 'Where is the correct place to insert a JavaScript?', 'inside the <head> tags', 'after the closing html tag', 'both head and body section', 'the body section only', 'in-between the title tags', '', '', '', '', '', '', 'C', '2023-04-19 09:30:37', '2023-05-22 15:44:50'),
(3, 2, 'What is the correct syntax for referring to an external script called \"xxx.js\"?', '< script  src=\"xxx.js\" >< / script >', '<  script  name=\"xxx.js\" >< / script >', '< script  attr=\"xxx.js\" >< /script >', '< script  type=\"xxx.js\" >< / script >', '< script  no=\"xxx.js\" >< / script >', '', '', '', '', '', '', 'A', '2023-04-19 09:30:37', '2023-05-22 15:45:01'),
(4, 2, 'The external JavaScript file must contain the <script> tag.', 'false', 'true', 'confused', 'indifferent', 'no idea', '', '', '', '', '', '', 'A', '2023-04-19 09:30:37', '2023-05-22 15:45:11'),
(5, 2, 'How do you write \"Hello World\" in an alert box?\r\n', 'alert(hello world)', 'lert(hello world)', 'print(hello world)', 'alert(\"hello world\")', 'cin>>\"hello world\"', '', '', '', '', '', '', 'D', '2023-04-19 09:30:38', '2023-05-22 15:45:16'),
(6, 2, 'How do you create a function in JavaScript?', 'function = myfunction', 'function getAcct ()', 'function > getAcct()', 'function : bolt()', 'function => getUsers()', '', '', '', '', '', '', 'B', '2023-04-19 09:30:38', '2023-05-22 15:45:21'),
(7, 2, 'How do you call a function named \"myFunction\"?', 'call myFunction(){}', 'seek myFunction() {}', 'get myFunction()', 'come myFunction()', 'myFunction()', '', '', '', '', '', '', 'E', '2023-04-19 09:30:38', '2023-05-22 15:45:25'),
(8, 2, 'How to write an IF statement in JavaScript?', 'if == a {}', 'if ( a==b {} ', 'if (a ==b){}', 'if a==) {}', 'if (h= {}', '', '', '', '', '', '', 'C', '2023-04-19 09:30:38', '2023-05-22 15:45:28'),
(9, 2, 'How to write an IF statement for executing some code if \"i\" is NOT equal to 5?', 'if (i != 5) {}', 'if (i ==! 5) {}', 'if (i != 5', 'if (i NOT 5) {}', 'if (i == 5) {}', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-04-19 09:30:38', '2023-05-26 11:49:17'),
(10, 2, 'How does a WHILE loop start?', 'WHILE (i <=5)', 'WHILE i <=5)', 'WHILE (i <=5{', 'WHILE (i <=5}', 'WHILE {i <=5)', '', '', '', '', '', '', 'A', '2023-04-19 09:30:38', '2023-05-22 15:45:37'),
(11, 2, 'How does a FOR loop start?', 'for {i=0; kjfjkfgjfk}', 'for (i=0; i<= 5; i++)', 'for (i=0 i<= 5 i++)', 'for (i=0 i<= 5; i++}', 'for {i=0; i<= 5; i++}', '', '', '', '', '', '', 'B', '2023-04-19 09:30:38', '2023-05-22 15:45:45'),
(12, 3, 'What does PHP stand for?', 'Private Home Pile', 'Hypertext Preprocessor', 'pronzi Hmoe point', 'Hyper Prolify ', 'php', '', '', '', '', '', '', 'C', '2023-04-19 09:39:47', '2023-05-22 15:45:49'),
(13, 3, 'PHP server scripts are surrounded by delimiters, which?', '{?PHP ?}', '< ? php ? >', '< php >', '>php<', '>?php ?<', '', '', '', '', '', '', 'B', '2023-04-19 09:39:47', '2023-05-22 15:45:53'),
(14, 3, 'How do you write \"Hello World\" in PHP', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', '', '', '', '', '', '', 'C', '2023-04-19 09:39:47', '2023-05-22 15:45:57'),
(15, 3, 'All variables in PHP start with which symbol?', '#', '@', '!', '$', '&', '', '', '', '', '', '', 'D', '2023-04-19 09:39:47', '2023-05-22 15:46:01'),
(16, 3, 'What is the correct way to end a PHP statement?', 'period (.)', 'comma (,)', 'semicolon (;)', 'tida (`)', 'colon (:)', '', '', '', '', '', '', 'C', '2023-04-19 09:39:47', '2023-05-22 15:46:05'),
(27, 8, 'What is a NOUN?', 'NOUN could be defined as the name of anything', 'NOUN is the action of objects and subjects', 'NOUN is related to Verb', 'Confused with the question', 'No idea', '', '', '', '', '', '', 'A', '2023-04-21 12:52:05', '2023-05-22 15:46:08'),
(147, 105, 'lkdjfjfkfnvbvbznmxzznxkipoequeeyieywaasas', 'Private Home Pile', 'Hypertext Preprocessor', 'ajgcacgdsajdasdgj', 'Hyper Prolify ', '<crumb>', 'uploads/qimg_64636d1d0fcf42.17447724.png', 'uploads/optionA_164636d1d0fd563.04204499.png', 'uploads/optionB_164636d1d0fd5e7.34492703.png', 'uploads/optionC_164636d1d0fd620.44594711.png', 'uploads/optionD_164636d1d0fd668.36878985.png', 'uploads/optionE_164636d1d0fd692.25446156.png', 'A', '2023-05-16 12:46:37', '2023-05-22 15:46:16'),
(148, 105, 'hjsjdskjdsljdhkjfskhfsfhskfkjfssfhsfhsfhsfbsfsdn', 'HSGDKJLGJDHSJFHHFFHDJFHDJDHFDDF', '<?php ?>', 'DIUYTYYYYYEYEYEIEIEIIIEIEIEIEIE', 'LKJHGHJKKLJKHGFGIUYTDTSD', 'ksdhshvasjd', 'uploads/qimg_64636d1d0fcf42.17447724.png', 'uploads/optionA_164636d1d0fd563.04204499.png', 'uploads/optionB_164636d1d0fd5e7.34492703.png', 'uploads/optionC_164636d1d0fd620.44594711.png', 'uploads/optionD_164636d1d0fd668.36878985.png', 'uploads/optionE_164636d1d0fd692.25446156.png', 'D', '2023-05-16 12:46:37', '2023-05-22 15:46:20'),
(149, 105, 's.sklkdksjsfjjsfsfskfjsfnskfjsfsfskfjsfksfjsfjsfskfhfs', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', 'uploads/qimg_64636d1d449d02.87267736.png', '', 'uploads/optionB_364636d1d449eb4.15086474.png', '', 'uploads/optionD_364636d1d449f17.34274293.png', 'uploads/optionE_364636d1d449f77.56310234.png', 'C', '2023-05-16 12:46:37', '2023-05-22 15:46:26'),
(150, 105, 'ksldjksjdskskskjdsjidiwwuwiuejwnsdnsmndsmnd', '#skdjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjkkkkkkkkkkkkkkkkaaaaaaaaaaaaa', '@akjjkdkjdjsjkdsd', '!nn7akdjkadjdjd90893893hdsj', '$dsdsdsd', '&dffffffffffffffffffdddddddddddddd', '', '', 'uploads/optionB_464636d1d69bb51.56750943.png', '', '', '', 'C', '2023-05-16 12:46:37', '2023-05-22 15:46:30'),
(151, 105, 'jsdkjksfhsfkhfshhfksjfsfusfuisfuwihfhwfkfnjfnfsfnfn', '.sldkskdskdskdlklsdklslk', 'wowewoewowieoweiwiew', 's,dmsdsldkksdlskdjskfjsfkjfkjsfjskjfskjfs', 'lkwdkslksklfslkfsfsf', 'skfjsfhsfjsfhsfhsfjs', 'uploads/qimg_64636d1d7b4807.31573728.png', '', 'uploads/optionB_564636d1d7b48e3.42612101.png', '', '', '', 'E', '2023-05-16 12:46:37', '2023-05-22 15:46:34'),
(152, 105, 'lwjshskfjsfjsfksfjskfjsjskjlskflslf', 's,kmdsjksjsksjsfjskfskf', 'slkjjsjjskjsjkfdkjsfjfjfjfnfffbfbfbfb', 'uuweiuweweywuewyuyeuwewoeiioweio', 'skfjskjsfjsfjsjkjfkjsfhfsjhfshfhfsjhf', 'sknfncncnxcnmxcnxcnmcnbcbbvbxnns', '', '', 'uploads/optionB_664636d1d9dc719.32387174.png', '', '', 'uploads/optionE_664636d1d9dc839.13014497.png', 'D', '2023-05-16 12:46:37', '2023-05-22 15:46:37'),
(153, 8, 'jkhggjhjkjkkjjkjjkjkjkkkjjhhhh', 'skdjksfhsfhs', '<Java>', 'smndsjhfshkfs', 'jshjshjhjddjs', 'sa,jhahajashda', '', '', '', '', '', '', 'D', '2023-05-22 22:42:36', '2023-05-22 23:09:29'),
(154, 8, 'nhfhfhfh', 'skjdksjdskdjskdjs', 'skahcdadhcajjdc', 'smndsjhfshkfs', 'sbjhsjdhdsjhjas', 'sa,jhahajashda', '', '', '', '', '', '', 'B', '2023-05-22 23:08:14', '2023-05-22 23:08:14'),
(155, 3, 'The function mkdir() is used for ?', 'To read file in PHP', 'To edit a file in PHP', 'To create a new directory or folder ', 'To delete a file in PHP', 'To decode a file in PHP', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-23 10:41:19', '2023-07-09 15:25:19'),
(2794, 105, 'What does PHP stand for?', 'Private Home Pile', 'Hypertext Preprocessor', 'pronzi Hmoe point', 'Hyper Prolify ', 'php', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 11:52:39', '2023-05-24 11:52:39'),
(2795, 105, 'PHP server scripts are surrounded by delimiters, which?', '{?PHP ?}', '< ? php ? >', '< php >', '>php<', '>?php ?<', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-05-24 11:52:39', '2023-05-24 11:52:39'),
(2796, 105, 'How do you write \"Hello World\" in PHP', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 11:52:39', '2023-05-24 11:52:39'),
(2797, 105, 'All variables in PHP start with which symbol?', '#', '@', '!', '$', '&', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-05-24 11:52:40', '2023-05-24 11:52:40'),
(2798, 105, 'What is the correct way to end a PHP statement?', 'period (.)', 'comma (,)', 'semicolon (;)', 'tida (`)', 'colon (:)', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 11:52:40', '2023-05-24 11:52:40'),
(2799, 105, 'lsdffdjjkdfjdkjgndfljgfdgknldjskdafndljasfaslfknddasjsd?', 'skdjksfhsfhs', 'skdjskdjskdhsk', 'pronzi Hmoe point', 'dhksdhshkdskhd', 'sndskjdksjdjsj', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 11:52:40', '2023-05-24 11:52:40'),
(2800, 1, 'Where is the correct place to insert a JavaScript?', 'inside the <head> tags', 'after the closing html tag', 'both head and body section', 'the body section only', 'in-between the title tags', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2801, 1, 'What is the correct syntax for referring to an external script called \"xxx.js\"?', '< script  src=\"xxx.js\" >< / script >', '<  script  name=\"xxx.js\" >< / script >', '< script  attr=\"xxx.js\" >< /script >', '< script  type=\"xxx.js\" >< / script >', '< script  no=\"xxx.js\" >< / script >', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2802, 1, 'The external JavaScript file must contain the <script> tag.', 'false', 'true', 'confused', 'indifferent', 'no idea', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2803, 1, 'How do you write \"Hello World\" in an alert box?\n', 'alert(hello world)', 'lert(hello world)', 'print(hello world)', 'alert(\"hello world\")', 'cin>>\"hello world\"', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2804, 1, 'How do you create a function in JavaScript?', 'function = myfunction', 'function getAcct ()', 'function > getAcct()', 'function : bolt()', 'function => getUsers()', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2805, 1, 'How do you call a function named \"myFunction\"?', 'call myFunction(){}', 'seek myFunction() {}', 'get myFunction()', 'come myFunction()', 'myFunction()', NULL, NULL, NULL, NULL, NULL, NULL, 'E', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2806, 1, 'How to write an IF statement in JavaScript?', 'if == a {}', 'if ( a==b {} ', 'if (a ==b){}', 'if a==) {}', 'if (h= {}', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2807, 1, 'How to write an IF statement for executing some code if \"i\" is NOT equal to 5?', 'if (i != 5) {}', 'if (i ==! 5) {}', 'if (i != 5) {}', 'if (i NOT 5) {}', 'if (i == 5) {}', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2808, 1, 'How does a WHILE loop start?', 'WHILE (i <=5)', 'WHILE i <=5)', 'WHILE (i <=5{', 'WHILE (i <=5}', 'WHILE {i <=5)', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2809, 1, 'How does a FOR loop start?', 'for {i=0; kjfjkfgjfk}', 'for (i=0; i<= 5; i++)', 'for (i=0 i<= 5 i++)', 'for (i=0 i<= 5; i++}', 'for {i=0; i<= 5; i++}', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-05-24 16:46:40', '2023-05-24 16:46:40'),
(2810, 105, 'JSDJVKSDJVSKDJDSKDJSCKSJSDCJSCD', 'JSDKJSKDJSDSDKSJDSKDJSKSKKSKSKSKKK', 'SKDJSDKJSKJDSJDKSD', 'SJDHSDHSDJHSDJSDHSJDHSS', 'SKDJSDKSHDSKJDHSKJD', 'SJDKJSHDJSHDSJDHS', 'uploads/qimg_6470a819d30c03.85153174.jpg', 'uploads/optionA_16470a819d30d86.35400088.png', 'uploads/optionB_16470a819d30df3.08409243.png', '', '', '', 'C', '2023-05-26 13:37:45', '2023-05-26 13:37:45'),
(2811, 105, 'SKJDSKDJKSJFSKFJSKFJSKJFSKSKJSFKJSF', '{?PHP ?}', 'SMDNSDNSDNSDJSD', 'IKWUWRWRWYRYWSDBSBNDSNDB', 'S,DKJSKDJSDJSDKSHFSKFJF', 'SFKSFJSFJSFJSFHJF', 'uploads/qimg_6470a819f203a0.22696871.png', 'uploads/optionA_26470a819f20484.38512333.png', '', 'uploads/optionC_26470a819f204c6.58826329.png', '', '', 'E', '2023-05-26 13:37:46', '2023-05-26 13:37:46'),
(2812, 113, 'lkdjfjfkfnvbvbznmxzznxkipoequeeyieywaasas', 'Private Home Pile', 'Hypertext Preprocessor', 'ajgcacgdsajdasdgj', 'Hyper Prolify ', '<crumb>', 'uploads/qimg_64636d1d0fcf42.17447724.png', 'uploads/optionA_164636d1d0fd563.04204499.png', 'uploads/optionB_164636d1d0fd5e7.34492703.png', 'uploads/optionC_164636d1d0fd620.44594711.png', 'uploads/optionD_164636d1d0fd668.36878985.png', 'uploads/optionE_164636d1d0fd692.25446156.png', 'A', '2023-05-28 13:27:50', '2023-05-28 13:27:50'),
(2813, 113, 'hjsjdskjdsljdhkjfskhfsfhskfkjfssfhsfhsfhsfbsfsdn', 'HSGDKJLGJDHSJFHHFFHDJFHDJDHFDDF', '<?php ?>', 'DIUYTYYYYYEYEYEIEIEIIIEIEIEIEIE', 'LKJHGHJKKLJKHGFGIUYTDTSD', 'ksdhshvasjd', 'uploads/qimg_64636d1d0fcf42.17447724.png', 'uploads/optionA_164636d1d0fd563.04204499.png', 'uploads/optionB_164636d1d0fd5e7.34492703.png', 'uploads/optionC_164636d1d0fd620.44594711.png', 'uploads/optionD_164636d1d0fd668.36878985.png', 'uploads/optionE_164636d1d0fd692.25446156.png', 'D', '2023-05-28 13:27:50', '2023-05-28 13:27:50'),
(2814, 113, 's.sklkdksjsfjjsfsfskfjsfnskfjsfsfskfjsfksfjsfjsfskfhfs', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', 'uploads/qimg_64636d1d449d02.87267736.png', NULL, 'uploads/optionB_364636d1d449eb4.15086474.png', NULL, 'uploads/optionD_364636d1d449f17.34274293.png', 'uploads/optionE_364636d1d449f77.56310234.png', 'C', '2023-05-28 13:27:50', '2023-05-28 13:27:50'),
(2815, 113, 'ksldjksjdskskskjdsjidiwwuwiuejwnsdnsmndsmnd', '#skdjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjkkkkkkkkkkkkkkkkaaaaaaaaaaaaa', '@akjjkdkjdjsjkdsd', '!nn7akdjkadjdjd90893893hdsj', '$dsdsdsd', '&dffffffffffffffffffdddddddddddddd', NULL, NULL, 'uploads/optionB_464636d1d69bb51.56750943.png', NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2816, 113, 'jsdkjksfhsfkhfshhfksjfsfusfuisfuwihfhwfkfnjfnfsfnfn', '.sldkskdskdskdlklsdklslk', 'wowewoewowieoweiwiew', 's,dmsdsldkksdlskdjskfjsfkjfkjsfjskjfskjfs', 'lkwdkslksklfslkfsfsf', 'skfjsfhsfjsfhsfhsfjs', 'uploads/qimg_64636d1d7b4807.31573728.png', NULL, 'uploads/optionB_564636d1d7b48e3.42612101.png', NULL, NULL, NULL, 'E', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2817, 113, 'lwjshskfjsfjsfksfjskfjsjskjlskflslf', 's,kmdsjksjsksjsfjskfskf', 'slkjjsjjskjsjkfdkjsfjfjfjfnfffbfbfbfb', 'uuweiuweweywuewyuyeuwewoeiioweio', 'skfjskjsfjsfjsjkjfkjsfhfsjhfshfhfsjhf', 'sknfncncnxcnmxcnxcnmcnbcbbvbxnns', NULL, NULL, 'uploads/optionB_664636d1d9dc719.32387174.png', NULL, NULL, 'uploads/optionE_664636d1d9dc839.13014497.png', 'D', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2818, 113, 'What does PHP stand for?', 'Private Home Pile', 'Hypertext Preprocessor', 'pronzi Hmoe point', 'Hyper Prolify ', 'php', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2819, 113, 'PHP server scripts are surrounded by delimiters, which?', '{?PHP ?}', '< ? php ? >', '< php >', '>php<', '>?php ?<', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2820, 113, 'How do you write \"Hello World\" in PHP', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2821, 113, 'All variables in PHP start with which symbol?', '#', '@', '!', '$', '&', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2822, 113, 'What is the correct way to end a PHP statement?', 'period (.)', 'comma (,)', 'semicolon (;)', 'tida (`)', 'colon (:)', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2823, 113, 'lsdffdjjkdfjdkjgndfljgfdgknldjskdafndljasfaslfknddasjsd?', 'skdjksfhsfhs', 'skdjskdjskdhsk', 'pronzi Hmoe point', 'dhksdhshkdskhd', 'sndskjdksjdjsj', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2824, 113, 'JSDJVKSDJVSKDJDSKDJSCKSJSDCJSCD', 'JSDKJSKDJSDSDKSJDSKDJSKSKKSKSKSKKK', 'SKDJSDKJSKJDSJDKSD', 'SJDHSDHSDJHSDJSDHSJDHSS', 'SKDJSDKSHDSKJDHSKJD', 'SJDKJSHDJSHDSJDHS', 'uploads/qimg_6470a819d30c03.85153174.jpg', 'uploads/optionA_16470a819d30d86.35400088.png', 'uploads/optionB_16470a819d30df3.08409243.png', NULL, NULL, NULL, 'C', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2825, 113, 'SKJDSKDJKSJFSKFJSKFJSKJFSKSKJSFKJSF', '{?PHP ?}', 'SMDNSDNSDNSDJSD', 'IKWUWRWRWYRYWSDBSBNDSNDB', 'S,DKJSKDJSDJSDKSHFSKFJF', 'SFKSFJSFJSFJSFHJF', 'uploads/qimg_6470a819f203a0.22696871.png', 'uploads/optionA_26470a819f20484.38512333.png', NULL, 'uploads/optionC_26470a819f204c6.58826329.png', NULL, NULL, 'E', '2023-05-28 13:27:51', '2023-05-28 13:27:51'),
(2827, 114, 'What is the area of a traingle?', 'A = (1/2) * B', 'A = R2 * H', 'A = H * B', 'A = (1/2)B*H', 'A = pie * r', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-06-29 00:18:06', '2023-07-02 12:47:59'),
(2828, 114, 'A triangle with a base of 8 and height of 4. Calculate the area.', '40', '34', '12', '24', '16', NULL, NULL, NULL, NULL, NULL, NULL, 'E', '2023-06-29 00:26:40', '2023-07-02 15:18:09'),
(2829, 114, 'What is the area of a circle of radius 2. Take pie as 3.14 ?', '12.56', '12.65', '12.52', '12.43', '12.53', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-29 00:28:45', '2023-07-02 15:21:39'),
(2830, 114, '2 + 4 = ?', '3', '10', '6', '4', '7', '', '', '', '', '', '', 'C', '2023-06-29 00:28:45', '2023-06-29 00:28:45'),
(2831, 114, '20 / 4 = ?', '12', '5', '4', '10', '45', '', 'uploads/optionA_1649d5fa4f1dea2.11534618.jpg', '', '', 'uploads/optionD_1649d5fa4f1e075.49468435.jpg', 'uploads/optionE_1649d5fa4f1e0a7.89187591.jpg', 'B', '2023-06-29 11:40:37', '2023-06-29 11:40:37'),
(2832, 114, '20 / 10 = ?', '12', '5', '4', '2', '45', 'uploads/qimg_64a188ba8181b0.44213639.jpg', NULL, 'uploads/optionB_64a188ba818496.95595798.jpg', 'uploads/optionC_64a188ba8184d8.48761350.jpg', NULL, NULL, 'D', '2023-06-29 11:45:51', '2023-07-02 15:24:58'),
(2833, 114, '3 * 4 + 4 = ?', '16', '4', '-12', '13', '34', 'uploads/qimg_649eaa878c28e7.05702890.jpg', 'uploads/optionA_649eaa878c4579.19520381.jpg', NULL, 'uploads/optionC_649eaa878c46c8.71627363.jpg', 'uploads/optionD_649eaa878c4798.67450727.jpg', NULL, 'A', '2023-06-29 11:45:51', '2023-06-30 11:12:23'),
(2834, 114, 'What is the area of a rectangle?', 'A = L * B', 'L = B * A', 'B = A - L', 'A = L - B', 'F = L + B', '', '', '', '', '', '', 'A', '2023-06-29 11:50:14', '2023-06-29 11:50:14'),
(2835, 114, 'Inside which HTML element do we put the JavaScript?', '< script >', '< Java >', '< src >', '< crumb >', '< HEAD >', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2836, 114, 'Where is the correct place to insert a JavaScript?', 'inside the <head> tags', 'after the closing html tag', 'both head and body section', 'the body section only', 'in-between the title tags', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2837, 114, 'What is the correct syntax for referring to an external script called \"xxx.js\"?', '< script  src=\"xxx.js\" >< / script >', '<  script  name=\"xxx.js\" >< / script >', '< script  attr=\"xxx.js\" >< /script >', '< script  type=\"xxx.js\" >< / script >', '< script  no=\"xxx.js\" >< / script >', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2838, 114, 'The external JavaScript file must contain the <script> tag.', 'true', 'false', 'confused', 'indifferent', 'no idea', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-06-29 15:18:47', '2023-07-01 06:54:55'),
(2839, 114, 'How do you write \"Hello World\" in an alert box?\r\n', 'alert(hello world)', 'let(hello world)', 'print(hello world)', 'alert(\"hello world\")', 'cin>>\"hello world\"', 'uploads/qimg_64a189408b00d0.05424243.jpg', NULL, 'uploads/optionB_64a189408b02f8.42004347.jpg', 'uploads/optionC_64a189408b0310.80971751.jpg', NULL, NULL, 'D', '2023-06-29 15:18:47', '2023-07-02 15:27:12'),
(2840, 114, 'How do you create a function in JavaScript?', 'function = myfunction', 'function getAcct ()', 'function > getAcct()', 'function : bolt()', 'function => getUsers()', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2841, 114, 'How do you call a function named \"myFunction\"?', 'call myFunction(){}', 'seek myFunction() {}', 'get myFunction()', 'come myFunction()', 'myFunction()', NULL, NULL, NULL, NULL, NULL, NULL, 'E', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2842, 114, 'How to write an IF statement in JavaScript?', 'if == a {}', 'if ( a==b {} ', 'if (a ==b){}', 'if a==) {}', 'if (h= {}', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2843, 114, 'How to write an IF statement for executing some code if \"i\" is NOT equal to 5?', 'if (i != 5) {}', 'if (i ==! 5) {}', 'if (i != 5', 'if (i NOT 5) {}', 'if (i == 5) {}', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-29 15:18:47', '2023-07-02 15:39:13'),
(2844, 114, 'How does a WHILE loop start?', 'WHILE (i <=5)', 'WHILE i <=5)', 'WHILE (i <=5{', 'WHILE (i <=5}', 'WHILE {i <=5)', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2845, 114, 'How does a FOR loop start?', 'for {i=0; kjfjkfgjfk}', 'for (i=0; i<= 5; i++)', 'for (i=0 i<= 5 i++)', 'for (i=0 i<= 5; i++}', 'for {i=0; i<= 5; i++}', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2846, 114, 'What does PHP stand for?', 'Private Home Pile', 'Hypertext Preprocessor', 'pronzi Hmoe point', 'Hyper Prolify ', 'php', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2847, 114, 'PHP server scripts are surrounded by delimiters, which?', '{?PHP ?}', '< ? php ? >', '< php >', '>php<', '>?php ?<', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2848, 114, 'How do you write \"Hello World\" in PHP', 'document.write(\"hello world\");', 'cout>>\"hello world\";', 'echo \"hello world\";', 'show (\"hello worl\");', 'view(\"hello world\");', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2849, 114, 'All variables in PHP start with which symbol?', '#', '@', '!', '$', '&', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2850, 114, 'What is the correct way to end a PHP statement?', 'period (.)', 'comma (,)', 'semicolon (;)', 'tida (`)', 'colon (:)', NULL, NULL, NULL, NULL, NULL, NULL, 'C', '2023-06-29 15:18:47', '2023-06-29 15:18:47'),
(2851, 114, 'What is the area of a circle?', 'A = pie r2', 'R = a pie', 'Pie = A * r2', ' H = r2 * A', 'g = R2 - A', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-30 13:14:24', '2023-06-30 13:14:24'),
(2852, 114, 'What is the area of a circle?', 'A = pie r2', 'R = a pie', 'Pie = A * r2', ' H = r2 * A', 'g = R2 - A', NULL, NULL, NULL, NULL, NULL, NULL, 'A', '2023-06-30 13:14:30', '2023-06-30 13:14:30'),
(2853, 3, 'What is the correct answer to this expression $result = 4 + string ; where string is 8 ;', '12', '41', '23', '48', '45', '', '', '', '', '', '', 'D', '2023-06-30 22:18:00', '2023-06-30 22:18:00'),
(2854, 3, 'json_encoded () is used for what in a PHP script?', 'Used to import code to a file', 'Used to send data in json format as response to the client-side', 'Used to delete an encrypted file', 'Used for record or data reading', 'None of the above', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-06-30 22:26:02', '2023-07-01 06:36:16'),
(2855, 114, 'Round up this value to the nearest whole number 24.63553 ?', '25', '26', '27', '28', '29', '', '', '', '', '', '', 'A', '2023-07-02 12:12:41', '2023-07-02 12:12:41'),
(2856, 114, 'Round up this decimal value to 2 decimal places 654.59509?', '654.595', '654.505', '654.600', '654.50', '654.601', '', '', '', '', '', '', 'C', '2023-07-02 12:12:41', '2023-07-02 12:12:41'),
(2857, 114, 'What is a proper fraction ?', 'Denominator is bigger than the Numerator', 'Numerator is bigger than the denominator', 'Both are equal', 'I will go for both option A and B', 'No idea', '', '', '', '', '', '', 'A', '2023-07-02 12:26:32', '2023-07-02 12:26:32'),
(2858, 114, 'Evaluate this expression 2 of 6-4*2 ?', '6', '7', '8', '4', '10', NULL, NULL, NULL, NULL, NULL, NULL, 'D', '2023-07-02 12:26:32', '2023-07-06 14:50:50'),
(2859, 114, 'What is an improper fraction ?', 'Denominator is bigger than the Numerator', 'Numerator is bigger than the denominator', 'Both are equal', 'I will go for both option A and B', 'No idea', NULL, NULL, NULL, NULL, NULL, NULL, 'B', '2023-07-02 12:34:34', '2023-07-02 12:39:02');

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
(24, 64, 3, 12, 'b', '2023-07-07 13:53:23', '2023-07-07 13:53:23'),
(25, 2, 3, 12, 'b', '2023-07-07 13:53:27', '2023-07-07 13:53:27'),
(26, 64, 3, 13, 'b', '2023-07-07 13:53:33', '2023-07-07 13:53:33'),
(27, 64, 3, 14, 'c', '2023-07-07 13:53:51', '2023-07-07 13:53:51'),
(28, 64, 3, 15, 'd', '2023-07-07 13:54:01', '2023-07-07 13:54:01'),
(29, 64, 3, 16, 'c', '2023-07-07 13:54:11', '2023-07-07 13:54:11'),
(30, 2, 3, 13, 'd', '2023-07-07 13:54:12', '2023-07-07 13:54:12'),
(31, 64, 3, 155, 'c', '2023-07-07 13:54:21', '2023-07-07 13:54:21'),
(32, 64, 3, 2853, 'c', '2023-07-07 13:54:32', '2023-07-07 13:54:32'),
(33, 2, 3, 14, 'b', '2023-07-07 13:54:45', '2023-07-07 13:55:26'),
(34, 64, 3, 2854, 'c', '2023-07-07 13:54:46', '2023-07-07 13:54:46'),
(35, 2, 3, 15, 'c', '2023-07-07 13:55:32', '2023-07-07 13:55:32'),
(36, 64, 8, 27, 'a', '2023-07-07 13:55:43', '2023-07-07 13:55:43'),
(37, 2, 3, 16, 'c', '2023-07-07 13:55:49', '2023-07-07 13:55:49'),
(38, 2, 3, 155, 'b', '2023-07-07 13:56:29', '2023-07-07 13:56:29'),
(39, 2, 3, 2853, 'd', '2023-07-07 13:56:46', '2023-07-07 13:56:46'),
(40, 2, 3, 2854, 'b', '2023-07-07 13:56:50', '2023-07-07 13:56:50'),
(41, 64, 8, 153, 'a', '2023-07-07 13:58:24', '2023-07-07 13:58:24'),
(42, 64, 8, 154, 'c', '2023-07-07 13:58:31', '2023-07-07 13:58:31'),
(43, 4, 3, 12, 'b', '2023-07-07 13:59:53', '2023-07-07 13:59:53'),
(44, 4, 3, 13, 'b', '2023-07-07 14:00:00', '2023-07-07 14:00:00'),
(45, 2, 8, 27, 'a', '2023-07-07 14:00:00', '2023-07-07 14:00:00'),
(46, 4, 3, 14, 'c', '2023-07-07 14:00:07', '2023-07-07 14:00:07'),
(47, 4, 3, 15, 'd', '2023-07-07 14:00:11', '2023-07-07 14:00:11'),
(48, 4, 3, 16, 'c', '2023-07-07 14:00:15', '2023-07-07 14:00:15'),
(49, 4, 3, 155, 'c', '2023-07-07 14:00:24', '2023-07-07 14:00:24'),
(50, 4, 3, 2853, 'a', '2023-07-07 14:00:33', '2023-07-07 14:00:33'),
(51, 2, 8, 153, 'b', '2023-07-07 14:00:41', '2023-07-07 14:00:41'),
(52, 2, 8, 154, 'd', '2023-07-07 14:00:48', '2023-07-07 14:00:48'),
(53, 6, 3, 12, 'b', '2023-07-07 14:01:45', '2023-07-07 14:01:45'),
(54, 3, 3, 12, 'b', '2023-07-07 14:01:50', '2023-07-07 14:01:50'),
(55, 6, 3, 13, 'b', '2023-07-07 14:01:53', '2023-07-07 14:01:53'),
(56, 7, 3, 12, 'b', '2023-07-07 14:04:13', '2023-07-07 14:04:13'),
(57, 7, 3, 13, 'b', '2023-07-07 14:04:22', '2023-07-07 14:04:22'),
(58, 6, 3, 14, 'b', '2023-07-07 14:04:27', '2023-07-07 14:04:27'),
(59, 6, 3, 15, 'd', '2023-07-07 14:04:34', '2023-07-07 14:04:34'),
(60, 7, 3, 14, 'e', '2023-07-07 14:04:37', '2023-07-07 14:04:37'),
(61, 6, 3, 16, 'b', '2023-07-07 14:04:39', '2023-07-07 14:04:39'),
(62, 7, 3, 15, 'c', '2023-07-07 14:04:44', '2023-07-07 14:04:44'),
(63, 7, 3, 16, 'c', '2023-07-07 14:04:53', '2023-07-07 14:04:53'),
(64, 7, 3, 155, 'a', '2023-07-07 14:05:03', '2023-07-07 14:05:03'),
(65, 7, 3, 2853, 'e', '2023-07-07 14:05:12', '2023-07-07 14:05:12'),
(66, 7, 3, 2854, 'c', '2023-07-07 14:05:39', '2023-07-07 14:05:39'),
(67, 3, 2, 2, 'a', '2023-07-07 14:05:41', '2023-07-07 14:05:41'),
(68, 3, 2, 3, 'd', '2023-07-07 14:05:43', '2023-07-07 14:05:43'),
(69, 3, 2, 4, 'c', '2023-07-07 14:05:44', '2023-07-07 14:05:44'),
(70, 3, 2, 5, 'd', '2023-07-07 14:05:46', '2023-07-07 14:05:46'),
(71, 3, 2, 6, 'd', '2023-07-07 14:05:49', '2023-07-07 14:05:53'),
(72, 3, 2, 7, 'd', '2023-07-07 14:05:55', '2023-07-07 14:05:55'),
(73, 3, 2, 8, 'd', '2023-07-07 14:05:57', '2023-07-07 14:05:57'),
(74, 6, 3, 155, 'c', '2023-07-07 14:06:01', '2023-07-07 14:06:01'),
(75, 6, 3, 2853, 'e', '2023-07-07 14:06:05', '2023-07-07 14:06:05'),
(76, 3, 3, 13, 'c', '2023-07-07 14:06:05', '2023-07-07 14:06:05'),
(77, 3, 3, 14, 'd', '2023-07-07 14:06:10', '2023-07-07 14:06:10'),
(78, 3, 3, 15, 'b', '2023-07-07 14:06:15', '2023-07-07 14:06:15'),
(79, 3, 3, 16, 'd', '2023-07-07 14:06:19', '2023-07-07 14:06:19'),
(80, 3, 3, 155, 'd', '2023-07-07 14:06:23', '2023-07-07 14:06:23'),
(81, 3, 3, 2853, 'c', '2023-07-07 14:06:27', '2023-07-07 14:06:27'),
(82, 3, 3, 2854, 'c', '2023-07-07 14:06:32', '2023-07-07 14:06:32'),
(83, 8, 8, 153, 'c', '2023-07-07 14:12:35', '2023-07-07 14:12:35'),
(84, 2, 2, 11, 'b', '2023-07-07 14:19:45', '2023-07-07 14:19:45'),
(85, 2, 2, 10, 'a', '2023-07-07 14:19:50', '2023-07-07 14:19:50'),
(86, 2, 2, 9, 'a', '2023-07-07 14:19:54', '2023-07-07 14:19:54'),
(87, 2, 2, 8, 'd', '2023-07-07 14:20:01', '2023-07-07 14:20:01'),
(88, 2, 2, 7, 'e', '2023-07-07 14:20:06', '2023-07-07 14:20:06'),
(89, 2, 2, 6, 'b', '2023-07-07 14:20:15', '2023-07-07 14:20:15'),
(90, 2, 2, 5, 'd', '2023-07-07 14:20:18', '2023-07-07 14:20:18'),
(91, 2, 2, 4, 'a', '2023-07-07 14:20:25', '2023-07-07 14:20:25'),
(92, 2, 2, 3, 'a', '2023-07-07 14:20:32', '2023-07-07 14:20:32'),
(93, 2, 2, 2, 'c', '2023-07-07 14:20:43', '2023-07-07 14:20:43'),
(94, 5, 3, 12, 'b', '2023-07-07 14:47:40', '2023-07-07 14:47:40'),
(95, 5, 8, 27, 'a', '2023-07-07 14:48:04', '2023-07-07 14:48:04'),
(96, 5, 8, 153, 'c', '2023-07-07 14:49:06', '2023-07-07 14:49:07'),
(97, 5, 8, 154, 'c', '2023-07-07 14:49:10', '2023-07-07 14:49:10'),
(98, 5, 3, 13, 'b', '2023-07-07 14:49:19', '2023-07-07 14:49:19'),
(99, 5, 3, 14, 'c', '2023-07-07 14:49:22', '2023-07-07 14:49:22'),
(100, 5, 3, 15, 'd', '2023-07-07 14:49:25', '2023-07-07 14:49:25'),
(101, 5, 3, 16, 'c', '2023-07-07 14:49:28', '2023-07-07 14:49:28'),
(102, 5, 3, 155, 'c', '2023-07-07 14:49:38', '2023-07-07 14:49:38'),
(103, 5, 3, 2853, 'd', '2023-07-07 14:49:41', '2023-07-07 14:49:41'),
(104, 5, 3, 2854, 'b', '2023-07-07 14:49:49', '2023-07-07 14:49:49'),
(105, 5, 105, 147, 'a', '2023-07-07 14:50:53', '2023-07-07 14:50:53'),
(106, 5, 105, 148, 'e', '2023-07-07 14:51:00', '2023-07-07 14:51:00'),
(107, 5, 105, 149, 'd', '2023-07-07 14:51:03', '2023-07-07 14:51:03'),
(108, 5, 105, 150, 'b', '2023-07-07 14:51:09', '2023-07-07 14:51:09'),
(109, 5, 105, 151, 'c', '2023-07-07 14:51:15', '2023-07-07 14:51:15'),
(110, 5, 105, 2794, 'b', '2023-07-07 14:51:27', '2023-07-07 14:51:27'),
(111, 5, 105, 2795, 'b', '2023-07-07 14:51:33', '2023-07-07 14:51:33'),
(112, 5, 105, 2796, 'c', '2023-07-07 14:51:36', '2023-07-07 14:51:36'),
(113, 5, 105, 2797, 'd', '2023-07-07 14:51:40', '2023-07-07 14:51:40'),
(114, 5, 105, 2798, 'c', '2023-07-07 14:51:44', '2023-07-07 14:51:44'),
(115, 5, 105, 2799, 'c', '2023-07-07 14:51:47', '2023-07-07 14:51:47'),
(116, 5, 105, 2810, 'a', '2023-07-07 14:51:50', '2023-07-07 14:51:50'),
(117, 5, 105, 2811, 'd', '2023-07-07 14:51:57', '2023-07-07 14:51:57'),
(118, 10, 3, 12, 'b', '2023-07-07 14:52:29', '2023-07-07 14:52:29'),
(119, 10, 3, 13, 'b', '2023-07-07 14:52:32', '2023-07-07 14:52:32'),
(120, 10, 3, 14, 'c', '2023-07-07 14:52:36', '2023-07-07 14:52:36'),
(121, 10, 3, 15, 'd', '2023-07-07 14:52:39', '2023-07-07 14:52:39'),
(122, 10, 3, 16, 'c', '2023-07-07 14:52:44', '2023-07-07 14:52:44'),
(123, 10, 3, 155, 'c', '2023-07-07 14:52:51', '2023-07-07 14:52:51'),
(124, 10, 3, 2853, 'd', '2023-07-07 14:53:02', '2023-07-07 14:53:02'),
(125, 10, 3, 2854, 'b', '2023-07-07 14:53:05', '2023-07-07 14:53:05'),
(126, 10, 8, 27, 'a', '2023-07-07 14:54:35', '2023-07-07 14:54:35'),
(127, 10, 8, 153, 'b', '2023-07-07 14:54:38', '2023-07-07 14:54:38'),
(128, 10, 8, 154, 'c', '2023-07-07 14:54:41', '2023-07-07 14:54:41'),
(129, 11, 3, 12, 'b', '2023-07-07 14:56:14', '2023-07-07 14:56:14'),
(130, 11, 3, 13, 'b', '2023-07-07 14:56:18', '2023-07-07 14:56:18'),
(131, 11, 3, 14, 'c', '2023-07-07 14:56:21', '2023-07-07 14:56:21'),
(132, 11, 3, 15, 'd', '2023-07-07 14:56:24', '2023-07-07 14:56:24'),
(133, 11, 3, 16, 'c', '2023-07-07 14:56:27', '2023-07-07 14:56:27'),
(134, 11, 3, 155, 'c', '2023-07-07 14:56:31', '2023-07-07 14:56:31'),
(135, 11, 3, 2853, 'd', '2023-07-07 14:56:33', '2023-07-07 14:56:33'),
(136, 11, 3, 2854, 'b', '2023-07-07 14:56:38', '2023-07-07 14:56:38'),
(137, 9, 3, 12, 'b', '2023-07-07 14:57:32', '2023-07-07 14:57:32'),
(138, 9, 3, 13, 'b', '2023-07-07 14:57:37', '2023-07-07 14:57:37'),
(139, 9, 3, 14, 'c', '2023-07-07 14:57:51', '2023-07-07 14:57:51'),
(140, 9, 3, 15, 'd', '2023-07-07 14:57:54', '2023-07-07 14:57:54'),
(141, 9, 3, 16, 'c', '2023-07-07 14:57:56', '2023-07-07 14:57:56'),
(142, 9, 3, 155, 'c', '2023-07-07 14:57:59', '2023-07-07 14:57:59'),
(143, 9, 3, 2853, 'd', '2023-07-07 14:58:02', '2023-07-07 14:58:02'),
(144, 9, 3, 2854, 'b', '2023-07-07 14:58:05', '2023-07-07 14:58:05'),
(145, 64, 114, 2827, 'd', '2023-07-07 15:02:12', '2023-07-07 15:02:16'),
(146, 64, 114, 2828, 'e', '2023-07-07 15:02:27', '2023-07-07 15:02:27'),
(147, 64, 114, 2829, 'a', '2023-07-07 15:02:36', '2023-07-07 15:02:36'),
(148, 64, 114, 2830, 'c', '2023-07-07 15:02:39', '2023-07-07 15:02:39'),
(149, 64, 114, 2831, 'b', '2023-07-07 15:03:22', '2023-07-07 15:03:22'),
(150, 64, 114, 2832, 'd', '2023-07-07 15:03:37', '2023-07-07 15:03:37'),
(151, 64, 114, 2833, 'a', '2023-07-07 15:03:45', '2023-07-07 15:03:45'),
(152, 64, 114, 2834, 'a', '2023-07-07 15:03:52', '2023-07-07 15:03:52'),
(153, 64, 114, 2835, 'c', '2023-07-07 15:04:08', '2023-07-07 15:04:08'),
(154, 64, 114, 2836, 'a', '2023-07-07 15:04:12', '2023-07-07 15:04:12'),
(155, 64, 114, 2837, 'd', '2023-07-07 15:04:42', '2023-07-07 15:04:42'),
(156, 64, 114, 2838, 'a', '2023-07-07 15:05:05', '2023-07-07 15:05:05'),
(157, 64, 114, 2839, 'c', '2023-07-07 15:05:13', '2023-07-07 15:05:13'),
(158, 64, 114, 2840, 'a', '2023-07-07 15:05:41', '2023-07-07 15:05:56'),
(159, 64, 114, 2841, 'c', '2023-07-07 15:06:15', '2023-07-07 15:06:29'),
(160, 64, 114, 2842, 'c', '2023-07-07 15:06:44', '2023-07-07 15:06:44'),
(161, 64, 114, 2843, 'a', '2023-07-07 15:07:24', '2023-07-07 15:07:24'),
(162, 64, 114, 2844, 'e', '2023-07-07 15:08:32', '2023-07-07 15:08:32'),
(163, 64, 114, 2845, 'c', '2023-07-07 15:08:42', '2023-07-07 15:08:42'),
(164, 64, 114, 2846, 'b', '2023-07-07 15:08:47', '2023-07-07 15:08:47'),
(165, 64, 114, 2847, 'c', '2023-07-07 15:08:55', '2023-07-07 15:08:55'),
(166, 64, 114, 2848, 'e', '2023-07-07 15:09:28', '2023-07-07 15:09:28'),
(167, 64, 114, 2849, 'b', '2023-07-07 15:09:33', '2023-07-07 15:09:33'),
(168, 64, 114, 2850, 'a', '2023-07-07 15:09:58', '2023-07-07 15:09:58'),
(169, 64, 114, 2851, 'a', '2023-07-07 15:10:05', '2023-07-07 15:10:05'),
(170, 64, 114, 2852, 'a', '2023-07-07 15:10:13', '2023-07-07 15:10:13'),
(171, 64, 114, 2855, 'a', '2023-07-07 15:10:31', '2023-07-07 15:10:31'),
(172, 64, 114, 2856, 'c', '2023-07-07 15:10:51', '2023-07-07 15:10:51'),
(173, 64, 114, 2857, 'b', '2023-07-07 15:11:13', '2023-07-07 15:11:13'),
(174, 64, 114, 2858, 'd', '2023-07-07 15:11:45', '2023-07-07 15:11:45'),
(175, 64, 114, 2859, 'a', '2023-07-07 15:12:02', '2023-07-07 15:12:02'),
(181, 67, 2, 9, 'a', '2023-07-08 10:16:19', '2023-07-08 10:16:19'),
(182, 67, 2, 8, 'c', '2023-07-08 10:21:08', '2023-07-08 10:21:08'),
(183, 67, 2, 10, 'a', '2023-07-08 10:21:50', '2023-07-08 10:21:50'),
(184, 67, 2, 6, 'b', '2023-07-08 10:22:45', '2023-07-08 10:22:45'),
(188, 67, 2, 3, 'a', '2023-07-08 10:26:47', '2023-07-08 10:26:47'),
(189, 67, 2, 4, 'a', '2023-07-08 10:28:36', '2023-07-08 10:28:36'),
(190, 67, 2, 11, 'b', '2023-07-08 10:29:19', '2023-07-08 10:29:19'),
(191, 67, 2, 5, 'd', '2023-07-08 10:29:39', '2023-07-08 10:29:39'),
(192, 67, 2, 2, 'c', '2023-07-08 10:31:10', '2023-07-08 10:31:10'),
(193, 67, 2, 7, 'e', '2023-07-08 10:34:07', '2023-07-08 10:34:07'),
(207, 64, 2, 6, 'b', '2023-07-08 14:52:05', '2023-07-08 14:52:05'),
(208, 64, 2, 10, 'a', '2023-07-08 14:52:09', '2023-07-08 14:52:09'),
(209, 64, 2, 5, 'd', '2023-07-08 14:52:33', '2023-07-08 14:52:33'),
(210, 64, 2, 7, 'e', '2023-07-08 14:58:57', '2023-07-08 14:58:57'),
(211, 64, 2, 11, 'b', '2023-07-08 14:59:20', '2023-07-08 14:59:20'),
(212, 64, 2, 8, 'c', '2023-07-08 15:01:10', '2023-07-08 15:01:10'),
(213, 64, 2, 4, 'a', '2023-07-08 15:01:21', '2023-07-08 15:01:21'),
(214, 64, 2, 2, 'c', '2023-07-08 15:01:45', '2023-07-08 15:01:45'),
(215, 64, 2, 3, 'a', '2023-07-08 15:01:54', '2023-07-08 15:01:54'),
(216, 64, 2, 9, 'a', '2023-07-08 15:02:38', '2023-07-08 15:02:38'),
(217, 67, 8, 153, 'b', '2023-07-08 15:08:09', '2023-07-08 15:08:09'),
(218, 67, 8, 27, 'a', '2023-07-08 15:08:31', '2023-07-08 15:08:31'),
(219, 67, 8, 154, 'c', '2023-07-08 15:08:43', '2023-07-08 15:08:44'),
(220, 69, 3, 12, 'b', '2023-07-09 15:07:26', '2023-07-09 15:07:26'),
(221, 69, 3, 2853, 'd', '2023-07-09 15:07:42', '2023-07-09 15:07:42'),
(222, 69, 3, 16, 'c', '2023-07-09 15:08:18', '2023-07-09 15:08:18'),
(223, 69, 3, 155, 'c', '2023-07-09 15:08:23', '2023-07-09 15:08:23'),
(224, 69, 3, 13, 'b', '2023-07-09 15:08:27', '2023-07-09 15:08:27'),
(225, 69, 3, 15, 'd', '2023-07-09 15:08:31', '2023-07-09 15:08:31'),
(226, 69, 3, 14, 'c', '2023-07-09 15:08:36', '2023-07-09 15:08:36'),
(227, 69, 3, 2854, 'b', '2023-07-09 15:08:41', '2023-07-09 15:08:41'),
(228, 71, 3, 12, 'b', '2023-07-09 15:23:19', '2023-07-09 15:23:19'),
(229, 71, 3, 14, 'c', '2023-07-09 15:23:27', '2023-07-09 15:23:27'),
(230, 71, 3, 2853, 'd', '2023-07-09 15:24:00', '2023-07-09 15:24:00'),
(231, 71, 3, 155, 'c', '2023-07-09 15:24:04', '2023-07-09 15:24:04'),
(232, 71, 3, 15, 'd', '2023-07-09 15:24:10', '2023-07-09 15:24:10'),
(233, 71, 3, 13, 'b', '2023-07-09 15:26:50', '2023-07-09 15:26:50'),
(234, 71, 3, 2854, 'b', '2023-07-09 15:27:06', '2023-07-09 15:27:06'),
(235, 71, 3, 16, 'c', '2023-07-09 15:27:13', '2023-07-09 15:27:13');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `gender`, `application`, `examName`, `created_at`, `update_at`) VALUES
(2, 'Jason Igbinoba', 'json_igb@gmail.com', 'jason123', 'json123456', 'male', 'Web developer', 'PHP,JAVASCRIPT,ENGLISH', '2023-06-11 12:31:11', '2023-06-11 12:31:11'),
(3, 'Mark Thomas', 'mark_thomas@gmail.com', 'mark12345', 'mark123456', 'male', 'Web developer', 'PHP,JAVASCRIPT', '2023-06-11 12:31:12', '2023-06-11 12:31:12'),
(4, 'Patience Aigbe', 'patAigbe@hotmail.com', 'pat12345', 'pat123456', 'female', 'Web developer', 'PHP,ENGLISH', '2023-06-11 12:31:12', '2023-07-07 21:39:56'),
(5, 'Magdalane Ugiagbe', 'magd_ugia@gmail.com', 'magda12345', 'magda123456', 'female', 'Admin I', 'PHP,ENGLISH,JAVA', '2023-06-11 12:31:12', '2023-06-11 12:31:12'),
(6, 'Eseosa Frank', 'eseosaFrank@gmail.com', 'ese12345', 'ese123456', 'female', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:13', '2023-06-11 12:31:13'),
(7, 'Matthew Isaac', 'matt_isaac@hotmail.com', 'matt12345', 'matt123456', 'male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:14', '2023-06-11 12:31:14'),
(8, 'Grace Ada', 'graceada92@hotmail.com', 'Grace92', 'X#3Pq8vR', 'Female', 'Admin III', 'PHP,ENGLISH,JAVA', '2023-06-11 12:31:14', '2023-06-11 12:31:14'),
(9, 'Larry Monroe', 'larrymonroe79@hotmail.com', 'Larry79', 'Y@7Fs9kL', 'Male', 'Medical Officer', 'JAVASCRIPT ECMASCRIPT,PHP,ENGLISH', '2023-06-11 12:31:15', '2023-06-11 12:31:15'),
(10, 'Oaimhen Victory', 'oaimhenvictory45@hotmail.com', 'Victory45', 'Z%5Gt2cN', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:15', '2023-06-11 12:31:15'),
(11, 'Greteli Finchhan', 'gretelifinchhan23@hotmail.com', 'Finchhan23', 'A*6Rw1dM', 'Female', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:15', '2023-06-11 12:31:15'),
(12, 'Shwartz Blessing', 'shwartzblessing86@hotmail.com', 'Blessing86', 'B$4Hu7bP', 'Female', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:15', '2023-06-11 12:31:15'),
(13, 'Adeola Benedict', 'adeolabenedict57@hotmail.com', 'Adeola57', 'C9Jx6qSA', 'Female', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:15', '2023-06-11 12:31:15'),
(14, 'Amarachi Uyi', 'amarachiuyi64@hotmail.com', 'Uyi64', 'D!2Ly5zT', 'Female', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:16', '2023-06-11 12:31:16'),
(15, 'Wellington Favour', 'wellingtonfavour72@hotmail.com', 'Favour72', 'E&1Kp4mX', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:16', '2023-06-11 12:31:16'),
(16, 'Chelsea Dunder', 'chelseadunder09@hotmail.com', 'Chelsea09', 'F@8Nq3wR', 'Female', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:16', '2023-06-11 12:31:16'),
(17, 'Kelly Isaac', 'kellyisaac83@hotmail.com', 'Kelly83', 'G$7Ds5tE', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:17', '2023-06-11 12:31:17'),
(18, 'Osaze Miles', 'osazemiles98@gmail.com', 'Osaze98', 'H*6Wu1xQ', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:17', '2023-06-11 12:31:17'),
(19, 'Ray Chestnut', 'raychestnut41@gmail.com', 'Ray41', 'I!3Hv9yP', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:17', '2023-06-11 12:31:17'),
(20, 'Raven Willows', 'ravenwillows22@gmail.com', 'Raven22', 'J@4Kt7zG', 'Female', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:18', '2023-06-11 12:31:18'),
(21, 'Emmanuel Parker', 'emmanuelparker15@gmail.com', 'Parker15', 'K%5Xu2sB', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:18', '2023-06-11 12:31:18'),
(22, 'Will Stones', 'willstones36@gmail.com', 'Stones36', 'L8Pw5vR', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:18', '2023-06-11 12:31:18'),
(23, 'Joana Amber', 'joanaamber58@gmail.com', 'Joana58', 'M!9Gs4xQ', 'Female', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:19', '2023-06-11 12:31:19'),
(24, 'Adesina Michael', 'adesinamichael91@gmail.com', 'Adesina91', 'N#2Rt7yE', 'Male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:20', '2023-06-11 12:31:20'),
(25, 'Obaze Milan', 'obazemilan12@gmail.com', 'Milan12', 'O$7Fq4wX', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:20', '2023-06-11 12:31:20'),
(26, 'Ehis Shaftman', 'ehisshaftman75@gmail.com', 'Ehis75', 'P%5Dv2kL', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:20', '2023-06-11 12:31:20'),
(27, 'Erlich Woner', 'erlichwoner87@gmail.com', 'Erlich87', 'Q8Mx5nS', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:21', '2023-06-11 12:31:21'),
(28, 'Hilary Clinton', 'hilarylinton09@yahoo.com', 'Hillary09', 'R@4Hs7gB', 'Female', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:21', '2023-06-11 12:31:21'),
(29, 'Potus Third', 'potusthird24@yahoo.com', 'POTUS24', 'S!3Fk6wE', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:21', '2023-06-11 12:31:21'),
(31, 'Ryan Agas', 'ryanaghatize83@yahoo.com', ' Ryan83', 'U2Ws9zG', 'Male', 'Lawyer I', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:23', '2023-06-11 12:31:23'),
(32, 'Sara Imafidon', 'sara_Imafidon@gmail.com', 'sara_24', 'sara_imafidon', 'female', 'Lab technician', 'JAVASCRIPT,PHP,JAVA', '2023-06-11 12:31:23', '2023-06-11 12:31:23'),
(33, 'Ryan Adams', 'ryananthony83@yahoo.com', 'Ryan844', 'U^2Ws9zG4', 'Male', 'Accountant II', 'PHP,ENGLISH,JAVASCRIPT ECMASCRIPT', '2023-06-11 12:31:23', '2023-06-11 12:31:23'),
(34, 'Osasogie Emmanuel', 'osasogie24@gmail.com', 'osasogie1234', 'osaso1234', 'female', 'Admin II', 'maths', '2023-06-11 12:31:24', '2023-07-09 16:11:34'),
(35, 'Adams Sanchez', 'adams@gmail.com', 'adams_1234', 'adams1234', 'male', 'Physiologist II', 'PHP,JAVA,DUPLICATED JAVA', '2023-06-11 12:31:24', '2023-06-11 12:31:24'),
(36, 'Kate Dave', 'kate_dave@gmail.com', 'katie1234', 'kate12345', 'female', 'Admin II', 'JAVASCRIPT ECMASCRIPT,JAVASCRIPT,ENGLISH', '2023-06-11 12:31:24', '2023-06-11 12:31:24'),
(37, 'Uyi Moses', 'uyi1234@gmail.com', 'uyi12345', 'uyi1234', 'male', 'Admin II', 'JAVASCRIPT,JAVA,PHP', '2023-06-11 12:31:25', '2023-06-11 12:31:25'),
(38, 'Francis Osayi', 'francis123@gmail.com', 'franc12345', 'francis1234', 'male', 'Lecturer', 'PHP,JAVASCRIPT', '2023-06-11 12:31:25', '2023-06-11 12:31:25'),
(39, 'Mary Ojiekere', 'mary_ojei24@hotmail.com', 'mary_ojei1234', 'mary12345', 'female', 'director', 'ENGLISH,PHP,JAVA', '2023-06-11 12:31:25', '2023-06-11 12:31:25'),
(63, 'Fiona Samuel', 'fiona@gmail.com', 'fiona1234', 'fiona123', 'female', 'admin', 'PHP,ENGLISH,JAVASCRIPT,JAVASCRIPT ECMASCRIPT', '2023-06-29 22:34:04', '2023-06-29 22:34:04'),
(65, 'Daniel', 'dany@gmail.com', 'danny', 'danyy1234', 'male', 'web designer', 'JAVA', '2023-06-30 17:57:34', '2023-06-30 17:57:34'),
(66, 'Daniel meeks', 'meeks@gmail.com', 'meeks123', 'meeks123456', 'male', 'web designer', 'PHP,Maths ', '2023-06-30 18:25:09', '2023-06-30 18:25:09'),
(70, 'Fiona David', 'fionadave@gmail.com', 'fiona12345', 'fiona1234', 'female', 'Secretary II', 'MATHS,ENGLISH', '2023-07-09 15:05:56', '2023-07-09 15:05:56'),
(71, 'Enobakhare Kenneth ', 'kenenobas@gmail.com', 'ken24ever', 'osasumwen24', 'male', 'Web developer', 'PHP,ENGLISH,JAVASCRIPT,MATHS', '2023-07-09 15:19:52', '2023-07-09 15:19:52');

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
(3, 2, 3, '2023-07-07 13:57:10', '2023-07-07 14:56:55', 'completed', '2023-06-11 12:31:12', '2023-07-07 14:56:55', '38'),
(4, 2, 2, '2023-07-07 13:57:06', '2023-07-07 14:20:48', 'completed', '2023-06-11 12:31:12', '2023-07-07 14:20:48', '90'),
(5, 2, 8, '2023-07-07 13:59:46', '2023-07-07 15:01:01', 'completed', '2023-06-11 12:31:12', '2023-07-07 15:01:01', '34'),
(6, 3, 3, '2023-07-07 13:50:22', '2023-07-07 14:49:47', 'completed', '2023-06-11 12:31:12', '2023-07-07 14:49:47', '0'),
(7, 3, 2, '2023-07-07 13:51:45', '2023-07-07 14:51:23', 'completed', '2023-06-11 12:31:12', '2023-07-07 14:51:23', '10'),
(8, 4, 3, '2023-07-07 13:59:36', '2023-07-07 14:00:42', 'completed', '2023-06-11 12:31:12', '2023-07-07 14:00:42', '63'),
(9, 4, 8, '2023-07-07 12:49:01', '2023-07-07 12:49:02', 'pending', '2023-06-11 12:31:12', '2023-07-07 13:06:03', '0'),
(11, 5, 3, '2023-07-07 14:46:53', '2023-07-07 15:30:40', 'completed', '2023-06-11 12:31:12', '2023-07-07 15:30:40', '88'),
(12, 5, 8, '2023-07-07 14:47:52', '2023-07-07 15:31:19', 'completed', '2023-06-11 12:31:12', '2023-07-07 15:31:19', '34'),
(13, 5, 105, '2023-07-07 14:50:22', '2023-07-07 15:27:08', 'completed', '2023-06-11 12:31:12', '2023-07-07 15:27:08', '43'),
(14, 6, 3, '2023-07-07 13:56:50', '2023-07-07 14:59:41', 'completed', '2023-06-11 12:31:13', '2023-07-07 14:59:41', '38'),
(15, 6, 8, '2023-07-07 13:57:11', '2023-07-07 14:56:48', 'completed', '2023-06-11 12:31:13', '2023-07-07 14:56:48', '0'),
(16, 6, 1, '2023-07-07 13:57:24', '2023-07-07 14:33:35', 'completed', '2023-06-11 12:31:13', '2023-07-07 14:33:35', '0'),
(17, 7, 3, '2023-07-07 13:52:50', '2023-07-07 14:53:24', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:53:24', '25'),
(18, 7, 8, '2023-07-07 13:53:38', '2023-07-07 14:54:32', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:54:32', '0'),
(19, 7, 1, '2023-07-07 13:55:00', '2023-07-07 14:54:07', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:54:07', '0'),
(20, 8, 3, '2023-07-07 13:57:44', '2023-07-07 14:55:02', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:55:02', '0'),
(21, 8, 8, '2023-07-07 13:58:11', '2023-07-07 14:58:32', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:58:32', '0'),
(22, 8, 105, '2023-07-07 13:58:29', '2023-07-07 14:59:02', 'completed', '2023-06-11 12:31:14', '2023-07-07 14:59:02', '0'),
(23, 9, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(24, 9, 3, '2023-07-07 14:57:24', '2023-07-07 15:32:28', 'completed', '2023-06-11 12:31:15', '2023-07-07 15:32:28', '88'),
(25, 9, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(26, 10, 3, '2023-07-07 14:52:22', '2023-07-07 15:33:40', 'completed', '2023-06-11 12:31:15', '2023-07-07 15:33:40', '88'),
(27, 10, 8, '2023-07-07 14:53:22', '2023-07-07 14:54:45', 'completed', '2023-06-11 12:31:15', '2023-07-07 14:54:45', '34'),
(28, 10, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(29, 11, 3, '2023-07-07 14:56:04', '2023-07-07 15:34:13', 'completed', '2023-06-11 12:31:15', '2023-07-07 15:34:13', '88'),
(30, 11, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(31, 11, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(32, 12, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(33, 12, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(34, 12, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:15', '2023-06-11 12:31:15', ''),
(35, 13, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(36, 13, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(37, 13, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(38, 14, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(39, 14, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(40, 14, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(41, 15, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(42, 15, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(43, 15, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(44, 16, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(45, 16, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(46, 16, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:16', '2023-06-11 12:31:16', ''),
(47, 17, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(48, 17, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(49, 17, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(50, 18, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(51, 18, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(52, 18, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:17', '2023-06-11 12:31:17', ''),
(53, 19, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(54, 19, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(55, 19, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(56, 20, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(57, 20, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(58, 20, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(59, 21, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(60, 21, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(61, 21, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:18', '2023-06-11 12:31:18', ''),
(62, 22, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(63, 22, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(64, 22, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(65, 23, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(66, 23, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(67, 23, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:19', '2023-06-11 12:31:19', ''),
(68, 24, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(69, 24, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(70, 24, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(71, 25, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(72, 25, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(73, 25, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(74, 26, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(75, 26, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(76, 26, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:20', '2023-06-11 12:31:20', ''),
(77, 27, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(78, 27, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(79, 27, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(80, 28, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(81, 28, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(82, 28, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:21', '2023-06-11 12:31:21', ''),
(83, 29, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:22', '2023-06-11 12:31:22', ''),
(84, 29, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:22', '2023-06-11 12:31:22', ''),
(85, 29, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:22', '2023-06-11 12:31:22', ''),
(89, 31, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(90, 31, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(91, 31, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(92, 32, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(93, 32, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(94, 32, 105, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(95, 33, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(96, 33, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(97, 33, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:23', '2023-06-11 12:31:23', ''),
(100, 35, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(101, 35, 105, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(102, 35, 111, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(103, 36, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(104, 36, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(105, 36, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:24', '2023-06-11 12:31:24', ''),
(106, 37, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(107, 37, 105, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(108, 37, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(109, 38, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(110, 38, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(111, 39, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(112, 39, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(113, 39, 105, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-11 12:31:25', '2023-06-11 12:31:25', ''),
(128, 55, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 15:05:20', '2023-06-29 15:05:20', ''),
(135, 1, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 21:54:51', '2023-06-29 21:54:51', ''),
(148, 63, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 22:34:04', '2023-06-29 22:34:04', ''),
(149, 63, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 22:34:04', '2023-06-29 22:34:04', ''),
(150, 63, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 22:34:04', '2023-06-29 22:34:04', ''),
(151, 63, 1, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-29 22:34:04', '2023-06-29 22:34:04', ''),
(152, 64, 3, '2023-07-07 13:53:04', '2023-07-07 13:55:05', 'completed', '2023-06-29 22:58:56', '2023-07-07 13:55:05', '63'),
(153, 64, 8, '2023-07-07 13:55:37', '2023-07-07 13:58:42', 'completed', '2023-06-29 22:58:56', '2023-07-07 13:58:42', '34'),
(154, 64, 2, '2023-07-08 14:43:53', '2023-07-08 15:05:19', 'completed', '2023-06-29 22:58:56', '2023-07-08 15:05:19', '100'),
(159, 65, 105, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-30 17:57:34', '2023-06-30 17:57:34', ''),
(160, 66, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-06-30 18:25:09', '2023-06-30 18:25:09', ''),
(163, 67, 8, '2023-07-08 15:07:46', '2023-07-08 15:08:54', 'completed', '2023-06-30 21:58:29', '2023-07-08 15:08:54', '34'),
(165, 67, 2, '2023-07-08 10:13:22', '2023-07-08 10:34:27', 'completed', '2023-06-30 22:05:50', '2023-07-08 10:34:27', '100'),
(166, 68, 2, '2023-07-07 17:05:03', NULL, 'in_progress', '2023-07-03 22:03:11', '2023-07-07 17:05:03', ''),
(167, 68, 3, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-03 22:03:11', '2023-07-03 22:03:11', ''),
(173, 70, 114, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 15:05:56', '2023-07-09 15:05:56', ''),
(174, 70, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 15:05:56', '2023-07-09 15:05:56', ''),
(175, 71, 3, '2023-07-09 15:22:58', '2023-07-09 15:28:01', 'completed', '2023-07-09 15:19:52', '2023-07-09 15:28:01', '88'),
(176, 71, 8, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 15:19:52', '2023-07-09 15:19:52', ''),
(177, 71, 2, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 15:19:52', '2023-07-09 15:19:52', ''),
(178, 71, 114, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 15:19:52', '2023-07-09 15:19:52', ''),
(179, 34, 114, '0000-00-00 00:00:00', NULL, 'pending', '2023-07-09 16:11:34', '2023-07-09 16:11:34', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2860;

--
-- AUTO_INCREMENT for table `selected_options`
--
ALTER TABLE `selected_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `users_exam`
--
ALTER TABLE `users_exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
