PRAGMA
synchronous
=
OFF;
PRAGMA
journal_mode
=
MEMORY;
BEGIN
TRANSACTION;
CREATE TABLE `db_version`
(
  `version`     integer     NOT NULL,
  `structure`   integer     NOT NULL,
  `content`     integer     NOT NULL,
  `description` varchar(30) NOT NULL DEFAULT '',
  `comment`     varchar(150)         DEFAULT '',
  PRIMARY KEY (`version`, `structure`, `content`)
);
INSERT INTO `db_version`(`version`, `structure`, `content`, `description`, `comment`)
VALUES (21, 1, 3, 'Remove field from dbDocs', 'Base Database from 20150409 to Rel21_1_3');
CREATE TABLE `account`
(
  `id`              integer     NOT NULL PRIMARY KEY AUTOINCREMENT,
  `username`        varchar(32) NOT NULL DEFAULT '',
  `sha_pass_hash`   varchar(40) NOT NULL DEFAULT '',
  `gmlevel`         integer     NOT NULL DEFAULT '0',
  `sessionkey`      longtext,
  `v`               longtext,
  `s`               longtext,
  `email`           text,
  `joindate`        timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_ip`         varchar(30) NOT NULL DEFAULT '0.0.0.0',
  `failed_logins`   integer     NOT NULL DEFAULT '0',
  `locked`          integer     NOT NULL DEFAULT '0',
  `last_login`      timestamp   NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active_realm_id` integer     NOT NULL DEFAULT '0',
  `expansion`       integer     NOT NULL DEFAULT '0',
  `mutetime`        integer     NOT NULL DEFAULT '0',
  `locale`          integer     NOT NULL DEFAULT '0',
  `os`              varchar(3)           DEFAULT '',
  `playerBot`       integer     NOT NULL DEFAULT 0,
  UNIQUE (`username`)
);
insert into `account`(`id`, `username`, `sha_pass_hash`, `gmlevel`, `sessionkey`, `v`, `s`, `email`, `joindate`,
                      `last_ip`, `failed_logins`, `locked`, `last_login`, `active_realm_id`, `expansion`, `mutetime`,
                      `locale`, `os`, `playerBot`)
values (1, 'ADMINISTRATOR', 'a34b29541b87b7e4823683ce6c7bf6ae68beaaac', 3, '', '0', '0', '', '2006-04-25 13:18:56',
        '127.0.0.1', 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '', '\0');
insert into `account`(`id`, `username`, `sha_pass_hash`, `gmlevel`, `sessionkey`, `v`, `s`, `email`, `joindate`,
                      `last_ip`, `failed_logins`, `locked`, `last_login`, `active_realm_id`, `expansion`, `mutetime`,
                      `locale`, `os`, `playerBot`)
values (2, 'GAMEMASTER', '7841e21831d7c6bc0b57fbe7151eb82bd65ea1f9', 2, '', '0', '0', '', '2006-04-25 13:18:56',
        '127.0.0.1', 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '', '\0');
insert into `account`(`id`, `username`, `sha_pass_hash`, `gmlevel`, `sessionkey`, `v`, `s`, `email`, `joindate`,
                      `last_ip`, `failed_logins`, `locked`, `last_login`, `active_realm_id`, `expansion`, `mutetime`,
                      `locale`, `os`, `playerBot`)
values (3, 'MODERATOR', 'a7f5fbff0b4eec2d6b6e78e38e8312e64d700008', 1, '', '0', '0', '', '2006-04-25 13:19:35',
        '127.0.0.1', 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '', '\0');
insert into `account`(`id`, `username`, `sha_pass_hash`, `gmlevel`, `sessionkey`, `v`, `s`, `email`, `joindate`,
                      `last_ip`, `failed_logins`, `locked`, `last_login`, `active_realm_id`, `expansion`, `mutetime`,
                      `locale`, `os`, `playerBot`)
values (4, 'PLAYER', '3ce8a96d17c5ae88a30681024e86279f1a38c041', 0, '', '0', '0', '', '2006-04-25 13:19:35',
        '127.0.0.1', 0, 0, '0000-00-00 00:00:00', 0, 0, 0, 0, '', '\0');
CREATE TABLE `account_banned`
(
  `id`        integer      NOT NULL,
  `bandate`   integer      NOT NULL DEFAULT '0',
  `unbandate` integer      NOT NULL DEFAULT '0',
  `bannedby`  varchar(50)  NOT NULL,
  `banreason` varchar(255) NOT NULL,
  `active`    integer      NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`, `bandate`),
  CONSTRAINT `account_banned_ibfk_1` FOREIGN KEY (`id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE `ip_banned`
(
  `ip`        varchar(32)  NOT NULL DEFAULT '0.0.0.0',
  `bandate`   integer      NOT NULL,
  `unbandate` integer      NOT NULL,
  `bannedby`  varchar(50)  NOT NULL DEFAULT '[Console]',
  `banreason` varchar(255) NOT NULL DEFAULT 'no reason',
  PRIMARY KEY (`ip`, `bandate`)
);
CREATE TABLE `realmcharacters`
(
  `realmid`  integer NOT NULL,
  `acctid`   integer NOT NULL,
  `numchars` integer NOT NULL DEFAULT '0',
  PRIMARY KEY (`realmid`, `acctid`),
  CONSTRAINT `realmcharacters_ibfk_1` FOREIGN KEY (`realmid`) REFERENCES `realmlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE `realmlist`
(
  `id`                   integer      NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name`                 varchar(32)  NOT NULL DEFAULT '',
  `address`              varchar(32)  NOT NULL DEFAULT '127.0.0.1',
  `localAddress`         varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `localSubnetMask`      varchar(255) NOT NULL DEFAULT '255.255.255.0',
  `port`                 integer      NOT NULL DEFAULT '8085',
  `icon`                 integer      NOT NULL DEFAULT '0',
  `realmflags`           integer      NOT NULL DEFAULT '2',
  `timezone`             integer      NOT NULL DEFAULT '0',
  `allowedSecurityLevel` integer      NOT NULL DEFAULT '0',
  `population`           float        NOT NULL DEFAULT '0',
  `realmbuilds`          varchar(64)  NOT NULL DEFAULT '',
  UNIQUE (`name`)
);
INSERT INTO `realmlist`(`name`)
values ('Testing');
CREATE TABLE `uptime`
(
  `realmid`     integer     NOT NULL,
  `starttime`   integer     NOT NULL DEFAULT '0',
  `startstring` varchar(64) NOT NULL DEFAULT '',
  `uptime`      integer     NOT NULL DEFAULT '0',
  `maxplayers`  integer     NOT NULL DEFAULT '0',
  PRIMARY KEY (`realmid`, `starttime`)
);
CREATE TABLE `warden_log`
(
  `entry`      integer   NOT NULL PRIMARY KEY AUTOINCREMENT,
  `check`      integer   NOT NULL,
  `action`     integer   NOT NULL DEFAULT '0',
  `account`    integer   NOT NULL,
  `guid`       integer   NOT NULL DEFAULT '0',
  `map`        integer            DEFAULT NULL,
  `position_x` float              DEFAULT NULL,
  `position_y` float              DEFAULT NULL,
  `position_z` float              DEFAULT NULL,
  `date`       timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE
INDEX
"idx_account_idx_gmlevel"
ON
"account"
(
`gmlevel`
);
CREATE
INDEX
"idx_realmcharacters_acctid"
ON
"realmcharacters"
(
`acctid`
);
END
TRANSACTION;
