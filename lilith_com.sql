-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-12-07 13:54:56
-- 服务器版本： 8.0.25
-- PHP 版本： 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `new`
--

-- --------------------------------------------------------

--
-- 表的结构 `echo_admin`
--

CREATE TABLE `echo_admin` (
  `id` int NOT NULL,
  `username` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind` tinyint NOT NULL,
  `psd` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lasttime` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alevel` tinyint DEFAULT NULL,
  `power` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asetting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ucmsid` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `echo_admin`
--

INSERT INTO `echo_admin` (`id`, `username`, `kind`, `psd`, `lasttime`, `lastip`, `nickname`, `alevel`, `power`, `asetting`, `ucmsid`) VALUES
(1, 'getelement', 0, 'f98bbbbb8de640f76c6b181f2486629a', NULL, NULL, '管理员', 3, '{\"b\":{\"1\":1,\"2\":1},\"alevel\":3}', NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `echo_article`
--

CREATE TABLE `echo_article` (
  `id` int NOT NULL,
  `posttime` int DEFAULT '0',
  `cid` int DEFAULT '0',
  `adminuid` int DEFAULT '0',
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `keywords` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `shijian` int DEFAULT NULL,
  `aorder` int DEFAULT NULL,
  `pic` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pics` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `tag` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `click` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `echo_channel`
--

CREATE TABLE `echo_channel` (
  `cid` int NOT NULL,
  `fid` int NOT NULL DEFAULT '0',
  `cname` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ckind` tinyint NOT NULL,
  `ifshow` tinyint(1) DEFAULT NULL,
  `ifshownav` tinyint(1) DEFAULT NULL,
  `ifshowadmin` tinyint(1) DEFAULT NULL,
  `ifshowleft` tinyint(1) DEFAULT NULL,
  `newwindow` tinyint(1) DEFAULT NULL,
  `corder` int DEFAULT NULL,
  `csetting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cvalue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `echo_channel`
--

INSERT INTO `echo_channel` (`cid`, `fid`, `cname`, `ckind`, `ifshow`, `ifshownav`, `ifshowadmin`, `ifshowleft`, `newwindow`, `corder`, `csetting`, `cvalue`) VALUES
(1, 0, '网站首页', 1, 1, 1, 1, 1, 0, 5, '{\"channel_url\":\"\\/\",\"template\":\"index.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/(cid)\\/page_(page).html\",\"templatelist\":\"list.php\",\"channel_pageurlcache\":\"0\",\"channel_articleurl\":\"\\/(cid)\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":\"0\",\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\"}', ''),
(2, 0, '解读&#x5173;&#x952e;&#x8bcd;&#x31;', 1, 1, 1, 1, 1, 0, 10, '{\"channel_url\":\"\\/about.html\",\"template\":\"about.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/(cid)\\/page_(page).html\",\"templatelist\":\"list.php\",\"channel_pageurlcache\":\"0\",\"channel_articleurl\":\"\\/(cid)\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":\"0\",\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\"}', ''),
(3, 0, '产品展示', 2, 1, 1, 1, 1, 0, 15, '{\"channel_url\":\"\\/works.html\",\"template\":\"works.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/works\\/page_(page).html\",\"templatelist\":\"works.php\",\"channel_pageurlcache\":0,\"channel_articleurl\":\"\\/works\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":0,\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\",\"listnoadd\":0,\"listnoedit\":0,\"listnodel\":0,\"listcopy\":0,\"listarticlemove\":0,\"listshowadminname\":0,\"listfidshow\":0}', ''),
(4, 0, '新闻动态', 2, 1, 1, 1, 1, 0, 20, '{\"channel_url\":\"\\/news.html\",\"template\":\"news.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/news\\/page_(page).html\",\"templatelist\":\"news.php\",\"channel_pageurlcache\":0,\"channel_articleurl\":\"\\/news\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":0,\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\",\"listnoadd\":0,\"listnoedit\":0,\"listnodel\":0,\"listcopy\":0,\"listarticlemove\":0,\"listshowadminname\":0,\"listfidshow\":0}', ''),
(5, 0, '服务宗旨', 1, 1, 1, 1, 1, 0, 25, '{\"channel_url\":\"\\/service.html\",\"template\":\"service.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/(cid)\\/page_(page).html\",\"templatelist\":\"list.php\",\"channel_pageurlcache\":\"0\",\"channel_articleurl\":\"\\/(cid)\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":\"0\",\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\"}', ''),
(6, 0, '找到&#x5173;&#x952e;&#x8bcd;&#x32;', 1, 1, 1, 1, 1, 0, 30, '{\"channel_url\":\"\\/contact.html\",\"template\":\"contact.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/(cid)\\/page_(page).html\",\"templatelist\":\"list.php\",\"channel_pageurlcache\":0,\"channel_articleurl\":\"\\/(cid)\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":0,\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[]\",\"listnoadd\":0,\"listnoedit\":0,\"listnodel\":0,\"listcopy\":0,\"listarticlemove\":0,\"listshowadminname\":0,\"listfidshow\":0}', ''),
(7, 0, 'sitemap', 1, 1, 0, 1, 1, 0, 35, '{\"channel_url\":\"\\/sitemap.xml\",\"template\":\"sitemapxml.php\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/(cid)\\/page_(page).html\",\"templatelist\":\"list.php\",\"channel_pageurlcache\":\"0\",\"channel_articleurl\":\"\\/(cid)\\/(id).html\",\"templatearticle\":\"article.php\",\"channel_articleurlcache\":\"0\",\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[{\\\"uri\\\":\\\"\\\\\\/sitemap.html\\\",\\\"res\\\":\\\"sitemaphtml.php\\\",\\\"cache\\\":0},{\\\"uri\\\":\\\"\\\\\\/sitemap.txt\\\",\\\"res\\\":\\\"sitemaptxt.php\\\",\\\"cache\\\":0}]\"}', ''),
(8, 0, '标签页', 2, 1, 0, 1, 1, 0, 40, '{\"channel_url\":\"\",\"template\":\"\",\"channel_urlcache\":0,\"channel_pageurl\":\"\\/tag\\/{title}\\/page_(page).html\",\"templatelist\":\"tag.php\",\"channel_pageurlcache\":0,\"channel_articleurl\":\"\",\"templatearticle\":\"\",\"channel_articleurlcache\":0,\"articletable\":\"echo_article\",\"temppage_size\":15,\"temppage_order\":\"id desc\",\"listadminuid\":1,\"cnote\":\"\",\"channel_domain\":\"\",\"otherpage\":\"[{\\\"uri\\\":\\\"\\\\\\/tag\\\\\\/{title}.html\\\",\\\"res\\\":\\\"tag.php\\\",\\\"cache\\\":0},{\\\"uri\\\":\\\"\\\\\\/search\\\\\\/{title}\\\\\\/page_(page).html\\\",\\\"res\\\":\\\"tag.php\\\",\\\"cache\\\":0},{\\\"uri\\\":\\\"\\\\\\/search\\\\\\/{title}.html\\\",\\\"res\\\":\\\"tag.php\\\",\\\"cache\\\":0}]\",\"listnoadd\":0,\"listnoedit\":0,\"listnodel\":0,\"listcopy\":0,\"listarticlemove\":0,\"listshowadminname\":0,\"listfidshow\":0}', '');

-- --------------------------------------------------------

--
-- 表的结构 `echo_moudle`
--

CREATE TABLE `echo_moudle` (
  `id` int NOT NULL,
  `cid` int DEFAULT NULL,
  `fid` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mname` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minfo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mcontent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mkind` int DEFAULT NULL,
  `morder` int DEFAULT NULL,
  `ifcreated` tinyint DEFAULT NULL,
  `ifshow` tinyint DEFAULT NULL,
  `ifonly` tinyint DEFAULT NULL,
  `ifadmin` tinyint DEFAULT NULL,
  `ifmore` tinyint DEFAULT NULL,
  `hide` tinyint DEFAULT NULL,
  `ifshowtemp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `strarray` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `msetting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `strdefault` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mfunction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `echo_moudle`
--

INSERT INTO `echo_moudle` (`id`, `cid`, `fid`, `mname`, `minfo`, `mcontent`, `mkind`, `morder`, `ifcreated`, `ifshow`, `ifonly`, `ifadmin`, `ifmore`, `hide`, `ifshowtemp`, `strarray`, `msetting`, `strdefault`, `mfunction`) VALUES
(1, 3, '', 'title', '标题', '', 1, 5, 1, 1, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1,\"adminsearch\":1}', '', NULL),
(2, 3, '', 'keywords', '关键词	', '', 1, 10, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(3, 3, '', 'description', '描述', '', 2, 15, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(4, 3, '', 'shijian', '时间', '', 9, 20, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', 'now', NULL),
(5, 3, '', 'aorder', '排序', '', 7, 25, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '1', NULL),
(6, 3, '', 'pic', '图片', '', 5, 30, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(7, 3, '', 'pics', '多图	', '', 6, 35, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(8, 3, '', 'content', '内容	', '', 4, 40, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(9, 3, '', 'tag', '标签', '', 1, 45, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(10, 3, '', 'click', '点击量', '', 7, 50, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '1', NULL),
(11, 4, '', 'title', '标题', '', 1, 5, 1, 1, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1,\"adminsearch\":1}', '', NULL),
(12, 4, '', 'keywords', '关键词	', '', 1, 10, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(13, 4, '', 'description', '描述', '', 2, 15, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(14, 4, '', 'shijian', '时间', '', 9, 20, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', 'now', NULL),
(15, 4, '', 'aorder', '排序', '', 7, 25, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '1', NULL),
(16, 4, '', 'pic', '图片', '', 5, 30, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(17, 4, '', 'pics', '多图', '', 6, 35, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(18, 4, '', 'content', '内容', '', 4, 40, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(19, 4, '', 'tag', '标签', '', 1, 45, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '', NULL),
(20, 4, '', 'click', '点击量', '', 7, 50, 1, 0, 0, 0, NULL, 0, '', NULL, '{\"filterhtml\":1}', '1', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `echo_str`
--

CREATE TABLE `echo_str` (
  `id` int NOT NULL,
  `strcid` int DEFAULT NULL,
  `strname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strvalue` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `strinfo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `strstyle` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ifshow` tinyint DEFAULT NULL,
  `ifbind` tinyint DEFAULT NULL,
  `ifadmin` tinyint DEFAULT NULL,
  `inputkind` tinyint DEFAULT NULL,
  `strorder` int DEFAULT NULL,
  `strarray` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ssetting` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `strtip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `echo_str`
--

INSERT INTO `echo_str` (`id`, `strcid`, `strname`, `strvalue`, `strinfo`, `strstyle`, `ifshow`, `ifbind`, `ifadmin`, `inputkind`, `strorder`, `strarray`, `ssetting`, `strtip`) VALUES
(1, 0, 'router', '[{\"uri\":\"\\/\",\"res\":\"index\",\"domain\":\"\",\"cache\":0,\"cid\":0},{\"uri\":\"\\/\",\"res\":\"index.php\",\"cache\":0,\"cid\":\"1\",\"domain\":\"\"},{\"uri\":\"\\/about.html\",\"res\":\"about.php\",\"cache\":0,\"cid\":\"2\",\"domain\":\"\"},{\"uri\":\"\\/works.html\",\"res\":\"works.php\",\"cache\":0,\"cid\":\"3\",\"domain\":\"\"},{\"uri\":\"\\/works\\/page_(page).html\",\"res\":\"works.php\",\"cache\":0,\"cid\":\"3\",\"domain\":\"\"},{\"uri\":\"\\/works\\/(id).html\",\"res\":\"article.php\",\"cache\":0,\"cid\":\"3\",\"domain\":\"\"},{\"uri\":\"\\/news.html\",\"res\":\"news.php\",\"cache\":0,\"cid\":\"4\",\"domain\":\"\"},{\"uri\":\"\\/news\\/page_(page).html\",\"res\":\"news.php\",\"cache\":0,\"cid\":\"4\",\"domain\":\"\"},{\"uri\":\"\\/news\\/(id).html\",\"res\":\"article.php\",\"cache\":0,\"cid\":\"4\",\"domain\":\"\"},{\"uri\":\"\\/service.html\",\"res\":\"service.php\",\"cache\":0,\"cid\":\"5\",\"domain\":\"\"},{\"uri\":\"\\/contact.html\",\"res\":\"contact.php\",\"cache\":0,\"cid\":\"6\",\"domain\":\"\"},{\"uri\":\"\\/sitemap.xml\",\"res\":\"sitemapxml.php\",\"cache\":0,\"cid\":\"7\",\"domain\":\"\"},{\"uri\":\"\\/sitemap.html\",\"res\":\"sitemaphtml.php\",\"cache\":0,\"cid\":\"7\",\"domain\":\"\"},{\"uri\":\"\\/sitemap.txt\",\"res\":\"sitemaptxt.php\",\"cache\":0,\"cid\":\"7\",\"domain\":\"\"},{\"uri\":\"\\/tag\\/{title}\\/page_(page).html\",\"res\":\"tag.php\",\"cache\":0,\"cid\":\"8\",\"domain\":\"\"},{\"uri\":\"\\/tag\\/{title}.html\",\"res\":\"tag.php\",\"cache\":0,\"cid\":\"8\",\"domain\":\"\"},{\"uri\":\"\\/search\\/{title}\\/page_(page).html\",\"res\":\"tag.php\",\"cache\":0,\"cid\":\"8\",\"domain\":\"\"},{\"uri\":\"\\/search\\/{title}.html\",\"res\":\"tag.php\",\"cache\":0,\"cid\":\"8\",\"domain\":\"\"}]', NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL),
(2, 0, 'title', '&#x6807;&#x9898;', NULL, NULL, NULL, NULL, 0, 1, 5, NULL, '{\"filterhtml\":1}', NULL),
(3, 0, 'keywords', '&#x5173;&#x952e;&#x8bcd;&#x31;&#x2c;&#x5173;&#x952e;&#x8bcd;&#x32;&#x2c;&#x5173;&#x952e;&#x8bcd;&#x33;&#x2c;&#x5173;&#x952e;&#x8bcd;&#x34;', NULL, NULL, NULL, NULL, 0, 1, 10, NULL, '{\"filterhtml\":1}', NULL),
(4, 0, 'description', '&#x63cf;&#x8ff0;', NULL, NULL, NULL, NULL, 0, 2, 15, NULL, '{\"filterhtml\":1}', NULL),
(5, 0, 'logo', '/uploads/images/logo/nan-gong-ti-yu.png', NULL, '', NULL, 0, 0, 5, 20, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(6, 0, 'case_number', '粤ICP备17135542号-1', NULL, NULL, NULL, NULL, 0, 1, 25, NULL, '{\"filterhtml\":1}', NULL),
(7, 0, 'home_banner_all_1', '/uploads/images/banner/wan-zhuan-yun-dong-xiang-shou-kuai-le-ren-sheng.png||玩转运动，享受快乐人生。', NULL, NULL, NULL, NULL, 0, 1, 30, NULL, '{\"filterhtml\":1}', NULL),
(8, 0, 'home_banner_all_2', '/uploads/images/banner/yun-dong-rang-sheng-huo-geng-jing-cai.png||运动，让生活更精彩。', NULL, NULL, NULL, NULL, 0, 1, 35, NULL, '{\"filterhtml\":1}', NULL),
(9, 0, 'home_banner_all_3', '/uploads/images/banner/jian-kang-ren-sheng-cong-yun-dong-kai-shi.png||健康人生，从运动开始！', NULL, NULL, NULL, NULL, 0, 1, 40, NULL, '{\"filterhtml\":1}', NULL),
(10, 0, 'home_banner_all_4', '/uploads/images/banner/sai-chang-zhi-wai-de-jing-shen-cai-shi-zhang-xian-shi-li-de-zui-jia-ti-xian.png||赛场之外的精神才是彰显实力的最佳体现。', NULL, NULL, NULL, NULL, 0, 1, 45, NULL, '{\"filterhtml\":1}', NULL),
(11, 0, 'home_banner_all_5', '/uploads/images/banner/bu-duan-jin-qu-yong-pan-gao-feng-pi-jing-zhan-ji.png||不断进取，勇攀高峰，披荆斩棘！', NULL, NULL, NULL, NULL, 0, 1, 50, NULL, '{\"filterhtml\":1}', NULL),
(12, 0, 'about_img', '/uploads/images/about/jie-du-guan-jian-ci-1.png', NULL, '', NULL, 0, 0, 5, 55, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(13, 0, 'about_text', '<p><strong>&#x5173;&#x952e;&#x8bcd;&#x33;</strong>体育有限公司是一家专业的体育服务提供商，致力于为广大体育爱好者打造更好的运动体验。我们提供多样化的服务，包括但不限于体育用品销售、体育场馆租赁、健身培训、赛事活动策划等，旨在为客户提供全方位的体育服务。我们拥有一支经验丰富的管理团队和一批充满热情的员工，他们始终秉持“专业、专注、用心”的服务理念，为客户提供高品质、专业化的体育服务。无论您是体育爱好者，还是希望在体育领域获得更多发展机会的企业，我们都将为您提供全面的解决方案，让您满意、放心地享受体育带来的快乐与健康。</p>', NULL, NULL, NULL, NULL, 0, 1, 60, NULL, '{\"filterhtml\":1}', NULL),
(14, 0, 'service_text_1', '• 体育用品销售服务：销售体育用品，并提供选购建议、产品保姆等售后服务。', NULL, NULL, NULL, NULL, 0, 1, 65, NULL, '{\"filterhtml\":1}', NULL),
(15, 0, 'service_text_2', '场馆租赁服务：提供场馆租赁及场馆管理服务，包括场馆设施维护、安保服务等。', NULL, NULL, NULL, NULL, 0, 1, 70, NULL, '{\"filterhtml\":1}', NULL),
(16, 0, 'service_text_3', ' 体育赛事组织：组织各类体育赛事，如足球、篮球、羽毛球等比赛，以及马拉松、自行车等运动会。', NULL, NULL, NULL, NULL, 0, 1, 75, NULL, '{\"filterhtml\":1}', NULL),
(17, 0, 'service_text_4', '赛后营销咨询服务：根据客户需求，提供专业化的赛后营销分析及规划，包括广告投放、公关活动等。', NULL, NULL, NULL, NULL, 0, 1, 80, NULL, '{\"filterhtml\":1}', NULL),
(18, 0, 'service_text_5', '场馆建设服务：提供体育场馆的设计规划、建设施工、设备采购、后期运营等全流程解决方案。', NULL, NULL, NULL, NULL, 0, 1, 85, NULL, '{\"filterhtml\":1}', NULL),
(19, 0, 'service_text_6', '赛事策划服务：提供各类体育赛事的策划、组织、执行、管理及其他相关服务。', NULL, NULL, NULL, NULL, 0, 1, 90, NULL, '{\"filterhtml\":1}', NULL),
(20, 0, 'service_text_7', '运动营地活动：提供各类户外运动营地活动，包括但不限于登山、瑜伽、皮划艇等，为客户提供快乐的运动体验。', NULL, NULL, NULL, NULL, 0, 1, 95, NULL, '{\"filterhtml\":1}', NULL),
(21, 0, 'service_text_8', '健身房设计： 为客户提供健身房设计方案服务，包括器材布置、空间规划、环境设置等。', NULL, NULL, NULL, NULL, 0, 1, 100, NULL, '{\"filterhtml\":1}', NULL),
(22, 0, 'address', '马鞍山市琴藏山谷456号', NULL, NULL, NULL, NULL, 0, 1, 105, NULL, '{\"filterhtml\":1}', NULL),
(23, 0, 'phone', '13594780274', NULL, NULL, NULL, NULL, 0, 1, 110, NULL, '{\"filterhtml\":1}', NULL),
(24, 0, 'email', 'imprecise@qq.com', NULL, NULL, NULL, NULL, 0, 1, 115, NULL, '{\"filterhtml\":1}', NULL),
(25, 0, 'class', '8176061459', NULL, NULL, NULL, NULL, 0, 1, 120, NULL, '{\"filterhtml\":1}', NULL),
(26, 0, 'works_banner_img', '/uploads/images/column/chan-pin-zhan-shi.png', NULL, '', NULL, 0, 0, 5, 125, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(27, 0, 'news_banner_img', '/uploads/images/column/xin-wen-dong-tai.png', NULL, '', NULL, 0, 0, 5, 130, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(28, 0, 'service_banner_img', '/uploads/images/column/fu-wu-zong-zhi.png', NULL, '', NULL, 0, 0, 5, 135, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(29, 0, 'contact_banner_img', '/uploads/images/column/zhao-dao-guan-jian-ci-2.png', NULL, '', NULL, 0, 0, 5, 140, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(30, 0, 'about_banner_img', '/uploads/images/column/jie-du-guan-jian-ci-1.png', NULL, '', NULL, 0, 0, 5, 145, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(31, 0, 'ask_all_1', '/uploads/images/ask/bing-yu-mei.png||邴裕梅||自从来到这家医疗中心，我的健康状况有了显著改善。医生和护士都非常专业，他们的细心关怀让我感到很温暖。', NULL, NULL, NULL, NULL, 0, 1, 150, NULL, '{\"filterhtml\":1}', NULL),
(32, 0, 'ask_all_2', '/uploads/images/ask/lu-si-shan.png||卢思山||作为一名长期慢性病患者，我对这里的个性化治疗计划感到非常满意。医生为我制定的治疗方案既全面又实用。', NULL, NULL, NULL, NULL, 0, 1, 155, NULL, '{\"filterhtml\":1}', NULL),
(33, 0, 'ask_all_3', '/uploads/images/ask/lian-wen-xia.png||连文霞||我对这里的医疗服务非常满意。从预约到治疗，每一步都非常顺畅。医生的专业建议帮助我更好地理解了我的健康状况。', NULL, NULL, NULL, NULL, 0, 1, 160, NULL, '{\"filterhtml\":1}', NULL),
(34, 0, 'ask_all_4', '/uploads/images/ask/zhuang-xiao-jie.png||庄晓洁||非常感谢这里的医生和护理团队。他们的专业知识和关心让我的康复过程更加轻松。', NULL, NULL, NULL, NULL, 0, 1, 165, NULL, '{\"filterhtml\":1}', NULL),
(35, 0, 'ask_all_5', '/uploads/images/ask/zu-tong-xia.png||祖彤霞||我对这家医疗中心的服务印象深刻。每位员工都非常友好和专业，让我感到很放心。', NULL, NULL, NULL, NULL, 0, 1, 170, NULL, '{\"filterhtml\":1}', NULL),
(36, 0, 'themes_color', '#0e1f65', NULL, NULL, NULL, NULL, 0, 1, 175, NULL, '{\"filterhtml\":1}', NULL),
(37, 0, 'partner_img_1', '/uploads/images/partner/2023112812244106423274c4.png', NULL, '', NULL, 0, 0, 5, 180, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(38, 0, 'partner_img_2', '/uploads/images/partner/2023112812244134030e13fd.png', NULL, '', NULL, 0, 0, 5, 185, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(39, 0, 'partner_img_3', '/uploads/images/partner/2023112812244143e2c6883c.png', NULL, '', NULL, 0, 0, 5, 190, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(40, 0, 'partner_img_4', '/uploads/images/partner/202311281224415b5543f451.png', NULL, '', NULL, 0, 0, 5, 195, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(41, 0, 'partner_img_5', '/uploads/images/partner/202311281224416999658c7c.png', NULL, '', NULL, 0, 0, 5, 200, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(42, 0, 'partner_img_6', '/uploads/images/partner/202311281224417dd53f93f2.png', NULL, '', NULL, 0, 0, 5, 205, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(43, 0, 'partner_img_7', '/uploads/images/partner/20231128122441bdb86ea891.png', NULL, '', NULL, 0, 0, 5, 210, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(44, 0, 'partner_img_8', '/uploads/images/partner/20231128122441c9b4a595a6.png', NULL, '', NULL, 0, 0, 5, 215, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(45, 0, 'partner_img_9', '/uploads/images/partner/20231128122441cb1e1c18fb.png', NULL, '', NULL, 0, 0, 5, 220, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(46, 0, 'partner_img_10', '/uploads/images/partner/20231128122441cde1fcff7b.png', NULL, '', NULL, 0, 0, 5, 225, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(47, 0, 'partner_img_11', '/uploads/images/partner/20231128122441cf20ebd5c0.png', NULL, '', NULL, 0, 0, 5, 230, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(48, 0, 'partner_img_12', '/uploads/images/partner/20231128122441d293ad8ea4.png', NULL, '', NULL, 0, 0, 5, 235, '', '{\"regular\":\"\",\"lenmin\":\"\",\"lenmax\":\"\",\"filterhtml\":\"1\"}', ''),
(49, 0, 'faq_text_1', '• 体育用品销售服务：销售体育用品，并提供选购建议、产品保姆等售后服务。', NULL, NULL, NULL, NULL, 0, 1, 290, NULL, '{\"filterhtml\":1}', NULL),
(50, 0, 'faq_text_2', '场馆租赁服务：提供场馆租赁及场馆管理服务，包括场馆设施维护、安保服务等。', NULL, NULL, NULL, NULL, 0, 1, 295, NULL, '{\"filterhtml\":1}', NULL),
(51, 0, 'faq_text_3', ' 体育赛事组织：组织各类体育赛事，如足球、篮球、羽毛球等比赛，以及马拉松、自行车等运动会。', NULL, NULL, NULL, NULL, 0, 1, 300, NULL, '{\"filterhtml\":1}', NULL),
(52, 0, 'faq_text_4', '赛后营销咨询服务：根据客户需求，提供专业化的赛后营销分析及规划，包括广告投放、公关活动等。', NULL, NULL, NULL, NULL, 0, 1, 305, NULL, '{\"filterhtml\":1}', NULL),
(53, 0, 'faq_text_5', '场馆建设服务：提供体育场馆的设计规划、建设施工、设备采购、后期运营等全流程解决方案。', NULL, NULL, NULL, NULL, 0, 1, 310, NULL, '{\"filterhtml\":1}', NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `echo_admin`
--
ALTER TABLE `echo_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `echo_article`
--
ALTER TABLE `echo_article`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `echo_channel`
--
ALTER TABLE `echo_channel`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `echo_moudle`
--
ALTER TABLE `echo_moudle`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `echo_str`
--
ALTER TABLE `echo_str`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `echo_admin`
--
ALTER TABLE `echo_admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `echo_article`
--
ALTER TABLE `echo_article`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `echo_channel`
--
ALTER TABLE `echo_channel`
  MODIFY `cid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `echo_moudle`
--
ALTER TABLE `echo_moudle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `echo_str`
--
ALTER TABLE `echo_str`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
