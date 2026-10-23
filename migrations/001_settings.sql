--
--  App settings
-- -------------
-- A name is a key: the primary key keeps one row per setting.
CREATE TABLE `settings` (
    `name` varchar(100) NOT NULL,
    `value` varchar(255) NOT NULL,
    PRIMARY KEY (`name`)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4
    COLLATE=utf8mb4_unicode_ci;
