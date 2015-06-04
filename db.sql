CREATE TABLE IF NOT EXISTS `links` (
    `link_id` int(11) NOT NULL AUTO_INCREMENT,
    `small_url` text NOT NULL,
    `big_url` text NOT NULL,
    `visit_count` int(11),
    `date_added` text NOT NULL,
    `reported` tinyint DEFAULT 0,
    `disabled` tinyint DEFAULT 0,
    PRIMARY KEY (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` text NOT NULL,
    `password` text NOT NULL,
    `reg_date` text NOT NULL,
    `reported` tinyint DEFAULT 0,
    `disabled` tinyint DEFAULT 0,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `userlink` (
    `ul_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `link_id` int(11) NOT NULL,
    PRIMARY KEY (`ul_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
    FOREIGN KEY (`link_id`) REFERENCES `links` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `log` (
    `log_id` int(11) NOT NULL AUTO_INCREMENT,
    `link_id` int(11) NOT NULL,
    `date_ref` text NOT NULL,
    PRIMARY KEY (`log_id`),
    FOREIGN KEY (`link_id`) REFERENCES `links` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
