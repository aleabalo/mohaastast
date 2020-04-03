<? /* vsp stats processor, copyright 2004-2005, myrddin8 AT gmail DOT com (a924cb279be8cb6089387d402288c9f2) */
 define("cVERSION","0.45"); define("cTITLE", /*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/" ----------------------------------------------------------------------------- "."\r\n".
/*__POBS_EXCLUDE__*/"                     vsp stats processor (c) 2004-2005                         "."\r\n".
/*__POBS_EXCLUDE__*/"                               version ".constant("cVERSION")."                                    "."\r\n".
/*__POBS_EXCLUDE__*/"                 vsp by myrddin (myrddin8 AT gmail DOT com)                    "."\r\n".
/*__POBS_EXCLUDE__*/" ----------------------------------------------------------------------------- "."\r\n".
"\r\n");
define("cUSAGE", /*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"  ---------------------------------------------------------------------------  "."\r\n".
/*__POBS_EXCLUDE__*/"  Usage: php vsp.php [options] [-p parserOptions] [logFilename]                "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    [options]                                                                  "."\r\n".
/*__POBS_EXCLUDE__*/"    ---------                                                                  "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    -c                 specify config file (must be in pub/configs/)           "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    -l                 specify logType (gamecode-gametype)                     "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"                         logType:-                                             "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"                           client           Client Logs (Any game)             "."\r\n".
/*__POBS_EXCLUDE__*/"                           cod              Call Of Duty, United Offensive     "."\r\n".
/*__POBS_EXCLUDE__*/"                           hl               HalfLife 1 & 2, CS:Source etc.     "."\r\n".
/*__POBS_EXCLUDE__*/"                           moh              Medal Of Honor AA,SH,BT,PA? etc.   "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a              Quake 3 Arena (and q3 engine games)"."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-battle       Quake 3 Arena BattleMod            "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-cpma         Quake 3 Arena CPMA (Promode)       "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-freeze       Quake 3 Arena (U)FreezeTag etc.    "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-lrctf        Quake 3 Arena Lokis Revenge CTF    "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-osp          Quake 3 Arena OSP                  "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-ra3          Quake 3 Arena Rocket Arena 3       "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-threewave    Quake 3 Arena Threewave            "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-ut           Quake 3 Arena UrbanTerror          "."\r\n".
/*__POBS_EXCLUDE__*/"                           q3a-xp           Quake 3 Arena Excessive Plus       "."\r\n".
/*__POBS_EXCLUDE__*/"                           rtcw             Return to Castle Wolfenstein       "."\r\n".
/*__POBS_EXCLUDE__*/"                           sof2             Soldier of Fortune 2               "."\r\n".
/*__POBS_EXCLUDE__*/"                           wet              Wolfenstein: Enemy Territory       "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    -n                                                                         "."\r\n".
/*__POBS_EXCLUDE__*/"                         No confirmation/prompts (for unattended runs etc.)    "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    -a                 specify action                                          "."\r\n".
/*__POBS_EXCLUDE__*/"                         perform a specific predefined action                  "."\r\n".
/*__POBS_EXCLUDE__*/"                         *make sure this is the last option specified!*        "."\r\n".
/*__POBS_EXCLUDE__*/"                         [logFilename] is not needed if this option is used    "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"                         action:-                                              "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"                           clear_db         Clear the database in config       "."\r\n".             
/*__POBS_EXCLUDE__*/"                                            ie. Reset Stats                    "."\r\n".             
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    -p [parserOptions]                                                         "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"       savestate       1                                                       "."\r\n".
/*__POBS_EXCLUDE__*/"                         Enable savestate processing                           "."\r\n".
/*__POBS_EXCLUDE__*/"                         Remembers previously scanned logs and events.         "."\r\n".
/*__POBS_EXCLUDE__*/"                         If this option is enabled, VSP will remember the      "."\r\n".
/*__POBS_EXCLUDE__*/"                         location in the log file where the last stats was     "."\r\n".
/*__POBS_EXCLUDE__*/"                         parsed from. So the next time VSP is run with the     "."\r\n".
/*__POBS_EXCLUDE__*/"                         savestate 1 option against the same log file, it will "."\r\n".
/*__POBS_EXCLUDE__*/"                         start parsing the stats from the previous saved       "."\r\n".
/*__POBS_EXCLUDE__*/"                         location.                                             "."\r\n".
/*__POBS_EXCLUDE__*/"                         If you want VSP to forget this save state, then you   "."\r\n".
/*__POBS_EXCLUDE__*/"                         have to delete the corresponding save state file from "."\r\n". 
/*__POBS_EXCLUDE__*/"                         the logdata/ folder. The name is in the format        "."\r\n".
/*__POBS_EXCLUDE__*/"                         savestate_[special_Form_Of_Logfile_Name]              "."\r\n".
/*__POBS_EXCLUDE__*/"                         Deleting that file and running VSP again with         "."\r\n".
/*__POBS_EXCLUDE__*/"                         savestate 1 option will reparse the whole log again   "."\r\n".
/*__POBS_EXCLUDE__*/"                         from the beginning. Also note that each logfile will  "."\r\n".
/*__POBS_EXCLUDE__*/"                         have a separate save state file under the logdata     "."\r\n".
/*__POBS_EXCLUDE__*/"                         folder. Do not edit/modify the savestate files! If    "."\r\n".
/*__POBS_EXCLUDE__*/"                         you dont want it, just delete it.                     "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"       check ReadME or first few lines of a particular parser php for other    "."\r\n".
/*__POBS_EXCLUDE__*/"       valid options for that particular parser                                "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    [logFilename] could be an FTP link/url. Set FTP username/password in config"."\r\n".
/*__POBS_EXCLUDE__*/"    [logFilename] may be a logDirectory for some games. ex:- *HalfLife*        "."\r\n".
/*__POBS_EXCLUDE__*/"                                                                               "."\r\n".
/*__POBS_EXCLUDE__*/"    Usage: php vsp.php [options] [-p parserOptions] [logFilename]              "."\r\n".
/*__POBS_EXCLUDE__*/"  Example: php vsp.php -l q3a -p savestate 1 \"c:/quake iii arena/games.log\"    "."\r\n".
/*__POBS_EXCLUDE__*/"  ---------------------------------------------------------------------------  "."\r\n".
"\r\n"); 
class F02ac4643 { var $Vf273a653; var $V56cacbad=0; var $Vb77eef69=0; var $V282dbc1d; var $V75125d17;
 var $V42dfa3a4; function F47fe6c4c($V2e7bf2ef) { if (isset($GLOBALS['skillset']['weapon_factor'][$V2e7bf2ef]))
 { return $GLOBALS['skillset']['weapon_factor'][$V2e7bf2ef]; } return 1.0; } function F4af5007c($V2da2c443)
 { if (isset($GLOBALS['skillset']['event'][$V2da2c443])) { return $GLOBALS['skillset']['event'][$V2da2c443];
} return 0.0; } function F428ddac6($V116ad936) { global $V9c1ebee8; $V116ad936=$V9c1ebee8->qstr($V116ad936);
 $Vac5c74b6="select skill from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile where playerID=$V116ad936
 "; $V3a2d7564=$V9c1ebee8->Execute($Vac5c74b6); if ($V3a2d7564 and !$V3a2d7564->EOF) if ($V3a2d7564->fields[0]>=1000.00)
 return $V3a2d7564->fields[0]; return 1000.0; } function Fec5ab55c($V418c5509,$Vafe72417,$V38bb9770,$V7b824acf)
 { if (!isset($this->V75125d17[$Vafe72417])) { return; } if (!strcmp($V418c5509,"rep")) { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509;
$this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]=$V7b824acf; } else if (!strcmp($V418c5509,"inc"))
 { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509; if (isset($this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]))
 $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]+=$V7b824acf; else $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]=$V7b824acf;
} else if (!strcmp($V418c5509,"avg")) { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509;
if (isset($this->V75125d17[$Vafe72417]['data'][$V38bb9770][1])) $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]=round(($V7b824acf + $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1])/2.0 ,2);
else $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]=$V7b824acf; } else if (!strcmp($V418c5509,"sto"))
 { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509; $Vb67d07b7 = count($this->V75125d17[$Vafe72417]['data'][$V38bb9770]);
$this->V75125d17[$Vafe72417]['data'][$V38bb9770][$Vb67d07b7]=$V7b824acf; } else if (!strcmp($V418c5509,"sto_uni"))
 { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509; if (!isset($this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]))
 { $this->V75125d17[$Vafe72417]['data'][$V38bb9770][1]=$V7b824acf; } else { $Vb67d07b7 = count($this->V75125d17[$Vafe72417]['data'][$V38bb9770]); 
 unset($this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]); if (array_search($V7b824acf,$this->V75125d17[$Vafe72417]['data'][$V38bb9770])===false)
 $this->V75125d17[$Vafe72417]['data'][$V38bb9770][$Vb67d07b7]=$V7b824acf; $this->V75125d17[$Vafe72417]['data'][$V38bb9770][0]=$V418c5509;
} } } function F95791962($Vafe72417,$V11bc833e) { if (!isset($this->V75125d17[$Vafe72417])) { return;
} if (isset($this->V75125d17[$V11bc833e])) { Fb7d30ee1("PlayerID Conflict Detected\n"); } foreach($this->V75125d17 as $Vd915074e => $V245742dd)
 { if (!isset($V245742dd['events'])) continue; foreach($V245742dd['events'] as $Vf4345940 => $Vc00710ee)
 { foreach($Vc00710ee as $Vccefc8b4 => $V7ccb0a11) { foreach($V7ccb0a11 as $V23488d50 => $Vdb6db230)
 { if (!isset($Vdb6db230['2D'])) continue; foreach($Vdb6db230['2D'] as $V5fe26767 => $V80cbfddc) {
 foreach($V80cbfddc as $V64d90431 => $V68a881e6) { foreach($V68a881e6 as $Vd85cbecd => $V27ccee9d)
 { if (strcmp($Vd85cbecd,$Vafe72417)==0) { $this->V75125d17[$Vd915074e]['events'][$Vf4345940][$Vccefc8b4][$V23488d50]['2D'][$V5fe26767][$V64d90431][$V11bc833e]=$V27ccee9d;
unset($this->V75125d17[$Vd915074e]['events'][$Vf4345940][$Vccefc8b4][$V23488d50]['2D'][$V5fe26767][$V64d90431][$Vd85cbecd]);
} } } } } } } } $this->V75125d17[$V11bc833e]=$this->V75125d17[$Vafe72417]; unset($this->V75125d17[$Vafe72417]); 
 } function Fddcbd60f($Vafe72417,$V44ae8273) { if (!isset($this->V75125d17[$Vafe72417])) { return;
} $this->V75125d17[$Vafe72417]['profile']['name']=$V44ae8273; } function F0a0dc2ec($Vafe72417,$Vbaec6461)
 { if (!isset($this->V75125d17[$Vafe72417])) { return; } $this->V75125d17[$Vafe72417]['vdata']['icon'][0]=""; 
 $this->V75125d17[$Vafe72417]['vdata']['icon'][1]="$Vbaec6461"; } function Fa3f3cadc($Vafe72417,$V29a7e964)
 { if (!isset($this->V75125d17[$Vafe72417])) { return; } $this->V75125d17[$Vafe72417]['vdata']['role'][0]=""; 
 $this->V75125d17[$Vafe72417]['vdata']['role'][1]="$V29a7e964"; } function F555c9055($Vafe72417,$Vf894427c)
 { if (!isset($this->V75125d17[$Vafe72417])) { return; } $this->V75125d17[$Vafe72417]['vdata']['team'][0]=""; 
 $this->V75125d17[$Vafe72417]['vdata']['team'][1]="$Vf894427c"; if (!isset($this->V282dbc1d[$Vf894427c]))
 $this->V282dbc1d[$Vf894427c]='1'; } function F52d4d302($Vf894427c) { if (!isset($this->V282dbc1d[$Vf894427c]))
 $this->V282dbc1d[$Vf894427c]='1'; } function F7161116f() { $this->Vb77eef69++; } function F15999c20()
 { } function F6d04475a($V2cbf43a2,$Vcb99dc4d) { if (preg_match("/^_v_/", $V2cbf43a2, $Vb74df323)) 
 $this->Vf273a653[$V2cbf43a2]=$Vcb99dc4d; else if (isset($GLOBALS['cfg']['data_filter']['gamedata']['']) && preg_match($GLOBALS['cfg']['data_filter']['gamedata'][''], $V2cbf43a2, $Vb74df323))
 return; else $this->Vf273a653[$V2cbf43a2]=$Vcb99dc4d; } function F6aae4907($Vafe72417,$V3b043eba)
 { foreach ($GLOBALS['player_ban_list'] as $V7fa3b767 => $V9539adc5) { if (preg_match($V9539adc5, $Vafe72417, $Vb74df323))
 { return; } } if (isset($this->V75125d17[$Vafe72417])) { return; } $this->V75125d17[$Vafe72417]['v']['original_id']=$Vafe72417;
 $this->V75125d17[$Vafe72417]['profile']['name']="$V3b043eba"; $this->V75125d17[$Vafe72417]['profile']['skill']=$this->F428ddac6($Vafe72417);
$this->V75125d17[$Vafe72417]['profile']['kills']=0; $this->V75125d17[$Vafe72417]['profile']['deaths']=0;
$this->V75125d17[$Vafe72417]['profile']['kill_streak']=0; $this->V75125d17[$Vafe72417]['profile']['kill_streak_counter']=0;
$this->V75125d17[$Vafe72417]['profile']['death_streak']=0; $this->V75125d17[$Vafe72417]['profile']['death_streak_counter']=0;
 $this->V75125d17[$Vafe72417]['data']=array(); $this->V75125d17[$Vafe72417]['vdata']['team'][0]=""; 
 $this->V75125d17[$Vafe72417]['vdata']['team'][1]=""; $this->V75125d17[$Vafe72417]['vdata']['role'][0]=""; 
 $this->V75125d17[$Vafe72417]['vdata']['role'][1]=""; $this->Fec5ab55c("sto",$Vafe72417,"alias",$V3b043eba); 
 } function F8405e6ea($Vafe72417,$V7a674c32) { if (!isset($this->V75125d17[$Vafe72417])) { return;
} if (preg_match("/\d/",$V7a674c32) || preg_match("/@/",$V7a674c32)) { return; } $this->V75125d17[$Vafe72417]['vdata']['quote'][0]="rep";
 if (!isset($this->V75125d17[$Vafe72417]['vdata']['quote'][1])) $this->V75125d17[$Vafe72417]['vdata']['quote'][1]="$V7a674c32";
else if (strlen($this->V75125d17[$Vafe72417]['vdata']['quote'][1])<5) $this->V75125d17[$Vafe72417]['vdata']['quote'][1]="$V7a674c32";
else if (strlen($V7a674c32)>25) $this->V75125d17[$Vafe72417]['vdata']['quote'][1]="$V7a674c32"; else if (mt_rand(1,10) <= 5)
 $this->V75125d17[$Vafe72417]['vdata']['quote'][1]="$V7a674c32"; } function Fd45b6912() { $this->F242ca9da(); 
 $this->V56cacbad++; echo "Analyzing game ".sprintf("%04d ",$this->V56cacbad); Fa10803e1(); $this->Vb77eef69=0;
} function Fc3b570a7() { if (isset($this->V75125d17)) { foreach($this->V75125d17 as $Vafe72417 => $V910d9037)
 { if ($this->V75125d17[$Vafe72417]['profile']['death_streak_counter'] > $this->V75125d17[$Vafe72417]['profile']['death_streak'])
 $this->V75125d17[$Vafe72417]['profile']['death_streak']=$this->V75125d17[$Vafe72417]['profile']['death_streak_counter'];
if ($this->V75125d17[$Vafe72417]['profile']['kill_streak_counter'] > $this->V75125d17[$Vafe72417]['profile']['kill_streak'])
 $this->V75125d17[$Vafe72417]['profile']['kill_streak']=$this->V75125d17[$Vafe72417]['profile']['kill_streak_counter'];
} } } function Fb03ee647() { foreach($this->V75125d17 as $Vafe72417 => $V910d9037) { if (isset($this->V75125d17[$Vafe72417]['events']))
 { unset($this->V75125d17[$Vafe72417]['events']); } $this->V75125d17[$Vafe72417]['profile']['skill']=$this->F428ddac6($Vafe72417);
$this->V75125d17[$Vafe72417]['profile']['kills']=0; $this->V75125d17[$Vafe72417]['profile']['deaths']=0;
$this->V75125d17[$Vafe72417]['profile']['kill_streak']=0; $this->V75125d17[$Vafe72417]['profile']['kill_streak_counter']=0;
$this->V75125d17[$Vafe72417]['profile']['death_streak']=0; $this->V75125d17[$Vafe72417]['profile']['death_streak_counter']=0;
$this->V75125d17[$Vafe72417]['data']=array(); } } function F242ca9da() { if (isset($this->V75125d17))
 unset($this->V75125d17); if (isset($this->Vf273a653)) unset($this->Vf273a653); if (isset($this->V282dbc1d))
 unset($this->V282dbc1d); if (isset($this->V42dfa3a4)) unset($this->V42dfa3a4); } function F26dd5333()
 { if (isset($this->V75125d17)) return ($this->V75125d17); return FALSE; } function F068fac4f()
 { if (isset($this->Vf273a653)) return ($this->Vf273a653); return FALSE; } function F89da123b($Vf894427c,$V2da2c443,$V6ae4aaa3)
 { $V10dad7cb=''; $Vf1a19314=$V2da2c443; if (preg_match("/^(.*)\\|(.+)/", $Vf1a19314, $Vb74df323))
 { $V10dad7cb=$Vb74df323[1]; $Vf1a19314=$Vb74df323[2];; } if (isset($GLOBALS['cfg']['data_filter']['events'][$V10dad7cb]) && preg_match($GLOBALS['cfg']['data_filter']['events'][$V10dad7cb], $Vf1a19314, $Vb74df323))
 return; if (!$this->V75125d17) return; foreach($this->V75125d17 as $Vd915074e => $V163b0d74) {
 $V29a7e964=$this->V75125d17[$Vd915074e]['vdata']['role'][1]; if (!isset($this->V75125d17[$Vd915074e]['events'][$this->Vb77eef69][$Vf894427c]))
 continue; if (!isset($this->V75125d17[$Vd915074e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]))
 $this->V75125d17[$Vd915074e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]=0;
$this->V75125d17[$Vd915074e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]+=$V6ae4aaa3;
$this->V75125d17[$Vd915074e]['profile']['skill']+=$this->F4af5007c($V2da2c443); } } function F72d01d3f($Vafe72417,$V2da2c443,$V6ae4aaa3)
 { if (!isset($this->V75125d17[$Vafe72417])) return; $V10dad7cb=''; $Vf1a19314=$V2da2c443; if (preg_match("/^(.*)\\|(.+)/", $Vf1a19314, $Vb74df323))
 { $V10dad7cb=$Vb74df323[1]; $Vf1a19314=$Vb74df323[2];; } if (isset($GLOBALS['cfg']['data_filter']['events'][$V10dad7cb]) && preg_match($GLOBALS['cfg']['data_filter']['events'][$V10dad7cb], $Vf1a19314, $Vb74df323))
 return; $Vf894427c=$this->V75125d17[$Vafe72417]['vdata']['team'][1]; $V29a7e964=$this->V75125d17[$Vafe72417]['vdata']['role'][1];
if (!isset($this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]))
 $this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]=0;
$this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['1D'][$V2da2c443]+=$V6ae4aaa3;
 $this->V75125d17[$Vafe72417]['profile']['skill']+=$this->F4af5007c($V2da2c443); } function F4135e567($Vafe72417,$V863818d8,$V2da2c443,$V6ae4aaa3)
 { if (!isset($this->V75125d17[$Vafe72417]) || !isset($this->V75125d17[$V863818d8])) { return; }
$Vf894427c=$this->V75125d17[$Vafe72417]['vdata']['team'][1]; $V29a7e964=$this->V75125d17[$Vafe72417]['vdata']['role'][1];
 $V60962ab1=$this->V75125d17[$V863818d8]['vdata']['team'][1]; $V84ccdc56=$this->V75125d17[$V863818d8]['vdata']['role'][1];
if (isset($this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V863818d8][$V2da2c443]))
 { $this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V863818d8][$V2da2c443]+=$V6ae4aaa3;
} else { $this->V75125d17[$Vafe72417]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V863818d8][$V2da2c443]=$V6ae4aaa3;
} $this->V75125d17[$Vafe72417]['profile']['skill']+=$this->F4af5007c($V2da2c443); } function Fd65f3244($V4b8cff0e,$V6426a622,$V2e7bf2ef)
 { if (!isset($this->V75125d17[$V4b8cff0e]) || !isset($this->V75125d17[$V6426a622])) { return; } 
 $Ve7bf558f = $this->V75125d17[$V6426a622]['profile']['skill'] * $GLOBALS['skillset']['fraction']['value'] ;
$Vf894427c=$this->V75125d17[$V4b8cff0e]['vdata']['team'][1]; $V29a7e964=$this->V75125d17[$V4b8cff0e]['vdata']['role'][1];
$V60962ab1=$this->V75125d17[$V6426a622]['vdata']['team'][1]; $V84ccdc56=$this->V75125d17[$V6426a622]['vdata']['role'][1]; 
 if (strcmp($V4b8cff0e,$V6426a622)!=0) { if ( (count($this->V282dbc1d)>1 && strcmp($Vf894427c,$V60962ab1)==0))
 { if (!isset($this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["teamkill|$V2e7bf2ef"]))
 $this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["teamkill|$V2e7bf2ef"]=0;
$this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["teamkill|$V2e7bf2ef"]++;
 $Ve97b3886 = $this->V75125d17[$V4b8cff0e]['profile']['skill'] * $GLOBALS['skillset']['fraction']['value'];
$this->V75125d17[$V4b8cff0e]['profile']['skill']-=$Ve97b3886; } else { if (!isset($this->V42dfa3a4['first killer']))
 { $this->F72d01d3f($V4b8cff0e,"first killer",1); $this->F72d01d3f($V6426a622,"first victim",1); $this->V42dfa3a4['first killer']=1;
} if (!isset($this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["kill|$V2e7bf2ef"]))
 $this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["kill|$V2e7bf2ef"]=0;
$this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["kill|$V2e7bf2ef"]++;
$this->V75125d17[$V4b8cff0e]['profile']['kills']++; $this->V75125d17[$V4b8cff0e]['profile']['kill_streak_counter']++;
if ($this->V75125d17[$V4b8cff0e]['profile']['death_streak_counter'] > $this->V75125d17[$V4b8cff0e]['profile']['death_streak'])
 $this->V75125d17[$V4b8cff0e]['profile']['death_streak']=$this->V75125d17[$V4b8cff0e]['profile']['death_streak_counter'];
$this->V75125d17[$V4b8cff0e]['profile']['death_streak_counter']=0; $this->V75125d17[$V4b8cff0e]['profile']['skill']+=$this->F47fe6c4c($V2e7bf2ef) * $Ve7bf558f;
$this->V75125d17[$V6426a622]['profile']['skill']-=$Ve7bf558f; } } else { if (!isset($this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["suicide|$V2e7bf2ef"]))
 $this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["suicide|$V2e7bf2ef"]=0;
$this->V75125d17[$V4b8cff0e]['events'][$this->Vb77eef69][$Vf894427c][$V29a7e964]['2D'][$V60962ab1][$V84ccdc56][$V6426a622]["suicide|$V2e7bf2ef"]++; 
 $this->V75125d17[$V6426a622]['profile']['skill']-=$Ve7bf558f; } $this->V75125d17[$V6426a622]['profile']['deaths']++;
$this->V75125d17[$V6426a622]['profile']['death_streak_counter']++; if ($this->V75125d17[$V6426a622]['profile']['kill_streak_counter'] > $this->V75125d17[$V6426a622]['profile']['kill_streak'])
 $this->V75125d17[$V6426a622]['profile']['kill_streak']=$this->V75125d17[$V6426a622]['profile']['kill_streak_counter'];
$this->V75125d17[$V6426a622]['profile']['kill_streak_counter']=0; } } class F622a322a { var $V75125d17;
 var $V7da699e4; var $Vf273a653; function F622a322a() { } function F61ee4b91() { foreach($this->V75125d17 as $Vafe72417 => $V910d9037)
 { foreach($V910d9037 as $V17f71d96 => $Vf57346d3) { if (!strcmp($V17f71d96,'events')) { foreach($Vf57346d3 as $V9bbd993d => $V61b837be)
 { foreach($V61b837be as $Vf894427c => $Vf60229f3) { foreach($Vf60229f3 as $V29a7e964 => $V91812ae6)
 { foreach($V91812ae6 as $V1cd03614 => $V9290beca) { $V0ba4439e=0; if (sizeof($V91812ae6['1D'])<=1 && $this->V75125d17[$Vafe72417]['profile']['deaths']==0) 
 { $V0ba4439e=1; if (array_key_exists('2D',$V91812ae6)) { $V0ba4439e=0; } } if ($V0ba4439e==1) {
 unset($this->V75125d17[$Vafe72417]['events'][$V9bbd993d][$Vf894427c][$V29a7e964]); } } } } } } 
 } } } function Fefea820f() { global $V9c1ebee8; $Vac5c74b6="select count(*) from {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d";
$V3a2d7564=$V9c1ebee8->Execute($Vac5c74b6); if ($V3a2d7564 && $V3a2d7564->fields[0]>10000) { $V9ab2ec7e["{$GLOBALS['cfg']['db']['table_prefix']}".'eventdata1d']=1;
$V9ab2ec7e["{$GLOBALS['cfg']['db']['table_prefix']}".'eventdata2d']=1; foreach ($V9ab2ec7e as $V4b27b6e5 => $V3a6d0284 )
 { echo "purifyDb: checking for probable bad entries from $V4b27b6e5\n"; $Vac5c74b6="select eventCategory, eventName, count(*) as c from $V4b27b6e5 group by eventCategory,eventName having c<3"; 
 $V3a2d7564=$V9c1ebee8->Execute($Vac5c74b6); if ($V3a2d7564 && !$V3a2d7564->EOF) { echo "purifyDb: removing probable bad entries from $V4b27b6e5\n";
do { $V63d2929c="delete from $V4b27b6e5 where eventCategory=".$V9c1ebee8->qstr($V3a2d7564->fields[0]).
 " AND eventName=".$V9c1ebee8->qstr($V3a2d7564->fields[1]) ; $V4fc2f671=$V9c1ebee8->Execute($V63d2929c);
if ($V4fc2f671) echo "purifyDb: removed: category-{$V3a2d7564->fields[0]}, name-{$V3a2d7564->fields[1]}\n";
}while ($V3a2d7564->MoveNext() && !$V3a2d7564->EOF); } echo "purifyDb: done\n"; } } } function F215f9169()
 { $tp=$GLOBALS['cfg']['db']['table_prefix']; include_once("pub/games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$GLOBALS['cfg']['awardset']}-awards.php");
 @include_once("pub/games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$GLOBALS['cfg']['weaponset']}-weapons.php");
global $V9c1ebee8; echo "\ngenerateAwards: Generating Awards..."; Fa10803e1(); if (!isset($GLOBALS['awardset']))
 { echo "Award Definitions not found.\n"; echo " "."pub/games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$GLOBALS['cfg']['awardset']}-awards.php\n";
return; } $awardset_expanded=array(); $Vac5c74b6="select distinct eventName from {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d where eventCategory='kill' order by eventName"; 
 $V3a2d7564=$V9c1ebee8->Execute($Vac5c74b6); foreach($GLOBALS['awardset'] as $Vee670b78 => $V853346d3)
 { if (strstr($Vee670b78,'_v_weapons')) { if ($V3a2d7564) { $V3a2d7564->MoveFirst(); do { $V15b259db=preg_replace("/_v_weapons/",$V3a2d7564->fields[0],$Vee670b78); 
 if (isset($GLOBALS['awardset'][$Vee670b78]['name'])) { if (isset($weaponset[$V3a2d7564->fields[0]]['name']))
 $awardset_expanded[$V15b259db]['name']=preg_replace("/_v_weapons/",$weaponset[$V3a2d7564->fields[0]]['name'],$GLOBALS['awardset'][$Vee670b78]['name']);
else $awardset_expanded[$V15b259db]['name']=preg_replace("/_v_weapons/",ucfirst(strtolower(str_replace("_", " ",$V3a2d7564->fields[0]))), $GLOBALS['awardset'][$Vee670b78]['name']);
} if (isset($GLOBALS['awardset'][$Vee670b78]['image'])) $awardset_expanded[$V15b259db]['image']=preg_replace("/_v_weapons/",$V3a2d7564->fields[0],$GLOBALS['awardset'][$Vee670b78]['image']);
if (isset($GLOBALS['awardset'][$Vee670b78]['category'])) $awardset_expanded[$V15b259db]['category']=preg_replace("/_v_weapons/",$V3a2d7564->fields[0],$GLOBALS['awardset'][$Vee670b78]['category']);
foreach($GLOBALS['awardset'][$Vee670b78]['sql'] as $Va76c847d => $V111b0e36) { $awardset_expanded[$V15b259db]['sql'][$Va76c847d]=preg_replace("/_v_weapons/",$V3a2d7564->fields[0],$GLOBALS['awardset'][$Vee670b78]['sql'][$Va76c847d]);
} }while ($V3a2d7564->MoveNext() && !$V3a2d7564->EOF); } } else { $awardset_expanded[$Vee670b78]=$GLOBALS['awardset'][$Vee670b78];
} } $Vac5c74b6="DELETE from {$GLOBALS['cfg']['db']['table_prefix']}awards where 1"; $V9c1ebee8->Execute($Vac5c74b6);
 foreach($awardset_expanded as $Vee670b78 => $V853346d3) { foreach($awardset_expanded[$Vee670b78]['sql'] as $Vf5c8a086 => $Vac5c74b6)
 { $Vac5c74b6=preg_replace("/awardset/","awardset_expanded",$Vac5c74b6); eval("\$Vac5c74b6=\"$Vac5c74b6\";");
$awardset_expanded[$Vee670b78]['sql_final']=preg_replace("/\s+/"," ",$Vac5c74b6); $V3a2d7564=$V9c1ebee8->Execute($Vac5c74b6); 
 $awardset_expanded[$Vee670b78]['sql'][$Vf5c8a086]=$V3a2d7564->fields; $awardset_expanded[$Vee670b78]['result']=$awardset_expanded[$Vee670b78]['sql'][$Vf5c8a086][0];
 } if (isset($awardset_expanded[$Vee670b78]['name'])) { if (!isset($awardset_expanded[$Vee670b78]['category']))
 $awardset_expanded[$Vee670b78]['category']=''; $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}awards 
 set awardID=".$V9c1ebee8->qstr($Vee670b78).""; ; $V9c1ebee8->Execute($Vac5c74b6); $Vac5c74b6="UPDATE {$GLOBALS['cfg']['db']['table_prefix']}awards
 set name=".$V9c1ebee8->qstr($awardset_expanded[$Vee670b78]['name'])." ,category=".$V9c1ebee8->qstr($awardset_expanded[$Vee670b78]['category'])."
 ,image=".$V9c1ebee8->qstr($awardset_expanded[$Vee670b78]['image'])." ,playerID=".$V9c1ebee8->qstr($awardset_expanded[$Vee670b78]['result'])."
 ,sql=".$V9c1ebee8->qstr($awardset_expanded[$Vee670b78]['sql_final'])." where awardID=".$V9c1ebee8->qstr($Vee670b78).""; 
 $V9c1ebee8->Execute($Vac5c74b6); } } echo "done\n"; Fa10803e1(); } function F43781db5(&$V7a55b3e1,&$Vcc64f241)
 { global $V9c1ebee8; if (!$V7a55b3e1) { print "game is empty?, ignored\n"; Fa10803e1(); return;
} print "updating database..."; Fa10803e1(); $this->V75125d17=$V7a55b3e1; $this->Vf273a653=$Vcc64f241;
$this->Vf273a653['_v_players']=count($this->V75125d17); if (!isset($this->Vf273a653['_v_players']))
 $this->Vf273a653['_v_players']="?"; if (!isset($this->Vf273a653['_v_map'])) $this->Vf273a653['_v_map']="?";
if (!isset($this->Vf273a653['_v_mod'])) $this->Vf273a653['_v_mod']="?"; if (!isset($this->Vf273a653['_v_game']))
 $this->Vf273a653['_v_game']="?"; if (!isset($this->Vf273a653['_v_game_type'])) $this->Vf273a653['_v_game_type']="?";
if (!isset($this->Vf273a653['_v_time_start'])) $this->Vf273a653['_v_time_start']="?"; do
 { preg_match("/^0\\.(\d+) (\d+)/", microtime(), $Vc7e009b7); $Vc7e009b7 = $Vc7e009b7[2].$Vc7e009b7[1];
} while ($this->V7da699e4== $Vc7e009b7); $this->V7da699e4=$Vc7e009b7; if ($this->Vf273a653) { foreach($this->Vf273a653 as $V2cbf43a2 => $Vcb99dc4d)
 { $V2cbf43a2 = $V9c1ebee8->qstr($V2cbf43a2); $Vcb99dc4d = $V9c1ebee8->qstr($Vcb99dc4d); $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}gamedata set gameID=$this->V7da699e4, name=$V2cbf43a2, value=$Vcb99dc4d";
$V9c1ebee8->Execute($Vac5c74b6); } } foreach($this->V75125d17 as $Vafe72417 => $V910d9037) { if ($this->V75125d17[$Vafe72417]['profile']['skill'] < 1000.0)
 $this->V75125d17[$Vafe72417]['profile']['skill']=1000.0; if ($GLOBALS['cfg']['parser']['use_original_playerID'])
 { $V910d9037['v']['original_id']=$V910d9037['v']['original_id']; } else { $V910d9037['v']['original_id']=$Vafe72417;
} $V910d9037['v']['original_id']=$V9c1ebee8->qstr(substr($V910d9037['v']['original_id'],0,99)); $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}playerprofile SET playerID={$V910d9037['v']['original_id']}"; 
 $V9c1ebee8->Execute($Vac5c74b6); if (isset($GLOBALS['cfg']['parser']['use_most_used_playerName']) && $GLOBALS['cfg']['parser']['use_most_used_playerName']==1)
 { $Vac5c74b6=sprintf("select dataValue, count(*) as num from {$GLOBALS['cfg']['db']['table_prefix']}playerdata 
 where dataName=%s and playerID={$V910d9037['v']['original_id']} group by dataValue order by num desc
 " ,$V9c1ebee8->qstr('alias') ); $V3a2d7564=$V9c1ebee8->SelectLimit($Vac5c74b6,1,0); if ($V3a2d7564 and !$V3a2d7564->EOF)
 { $V700270e9=$V9c1ebee8->qstr($V3a2d7564->fields[0]); } else { $V700270e9=$V9c1ebee8->qstr($this->V75125d17[$Vafe72417]['profile']['name']);
} $Vac5c74b6=sprintf("UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile SET playerName=%s, skill=%s, kills=kills+%s, deaths=deaths+%s, games=games+1 where playerID={$V910d9037['v']['original_id']}"
 ,$V700270e9 ,round($this->V75125d17[$Vafe72417]['profile']['skill']) ,$this->V75125d17[$Vafe72417]['profile']['kills']
 ,$this->V75125d17[$Vafe72417]['profile']['deaths'] ); } else { $Vac5c74b6=sprintf("UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile SET playerName=%s, skill=%s, kills=kills+%s, deaths=deaths+%s, games=games+1 where playerID={$V910d9037['v']['original_id']}"
 ,$V9c1ebee8->qstr($this->V75125d17[$Vafe72417]['profile']['name']) ,round($this->V75125d17[$Vafe72417]['profile']['skill'])
 ,$this->V75125d17[$Vafe72417]['profile']['kills'] ,$this->V75125d17[$Vafe72417]['profile']['deaths']
 ); } $V9c1ebee8->Execute($Vac5c74b6); $Vac5c74b6=sprintf("UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile SET kill_streak=%d WHERE playerID={$V910d9037['v']['original_id']} AND %d>kill_streak"
 ,$this->V75125d17[$Vafe72417]['profile']['kill_streak'] ,$this->V75125d17[$Vafe72417]['profile']['kill_streak']
 ); $V9c1ebee8->Execute($Vac5c74b6); $Vac5c74b6=sprintf("UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerprofile SET death_streak=%d WHERE playerID={$V910d9037['v']['original_id']} AND %d>death_streak"
 ,$this->V75125d17[$Vafe72417]['profile']['death_streak'] ,$this->V75125d17[$Vafe72417]['profile']['death_streak']
 ); $V9c1ebee8->Execute($Vac5c74b6); foreach($V910d9037 as $V17f71d96 => $Vf57346d3) { if (!strcmp($V17f71d96,'data') || !strcmp($V17f71d96,'vdata'))
 { foreach($Vf57346d3 as $V38bb9770 => $V260a7bf2) { $V7b824acf=$V260a7bf2[1]; $V38bb9770=$V9c1ebee8->qstr($V38bb9770);
 $V418c5509 = $V260a7bf2[0]; if (!strcmp($V418c5509,"rep") || !strcmp($V418c5509,"inc") || !strcmp($V418c5509,"avg"))
 { $V260a7bf2[1]=$V9c1ebee8->qstr($V260a7bf2[1]); if (!strcmp($V418c5509,"rep")) { $Vac5c74b6="UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerdata SET dataValue={$V260a7bf2[1]} where playerID={$V910d9037['v']['original_id']} and dataName=$V38bb9770 and gameID=0";
} else if (!strcmp($V418c5509,"inc")) { if ($V260a7bf2[1]==0) continue; $Vac5c74b6="UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerdata SET dataValue=dataValue+{$V260a7bf2[1]} where playerID={$V910d9037['v']['original_id']} and dataName=$V38bb9770 and gameID=0";
} else if (!strcmp($V418c5509,"avg")) { $Vac5c74b6="UPDATE {$GLOBALS['cfg']['db']['table_prefix']}playerdata SET dataValue=round((dataValue+{$V260a7bf2[1]})/2.0,2.0) where playerID={$V910d9037['v']['original_id']} and dataName=$V38bb9770 and gameID=0"; 
 } if ($V9c1ebee8->Execute($Vac5c74b6)!==false && $V9c1ebee8->Affected_Rows()==0) { $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}playerdata SET gameID=0, dataName=$V38bb9770, dataValue={$V260a7bf2[1]}, playerID={$V910d9037['v']['original_id']}";
$V9c1ebee8->Execute($Vac5c74b6); } } else if (!strcmp($V418c5509,"sto")) { unset ($V260a7bf2[0]);
foreach($V260a7bf2 as $V1b612377 => $V7b824acf) { $V7b824acf=$V9c1ebee8->qstr($V7b824acf); $V3a2d7564=$V9c1ebee8->Execute("select MAX(dataNo) from {$GLOBALS['cfg']['db']['table_prefix']}playerdata where gameID=$this->V7da699e4 AND dataName=$V38bb9770 AND playerID={$V910d9037['v']['original_id']}");
 if ($V3a2d7564 && !$V3a2d7564->EOF) { $Vba67c8ce=$V3a2d7564->fields[0]; } if (!isset($Vba67c8ce) || strlen($Vba67c8ce) < 1)
 { $Vba67c8ce=0; } else { $Vba67c8ce=$Vba67c8ce+1; } $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}playerdata SET gameID=$this->V7da699e4,dataName=$V38bb9770, dataNo=$Vba67c8ce, dataValue=$V7b824acf, playerID={$V910d9037['v']['original_id']}"; 
 $V9c1ebee8->Execute($Vac5c74b6); } } } } else if (!strcmp($V17f71d96,'events')) { foreach($Vf57346d3 as $V9bbd993d => $V61b837be)
 { foreach($V61b837be as $Vf894427c => $Vf60229f3) { $V61110698 = $V9c1ebee8->qstr($Vf894427c); foreach($Vf60229f3 as $V29a7e964 => $V91812ae6)
 { $V6f8b602a = $V9c1ebee8->qstr($V29a7e964); foreach($V91812ae6 as $V1cd03614 => $V9290beca) { if (!strcmp($V1cd03614,'1D'))
 { foreach($V9290beca as $Vf1a19314 => $V1c6ef5e9) { $V10dad7cb=""; if (preg_match("/^(.*)\\|(.+)/", $Vf1a19314, $Vb74df323))
 { $V10dad7cb=$Vb74df323[1]; $Vf1a19314=$Vb74df323[2]; } $Vf1a19314 = $V9c1ebee8->qstr($Vf1a19314);
$V1c6ef5e9 = $V9c1ebee8->qstr($V1c6ef5e9); $V10dad7cb = $V9c1ebee8->qstr($V10dad7cb); $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}eventdata1d SET playerID={$V910d9037['v']['original_id']},gameID=$this->V7da699e4,round=$V9bbd993d,team=$V61110698,role=$V6f8b602a,eventName=$Vf1a19314,eventValue=$V1c6ef5e9,eventCategory=$V10dad7cb"; 
 $V9c1ebee8->Execute($Vac5c74b6); } } else if (!strcmp($V1cd03614,'2D')) { foreach($V9290beca as $V60962ab1 => $V6b3b7a9f)
 { $Vbc6c5186 = $V9c1ebee8->qstr($V60962ab1); foreach($V6b3b7a9f as $V84ccdc56 => $Vda5a5b5d) { $V4647c709 = $V9c1ebee8->qstr($V84ccdc56);
foreach($Vda5a5b5d as $V863818d8 => $Vcf7bfd32) { if ($GLOBALS['cfg']['parser']['use_original_playerID'])
 { $Vdbead972 = $this->V75125d17[$V863818d8]['v']['original_id']; } else { $Vdbead972 = $V863818d8; 
 } $Vdbead972 = $V9c1ebee8->qstr(substr($Vdbead972,0,99)); foreach($Vcf7bfd32 as $Vd4e58592 => $V2029376b)
 { $V701adf24=""; if (preg_match("/^(.*)\\|(.+)/", $Vd4e58592, $Vb74df323)) { $V701adf24=$Vb74df323[1];
$Vd4e58592=$Vb74df323[2]; } $Vd4e58592 = $V9c1ebee8->qstr($Vd4e58592); $V2029376b = $V9c1ebee8->qstr($V2029376b);
$V701adf24 = $V9c1ebee8->qstr($V701adf24); $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d SET playerID={$V910d9037['v']['original_id']},gameID=$this->V7da699e4,round=$V9bbd993d,team=$V61110698,role=$V6f8b602a,eventName=$Vd4e58592,eventValue=$V2029376b,eventCategory=$V701adf24,player2ID=$Vdbead972,team2=$Vbc6c5186,role2=$V4647c709"; 
 $V9c1ebee8->Execute($Vac5c74b6); } } } } } } } } } } } } $Vd744430a["last update time"]=date('Y-m-d H:i:s');
$Vd744430a["vsp version"]=constant("cVERSION"); foreach ($Vd744430a as $V13c571a8=>$Va2f69a5a) { $Vac5c74b6="INSERT INTO {$GLOBALS['cfg']['db']['table_prefix']}gamedata set gameID=0, name=".$V9c1ebee8->qstr($V13c571a8);
$V9c1ebee8->Execute($Vac5c74b6); $Vac5c74b6=sprintf("UPDATE {$GLOBALS['cfg']['db']['table_prefix']}gamedata SET value=%s where name=%s"
 ,$V9c1ebee8->qstr($Va2f69a5a) ,$V9c1ebee8->qstr($V13c571a8) ); $V9c1ebee8->Execute($Vac5c74b6); }
 print "done\n"; Fa10803e1(); } } function F4ca894df() { print cTITLE; } function F4d7a92f8() {
 print cUSAGE; } function Fb7d30ee1($V341be97d) { $Vad42f669=1; if ($Vad42f669==1) { print "$V341be97d";
} } function F03c2b497($V6e2baaf3) { print "\n$V6e2baaf3\n"; F56fd05e9(); } function Facf3bf61($Vd17549fa)
{ F4d7a92f8(); print "$Vd17549fa\n"; F56fd05e9(); } function F30765b08(&$V5a1af13e,$V73600783) {
 $Vd5efc4b7 = ftp_rawlist($V5a1af13e,$V73600783); $V23227229=Fe6fec173($Vd5efc4b7); $V0ad17471=array();
foreach ($V23227229 as $V8c7dd922) { if($V8c7dd922['type'] == 0) { $V0ad17471[(count($V0ad17471))] = $V8c7dd922; 
 } } return $V0ad17471; } function Fd2c39001($V6c62e2ab) { $Va4b43381=parse_url($V6c62e2ab); echo "Attempting to connect to FTP server {$Va4b43381['host']}:{$Va4b43381['port']}...\n"; 
 if (isset($Va4b43381['user']) || isset($Va4b43381['pass'])) { echo " - Specify the ftp username and password in the config and not in the VSP command line (Security reasons?)\n";
F56fd05e9(); } Fa10803e1(); if (!$V5a1af13e = ftp_connect($Va4b43381['host'],$Va4b43381['port'],30))
 { echo " - Error: Failed to connect to ftp server. Verify FTP hostname/port.\n"; echo " Also, your php host may not have ftp access via php enabled or may\n";
echo " have blocked the php process from connecting to an external server\n"; F56fd05e9(); } if (!ftp_login($V5a1af13e, $GLOBALS['cfg']['ftp']['username'], $GLOBALS['cfg']['ftp']['password']))
 { echo " - Error: Failed to login to ftp server. Verify FTP username/password in config\n"; F56fd05e9();
} echo " - Connection/Login successful.\n"; if (isset($GLOBALS['cfg']['ftp']['pasv']) && $GLOBALS['cfg']['ftp']['pasv'])
 { if (ftp_pasv($V5a1af13e, true)) echo " - FTP passive mode enabled\n"; else echo " - failed to enable FTP passive mode\n";
} else { echo " - not using FTP passive mode (disabled in config)\n"; } if (!F331c0468($GLOBALS['cfg']['ftp']['logs_path']))
 { echo " - Error: Failed to create local directory \"".$GLOBALS['cfg']['ftp']['logs_path']."\" for FTP log download.\n";
echo " Check pathname/permissions.\n"; F56fd05e9(); } if (preg_match("/[\\/\\\\]$/",$Va4b43381['path']))
 { echo " - Preparing to download all files from remote directory \"".$Va4b43381['path']."\"\n"; $V0ad17471=F30765b08($V5a1af13e,$Va4b43381['path']);
preg_match("/([^\\/\\\\]+[\\/\\\\])$/",$Va4b43381['path'],$Vb74df323); $V24faf2f1=$Va4b43381['path'];
$Ved05e3b3=F9578dd1f($GLOBALS['cfg']['ftp']['logs_path'].$Vb74df323[1]); F331c0468($Ved05e3b3); $Vc0d41efd=$Ved05e3b3;
} else { echo " - Preparing to download the remote file \"".$Va4b43381['path']."\"\n"; preg_match("/([^\\/\\\\]+)$/",$Va4b43381['path'],$Vb74df323);
$V0ad17471[0]['name']=$Vb74df323[1]; $V0ad17471[0]['size']=ftp_size($V5a1af13e,$Va4b43381['path']);
 $V24faf2f1=substr($Va4b43381['path'],0,strlen($Va4b43381['path'])-strlen($V0ad17471[0]['name'])); $Ved05e3b3=F9578dd1f($GLOBALS['cfg']['ftp']['logs_path']);
$Vc0d41efd=$Ved05e3b3.$V0ad17471[0]['name']; } if (!ctype_digit(''.$V0ad17471[0]['size']) || $V0ad17471[0]['size']<0)
 { echo " - Error: cannot find Remote file \"".$V0ad17471[0]['name']."\" at ftp://{$Va4b43381['host']}:{$Va4b43381['port']}".$V24faf2f1."\n";
F56fd05e9(); } foreach ($V0ad17471 as $V8c7dd922) { $Vb026bf91=$Ved05e3b3.$V8c7dd922['name']; $V85b21706 = file_exists($Vb026bf91) ? filesize($Vb026bf91) - 1 : 0;
$Vef5e6c91=$V24faf2f1.$V8c7dd922['name']; $V011089a7 = $V8c7dd922['size']; echo " - Attempting to download \"$Vef5e6c91\" from FTP server to \"$Vb026bf91\"...\n";
Fa10803e1(); if (isset($GLOBALS['cfg']['ftp']['overwrite']) && $GLOBALS['cfg']['ftp']['overwrite'])
 { echo " - overwrite mode\n"; if(!ftp_get($V5a1af13e, $Vb026bf91, $Vef5e6c91, FTP_BINARY)) { echo " Error: Failed to get ftp log from \"$Vef5e6c91\" to \"$Vb026bf91\".\n";
if (!$GLOBALS['cfg']['ftp']['pasv']) echo " Try enabling FTP passive mode in config.\n"; echo " Try making the ftplogs/ and logdata/ folder writable by all (chmod 777).\n";
F56fd05e9(); } echo " Downloaded remote file successfully\n"; Fa10803e1(); } else { if($V011089a7 == $V85b21706 + 1) 
 { echo " Remote file is the same size as Local file. Skipped Download.\n"; } else if($V011089a7 > $V85b21706 + 1) 
 { if(!ftp_get($V5a1af13e, $Vb026bf91, $Vef5e6c91, FTP_BINARY, $V85b21706)) { echo " Error: Failed to get ftp log from \"$Vef5e6c91\" to \"$Vb026bf91\".\n";
if (!$GLOBALS['cfg']['ftp']['pasv']) echo " Try enabling FTP passive mode in config.\n"; echo " Try making the ftplogs/ and logdata/ folder writable by all (chmod 777).\n";
F56fd05e9(); } echo " Downloaded/Resumed remote file successfully\n"; } else { echo " Remote file is smaller than Local file. Skipped Download.\n";
} Fa10803e1(); } } echo $Vc0d41efd."\n"; return $Vc0d41efd; } function F92261ca6() { global $V51d3ee44;
if (cIS_SHELL) { if (!isset($_SERVER['argc'])) { echo "Error: args not registered.\n"; echo " register_argc_argv may need to be set to On in shell mode\n";
echo " Please edit your php.ini and set variable register_argc_argv to On\n"; F56fd05e9(); } $V51d3ee44['argv']=$_SERVER['argv']; 
 $V51d3ee44['argc']=$_SERVER['argc']; } else { $V4f96c5a0=$_POST['V70e78261']; if (get_magic_quotes_gpc())
 $V4f96c5a0=stripslashes($V4f96c5a0); $V51d3ee44=F126ba7b1("vsp.php ".$V4f96c5a0); } global $V0f14082c; 
 $V0f14082c['parser-options']=""; $V0f14082c['prompt']=1; if ($V51d3ee44['argc']>1) { for ($V865c0c0b=1;$V865c0c0b<$V51d3ee44['argc']-1;$V865c0c0b++)
 { if (strcmp($V51d3ee44['argv'][$V865c0c0b],"-a")==0) { $V865c0c0b++; $V0f14082c['action']=$V51d3ee44['argv'][$V865c0c0b];
if ($V0f14082c['action']!='clear_db') Facf3bf61("error: invalid action"); break; } if (strcmp($V51d3ee44['argv'][$V865c0c0b],"-n")==0)
 { $V0f14082c['prompt']=0; continue; } if ($V865c0c0b+1 > $V51d3ee44['argc']-2) { Facf3bf61("error: no value specified for option ".$V51d3ee44['argv'][$V865c0c0b]);
} if (strcmp($V51d3ee44['argv'][$V865c0c0b],"-p")==0) { $V865c0c0b++; for ($V363b122c=$V865c0c0b;$V363b122c<$V51d3ee44['argc']-1;$V363b122c=$V363b122c+2)
 { $V0f14082c['parser-options'][$V51d3ee44['argv'][$V363b122c]]=$V51d3ee44['argv'][$V363b122c+1]; }
break; } else if (strcmp($V51d3ee44['argv'][$V865c0c0b],"-c")==0) { $V865c0c0b++; $V0f14082c['config']=$V51d3ee44['argv'][$V865c0c0b];
} else if (strcmp($V51d3ee44['argv'][$V865c0c0b],"-l")==0) { $V865c0c0b++; $V0f14082c['log-gamecode']=$V51d3ee44['argv'][$V865c0c0b];
$V0f14082c['log-gametype']=''; if (preg_match("/(.*)-(.*)/",$V0f14082c['log-gamecode'],$Vb74df323))
 { $V0f14082c['log-gamecode']=$Vb74df323[1]; $V0f14082c['log-gametype']=$Vb74df323[2]; $V0f14082c['parser-options']['gametype']=$V0f14082c['log-gametype'];
} } else { Facf3bf61("error: invalid option ".$V51d3ee44['argv'][$V865c0c0b]); } } } else { Facf3bf61("error: logfile not specified");
} $V0f14082c['logfile']=$V51d3ee44['argv'][$V51d3ee44['argc']-1]; if (!isset($V0f14082c['action']))
 { if (!isset($V0f14082c['logfile'])) { Facf3bf61("error: logFile not specified"); } if (!isset($V0f14082c['log-gamecode']))
 { Facf3bf61("error: logType not specified"); } } $V55d5b418="pub/configs/"; if (!isset($V0f14082c['config']) || preg_match("/\\.\\./",$V0f14082c['config']) || !is_file($V55d5b418.$V0f14082c['config']))
 { $V0f14082c['config']=$V55d5b418."cfg-default.php"; } else { $V0f14082c['config']=$V55d5b418.$V0f14082c['config']; 
 } echo "max_execution_time is ".ini_get("max_execution_time")."\n\n"; echo "[command-line options]: ";
print_r($V0f14082c); if (isset($V0f14082c['parser-options']['savestate']) && $V0f14082c['parser-options']['savestate'])
 { $Vb3521e13="writetest_".md5(uniqid(rand(), true)); $V2880b5ba = fopen('./logdata/'.$Vb3521e13,"wb");
if (!$V2880b5ba || !fwrite($V2880b5ba,"* WRITE TEST *\n")) { echo "Error: savestate 1 processing requires logdata/ directory to be writable.\n";
echo " Enable write permissions for logdata/ directory (chmod 777)\n"; F56fd05e9(); } fclose($V2880b5ba);
unlink("logdata/$Vb3521e13"); } } function F68c076b3() { global $V0f14082c; global $V51d3ee44; require_once($V0f14082c['config']);
if (preg_match("/^ftp:\\/\\//i",$V0f14082c['logfile'])) $V0f14082c['logfile']=Fd2c39001($V0f14082c['logfile']);
 $V0f14082c['parser-options']['trackID']=$GLOBALS['cfg']['parser']['trackID']; if (isset($GLOBALS['cfg']['db']['adodb_path']))
 $GLOBALS['cfg']['db']['adodb_path']=F9578dd1f($GLOBALS['cfg']['db']['adodb_path']); else $GLOBALS['cfg']['db']['adodb_path']=F9578dd1f(Ce5c65ec5).'pub/lib/adodb/';
require_once("{$GLOBALS['cfg']['db']['adodb_path']}".'adodb.inc.php'); include_once("{$GLOBALS['cfg']['db']['adodb_path']}".'tohtml.inc.php');
require_once("sql/{$GLOBALS['cfg']['db']['adodb_driver']}.inc.php"); include_once("pub/include/playerBanList-{$GLOBALS['cfg']['player_ban_list']}.inc.php");
foreach ($GLOBALS['player_ban_list'] as $V7fa3b767 => $V36190f8a) { $GLOBALS['player_ban_list'][$V7fa3b767]="/^".preg_quote($V36190f8a)."$/";
} $GLOBALS['V9c1ebee8'] = &ADONewConnection($GLOBALS['cfg']['db']['adodb_driver']); global $V9c1ebee8; 
 if(!$V9c1ebee8->Connect($GLOBALS['cfg']['db']['hostname'], $GLOBALS['cfg']['db']['username'], $GLOBALS['cfg']['db']['password'], $GLOBALS['cfg']['db']['dbname']))
 { echo "Attempting to create/connect to database {$GLOBALS['cfg']['db']['dbname']}\n"; $GLOBALS['V9c1ebee8'] = null;
$GLOBALS['V9c1ebee8'] = &ADONewConnection($GLOBALS['cfg']['db']['adodb_driver']); global $V9c1ebee8; 
 $V9c1ebee8->Connect($GLOBALS['cfg']['db']['hostname'], $GLOBALS['cfg']['db']['username'], $GLOBALS['cfg']['db']['password']); 
 $V9c1ebee8->Execute($sql_create[0]); if(!$V9c1ebee8->Connect($GLOBALS['cfg']['db']['hostname'], $GLOBALS['cfg']['db']['username'], $GLOBALS['cfg']['db']['password'], $GLOBALS['cfg']['db']['dbname']))
 { echo " - failed to create/connect to database {$GLOBALS['cfg']['db']['dbname']}\n"; F56fd05e9();
} echo " - database created\n"; } if (isset($V0f14082c['action']) && $V0f14082c['action']=="clear_db")
 { if (cIS_SHELL && $V0f14082c['prompt']) { echo "Are you sure you want to clear the database {$GLOBALS['cfg']['db']['dbname']} @ {$GLOBALS['cfg']['db']['hostname']}? (y/n)\n";
Fa10803e1(); $Vd0cf705f=Fd63c38c9(); } else { $Vd0cf705f='y'; } if ($Vd0cf705f=='y' || $Vd0cf705f=='Y')
 { foreach($sql_destroy as $V7fa3b767 => $Vac5c74b6) { $V9c1ebee8->Execute($Vac5c74b6); } print "{$GLOBALS['cfg']['db']['table_prefix']}* tables in {$GLOBALS['cfg']['db']['dbname']} @ {$GLOBALS['cfg']['db']['hostname']} has been cleared\n";
} Fa3e3aec1(); } foreach($sql_create as $V7fa3b767 => $Vac5c74b6) { if ($V7fa3b767==0) continue;
$V9c1ebee8->Execute($Vac5c74b6); } $V9c1ebee8->SetFetchMode(ADODB_FETCH_NUM); if (!is_dir("pub/games/{$GLOBALS['cfg']['game']['name']}"))
 { echo "Error: The variable \$cfg['game']['name'] is not set properly in config file.\n"; echo " Edit your config file ({$V0f14082c['config']})\n";
echo " Read the comments beside that variable and set that variable properly.\n"; F56fd05e9(); } if (!file_exists("vsp-{$V0f14082c['log-gamecode']}.php"))
 Facf3bf61("error: unrecognized logType"); require_once("vsp-{$V0f14082c['log-gamecode']}.php"); include_once("pub/games/{$GLOBALS['cfg']['game']['name']}/skillsets/{$GLOBALS['cfg']['skillset']}/{$GLOBALS['cfg']['skillset']}-skill.php");
if (!isset($GLOBALS['skillset'])) { echo "Skill Definitions not found.\n"; echo " "."pub/games/{$GLOBALS['cfg']['game']['name']}/skillsets/{$GLOBALS['cfg']['skillset']}/{$GLOBALS['cfg']['skillset']}-skill.php"."\n";
} $V21d8a920 = new F622a322a(); $Vae2aeb93 = new F02ac4643(); $V8db265ff=strtoupper($V0f14082c['log-gamecode']);
eval("\$V3643b863 = new VSPParser$V8db265ff(\$V0f14082c['parser-options'],\$V21d8a920,\$Vae2aeb93);"); 
 $V3643b863->F1417ca90($V0f14082c['logfile']); $V21d8a920->F215f9169(); } function F181dcd21() {
 require_once("./password.inc.php"); if (strlen($vsp['password'])<6) { echo "<HTML><BODY><PRE>Web Access to vsp.php is currently disabled.\nIf you want to enable web access to vsp.php,\nlook in password.inc.php under your vsp folder using a text editor(notepad).\nRead the ReadME.txt file for additional information.";
F56fd05e9(); } if (!isset($_POST['password'])) { ?> <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
 <HTML> <HEAD> <TITLE>vsp stats processor</TITLE> </HEAD> <BODY> <center> <PRE> <?F4ca894df();?>
 </PRE> <form action="vsp.php?mode=web" method="post"> <TABLE BORDER="0" CELLSPACING="5" CELLPADDING="0">
 <TR> <TD>&nbsp;</TD> <TD>[options] [-p parserOptions] [logFilename]</TD> </TR> <TR> <TD VALIGN="TOP">php vsp.php</TD>
 <TD><input size="50" type="text" name="V70e78261" /><BR>example: -l q3a-osp -p savestate 1 "games.log"</TD>
 </TR> </TABLE> <BR><BR> password = <input size=10 type=password name="password" /><BR><BR><input type="submit" value="Submit ( Process Stats )" />
 <BR><BR> </form> <PRE> <?F4d7a92f8();?> </PRE> </center> </BODY></HTML> <? exit(); } $V42c71341=$_POST['password'];
if (get_magic_quotes_gpc()) $V42c71341=stripslashes($V42c71341); if (md5($V42c71341) != md5($vsp['password']))
 { echo "<HTML><BODY><PRE>Invalid password.\nFor the correct password, Look in password.inc.php under your vsp folder using a text editor(notepad).";
F56fd05e9(); } } function F5974bf41() { Fa10803e1(); $GLOBALS['Vc4d98dbd']=gettimeofday(); set_time_limit(0); 
 define("Ce5c65ec5",dirname(realpath(__FILE__))); if ((isset($_GET['mode']) && $_GET['mode']=='web') || isset($_SERVER['QUERY_STRING']) || isset($_SERVER['HTTP_HOST']) || isset($_SERVER['SERVER_PROTOCOL']) || isset($_SERVER['SERVER_SOFTWARE']) || isset($_SERVER['SERVER_NAME']))
 define("cIS_SHELL",0); else define("cIS_SHELL",1); define ("cBIG_STRING_LENGTH","1024"); if (cIS_SHELL)
 { ini_set("html_errors","0"); chdir(Ce5c65ec5); } else { ini_set("html_errors","1"); F181dcd21();
echo "<HTML><BODY><PRE>"; } F4ca894df(); } function F56fd05e9() { if (!cIS_SHELL) echo "</PRE></BODY></HTML>";
exit(); } function Fa3e3aec1() { F4ca894df(); $Vb1f08b98=F3a57ff01($GLOBALS['Vc4d98dbd']); $Vcd0f6503=floor($Vb1f08b98/60);
$V89cef217=$Vb1f08b98%60; echo "processed in {$Vcd0f6503}m {$V89cef217}s ({$Vb1f08b98}s)\n"; if (!cIS_SHELL)
 echo "</PRE></BODY></HTML>"; exit(); } require_once('vutil.php'); F5974bf41(); F92261ca6(); F68c076b3();
Fa3e3aec1(); ?>