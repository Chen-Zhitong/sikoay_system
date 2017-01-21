CREATE DATABASE huayujk CHARACTER SET utf8;
USE huayujk;
CREATE TABLE news (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        title VARCHAR(60) NOT NULL,
        author VARCHAR(60) NOT NULL,
        content TEXT ,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        image VARCHAR(255) ,
        type ENUM("industryNews","companyNews","hearthLife","hearthFood","hearthManage","doctorGuidance","tumourCure","hearthMentality","womanGuidance","publicBenefit") NOT NULL,
        hits INT(6) UNSIGNED NOT NULL default 0,
        userId INT(12) UNSIGNED
        )ENGINE = MyISAM;
CREATE TABLE notice (
        id VARCHAR(60) NOT NULL PRIMARY KEY,
        content TEXT NOT NULL,
        up_Date DATE NOT NULL
        )ENGINE = MyISAM;
CREATE TABLE hearthTest (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        title VARCHAR(60) NOT NULL,
        author VARCHAR(60) NOT NULL,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        image VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        hits INT(6) UNSIGNED NOT NULL default 0
        )ENGINE = MyISAM;
CREATE TABLE hearthTestQuestion (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        content VARCHAR(2048) NOT NULL,
        type ENUM("checkbox","radio") NOT NULL,
        testId INT(12) UNSIGNED NOT NULL
        )ENGINE = MyISAM;
CREATE TABLE hearthTestAnswer (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        content VARCHAR(1024) NOT NULL,
        grade INT(6) NOT NULL DEFAULT 0,
        questionId INT(12) UNSIGNED NOT NULL
        )ENGINE = MyISAM;
CREATE TABLE hearthTestResult (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        content TEXT NOT NULL,
        comment VARCHAR(1024) NOT NULL,
        grade INT(6) NOT NULL DEFAULT 0,
        testId INT(12) UNSIGNED NOT NULL
        )ENGINE = MyISAM;
CREATE TABLE serve (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        title VARCHAR(128) NOT NULL,
        content TEXT,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        image VARCHAR(255) NOT NULL,
        phone VARCHAR(64),
        province VARCHAR(60),
        city VARCHAR(60),
        area VARCHAR(60),
        address VARCHAR(512),
        hits INT(8) UNSIGNED NOT NULL default 0,
        price DOUBLE(8,2) NOT NULL default 0.00,
        type VARCHAR(60) NOT NULL,
        turnover DOUBLE(10,2) NOT NULL default 0.00,
        status ENUM("not_audit","in_review","not_pass","shelves","sold_out","delete") NOT NULL default "not_audit",
        serverId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB AUTO_INCREMENT = 1000000000;
CREATE TABLE serveDetails (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        type ENUM("shop","home","phone","on_line") NOT NULL,
        duration INT(6) NOT NULL,
        content TEXT NOT NULL,
        serveId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB;
CREATE TABLE serveTimeFarme (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        week ENUM("Sun","Mon","Tue","Wed","Thu","Fri","Sat") NOT NULL,
        timeStart TIME NOT NULL,
        timeEnd TIME NOT NULL,
        serveDetailsId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB;
CREATE TABLE serveImages (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        image VARCHAR(512) NOT NULL,
        serveId INT(12) UNSIGNED NOT NULL
        ) ENGINE =InnoDB;
CREATE TABLE serveComment (
        id INT(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        add_Date DATETIME NOT NULL,
        grade INT(4) UNSIGNED NOT NULL default 1,
        content TEXT,
        I_Like INT(6) NOT NULL,
        indentId INT(12) UNSIGNED NOT NULL,
        serveId INT(12) UNSIGNED NOT NULL,
        userId INT(12) UNSIGNED NOT NULL,
        anonymity INT(1) UNSIGNED default 0
        )ENGINE = MyISAM;
CREATE TABLE indent (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        title VARCHAR(128) NOT NULL,
        price DOUBLE(7,2) UNSIGNED NOT NULL default 0,
        serveType ENUM("shop","home","phone","on_line") NOT NULL,
        duration INT(6) NOT NULL,
        content TEXT,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        dateStr VARCHAR(128) NOT NULL,
        clientName VARCHAR(60) NOT NULL,
        clientPhone VARCHAR(60) NOT NULL,
        clientAddress VARCHAR(1024) NOT NULL,
        status ENUM("non_payment","payment","confirmServe","completeServe","completed","refund","completeRefund","complain","complainOver","close") NOT NULL default 'non_payment',
        serveId INT(12) UNSIGNED NOT NULL,
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB AUTO_INCREMENT = 1000000000;
CREATE TABLE indentCancelReason (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        add_Date DATETIME NOT NULL,
        reasonType VARCHAR(128) NOT NULL,
        content VARCHAR(1024) NOT NULL,
        indentId INT(12) UNSIGNED NOT NULL,
        userId INT(12) UNSIGNED NOT NULL
        )ENGINE = InnoDB;
CREATE TABLE complain (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        add_Date DATETIME NOT NULL,
        content VARCHAR(1024) NOT NULL,
        indentId INT(12) UNSIGNED NOT NULL,
        userId INT(12) UNSIGNED NOT NULL
        )ENGINE = InnoDB;
CREATE TABLE complainImage (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        image VARCHAR(512) NOT NULL,
        complainId INT(12) UNSIGNED NOT NULL
        )ENGINE = InnoDB;
CREATE TABLE shoppingCart (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        addDate DATETIME NOT NULL,
        indentId INT(12) UNSIGNED NOT NULL,
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB;
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
        type ENUM("Client","Company","Server") NOT NULL default "Client",
        money DOUBLE(12,2) NOT NULL default 0.00
        ) ENGINE = InnoDB AUTO_INCREMENT = 1000000000;
CREATE TABLE userFamily (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        addDate DATETIME NOT NULL,
        name VARCHAR(60) NOT NULL,
        sex ENUM("M","W") NOT NULL,
        phone VARCHAR(20) NOT NULL,
        relation VARCHAR(20) NOT NULL,
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB;
CREATE TABLE userPurchaseInfo (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        name VARCHAR(128) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        province VARCHAR(60) NOT NULL,
        city VARCHAR(60) NOT NULL,
        area VARCHAR(60) NOT NULL,
        addressDetails VARCHAR(512),
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE =InnoDB;
CREATE TABLE client (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        nickName VARCHAR(60) NOT NULL,
        image VARCHAR(255) NOT NULL,
        sex ENUM("M","W"),
        phone VARCHAR(64),
        email VARCHAR(128),
        name VARCHAR(128),
        birthday DATE,
        identityNumber VARCHAR(60),
        province VARCHAR(60),
        city VARCHAR(60),
        area VARCHAR(60),
        addressDetails VARCHAR(512),
        chooseAddress INT(12) UNSIGNED,
        level ENUM("common","expert","super") NOT NULL default "common",
        payStatus ENUM("unpaid","paid") NOT NULL default "unpaid",
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB AUTO_INCREMENT = 10000000;
CREATE TABLE server (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        nickName VARCHAR(60),
        name VARCHAR(128),
        sex ENUM("M","W"),
        type VARCHAR(128),
        phone VARCHAR(20),
        image VARCHAR(512),
        email VARCHAR(128),
        workingAge INT(5),
        sketch VARCHAR(512),
        identityNumber VARCHAR(60),
        province VARCHAR(60),
        city VARCHAR(60),
        area VARCHAR(60),
        addressDetails VARCHAR(512),
        chooseAddress INT(12) UNSIGNED,
        content VARCHAR(2048),
        level ENUM("common","expert","super") NOT NULL default "common",
        verification ENUM("not_audit","in_review","not_pass","pass") NOT NULL default "not_audit",
        verificationMsg VARCHAR(512),
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB AUTO_INCREMENT = 10000000;
CREATE TABLE serverImage (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        type ENUM("certificate","ID_card_positive","ID_card_on_the_back","photo") NOT NULL default "certificate",
        image VARCHAR(512) NOT NULL,
        serverId INT(12) UNSIGNED NOT NULL
        ) ENGINE =InnoDB;
CREATE TABLE journalAccount (
        id INT(12) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
        add_Date DATETIME NOT NULL,
        up_Date DATETIME NOT NULL,
        paymentMethod ENUM('alipay','wxpay','balance'),
        money DOUBLE(12,2) NOT NULL default 0.00,
        type ENUM("top_up","drawings","expense","income") NOT NULL,
        status ENUM("non_payment","success","freeze","cancel") NOT NULL DEFAULT "non_payment",
        content VARCHAR(512),
        indentId VARCHAR(512),
        userId INT(12) UNSIGNED NOT NULL
        ) ENGINE = InnoDB AUTO_INCREMENT = 100000000;
GRANT SELECT,UPDATE,DELETE,INSERT
ON huayujk.*
TO huayujk IDENTIFIED BY'hyjk2016';
