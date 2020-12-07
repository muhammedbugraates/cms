-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2020 at 07:39 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_title`) VALUES
(1, 24, 'Bootstrap'),
(2, 24, 'Javascript'),
(3, 27, 'PHP'),
(4, 29, 'JAVA'),
(17, 30, 'Procedural PHP'),
(20, 45, 'HTML5');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text DEFAULT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(23, 35, 'Rico Fire', 'rico@gmail.com', 'I think it is very useful tutorial.', 'approved', '2020-11-10'),
(24, 34, 'Noname User', 'mbugrates@gmail.com', 'I think it is not really bad. I like it', 'approved', '2020-11-10'),
(25, 34, 'Noname User', 'mbugrates@gmail.com', 'Actually I change my mind.', 'approved', '2020-11-10'),
(26, 42, 'Buğra', 'mbugrates@gmail.com', 'I think it is very awesome!', 'unapproved', '2020-11-10'),
(27, 35, 'Bugra', 'bugra@gmail.com', 'asdasd', 'approved', '2020-11-15'),
(30, 33, 'sad', 'sadf@sadgf', 'asd', 'approved', '2020-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(123, 24, 36),
(138, 46, 33),
(139, 28, 33),
(144, 24, 56),
(147, 24, 33),
(148, 24, 57);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) DEFAULT NULL,
  `post_user` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text DEFAULT NULL,
  `post_content` text DEFAULT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL DEFAULT 0,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_views_count` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_user`, `user_id`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_views_count`, `likes`) VALUES
(33, 1, 'Bootstrap Tutorial 1', '', 'demo1', 27, '2020-11-10', 'image_3.jpg', 'Bootstrap is a web framework that focuses on simplifying the development of informative web pages (as opposed to web apps). The primary purpose of adding it to a web project is to apply Bootstrap\'s choices of color, size, font and layout to that project. As such, the primary factor is whether the developers in charge find those choices to their liking. Once added to a project, Bootstrap provides basic style definitions for all HTML elements. The result is a uniform appearance for prose, tables and form elements across web browsers. In addition, developers can take advantage of CSS classes defined in Bootstrap to further customize the appearance of their contents. For example, Bootstrap has provisioned for light- and dark-colored tables, page headings, more prominent pull quotes, and text with a highlight.\r\n\r\nBootstrap also comes with several JavaScript components in the form of jQuery plugins. They provide additional user interface elements such as dialog boxes, tooltips, and carousels. Each Bootstrap component consists of an HTML structure, CSS declarations, and in some cases accompanying JavaScript code. They also extend the functionality of some existing interface elements, including for example an auto-complete function for input fields.', 'bootstrap', 0, 'published', 573, 18),
(34, 2, 'Javascript Tutorial 1', '', 'demo2', 28, '2020-11-10', 'image_4.jpg', 'JavaScript (/ˈdʒɑːvəˌskrɪpt/),[6] often abbreviated as JS, is a programming language that conforms to the ECMAScript specification.[7] JavaScript is high-level, often just-in-time compiled, and multi-paradigm. It has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nAlongside HTML and CSS, JavaScript is one of the core technologies of the World Wide Web.[8] JavaScript enables interactive web pages and is an essential part of web applications. The vast majority of websites use it for client-side page behavior,[9] and all major web browsers have a dedicated JavaScript engine to execute it.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nAs a multi-paradigm language, JavaScript supports event-driven, functional, and imperative programming styles. It has application programming interfaces (APIs) for working with text, dates, regular expressions, standard data structures, and the Document Object Model (DOM). However, the language itself does not include any input/output (I/O), such as networking, storage, or graphics facilities, as the host environment (usually a web browser) provides those APIs.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nJavaScript engines were originally used only in web browsers, but they are now embedded in some servers, usually via Node.js. They are also embedded in a variety of applications created with frameworks such as Electron and Cordova.\\\\\\\\r\\\\\\\\n\\\\\\\\r\\\\\\\\nAlthough there are similarities between JavaScript and Java, including language name, syntax, and respective standard libraries, the two languages are distinct and differ greatly in design.', 'javascript', 0, 'published', 23, 2),
(35, 3, 'PHP Tutorial 1', '', 'demo3', 29, '2020-11-10', 'programming-900x300.png', 'PHP is a general-purpose scripting language especially suited to web development.[6] It was originally created by Danish-Canadian programmer Rasmus Lerdorf in 1994.[7] The PHP reference implementation is now produced by The PHP Group.[8] PHP originally stood for Personal Home Page,[7] but it now stands for the recursive initialism PHP: Hypertext Preprocessor.[9]\r\n\r\nPHP code is usually processed on a web server by a PHP interpreter implemented as a module, a daemon or as a Common Gateway Interface (CGI) executable. On a web server, the result of the interpreted and executed PHP code – which may be any type of data, such as generated HTML or binary image data – would form the whole or part of an HTTP response. Various web template systems, web content management systems, and web frameworks exist which can be employed to orchestrate or facilitate the generation of that response. Additionally, PHP can be used for many programming tasks outside of the web context, such as standalone graphical applications[10] and robotic drone control.[11] Arbitrary PHP code can also be interpreted and executed via command-line interface (CLI).\r\n\r\nThe standard PHP interpreter, powered by the Zend Engine, is free software released under the PHP License. PHP has been widely ported and can be deployed on most web servers on almost every operating system and platform, free of charge.[12]\r\n\r\nThe PHP language evolved without a written formal specification or standard until 2014, with the original implementation acting as the de facto standard which other implementations aimed to follow. Since 2014, work has gone on to create a formal PHP specification.[13]\r\n\r\nBy September 2020, two out of every three websites using PHP are still on discontinued PHP versions,[14] and almost half of all PHP websites use version 5.6 or older,[15] that not even Debian supports (while Debian 9 still supports version 7.0 and 7.1, those versions are unsupported by The PHP Development Team).[16] In addition, PHP version 7.2, the most popular supported PHP version, will stop getting security updates on November 30, 2020[14] and therefore unless PHP websites are upgraded to version 7.3 (or newer), 84% of PHP websites will thus use discontinued versions.', 'php', 0, 'published', 16, 0),
(36, 20, 'HTLM5 Tutorial', '', 'rico', 24, '2020-11-10', 'programming-900x300.png', 'In 1980, physicist Tim Berners-Lee, a contractor at CERN, proposed and prototyped ENQUIRE, a system for CERN researchers to use and share documents. In 1989, Berners-Lee wrote a memo proposing an Internet-based hypertext system.[3] Berners-Lee specified HTML and wrote the browser and server software in late 1990. That year, Berners-Lee and CERN data systems engineer Robert Cailliau collaborated on a joint request for funding, but the project was not formally adopted by CERN. In his personal notes[4] from 1990 he listed[5] \\\\\\\"some of the many areas in which hypertext is used\\\\\\\" and put an encyclopedia first.\\\\r\\\\n\\\\r\\\\nThe first publicly available description of HTML was a document called \\\\\\\"HTML Tags\\\\\\\", first mentioned on the Internet by Tim Berners-Lee in late 1991.[6][7] It describes 18 elements comprising the initial, relatively simple design of HTML. Except for the hyperlink tag, these were strongly influenced by SGMLguid, an in-house Standard Generalized Markup Language (SGML)-based documentation format at CERN. Eleven of these elements still exist in HTML 4.[8]', 'html', 0, 'published', 4, 1),
(37, 4, 'Java CMS Tutorial', '', 'mbugrates', 26, '2020-11-10', 'image_1.jpg', 'Java is a class-based, object-oriented programming language that is designed to have as few implementation dependencies as possible. It is a general-purpose programming language intended to let application developers write once, run anywhere (WORA),[17] meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.[18] Java applications are typically compiled to bytecode that can run on any Java virtual machine (JVM) regardless of the underlying computer architecture. The syntax of Java is similar to C and C++, but has fewer low-level facilities than either of them. The Java runtime provides dynamic capabilities (such as reflection and runtime code modification) that are typically not available in traditional compiled languages. As of 2019, Java was one of the most popular programming languages in use according to GitHub,[19][20] particularly for client-server web applications, with a reported 9 million developers.[21]', 'cms, java', 0, 'draft', 7, 0),
(42, 2, 'Javascript Tutorial 2', '', 'demo1', 27, '2020-11-15', 'image_4.jpg', '<p>JavaScript (/ˈdʒɑːvəˌskrɪpt/),[6] often abbreviated as JS, is a programming language that conforms to the ECMAScript specification.[7] JavaScript is high-level, often just-in-time compiled, and multi-paradigm. It has curly-bracket syntax, dynamic typing, prototype-based object-orientation, and first-class functions.\\\\r\\\\n\\\\r\\\\nAlongside HTML and CSS, JavaScript is one of the core technologies of the World Wide Web.[8] JavaScript enables interactive web pages and is an essential part of web applications. The vast majority of websites use it for client-side page behavior,[9] and all major web browsers have a dedicated JavaScript engine to execute it.\\\\r\\\\n\\\\r\\\\nAs a multi-paradigm language, JavaScript supports event-driven, functional, and imperative programming styles. It has application programming interfaces (APIs) for working with text, dates, regular expressions, standard data structures, and the Document Object Model (DOM). However, the language itself does not include any input/output (I/O), such as networking, storage, or graphics facilities, as the host environment (usually a web browser) provides those APIs.\\\\r\\\\n\\\\r\\\\nJavaScript engines were originally used only in web browsers, but they are now embedded in some servers, usually via Node.js. They are also embedded in a variety of applications created with frameworks such as Electron and Cordova.\\\\r\\\\n\\\\r\\\\nAlthough there are similarities between JavaScript and Java, including language name, syntax, and respective standard libraries, the two languages are distinct and differ greatly in design.</p>', 'javascript', 0, 'draft', 37, 0),
(43, 4, 'Java CMS Tutorial', '', 'mbugrates', 26, '2020-11-13', 'image_1.jpg', '<h2>JAVA</h2><p>&nbsp;</p><h4><i><strong>Java is a class-based, object-oriented programming language that is designed to have as few implementation dependencies as possible. It is a general-purpose programming language intended to let application developers write once, run anywhere (WORA),[17] meaning that compiled Java code can run on all platforms that support Java without the need for recompilation.[18] Java applications are typically compiled to bytecode that can run on any Java virtual machine (JVM) regardless of the underlying computer architecture. The syntax of Java is similar to C and C++, but has fewer low-level facilities than either of them. The Java runtime provides dynamic capabilities (such as reflection and runtime code modification) that are typically not available in traditional compiled languages. As of 2019, Java was one of the most popular programming languages in use according to GitHub,[19][20] particularly for client-server web applications, with a reported 9 million developers.[21]</strong></i></h4><p>&nbsp;</p><h3><i>Think different</i></h3>', 'cms, java', 0, 'draft', 22, 0),
(52, 1, 'Bootstrap Tutorial 3', NULL, 'rico', 24, '2020-11-15', 'image_3.jpg', '<p>Bootstrap asd Bootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asdBootstrap asd</p>', 'bootstrap', 0, 'draft', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(3) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) DEFAULT NULL,
  `user_lastname` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text DEFAULT NULL,
  `user_role` varchar(255) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2y$10$iusesomecrazystrings22',
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `randSalt`, `token`) VALUES
(24, 'rico', '$2y$10$qHJ0OTPdjOlegVAeZpDdq.2ir6ZV.L4tA1xjvO6s19nRPQqR.OkQu', 'Rico', 'Fire', 'rico@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22', ''),
(27, 'demo1', '$2y$12$wHDpjNFR0SJCpgSiR62V7.SC.czQkcG9zqFWxCp09qktw..93eGwC', 'Demo1', 'Last1', 'demo1@gmail.com', '', 'admin', '$2y$10$iusesomecrazystrings22', NULL),
(28, 'demo2', '$2y$12$8r5.bzw2klho93C.XbqymOwCfi6c4/djdn/XO9g9RrxgyEcubMFMC', 'Demo2', 'Last2', 'demo2@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', NULL),
(29, 'demo3', '$2y$10$zwLJAWZ6rvUfmpaUFsHHnew26PBoyct.fZypn1nyXQrYR47rRpdpu', 'Demo3', 'Last3', 'demo3@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', NULL),
(30, 'demo4', '$2y$12$ygtHmwpHY9fmPirXN4HSeumTnV0Ca8K2Wx/NJHip3f0UXE0QtIzta', 'Demo4', 'Last4', 'demo4@gmail.com', '', 'subscriber', '$2y$10$iusesomecrazystrings22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(3, 'hb045eqvl3vdfpuqc04vtkeon8', 1604881904),
(4, 'kfl7jc6j0a8hec23g7o8so4ok4', 1605876522),
(5, 'cgrh7qc2v5hskv5bh0ql9ego4r', 1604874430),
(6, 'jl3n12mf34kbj3nqa5jn9f5ao3', 1606082650),
(7, 'iqpphqb8mgjn61kdctbvfk8645', 1604877593),
(8, 'g6umqqt1fc5nj3136dt1i22l9q', 1604945050),
(9, '1p6rdl0p9ucrlo4rg6dsc0ng3t', 1604971018),
(10, 'vbebf5tpebnhcak25v0o4rsdjh', 1605058866),
(11, 'iog7377jhj2btneut801fp2rto', 1605111421),
(12, 'dcjs93b46jc9d1ii1i41v6mm4p', 1605117837),
(13, 'fhaveef1qeh7nj1go7l1t9gndl', 1605283316),
(14, 'rf7t5l3loq7blga1q8pmpmqkhf', 1605444682),
(15, 'e795db4346176e8c5827f8df29b58242', 1605445439),
(16, 'udosecob815jk4n6dk33seisno', 1605749275),
(17, 'ee8fc5a40b965cdb75bb0f4924811420', 1605447197),
(18, '3td24f3ttvp9fkksb0a5t1i9mo', 1605461952),
(19, '7a1a879798d240064a987f89edf994dc', 1605485144),
(20, 'panbgmdoh3q5698ek6a6vqub93', 1605461457),
(21, 'q11rr3unejiv9themh4salpmda', 1605461459),
(22, 'b6071a2e2d4696642c0b4a0aa0301190', 1605461074),
(23, 'ldhll93qeg4fk6lejs505rn2qd', 1605512403),
(24, 'dtccct3bsecrvafm7on6rbfufs', 1605564397),
(25, 'ht6efk0f5gte3bdkkue3nls447', 1605613703),
(26, 'bhs3kg5gshvq0buf884kopjoac', 1605653375),
(27, '8ka0rldjssl7n1no6u0p67j7ca', 1605656846),
(28, '39aab0b111279db7149c65e90177cb1d', 1605749366),
(29, 'jp52kgh1ud59k19a21dibv647i', 1606310969),
(30, '14bq704ue81394933b7hdkbr36', 1605983797),
(31, '7p00vtqjdd3ohjue3c9pd9gjad', 1606225154),
(32, 'f13b8789da70c3629b455b8cf988a0a2', 1606082227),
(33, '57a5ljdhe67iun3gbmaujvffsf', 1607366374);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
