CREATE TABLE IF NOT EXISTS `bannercategory` (
  `bannerCategory_id` int(11) NOT NULL AUTO_INCREMENT,
  `bannerCategory_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `bannerCategory_html_id` varchar(64) COLLATE utf8_bin NOT NULL,
  `bannerCategory_slots` int(11) NOT NULL,
  PRIMARY KEY (`bannerCategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;



CREATE TABLE IF NOT EXISTS `banners` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_file` varchar(255) COLLATE utf8_bin NOT NULL,
  `banner_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `banner_group` varchar(64) COLLATE utf8_bin NOT NULL,
  `banner_width` int(11) NOT NULL,
  `banner_height` int(11) NOT NULL,
  `display_from` date NOT NULL,
  `display_to` date NOT NULL,
  `display_clicks` int(11) NOT NULL,
  `display_count` int(11) NOT NULL,
  `clicked` int(11) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=22 ;
