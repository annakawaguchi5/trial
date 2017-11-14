-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017 年 11 朁E13 日 06:29
-- サーバのバージョン： 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trial`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_adjustskd`
--

CREATE TABLE `tb_adjustskd` (
  `receiverid` varchar(16) NOT NULL,
  `requestid` int(11) NOT NULL,
  `optid` int(11) NOT NULL,
  `possibility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_adjustskd`
--

INSERT INTO `tb_adjustskd` (`receiverid`, `requestid`, `optid`, `possibility`) VALUES
('14JK999', 23, 0, 1),
('14JK999', 23, 1, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_department`
--

CREATE TABLE `tb_department` (
  `did` varchar(3) NOT NULL,
  `dname` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_department`
--

INSERT INTO `tb_department` (`did`, `dname`) VALUES
('a', 'なし'),
('aa', '芸術学部美術学科'),
('ac', '商学部第二部商学科'),
('ad', '芸術学部デザイン学科'),
('af', '芸術学部芸術表現学科'),
('al', '芸術学部生活環境デザイン学科'),
('am', '芸術学部写真・映像メディア学科'),
('ap', '芸術学部写真映像学科'),
('as', '芸術学部ソーシャルデザイン学科'),
('at', '芸術学部'),
('av', '芸術学部ビジュアルデザイン学科'),
('cc', '商学部第一部商学科'),
('ct', '商学部第一部観光産業学科'),
('ee', '経済学部経済学科'),
('es', '経済学部'),
('jk', '情報科学部情報科学科'),
('kk', '国際文化学部国際文化学科'),
('kn', '国際文化学部日本文化学科'),
('kr', '国際文化学部臨床心理学科'),
('ll', '生命科学部生命科学科'),
('mi', '経営学部国際経営学科'),
('mm', '経営学部産業経営学科'),
('r', '理工学部,'),
('re', '理工学部電気工学科'),
('rm', '理工学部機械工学科'),
('rs', '理工学部情報科学科'),
('ta', '工学部建築学科'),
('tb', '工学部バイオロボティクス学科'),
('tc', '工学部物質生命化学科'),
('td', '工学部都市基盤デザイン工学科'),
('te', '工学部電気情報工学科'),
('th', '工学部住居・インテリア設計学科'),
('tm', '工学部機械工学科'),
('ua', '建築都市工学部建築学科'),
('ud', '建築都市工学部都市デザイン工学科'),
('uh', '建築都市工学部住居・インテリア学');

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_image`
--

CREATE TABLE `tb_image` (
  `imgid` int(11) NOT NULL,
  `userid` varchar(32) NOT NULL,
  `mime` varchar(32) NOT NULL,
  `uptime_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_image`
--

INSERT INTO `tb_image` (`imgid`, `userid`, `mime`, `uptime_at`) VALUES
(1, '15TM000', 'png', '2017-11-08 08:03:16');

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_ngword`
--

CREATE TABLE `tb_ngword` (
  `ngid` int(11) NOT NULL,
  `ngword` varchar(32) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_ngword`
--

INSERT INTO `tb_ngword` (`ngid`, `ngword`, `weight`) VALUES
(1, 'レポート', 4),
(2, '代行', 3),
(3, '出席', 3),
(4, '代わり', 3),
(5, '死ね', 5),
(6, '殺す', 5),
(7, '馬鹿', 4),
(8, 'バカ', 4);

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_point`
--

CREATE TABLE `tb_point` (
  `pid` bigint(20) UNSIGNED NOT NULL,
  `daytime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userid` varchar(16) NOT NULL,
  `detail` text NOT NULL,
  `pchange` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_point`
--

INSERT INTO `tb_point` (`pid`, `daytime`, `userid`, `detail`, `pchange`) VALUES
(25, '2015-10-13 07:36:23', '10jk083', 'ポイントチャージ', 100),
(29, '2015-10-13 08:02:05', '10jk083', 'ポイント利用', -100),
(30, '2015-10-13 08:02:34', '10jk083', 'ポイントチャージ', 300),
(45, '2015-10-15 02:47:00', '10jk083', 'ポイント利用', -200),
(46, '2015-10-20 06:04:55', '10jk083', 'ポイントチャージ', 200),
(47, '2015-10-20 06:05:33', '10jk083', 'ポイント利用', -200),
(56, '2015-10-20 06:27:57', '12jk200', '支払い', -500),
(57, '2015-10-20 06:27:57', '11jk200', '収入', 500),
(58, '2015-10-20 06:30:22', '12jk200', '支払い', -50),
(59, '2015-10-20 06:30:22', '10jk083', '収入', 50),
(60, '2015-10-20 06:30:22', '12jk200', '支払い', -50),
(61, '2015-10-20 06:30:22', '10jk200', '収入', 50),
(62, '2015-11-12 02:49:41', '10jk083', 'ポイントチャージ', 300),
(63, '2015-11-16 06:06:18', '12jk200', '支払い', -500),
(64, '2015-11-16 06:06:18', '11jk200', '収入', 500),
(65, '2015-11-17 06:40:10', '12jk200', 'ポイントチャージ', 1200),
(66, '2015-11-19 02:54:02', '13jk200', 'ポイントチャージ', 1000),
(67, '2015-11-19 02:54:38', '13jk200', 'ポイント利用', -500),
(68, '2015-12-10 01:58:27', '12jk200', 'ポイント利用', -50),
(69, '2015-12-11 06:54:43', '12jk200', 'ポイントチャージ', 100),
(70, '2015-12-11 06:58:24', '12jk200', 'ポイントチャージ', 200),
(71, '2015-12-17 00:18:49', '12jk200', '支払い', -500),
(72, '2015-12-17 00:18:49', '12jk200', '収入', 500),
(73, '2015-12-17 00:38:34', '12jk200', '支払い', -200),
(74, '2015-12-17 00:38:34', '12jk200', '収入', 200),
(75, '2015-12-17 00:40:36', '12jk200', 'ポイント利用', -300),
(76, '2015-12-17 00:41:13', '12jk200', 'ポイントチャージ', 300),
(83, '2016-01-27 01:59:39', '10jk083', 'ポイントチャージ', 100),
(120, '2017-01-24 14:41:09', '13jk050', '支払い', -500),
(121, '2017-01-24 14:41:09', '10jk083', '収入', 500),
(122, '2017-01-24 14:41:09', '13jk050', '支払い', -500),
(123, '2017-01-24 14:41:09', '11jk200', '収入', 500),
(124, '2017-01-24 14:41:09', '13jk050', '支払い', -500),
(125, '2017-01-24 14:41:09', '12jk200', '収入', 500),
(126, '2017-01-24 15:02:27', '13jk050', '支払い', -500),
(127, '2017-01-24 15:02:27', '10jk083', '収入', 500),
(128, '2017-01-24 15:02:27', '13jk050', '支払い', -500),
(129, '2017-01-24 15:02:27', '10jk083', '収入', 500),
(130, '2017-01-24 15:02:27', '13jk050', '支払い', -500),
(131, '2017-01-24 15:02:27', '12jk200', '収入', 500),
(132, '2017-01-24 23:54:00', '13jk050', '支払い', -500),
(133, '2017-01-24 23:54:00', '10jk083', '収入', 500),
(134, '2017-01-24 23:54:00', '13jk050', '支払い', -500),
(135, '2017-01-24 23:54:00', '10jk083', '収入', 500),
(136, '2017-01-24 23:54:00', '13jk050', '支払い', -500),
(137, '2017-01-24 23:54:00', '11jk200', '収入', 500),
(138, '2017-01-25 00:06:26', '13jk050', '支払い', -500),
(139, '2017-01-25 00:06:26', '10jk083', '収入', 500),
(140, '2017-01-25 00:06:26', '13jk050', '支払い', -500),
(141, '2017-01-25 00:06:26', '10jk083', '収入', 500),
(142, '2017-01-25 00:06:26', '13jk050', '支払い', -500),
(143, '2017-01-25 00:06:26', '11jk200', '収入', 500),
(144, '2017-01-25 00:16:06', '13jk050', '支払い', -500),
(145, '2017-01-25 00:16:06', '10jk083', '収入', 500),
(146, '2017-01-25 00:16:06', '13jk050', '支払い', -500),
(147, '2017-01-25 00:16:06', '10jk083', '収入', 500),
(148, '2017-01-25 00:16:06', '13jk050', '支払い', -500),
(149, '2017-01-25 00:16:06', '11jk200', '収入', 500),
(150, '2017-01-25 00:34:00', '13jk050', '支払い', -500),
(151, '2017-01-25 00:34:01', '10jk083', '収入', 500),
(152, '2017-01-25 00:34:01', '13jk050', '支払い', -500),
(153, '2017-01-25 00:34:01', '10jk083', '収入', 500),
(154, '2017-01-25 00:34:01', '13jk050', '支払い', -500),
(155, '2017-01-25 00:34:01', '11jk200', '収入', 500),
(156, '2017-01-25 02:30:51', '13jk050', '支払い', -500),
(157, '2017-01-25 02:30:51', '10jk083', '収入', 500),
(158, '2017-01-25 02:30:51', '13jk050', '支払い', -500),
(159, '2017-01-25 02:30:51', '10jk083', '収入', 500),
(160, '2017-01-25 02:30:52', '13jk050', '支払い', -500),
(161, '2017-01-25 02:30:52', '11jk200', '収入', 500),
(162, '2017-07-12 02:44:43', '10jk083', '支払い', -500),
(163, '2017-07-12 02:44:43', '11jk200', '収入', 500),
(164, '2017-07-12 02:44:43', '10jk083', '支払い', -500),
(165, '2017-07-12 02:44:43', '12jk200', '収入', 500),
(169, '2017-09-29 08:34:47', '14JK999', '初回ポイント', 500);

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_receive`
--

CREATE TABLE `tb_receive` (
  `requestid` int(11) NOT NULL,
  `userid` varchar(32) NOT NULL,
  `dgresult` int(11) DEFAULT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `fileid` varchar(32) DEFAULT NULL,
  `mime` varchar(32) DEFAULT NULL,
  `optid` int(11) DEFAULT NULL,
  `rday` datetime NOT NULL,
  `eday` datetime DEFAULT NULL,
  `updatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- テーブルのデータのダンプ `tb_receive`
--

INSERT INTO `tb_receive` (`requestid`, `userid`, `dgresult`, `comment`, `fileid`, `mime`, `optid`, `rday`, `eday`, `updatetime`) VALUES
(3, '15TM000', NULL, 'あああ', '9', 'jpg', NULL, '2017-07-01 00:00:00', '2017-11-08 16:55:31', '2017-11-08 07:55:31'),
(3, '16KK000', NULL, 'こちらはいかがですか？', '8', 'jpg', NULL, '2017-07-01 00:00:00', '2017-09-22 16:10:00', '2017-09-22 07:10:00'),
(6, '16KK000', NULL, NULL, '0', NULL, NULL, '2017-07-01 00:00:00', '2017-10-17 16:10:00', '2017-10-17 09:02:23'),
(4, '16KK000', NULL, NULL, '1', NULL, NULL, '2017-07-01 00:00:00', '2017-10-21 23:59:00', '2017-10-17 10:56:16');

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_report`
--

CREATE TABLE `tb_report` (
  `repid` int(11) NOT NULL,
  `requestid` int(11) NOT NULL,
  `kind` int(11) NOT NULL,
  `reason` text,
  `reporter` char(16) DEFAULT NULL,
  `insp` int(11) DEFAULT '0',
  `cancelnum` int(11) NOT NULL DEFAULT '0',
  `JudgeA` int(11) NOT NULL DEFAULT '0',
  `JudgeB` int(11) NOT NULL DEFAULT '0',
  `JudgeC` int(11) NOT NULL DEFAULT '0',
  `result` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_report`
--

INSERT INTO `tb_report` (`repid`, `requestid`, `kind`, `reason`, `reporter`, `insp`, `cancelnum`, `JudgeA`, `JudgeB`, `JudgeC`, `result`) VALUES
(1, 1, 0, 'あいうえお', '14JK000', 3, 2, -1, -1, 1, 2),
(2, 4, 0, '中傷する用語が含まれている。', '15TM000', 0, 0, 0, 0, 0, 0),
(3, 15, 5, '内容が意味不明', '14JK999', 2, 0, 1, 1, 0, 1),
(4, 15, 5, '内容が意味不明', '14JK999', 2, 2, -1, -1, 0, 2),
(5, 6, 0, '代行出席は違反だと思います。', '16KK000', 2, 2, 0, -1, -1, 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_request`
--

CREATE TABLE `tb_request` (
  `requestid` int(11) NOT NULL,
  `rname` varchar(128) NOT NULL,
  `sdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `contents` varchar(1000) NOT NULL,
  `point` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `perficient` int(11) DEFAULT NULL,
  `amethod` int(11) NOT NULL,
  `requserid` varchar(16) NOT NULL,
  `rpoint` int(11) NOT NULL,
  `outsider` varchar(32) DEFAULT NULL,
  `category` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_request`
--

INSERT INTO `tb_request` (`requestid`, `rname`, `sdate`, `edate`, `contents`, `point`, `state`, `perficient`, `amethod`, `requserid`, `rpoint`, `outsider`, `category`) VALUES
(1, 'ポスター作成', '2017-07-23 00:00:00', '2017-07-31 18:00:00', '香椎際のポスターデザインをお願いします。', 500, 3, 2, 1, '14JK000', 250, NULL, 2),
(3, '学内の写真がほしいです！！', '2017-11-01 00:00:00', '2017-11-15 18:00:00', 'はじめまして\r\nHPを作成しており、学文祭の写真を使いたいと考えています。\r\nお持ちの方はご協力お願いします。', 100, 2, 1, 2, '14JK000', 100, 'NULL', 2),
(4, 'イベント企画', '2017-07-01 00:00:00', '2017-10-21 23:59:00', '新イベントのアイデアを募集します。\r\n馬鹿でもできる仕事なので、どしどしご応募ください！', 500, 2, 5, 1, '14JK000', 100, 'NULL', 2),
(6, 'Webプロの代行出席', '2017-07-26 00:00:00', '2017-07-31 15:00:00', '今週の火曜4限にあるWebプロのデータをください。', 200, -1, 1, 2, '14JK000', 200, 'NULL', 2),
(25, '【ライティング】オアシスの紹介文を書いてください。', '2017-11-03 00:00:00', '2017-11-06 00:00:00', '中央会館1階にあるオアシスを記事にしたいと考えています。<br />\r\nそこで、オアシスの良い点やお勧めポイントなどを教えて下さい。<br />\r\n字数は30文字以上50文字以下でお願いします。', 300, 0, 3, 3, '14JK000', 100, NULL, 2),
(15, 'abc', '2017-10-16 03:35:00', '2017-10-17 03:35:00', '123', 200, -1, 2, 1, '14JK999', 100, 'NULL', 1),
(26, '本を届けるお仕事', '2017-11-14 00:00:00', '2017-11-16 23:59:00', 'スケジュールが合わない為、代わりに本を返して来てください。<br />\r\n【14JK999　橋本さん】に本を3冊渡してください。<br />\r\n平日の昼休みに12号館ロビーにて受け渡しをお願いします。<br />\r\n詳細な日程は相談の上、決定します。', 300, 2, 1, 2, '14JK000', 300, NULL, 1),
(24, '通訳(英語)をお願いします。', '2017-10-18 21:00:00', '2017-10-18 22:00:00', '来週、海外から友人（女性）が来るのですが、私は英語ができません。 そこで、英語の通訳ができる方を探しています。 よろしくお願いします。 ', 500, 2, 2, 3, '14JK000', 250, 'なし', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_schedule`
--

CREATE TABLE `tb_schedule` (
  `sid` int(11) NOT NULL,
  `requestid` int(11) NOT NULL,
  `optid` int(11) NOT NULL,
  `stime` datetime DEFAULT NULL,
  `etime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_schedule`
--

INSERT INTO `tb_schedule` (`sid`, `requestid`, `optid`, `stime`, `etime`) VALUES
(1, 15, 0, '2017-10-17 09:00:00', '2017-10-17 12:00:00'),
(2, 15, 1, '2017-10-18 12:00:00', '2017-10-18 15:00:00'),
(3, 15, 2, '2017-10-19 15:00:00', '2017-10-19 18:00:00'),
(17, 23, 0, '2017-10-21 13:00:00', '2017-10-21 16:00:00'),
(18, 23, 1, '2017-10-22 09:00:00', '2017-10-22 12:00:00'),
(19, 24, 0, '2017-10-28 09:00:00', '2017-10-28 12:00:00'),
(20, 24, 1, '2017-10-29 12:00:00', '2017-10-29 15:00:00'),
(21, 26, 0, '2017-11-06 12:10:00', '2017-11-06 13:00:00'),
(22, 26, 1, '2017-11-07 12:10:00', '2017-11-07 13:00:00'),
(23, 26, 2, '2017-11-08 12:10:00', '2017-11-08 13:00:00'),
(24, 26, 3, '2017-11-09 12:10:00', '2017-11-09 13:00:00'),
(25, 26, 4, '2017-11-10 12:10:00', '2017-11-10 13:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_upfile`
--

CREATE TABLE `tb_upfile` (
  `fileid` int(11) NOT NULL,
  `filename` varchar(32) NOT NULL,
  `mime` varchar(32) NOT NULL,
  `reqid` int(11) NOT NULL,
  `uploader` varchar(32) NOT NULL,
  `uptime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tb_user`
--

CREATE TABLE `tb_user` (
  `userid` varchar(7) NOT NULL,
  `passwd` varchar(16) NOT NULL,
  `uname` varchar(16) NOT NULL,
  `gender` int(11) NOT NULL,
  `birth` date NOT NULL,
  `email` varchar(32) NOT NULL,
  `dept` varchar(8) NOT NULL,
  `tel` varchar(16) NOT NULL,
  `selfintro` text NOT NULL,
  `rpoint` int(11) DEFAULT NULL,
  `post` int(11) NOT NULL,
  `auth` int(11) NOT NULL DEFAULT '1',
  `evalnum` int(11) NOT NULL,
  `goodnum` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tb_user`
--

INSERT INTO `tb_user` (`userid`, `passwd`, `uname`, `gender`, `birth`, `email`, `dept`, `tel`, `selfintro`, `rpoint`, `post`, `auth`, `evalnum`, `goodnum`, `created_at`) VALUES
('10JK083', 'abcd', '中島拓也', 1, '2017-06-27', 'aaaa@hotmali.com', 'jk', '090-1234-4567', '', 500, 1, 1, 0, 0, '0000-00-00'),
('11JK200', 'abcd', '佐藤翔太', 1, '2017-06-27', 'bbbb@gmali.com', 'te', '080-1111-1111', '', 500, 1, 1, 0, 0, '0000-00-00'),
('12AT200', 'abcd', '鈴木健太', 1, '2017-06-27', 'cccc@gmali.com', 'at', '090-2222-2222', '', 500, 1, 1, 0, 0, '0000-00-00'),
('13ES050', 'abcd', '高橋大樹', 1, '2017-06-27', 'dddd@gmail.com', 'es', '090-5555-5555', '', 500, 1, 1, 0, 0, '0000-00-00'),
('10JK200', 'abcd', '田中翼', 1, '2017-06-27', 'eeee@gmail.com', 'jk', '080-4444-4444', '', 500, 1, 1, 0, 0, '0000-00-00'),
('11JK049', 'abcd', '久保山雄介', 1, '2017-06-27', 'ffff@gmail.com', 'jk', '080-7777-7777', '', 500, 1, 1, 0, 0, '0000-00-00'),
('admin', 'abcd', '管理者', 0, '1985-08-11', 'xxxx@kyusan-u.ac.jp', 'a', '080-1111-1234', '', 0, 9, 1, 0, 0, '0000-00-00'),
('11JK006', 'abcd', '石田真悟', 1, '2017-06-27', 'gggg@gmail.com', 'jk', '080-1111-0000', '', 500, 1, 1, 0, 0, '0000-00-00'),
('cheng', 'abcd', '成先生', 1, '2017-06-27', 'cheng@1234.com', 'jk', '1234', '', 500, 2, 1, 0, 0, '0000-00-00'),
('jkjimu', 'abcd', '理工学部事務室', 0, '0000-00-00', 'jkjimu@abc.com', 'r', '5413', '', NULL, 5, 1, 0, 0, '2017-06-27'),
('14JK000', 'abcd', '福本彩香', 2, '1996-03-11', 'hhhh@gmail.com', 'jk', '080-3333-3333', '', 500, 1, 1, 3, 2, '2017-07-31'),
('15TM000', 'abcd', '藤井大樹', 1, '1996-07-18', 'iiii@gmail.com', 'tm', '080-6666-6666', '', 500, 1, 1, 0, 0, '2017-06-27'),
('16KK000', 'abcd', '杉山圭太郎', 1, '2017-06-27', 'jjjj@gmail.com', 'kk', '080-8888-8888', '', 500, 1, 1, 0, 0, '0000-00-00'),
('17LL000', 'abcd', '緒方美穂', 2, '1998-11-21', 'kkkk@gmail.com', 'll', '080-9999-9999', '', 500, 1, 0, 0, 0, '2017-06-27'),
('makino', 'abcd', '牧野秀隆', 1, '1966-04-29', 'llll@gmail.com', 'jk', '080-1111-2222', '', 500, 2, 1, 0, 0, '2017-06-27'),
('tomioka', 'abcd', '富岡幸子', 2, '2017-06-27', 'mmmm@gmail.com', 'ee', '080-1111-3333', '', 500, 2, 1, 0, 0, '0000-00-00'),
('JudgeA', 'abcd', '審査員A', 0, '0000-00-00', 'judgea@abc.com', 'a', '0000-00-0000', '', NULL, 8, 1, 0, 0, '0000-00-00'),
('JudgeB', 'abcd', '審査員B', 0, '0000-00-00', 'judgeb@abc.com', 'a', '1111-11-1111', '', NULL, 8, 1, 0, 0, '0000-00-00'),
('JudgeC', 'abcd', '審査員C', 0, '0000-00-00', 'judgec@abc.com', 'a', '2222-22-2222', '', NULL, 8, 1, 0, 0, '0000-00-00'),
('14JK999', 'abcd', '橋本菜々子', 2, '1996-02-19', 'mmmm@st.kyusan-u.ac.jp', 'af', '000-0000-0000', '絵をかくのが得意です。', 500, 1, 1, 0, 0, '2017-06-27');

-- --------------------------------------------------------

--
-- ビュー用の代替構造 `vw_report`
-- (See below for the actual view)
--
CREATE TABLE `vw_report` (
);

-- --------------------------------------------------------

--
-- ビュー用の代替構造 `vw_user`
-- (See below for the actual view)
--
CREATE TABLE `vw_user` (
`userid` varchar(7)
,`passwd` varchar(16)
,`uname` varchar(16)
,`gender` int(11)
,`birth` date
,`email` varchar(32)
,`dept` varchar(8)
,`tel` varchar(16)
,`selfintro` text
,`rpoint` int(11)
,`post` int(11)
,`auth` int(11)
,`evalnum` int(11)
,`goodnum` int(11)
,`created_at` date
,`did` varchar(3)
,`dname` varchar(16)
);

-- --------------------------------------------------------

--
-- ビュー用の構造 `vw_report`
--
DROP TABLE IF EXISTS `vw_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_report`  AS  select `tb_report`.`requestid` AS `requestid`,`tb_report`.`kind` AS `kind`,`tb_report`.`reason` AS `reason`,`tb_report`.`reporter` AS `reporter`,`tb_report`.`insp` AS `insp`,`tb_report`.`judge` AS `judge` from `tb_report` ;

-- --------------------------------------------------------

--
-- ビュー用の構造 `vw_user`
--
DROP TABLE IF EXISTS `vw_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user`  AS  select `tb_user`.`userid` AS `userid`,`tb_user`.`passwd` AS `passwd`,`tb_user`.`uname` AS `uname`,`tb_user`.`gender` AS `gender`,`tb_user`.`birth` AS `birth`,`tb_user`.`email` AS `email`,`tb_user`.`dept` AS `dept`,`tb_user`.`tel` AS `tel`,`tb_user`.`selfintro` AS `selfintro`,`tb_user`.`rpoint` AS `rpoint`,`tb_user`.`post` AS `post`,`tb_user`.`auth` AS `auth`,`tb_user`.`evalnum` AS `evalnum`,`tb_user`.`goodnum` AS `goodnum`,`tb_user`.`created_at` AS `created_at`,`tb_department`.`did` AS `did`,`tb_department`.`dname` AS `dname` from (`tb_user` join `tb_department`) where (`tb_user`.`dept` = `tb_department`.`did`) order by `tb_user`.`post` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_department`
--
ALTER TABLE `tb_department`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `tb_image`
--
ALTER TABLE `tb_image`
  ADD PRIMARY KEY (`imgid`);

--
-- Indexes for table `tb_ngword`
--
ALTER TABLE `tb_ngword`
  ADD PRIMARY KEY (`ngid`),
  ADD UNIQUE KEY `ngid` (`ngid`);

--
-- Indexes for table `tb_point`
--
ALTER TABLE `tb_point`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `pid` (`pid`);

--
-- Indexes for table `tb_receive`
--
ALTER TABLE `tb_receive`
  ADD UNIQUE KEY `fileid` (`fileid`);

--
-- Indexes for table `tb_report`
--
ALTER TABLE `tb_report`
  ADD PRIMARY KEY (`repid`);

--
-- Indexes for table `tb_request`
--
ALTER TABLE `tb_request`
  ADD PRIMARY KEY (`requestid`);

--
-- Indexes for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tb_upfile`
--
ALTER TABLE `tb_upfile`
  ADD PRIMARY KEY (`fileid`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_image`
--
ALTER TABLE `tb_image`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_ngword`
--
ALTER TABLE `tb_ngword`
  MODIFY `ngid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tb_point`
--
ALTER TABLE `tb_point`
  MODIFY `pid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `tb_report`
--
ALTER TABLE `tb_report`
  MODIFY `repid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_request`
--
ALTER TABLE `tb_request`
  MODIFY `requestid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tb_schedule`
--
ALTER TABLE `tb_schedule`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tb_upfile`
--
ALTER TABLE `tb_upfile`
  MODIFY `fileid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
