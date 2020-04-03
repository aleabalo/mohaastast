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
$skillset['weapon_factor']['ak47']=1.5;
$skillset['weapon_factor']['aug']=1.5;
$skillset['weapon_factor']['awp']=1.5;
$skillset['weapon_factor']['deagle']=1.75;
$skillset['weapon_factor']['elite']=1.75;
$skillset['weapon_factor']['five-seven']=1.75;
$skillset['weapon_factor']['g35gl']=1.5;
$skillset['weapon_factor']['glock18']=1.75;
$skillset['weapon_factor']['grenade']=2.0;
$skillset['weapon_factor']['headshot']=2.5;
$skillset['weapon_factor']['knife']=3.0;
$skillset['weapon_factor']['m3']=1.25;
$skillset['weapon_factor']['m4a1']=1.5;
$skillset['weapon_factor']['m249']=1.25;
$skillset['weapon_factor']['mac10']=1.25;
$skillset['weapon_factor']['mp5navy']=1.25;
$skillset['weapon_factor']['p90']=1.25;
$skillset['weapon_factor']['p228']=1.75;
$skillset['weapon_factor']['scout']=1.5;
$skillset['weapon_factor']['sg550']=1.5;
$skillset['weapon_factor']['sg552']=1.5;
$skillset['weapon_factor']['tank']=2.5;
$skillset['weapon_factor']['tmp']=1.25;
$skillset['weapon_factor']['ump45']=1.25;
$skillset['weapon_factor']['usp45']=1.75;
$skillset['weapon_factor']['xm1041']=1.25;

// event skill is just added to the player's current skill
$skillset['event']['event_1']=1.0;
$skillset['event']['event_2']=2.0;
$skillset['event']['eventCategory_1|event_1']=10.0;
$skillset['event']['eventCategory_1|event_2']=5.0;
$skillset['event']['eventCategory_2|event_1']=1.5;
$skillset['event']['eventCategory_2|event_2']=1.0;

?>
