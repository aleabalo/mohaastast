<? /* vsp stats processor, copyright 2004-2005, myrddin8 AT gmail DOT com (a924cb279be8cb6089387d402288c9f2) */
class VSPParserMOH { var $V2e9590a3; var $Va10baeb6; var $V1c7b7557; var $Vdba7d3a2; var $V8ba4afff;
var $Va509f5c2; var $Vbbf5edcf; var $V93da65a9; var $V21d8a920; var $Vae2aeb93; var $Va2bbabfe; var $V6d2b5d2c;
 var $V42dfa3a4; var $Vc3ecd549; var $V9693e947; var $Vdafa753c; var $V50dffd37; var $Vd6d33a32;
var $logdata; var $Va733fe6b; var $Vb3b1075a; function VSPParserMOH($Ve0d85fdc,&$V4f00ff2f,&$V495c39bf)
 { $this->Vbbf5edcf=array( "/^clientCommand: (.+) : .* : userinfo .*\\\\name\\\\([^\\\]*)/", ); 
 $this->def_chat=array( "^CHAT: *#PLAYER#: #CHAT#$" ); $this->Vdba7d3a2=array( "/^Server: /" );
$this->V1c7b7557=array( "/^------ Server Initialization ------/" ); $this->Va10baeb6=array( "#PLAYER# has entered the battle"
 ); $this->V8ba4afff=array( "/^clientCommand: (.*) : .* : join_team (.*)/" ); $this->Va509f5c2=array( 
 ); $this->V2e9590a3=array( "/^(.*) was clubbed by (.*)$/" => 'CLUB', "/^(.*) was bashed by (.*)$/" => 'CLUB',
 "/^(.*) was gunned down by (.*?)( in the (.*))?$/" => 'PISTOL', "/^(.*) was sniped by (.*?)( in the (.*))?$/" => 'SNIPER',
 "/^(.*) was perforated by (.*?)'s SMG( in the (.*))?$/" => 'SMG', "/^(.*) was machine-gunned by (.*?)( in the (.*))?$/" => 'MG',
 "/^(.*) took (.*)'s rocket in the face$/" => 'ROCKET', "/^(.*) took (.*)'s rocket right in the kisser$/" => 'ROCKET',
 "/^(.*) was blown away by (.*)$/" => 'ROCKET', "/^((.*)) blew himself up$/" => 'ROCKET', "/^(.*) was hunted down by (.*)$/" => 'SHOTGUN',
 "/^(.*) was pumped full of buckshot by (.*)$/" => 'SHOTGUN', "/^(.*) was rifled by (.*?)( in the (.*))?$/" => 'RIFLE',
 "/^(.*) is picking (.*)'s shrapnel out of his teeth$/" => 'GRENADE', "/^(.*) tripped on (.*)'s grenade$/" => 'GRENADE',
 "/^((.*)) tripped on his own grenade$/" => 'GRENADE', "/^((.*)) played catch with himself$/" => 'GRENADE',
 "/^((.*)) cratered$/" => 'FALLING', "/^((.*)) took himself out of commision$/" => 'SUICIDE', "/^((.*)) blew up$/" => 'MINE',
 "/^(.*) was shot by (.*)$/" => 'RIFLE', "/^((.*)) died$/" => 'EXPLODE', "/^(.*) stepped on (.*)'s landmine$/" => 'MINE',
 ); define("C7e731e80",1024); $this->Fcda1c5ae($Ve0d85fdc); $this->V21d8a920= $V4f00ff2f; $this->Vae2aeb93= $V495c39bf;
 $this->V6d2b5d2c= array(); $this->V42dfa3a4= array(); $this->Va2bbabfe= array(); $this->logdata=array();
 $this->Vdafa753c= false; $this->V42dfa3a4['hit_location']['none']="locnone"; $this->V42dfa3a4['hit_location']['lower torso']="locstomach";
$this->V42dfa3a4['hit_location']['upper torso']="locchest"; $this->V42dfa3a4['hit_location']['middle torso']="locstomach";
$this->V42dfa3a4['hit_location']['upper right arm']="locarm-right(upper)"; $this->V42dfa3a4['hit_location']['upper left arm']="locarm-left(upper)";
$this->V42dfa3a4['hit_location']['lower right arm']="locarm-right(lower)"; $this->V42dfa3a4['hit_location']['lower left arm']="locarm-left(lower)";
$this->V42dfa3a4['hit_location']['right hand']="locarm-right(hand)"; $this->V42dfa3a4['hit_location']['left hand']="locarm-left(hand)";
$this->V42dfa3a4['hit_location']['upper right leg']="locleg-right(upper)"; $this->V42dfa3a4['hit_location']['upper left leg']="locleg-left(upper)";
$this->V42dfa3a4['hit_location']['lower right leg']="locleg-right(lower)"; $this->V42dfa3a4['hit_location']['lower left leg']="locleg-left(lower)";
$this->V42dfa3a4['hit_location']['right foot']="locleg-right(foot)"; $this->V42dfa3a4['hit_location']['left foot']="locleg-left(foot)";
$this->V42dfa3a4['hit_location']['head']="lochead"; $this->V42dfa3a4['hit_location']['neck']="locneck";
$this->V42dfa3a4['hit_location']['pelvis']="locstomach"; } function Fcda1c5ae($Ve0d85fdc) { $this->V93da65a9['savestate']=0;
$this->V93da65a9['gametype']=""; $this->V93da65a9['backuppath']=""; $this->V93da65a9['trackID']="playerName"; 
 if (is_array($Ve0d85fdc)) { foreach($Ve0d85fdc as $Ve7cb9038 => $Va36fd2a1) { $this->V93da65a9[$Ve7cb9038] = $Va36fd2a1;
} } if ($this->V93da65a9['backuppath']) { $this->V93da65a9['backuppath']=F9578dd1f($this->V93da65a9['backuppath']);
} print_r($this->V93da65a9); } function F713be45c() { unset($this->Va2bbabfe); $this->Va2bbabfe= array();
unset($this->V6d2b5d2c); $this->V6d2b5d2c= array(); $this->V9693e947['month']=12; $this->V9693e947['date']=28;
$this->V9693e947['year']=1971; $this->V9693e947['hour']=23; $this->V9693e947['min']=59; $this->V9693e947['sec']=59;
} function F5c0b129c() { $this->logdata["last_shutdown_end_position"]=ftell($this->V50dffd37); 
 $V9a52fe40=fseek ($this->V50dffd37, -C7e731e80, SEEK_CUR); if ($V9a52fe40==0) { $this->logdata['last_shutdown_hash']=md5(fread($this->V50dffd37, C7e731e80));
} else { $V284073b9=ftell($this->V50dffd37); fseek ($this->V50dffd37, 0); $this->logdata['last_shutdown_hash']=md5(fread($this->V50dffd37, $V284073b9)); 
 } $V3b2eb2c1 = fopen('./logdata/savestate_'.Fff47f8ac($this->Vd6d33a32).'.inc.php',"wb"); fwrite($V3b2eb2c1,"<? \n");
fwrite($V3b2eb2c1,"\$this->logdata['last_shutdown_hash']='{$this->logdata['last_shutdown_hash']}';\n");
fwrite($V3b2eb2c1,"\$this->logdata['last_shutdown_end_position']={$this->logdata['last_shutdown_end_position']};\n");
fwrite($V3b2eb2c1,"?>"); fclose($V3b2eb2c1); } function Fb96636b2() { echo "Verifying savestate\n";
$V8774de0e=fopen($this->Vd6d33a32,"rb"); $V2843c763=fseek($V8774de0e,$this->logdata['last_shutdown_end_position']);
 if ($V2843c763==0) { $V9a52fe40=fseek ($V8774de0e, -C7e731e80, SEEK_CUR); if ($V9a52fe40==0) { 
 $Vb9cc7f4b=fread($V8774de0e, C7e731e80); } else { $V284073b9=ftell($V8774de0e); fseek ($V8774de0e, 0);
$Vb9cc7f4b=fread($V8774de0e, $V284073b9); } if (strcmp(md5($Vb9cc7f4b),$this->logdata['last_shutdown_hash'])==0)
 { echo " - Hash matched, resuming parsing from previous saved location in log file\n"; fseek($this->V50dffd37,$this->logdata['last_shutdown_end_position']);
} else { echo " - Hash did not match, assuming new log file\n"; fseek($this->V50dffd37,0); } } else
 { echo " - Seek to prior location failed, assuming new log file\n"; fseek($this->V50dffd37,0); }
 fclose($V8774de0e); } function F1417ca90($Vdbe56eaf) { $this->Vd6d33a32=realpath($Vdbe56eaf); 
 if (!file_exists($this->Vd6d33a32)) { F03c2b497("error: log file \"{$Vdbe56eaf}\" does not exist");
} $this->F713be45c(); if ($this->V93da65a9['savestate']==1) { echo "savestate 1 processing enabled\n";
@include_once('./logdata/savestate_'.Fff47f8ac($this->Vd6d33a32).'.inc.php'); $this->V50dffd37= fopen($this->Vd6d33a32,"rb");
 if (!empty($this->logdata)) { $this->Fb96636b2($this->Vd6d33a32); } } else { $this->V50dffd37= fopen($this->Vd6d33a32,"rb");
} if (!$this->V50dffd37) { Fb7d30ee1("error: {this->logfile} could not be opened"); return; } $this->V42dfa3a4['logfile_size']=filesize($this->Vd6d33a32); 
 while(!feof($this->V50dffd37)) { $this->Va733fe6b=ftell($this->V50dffd37); $V6438c669 = fgets($this->V50dffd37, cBIG_STRING_LENGTH); 
 $V6438c669=rtrim($V6438c669,"\r\n"); $this->F20dd322a($V6438c669); } fclose($this->V50dffd37); 
 } function F7212cda9($V341be97d) { return $V341be97d; } function Fa3f5d48d($V341be97d) { return $V341be97d;
} function Ffa84691e() { if (preg_match("/^(\d+):(\d+)/", $this->Vc3ecd549, $Vb74df323)) { $V110decc3['min']=$Vb74df323[1];
$V110decc3['sec']=$Vb74df323[2]; return date ("Y-m-d H:i:s", adodb_mktime ($this->V9693e947['hour'],$this->V9693e947['min']+$V110decc3['min'],$this->V9693e947['sec']+$V110decc3['sec'],$this->V9693e947['month'],$this->V9693e947['date'],$this->V9693e947['year']));
} else if (preg_match("/^(\d+).(\d+)/", $this->Vc3ecd549, $Vb74df323)) { $V110decc3['min']=0; $V110decc3['sec']=$Vb74df323[1]; 
 return date ("Y-m-d H:i:s", adodb_mktime ($this->V9693e947['hour'],$this->V9693e947['min']+$V110decc3['min'],$this->V9693e947['sec']+$V110decc3['sec'],$this->V9693e947['month'],$this->V9693e947['date'],$this->V9693e947['year']));
} else if (preg_match("/^(\d+):(\d+):(\d+)/", $this->Vc3ecd549, $Vb74df323)) { $V110decc3['hour']=$Vb74df323[1];
$V110decc3['min'] =$Vb74df323[2]; $V110decc3['sec'] =$Vb74df323[3]; return date ("Y-m-d H:i:s", adodb_mktime ($V110decc3['hour'],$V110decc3['min'],$V110decc3['sec'],$this->V9693e947['month'],$this->V9693e947['date'],$this->V9693e947['year']));
} } function F7939839b(&$V6438c669) { foreach ($this->Vdba7d3a2 as $Vd405fc11) { if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { if ($this->Vdafa753c) { Fb7d30ee1("corrupt game (no Shutdown after Init), ignored\n"); Fb7d30ee1("{$this->Vc3ecd549} $V6438c669\n");
$this->Vae2aeb93->Fc3b570a7(); $this->Vae2aeb93->F242ca9da(); } $this->Vdafa753c= true; $this->Vb3b1075a=$this->Va733fe6b;
$this->F713be45c(); $this->Vae2aeb93->Fd45b6912(); $this->Vae2aeb93->F6d04475a("_v_time_start",date('Y-m-d H:i:s')); 
 if (preg_match("/([^\/\\\\]*)$/",$V6438c669,$Va9ddcf51)) $this->Vae2aeb93->F6d04475a("_v_map",$Va9ddcf51[1]);
else $this->Vae2aeb93->F6d04475a("_v_map","?"); $this->Vae2aeb93->F6d04475a("_v_game",'moh'); if (isset($this->V42dfa3a4['mod']))
 $this->Vae2aeb93->F6d04475a("_v_mod",$this->V42dfa3a4['mod']); else $this->Vae2aeb93->F6d04475a("_v_mod","?"); 
 $this->Vae2aeb93->F6d04475a("_v_game_type","?"); return true; } } return false; } function Fc5aace53(&$V6438c669)
 { foreach ($this->V1c7b7557 as $Vd405fc11) { if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { if ($this->V93da65a9['savestate']==1) { $this->F5c0b129c(); } $this->Vae2aeb93->Fc3b570a7();
$this->V21d8a920->F43781db5($this->Vae2aeb93->F26dd5333(),$this->Vae2aeb93->F068fac4f()); $this->Vae2aeb93->F242ca9da();
$this->Vdafa753c= false; return true; } } return false; } function F4b57e26a($Vc165b9b5) { foreach ($this->Va2bbabfe as $Vd915074e => $V163b0d74)
 { if (strstr($Vd915074e,$Vc165b9b5)) return $Vd915074e; } return $Vc165b9b5; } function Fa00ebe94(&$V6438c669)
 { foreach ($this->Va10baeb6 as $V8792851f) { $Vd405fc11 = "/".($V8792851f)."/"; $Vd405fc11 = str_replace("#PLAYER#","(.*?)",$Vd405fc11); 
 if (preg_match($Vd405fc11, $V6438c669, $Vb74df323)) { $V912af0df=$Vb74df323[1]; $this->Va2bbabfe[$V912af0df]['name']=$this->Fa3f5d48d($V912af0df); 
 $this->Vae2aeb93->F6aae4907($V912af0df,$this->Va2bbabfe[$V912af0df]['name']); return true; } }
 return false; } function F390143ba(&$V6438c669) { foreach ($this->V8ba4afff as $Vd405fc11) {
 if (preg_match($Vd405fc11, $V6438c669, $Vb74df323)) { $V912af0df=$Vb74df323[1]; $Vf894427c=$Vb74df323[2];
} if (strlen($V912af0df)>0 && strlen($Vf894427c)>0) { $this->Vae2aeb93->F555c9055($V912af0df,$Vf894427c);
return true; } } return false; } function F58a1721d(&$V6438c669) { foreach ($this->V2e9590a3 as $Vd405fc11 => $V80cfa351)
 { if (preg_match($Vd405fc11, $V6438c669, $Vb74df323)) { $V96d4976b=$Vb74df323[1]; $Vb36d3314=$Vb74df323[2];
$V8283506e=$Vb74df323[4]; if (strlen($V96d4976b)>=29) $V96d4976b=$this->F4b57e26a($V96d4976b); if (strlen($Vb36d3314)>=29) 
 $Vb36d3314=$this->F4b57e26a($Vb36d3314); if (strlen($V96d4976b)>0 && strlen($Vb36d3314)>0) { $this->Vae2aeb93->Fd65f3244($Vb36d3314,$V96d4976b,$V80cfa351);
} if (strlen($V8283506e)>0) { $this->Vae2aeb93->F4135e567($Vb36d3314, $Vb36d3314, "accuracy|{$V80cfa351}_hits",1);
$this->Vae2aeb93->F4135e567($Vb36d3314, $Vb36d3314, "accuracy|{$V80cfa351}_shots",1); $this->Vae2aeb93->F4135e567($Vb36d3314, $Vb36d3314, "accuracy|{$V80cfa351}_".$this->V42dfa3a4['hit_location'][$V8283506e],1);
 } return true; } } return false; } function F53e6621b(&$V6438c669) { foreach ($this->Va509f5c2 as $V8792851f => $V6b0755dd)
 { $Vd405fc11 = "/".($V8792851f)."/"; $Vd405fc11 = str_replace("#PLAYER#","(.*?)",$Vd405fc11); if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { $this->Vae2aeb93->F72d01d3f($Vb74df323[1],$V6b0755dd,1); return true; } } return false; } function F92efcba9(&$V6438c669)
 { foreach ($this->Vbbf5edcf as $Vd405fc11) { if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { $V912af0df=$Vb74df323[1]; $Vb068931c=$Vb74df323[2]; } if (strlen($V912af0df)>0 && strlen($Vb068931c)>0 && $V912af0df!=$Vb068931c)
 { $V1963b948=$this->Fa3f5d48d($Vb068931c); $this->Vae2aeb93->Fec5ab55c("sto",$V912af0df,"alias",$V1963b948);
$this->Vae2aeb93->Fddcbd60f($V912af0df,$V1963b948); $this->Vae2aeb93->F95791962($V912af0df,$Vb068931c); 
 return true; } } return false; } function F7888de3f(&$V6438c669) { foreach ($this->def_chat as $V8792851f)
 { $V912af0df=""; $Vaa8af3eb=""; $Vd405fc11 = "/".($V8792851f)."/"; $Vd405fc11 = str_replace("#PLAYER#","(.*?)",$Vd405fc11);
$Vd405fc11 = str_replace("#CHAT#",".+",$Vd405fc11); if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { $V912af0df=$Vb74df323[1]; } $Vd405fc11 = "/".($V8792851f)."/"; $Vd405fc11 = str_replace("#PLAYER#",".*",$Vd405fc11);
$Vd405fc11 = str_replace("#CHAT#","(.*?)",$Vd405fc11); if (preg_match($Vd405fc11, $V6438c669, $Vb74df323))
 { $Vaa8af3eb=$Vb74df323[1]; } if (strlen($V912af0df)>0 && strlen($Vaa8af3eb)>0) { $this->Vae2aeb93->F8405e6ea($V912af0df,$this->F7212cda9($Vaa8af3eb));
return true; } } return false; } function F26a565c8(&$V6438c669) { return false; } function F20dd322a(&$V6438c669)
 { if ($this->F7939839b($V6438c669)) { echo sprintf("(%05.2f%%) ",100.0 * ftell($this->V50dffd37)/$this->V42dfa3a4['logfile_size']);
} else if ($this->Vdafa753c) { if ($this->F26a565c8($V6438c669)) { } else if ($this->Fa00ebe94($V6438c669))
 { } else if ($this->F58a1721d($V6438c669)) { } else if ($this->F53e6621b($V6438c669)) { } else if ($this->F7888de3f($V6438c669)) 
 { } else if ($this->F92efcba9($V6438c669)) { } else if ($this->Fc5aace53($V6438c669)) { } else
 { } } else { } } } ?>