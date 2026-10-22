--  Settings by name
-- -----------------
-- A name is a key: the primary key keeps one row per setting. The table also gets the full UTF-8
-- (utf8mb4) like the other tables. Fails on duplicate names, which must be removed by hand first.
ALTER TABLE `settings`
    CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    ADD PRIMARY KEY (`name`);
