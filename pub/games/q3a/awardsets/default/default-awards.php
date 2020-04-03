<?
global $awardset;

$awardset['avg_games']['sql'][0]    = "select STD(games) 
                                       from {$tp}playerprofile
                                    ";

                         $avg_games = "({\$awardset['avg_games']['sql'][0][0]}-1)";
//------------------------------------------------
$awardset['CTF_Assist']['name']                      = 'Best Supporter';
$awardset['CTF_Assist']['image']                     = 'CTF_Supporter';
$awardset['CTF_Assist']['category']                  = 'CTF';
$awardset['CTF_Assist']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where (eventName='Defend_Carrier' OR eventName='Defend_Hurt_Carrier' OR eventName='Flag_Assist_Return' OR eventName='Flag_Assist_Frag')
                                                             and eventCategory='CTF'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";

//------------------------------------------------
$awardset['CTF_Retriever']['name']                      = 'Best Flag Retriever';
$awardset['CTF_Retriever']['image']                     = 'CTF_Retriever';
$awardset['CTF_Retriever']['category']                  = 'CTF';
$awardset['CTF_Retriever']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where (eventName='Kill_Carrier' OR eventName='Flag_Return')
                                                             and eventCategory='CTF'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";


//------------------------------------------------
$awardset['CTF_Defend']['name']                      = 'Best Defender';
$awardset['CTF_Defend']['image']                     = 'CTF_Defend';
$awardset['CTF_Defend']['category']                  = 'CTF';
$awardset['CTF_Defend']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where (eventName='Defend_Base' OR eventName='Defend_Flag')
                                                             and eventCategory='CTF'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";


//------------------------------------------------
$awardset['CTF_Flag_Capture']['name']                      = 'Best Flag Capper';
$awardset['CTF_Flag_Capture']['image']                     = 'CTF_Flag_Capture';
$awardset['CTF_Flag_Capture']['category']                  = 'CTF';
$awardset['CTF_Flag_Capture']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where eventName='Flag_Capture' 
                                                             and eventCategory='CTF'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";

//------------------------------------------------
$awardset['item_quad']['name']                      = 'Quad Whore';
$awardset['item_quad']['image']                     = 'item_quad';
$awardset['item_quad']['category']                  = 'Item';
$awardset['item_quad']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where eventName='quad' 
                                                             and eventCategory='item'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";
//------------------------------------------------
$awardset['item_regen']['name']                      = 'Regen Romper';
$awardset['item_regen']['image']                     = 'item_regen';
$awardset['item_regen']['category']                  = 'Item';
$awardset['item_regen']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where eventName='regen' 
                                                             and eventCategory='item'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";
//------------------------------------------------
$awardset['item_haste']['name']                      = 'Haste Hog';
$awardset['item_haste']['image']                     = 'item_haste';
$awardset['item_haste']['category']                  = 'Item';
$awardset['item_haste']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where eventName='haste' 
                                                             and eventCategory='item'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";
//------------------------------------------------
$awardset['item_mega']['name']                      = 'Mega Man';
$awardset['item_mega']['image']                     = 'item_mega';
$awardset['item_mega']['category']                  = 'Item';
$awardset['item_mega']['sql'][0]                    = "select {$tp}playerprofile.playerID, {$tp}playerprofile.playerName, round(sum(eventValue)/games,2) as value from {$tp}playerprofile,{$tp}eventdata1d
                                                       where eventName='health_mega' 
                                                             and eventCategory='item'
                                                             and games>$avg_games 
                                                             and {$tp}playerprofile.playerID={$tp}eventdata1d.playerID
                                                             
                                                       group by {$tp}eventdata1d.playerID
                                                       ORDER BY value DESC
                                                    ";
//------------------------------------------------

$awardset['kr']['name']                             = 'Best Killer';
$awardset['kr']['image']                            = 'player_killer';
$awardset['kr']['category']                         = 'Player';
      
$awardset['kr']['sql'][0]                           = "select playerID, playerName, kills/(games+$avg_games) from {$tp}playerprofile
                                                       where games>$avg_games 
                                                       ORDER BY kills/(games+$avg_games) DESC
                                                    ";
//------------------------------------------------
$awardset['ks']['name']                             = 'Highest Kill Streak';
$awardset['ks']['image']                            = 'player_killstreak';
$awardset['ks']['category']                         = 'Player';

$awardset['ks']['sql'][0]                           = "select playerID, playerName, kill_streak
                                                       from {$tp}playerprofile
                                                       ORDER BY kill_streak DESC
                                                    ";
//------------------------------------------------
$awardset['eff']['name']                            = 'Best Efficiency';
$awardset['eff']['image']                           = 'player_efficiency';
$awardset['eff']['category']                        = 'Player';

$awardset['eff']['sql'][0]                          = "select playerID, playerName, kills/(1+kills+deaths)
                                                       from {$tp}playerprofile
                                                       where games>$avg_games 
                                                       ORDER BY kills/(1+kills+deaths) DESC
                                                    ";
//------------------------------------------------
$awardset['killer__v_weapons']['name']                = 'Best Killer with _v_weapons';
$awardset['killer__v_weapons']['image']               = 'killer__v_weapons';
$awardset['killer__v_weapons']['category']            = 'Carnage';
 
$awardset['killer__v_weapons']['sql'][0]              = "select {$tp}playerprofile.playerID,{$tp}playerprofile.playerName,sum(eventValue) as Kills, {$tp}playerprofile.games as Games, round((sum(eventValue)/{$tp}playerprofile.games),2) as kill_ratio
                                                      from {$tp}eventdata2d,{$tp}playerprofile
                                                      where {$tp}playerprofile.games>$avg_games and
                                                            (eventName='_v_weapons') and
                                                            eventCategory='kill' and
                                                            {$tp}playerprofile.playerID={$tp}eventdata2d.playerID and
                                                            {$tp}eventdata2d.playerID!={$tp}eventdata2d.player2ID
                                                      group by {$tp}eventdata2d.playerID
                                                      ORDER by kill_ratio DESC
                                                   ";







//------------------------------------------------------------------
// Accuracy awards using compiled tables to make it fast
//
$awardset['accuracy_set_table']['sql'][0]    = "drop table {$tp}awardsaccuracy";

$awardset['accuracy_set_table']['sql'][1]    = "CREATE TABLE {$tp}awardsaccuracy (
                                                playerID varchar(100) NOT NULL default ''
                                                ,playerName varchar(255) NOT NULL default ''
                                                ,weaponID varchar(100) NOT NULL default ''
                                                ,games int(10) unsigned default '0'
                                                ,hits int(10) unsigned default '0'
                                                ,shots int(10) unsigned default '0'
                                                ,accuracy float(10,2) unsigned default '0'
                                                ,PRIMARY KEY  (playerID,weaponID)
                                              ) TYPE=MyISAM                                    
                                              ";

$awardset['accuracy__v_weapons_populate_table']['sql'][0]  = "insert into {$tp}awardsaccuracy
                                                              select ed1.playerID
                                                                     ,{$tp}playerprofile.playerName
                                                                     ,ed1.eventName
                                                                     ,{$tp}playerprofile.games as games
                                                                     ,sum(ed1.eventValue) as hits 
                                                                     ,sum(ed2.eventValue) as shots
                                                                     ,round(sum(ed1.eventValue)/sum(ed2.eventValue)*100.0,2) as accuracy 
                                                              from {$tp}eventdata2d as ed1,{$tp}playerprofile 
                                                              left join {$tp}eventdata2d as ed2 
                                                              on (
                                                                  ed1.playerid=ed2.playerid and
                                                                  ed1.gameid=ed2.gameid and 
                                                                  ed1.round=ed2.round and
                                                                  ed1.team=ed2.team and 
                                                                  ed1.role=ed2.role and 
                                                                  ed1.eventCategory=ed2.eventCategory and
                                                                  ed1.player2id=ed2.player2id and 
                                                                  ed1.team2=ed2.team2 and 
                                                                  ed1.role2=ed2.role2
                                                                 ) 
                                                              where 
                                                              {$tp}playerprofile.games>$avg_games 
                                                              and {$tp}playerprofile.playerID=ed1.playerID 
                                                              and ed1.eventName='_v_weapons_hits' 
                                                              and ed2.eventName='_v_weapons_shots'
                                                              and ed1.eventCategory='accuracy'
                                                              group by playerID,ed1.eventName
                                                              order by accuracy DESC
                                                              ";


$awardset['avg_shots__v_weapons']['sql'][0]    = "select std(shots)
                                               from {$tp}awardsaccuracy
                                               where weaponID='_v_weapons_hits' 
                                               group by weaponID 
                                    ";


$awardset['accuracy__v_weapons']['name']                 = 'Best Accuracy with _v_weapons';
$awardset['accuracy__v_weapons']['image']                = 'accuracy__v_weapons';
$awardset['accuracy__v_weapons']['category']             = 'Accuracy';
$awardset['accuracy__v_weapons']['sql'][0]               = "select playerID,playerName,games,hits ,shots,accuracy 
                                                          from {$tp}awardsaccuracy
                                                          where weaponID='_v_weapons_hits'
                                                          and shots > ({\$awardset['avg_shots_v_weapons']['sql'][0][0]}-1)
                                                          group by playerID
                                                          order by accuracy DESC
                                                          ";




$awardset['accuracyALLWEAPONS']['name']                 = 'Best Overall Accuracy';
$awardset['accuracyALLWEAPONS']['image']                = 'accuracy_ALLWEAPONS';
$awardset['accuracyALLWEAPONS']['category']             = 'Accuracy';
$awardset['accuracyALLWEAPONS']['sql'][0]               = "select playerID
                                                                  ,playerName,games
                                                                  ,sum(hits) as hits
                                                                  ,sum(shots) as shots
                                                                  ,sum(hits)/sum(shots) as accuracy 
                                                           from {$tp}awardsaccuracy 
                                                           group by playerID 
                                                           order by accuracy DESC,hits/games DESC";











//------------------------------------------------------------------












/*
//------------------------------------------------------------------
// Accuracy awards using direct method (slow)
//
$awardset['avg_shots__v_weapons']['sql'][0]    = "select avg(eventValue) as shots 
                                               from {tp}eventdata2d 
                                               where eventname='_v_weapons_shots' 
                                               group by playerid 
                                               order by shots desc
                                    ";


$awardset['accuracy__v_weapons-direct']['name']           = 'Best Accuracy with _v_weapons';
$awardset['accuracy__v_weapons-direct']['image']               = 'accuracy__v_weapons';
$awardset['accuracy__v_weapons-direct']['category']            = 'Accuracy';
$awardset['accuracy__v_weapons-direct']['sql'][0] = "select ed1.playerID,{$tp}playerprofile.playerName,{$tp}playerprofile.games as games,sum(ed1.eventValue) as hits ,sum(ed2.eventValue) as shots,round(sum(ed1.eventValue)/sum(ed2.eventValue)*100.0,2) as accuracy 
                                            from {$tp}eventdata2d as ed1,{$tp}playerprofile 
                                            left join {$tp}eventdata2d as ed2 
                                            on (
                                                ed1.playerid=ed2.playerid and
                                                ed1.gameid=ed2.gameid and 
                                                ed1.round=ed2.round and
                                                ed1.team=ed2.team and 
                                                ed1.role=ed2.role and 
                                                ed1.eventCategory=ed2.eventCategory and
                                                ed1.player2id=ed2.player2id and 
                                                ed1.team2=ed2.team2 and 
                                                ed1.role2=ed2.role2
                                               ) 
                                            where 
                                            {$tp}playerprofile.playerID=ed1.playerID and 
                                            ed1.eventName='_v_weapons_hits' and ed2.eventName='_v_weapons_shots'
                                            group by playerID
                                            having shots > ({\$awardset['avg_shots_v_weapons']['sql'][0][0]}-1)
                                            and games>$avg_games 
                                            order by accuracy DESC
                                            ";

//------------------------------------------------------------------
*/








?>