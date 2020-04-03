<? /* vsp stats processor, copyright 2004-2005, myrddin8 AT gmail DOT com (a924cb279be8cb6089387d402288c9f2) */
include("./vsp-q3a.php"); class VSPParserRTCW extends VSPParserQ3A { function F7939839b(&$V6438c669)
 { if (parent::F7939839b($V6438c669)) { $this->Vae2aeb93->F6d04475a("_v_game",'rtcw'); return true;
} return false; } function F26a565c8(&$V6438c669) { return false; } function Ff90d84c5(&$V6438c669)
 { if (!preg_match("/^ClientUserinfoChanged: (\d+) (.*)/", $V6438c669, $Vb74df323)) return false;
$V2bfe9d72=$Vb74df323[1]; $V4fe74676=$Vb74df323[2]; while (preg_match("/^(.+)\\\(.*)\\\/U", $V4fe74676, $Va9ddcf51) || preg_match("/^(.+)\\\(.*)/", $V4fe74676, $Va9ddcf51))
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
} else if (!strcmp($Vf986617c,"model")) { if ($this->Va2bbabfe[$V2bfe9d72]['team']!='3') { if (preg_match("/multi.*\\/.*lieutenant.*/",$Vada01463,$Vb74df323))
 $this->Va2bbabfe[$V2bfe9d72]['role']='lieutenant'; else if (preg_match("/^multi.*\\/.*medic.*/",$Vada01463,$Vb74df323))
 $this->Va2bbabfe[$V2bfe9d72]['role']='medic'; else if (preg_match("/^multi.*\\/.*engineer.*/",$Vada01463,$Vb74df323))
 $this->Va2bbabfe[$V2bfe9d72]['role']='engineer'; else if (preg_match("/^multi.*\\/.*soldier.*/",$Vada01463,$Vb74df323))
 $this->Va2bbabfe[$V2bfe9d72]['role']='soldier'; $this->Vae2aeb93->Fa3f3cadc($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['role']);
if (!isset($this->Va2bbabfe[$V2bfe9d72]['icon']) || strcmp($this->Va2bbabfe[$V2bfe9d72]['icon'],$Vada01463))
 { $this->Va2bbabfe[$V2bfe9d72]['icon']=$Vada01463; $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"icon|{$this->Va2bbabfe[$V2bfe9d72]['icon']}",1);
} } } } return true; } } ?>