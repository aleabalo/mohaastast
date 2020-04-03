<?php
$start_time=gettimeofday();

require("./util.php");
require("./all.inc.php");
require(getConfig());
require("{$GLOBALS['cfg']['db']['adodb_path']}".'adodb.inc.php');

$db = &ADONewConnection("{$GLOBALS['cfg']['db']['adodb_driver']}");
if(!$db->Connect($GLOBALS['cfg']['db']['hostname'], $GLOBALS['cfg']['db']['username'], $GLOBALS['cfg']['db']['password'], $GLOBALS['cfg']['db']['dbname']))
{
  print "error: cannot establish database connection\n";
  exit();
}
//$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->SetFetchMode(ADODB_FETCH_NUM);

$playerID=$_GET['playerID'];
if (get_magic_quotes_gpc())
  $playerID=stripslashes($playerID);

$qplayerID=$db->qstr($playerID); // playerID quoted for sql



setSkin();

setupVars();

getStats();
getStats1D();

readPlayerData();

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-1">
<TITLE>vsp (player stats)</TITLE>
<LINK REL=stylesheet HREF="<? print $GLOBALS['stylesheet']; ?>" TYPE="text/css">
<? if ($settings['display']['javascript_tooltips']) includeDOMTT();?>
<script language="javascript" type="text/javascript" src="../../lib/sorttable/sorttable.js"></script>
<script language="JavaScript" type="text/javascript">

function searchByGUID(search_txt)
{
  document.guidform.search_txt.value=''+search_txt;
  document.guidform.submit();
}
function searchByIP(search_txt)
{
  document.ipform.search_txt.value=''+search_txt;
  document.ipform.submit();
}
function searchByName(search_txt)
{
  document.nameform.search_txt.value=''+search_txt;
  document.nameform.submit();
}
</script>
</HEAD>

<?
$pre_time=timeElapsed($start_time);
ob_start("compactHTML");
?>

<body>


<?
//*************************************************************************
function setupVars()
{
  if (!is_dir("../../games/{$GLOBALS['cfg']['game']['name']}"))
  {
    $GLOBALS['cfg']['game']['name']='default';
  }
}
//*************************************************************************
function drawHeadBar()
{
  global $sort,$config;
  ?>
  <!-- navbar begin          ################################################-->
  <table CLASS="cellHeading" CELLSPACING="0" CELLPADDING="1" WIDTH="100%" style="border-width: 0;">
    <TR>
    <TD HEIGHT="25" CLASS="cellHeading" style="border-right-width: 0; text-align: left;" >
      <B>Player Profile</B>
    </TD>
    </TR>
  </table>
  <!-- navbar end            ################################################-->
  <?
}
//*************************************************************************
function drawStats1D($eventCategory)
{
  
  global $db;
  global $gmatrix1D,$gevent1D,$geventName1D;
  
  $gevent1D_tmp = $gevent1D;
  
  $max_items=0;
  foreach($gevent1D_tmp as $eventCat => $val)
  {
    $max_new = count($val);
    if ($max_new>$max_items)
      $max_items = $max_new;
  }
  
  ?>
  <!-- events per category begin ##################################################-->
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=0 WIDTH="100%" >
  <TR CLASS="cellSubHeading">
    <TD COLSPAN="2" WIDTH="100%" style="text-align: left"><?print fstr($eventCategory);?>&nbsp;</TD>
  </TR>
  <?
  $count=0;
  if ($gmatrix1D[$eventCategory])
  {
    //htmlprint_r($gmatrix1D[$teamID][$playerID]);
    foreach($gmatrix1D[$eventCategory] as $eventName => $eventValue)
    {
      
      
      
      if ($count%2 == 0)
        $cell_class="cell1";
      else
        $cell_class="cell2";
      $count++;

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
      <TD WIDTH="70%" style="text-align: left"><?print fstr($eventName);?></TD>
      <TD WIDTH="30%"><?print fstr($eventValue);?></TD>
      </TR>
      <?  


    }
  }
  
  for($i=$count;$i<$max_items;$i++)
  {
    if ($i%2 == 0)
      $cell_class="cell1";
    else
      $cell_class="cell2";

    ?>
    <TR CLASS="<?print "$cell_class"?>">
    <TD WIDTH="70%">&nbsp;</TD>
    <TD WIDTH="30%">&nbsp;</TD>
    </TR>
    <?  
  }
  ?>
  </TABLE>
  <!-- events per category end   ##################################################-->
  <?
}
//*************************************************************************
function drawPlayerStats()
{
  $categories_per_row=3;
  global $db;
  global $gmatrix1D,$gevent1D;
  global $gmatrix,$gmatrixtotal,$gweapon;
  global $player_data;

  

  ?>

      <table style="border-width: 0; padding: 0px 0px 0px 0px" CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
      <TR>
        <TD COLSPAN="<?print $categories_per_row;?>" WIDTH="100%" CLASS="cellHeading" style="text-align: left">
          &nbsp;
        </TD>
      </TR>



      <?
      $count_cat=0;
      
      if (isset($gevent1D))
      {
        
        foreach($gevent1D as $eventCategory => $val)
        {

          if ($count_cat%$categories_per_row==0)
            echo "\n<TR>";

          $count_cat++;
          ?>
          <TD WIDTH="<?print round(100/($categories_per_row),2)?>%" CLASS="cellBG" style="vertical-align: top; text-align: left ;border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px">
          <?drawStats1D($eventCategory);?>
          </TD>
          <?

          if ($count_cat%$categories_per_row==0)
            echo "</TR>\n";

        }
      }

      while ($count_cat%$categories_per_row!=0)
      {
        if ($count_cat%$categories_per_row==0)
          echo "\n<TR>";

        $count_cat++;

        ?>
        <TD WIDTH="<?print 100/($categories_per_row)?>%" CLASS="cellSubHeading" style="vertical-align: top; text-align: left ;border-width: 0px 0px 0px 0px; padding: 0px 0px 0px 0px">
        <?drawStats1D(false);?>
        </TD>
        <?

        if ($count_cat%$categories_per_row==0)
          echo "</TR>\n";

      }


      ?>

      <TR>
        <TD COLSPAN="<?print $categories_per_row;?>" WIDTH="100%" CLASS="cellSubHeading" style="vertical-align: top; text-align: left; padding: 0 ; border-width: 0">
        <?drawWeaponStats();?>
        </TD>
      </TR>


      </table>
      <BR>

  <?




} 

//*************************************************************************
function getStats1D()
{
  global $db;
  global $gmatrix1D,$gevent1D,$gicon;
  $sql = "select eventCategory, eventName, sum(eventValue),team,role  
            from {$GLOBALS['cfg']['db']['table_prefix']}eventdata1d
            where playerID={$GLOBALS['qplayerID']}
            group by playerID,eventCategory,eventName,team,role
         ";

  //echo $sql;
  $rs = $db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    
    do
    {

      if ($rs->fields[0]=='icon')
      {
        if (!isset($gicon[$GLOBALS['playerID']][$rs->fields[3]][$rs->fields[4]][$rs->fields[1]]))
          $gicon[$GLOBALS['playerID']][$rs->fields[3]][$rs->fields[4]][$rs->fields[1]]=0;
        $gicon[$GLOBALS['playerID']][$rs->fields[3]][$rs->fields[4]][$rs->fields[1]]+=$rs->fields[2];
      }
      else
      {
        $gevent1D[$rs->fields[0]][$rs->fields[1]] = 1;

        if (!isset($gmatrix1D[$rs->fields[0]][$rs->fields[1]]))
          $gmatrix1D[$rs->fields[0]][$rs->fields[1]]=0;
        $gmatrix1D[$rs->fields[0]][$rs->fields[1]]+=$rs->fields[2];
      }


    }while($rs->MoveNext());
  }

  if ($gevent1D)
  {
    ksort($gevent1D);
    foreach ($gevent1D as $cat=>$event)
      ksort($gevent1D[$cat]);
  }
  if ($gmatrix1D)
  {
    foreach($gmatrix1D as $eventCategoryi=>$eventCategoryi_val)
      ksort($gmatrix1D[$eventCategoryi]);
  }

  //htmlprint_r($gmatrix1D);
  //htmlprint_r($gicon);
}
//*************************************************************************
function getStats()
{

  global $db;
  global $gevent1D,$gmatrix1D;
  global $gmatrix,$gmatrixtotal,$gweapon,$gplayerName,$ggame;
  $sql = "select eventCategory, team, team2, ED2D.playerID, player2ID, eventName, eventValue, playerName,gameID,role,role2  
            from {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d as ED2D,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP
            where ED2D.playerID={$GLOBALS['qplayerID']}
                  AND ED2D.playerID!=ED2D.player2ID
                  AND ED2D.player2ID=PP.playerID
         ";

  //echo($sql);
  $rs_all[] = $db->Execute($sql);
  
  $sql = "select eventCategory, team, team2, ED2D.playerID, player2ID, eventName, eventValue, playerName,gameID,role,role2  
            from {$GLOBALS['cfg']['db']['table_prefix']}eventdata2d as ED2D,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP
            where ED2D.player2ID={$GLOBALS['qplayerID']}
                  AND ED2D.playerID=PP.playerID
         ";

  //echo($sql);
  $rs_all[] = $db->Execute($sql);

  foreach ($rs_all as $rs_count => $rs)
  {
    if ($rs && !$rs->EOF)
    {

      do
      {
        $ggame[$rs->fields[8]]=1;
        if ($rs->fields[0]=='kill' || $rs->fields[0]=='suicide' || $rs->fields[0]=='teamkill')
        { 
          $gweapon[$rs->fields[5]]=1;


          if ($rs_count==0)
            $gplayerName[$rs->fields[4]] = $rs->fields[7];
          else if ($rs_count==1)
            $gplayerName[$rs->fields[3]] = $rs->fields[7];



          //print(" t1->".$rs->fields[1]." p1->".$rs->fields[3]." t2->".$rs->fields[2]." p2>".$rs->fields[4]."<BR>");
          if (!strcmp($rs->fields[3],$GLOBALS['playerID']) && $rs->fields[0]=='kill')
          { //kill
            //echo "kill<BR>";
            //**********kill matrix





            if (!isset($gmatrixtotal[$rs->fields[4]]['_v_weapon']['kills']))
              $gmatrixtotal[$rs->fields[4]]['_v_weapon']['kills']=0;
            $gmatrixtotal[$rs->fields[4]]['_v_weapon']['kills']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player'][$rs->fields[5]]['kills']))
              $gmatrixtotal['_v_player'][$rs->fields[5]]['kills']=0;
            $gmatrixtotal['_v_player'][$rs->fields[5]]['kills']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player']['_v_weapon']['kills']))
              $gmatrixtotal['_v_player']['_v_weapon']['kills']=0;
            $gmatrixtotal['_v_player']['_v_weapon']['kills']+=$rs->fields[6];
            //**********kill matrix

          }

          else if (!strcmp($rs->fields[3],$GLOBALS['playerID']) && $rs->fields[0]=='suicide')
          { //suicide
            //echo "suicide<BR>";





            if (!isset($gmatrixtotal['_v_player'][$rs->fields[5]]['suicides']))
              $gmatrixtotal['_v_player'][$rs->fields[5]]['suicides']=0;
            $gmatrixtotal['_v_player'][$rs->fields[5]]['suicides']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player']['_v_weapon']['suicides']))
              $gmatrixtotal['_v_player']['_v_weapon']['suicides']=0;
            $gmatrixtotal['_v_player']['_v_weapon']['suicides']+=$rs->fields[6];


            //********* death matrix
            if (!isset($gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']))
              $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']=0;
            $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']+=$rs->fields[6];


            if (!isset($gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']))
              $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']=0;
            $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player']['_v_weapon']['deaths']))
              $gmatrixtotal['_v_player']['_v_weapon']['deaths']=0;
            $gmatrixtotal['_v_player']['_v_weapon']['deaths']+=$rs->fields[6];
            //********* death matrix


          }

          else if (!strcmp($rs->fields[3],$GLOBALS['playerID']) && $rs->fields[0]=='teamkill')
          { //team kill




            $gevent1D['']['Team Kills'] = 1;
            if (!isset($gmatrix1D['']['Team Kills']))
              $gmatrix1D['']['Team Kills']=0;
            $gmatrix1D['']['Team Kills']+=$rs->fields[6];
          }
          else if (!strcmp($rs->fields[4],$GLOBALS['playerID']) && $rs->fields[0]=='teamkill')
          { // team death




            $gevent1D['']['Team Deaths'] = 1;
            if (!isset($gmatrix1D['']['Team Deaths']))
              $gmatrix1D['']['Team Deaths']=0;
            $gmatrix1D['']['Team Deaths']+=$rs->fields[6];


            //********* death matrix
            /* 
            // If this code is enabled, it messes with the easiest prey/worst enemy stuff.
            // ie team kills get shown in the easiest prey column
            if (!isset($gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']))
              $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']=0;
            $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']+=$rs->fields[6];
            */

            if (!isset($gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']))
              $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']=0;
            $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player']['_v_weapon']['deaths']))
              $gmatrixtotal['_v_player']['_v_weapon']['deaths']=0;
            $gmatrixtotal['_v_player']['_v_weapon']['deaths']+=$rs->fields[6];
            //********* death matrix


          }
          else
          { //death
            //echo "death<BR>";





            //********* death matrix
            if (!isset($gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']))
              $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']=0;
            $gmatrixtotal[$rs->fields[3]]['_v_weapon']['deaths']+=$rs->fields[6];


            if (!isset($gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']))
              $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']=0;
            $gmatrixtotal['_v_player'][$rs->fields[5]]['deaths']+=$rs->fields[6];

            if (!isset($gmatrixtotal['_v_player']['_v_weapon']['deaths']))
              $gmatrixtotal['_v_player']['_v_weapon']['deaths']=0;
            $gmatrixtotal['_v_player']['_v_weapon']['deaths']+=$rs->fields[6];
            //********* death matrix

          }



        }
        else if ($rs->fields[0] == 'accuracy')
        {
          if (preg_match("/^(.*)_(.*)/", $rs->fields[5], $ma))
          {
            $weapon=$ma[1];
            $type=$ma[2];


            if (!isset($gweapon[$weapon])) 
             $gweapon[$weapon]=1;         


            if ($type=='hits')
            {
              if (!strcmp($rs->fields[3],$rs->fields[4]))// ie the same
              {
                if (!isset($GLOBALS['g_hitbox']['ALL']))
                  $GLOBALS['g_hitbox']['ALL']=0;
                $GLOBALS['g_hitbox']['ALL']+=$rs->fields[6];

                if (!isset($gmatrixtotal['_v_player'][$weapon]['hits']))
                  $gmatrixtotal['_v_player'][$weapon]['hits']=0;
                $gmatrixtotal['_v_player'][$weapon]['hits']+=$rs->fields[6];


                if (!isset($gmatrixtotal['_v_player']['_v_weapon']['hits']))
                  $gmatrixtotal['_v_player']['_v_weapon']['hits']=0;
                $gmatrixtotal['_v_player']['_v_weapon']['hits']+=$rs->fields[6];


              }
            }
            else if ($type=='shots')
            {
              if (!strcmp($rs->fields[3],$rs->fields[4]))// ie the same
              {
                if (!isset($gmatrixtotal['_v_player'][$weapon]['shots']))
                  $gmatrixtotal['_v_player'][$weapon]['shots']=0;
                $gmatrixtotal['_v_player'][$weapon]['shots']+=$rs->fields[6];


                if (!isset($gmatrixtotal['_v_player']['_v_weapon']['shots']))
                  $gmatrixtotal['_v_player']['_v_weapon']['shots']=0;
                $gmatrixtotal['_v_player']['_v_weapon']['shots']+=$rs->fields[6];

              }
            }
            else if (preg_match("/loc(.+)/",$type,$ma))
            {
              //echo "$type<BR>";
              if (!isset($GLOBALS['g_hitbox'][$ma[1]]))
                $GLOBALS['g_hitbox'][$ma[1]]=0;
              $GLOBALS['g_hitbox'][$ma[1]]+=$rs->fields[6];
            }
          }
        }
        else
        {
          // PvP events. Just add as normal 1D event for now
          $gevent1D[$rs->fields[0]][$rs->fields[5]] = 1;

          if (!isset($gmatrix1D[$rs->fields[0]][$rs->fields[5]]))
            $gmatrix1D[$rs->fields[0]][$rs->fields[5]]=0;
          $gmatrix1D[$rs->fields[0]][$rs->fields[5]]+=$rs->fields[6];
        }




      }while($rs->MoveNext());

    }
  }

  
  
  
  ksort($gweapon);
  
  
  //htmlprint_r($gmatrixtotal);
}
//*************************************************************************
function drawPreyOrEnemyList($what,$limit)
{
  global $db;
  global $gmatrixtotal;
  global $gplayerName;

  //$limit=100;
  if (!strcmp($what,"prey"))
  {
    $eff_sortdir="down";
    $data='kills';
    $table_heading = "Easiest Preys";
  }
  else if (!strcmp($what,"enemy"))
  {
    $eff_sortdir="up";
    $data='deaths';  
    $table_heading = "Worst Enemies";
  }
  else
    return;

  foreach($gmatrixtotal as $player_i=>$val_i)
    $player_list[$player_i]=$gmatrixtotal[$player_i]['_v_weapon'][$data];

  unset($player_list['_v_player']);
  unset($player_list[$GLOBALS['playerID']]);

  arsort($player_list,SORT_NUMERIC);

  ?>
  <!-- prey/enemy  table begin ##################################################-->
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
    <TD WIDTH="100%" COLSPAN="5" CLASS="cellHeading" style="text-align: center "><?echo $table_heading?> (top <?echo $limit?>)  
    </TD>
    </TR>
  </table>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%" class="sortable" id="<?echo $what?>">
    <TR CLASS="cellSubHeading">
    <TD style="text-align: left">Player</TD>
    <TD>Kills</TD>
    <TD>Deaths</TD>
    <TD sortdir="<?print $eff_sortdir;?>">Eff %</TD>
    </TR>
  <?

  $count=0;
  foreach ($player_list as $playerID=>$val)
  {
    $count++;
    if ($count%2 == 1)
      $cell_class="cell1";
    else
      $cell_class="cell2";

    $kills=0+$gmatrixtotal[$playerID]['_v_weapon']['kills'];
    $deaths=0+$gmatrixtotal[$playerID]['_v_weapon']['deaths'];

    ?>
    <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
    <TD style="text-align: left" >
    <A HREF="playerstat.php?playerID=<?print rawurlencode($playerID)."&amp;config=$GLOBALS[config]";?>">
    <?print processColors(htmlspecialchars($gplayerName[$playerID]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length']);?>
    </A>
    </TD>
    <TD><?print $kills?></TD>
    <TD><?print $deaths;?></TD>
    <TD><?printf("%02.2f",100*$kills/(0.00001+$kills+$deaths));?></TD>
    </TR>
    <?
    if ($count==$limit)
      break;
  }

  ?>
  </table>
  <!-- prey/enemy  table end ##################################################-->
  <?

  

}
//*************************************************************************
function drawPlayerAwards()
{
  global $db;

  $sql="select awardID,name,category,image,playerName,{$GLOBALS['cfg']['db']['table_prefix']}awards.playerID 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile
          where {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['qplayerID']}
                AND {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID
          order by category,name
       ";
  $rs=$db->Execute($sql);

  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- allawards table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
      <TD COLSPAN=3 WIDTH="100%"  CLASS="cellHeading" style="text-align: left">Awards List</TD>
    </TR>
    <?
    do
    {
      ?>
      <TR CLASS="cellSubHeading">
        <TD COLSPAN="3" WIDTH="100%" style="text-align: left"><?print $rs->fields[2];?></TD>
      </TR>    
      <?
      $count=0;
      do
      {
        $count++;
        if ($count%2 == 1)
          $cell_class="cell1";
        else
          $cell_class="cell2";
        $cat=$rs->fields[2];



        $award_images[]="";
        unset($award_images);
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[3]}".".gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[3]}".".jpg";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[3]}".".png";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.jpg";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.png";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/default/default.gif";
        $award_images[] = "../../games/default/awardsets/default/default.gif";

        $no_of_award_images=count($award_images);
        for($i=0;$i<$no_of_award_images;$i++)
        {
          if (is_file($award_images[$i]))
          {
            $award_image=$award_images[$i];
            break;
          }
        }


        /*
        $award_image="../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[3]}";
        //echo $award_image;
        if (!is_file($award_image))
        {
          $award_image="../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.gif";
        }
        */
        ?>
        <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
          <TD style="text-align: left" width="100%">
            <A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>">
            <?print processColors(htmlspecialchars($rs->fields[1]),$GLOBALS['settings']['display']['color_names'],0);?>
            </A>
          </TD>
          <TD style="text-align: center">
            <A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>">
            <IMG alt="" border=0 name="<?print "AWARD_".$rs->fields[0];?>" src="<?print $award_image;?>"></A>
          </TD>
          
        </TR>
        <?

      }while($rs->MoveNext()  && strcmp($cat,$rs->fields[2])==0);
    
    }while(!$rs->EOF);
    ?>
    </table>
    <!-- allawards table end ##################################################-->
    <BR>
    <?
  }
  
  
  
}
//*************************************************************************
function drawPlayerAwardsCompact()
{
  global $db;

  $sql="select name,image,playerName,category,{$GLOBALS['cfg']['db']['table_prefix']}awards.playerID,awardID 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile
          where {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['qplayerID']}
                AND {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID
          order by category,name
       ";
  $rs=$db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- awards    table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
      <TD COLSPAN="2" WIDTH="100%"  CLASS="cellHeading" style="padding: 2; text-align: center">Awards List</TD>
    </TR>

    <?
    do
    {
      ?>
      <TR>
        <TD COLSPAN="2" WIDTH="100%"  CLASS="cellSubHeading" style="text-align: center "><?print $rs->fields[3];?></TD>
      </TR>    
      <?
      $count=0;
      $count_per_cat=0;
      do
      {
        if ($count%2 == 0)
          $cell_class="cell1";
        else
          $cell_class="cell2";

        $cat=$rs->fields[3];

        $award_images[]="";
        unset($award_images);
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".jpg";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".png";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/default/default.gif";
        $award_images[] = "../../games/default/awardsets/default/default.gif";
        
        $no_of_award_images=count($award_images);
        for($i=0;$i<$no_of_award_images;$i++)
        {
          if (is_file($award_images[$i]))
          {
            $award_image=$award_images[$i];
            break;
          }
        }

          
        if ($count_per_cat%$GLOBALS['settings']['display']['playerstats_max_awards_per_line']==0)
        {
          if ($count_per_cat>0)
          {
            ?>
            &nbsp;
            </TD>
          </TR>
          <?
          }
          $count++;
          ?>
          <TR CLASS="<?print "$cell_class"?>">
            <TD style="text-align: center;">
            <?
        }
        ?>
        <A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[5])."&amp;config=$GLOBALS[config]";?>"><IMG align="middle" alt="" name="<?print "AWARD_".$rs->fields[5];?>" BORDER=0 CLASS="tooltip" TITLE="<?print $rs->fields[0];?>" SRC="<?print $award_image;?>"></A>
        <?

        $count_per_cat++;

      }while($rs->MoveNext() && strcmp($cat,$rs->fields[3])==0);

      if ($count_per_cat>0)
      {
        ?>
        &nbsp;
        </TD>
      </TR>
      <?
      }

    }while(!$rs->EOF);
    
    ?>
    </table>
    <!-- awards    table end ##################################################-->
    <?
  }
}
//*************************************************************************
function drawPlayerAwardsSimple()
{
  global $db;

  $sql="select name,image,playerName,category,{$GLOBALS['cfg']['db']['table_prefix']}awards.playerID,awardID 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile
          where {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['qplayerID']}
                AND {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID
          order by category,name
       ";
  $rs=$db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    ?>Awards: <?
    do
    {

        $cat=$rs->fields[3];

        $award_images[]="";
        unset($award_images);
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".jpg";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/{$rs->fields[1]}".".png";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/{$GLOBALS['cfg']['awardset']}/default.gif";
        $award_images[] = "../../games/{$GLOBALS['cfg']['game']['name']}/awardsets/default/default.gif";
        $award_images[] = "../../games/default/awardsets/default/default.gif";
        
        $no_of_award_images=count($award_images);
        for($i=0;$i<$no_of_award_images;$i++)
        {
          if (is_file($award_images[$i]))
          {
            $award_image=$award_images[$i];
            break;
          }
        }

        ?>
        <A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[5])."&amp;config=$GLOBALS[config]";?>"><IMG align="middle" alt="" name="<?print "AWARD_".$rs->fields[5];?>" BORDER=0 TITLE="<?print $rs->fields[0]." ($cat)";?>" SRC="<?print $award_image;?>"></A>
        <?
    
    }while($rs->MoveNext() && !$rs->EOF);
    
  }
}
//*************************************************************************
function drawPlayerGUIDs()
{
  ?>
  <!-- guid      table begin ##################################################-->
  <form name="guidform" action="index.php?config=<?print $GLOBALS[config];?>" method="post">
  <input type='hidden' name='search_by' value='guid'>
  <input type='hidden' name='search_txt' value=''>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
  <TR>
    <TD COLSPAN=2 WIDTH="100%"  CLASS="cellHeading" style="text-align: center">GUIDs</TD>
  </TR>
  <?

  global $db;
  
  $sql="SELECT dataValue,count(*)
          from {$GLOBALS['cfg']['db']['table_prefix']}playerdata 
          where playerID={$GLOBALS['qplayerID']} 
                AND gameID!=0
                AND dataName='guid'
          group by dataValue
          order by dataValue ASC
       ";
  
  //echo $sql;
  //return;
  $rs = $db->Execute($sql);
  
  
  if ($rs && !$rs->EOF)
  {
    $count=0;
    do
    {
      $count++;
      if ($count%2 == 1)
        $cell_class="cell1";
      else
        $cell_class="cell2";

      if ((strlen($rs->fields[0])>20))
      {
        $guid_display=substr($rs->fields[0],$GLOBALS['settings']['display']['playerstats_guid_start'],$GLOBALS['settings']['display']['playerstats_guid_length']);
      }
      else
      {
        $guid_display=$rs->fields[0];
      }

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
        <TD style="text-align: left"><A HREF="javascript:searchByGUID('<?print $rs->fields[0];?>');" TITLE="<?print $rs->fields[0];?>"><?print $guid_display?></A></TD>
        <TD><?print fstr($rs->fields[1]);?></TD>
      </TR>
      <?
   
    }while($rs->MoveNext());
    
  }
  ?>
  </table>
  </form> 
  <!-- guid      table end ##################################################-->
  <?

}
//*************************************************************************
function drawPlayerIPs()
{
  ?>
  <!-- ip        table begin ##################################################-->
  <form name="ipform" action="index.php?config=<?print $GLOBALS[config];?>" method="post">
  <input type='hidden' name='search_by' value='ip'>
  <input type='hidden' name='search_txt' value=''>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
  <TR>
    <TD COLSPAN=2 WIDTH="100%"  CLASS="cellHeading" style="text-align: center">IPs</TD>
  </TR>
  
  <?

  global $db;
  
  $sql="SELECT dataValue,count(*)
          from {$GLOBALS['cfg']['db']['table_prefix']}playerdata 
          where playerID={$GLOBALS['qplayerID']} 
                AND gameID!=0
                AND dataName='ip'
          group by dataValue
          order by dataValue ASC
       ";
  
  //echo $sql;
  //return;
  $rs = $db->Execute($sql);
  
  
  if ($rs && !$rs->EOF)
  {
    $count=0;
    do
    {
      $count++;
      if ($count%2 == 1)
        $cell_class="cell1";
      else
        $cell_class="cell2";

      preg_match("/(\d+\\.\d+\\.)\d+\\.\d+/", $rs->fields[0], $ma);
      $ip=$ma[1].'?.?';
      //$ip=$rs->fields[0]
      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
        <TD style="text-align: left"> 
          <A href="javascript:searchByIP('<?print $ma[1];?>');"><?print $ip;?></A>
        </TD>
        <TD><?print fstr($rs->fields[1]);?></TD>
      </TR>
      <?
   
    }while($rs->MoveNext());
    
  }
  ?>
  
  </table>
  </form> 
  <!-- ip        table end ##################################################-->
  <?

}
//*************************************************************************
function drawPlayerAliases()
{
  global $db;
  ?>
  <!-- alias     table begin ##################################################-->
  <form name="nameform" action="index.php?config=<?print $GLOBALS[config];?>" method="post">
  <input type='hidden' name='search_by' value='name'>
  <input type='hidden' name='search_txt' value=''>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
  <TR>
    <TD COLSPAN=2 WIDTH="100%"  CLASS="cellHeading" style="text-align: center">Alias List</TD>
  </TR>
  <?

  
  $sql="SELECT dataValue,count(*) as num
          from {$GLOBALS['cfg']['db']['table_prefix']}playerdata 
          where playerID={$GLOBALS['qplayerID']} 
                AND gameID!=0
                AND dataName='alias'
          group by dataValue
          order by num DESC,dataValue ASC
       ";
  
  //echo $sql;
  //return;
  $rs = $db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    $count=0;
    do
    {
      $count++;
      if ($count%2 == 1)
        $cell_class="cell1";
      else
        $cell_class="cell2";

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
        <TD style="text-align: left">
        <A href="javascript:searchByName('<?print processColors(addslashes($rs->fields[0]),0,0);?>');"<?print processColors(htmlspecialchars($rs->fields[0]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length'],1);?></A></TD>
        <TD><?print ($rs->fields[1]);?></TD>
      </TR>
      <?
   
    }while($rs->MoveNext());
    
  }

  ?>
  </table>
  </form>
  <!-- alias     table end ##################################################-->
  <?

}
//*************************************************************************
function drawPlayerData()
{
  global $player_data;
  global $player_data_0;
  
  $player_data_0['quote'] = $player_data['quote'];
  $player_data_0['playerName'] = $player_data['playerName'];
  $player_data_0['icon'] = $player_data['icon'];
  $player_data_0['role'] = $player_data['role'];
  $player_data_0['team'] = $player_data['team'];
  
  unset ($player_data['quote']);
  unset ($player_data['playerName']);
  unset ($player_data['icon']);
  unset ($player_data['role']);
  unset ($player_data['team']);
  
  
  if (is_array($player_data))
  {
    ?>
    <!-- playerdatatable begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
      <TD COLSPAN="2" CLASS="cellHeading" style="padding: 2; text-align: center">General Stats</TD>
    </TR>

    <?
      $role_images[]="";
      unset($role_images);

      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/$player_data_0[team]/$player_data_0[role].gif";
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/$player_data_0[team]/$player_data_0[role].jpg";
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/$player_data_0[team]/$player_data_0[role].png";
      
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/default/default.gif";
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/default/default.jpg";
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/{$GLOBALS['cfg']['roleset']}/default/default.png";
      $role_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/rolesets/default/default/default.gif";
      $role_images[]="../../games/default/rolesets/default/default/default.gif";

      $no_of_role_images=count($role_images);
      for($i=0;$i<$no_of_role_images;$i++)
      {
        if (is_file($role_images[$i]))
        {
          $role_image=$role_images[$i];
          break;
        }
      }

    ?>
    <TR CLASS="cellSubHeading">
      <TD COLSPAN="2" style="text-align: center; padding: 0; ">
        <IMG alt="" name="ROLE" src="<? print $role_image; ?>"> 
      </TD>
    </TR>    

    
    <?


    $count=0;
    $categoryi='';
    foreach($player_data as $data_var => $data_val)
    {
      if (preg_match("/(.*)\\|(.*)/", $data_var, $ma))
      {
        $categoryi_new=$ma[1];
        $data_var=$ma[2];
      }
      else
      {
        $categoryi_new='';
      }

      if (strcmp($categoryi_new,$categoryi))
      {
        ?>
        <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
          <TD colspan=2 CLASS="cellSubheading" style="text-align: left"><?print fstr($categoryi_new);?></TD>
        </TR>
        <?
        $categoryi=$categoryi_new;
      }
      
      $count++;
      if ($count%2 == 1)
        $cell_class="cell1";
      else
        $cell_class="cell2";

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
        <TD style="text-align: left"><?print fstr($data_var);?></TD>
        <TD><?print $data_val;?></TD>
      </TR>
      <?
    }
    ?>

    </table>
    <!-- playerdatatable end ##################################################-->
    <?
  }


}
//*************************************************************************
function readPlayerData()
{
  global $db,$player_data;


  global $gicon;
  



  $sql = "SELECT dataName,dataValue
            FROM {$GLOBALS['cfg']['db']['table_prefix']}playerdata
            WHERE {$GLOBALS['cfg']['db']['table_prefix']}playerdata.playerID={$GLOBALS['qplayerID']}
                  AND gameID=0
                  AND dataNo=0
            ORDER BY dataName
         ";

  $rs=$db->Execute($sql);
  
  //if (!$rs || $rs->EOF)
  //  return;
  
  $player_data=$rs->GetAssoc();


  if (!isset($player_data['quote']))
    $player_data['quote']="";




  
  $player_data['team']="default";
  $player_data['role']="default";
  $player_data['icon']="default";
  $icon_count_max=0;
  
  if (isset($gicon))
  {
    foreach ($gicon[$GLOBALS['playerID']] as $teamIDi => $teamIDi_val)
    {
      foreach ($teamIDi_val as $rolei => $rolei_val)
      {
        foreach ($rolei_val as $iconi => $iconi_val)
        {
          if ($iconi_val>$icon_count_max)
          {
            $icon_count_max=$iconi_val;
            $player_data['icon']=$iconi;
            $player_data['role']=$rolei;
            $player_data['team']=$teamIDi;

          }
        }
      }
    }
  }
  
  if (strlen($player_data['team'])<1)
    $player_data['team']='default';
  if (strlen($player_data['role'])<1)
    $player_data['role']='default';
  if (strlen($player_data['icon'])<1)
    $player_data['icon']='default';


  //htmlprint_r($gicon);
  //echo $player_data['team']." => ".$player_data['role']." => ".$player_data['icon'];
  


  $sql = "SELECT playerName,skill,kills,deaths,kill_streak,death_streak,games
            FROM {$GLOBALS['cfg']['db']['table_prefix']}playerprofile
            where {$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID={$GLOBALS['qplayerID']}
         ";

  $rs=$db->Execute($sql);
  
  $player_data['playerName']=$rs->fields[0];
  $player_data['skill']=$rs->fields[1];
  $player_data['games']=$rs->fields[6];
  $player_data['kills']=$rs->fields[2];
  $player_data['deaths']=$rs->fields[3];
  $player_data['kill_streak']=$rs->fields[4];
  $player_data['death_streak']=$rs->fields[5];
  
  $player_data['kills:game']=round($player_data['kills']/$player_data['games'],2);
  $player_data['kills:death']=round($player_data['kills']/(1+$player_data['deaths']),2);

}
//*************************************************************************
function drawProfile()
{
  global $db,$player_data,$player_data_0;

  ?>
  <!-- profile table start ##################################################-->
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
    <TD COLSPAN="2" CLASS="cellHeading" style="text-align: right">
    &nbsp;
    </TD>
    </TR>
    <TR CLASS="cell1">
    <TD WIDTH="100%" style="vertical-align: top; text-align: left">
      <font size="+1"><? print processColors(htmlspecialchars($player_data_0['playerName']),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length_big']) ?></font><BR><BR>
      <? 
      if ($GLOBALS['settings']['display']['quotes']!=0 && strlen($player_data_0['quote'])>0) 
      {
        print "&nbsp;&nbsp;&nbsp;- \" ".processColors(htmlspecialchars($player_data_0['quote']),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length_big'])." \"";
      }
      ?>
    </TD>
    
    <?

    $icon_images[]="";
    unset($icon_images);
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/$player_data_0[team]/$player_data_0[role]/".stripIllegalFilenameChars($player_data_0['icon'],"\\/").".gif";
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/$player_data_0[team]/$player_data_0[role]/".stripIllegalFilenameChars($player_data_0['icon'],"\\/").".jpg";
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/$player_data_0[team]/$player_data_0[role]/".stripIllegalFilenameChars($player_data_0['icon'],"\\/").".png";

    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/default/default/default.gif";
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/default/default/default.jpg";    
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/{$GLOBALS['cfg']['iconset']}/default/default/default.png";
    
    $icon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/iconsets/default/default/default/default.gif";
    $icon_images[]="../../games/default/iconsets/default/default/default/default.gif";
    
    $no_of_icon_images=count($icon_images);
    for($i=0;$i<$no_of_icon_images;$i++)
    {
      if (is_file($icon_images[$i]))
      {
        $icon_image=$icon_images[$i];
        break;
      }
    }
    //echo $icon_image;
    ?>
    <TD style="text-align: center; vertical-align: bottom; ">
      <img alt="" name="ICON" src="<? print $icon_image; ?>">
    </TD>

    </TR>

  </table>
  <!-- profile table end ##################################################-->
  <?
}
//*************************************************************************
function drawHitbox()
{
    //print_r($GLOBALS['g_hitbox']);
    ksort($GLOBALS['g_hitbox']);
    $hitbox_param="";
    foreach ($GLOBALS['g_hitbox'] as $loc => $val)
      $hitbox_param.="H[$loc]"."="."$val&amp;";
    //echo $hitbox_param;
    ?>
    
    <!-- hitbox    table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 width="100%">

      <TR>
        <TD COLSPAN="2" CLASS="cellHeading" style="text-align: center">Hitbox</TD>
      </TR>

      <?
      if (extension_loaded('gd'))
      {
        ?>
        <TR CLASS="cellSubHeading">
          <TD style="text-align: center; padding: 0;"><IMG alt="" name="HITBOX" src="./hitbox.php?<?echo $hitbox_param;?>"></TD>
        </TR>
        <?
      }
      ?>
    </table>
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 width="100%" class="sortable" id="hitbox">  
    <TR CLASS="cellSubHeading">          
      <TD style="text-align: left; ">Location</TD>
      <TD style="text-align: right;" sortdir="down">Hits</TD>
      <TD style="text-align: right;" sortdir="none">%</TD>      
    </TR>

      <?
      foreach ($GLOBALS['g_hitbox'] as $loc => $val)
      {
        if ($loc=='ALL')
          continue;
        $count++;
        if ($count%2 == 1)
          $cell_class="cell1";
        else
          $cell_class="cell2";
        ?>
        <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >          
          <TD style="text-align: left;"><?echo ucfirst($loc);?></TD>
          <TD style="text-align: right;"><?echo $val;?></TD>
          <TD style="text-align: right;"><?printf("%02d",(($val/$GLOBALS['g_hitbox']['ALL'])*100));?></TD>
        </TR>
        <?
      }
      ?>
    </table>
    <!-- hitbox    table end ##################################################-->
    <?

}
//*************************************************************************
function drawGamesList()
{
  global $ggame;
  global $start_from;
  $start_from=0;
  global $db;

  if (count($ggame)==0)
    return;

  ?>
  <!-- gamestats table begin ##################################################-->
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
    <TD COLSPAN="2" CLASS="cellHeading" style="text-align: center; padding-left: 20; padding-right: 20">Games List (last <?echo $GLOBALS['cfg']['display']['record_limit'];?>)</TD>
    </TR>



    <TR CLASS="cellSubHeading">
    <TD COLSPAN=2 style="text-align: center">Time, Map</TD>
    </TR>

  <?

  ksort($ggame);
  $ggame=array_reverse($ggame);
  
  
  $count=0;
  foreach($ggame as $gID => $val)
  {
    $sql="select name,value 
            from {$GLOBALS['cfg']['db']['table_prefix']}gamedata
            where gameID=$gID
                  AND
                  (name='_v_time_start'
                   OR name='_v_map'
                  )
            ORDER BY name DESC
         ";
    //echo $sql;

    $rs=$db->Execute($sql);

    $time_start=$rs->fields[1];
    $rs->MoveNext();
    //$map=substr($rs->fields[1],0,$GLOBALS['settings']['display']['max_char_length_small']);
    $map=$rs->fields[1];
    
    $count++;
    if ($count%2 == 1)
      $cell_class="cell1";
    else
      $cell_class="cell2";

    ?>
    <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
    <TD style="border-right-width: 0; "><?print $count;?></TD>
    <TD style="text-align: left; border-left-width: 0;">
    <A CLASS="tooltip" TITLE="<?print "$time_start, $map"?>" HREF="gamestat.php?gameID=<?print $gID."&amp;config=$GLOBALS[config]";?>">
    <?
      print substr($time_start,5,5).", ".processColors(htmlentities($rs->fields[1]),0,$GLOBALS['settings']['display']['max_char_length_small']);
    ?>
    </A>
    </TD>
    </TR>
    <?
    if ($count >= $GLOBALS['cfg']['display']['record_limit'])
      break;

  }

  ?>
  </table>
  <!-- gamestats table end ##################################################-->
  <?


}
//*************************************************************************
function drawWeaponStats()
{
  include("../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$GLOBALS['cfg']['weaponset']}-weapons.php");
  global $gmatrix,$gmatrixtotal,$gweapon;
  global $db;
  
  ?>
  <!-- weaponstats table begin ##################################################-->
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=1 WIDTH="100%" class="sortable" id="weaponstats">
    <TR CLASS="cellSubHeading">
    <TD style="text-align: left;">Weapon</TD>
    <TD WIDTH="10%" sortdir="down">Kills</TD>
    <TD WIDTH="10%">Deaths</TD>
    <TD WIDTH="10%">Suicides</TD>
    <TD WIDTH="10%">Eff %</TD>
    <? 
    if (isset($GLOBALS['g_hitbox']))
    {
      ?>
      <TD WIDTH="10%">Hits</TD>
      <TD WIDTH="10%">Shots</TD>
      <TD WIDTH="10%">Misses</TD>
      <TD WIDTH="10%">Acc %</TD>
      <?
    }
    ?>
    <TD WIDTH="1%" style="text-align: center;" sortdir="none">&nbsp;</TD>
    </TR>
  <?
  
  $count=0;
  //htmlprint_r($gmatrixtotal);
  foreach($gweapon as $weapon => $val)
  {
      $count++;
      if ($count%2 == 1)
        $cell_class="cell1";
      else
        $cell_class="cell2";
  
      $kills=0+$gmatrixtotal['_v_player'][$weapon]['kills'];
      $deaths=0+$gmatrixtotal['_v_player'][$weapon]['deaths'];
      $suicides=0+$gmatrixtotal['_v_player'][$weapon]['suicides'];

      $hits=0+$gmatrixtotal['_v_player'][$weapon]['hits'];
      $shots=0+$gmatrixtotal['_v_player'][$weapon]['shots'];


      if (isset($GLOBALS['weaponset'][$weapon]['name']))
        $weapon_name=$GLOBALS['weaponset'][$weapon]['name'];
      else
        $weapon_name=fstr($weapon);

      ?>


      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
      
      <?
      $weapon_images[]="";
      unset($weapon_images);
      if (isset($GLOBALS['weaponset'][$weapon]['image']))
      {
        $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$GLOBALS['weaponset'][$weapon]['image']}";
      }
      else
      {
        //echo $weapon;
        $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$weapon}.gif";
        $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$weapon}.jpg";
        $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg']['weaponset']}/{$weapon}.png";
      }

      $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg'][weaponset]}/default.gif";
      $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg'][weaponset]}/default.jpg";
      $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/{$GLOBALS['cfg'][weaponset]}/default.png";

      $weapon_images[]="../../games/{$GLOBALS['cfg']['game']['name']}/weaponsets/default/default.gif";
      $weapon_images[]="../../games/default/weaponsets/default/default.gif";

      $no_of_weapon_images=count($weapon_images);
      for($i=0;$i<$no_of_weapon_images;$i++)
      {
        //echo $weapon_images[$i];
        if (is_file($weapon_images[$i]))
        {
          $weapon_image=$weapon_images[$i];
          break;
        }
      }
      //echo $weapon_image;
      ?>

      <TD style="text-align: left  "><?print $weapon_name;?></TD>
      <TD><?print $kills;?></TD>
      <TD><?print $deaths;?></TD>
      <TD><?print $suicides;?></TD>
      <TD><?printf("%02.2f",100*$kills/(0.00001+$kills+$deaths));?></TD>
      <? 
      if (isset($GLOBALS['g_hitbox']))
      {
        ?>
        <TD><?print $hits;?></TD>
        <TD><?print $shots;?></TD>
        <TD><?print $shots-$hits;?></TD>
        <TD><?printf("%02.2f",100*$hits/(0.00001+$shots));?></TD>
        <?
      }
      ?>
      <TD style="text-align: center"><IMG align="middle" alt="" src="<? print $weapon_image; ?>"></TD>
      </TR>
      <?

  }
  

  $kills=0+$gmatrixtotal['_v_player']['_v_weapon']['kills'];
  $deaths=0+$gmatrixtotal['_v_player']['_v_weapon']['deaths'];
  $suicides=0+$gmatrixtotal['_v_player']['_v_weapon']['suicides'];

  $hits=0+$gmatrixtotal['_v_player']['_v_weapon']['hits'];
  $shots=0+$gmatrixtotal['_v_player']['_v_weapon']['shots'];

  ?>



  <TR CLASS="cellSubHeading" sortbottom="1">
  <TD style="text-align: left;">Total</TD>
  <TD><?print $kills;?></TD>
  <TD><?print $deaths;?></TD>
  <TD><?print $suicides;?></TD>
  <TD><?printf("%02.2f",100*$kills/(0.00001+$kills+$deaths));?></TD>
  <? 
  if (isset($GLOBALS['g_hitbox']))
  {
    ?>
    <TD><?print $hits;?></TD>
    <TD><?print $shots;?></TD>
    <TD><?print $shots-$hits;?></TD>
    <TD><?printf("%02.2f",100*$hits/(0.00001+$shots));?></TD>
    <?
  }
  ?>
  <TD style="text-align: center;">&nbsp;</TD>
  </TR>


  </table>
  <!-- weaponstats table end ##################################################-->
  <?
  
  
  
}
//*************************************************************************


?>

<!-- layout table begin ##################################################-->
<table style="border-width: 2; border-spacing: 0; padding: 0 0 0 0; margin: 0 0 0 0;" CELLSPACING="0" CELLPADDING="0" WIDTH="100%">

<TR>
  <TD style="vertical-align: top; padding: 0;" COLSPAN=3 CLASS="cellBG">
    <? drawMainHeading(); ?>
  </TD>
</TR>

<TR>
  <TD COLSPAN=3 style="border-width: 0; padding: 0; ">
    <? drawMenu(); ?>
  </TD>
</TR>

<TR>
  <TD style="vertical-align: top; padding: 10px 10px 10px 10px; border-width: 0 0 0 0;" COLSPAN=3 CLASS="cellBG">
    <?
    drawHeadBar();
    ?>
  </TD>
</TR>


<TR>
      <td CLASS="cellBG" style="vertical-align: top; padding: 0px 10px 10px 10px; border-width: 0 0 0 0;">
          <?drawPlayerData();?><BR>
          <?//drawPlayerAwardsCompact();?><!--<BR>-->
          <?drawPlayerAliases();?><BR>
          <?drawPlayerGUIDs();?><BR>
          <?drawPlayerIPs();?><BR>
      </td>

      <td CLASS="cellBG" style="vertical-align: top; padding: 0px 0 10px 0; border-width: 0 0 0 0;" WIDTH="100%" >
        <? 
          //echo $GLOBALS['playerID'];
          drawProfile();?><BR><?
          drawPlayerAwards();
          drawPlayerStats();    
          
        ?>
        
        <!--#######################-->
        <table style="padding: 0 0 0 0; border-width: 0 0 0 0;" CELLSPACING="0" CELLPADDING="0" WIDTH="100%">
        <tr>
          <td width="50%" style="vertical-align: top; border-width: 0 0 0 0; padding: 0 5px 0 0;">
            <?
            drawPreyOrEnemyList("prey",25);
            ?>
          </td>
          <td width="50%" style="vertical-align: top; border-width: 0 0 0 0; padding: 0 0 0px 5px;">
            <?
            drawPreyOrEnemyList("enemy",25);
            ?>
          </td>
        </tr>
        </table>
        <!--#######################-->
      </td>


      <td CLASS="cellBG" style="vertical-align: top; padding: 0px 10px 10px 10px; border-width: 0 0 0 0;">

      <?
        if (isset($GLOBALS['g_hitbox']) && count($GLOBALS['g_hitbox'])>1)
        {
           drawHitbox();
           ?><BR><?
        }
      ?>
        
      <? 
        if ($GLOBALS['settings']['display']['gamestats']) 
          drawGamesList();
      ?>
      
      </td>



</TR>

<TR>
  <TD COLSPAN=3 style="vertical-align: top; padding: 0 0 0 0; border-width: 0 0 0 0;" CLASS="cellBG">
    <?
    drawCredits();
    ?>
  </TD>
</TR>

</table>
<!-- layout table end ##################################################-->
<?

if ($settings['display']['javascript_tooltips'])
{
  ?>
  <script type="text/javascript">domTT_replaceTitles();</script>
  <?
}
ob_end_flush(); // flush after compactHTML
echo "<center>page loaded in ".timeElapsed($start_time)."s (".$pre_time."s)</center>";
?>
</BODY>
</HTML>