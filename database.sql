-- ─────────────────────────────────────────────────────────────────────────
-- database.sql
-- Run this once to set up the database and table.
--
-- In phpMyAdmin:  import this file
-- In terminal:    mysql -u root -p < database.sql
-- ─────────────────────────────────────────────────────────────────────────

CREATE DATABASE IF NOT EXISTS nodemcu_sbca_rfid_mysql
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE nodemcu_sbca_rfid_mysql;

CREATE TABLE IF NOT EXISTS table_nodemcu_rfidrc522_mysql (
    id     VARCHAR(50)  NOT NULL PRIMARY KEY COMMENT 'RFID card UID',
    name   VARCHAR(100) NOT NULL,
    gender VARCHAR(10)  NOT NULL,
    email  VARCHAR(100) NOT NULL,
    mobile VARCHAR(20)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
