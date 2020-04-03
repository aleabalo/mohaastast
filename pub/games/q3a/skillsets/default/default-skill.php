<?
//------------------------------------------------------------------------------
// Pretty simple formula for now, which is basically:-
//
// $victim_based_skill_no =  $victimSkill * $skillset_fraction ;
//
// $KillerSkill+=$weaponFactor * $victim_based_skill_no;
// $VictimSkill-=$victim_based_skill_no;
// 
// In the event of a suicide or a teamkill, the appropriate penalty based on the
// above formula is applied
//------------------------------------------------------------------------------

global $skillset;

// a fraction is gained by the killer and lost by the victim
$skillset['fraction']['value'] = 1/1000.0;

// weapon modifier
$skillset['weapon_factor']['GAUNTLET']=1.5;
$skillset['weapon_factor']['MACHINEGUN']=1.0;
$skillset['weapon_factor']['SHOTGUN']=1.0;
$skillset['weapon_factor']['GRENADE']=1.5;
$skillset['weapon_factor']['GRENADE_SPLASH']=1.0;
$skillset['weapon_factor']['ROCKET']=1.25;
$skillset['weapon_factor']['ROCKET_SPLASH']=1.0;
$skillset['weapon_factor']['LIGHTNING']=1.25;
$skillset['weapon_factor']['PLASMA']=1.25;
$skillset['weapon_factor']['PLASMA_SPLASH']=1.0;
$skillset['weapon_factor']['RAILGUN']=1.5;

// event skill is just added to the player's current skill
$skillset['event']['CTF|Flag_Return']=1.0;
$skillset['event']['CTF|Kill_Carrier']=2.0;
$skillset['event']['CTF|Defend_Base']=1.0;
$skillset['event']['CTF|Defend_Flag']=1.0;
$skillset['event']['CTF|Flag_Assist_Frag']=1.0;
$skillset['event']['CTF|Flag_Assist_Return']=1.0;
$skillset['event']['CTF|Flag_Pickup']=1.0;
$skillset['event']['CTF|Defend_Hurt_Carrier']=2.0;
$skillset['event']['CTF|Hurt_Carrier_Defend']=2.0;
$skillset['event']['CTF|Defend_Carrier']=2.0;
$skillset['event']['CTF|Flag_Capture']=10.0;


?>