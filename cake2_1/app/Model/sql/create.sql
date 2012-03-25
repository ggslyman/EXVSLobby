CREATE DATABASE exvslobby default character set utf8;
USE exvslobby;
-- phpMyAdmin SQL Dump
-- version 3.3.10.3
-- http://www.phpmyadmin.net
--
-- �z�X�g: mysql122.db.sakura.ne.jp
-- ��������: 2012 �N 3 �� 24 �� 13:27
-- �T�[�o�̃o�[�W����: 5.1.51
-- PHP �̃o�[�W����: 5.3.8

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
-- �e�[�u���̍\�� `ssf4ae_entries`
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
-- �e�[�u���̍\�� `entry_characters`
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



INSERT INTO characters (character_name) values ('�˃K���_��');
INSERT INTO characters (character_name) values ('Hi-�˃K���_��');
INSERT INTO characters (character_name) values ('V2�K���_��');
INSERT INTO characters (character_name) values ('�}�X�^�[�K���_��');
INSERT INTO characters (character_name) values ('�E�C���O�K���_���[��(EW��)');
INSERT INTO characters (character_name) values ('�K���_��DX');
INSERT INTO characters (character_name) values ('�̓K���_��');
INSERT INTO characters (character_name) values ('�^�[��X');
INSERT INTO characters (character_name) values ('�f�X�e�B�j�[�K���_��');
INSERT INTO characters (character_name) values ('�X�g���C�N�t���[�_���K���_��');
INSERT INTO characters (character_name) values ('�_�u���I�[�K���_��');
INSERT INTO characters (character_name) values ('�_�u���I�[�N�A���^');
INSERT INTO characters (character_name) values ('���j�R�[���K���_��');
INSERT INTO characters (character_name) values ('�N���X�{�[���E�K���_��X1�t���N���X');
INSERT INTO characters (character_name) values ('Z�K���_��');
INSERT INTO characters (character_name) values ('�t���A�[�}�[ZZ�K���_��');
INSERT INTO characters (character_name) values ('�L���x���C');
INSERT INTO characters (character_name) values ('�T�U�r�[');
INSERT INTO characters (character_name) values ('�S�b�h�K���_��');
INSERT INTO characters (character_name) values ('�g�[���M�XIII');
INSERT INTO characters (character_name) values ('�K���_���f�X�T�C�Y�w��(EW��)');
INSERT INTO characters (character_name) values ('���W���X�e�B�X�K���_��');
INSERT INTO characters (character_name) values ('�P���f�B���K���_��');
INSERT INTO characters (character_name) values ('���t�@�G���K���_��');
INSERT INTO characters (character_name) values ('�N�V���g����');
INSERT INTO characters (character_name) values ('�V�i���W��');
INSERT INTO characters (character_name) values ('�N���X�{�[���K���_��X1��');
INSERT INTO characters (character_name) values ('�N���X�{�[���K���_��X2��');
INSERT INTO characters (character_name) values ('�K���_��');
INSERT INTO characters (character_name) values ('�V���A��p�Q���O�O');
INSERT INTO characters (character_name) values ('�S��');
INSERT INTO characters (character_name) values ('���b�T�[��');
INSERT INTO characters (character_name) values ('�K���_��F91');
INSERT INTO characters (character_name) values ('�h���S���K���_��');
INSERT INTO characters (character_name) values ('�K���_���w�r�[�A�[���Y��(EW��)');
INSERT INTO characters (character_name) values ('�K���_�����@�T�[�S�E�`�F�X�g�u���C�N');
INSERT INTO characters (character_name) values ('�S�[���h�X���[');
INSERT INTO characters (character_name) values ('�X�g���C�N�K���_��');
INSERT INTO characters (character_name) values ('�t�H�r�h�D���K���_��');
INSERT INTO characters (character_name) values ('�v�����B�f���X�K���_��');
INSERT INTO characters (character_name) values ('�K�i�[�U�N�E�H�[���A');
INSERT INTO characters (character_name) values ('�K���_���G�N�V�A');
INSERT INTO characters (character_name) values ('�X�T�m�I');
INSERT INTO characters (character_name) values ('�K���_���f���i���X');
INSERT INTO characters (character_name) values ('�f���^�v���X');
INSERT INTO characters (character_name) values ('�K���_������1���@Fb');
INSERT INTO characters (character_name) values ('�K���_������2���@');
INSERT INTO characters (character_name) values ('�K���_���A�X�g���C���b�h�t���[��');
INSERT INTO characters (character_name) values ('�K���_���A�X�g���C�u���[�t���[��SL');
INSERT INTO characters (character_name) values ('�A�b�K�C');
INSERT INTO characters (character_name) values ('�L���x���CMk-II(�v���c�[�@)');
INSERT INTO characters (character_name) values ('�x���K�E�M���X');
INSERT INTO characters (character_name) values ('�K���C�[�W');
INSERT INTO characters (character_name) values ('���S�D');
INSERT INTO characters (character_name) values ('�A���b�N�X');
INSERT INTO characters (character_name) values ('�U�N��');
INSERT INTO characters (character_name) values ('�K���_��Ez8');
INSERT INTO characters (character_name) values ('�O�t�E�J�X�^��');
INSERT INTO characters (character_name) values ('�d�_');
INSERT INTO characters (character_name) values ('�q���h���u');
INSERT INTO characters (character_name) values ('�A���P�[�K���_��');
INSERT INTO characters (character_name) values ('�u���[�f�B�X�e�B�j�[1���@');
INSERT INTO characters (character_name) values ('�S�g���^��');
INSERT INTO characters (character_name) values ('�W�EO');
INSERT INTO characters (character_name) values ('�t���[�_���K���_��');
INSERT INTO characters (character_name) values ('�W�I���O');
