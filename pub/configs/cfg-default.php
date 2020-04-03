<?php
//==============================================================================
// Anything following double slashes // are comments.
// You can use // to disable certain settings. 
// Remove the // infront of a variable if you want to enable it.
//==============================================================================
global $cfg;

//================================================
// Error Reporting
    
    error_reporting(E_ALL ^ E_NOTICE);             // For Debugging. Recommended when you set up vsp for the first time.
    //error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); // Recommended for regular use after ensuring proper run of vsp.
    //error_reporting(E_ALL);                        // For Debugging. Enable this if you are having a hard time to get vsp going.

//================================================
// Database settings
    
    //$cfg['db']['adodb_path']= "C:/php/lib/adodb/"; // Uncomment/Enable this only if you have and want to use your own adodb libraries.
                                                     // Must specify it as an absolute path! ie:- "../../adodb" etc. are *NOT ALLOWED*
    
    $cfg['db']['adodb_driver']= 'mysql'; 
    
    $cfg['db']['table_prefix'] = "vsp_";           // use only lower case to minimize windows/linux portability problems
    
    $cfg['db']['hostname'] = "localhost";
    $cfg['db']['dbname']   = "database_name";      // use only lower case to minimize windows/linux portability problems
    $cfg['db']['username'] = "database_user";
    $cfg['db']['password'] = "database_pass";

//================================================
// Game settings 

    $cfg['game']['name']='enter_correct_value_here'; /*** make sure this is set correctly! Read below! ***/
                                                     /*----------------------------------------
                                                     In order to find out what values are
                                                     acceptable for this variable, look in the
                                                     /pub/games/ folder in vsp. Any sub 
                                                     directory in this folder is valid.
                                                     ex:- 
                                                          'cod'     for Call of Duty and all its expansions/mods
                                                          'hl'      for Half Life and all its mods
                                                          'moh'     for Medal of Honor and all its expansions/mods
                                                          'q3a'     for Quake 3 Arena and all its expansions/mods
                                                          'rtcw'    for Return to Castle Wolfenstein and all its mods
                                                          'sof2'    for Soldier of Fortune 2
                                                          'wet'     for Wolfenstein Enemy Territory and all its mods
                                                          'default' for games that are not listed in pub/games/
                                                         etc.
                                                     ----------------------------------------*/

// Themes *may* use the following variables to do special processing for a particular game,mod,type
    $cfg['game']['mod']='default';  // not used currently
    $cfg['game']['type']='default'; // not used currently
// The theme author decides how to use these variables.
// Check the documentation for the theme that you are using

//================================================
// Remote downloading of logs

    $cfg['ftp']['logs_path']= "./ftplogs/";        // Files downloaded from ftp server will go into this directory on local server.
    $cfg['ftp']['username'] = "ftp_user";
    $cfg['ftp']['password'] = "ftp_pass";
    $cfg['ftp']['pasv'] = 0;                       // Enable(1)/Disable(0) Passive mode. Some FTP servers may require this to be ON
    $cfg['ftp']['overwrite'] = 0;                  // Enable(1)/Disable(0) overwriting of file(s). A value of 0 resumes the log.

//================================================
// Parser Options
    
    $cfg['parser']['use_original_playerID'] = 1;                   // Check http://www.clanavl.com/ipb/index.php?showtopic=32
    $cfg['parser']['use_most_used_playerName'] = 1;                // use the most used playerName (set to 1) OR newest playerName (set to 0) as primary playerName
    
    
    
    // You can track players by guid and ip if the game/mod supports it. 
    // Tracking by guid is always the best option if its available. If it doesn't work track by playername
    
    //----- ***USE ONLY ONE OF THESE AT A TIME*** -----
    
    $cfg['parser']['trackID'] = 'playerName';                      // Default method for tracking, works with all games/mods. If unsure, use this.
    
    //$cfg['parser']['trackID'] = 'ip=/(\d+\\.\d+\\.\d+\\.\d+)/';  // Track by ip AAA.BBB.CCC.DDD (NOT RECOMMENDED - the full ip of the player will be viewable by anyone)
    //$cfg['parser']['trackID'] = 'ip=/(\d+\\.\d+\\.\d+\\.)/U';    // Track by ip AAA.BBB.CCC.*   (recommended tracking format for ips)
    //$cfg['parser']['trackID'] = 'ip=/(\d+\\.\d+\\.\d)/U';        // Track by ip AAA.BBB.C*.*
    //$cfg['parser']['trackID'] = 'ip=/(\d+\\.)/U';                // Track by ip AAA.*.*.*
    
    //$cfg['parser']['trackID'] = 'guid';                          // Recommended method of tracking, if available for that game/mod
    
    //----- ***USE ONLY ONE OF THESE AT A TIME*** -----

//================================================
// Other settings

    $cfg['awardset']='default';
    $cfg['skillset']='default';
    $cfg['roleset']='default';
    $cfg['iconset']='default';
    $cfg['mapset']='default';
    $cfg['weaponset']='default';

    $cfg['player_ban_list']='default';
    $cfg['player_exclude_list']='default';

//================================================
// Display settings

    $cfg['display']['record_limit']=50;

//================================================
// Server info

    $cfg['display']['server_title']=<<<END_OF_SERVER_TITLE
    <a href="http://www.clanavl.com/vsp/"><B>VSP STATS</B></a>
END_OF_SERVER_TITLE;

    $cfg['display']['server_image']="../../images/server.gif";
    
    $cfg['display']['server_info']=<<<END_OF_SERVER_INFO
    <table style="border-width: 0;">
    <TR>
      <TD style="border-width: 0; text-align: right">Server IP:</TD>
      <TD style="border-width: 0; text-align: left" >Set these options in your config file (cfg-default.php)</TD>
    </TR>
    <TR>
      <TD style="border-width: 0; text-align: right">Game:</TD>
      <TD style="border-width: 0; text-align: left" >Unknown</TD>
    </TR>
    <TR>
      <TD style="border-width: 0; text-align: right">Admin:</TD>
      <TD style="border-width: 0; text-align: left" >Unknown</TD>
    </TR>
    <TR>
      <TD style="border-width: 0; text-align: right">Contact:</TD>
      <TD style="border-width: 0; text-align: left" >email [at] host [dot] com</TD>
    </TR>
    <TR>
      <TD style="border-width: 0; text-align: right">IRC:</TD>
      <TD style="border-width: 0; text-align: left" >You can also customize more options in settings.php</TD>
    </TR>
    <TR>
      <TD style="border-width: 0; text-align: right">Quote:</TD>
      <TD style="border-width: 0; text-align: left" >" Hello World! "</TD>
    </TR>
    </table>
END_OF_SERVER_INFO;

//================================================
// Data Filters
// format :- $cfg['data_filter']['events']['eventCategory'] = REGEXP

// $cfg['data_filter']['events']['eventCategory'] = "/^R/";     means exclude the events in the category eventCategory where eventName begins with R
// $cfg['data_filter']['events'][''] = "/.*/";                  means exclude all events in category eventCategory where eventName matches anything

  $cfg['data_filter']['events']['weapon']="/.*/";
  $cfg['data_filter']['events']['ammo']="/.*/";
  $cfg['data_filter']['events']['']="/^(team_CTF_blueflag|team_CTF_redflag)/";
  
  //$cfg['data_filter']['gamedata']['']="/^(sv_|g_|p_)/";
  $cfg['data_filter']['gamedata']['']="/.*/";

//================================================

//==============================================================================
?>