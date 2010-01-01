-- MySQL dump 8.21
--
-- Host: localhost    Database: kaartine
---------------------------------------------------------
-- Server version	3.23.49-log

--
-- Table structure for table 'kurssit'
--

CREATE TABLE kurssit (
  id int(11) NOT NULL auto_increment,
  kurssinnum int(11) default NULL,
  kurssinkuv varchar(50) default NULL,
  pvm int(11) default NULL,
  ov int(11) default NULL,
  av int(11) default NULL,
  user int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



--
-- Table structure for table 'meneilla'
--

CREATE TABLE meneilla (
  id int(11) NOT NULL auto_increment,
  kurssinnum int(11) default NULL,
  kurssinkuv varchar(50) default NULL,
  lyhenne varchar(8) default NULL,
  pvm int(11) default NULL,
  ov int(11) default NULL,
  user int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;


--
-- Table structure for table 'periodi1'
--

CREATE TABLE periodi1 (
  id int(11) default NULL,
  maa tinytext,
  tii tinytext,
  kes tinytext,
  tor tinytext,
  per tinytext,
  user int(11) default NULL,
  luokka1 varchar(11) default NULL,
  luokka2 varchar(11) default NULL,
  luokka3 varchar(11) default NULL,
  luokka4 varchar(11) default NULL,
  luokka5 varchar(11) default NULL
) TYPE=MyISAM;



--
-- Table structure for table 'periodi2'
--

CREATE TABLE periodi2 (
  id int(11) default NULL,
  maa tinytext,
  tii tinytext,
  kes tinytext,
  tor tinytext,
  per tinytext,
  user int(11) default NULL,
  luokka1 varchar(11) default NULL,
  luokka2 varchar(11) default NULL,
  luokka3 varchar(11) default NULL,
  luokka4 varchar(11) default NULL,
  luokka5 varchar(11) default NULL
) TYPE=MyISAM;


--
-- Table structure for table 'periodi3'
--

CREATE TABLE periodi3 (
  id int(11) default NULL,
  maa tinytext,
  tii tinytext,
  kes tinytext,
  tor tinytext,
  per tinytext,
  user int(11) default NULL,
  luokka1 varchar(11) default NULL,
  luokka2 varchar(11) default NULL,
  luokka3 varchar(11) default NULL,
  luokka4 varchar(11) default NULL,
  luokka5 varchar(11) default NULL
) TYPE=MyISAM;


--
-- Table structure for table 'periodi4'
--

CREATE TABLE periodi4 (
  id int(11) default NULL,
  maa tinytext,
  tii tinytext,
  kes tinytext,
  tor tinytext,
  per tinytext,
  user int(11) default NULL,
  luokka1 varchar(11) default NULL,
  luokka2 varchar(11) default NULL,
  luokka3 varchar(11) default NULL,
  luokka4 varchar(11) default NULL,
  luokka5 varchar(11) default NULL
) TYPE=MyISAM;


--
-- Table structure for table 'users'
--

CREATE TABLE users (
  id int(11) NOT NULL auto_increment,
  name varchar(8) default NULL,
  password varchar(32) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;
