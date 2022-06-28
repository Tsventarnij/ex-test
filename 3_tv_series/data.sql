CREATE TABLE `tv_series` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `channel` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tv_series_intervals` (
  `id_tv_series` int(11) NOT NULL,
  `week_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `show_time` time NOT NULL,
  KEY `tv_series_id_foreign_key_idx` (`id_tv_series`),
  CONSTRAINT `tv_series_id_foreign_key` FOREIGN KEY (`id_tv_series`) REFERENCES `tv_series` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tv_series` (`title`, `channel`, `gender`)
VALUES
    ('Friends', 'NBC', 'Sitcom'),
    ('Mighty Morphin Power Rangers', 'Fox Kids', 'Action, Superhero'),
    ('Breaking Bad', 'AMC', 'Crime drama, Black comedy');

INSERT INTO `tv_series_intervals` (`id_tv_series`, `week_day`, `show_time`)
VALUES
    (1, 'Monday', '19:00'),
    (1, 'Wednesday', '19:00'),
    (1, 'Friday', '19:00'),
    (2, 'Saturday', '9:00'),
    (3, 'Tuesday', '21:00'),
    (3, 'Thursday', '21:00');