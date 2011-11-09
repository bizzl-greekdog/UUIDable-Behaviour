DROP TABLE IF EXISTS `uuidable_repository`;
CREATE TABLE IF NOT EXISTS `uuidable_repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` binary(36) NOT NULL,
  `model` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
