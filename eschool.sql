-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2018 at 10:01 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `uid` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `role` int(11) NOT NULL,
  `class_id` int(255) NOT NULL,
  `student_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`uid`, `username`, `password`, `first_name`, `last_name`, `role`, `class_id`, `student_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'ศิริวัฒน์', 'จันทร์เก', 0, 1, 0),
(2, 'somchai', '816d44df9034790aac5ab5e91c4cbe46', 'สมชาย', 'ใจดี', 2, 2, 2147483647),
(3, 'dutsadee', '96fbdcd4f1e0ce72a2b32b2db65640f4', 'ดุษฎี', 'ศรีสองเมือง', 0, 1, 0),
(4, 'somjai', '2fd4d3e56e0130e06aef602de440a87d', 'สมใจ', 'ใจดี', 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `annoucement`
--

CREATE TABLE `annoucement` (
  `id` int(255) NOT NULL,
  `title` varchar(80) NOT NULL,
  `content` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `owner_uid` int(255) NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `annoucement`
--

INSERT INTO `annoucement` (`id`, `title`, `content`, `attachment`, `owner_uid`, `time`) VALUES
(1, 'กำหนดการติว GAT-PAT', 'กำหนดการติว GAT PAT สำหรับนักเรียนชั้น ม.6 ระหว่างวันที่ 6 - 8 และ 12 - 13 ก.พ. 61 ณ อาคารอเนกประสงค์', '0', 1, 1520754803),
(2, ' ประกาศทุนนักเรียนที่มีผลการเรียนก้าวหน้า', 'ตรวจสอบรายชื่อนักเรียนที่ได้รับทุนได้ทางระบบ e-school เว็บไซต์โรงเรียน และบอร์ดหน้าห้องกิจการนักเรียน', '0', 1, 1520754803),
(3, 'นักเรียนที่ผ่านการสอบนักธรรมศึกษาตรี โท เอกประจำปี 2557-2559', 'กำหนดการติว GAT PAT สำหรับนักเรียนชั้น ม.6 ระหว่างวันที่ 6 - 8 และ 12 - 13 ก.พ. 61 ณ อาคารอเนกประสงค์สำหรับนักเรียนที่ผ่านการสอบนักธรรมศึกษาตรี โท เอกประจำปี 2557-2559 เเละยังไม่ได้รับใบประกาศสามารถมาติดต่อรับใบประกาศนียบัตรได้ที่ห้องกลุ่มสาระสังคม', 'https://google.com', 1, 1520754803),
(4, 'นักเรียนที่ผ่านการสอบนักธรรมศึกษาตรี โท เอกประจำปี 2557-2559นักเรียนระดับชั้นม.1', '<p>ประกาศเเจ้งให้นักเรียนระดับชั้นม.1-ม.5 ตรวจสอบรายชื่อเเละให้จดเลขที่นั่งสอบ เพื่อเข้าสอบนักธรรมศึกษาตรี โท เอกประจำปี 2560 ซึ่งจะมีการสอบพร้อมกันทั่วประเทศในวันพฤหัสบดี ที่ 9 พฤศจิกายนนี้ โดยจะสอบตั้งเเต่เวลา 08.30 น. นักเรียนสามารถตรวจสอบรายชื่อได้ที่', '0', 1, 1521103150);

-- --------------------------------------------------------

--
-- Table structure for table `board_comment`
--

CREATE TABLE `board_comment` (
  `id` int(255) NOT NULL,
  `topic_id` int(255) NOT NULL,
  `comment` text NOT NULL,
  `post_by` int(255) NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `board_comment`
--

INSERT INTO `board_comment` (`id`, `topic_id`, `comment`, `post_by`, `time`) VALUES
(1, 1, 'สวัสดี', 3, 1521396075);

-- --------------------------------------------------------

--
-- Table structure for table `board_topic`
--

CREATE TABLE `board_topic` (
  `id` int(255) NOT NULL,
  `topic` varchar(120) NOT NULL,
  `content` text NOT NULL,
  `post_by` int(255) NOT NULL,
  `time` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `board_topic`
--

INSERT INTO `board_topic` (`id`, `topic`, `content`, `post_by`, `time`) VALUES
(1, 'test', '<p>testtest</p>', 1, 1521364238);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(255) NOT NULL,
  `class_name` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_name`) VALUES
(1, 'Admin'),
(2, '1/1');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(255) NOT NULL,
  `title` varchar(120) NOT NULL,
  `content` text NOT NULL,
  `post_time` int(255) NOT NULL,
  `post_by` int(255) NOT NULL,
  `title_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `content`, `post_time`, `post_by`, `title_image`) VALUES
(1, 'ทดสอบ', '<p>ทดสอบผลงานนักเรียนนะครับบบบ</p>', 1521106218, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `score_id` int(255) NOT NULL,
  `slot_id` int(255) NOT NULL,
  `score` int(3) NOT NULL,
  `score_owner` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`score_id`, `slot_id`, `score`, `score_owner`) VALUES
(1, 1, 5, 1),
(2, 3, 5, 2),
(3, 7, 8, 2),
(4, 14, 9, 2),
(5, 15, 10, 2),
(6, 16, 10, 2),
(7, 17, 10, 2),
(8, 18, 26, 2),
(9, 1, 10, 2),
(10, 3, 8, 4),
(11, 7, 9, 4),
(12, 14, 6, 4),
(13, 15, 6, 4),
(14, 16, 8, 4),
(15, 17, 8, 4),
(16, 18, 29, 4),
(17, 10, 0, 3),
(18, 10, 3, 1),
(19, 7, 8, 1),
(20, 3, 10, 1),
(21, 14, 10, 1),
(22, 15, 10, 1),
(23, 16, 10, 1),
(24, 17, 10, 1),
(25, 18, 30, 1),
(26, 3, 0, 3),
(27, 7, 0, 3),
(28, 14, 0, 3),
(29, 15, 0, 3),
(30, 16, 0, 3),
(31, 17, 0, 3),
(32, 18, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `score_slot`
--

CREATE TABLE `score_slot` (
  `slot_id` int(255) NOT NULL,
  `slot_name` varchar(20) NOT NULL,
  `full_score` int(4) NOT NULL,
  `subject_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `score_slot`
--

INSERT INTO `score_slot` (`slot_id`, `slot_name`, `full_score`, `subject_id`) VALUES
(1, 'สอบครั้งที่ 1', 0, 1),
(3, 'กิจกรรมที่ 1', 10, 7),
(4, 'ทดสอบ 1', 0, 6),
(5, 'ทดสอบ 2', 0, 6),
(6, 'ทดสอบ 3', 0, 6),
(7, 'สอบ 1', 10, 7),
(8, 'แบบฝึกหัด 1', 0, 4),
(9, 'สอบ 1', 0, 4),
(10, 'จิตพิสัย', 0, 4),
(11, 'สอบ 1', 0, 3),
(12, 'Exercise 1', 0, 2),
(13, 'Exercise 2', 0, 2),
(14, 'กิจกรรมที่ 2', 10, 7),
(15, 'สอบ 2', 10, 7),
(16, 'กิจกรรมที่ 3', 10, 7),
(17, 'สอบ 3', 10, 7),
(18, 'ปลายภาค', 30, 7);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(255) NOT NULL,
  `subject_name` varchar(20) NOT NULL,
  `subject_code` varchar(8) NOT NULL,
  `teacher_uid` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_code`, `teacher_uid`) VALUES
(1, 'ภาษาไทย', 'THA1001', 1),
(2, 'ภาษาอังกฤษ', 'ENG1001', 1),
(3, 'วิทยาศาสตร์', 'SCI1001', 1),
(4, 'คณิตศาสตร์', 'MTH1001', 1),
(5, 'สังคมศึกษา', 'SOC1001', 1),
(6, 'ศิลปะ', 'ART1001', 1),
(7, 'คอมพิวเตอร์', 'COS1001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_content`
--

CREATE TABLE `subject_content` (
  `id` int(11) NOT NULL,
  `subject_id` int(255) NOT NULL,
  `content_tab` text NOT NULL,
  `exercise_tab` text NOT NULL,
  `video_tab` text NOT NULL,
  `lesson` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_content`
--

INSERT INTO `subject_content` (`id`, `subject_id`, `content_tab`, `exercise_tab`, `video_tab`, `lesson`, `visible`) VALUES
(1, 1, '<h1><strong>บทที่ 1</strong></h1><p>การอ่านออกเสียงคำ คำคล้องจองและข้อความสั้นๆบอกความหมายของคำที่ประกอบด้วยคำพื้นฐาน ๖๐๐ คำ อ่านจับใจความ เล่าเรื่องย่อตอบคำถามเกี่ยวกับเรื่องที่อ่าน การคาดคะเนเหตุการณ์จากเรื่องที่อ่านบอกความหมายของเครื่องหมายและสัญลักษณ์ที่สำคัญ บอกและเขียนพยัญชนะ สระวรรณยุกต์และเลขไทย การเขียนสะกดคำ และเขียนข้อความสั้นๆเป็นประโยคง่ายๆด้วยการคัดลายมือตัวบรรจงเต็มบรรทัด ฟังและปฏิบัติตามคำแนะนำคำสั่งง่ายๆ ตอบคำถามและเล่าเรื่องพูดแสดงความคิดเห็นและความรู้สึกจากเรื่องที่ฟังและดู บอกข้อคิดที่ได้จากการอ่านหรือการฟังวรรณกรรม ร้อยแก้วและร้อยกรองสำหรับเด็ก พูดสื่อสารในชีวิตประจำวันใช้ทักษะการอ่าน การฟัง การดูและการพูด เพื่อให้เกิดความรู้ ความคิด ความเข้าใจเห็นคุณค่าของการอ่าน มีมารยาทในการฟัง การดู การพูด การอ่านการเขียนและนำไปใช้ในชีวิตประจำวัน</p>', '<p>test</p>', '<p>test test test test</p>', 1, 1),
(2, 1, '<h1><strong>บทที่ 2</strong></h1><p>การอ่านออกเสียงคำ คำคล้องจองและข้อความสั้นๆบอกความหมายของคำที่ประกอบด้วยคำพื้นฐาน ๖๐๐ คำ อ่านจับใจความ เล่าเรื่องย่อตอบคำถามเกี่ยวกับเรื่องที่อ่าน การคาดคะเนเหตุการณ์จากเรื่องที่อ่านบอกความหมายของเครื่องหมายและสัญลักษณ์ที่สำคัญ บอกและเขียนพยัญชนะ สระวรรณยุกต์และเลขไทย การเขียนสะกดคำ และเขียนข้อความสั้นๆเป็นประโยคง่ายๆด้วยการคัดลายมือตัวบรรจงเต็มบรรทัด ฟังและปฏิบัติตามคำแนะนำคำสั่งง่ายๆ ตอบคำถามและเล่าเรื่องพูดแสดงความคิดเห็นและความรู้สึกจากเรื่องที่ฟังและดู บอกข้อคิดที่ได้จากการอ่านหรือการฟังวรรณกรรม ร้อยแก้วและร้อยกรองสำหรับเด็ก พูดสื่อสารในชีวิตประจำวันใช้ทักษะการอ่าน การฟัง การดูและการพูด เพื่อให้เกิดความรู้ ความคิด ความเข้าใจเห็นคุณค่าของการอ่าน มีมารยาทในการฟัง การดู การพูด การอ่านการเขียนและนำไปใช้ในชีวิตประจำวัน</p>', '<p>test</p>', '<p>test test test test</p>', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_describe`
--

CREATE TABLE `subject_describe` (
  `id` int(255) NOT NULL,
  `subject_id` int(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_describe`
--

INSERT INTO `subject_describe` (`id`, `subject_id`, `content`) VALUES
(1, 1, '<p>คำอธิบายของวิชาคอมพิวเตอร์นะอิอิ</p>');

-- --------------------------------------------------------

--
-- Table structure for table `testbank`
--

CREATE TABLE `testbank` (
  `id` int(255) NOT NULL,
  `test_title` varchar(100) NOT NULL,
  `test_subject` int(255) NOT NULL,
  `slot_id` int(255) NOT NULL,
  `onetime` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testbank`
--

INSERT INTO `testbank` (`id`, `test_title`, `test_subject`, `slot_id`, `onetime`, `visible`) VALUES
(1, 'แบบทดสอบ 1', 1, 1, 1, 1),
(2, 'ข้อสอบก่อนเรียนรายวิชาคอมพิวเตอร์', 7, 7, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testbank_answer`
--

CREATE TABLE `testbank_answer` (
  `aid` int(255) NOT NULL,
  `question_id` int(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testbank_answer`
--

INSERT INTO `testbank_answer` (`aid`, `question_id`, `answer`, `is_correct`) VALUES
(1, 1, 'ไก่จะได้สวย', 1),
(2, 1, 'ไก่กาก', 0),
(3, 1, 'ไก่พิการ', 0),
(4, 2, 'ไก่จะได้สวย', 1),
(5, 2, 'ไก่กาก', 0),
(6, 2, 'ไก่พิการ', 0),
(7, 3, 'ก. เครื่องที่ช่วยชีวิต', 0),
(8, 3, 'ข. เครื่องอำนวยความสะดวก', 0),
(9, 3, 'ค. เครื่องช่วยหายใจ', 0),
(10, 3, 'ง. เครื่องคิดคำนวณ', 0),
(11, 3, 'จ. เครื่องๆ', 0),
(12, 3, 'ฉ. ถูกทุกข้อ', 1),
(13, 4, 'ก. 1', 0),
(14, 4, 'ข. 2', 0),
(15, 4, 'ค. 3', 0),
(16, 4, 'ง. 4', 1),
(17, 4, 'จ. 5', 0),
(18, 5, 'ก. 4', 0),
(19, 5, 'ข. 5', 0),
(20, 5, 'ค. 1', 0),
(21, 5, 'ง. -1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testbank_history`
--

CREATE TABLE `testbank_history` (
  `id` int(255) NOT NULL,
  `owner_id` int(255) NOT NULL,
  `test_id` int(255) NOT NULL,
  `time` int(255) NOT NULL,
  `score` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testbank_history`
--

INSERT INTO `testbank_history` (`id`, `owner_id`, `test_id`, `time`, `score`) VALUES
(1, 1, 1, 1521311314, 3),
(2, 3, 2, 1521387008, 0);

-- --------------------------------------------------------

--
-- Table structure for table `testbank_question`
--

CREATE TABLE `testbank_question` (
  `qid` int(255) NOT NULL,
  `question` text NOT NULL,
  `test_id` int(255) NOT NULL,
  `score` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testbank_question`
--

INSERT INTO `testbank_question` (`qid`, `question`, `test_id`, `score`) VALUES
(1, 'ทำไมนกถึงมีขน', 1, 2),
(2, 'ทำไมขนไก่สีแดง', 1, 1),
(3, '1.คอมพิวเตอร์คือข้อใด', 2, 1),
(4, '2.ลักษณะของคอมพิวเตอร์แบ่งได้กี่แบบ', 2, 1),
(5, '3. 3-4 = ?', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `annoucement`
--
ALTER TABLE `annoucement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_comment`
--
ALTER TABLE `board_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_topic`
--
ALTER TABLE `board_topic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`score_id`);

--
-- Indexes for table `score_slot`
--
ALTER TABLE `score_slot`
  ADD PRIMARY KEY (`slot_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_content`
--
ALTER TABLE `subject_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_describe`
--
ALTER TABLE `subject_describe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testbank`
--
ALTER TABLE `testbank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testbank_answer`
--
ALTER TABLE `testbank_answer`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `testbank_history`
--
ALTER TABLE `testbank_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testbank_question`
--
ALTER TABLE `testbank_question`
  ADD PRIMARY KEY (`qid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `uid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `annoucement`
--
ALTER TABLE `annoucement`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `board_comment`
--
ALTER TABLE `board_comment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `board_topic`
--
ALTER TABLE `board_topic`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `score_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `score_slot`
--
ALTER TABLE `score_slot`
  MODIFY `slot_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `subject_content`
--
ALTER TABLE `subject_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `subject_describe`
--
ALTER TABLE `subject_describe`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `testbank`
--
ALTER TABLE `testbank`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `testbank_answer`
--
ALTER TABLE `testbank_answer`
  MODIFY `aid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `testbank_history`
--
ALTER TABLE `testbank_history`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `testbank_question`
--
ALTER TABLE `testbank_question`
  MODIFY `qid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
