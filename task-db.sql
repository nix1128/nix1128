
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('video','article','gallery','live') NOT NULL DEFAULT 'article',
  `status` enum('published','scheduled','archived','deleted') NOT NULL DEFAULT 'scheduled',
  `title` varchar(255) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `published_from` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published_to` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `article_media` (
  `article_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('video','image','livestream') NOT NULL DEFAULT 'image',
  `quality` int(11) DEFAULT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `service_id` int(11) NOT NULL,
  `published` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

