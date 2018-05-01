CREATE TABLE IF NOT EXISTS `{wp_table_prefix}wpgrabber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `type` char(4) NOT NULL,
  `url` text NOT NULL,
  `links` text NOT NULL,
  `title` text NOT NULL,
  `text_start` text NOT NULL,
  `text_end` text NOT NULL,
  `last_url` text NOT NULL,
  `last_count` tinyint(4) NOT NULL,
  `rss_encoding` varchar(16) NOT NULL,
  `html_encoding` varchar(16) NOT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `params` text NOT NULL,
  `last_update` int(11) NOT NULL,
  `work_time` int(11) NOT NULL,
  `interval` int(11) NOT NULL,
  `link_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `{wp_table_prefix}wpgrabber_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `images` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `{wp_table_prefix}wpgrabber_errors` (
  `id_error` int(11) NOT NULL AUTO_INCREMENT,
  `date_add` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_send` int(11) NOT NULL,
  PRIMARY KEY (`id_error`),
  UNIQUE KEY `file` (`file`),
  UNIQUE KEY `message` (`message`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;