<? /* vsp stats processor, copyright 2004-2005, myrddin8 AT gmail DOT com (a924cb279be8cb6089387d402288c9f2) */
include("./vsp-q3a.php"); class VSPParserWET extends VSPParserQ3A { function VSPParserWET($Ve0d85fdc,&$V4f00ff2f,&$V495c39bf)
 { parent::VSPParserQ3A($Ve0d85fdc,$V4f00ff2f,$V495c39bf); $this->V42dfa3a4['weapon_name']['search'] =array(
 "/MOD_/" ,"/_SPLASH/" ,"/AKIMBO_/" ,"/SILENCED_/" ,"/SILENCED/" ); $this->V42dfa3a4['weapon_name']['replace']=array(
 "" ,"" ); $this->V42dfa3a4['weapon_array']=array( 0 => 'KNIFE', 1 => 'LUGER', 2 => 'COLT', 3 => 'MP40', 
 4 => 'THOMPSON', 5 => 'STEN', 6 => 'FG42', 7 => 'PANZERFAUST', 8 => 'FLAMETHROWER', 9 => 'GRENADE',
 10 => 'MORTAR', 11 => 'DYNAMITE', 12 => 'AIRSTRIKE', 13 => 'ARTY', 14 => 'SYRINGE', 15 => 'SMOKECAN',
 16 => 'SATCHEL', 17 => 'GRENADE_LAUNCHER', 18 => 'LANDMINE', 19 => 'MOBILE_MG42', 20 => 'GARAND',
 21 => 'KAR98' ); } function F7939839b(&$V6438c669) { if (parent::F7939839b($V6438c669)) { $this->Vae2aeb93->F6d04475a("_v_game",'wet');
return true; } return false; } function F26a565c8(&$V6438c669) { return false; } function Fc5aace53(&$V6438c669)
 { if (!preg_match("/^ShutdownGame:/", $V6438c669, $Vb74df323)) return false; if (!isset($this->V6d2b5d2c['Exit']))
 { $Vb16ebe0a=''; while(!feof($this->V50dffd37) && !preg_match("/^InitGame: (.*)/", $Vb16ebe0a, $Vb74df323))
 { $V40023427=ftell($this->V50dffd37); $Vb16ebe0a = fgets($this->V50dffd37, cBIG_STRING_LENGTH); 
 $Vb16ebe0a=rtrim($Vb16ebe0a,"\r\n"); $this->F1ef9b71a($Vb16ebe0a); } return true; } else { if ($this->V93da65a9['savestate']==1)
 { $this->F5c0b129c(); } $this->Vae2aeb93->Fc3b570a7(); $this->V21d8a920->F43781db5($this->Vae2aeb93->F26dd5333(),$this->Vae2aeb93->F068fac4f());
$this->Vae2aeb93->F242ca9da(); $this->Vdafa753c= false; return true; } return true; } function Fcfcf8f26(&$V6438c669)
 { if (!preg_match("/^Exit:/", $V6438c669, $Vb74df323)) return false; $this->V6d2b5d2c['Exit']=1; 
 return true; } function Fdd2d6a64($V51cafe1c) { $Va68a76df=array(); $V15467e06=strrev(sprintf("%b",$V51cafe1c));
 $Vfc1178ea=strlen($V15467e06); for($V865c0c0b=0;$V865c0c0b<$Vfc1178ea;$V865c0c0b++) { if ($V15467e06[$V865c0c0b]=='1')
 { $Va68a76df[]=$this->V42dfa3a4['weapon_array'][$V865c0c0b]; } } return $Va68a76df; } function F73171ca8(&$V6438c669)
 { if (!preg_match("/^WeaponStats:/", $V6438c669)) return false; if (preg_match("/^WeaponStats: (\d+) (\d+) (\d+) (.*)/", $V6438c669, $Vb74df323))
 { $V2bfe9d72=$Vb74df323[1]; $Vbd89f3c9=$Vb74df323[4]; $V9fb97ff3=$this->Fdd2d6a64($Vb74df323[3]); 
 $V87058dfa=0; $V0a1c880f=count($V9fb97ff3); while ($V87058dfa<$V0a1c880f && preg_match("/^(\d+) (\d+) (\d+) (\d+) (\d+) (.*)/", $Vbd89f3c9, $Va9ddcf51))
 { $V47239253=$V9fb97ff3[$V87058dfa]; $Vfce79135=$Va9ddcf51[1]; $V9f892c18=$Va9ddcf51[2]; $Vf803abdc=$Va9ddcf51[5]; 
 $this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['id'],"accuracy|{$V47239253}_hits",$Vfce79135);
$this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['id'],"accuracy|{$V47239253}_shots",$V9f892c18);
$this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['id'],"accuracy|{$V47239253}_lochead",$Vf803abdc);
$Vbd89f3c9=$Va9ddcf51[6]; $V87058dfa++; } if (preg_match("/^(\d+) (\d+) (\d+) (\d+) (\d+)/", $Vbd89f3c9, $Va9ddcf51))
 { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"damage given",$Va9ddcf51[1]); $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"damage taken",$Va9ddcf51[2]);
$this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"damage to team",$Va9ddcf51[3]); $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"damage from team",$Va9ddcf51[4]); 
 } } return true; } function Ff90d84c5(&$V6438c669) { if (!preg_match("/^ClientUserinfoChanged: (\d+) (.*)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V4fe74676=$Vb74df323[2]; while (preg_match("/^(.+)\\\(.*)\\\/U", $V4fe74676, $Va9ddcf51) || preg_match("/^(.+)\\\(.*)/", $V4fe74676, $Va9ddcf51))
 { $Vf986617c=$Va9ddcf51[1]; $Vada01463=$Va9ddcf51[2]; $V4fe74676=substr($V4fe74676,strlen($Vf986617c)+strlen($Vada01463)+2);
if (!strcmp($Vf986617c,"n")) { $V1963b948=$this->Fa3f5d48d($Vada01463); if (isset($this->Va2bbabfe[$V2bfe9d72]['id']) && $this->V93da65a9['trackID'] == 'playerName' && strcmp($this->Va2bbabfe[$V2bfe9d72]['id'],$Vada01463)!=0)
 { $this->Vae2aeb93->Fec5ab55c("sto",$this->Va2bbabfe[$V2bfe9d72]['id'],"alias",$V1963b948); $this->Vae2aeb93->Fddcbd60f($this->Va2bbabfe[$V2bfe9d72]['id'],$V1963b948);
$this->Vae2aeb93->F95791962($this->Va2bbabfe[$V2bfe9d72]['id'],$Vada01463); $this->Va2bbabfe[$V2bfe9d72]['id']=$Vada01463;
} else if (isset($this->Va2bbabfe[$V2bfe9d72]['id']) && isset($this->Va2bbabfe[$V2bfe9d72]['name']) && strcmp($this->Va2bbabfe[$V2bfe9d72]['name'],$V1963b948)!=0)
 { $this->Vae2aeb93->Fec5ab55c("sto",$this->Va2bbabfe[$V2bfe9d72]['id'],"alias",$V1963b948); $this->Vae2aeb93->Fddcbd60f($this->Va2bbabfe[$V2bfe9d72]['id'],$V1963b948);
} else if ($this->V93da65a9['trackID'] == 'playerName') { $this->Va2bbabfe[$V2bfe9d72]['id']=$Vada01463;
} else if ($this->V93da65a9['trackID'] == 'guid' && isset($this->Va2bbabfe[$V2bfe9d72]['guid'])) {
 $this->Va2bbabfe[$V2bfe9d72]['id']=$this->Va2bbabfe[$V2bfe9d72]['guid']; } else if (preg_match("/^ip=(.+)/i",$this->V93da65a9['trackID'],$Vd6fd0924) 
 && isset($this->Va2bbabfe[$V2bfe9d72]['ip']) && preg_match($Vd6fd0924[1],$this->Va2bbabfe[$V2bfe9d72]['ip'],$V793914c9))
 { $this->Va2bbabfe[$V2bfe9d72]['id']=$V793914c9[1]; } else { Fb7d30ee1("\$cfg['parser']['trackID'] is invalid, ignored\n");
Fb7d30ee1("Use \$cfg['parser']['trackID'] = 'playerName'; in your config\n"); Fb7d30ee1("{$this->Vc3ecd549} $V6438c669\n");
$this->Vae2aeb93->F242ca9da(); $this->Vdafa753c= false; return true; } $this->Va2bbabfe[$V2bfe9d72]['name']=$V1963b948;
} else if (!strcmp($Vf986617c,"t")) { $this->Va2bbabfe[$V2bfe9d72]['team']=$Vada01463; $this->Vae2aeb93->F555c9055($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['team']);
} else if (!strcmp($Vf986617c,"c")) { if ($this->Va2bbabfe[$V2bfe9d72]['team']!='3') { if (!strcmp($Vada01463,"0"))
 $this->Va2bbabfe[$V2bfe9d72]['role']='soldier'; else if (!strcmp($Vada01463,"1")) $this->Va2bbabfe[$V2bfe9d72]['role']='medic';
else if (!strcmp($Vada01463,"2")) $this->Va2bbabfe[$V2bfe9d72]['role']='engineer'; else if (!strcmp($Vada01463,"3"))
 $this->Va2bbabfe[$V2bfe9d72]['role']='field_ops'; else if (!strcmp($Vada01463,"4")) $this->Va2bbabfe[$V2bfe9d72]['role']='covert_ops'; 
 $this->Vae2aeb93->Fa3f3cadc($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['role']);
if (!isset($this->Va2bbabfe[$V2bfe9d72]['icon']) || strcmp($this->Va2bbabfe[$V2bfe9d72]['icon'],$Vada01463))
 { $this->Va2bbabfe[$V2bfe9d72]['icon']=$this->Va2bbabfe[$V2bfe9d72]['role']; $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"icon|{$this->Va2bbabfe[$V2bfe9d72]['icon']}",1);
} } } } return true; } function Fe460a20b(&$V6438c669) { if (!preg_match("/^ClientDisconnect: (\d+)/", $V6438c669, $Vb74df323))
 return false; $this->V6d2b5d2c['disconnected'][$Vb74df323[1]]=1; return true; } function F12520a4b(&$V6438c669)
 { if (!preg_match("/^ClientConnect: (\d+)/", $V6438c669, $Vb74df323)) return false; $V2bfe9d72=$Vb74df323[1];
$V1dc90e6c=$V6438c669; $Vbb897a7c=$this->Va733fe6b; $V40023427=ftell($this->V50dffd37); $Vb16ebe0a = fgets($this->V50dffd37, cBIG_STRING_LENGTH);
$Vb16ebe0a=rtrim($Vb16ebe0a,"\r\n"); $this->F1ef9b71a($Vb16ebe0a); if (preg_match("/^ClientBegin: (\d+)/", $Vb16ebe0a, $Va9ddcf51))
 { if ($V2bfe9d72==$Va9ddcf51[1]) { return true; } else { $this->Va733fe6b=$Vbb897a7c; fseek($this->V50dffd37,$V40023427); 
 } } else if (preg_match("/^Userinfo: (.*)/", $Vb16ebe0a, $Va9ddcf51)) { $V4fe74676=$Va9ddcf51[1];
while (preg_match("/^\\\(.+)\\\(.*)\\\/U", $V4fe74676, $Vd6fd0924) || preg_match("/^\\\(.+)\\\(.*)/", $V4fe74676, $Vd6fd0924))
 { $Vf986617c=$Vd6fd0924[1]; $Vada01463=$Vd6fd0924[2]; $V4fe74676=substr($V4fe74676,strlen($Vf986617c)+strlen($Vada01463)+2);
if (!strcmp($Vf986617c,"cl_guid")) { $V0b5a0d9e=$Vada01463; } else if (!strcmp($Vf986617c,"ip")) {
 if (preg_match("/^(\d+\\.\d+\\.\d+\\.\d+)(:\\:\d+)*/",$Vada01463,$V793914c9)) { $V3d405e8c=$V793914c9[1]; 
 } } } if (isset($this->Va2bbabfe[$V2bfe9d72]['guid']) && isset($V0b5a0d9e) && $this->Va2bbabfe[$V2bfe9d72]['guid']!=$V0b5a0d9e)
 { $this->V6d2b5d2c['disconnected'][$V2bfe9d72]=1; } if (isset($this->Va2bbabfe[$V2bfe9d72]['ip']) && isset($V3d405e8c) 
 && $this->Va2bbabfe[$V2bfe9d72]['ip']!=$V3d405e8c) { $this->V6d2b5d2c['disconnected'][$V2bfe9d72]=1;
} $this->Va2bbabfe[$V2bfe9d72]['guid']=$V0b5a0d9e; $this->Va2bbabfe[$V2bfe9d72]['ip']=$V3d405e8c;
 } else { $this->Va733fe6b=$Vbb897a7c; fseek($this->V50dffd37,$V40023427); } if (isset($this->Va2bbabfe[$V2bfe9d72]))
 { if (!isset($this->V6d2b5d2c['disconnected'][$V2bfe9d72])) { } else { if (isset($this->Va2bbabfe[$V2bfe9d72]['guid']))
 $Vb257828c=$this->Va2bbabfe[$V2bfe9d72]['guid']; if (isset($this->Va2bbabfe[$V2bfe9d72]['ip'])) $V6dce490b=$this->Va2bbabfe[$V2bfe9d72]['ip']; 
 unset($this->Va2bbabfe[$V2bfe9d72]); if (isset($Vb257828c)) $this->Va2bbabfe[$V2bfe9d72]['guid']=$Vb257828c;
if (isset($V6dce490b)) $this->Va2bbabfe[$V2bfe9d72]['ip']=$V6dce490b; } if (isset($this->V6d2b5d2c['disconnected'][$V2bfe9d72]))
 unset($this->V6d2b5d2c['disconnected'][$V2bfe9d72]); } return true; } function F2063e72d(&$V6438c669)
 { if (!preg_match("/^Medic_Revive: (\d+) (\d+)/", $V6438c669, $Vb74df323)) return false; $V2bfe9d72=$Vb74df323[1];
$V90bc45fa=$Vb74df323[2]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Revives Given",1);
} if (isset($this->Va2bbabfe[$V90bc45fa]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V90bc45fa]['id'],"Role_Action|Revives Received",1);
} return true; } function Fca8d5713(&$V6438c669) { if (!preg_match("/^Steal_Uniform: (\d+) (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V90bc45fa=$Vb74df323[2]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id']))
 { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Uniforms Stolen",1);
} if (isset($this->Va2bbabfe[$V90bc45fa]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V90bc45fa]['id'],"Role_Action|Uniforms Lost",1);
} return true; } function Fde950ea0(&$V6438c669) { if (!preg_match("/^Ammo_Pack: (\d+) (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V90bc45fa=$Vb74df323[2]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id']))
 { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Ammo Given",1); } if (isset($this->Va2bbabfe[$V90bc45fa]['id']))
 { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V90bc45fa]['id'],"Role_Action|Ammo Taken",1); } return true;
} function Fac8bb84f(&$V6438c669) { if (!preg_match("/^Health_Pack: (\d+) (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V90bc45fa=$Vb74df323[2]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id']))
 { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Health Given",1); }
 if (isset($this->Va2bbabfe[$V90bc45fa]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V90bc45fa]['id'],"Role_Action|Health Taken",1);
} return true; } function Fe3e681be(&$V6438c669) { if (!preg_match("/^Dynamite_Plant: (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Dynamites Planted",1);
} return true; } function Ff94b0253(&$V6438c669) { if (!preg_match("/^Dynamite_Diffuse: (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Dynamites Diffused",1);
} return true; } function F97e180f2(&$V6438c669) { if (!preg_match("/^Repair: (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id'])) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"Role_Action|Repair",1);
} return true; } function Fa8539cfc(&$V6438c669) { if ($this->F2063e72d($V6438c669)) { return true;
} else if ($this->Fca8d5713($V6438c669)) { return true; } else if ($this->Fde950ea0($V6438c669)) {
 return true; } else if ($this->Fac8bb84f($V6438c669)) { return true; } else if ($this->Fe3e681be($V6438c669))
 { return true; } else if ($this->Ff94b0253($V6438c669)) { return true; } else if ($this->F97e180f2($V6438c669))
 { return true; } else if ($this->F73171ca8($V6438c669)) { return true; } else if ($this->Fcfcf8f26($V6438c669))
 { return true; } return false; } } ?>