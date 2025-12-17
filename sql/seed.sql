-- Додавання країн
INSERT INTO `countries` 
(`id`, `alias`, `name_common`, `name_official`, `capital`, `region`, `subregion`, `population`, `area`, `timezones`, `languages`, `currencies`, `flag_png`, `flag_svg`) 
VALUES
(1, 'ukraine', 'Ukraine', 'Ukraine', 'Kyiv', 'Europe', 'Eastern Europe', 44130000, 603628, '["UTC+02:00"]', '{"ukr": "Ukrainian"}', '{"UAH": {"name": "Ukrainian hryvnia", "symbol": "₴"}}', '/assets/flags/ua.png', '/assets/flags/ua.svg'),
(2, 'poland', 'Poland', 'Republic of Poland', 'Warsaw', 'Europe', 'Central Europe', 38386000, 312679, '["UTC+01:00"]', '{"pol": "Polish"}', '{"PLN": {"name": "Polish złoty", "symbol": "zł"}}', '/assets/flags/pl.png', '/assets/flags/pl.svg');

-- Додавання міст
INSERT INTO `cities` 
(`id`, `alias`, `name`, `country_id`, `population`, `area`, `timezone`) 
VALUES
(1, 'kyiv', 'Kyiv', 1, 2967000, 839, 'UTC+02:00'),
(2, 'warsaw', 'Warsaw', 2, 1794000, 517, 'UTC+01:00');

