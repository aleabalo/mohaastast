#
# Table Definitions for vsp stats processor (prefixed with vsp_)
#


# Table: 'vsp_awards'
# 
CREATE TABLE `vsp_awards` (
  `awardID` varchar(100) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `category` varchar(50) default NULL,
  `image` varchar(255) default '',
  `playerID` varchar(100) BINARY default '',
  `sql` text NOT NULL,
  PRIMARY KEY  (`awardID`)
) TYPE=MyISAM; 

# Table: 'vsp_eventdata1d'
# 
CREATE TABLE `vsp_eventdata1d` (
  `playerID` varchar(100) BINARY NOT NULL default '',
  `gameID` bigint(20) unsigned NOT NULL default '0',
  `round` int(10) unsigned NOT NULL default '0',
  `team` varchar(30) NOT NULL default '',
  `role` varchar(30) NOT NULL default '',
  `eventName` varchar(50) NOT NULL default '',
  `eventValue` varchar(50) NOT NULL default '',
  `eventCategory` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`playerID`,`gameID`,`round`,`team`,`role`,`eventName`,`eventCategory`)
) TYPE=MyISAM; 

# Table: 'vsp_eventdata2d'
# 
CREATE TABLE `vsp_eventdata2d` (
  `playerID` varchar(100) BINARY NOT NULL default '',
  `gameID` bigint(20) unsigned NOT NULL default '0',
  `round` int(10) unsigned NOT NULL default '0',
  `team` varchar(30) NOT NULL default '',
  `role` varchar(30) NOT NULL default '',
  `eventName` varchar(50) NOT NULL default '',
  `eventValue` varchar(50) NOT NULL default '',
  `eventCategory` varchar(50) NOT NULL default '',
  `player2ID` varchar(100) BINARY NOT NULL default '',
  `team2` varchar(30) NOT NULL default '',
  `role2` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`playerID`,`gameID`,`round`,`team`,`role`,`eventName`,`eventCategory`,`player2ID`,`team2`,`role2`)
) TYPE=MyISAM; 

# Table: 'vsp_gamedata'
# 
CREATE TABLE `vsp_gamedata` (
  `gameID` bigint(20) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `value` varchar(255) default '',
  PRIMARY KEY  (`gameID`,`name`)
) TYPE=MyISAM; 

# Table: 'vsp_playerdata'
# 
CREATE TABLE `vsp_playerdata` (
  `playerID` varchar(100) BINARY NOT NULL default '',
  `gameID` bigint(20) unsigned NOT NULL default '0',
  `dataName` varchar(50) NOT NULL default '',
  `dataNo` int(10) unsigned NOT NULL default '0',
  `dataValue` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`playerID`,`gameID`,`dataName`,`dataNo`)
) TYPE=MyISAM; 

# Table: 'vsp_playerprofile'
# 
CREATE TABLE `vsp_playerprofile` (
  `playerID` varchar(100) BINARY NOT NULL default '',
  `playerName` varchar(255) NOT NULL default '',
  `skill` int(10) unsigned default '0',
  `kills` int(11) default '0',
  `deaths` int(11) default '0',
  `kill_streak` int(11) default '0',
  `death_streak` int(11) default '0',
  `games` int(10) unsigned default '0',
  PRIMARY KEY  (`playerID`)
) TYPE=MyISAM; 


#
#
#