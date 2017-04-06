SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `ea_appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `book_datetime` datetime DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `notes` text,
  `hash` text,
  `no_show` tinyint(4) DEFAULT '0',
  `is_unavailable` tinyint(4) DEFAULT '0',
  `id_users_provider` bigint(20) unsigned DEFAULT NULL,
  `id_users_customer` bigint(20) unsigned DEFAULT NULL,
  `id_services` bigint(20) unsigned DEFAULT NULL,
  `id_google_calendar` text,
  PRIMARY KEY (`id`),
  KEY `id_users_customer` (`id_users_customer`),
  KEY `id_services` (`id_services`),
  KEY `id_users_provider` (`id_users_provider`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;


CREATE TABLE IF NOT EXISTS `ea_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL COMMENT '0',
  `appointments` int(4) DEFAULT NULL COMMENT '0',
  `customers` int(4) DEFAULT NULL COMMENT '0',
  `services` int(4) DEFAULT NULL COMMENT '0',
  `users` int(4) DEFAULT NULL COMMENT '0',
  `reports` int(4) DEFAULT NULL COMMENT '0',
  `system_settings` int(4) DEFAULT NULL COMMENT '0',
  `user_settings` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;


CREATE TABLE IF NOT EXISTS `ea_secretaries_providers` (
  `id_users_secretary` bigint(20) unsigned NOT NULL,
  `id_users_provider` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_users_secretary`,`id_users_provider`),
  KEY `fk_ea_secretaries_providers_1` (`id_users_secretary`),
  KEY `fk_ea_secretaries_providers_2` (`id_users_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `ea_services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `description` text,
  `availabilities_type` varchar(32) DEFAULT 'flexible',
  `attendants_number` int(11) DEFAULT '1',
  `id_service_categories` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_service_categories` (`id_service_categories`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;


CREATE TABLE IF NOT EXISTS `ea_services_providers` (
  `id_users` bigint(20) unsigned NOT NULL,
  `id_services` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_users`,`id_services`),
  KEY `id_services` (`id_services`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ea_service_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;


CREATE TABLE IF NOT EXISTS `ea_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `value` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;


CREATE TABLE IF NOT EXISTS `ea_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(512) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `mobile_number` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `zip_code` varchar(64) DEFAULT NULL,
  `notes` text,
  `id_roles` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_roles` (`id_roles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

CREATE TABLE IF NOT EXISTS `ea_user_settings` (
  `id_users` bigint(20) unsigned NOT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `salt` varchar(512) DEFAULT NULL,
  `working_plan` text,
  `notifications` tinyint(4) DEFAULT '0',
  `google_sync` tinyint(4) DEFAULT '0',
  `google_token` text,
  `google_calendar` varchar(128) DEFAULT NULL,
  `sync_past_days` int(11) DEFAULT '5',
  `sync_future_days` int(11) DEFAULT '5',
  `calendar_view` varchar(32) DEFAULT 'default',
  PRIMARY KEY (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ea_countries` (
`id` int(11) NOT NULL auto_increment,
`country_code` varchar(2) NOT NULL default '',
`country_name` varchar(100) NOT NULL default '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ea_languages` (
  `langID` smallint(3) NOT NULL AUTO_INCREMENT,
  `language` char(49) DEFAULT NULL,
  `code` char(2) DEFAULT NULL,
  PRIMARY KEY (`langID`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ea_customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(512) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `phone_number_1` varchar(128) DEFAULT NULL,
  `phone_number_2` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `country_origin` varchar(2) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `marital_status` varchar(2) DEFAULT NULL,
  `notes` text,
  `id_roles` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_roles` (`id_roles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

ALTER TABLE `ea_appointments`
  ADD CONSTRAINT `ea_appointments_ibfk_2` FOREIGN KEY (`id_users_customer`) REFERENCES `ea_customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ea_appointments_ibfk_3` FOREIGN KEY (`id_services`) REFERENCES `ea_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ea_appointments_ibfk_4` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `ea_secretaries_providers`
  ADD CONSTRAINT `fk_ea_secretaries_providers_1` FOREIGN KEY (`id_users_secretary`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ea_secretaries_providers_2` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `ea_services`
  ADD CONSTRAINT `ea_services_ibfk_1` FOREIGN KEY (`id_service_categories`) REFERENCES `ea_service_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE `ea_services_providers`
  ADD CONSTRAINT `ea_services_providers_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ea_services_providers_ibfk_2` FOREIGN KEY (`id_services`) REFERENCES `ea_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `ea_users`
  ADD CONSTRAINT `ea_users_ibfk_1` FOREIGN KEY (`id_roles`) REFERENCES `ea_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `ea_user_settings`
  ADD CONSTRAINT `ea_user_settings_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


INSERT INTO `ea_roles` (`id`, `name`, `slug`, `is_admin`, `appointments`, `customers`, `services`, `users`, `reports`, `system_settings`, `user_settings`) VALUES
(1, 'Administrator', 'admin', 1, 15, 15, 15, 15, 15, 15, 15),
(2, 'Provider', 'provider', 0, 15, 15, 0,0, 0, 0, 15),
(3, 'Customer', 'customer', 0, 0, 0, 0, 0,0, 0, 0),
(4, 'Secretary', 'secretary', 0, 15, 15, 0, 0, 0, 0, 15);

INSERT INTO `ea_settings` (`name`, `value`) VALUES
('company_working_plan', '{"monday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"tuesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"wednesday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"thursday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"friday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"saturday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]},"sunday":{"start":"09:00","end":"18:00","breaks":[{"start":"11:20","end":"11:30"},{"start":"14:30","end":"15:00"}]}}'),
('book_advance_timeout', '30');

INSERT INTO `ea_countries` VALUES (null, 'AF', 'Afghanistan');
INSERT INTO `ea_countries` VALUES (null, 'AL', 'Albania');
INSERT INTO `ea_countries` VALUES (null, 'DZ', 'Algeria');
INSERT INTO `ea_countries` VALUES (null, 'DS', 'American Samoa');
INSERT INTO `ea_countries` VALUES (null, 'AD', 'Andorra');
INSERT INTO `ea_countries` VALUES (null, 'AO', 'Angola');
INSERT INTO `ea_countries` VALUES (null, 'AI', 'Anguilla');
INSERT INTO `ea_countries` VALUES (null, 'AQ', 'Antarctica');
INSERT INTO `ea_countries` VALUES (null, 'AG', 'Antigua and Barbuda');
INSERT INTO `ea_countries` VALUES (null, 'AR', 'Argentina');
INSERT INTO `ea_countries` VALUES (null, 'AM', 'Armenia');
INSERT INTO `ea_countries` VALUES (null, 'AW', 'Aruba');
INSERT INTO `ea_countries` VALUES (null, 'AU', 'Australia');
INSERT INTO `ea_countries` VALUES (null, 'AT', 'Austria');
INSERT INTO `ea_countries` VALUES (null, 'AZ', 'Azerbaijan');
INSERT INTO `ea_countries` VALUES (null, 'BS', 'Bahamas');
INSERT INTO `ea_countries` VALUES (null, 'BH', 'Bahrain');
INSERT INTO `ea_countries` VALUES (null, 'BD', 'Bangladesh');
INSERT INTO `ea_countries` VALUES (null, 'BB', 'Barbados');
INSERT INTO `ea_countries` VALUES (null, 'BY', 'Belarus');
INSERT INTO `ea_countries` VALUES (null, 'BE', 'Belgium');
INSERT INTO `ea_countries` VALUES (null, 'BZ', 'Belize');
INSERT INTO `ea_countries` VALUES (null, 'BJ', 'Benin');
INSERT INTO `ea_countries` VALUES (null, 'BM', 'Bermuda');
INSERT INTO `ea_countries` VALUES (null, 'BT', 'Bhutan');
INSERT INTO `ea_countries` VALUES (null, 'BO', 'Bolivia');
INSERT INTO `ea_countries` VALUES (null, 'BA', 'Bosnia and Herzegovina');
INSERT INTO `ea_countries` VALUES (null, 'BW', 'Botswana');
INSERT INTO `ea_countries` VALUES (null, 'BV', 'Bouvet Island');
INSERT INTO `ea_countries` VALUES (null, 'BR', 'Brazil');
INSERT INTO `ea_countries` VALUES (null, 'IO', 'British Indian Ocean Territory');
INSERT INTO `ea_countries` VALUES (null, 'BN', 'Brunei Darussalam');
INSERT INTO `ea_countries` VALUES (null, 'BG', 'Bulgaria');
INSERT INTO `ea_countries` VALUES (null, 'BF', 'Burkina Faso');
INSERT INTO `ea_countries` VALUES (null, 'BI', 'Burundi');
INSERT INTO `ea_countries` VALUES (null, 'KH', 'Cambodia');
INSERT INTO `ea_countries` VALUES (null, 'CM', 'Cameroon');
INSERT INTO `ea_countries` VALUES (null, 'CA', 'Canada');
INSERT INTO `ea_countries` VALUES (null, 'CV', 'Cape Verde');
INSERT INTO `ea_countries` VALUES (null, 'KY', 'Cayman Islands');
INSERT INTO `ea_countries` VALUES (null, 'CF', 'Central African Republic');
INSERT INTO `ea_countries` VALUES (null, 'TD', 'Chad');
INSERT INTO `ea_countries` VALUES (null, 'CL', 'Chile');
INSERT INTO `ea_countries` VALUES (null, 'CN', 'China');
INSERT INTO `ea_countries` VALUES (null, 'CX', 'Christmas Island');
INSERT INTO `ea_countries` VALUES (null, 'CC', 'Cocos (Keeling) Islands');
INSERT INTO `ea_countries` VALUES (null, 'CO', 'Colombia');
INSERT INTO `ea_countries` VALUES (null, 'KM', 'Comoros');
INSERT INTO `ea_countries` VALUES (null, 'CG', 'Congo');
INSERT INTO `ea_countries` VALUES (null, 'CK', 'Cook Islands');
INSERT INTO `ea_countries` VALUES (null, 'CR', 'Costa Rica');
INSERT INTO `ea_countries` VALUES (null, 'HR', 'Croatia (Hrvatska)');
INSERT INTO `ea_countries` VALUES (null, 'CU', 'Cuba');
INSERT INTO `ea_countries` VALUES (null, 'CY', 'Cyprus');
INSERT INTO `ea_countries` VALUES (null, 'CZ', 'Czech Republic');
INSERT INTO `ea_countries` VALUES (null, 'DK', 'Denmark');
INSERT INTO `ea_countries` VALUES (null, 'DJ', 'Djibouti');
INSERT INTO `ea_countries` VALUES (null, 'DM', 'Dominica');
INSERT INTO `ea_countries` VALUES (null, 'DO', 'Dominican Republic');
INSERT INTO `ea_countries` VALUES (null, 'TP', 'East Timor');
INSERT INTO `ea_countries` VALUES (null, 'EC', 'Ecuador');
INSERT INTO `ea_countries` VALUES (null, 'EG', 'Egypt');
INSERT INTO `ea_countries` VALUES (null, 'SV', 'El Salvador');
INSERT INTO `ea_countries` VALUES (null, 'GQ', 'Equatorial Guinea');
INSERT INTO `ea_countries` VALUES (null, 'ER', 'Eritrea');
INSERT INTO `ea_countries` VALUES (null, 'EE', 'Estonia');
INSERT INTO `ea_countries` VALUES (null, 'ET', 'Ethiopia');
INSERT INTO `ea_countries` VALUES (null, 'FK', 'Falkland Islands (Malvinas)');
INSERT INTO `ea_countries` VALUES (null, 'FO', 'Faroe Islands');
INSERT INTO `ea_countries` VALUES (null, 'FJ', 'Fiji');
INSERT INTO `ea_countries` VALUES (null, 'FI', 'Finland');
INSERT INTO `ea_countries` VALUES (null, 'FR', 'France');
INSERT INTO `ea_countries` VALUES (null, 'FX', 'France, Metropolitan');
INSERT INTO `ea_countries` VALUES (null, 'GF', 'French Guiana');
INSERT INTO `ea_countries` VALUES (null, 'PF', 'French Polynesia');
INSERT INTO `ea_countries` VALUES (null, 'TF', 'French Southern Territories');
INSERT INTO `ea_countries` VALUES (null, 'GA', 'Gabon');
INSERT INTO `ea_countries` VALUES (null, 'GM', 'Gambia');
INSERT INTO `ea_countries` VALUES (null, 'GE', 'Georgia');
INSERT INTO `ea_countries` VALUES (null, 'DE', 'Germany');
INSERT INTO `ea_countries` VALUES (null, 'GH', 'Ghana');
INSERT INTO `ea_countries` VALUES (null, 'GI', 'Gibraltar');
INSERT INTO `ea_countries` VALUES (null, 'GK', 'Guernsey');
INSERT INTO `ea_countries` VALUES (null, 'GR', 'Greece');
INSERT INTO `ea_countries` VALUES (null, 'GL', 'Greenland');
INSERT INTO `ea_countries` VALUES (null, 'GD', 'Grenada');
INSERT INTO `ea_countries` VALUES (null, 'GP', 'Guadeloupe');
INSERT INTO `ea_countries` VALUES (null, 'GU', 'Guam');
INSERT INTO `ea_countries` VALUES (null, 'GT', 'Guatemala');
INSERT INTO `ea_countries` VALUES (null, 'GN', 'Guinea');
INSERT INTO `ea_countries` VALUES (null, 'GW', 'Guinea-Bissau');
INSERT INTO `ea_countries` VALUES (null, 'GY', 'Guyana');
INSERT INTO `ea_countries` VALUES (null, 'HT', 'Haiti');
INSERT INTO `ea_countries` VALUES (null, 'HM', 'Heard and Mc Donald Islands');
INSERT INTO `ea_countries` VALUES (null, 'HN', 'Honduras');
INSERT INTO `ea_countries` VALUES (null, 'HK', 'Hong Kong');
INSERT INTO `ea_countries` VALUES (null, 'HU', 'Hungary');
INSERT INTO `ea_countries` VALUES (null, 'IS', 'Iceland');
INSERT INTO `ea_countries` VALUES (null, 'IN', 'India');
INSERT INTO `ea_countries` VALUES (null, 'IM', 'Isle of Man');
INSERT INTO `ea_countries` VALUES (null, 'ID', 'Indonesia');
INSERT INTO `ea_countries` VALUES (null, 'IR', 'Iran (Islamic Republic of)');
INSERT INTO `ea_countries` VALUES (null, 'IQ', 'Iraq');
INSERT INTO `ea_countries` VALUES (null, 'IE', 'Ireland');
INSERT INTO `ea_countries` VALUES (null, 'IL', 'Israel');
INSERT INTO `ea_countries` VALUES (null, 'IT', 'Italy');
INSERT INTO `ea_countries` VALUES (null, 'CI', 'Ivory Coast');
INSERT INTO `ea_countries` VALUES (null, 'JE', 'Jersey');
INSERT INTO `ea_countries` VALUES (null, 'JM', 'Jamaica');
INSERT INTO `ea_countries` VALUES (null, 'JP', 'Japan');
INSERT INTO `ea_countries` VALUES (null, 'JO', 'Jordan');
INSERT INTO `ea_countries` VALUES (null, 'KZ', 'Kazakhstan');
INSERT INTO `ea_countries` VALUES (null, 'KE', 'Kenya');
INSERT INTO `ea_countries` VALUES (null, 'KI', 'Kiribati');
INSERT INTO `ea_countries` VALUES (null, 'KP', 'Korea, Democratic People''s Republic of');
INSERT INTO `ea_countries` VALUES (null, 'KR', 'Korea, Republic of');
INSERT INTO `ea_countries` VALUES (null, 'XK', 'Kosovo');
INSERT INTO `ea_countries` VALUES (null, 'KW', 'Kuwait');
INSERT INTO `ea_countries` VALUES (null, 'KG', 'Kyrgyzstan');
INSERT INTO `ea_countries` VALUES (null, 'LA', 'Lao People''s Democratic Republic');
INSERT INTO `ea_countries` VALUES (null, 'LV', 'Latvia');
INSERT INTO `ea_countries` VALUES (null, 'LB', 'Lebanon');
INSERT INTO `ea_countries` VALUES (null, 'LS', 'Lesotho');
INSERT INTO `ea_countries` VALUES (null, 'LR', 'Liberia');
INSERT INTO `ea_countries` VALUES (null, 'LY', 'Libyan Arab Jamahiriya');
INSERT INTO `ea_countries` VALUES (null, 'LI', 'Liechtenstein');
INSERT INTO `ea_countries` VALUES (null, 'LT', 'Lithuania');
INSERT INTO `ea_countries` VALUES (null, 'LU', 'Luxembourg');
INSERT INTO `ea_countries` VALUES (null, 'MO', 'Macau');
INSERT INTO `ea_countries` VALUES (null, 'MK', 'Macedonia');
INSERT INTO `ea_countries` VALUES (null, 'MG', 'Madagascar');
INSERT INTO `ea_countries` VALUES (null, 'MW', 'Malawi');
INSERT INTO `ea_countries` VALUES (null, 'MY', 'Malaysia');
INSERT INTO `ea_countries` VALUES (null, 'MV', 'Maldives');
INSERT INTO `ea_countries` VALUES (null, 'ML', 'Mali');
INSERT INTO `ea_countries` VALUES (null, 'MT', 'Malta');
INSERT INTO `ea_countries` VALUES (null, 'MH', 'Marshall Islands');
INSERT INTO `ea_countries` VALUES (null, 'MQ', 'Martinique');
INSERT INTO `ea_countries` VALUES (null, 'MR', 'Mauritania');
INSERT INTO `ea_countries` VALUES (null, 'MU', 'Mauritius');
INSERT INTO `ea_countries` VALUES (null, 'TY', 'Mayotte');
INSERT INTO `ea_countries` VALUES (null, 'MX', 'Mexico');
INSERT INTO `ea_countries` VALUES (null, 'FM', 'Micronesia, Federated States of');
INSERT INTO `ea_countries` VALUES (null, 'MD', 'Moldova, Republic of');
INSERT INTO `ea_countries` VALUES (null, 'MC', 'Monaco');
INSERT INTO `ea_countries` VALUES (null, 'MN', 'Mongolia');
INSERT INTO `ea_countries` VALUES (null, 'ME', 'Montenegro');
INSERT INTO `ea_countries` VALUES (null, 'MS', 'Montserrat');
INSERT INTO `ea_countries` VALUES (null, 'MA', 'Morocco');
INSERT INTO `ea_countries` VALUES (null, 'MZ', 'Mozambique');
INSERT INTO `ea_countries` VALUES (null, 'MM', 'Myanmar');
INSERT INTO `ea_countries` VALUES (null, 'NA', 'Namibia');
INSERT INTO `ea_countries` VALUES (null, 'NR', 'Nauru');
INSERT INTO `ea_countries` VALUES (null, 'NP', 'Nepal');
INSERT INTO `ea_countries` VALUES (null, 'NL', 'Netherlands');
INSERT INTO `ea_countries` VALUES (null, 'AN', 'Netherlands Antilles');
INSERT INTO `ea_countries` VALUES (null, 'NC', 'New Caledonia');
INSERT INTO `ea_countries` VALUES (null, 'NZ', 'New Zealand');
INSERT INTO `ea_countries` VALUES (null, 'NI', 'Nicaragua');
INSERT INTO `ea_countries` VALUES (null, 'NE', 'Niger');
INSERT INTO `ea_countries` VALUES (null, 'NG', 'Nigeria');
INSERT INTO `ea_countries` VALUES (null, 'NU', 'Niue');
INSERT INTO `ea_countries` VALUES (null, 'NF', 'Norfolk Island');
INSERT INTO `ea_countries` VALUES (null, 'MP', 'Northern Mariana Islands');
INSERT INTO `ea_countries` VALUES (null, 'NO', 'Norway');
INSERT INTO `ea_countries` VALUES (null, 'OM', 'Oman');
INSERT INTO `ea_countries` VALUES (null, 'PK', 'Pakistan');
INSERT INTO `ea_countries` VALUES (null, 'PW', 'Palau');
INSERT INTO `ea_countries` VALUES (null, 'PS', 'Palestine');
INSERT INTO `ea_countries` VALUES (null, 'PA', 'Panama');
INSERT INTO `ea_countries` VALUES (null, 'PG', 'Papua New Guinea');
INSERT INTO `ea_countries` VALUES (null, 'PY', 'Paraguay');
INSERT INTO `ea_countries` VALUES (null, 'PE', 'Peru');
INSERT INTO `ea_countries` VALUES (null, 'PH', 'Philippines');
INSERT INTO `ea_countries` VALUES (null, 'PN', 'Pitcairn');
INSERT INTO `ea_countries` VALUES (null, 'PL', 'Poland');
INSERT INTO `ea_countries` VALUES (null, 'PT', 'Portugal');
INSERT INTO `ea_countries` VALUES (null, 'PR', 'Puerto Rico');
INSERT INTO `ea_countries` VALUES (null, 'QA', 'Qatar');
INSERT INTO `ea_countries` VALUES (null, 'RE', 'Reunion');
INSERT INTO `ea_countries` VALUES (null, 'RO', 'Romania');
INSERT INTO `ea_countries` VALUES (null, 'RU', 'Russian Federation');
INSERT INTO `ea_countries` VALUES (null, 'RW', 'Rwanda');
INSERT INTO `ea_countries` VALUES (null, 'KN', 'Saint Kitts and Nevis');
INSERT INTO `ea_countries` VALUES (null, 'LC', 'Saint Lucia');
INSERT INTO `ea_countries` VALUES (null, 'VC', 'Saint Vincent and the Grenadines');
INSERT INTO `ea_countries` VALUES (null, 'WS', 'Samoa');
INSERT INTO `ea_countries` VALUES (null, 'SM', 'San Marino');
INSERT INTO `ea_countries` VALUES (null, 'ST', 'Sao Tome and Principe');
INSERT INTO `ea_countries` VALUES (null, 'SA', 'Saudi Arabia');
INSERT INTO `ea_countries` VALUES (null, 'SN', 'Senegal');
INSERT INTO `ea_countries` VALUES (null, 'RS', 'Serbia');
INSERT INTO `ea_countries` VALUES (null, 'SC', 'Seychelles');
INSERT INTO `ea_countries` VALUES (null, 'SL', 'Sierra Leone');
INSERT INTO `ea_countries` VALUES (null, 'SG', 'Singapore');
INSERT INTO `ea_countries` VALUES (null, 'SK', 'Slovakia');
INSERT INTO `ea_countries` VALUES (null, 'SI', 'Slovenia');
INSERT INTO `ea_countries` VALUES (null, 'SB', 'Solomon Islands');
INSERT INTO `ea_countries` VALUES (null, 'SO', 'Somalia');
INSERT INTO `ea_countries` VALUES (null, 'ZA', 'South Africa');
INSERT INTO `ea_countries` VALUES (null, 'GS', 'South Georgia South Sandwich Islands');
INSERT INTO `ea_countries` VALUES (null, 'ES', 'Spain');
INSERT INTO `ea_countries` VALUES (null, 'LK', 'Sri Lanka');
INSERT INTO `ea_countries` VALUES (null, 'SH', 'St. Helena');
INSERT INTO `ea_countries` VALUES (null, 'PM', 'St. Pierre and Miquelon');
INSERT INTO `ea_countries` VALUES (null, 'SD', 'Sudan');
INSERT INTO `ea_countries` VALUES (null, 'SR', 'Suriname');
INSERT INTO `ea_countries` VALUES (null, 'SJ', 'Svalbard and Jan Mayen Islands');
INSERT INTO `ea_countries` VALUES (null, 'SZ', 'Swaziland');
INSERT INTO `ea_countries` VALUES (null, 'SE', 'Sweden');
INSERT INTO `ea_countries` VALUES (null, 'CH', 'Switzerland');
INSERT INTO `ea_countries` VALUES (null, 'SY', 'Syrian Arab Republic');
INSERT INTO `ea_countries` VALUES (null, 'TW', 'Taiwan');
INSERT INTO `ea_countries` VALUES (null, 'TJ', 'Tajikistan');
INSERT INTO `ea_countries` VALUES (null, 'TZ', 'Tanzania, United Republic of');
INSERT INTO `ea_countries` VALUES (null, 'TH', 'Thailand');
INSERT INTO `ea_countries` VALUES (null, 'TG', 'Togo');
INSERT INTO `ea_countries` VALUES (null, 'TK', 'Tokelau');
INSERT INTO `ea_countries` VALUES (null, 'TO', 'Tonga');
INSERT INTO `ea_countries` VALUES (null, 'TT', 'Trinidad and Tobago');
INSERT INTO `ea_countries` VALUES (null, 'TN', 'Tunisia');
INSERT INTO `ea_countries` VALUES (null, 'TR', 'Turkey');
INSERT INTO `ea_countries` VALUES (null, 'TM', 'Turkmenistan');
INSERT INTO `ea_countries` VALUES (null, 'TC', 'Turks and Caicos Islands');
INSERT INTO `ea_countries` VALUES (null, 'TV', 'Tuvalu');
INSERT INTO `ea_countries` VALUES (null, 'UG', 'Uganda');
INSERT INTO `ea_countries` VALUES (null, 'UA', 'Ukraine');
INSERT INTO `ea_countries` VALUES (null, 'AE', 'United Arab Emirates');
INSERT INTO `ea_countries` VALUES (null, 'GB', 'United Kingdom');
INSERT INTO `ea_countries` VALUES (null, 'US', 'United States');
INSERT INTO `ea_countries` VALUES (null, 'UM', 'United States minor outlying islands');
INSERT INTO `ea_countries` VALUES (null, 'UY', 'Uruguay');
INSERT INTO `ea_countries` VALUES (null, 'UZ', 'Uzbekistan');
INSERT INTO `ea_countries` VALUES (null, 'VU', 'Vanuatu');
INSERT INTO `ea_countries` VALUES (null, 'VA', 'Vatican City State');
INSERT INTO `ea_countries` VALUES (null, 'VE', 'Venezuela');
INSERT INTO `ea_countries` VALUES (null, 'VN', 'Vietnam');
INSERT INTO `ea_countries` VALUES (null, 'VG', 'Virgin Islands (British)');
INSERT INTO `ea_countries` VALUES (null, 'VI', 'Virgin Islands (U.S.)');
INSERT INTO `ea_countries` VALUES (null, 'WF', 'Wallis and Futuna Islands');
INSERT INTO `ea_countries` VALUES (null, 'EH', 'Western Sahara');
INSERT INTO `ea_countries` VALUES (null, 'YE', 'Yemen');
INSERT INTO `ea_countries` VALUES (null, 'ZR', 'Zaire');
INSERT INTO `ea_countries` VALUES (null, 'ZM', 'Zambia');
INSERT INTO `ea_countries` VALUES (null, 'ZW', 'Zimbabwe');
INSERT INTO `ea_countries` VALUES (null, 'ZW', 'Zimbabwe');
/* Custom for MSF */
INSERT INTO `ea_countries` VALUES (null, 'PX', 'Palestinian living in Syria');

INSERT INTO `ea_languages` VALUES ('1', 'English', 'EN');
INSERT INTO `ea_languages` VALUES ('2', 'Afar', 'aa');
INSERT INTO `ea_languages` VALUES ('3', 'Abkhazian', 'ab');
INSERT INTO `ea_languages` VALUES ('4', 'Afrikaans', 'af');
INSERT INTO `ea_languages` VALUES ('5', 'Amharic', 'am');
INSERT INTO `ea_languages` VALUES ('6', 'Arabic', 'ar');
INSERT INTO `ea_languages` VALUES ('7', 'Assamese', 'as');
INSERT INTO `ea_languages` VALUES ('8', 'Aymara', 'ay');
INSERT INTO `ea_languages` VALUES ('9', 'Azerbaijani', 'az');
INSERT INTO `ea_languages` VALUES ('10', 'Bashkir', 'ba');
INSERT INTO `ea_languages` VALUES ('11', 'Byelorussian', 'be');
INSERT INTO `ea_languages` VALUES ('12', 'Bulgarian', 'bg');
INSERT INTO `ea_languages` VALUES ('13', 'Bihari', 'bh');
INSERT INTO `ea_languages` VALUES ('14', 'Bislama', 'bi');
INSERT INTO `ea_languages` VALUES ('15', 'Bengali/Bangla', 'bn');
INSERT INTO `ea_languages` VALUES ('16', 'Tibetan', 'bo');
INSERT INTO `ea_languages` VALUES ('17', 'Breton', 'br');
INSERT INTO `ea_languages` VALUES ('18', 'Catalan', 'ca');
INSERT INTO `ea_languages` VALUES ('19', 'Corsican', 'co');
INSERT INTO `ea_languages` VALUES ('20', 'Czech', 'cs');
INSERT INTO `ea_languages` VALUES ('21', 'Welsh', 'cy');
INSERT INTO `ea_languages` VALUES ('22', 'Danish', 'da');
INSERT INTO `ea_languages` VALUES ('23', 'German', 'de');
INSERT INTO `ea_languages` VALUES ('24', 'Bhutani', 'dz');
INSERT INTO `ea_languages` VALUES ('25', 'Greek', 'el');
INSERT INTO `ea_languages` VALUES ('26', 'Esperanto', 'eo');
INSERT INTO `ea_languages` VALUES ('27', 'Spanish', 'es');
INSERT INTO `ea_languages` VALUES ('28', 'Estonian', 'et');
INSERT INTO `ea_languages` VALUES ('29', 'Basque', 'eu');
INSERT INTO `ea_languages` VALUES ('30', 'Persian', 'fa');
INSERT INTO `ea_languages` VALUES ('31', 'Finnish', 'fi');
INSERT INTO `ea_languages` VALUES ('32', 'Fiji', 'fj');
INSERT INTO `ea_languages` VALUES ('33', 'Faeroese', 'fo');
INSERT INTO `ea_languages` VALUES ('34', 'French', 'fr');
INSERT INTO `ea_languages` VALUES ('35', 'Frisian', 'fy');
INSERT INTO `ea_languages` VALUES ('36', 'Irish', 'ga');
INSERT INTO `ea_languages` VALUES ('37', 'Scots/Gaelic', 'gd');
INSERT INTO `ea_languages` VALUES ('38', 'Galician', 'gl');
INSERT INTO `ea_languages` VALUES ('39', 'Guarani', 'gn');
INSERT INTO `ea_languages` VALUES ('40', 'Gujarati', 'gu');
INSERT INTO `ea_languages` VALUES ('41', 'Hausa', 'ha');
INSERT INTO `ea_languages` VALUES ('42', 'Hindi', 'hi');
INSERT INTO `ea_languages` VALUES ('43', 'Croatian', 'hr');
INSERT INTO `ea_languages` VALUES ('44', 'Hungarian', 'hu');
INSERT INTO `ea_languages` VALUES ('45', 'Armenian', 'hy');
INSERT INTO `ea_languages` VALUES ('46', 'Interlingua', 'ia');
INSERT INTO `ea_languages` VALUES ('47', 'Interlingue', 'ie');
INSERT INTO `ea_languages` VALUES ('48', 'Inupiak', 'ik');
INSERT INTO `ea_languages` VALUES ('49', 'Indonesian', 'in');
INSERT INTO `ea_languages` VALUES ('50', 'Icelandic', 'is');
INSERT INTO `ea_languages` VALUES ('51', 'Italian', 'it');
INSERT INTO `ea_languages` VALUES ('52', 'Hebrew', 'iw');
INSERT INTO `ea_languages` VALUES ('53', 'Japanese', 'ja');
INSERT INTO `ea_languages` VALUES ('54', 'Yiddish', 'ji');
INSERT INTO `ea_languages` VALUES ('55', 'Javanese', 'jw');
INSERT INTO `ea_languages` VALUES ('56', 'Georgian', 'ka');
INSERT INTO `ea_languages` VALUES ('57', 'Kazakh', 'kk');
INSERT INTO `ea_languages` VALUES ('58', 'Greenlandic', 'kl');
INSERT INTO `ea_languages` VALUES ('59', 'Cambodian', 'km');
INSERT INTO `ea_languages` VALUES ('60', 'Kannada', 'kn');
INSERT INTO `ea_languages` VALUES ('61', 'Korean', 'ko');
INSERT INTO `ea_languages` VALUES ('62', 'Kashmiri', 'ks');
INSERT INTO `ea_languages` VALUES ('63', 'Kurdish', 'ku');
INSERT INTO `ea_languages` VALUES ('64', 'Kirghiz', 'ky');
INSERT INTO `ea_languages` VALUES ('65', 'Latin', 'la');
INSERT INTO `ea_languages` VALUES ('66', 'Lingala', 'ln');
INSERT INTO `ea_languages` VALUES ('67', 'Laothian', 'lo');
INSERT INTO `ea_languages` VALUES ('68', 'Lithuanian', 'lt');
INSERT INTO `ea_languages` VALUES ('69', 'Latvian/Lettish', 'lv');
INSERT INTO `ea_languages` VALUES ('70', 'Malagasy', 'mg');
INSERT INTO `ea_languages` VALUES ('71', 'Maori', 'mi');
INSERT INTO `ea_languages` VALUES ('72', 'Macedonian', 'mk');
INSERT INTO `ea_languages` VALUES ('73', 'Malayalam', 'ml');
INSERT INTO `ea_languages` VALUES ('74', 'Mongolian', 'mn');
INSERT INTO `ea_languages` VALUES ('75', 'Moldavian', 'mo');
INSERT INTO `ea_languages` VALUES ('76', 'Marathi', 'mr');
INSERT INTO `ea_languages` VALUES ('77', 'Malay', 'ms');
INSERT INTO `ea_languages` VALUES ('78', 'Maltese', 'mt');
INSERT INTO `ea_languages` VALUES ('79', 'Burmese', 'my');
INSERT INTO `ea_languages` VALUES ('80', 'Nauru', 'na');
INSERT INTO `ea_languages` VALUES ('81', 'Nepali', 'ne');
INSERT INTO `ea_languages` VALUES ('82', 'Dutch', 'nl');
INSERT INTO `ea_languages` VALUES ('83', 'Norwegian', 'no');
INSERT INTO `ea_languages` VALUES ('84', 'Occitan', 'oc');
INSERT INTO `ea_languages` VALUES ('85', '(Afan)/Oromoor/Oriya', 'om');
INSERT INTO `ea_languages` VALUES ('86', 'Punjabi', 'pa');
INSERT INTO `ea_languages` VALUES ('87', 'Polish', 'pl');
INSERT INTO `ea_languages` VALUES ('88', 'Pashto/Pushto', 'ps');
INSERT INTO `ea_languages` VALUES ('89', 'Portuguese', 'pt');
INSERT INTO `ea_languages` VALUES ('90', 'Quechua', 'qu');
INSERT INTO `ea_languages` VALUES ('91', 'Rhaeto-Romance', 'rm');
INSERT INTO `ea_languages` VALUES ('92', 'Kirundi', 'rn');
INSERT INTO `ea_languages` VALUES ('93', 'Romanian', 'ro');
INSERT INTO `ea_languages` VALUES ('94', 'Russian', 'ru');
INSERT INTO `ea_languages` VALUES ('95', 'Kinyarwanda', 'rw');
INSERT INTO `ea_languages` VALUES ('96', 'Sanskrit', 'sa');
INSERT INTO `ea_languages` VALUES ('97', 'Sindhi', 'sd');
INSERT INTO `ea_languages` VALUES ('98', 'Sangro', 'sg');
INSERT INTO `ea_languages` VALUES ('99', 'Serbo-Croatian', 'sh');
INSERT INTO `ea_languages` VALUES ('100', 'Singhalese', 'si');
INSERT INTO `ea_languages` VALUES ('101', 'Slovak', 'sk');
INSERT INTO `ea_languages` VALUES ('102', 'Slovenian', 'sl');
INSERT INTO `ea_languages` VALUES ('103', 'Samoan', 'sm');
INSERT INTO `ea_languages` VALUES ('104', 'Shona', 'sn');
INSERT INTO `ea_languages` VALUES ('105', 'Somali', 'so');
INSERT INTO `ea_languages` VALUES ('106', 'Albanian', 'sq');
INSERT INTO `ea_languages` VALUES ('107', 'Serbian', 'sr');
INSERT INTO `ea_languages` VALUES ('108', 'Siswati', 'ss');
INSERT INTO `ea_languages` VALUES ('109', 'Sesotho', 'st');
INSERT INTO `ea_languages` VALUES ('110', 'Sundanese', 'su');
INSERT INTO `ea_languages` VALUES ('111', 'Swedish', 'sv');
INSERT INTO `ea_languages` VALUES ('112', 'Swahili', 'sw');
INSERT INTO `ea_languages` VALUES ('113', 'Tamil', 'ta');
INSERT INTO `ea_languages` VALUES ('114', 'Tegulu', 'te');
INSERT INTO `ea_languages` VALUES ('115', 'Tajik', 'tg');
INSERT INTO `ea_languages` VALUES ('116', 'Thai', 'th');
INSERT INTO `ea_languages` VALUES ('117', 'Tigrinya', 'ti');
INSERT INTO `ea_languages` VALUES ('118', 'Turkmen', 'tk');
INSERT INTO `ea_languages` VALUES ('119', 'Tagalog', 'tl');
INSERT INTO `ea_languages` VALUES ('120', 'Setswana', 'tn');
INSERT INTO `ea_languages` VALUES ('121', 'Tonga', 'to');
INSERT INTO `ea_languages` VALUES ('122', 'Turkish', 'tr');
INSERT INTO `ea_languages` VALUES ('123', 'Tsonga', 'ts');
INSERT INTO `ea_languages` VALUES ('124', 'Tatar', 'tt');
INSERT INTO `ea_languages` VALUES ('125', 'Twi', 'tw');
INSERT INTO `ea_languages` VALUES ('126', 'Ukrainian', 'uk');
INSERT INTO `ea_languages` VALUES ('127', 'Urdu', 'ur');
INSERT INTO `ea_languages` VALUES ('128', 'Uzbek', 'uz');
INSERT INTO `ea_languages` VALUES ('129', 'Vietnamese', 'vi');
INSERT INTO `ea_languages` VALUES ('130', 'Volapuk', 'vo');
INSERT INTO `ea_languages` VALUES ('131', 'Wolof', 'wo');
INSERT INTO `ea_languages` VALUES ('132', 'Xhosa', 'xh');
INSERT INTO `ea_languages` VALUES ('133', 'Yoruba', 'yo');
INSERT INTO `ea_languages` VALUES ('134', 'Chinese', 'zh');
INSERT INTO `ea_languages` VALUES ('135', 'Zulu', 'zu');
/* Custom for MSF */
INSERT INTO `ea_languages` VALUES ('136', 'Dari', 'di');
