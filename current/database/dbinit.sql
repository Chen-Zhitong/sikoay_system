CREATE DATABASE huayujy CHARACTER SET utf8;
USE huayujy;
CREATE TABLE news (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        title VARCHAR(60) NOT NULL,
        author VARCHAR(60) NOT NULL,
        content TEXT ,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        image VARCHAR(255) ,
        type ENUM("notice","news","activity") NOT NULL,
        hits INT(8) UNSIGNED NOT NULL default 0
        )ENGINE = MyISAM;
CREATE TABLE notice (
        id VARCHAR(60) NOT NULL PRIMARY KEY,
        content TEXT NOT NULL,
        up_Date DATE NOT NULL
        )ENGINE = MyISAM;
CREATE TABLE admin (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        account VARCHAR(60) NOT NULL,
        password VARCHAR(128) NOT NULL,
        name VARCHAR(60) NOT NULL
        ) ENGINE = InnoDB;
CREATE TABLE userAccount (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        account VARCHAR(60) NOT NULL,
        password VARCHAR(128) NOT NULL,
        phone VARCHAR(60),
        type ENUM("Client","Company","Server") NOT NULL default "Client",
        money DOUBLE(12,2) NOT NULL default 0.00
        ) ENGINE = InnoDB AUTO_INCREMENT = 1000000000;
GRANT SELECT,UPDATE,DELETE,INSERT
ON huayujy.*
TO huayujy IDENTIFIED BY'hyjy2017.';
