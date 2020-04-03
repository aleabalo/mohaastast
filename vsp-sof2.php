<? /* vsp stats processor, copyright 2004-2005, myrddin8 AT gmail DOT com (a924cb279be8cb6089387d402288c9f2) */
include("./vsp-q3a.php"); class VSPParserSOF2 extends VSPParserQ3A { function VSPParserSOF2($Ve0d85fdc,&$V4f00ff2f,&$V495c39bf)
 { parent::VSPParserQ3A($Ve0d85fdc,$V4f00ff2f,$V495c39bf); $this->V42dfa3a4['char_trans']=array( "^^" => "^",
 "^0" => "`#000000", "^1" => "`#FF1919", "^2" => "`#A9C274", "^3" => "`#FFFF00", "^4" => "`#4C4CFF",
 "^5" => "`#00FDFD", "^6" => "`#FF00FF", "^7" => "`#FFFFFF", "^8" => "`#7A00D8", "^9" => "`#3CDCB5",
 "^a" => "`#00F3B5", "^b" => "`#DC903C", "^c" => "`#D743CE", "^d" => "`#7FACDA", "^e" => "`#D80086",
 "^f" => "`#70C4CE", "^g" => "`#81F229", "^h" => "`#860028", "^i" => "`#254AAD", "^j" => "`#4AD800",
 "^k" => "`#CEB281", "^l" => "`#90C4F2", "^m" => "`#BD25B6", "^n" => "`#4E7F32", "^o" => "`#AF6B70",
 "^p" => "`#24946B", "^q" => "`#AF9594", "^r" => "`#B653B2", "^s" => "`#320022", "^t" => "`#7A0028",
 "^u" => "`#3C24B5", "^v" => "`#0DD743", "^w" => "`#000001", "^x" => "`#000D29", "^y" => "`#0E90C4",
 "^z" => "`#B28132", "^A" => "`#4A00EF", "^B" => "`#3CDC29", "^C" => "`#ED5124", "^D" => "`#324E7F",
 "^E" => "`#6CAF28", "^F" => "`#002470", "^G" => "`#48AA25", "^H" => "`#956C81", "^I" => "`#4EC4DC",
 "^J" => "`#94AF95", "^K" => "`#ADDB81", "^L" => "`#B27AD8", "^M" => "`#00D87A", "^N" => "`#D18900",
 "^O" => "`#B5BDF2", "^P" => "`#00F800", "^Q" => "`#F34BBD", "^R" => "`#293CDC", "^S" => "`#43F229",
 "^T" => "`#CE4E3C", "^U" => "`#9043F2", "^V" => "`#7BC8AD", "^W" => "`#8600B6", "^X" => "`#25B4AB",
 "^Y" => "`#86D700", "^Z" => "`#AF95DC", "^!" => "`#000000", "^#" => "`#000000", "^$" => "`#FF0000",
 "^%" => "`#0000FF", "^&" => "`#0000FF", "^(" => "`#FA00FA", "^)" => "`#00FFFF", "^*" => "`#ECECEC",
 "^+" => "`#B7B7B7", "^-" => "`#3F3F3F", "^," => "`#7E7E7E", "^." => "`#5D42B8", "^\\" => "`#B3446F",
 "^/" => "`#320065", "^<" => "`#00FFFF", "^>" => "`#25AFA7", "^[" => "`#3BAC92", "^]" => "`#25B695",
 "^{" => "`#BD0E00", "^}" => "`#254952", "^:" => "`#F3B27F", "^=" => "`#69AB8E", "^?" => "`#85D74E",
 "^@" => "`#C68100", "^_" => "`#FF0000", "^'" => "`#F4F4F4", "^|" => "`#7ADB4A", "^~" => "`#C68100"
 ); $this->V42dfa3a4['hit_location'][]="locnone"; $this->V42dfa3a4['hit_location'][]="locleg-right(foot)";
$this->V42dfa3a4['hit_location'][]="locleg-left(foot)"; $this->V42dfa3a4['hit_location'][]="locleg-right(upper)";
$this->V42dfa3a4['hit_location'][]="locleg-left(upper)"; $this->V42dfa3a4['hit_location'][]="locleg-right(lower)";
$this->V42dfa3a4['hit_location'][]="locleg-left(lower)"; $this->V42dfa3a4['hit_location'][]="locarm-right(hand)";
$this->V42dfa3a4['hit_location'][]="locarm-left(hand)"; $this->V42dfa3a4['hit_location'][]="locarm-right(ul)";
$this->V42dfa3a4['hit_location'][]="locarm-left(ul)"; $this->V42dfa3a4['hit_location'][]="lochead";
$this->V42dfa3a4['hit_location'][]="locstomach"; $this->V42dfa3a4['hit_location'][]="locchest"; $this->V42dfa3a4['hit_location'][]="locchest";
$this->V42dfa3a4['hit_location'][]="locchest"; $this->V42dfa3a4['hit_location'][]="locchest"; $this->V42dfa3a4['hit_location'][]="locchest";
$this->V42dfa3a4['hit_location'][]="locchest"; $this->V42dfa3a4['hit_location'][]="locneck"; $this->V42dfa3a4['hit_location'][]="logdebug";
} function Fa8539cfc(&$V6438c669) { if ($this->Fe8dd1de8($V6438c669)) { return true; } return false;
} function Fe8dd1de8(&$V6438c669) { if (!preg_match("/^hit: (\d+) (\d+) (\d+) (\d+) (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V6426a622=$Vb74df323[2]; $V536d25c1=$Vb74df323[3]; $Vda14a716=$Vb74df323[4]; 
 $V2e7bf2ef='UNKNOWN'; $this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'], $this->Va2bbabfe[$V2bfe9d72]['id'], "accuracy|{$V2e7bf2ef}_hits",1);
$this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'], $this->Va2bbabfe[$V2bfe9d72]['id'], "accuracy|{$V2e7bf2ef}_shots",1);
$V15467e06=strrev(sprintf("%b",$V536d25c1)); $Vfc1178ea=strlen($V15467e06); for($V865c0c0b=0;$V865c0c0b<$Vfc1178ea;$V865c0c0b++)
 { if ($V15467e06[$V865c0c0b]=='1') { $this->Vae2aeb93->F4135e567($this->Va2bbabfe[$V2bfe9d72]['id'], $this->Va2bbabfe[$V2bfe9d72]['id'], "accuracy|{$V2e7bf2ef}_".$this->V42dfa3a4['hit_location'][$V865c0c0b],1);
} } if ($Vda14a716>0) { $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"damage given",$Vda14a716);
$this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V6426a622]['id'],"damage taken",$Vda14a716); } return true;
} function F7939839b(&$V6438c669) { if (parent::F7939839b($V6438c669)) { $this->Vae2aeb93->F6d04475a("_v_game",'sof2');
return true; } return false; } function Fce212e15(&$V6438c669) { if (!preg_match("/^Warmup:/", $V6438c669, $Vb74df323))
 return false; return true; } function F26a565c8(&$V6438c669) { return false; } function F12520a4b(&$V6438c669)
 { if (!preg_match("/^ClientConnect: (\d+)/", $V6438c669, $Vb74df323)) return false; $V2bfe9d72=$Vb74df323[1];
 if (isset($this->Va2bbabfe[$V2bfe9d72])) { unset($this->Va2bbabfe[$V2bfe9d72]); } if (preg_match("/^ClientConnect: (\d+) - (\d+\.\d+\.\d+\.\d+)(:-?\d*)?( \[(.+)\])?/", $V6438c669, $Va9ddcf51))
 { $this->Va2bbabfe[$V2bfe9d72]['ip']=$Va9ddcf51[2]; if (isset($Va9ddcf51[5])) $this->Va2bbabfe[$V2bfe9d72]['guid']=$Va9ddcf51[5];
} return true; } function Ffab4963e(&$V6438c669) { if (!preg_match("/^ClientBegin: (\d+)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; if (isset($this->Va2bbabfe[$V2bfe9d72]['id'])) { if ($this->Va2bbabfe[$V2bfe9d72]['team']!='3')
 { if (isset($this->Va2bbabfe[$V2bfe9d72]['name'])) { $this->Vae2aeb93->F6aae4907($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['name']);
} if (isset($this->Va2bbabfe[$V2bfe9d72]['team'])) $this->Vae2aeb93->F555c9055($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['team']);
if (isset($this->Va2bbabfe[$V2bfe9d72]['ip'])) $this->Vae2aeb93->Fec5ab55c("sto",$this->Va2bbabfe[$V2bfe9d72]['id'],"ip",$this->Va2bbabfe[$V2bfe9d72]['ip']);
if (isset($this->Va2bbabfe[$V2bfe9d72]['guid'])) $this->Vae2aeb93->Fec5ab55c("sto",$this->Va2bbabfe[$V2bfe9d72]['id'],"guid",$this->Va2bbabfe[$V2bfe9d72]['guid']);
} } return true; } function Ff90d84c5(&$V6438c669) { if (!preg_match("/^ClientUserinfoChanged: (\d+) (.*)/", $V6438c669, $Vb74df323))
 return false; $V2bfe9d72=$Vb74df323[1]; $V4fe74676=$Vb74df323[2]; while (preg_match("/^(.+)\\\(.*)\\\/U", $V4fe74676, $Va9ddcf51) || preg_match("/^(.+)\\\(.*)/", $V4fe74676, $Va9ddcf51))
 { $Vf986617c=$Va9ddcf51[1]; $Vada01463=$Va9ddcf51[2]; $V4fe74676=substr($V4fe74676,strlen($Vf986617c)+strlen($Vada01463)+2);
if (!strcmp($Vf986617c,"n")) { $V1963b948=$this->Fa3f5d48d($Vada01463); if ($this->V93da65a9['trackID'] == 'playerName' && isset($this->Va2bbabfe[$V2bfe9d72]['id']) && strcmp($this->Va2bbabfe[$V2bfe9d72]['id'],$Vada01463)!=0)
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
} else if (!strcmp($Vf986617c,"t")) { $this->Va2bbabfe[$V2bfe9d72]['team']=$Vada01463; if ($this->Va2bbabfe[$V2bfe9d72]['team']!='3')
 $this->Vae2aeb93->F555c9055($this->Va2bbabfe[$V2bfe9d72]['id'],$this->Va2bbabfe[$V2bfe9d72]['team']);
} else if (!strcmp($Vf986617c,"identity")) { if ($this->Va2bbabfe[$V2bfe9d72]['team']!='3') { if (!isset($this->Va2bbabfe[$V2bfe9d72]['icon']) || strcmp($this->Va2bbabfe[$V2bfe9d72]['icon'],$Vada01463))
 { $this->Va2bbabfe[$V2bfe9d72]['icon']=$Vada01463; $this->Vae2aeb93->F72d01d3f($this->Va2bbabfe[$V2bfe9d72]['id'],"icon|{$this->Va2bbabfe[$V2bfe9d72]['icon']}",1); 
 } } } } return true; } } ?>