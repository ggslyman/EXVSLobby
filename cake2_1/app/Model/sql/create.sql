CREATE DATABASE exvslobby default character set utf8;
USE exvslobby;
-- phpMyAdmin SQL Dump
-- version 3.3.10.3
-- http://www.phpmyadmin.net
--
-- ホスト: mysql122.db.sakura.ne.jp
-- 生成時間: 2012 年 3 月 24 日 13:27
-- サーバのバージョン: 5.1.51
-- PHP のバージョン: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
--

-- --------------------------------------------------------

--
--

CREATE TABLE IF NOT EXISTS `characters` (
  `character_id` int(11) NOT NULL AUTO_INCREMENT,
  `character_name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`character_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `ssf4ae_entries`
--

CREATE TABLE IF NOT EXISTS `entries` (
  `entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `platform` int(11) NOT NULL,
  `nickname` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `messenger_type` int(11) NOT NULL,
  `messenger_id` text COLLATE utf8_unicode_ci NOT NULL,
  `single_point` int(11) DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `start_datetime` timestamp NULL DEFAULT NULL,
  `end_datetime` timestamp NULL DEFAULT NULL,
  `password` text COLLATE utf8_unicode_ci,
  `now_fight_flag` int(11) NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=145 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `entry_characters`
--

CREATE TABLE IF NOT EXISTS `entry_characters` (
  `entry_characters_id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  `character_point` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`entry_characters_id`,`character_id`),
  KEY `fk_entry_characters_entries` (`entry_id`),
  KEY `fk_entry_characters_character_master1` (`character_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;



INSERT INTO characters (character_name) values ('νガンダム');
INSERT INTO characters (character_name) values ('Hi-νガンダム');
INSERT INTO characters (character_name) values ('V2ガンダム');
INSERT INTO characters (character_name) values ('マスターガンダム');
INSERT INTO characters (character_name) values ('ウイングガンダムゼロ(EW版)');
INSERT INTO characters (character_name) values ('ガンダムDX');
INSERT INTO characters (character_name) values ('∀ガンダム');
INSERT INTO characters (character_name) values ('ターンX');
INSERT INTO characters (character_name) values ('デスティニーガンダム');
INSERT INTO characters (character_name) values ('ストライクフリーダムガンダム');
INSERT INTO characters (character_name) values ('ダブルオーガンダム');
INSERT INTO characters (character_name) values ('ダブルオークアンタ');
INSERT INTO characters (character_name) values ('ユニコーンガンダム');
INSERT INTO characters (character_name) values ('クロスボーン・ガンダムX1フルクロス');
INSERT INTO characters (character_name) values ('Zガンダム');
INSERT INTO characters (character_name) values ('フルアーマーZZガンダム');
INSERT INTO characters (character_name) values ('キュベレイ');
INSERT INTO characters (character_name) values ('サザビー');
INSERT INTO characters (character_name) values ('ゴッドガンダム');
INSERT INTO characters (character_name) values ('トールギスIII');
INSERT INTO characters (character_name) values ('ガンダムデスサイズヘル(EW版)');
INSERT INTO characters (character_name) values ('∞ジャスティスガンダム');
INSERT INTO characters (character_name) values ('ケルディムガンダム');
INSERT INTO characters (character_name) values ('ラファエルガンダム');
INSERT INTO characters (character_name) values ('クシャトリヤ');
INSERT INTO characters (character_name) values ('シナンジュ');
INSERT INTO characters (character_name) values ('クロスボーンガンダムX1改');
INSERT INTO characters (character_name) values ('クロスボーンガンダムX2改');
INSERT INTO characters (character_name) values ('ガンダム');
INSERT INTO characters (character_name) values ('シャア専用ゲルググ');
INSERT INTO characters (character_name) values ('百式');
INSERT INTO characters (character_name) values ('メッサーラ');
INSERT INTO characters (character_name) values ('ガンダムF91');
INSERT INTO characters (character_name) values ('ドラゴンガンダム');
INSERT INTO characters (character_name) values ('ガンダムヘビーアームズ改(EW版)');
INSERT INTO characters (character_name) values ('ガンダムヴァサーゴ・チェストブレイク');
INSERT INTO characters (character_name) values ('ゴールドスモー');
INSERT INTO characters (character_name) values ('ストライクガンダム');
INSERT INTO characters (character_name) values ('フォビドゥンガンダム');
INSERT INTO characters (character_name) values ('プロヴィデンスガンダム');
INSERT INTO characters (character_name) values ('ガナーザクウォーリア');
INSERT INTO characters (character_name) values ('ガンダムエクシア');
INSERT INTO characters (character_name) values ('スサノオ');
INSERT INTO characters (character_name) values ('ガンダムデュナメス');
INSERT INTO characters (character_name) values ('デルタプラス');
INSERT INTO characters (character_name) values ('ガンダム試作1号機Fb');
INSERT INTO characters (character_name) values ('ガンダム試作2号機');
INSERT INTO characters (character_name) values ('ガンダムアストレイレッドフレーム');
INSERT INTO characters (character_name) values ('ガンダムアストレイブルーフレームSL');
INSERT INTO characters (character_name) values ('アッガイ');
INSERT INTO characters (character_name) values ('キュベレイMk-II(プルツー機)');
INSERT INTO characters (character_name) values ('ベルガ・ギロス');
INSERT INTO characters (character_name) values ('ガンイージ');
INSERT INTO characters (character_name) values ('ラゴゥ');
INSERT INTO characters (character_name) values ('アレックス');
INSERT INTO characters (character_name) values ('ザク改');
INSERT INTO characters (character_name) values ('ガンダムEz8');
INSERT INTO characters (character_name) values ('グフ・カスタム');
INSERT INTO characters (character_name) values ('ヅダ');
INSERT INTO characters (character_name) values ('ヒルドルブ');
INSERT INTO characters (character_name) values ('アルケーガンダム');
INSERT INTO characters (character_name) values ('ブルーディスティニー1号機');
INSERT INTO characters (character_name) values ('ゴトラタン');
INSERT INTO characters (character_name) values ('ジ・O');
INSERT INTO characters (character_name) values ('フリーダムガンダム');
INSERT INTO characters (character_name) values ('ジオング');
