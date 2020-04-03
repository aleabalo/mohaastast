<?

// First statement in array MUST be a create database statement

$sql_create = array(

  "CREATE DATABASE IF NOT EXISTS {$GLOBALS['cfg']['db']['dbname']}"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile (
    playerID varchar(100) BINARY NOT NULL default ''
    ,playerName varchar(255) NOT NULL default ''
    ,skill int(10) unsigned default '0'
    ,kills INT DEFAULT 0
    ,deaths INT DEFAULT 0
    ,kill_streak INT DEFAULT 0
    ,death_streak INT DEFAULT 0
    ,games int(10) unsigned default '0'
    ,PRIMARY KEY  (playerID)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}playerdata (
    playerID varchar(100) BINARY NOT NULL default ''
    ,gameID bigint(20) unsigned NOT NULL default '0'
    ,dataName varchar(50) NOT NULL default ''
    ,dataNo INT unsigned NOT NULL default '0'
    ,dataValue varchar(255) NOT NULL default ''
    ,KEY pgID (playerID,gameID)
    ,KEY ddID (dataName,dataNo)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}eventdata1d (
    playerID varchar(100) BINARY NOT NULL default ''
    ,gameID bigint(20) unsigned NOT NULL default '0'
    ,round int(10) unsigned NOT NULL default '0'
    ,team varchar(30) NOT NULL default ''
    ,role varchar(30) NOT NULL default ''
    ,eventName varchar(50) NOT NULL default ''
    ,eventValue varchar(50) NOT NULL default ''
    ,eventCategory varchar(50) NOT NULL default ''
    ,KEY (playerID)
    ,KEY (gameID)
    ,KEY (eventName)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d (
    playerID varchar(100) BINARY NOT NULL default ''
    ,gameID bigint(20) unsigned NOT NULL default '0'
    ,round int(10) unsigned NOT NULL default '0'
    ,team varchar(30) NOT NULL default ''
    ,role varchar(30) NOT NULL default ''
    ,eventName varchar(50) NOT NULL default ''
    ,eventValue varchar(50) NOT NULL default ''
    ,eventCategory varchar(50) NOT NULL default ''
    ,player2ID varchar(100) BINARY NOT NULL default ''
    ,team2 varchar(30) NOT NULL default ''
    ,role2 varchar(30) NOT NULL default ''
    ,KEY (playerID)
    ,KEY (gameID)
    ,KEY (eventName)
    ,KEY (player2ID)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}gameprofile (
    gameID bigint(20) unsigned NOT NULL default '0'
    ,timeStart datetime NOT NULL default '0000-00-00 00:00:00'
    ,game varchar(100) NOT NULL default ''
    ,map varchar(50) NOT NULL default ''
    ,mod varchar(50) NOT NULL default ''
    ,gameType varchar(50) NOT NULL default ''
    ,players INT DEFAULT 0
    ,PRIMARY KEY (gameID)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}gamedata (
    gameID bigint(20) unsigned NOT NULL default '0'
    ,name varchar(50) NOT NULL default ''
    ,value varchar(255) default ''
    ,PRIMARY KEY (gameID,name)
  ) TYPE=MyISAM"

  ,"
  CREATE TABLE {$GLOBALS['cfg']['db']['table_prefix']}awards (
    awardID varchar(100) NOT NULL
    ,name varchar(100) NOT NULL 
    ,category varchar(50)
    ,image varchar (255) default ''
    ,playerID varchar(100) BINARY default ''
    ,sql TEXT NOT NULL
    ,PRIMARY KEY (awardID)
  ) TYPE=MyISAM"


);



$sql_destroy = array(
  "DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}playerdata"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}eventdata1d"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}gameprofile"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}gamedata"
  ,"DROP TABLE {$GLOBALS['cfg']['db']['table_prefix']}awards"
);

?>