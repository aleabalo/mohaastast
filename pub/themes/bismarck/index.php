<?php
$start_time=gettimeofday();

//******************************************************************************
require("./util.php");
require("./all.inc.php");
require(getConfig());
require("{$GLOBALS['cfg']['db']['adodb_path']}".'adodb.inc.php');

setSkin();


//htmlprint_r($GLOBALS);
//******************************************************************************
function drawHeadBar()
{
  global $sort,$config;
  ?>
  <!-- navbar begin          ################################################-->
  <table CLASS="cellHeading" CELLSPACING="0" CELLPADDING="1" WIDTH="100%" style="border-width: 0;">
    <TR>
    <TD HEIGHT="25" CLASS="cellHeading" style="border-right-width: 0; text-align: left;" >
      <B>Player Stats</B> &nbsp;<? if (isset($_POST['search_by'])) echo " ( search results for {$_POST['search_by']} = {$_POST['search_txt']} )"; ?>
    </TD>
    

    <TD CLASS="cellHeading" style="border-left-width: 0; text-align: right;" >
      <!-- search form begin     ################################################-->
      <form style="display:inline" method="post" action="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort"; ?>">

      <select style="text-align: center;" name="search_by" size="1" class="cellSubHeading">
        <option <?if (isset($_POST['search_by']) && $_POST['search_by']=='name') echo "selected";?> style="text-align: center;" class="cellSubHeading" value="name" >search by player name</option>
        <option <?if (isset($_POST['search_by']) && $_POST['search_by']=='guid') echo "selected";?> style="text-align: center;" class="cellSubHeading" value="guid" >search by player GUID</option>
        <option <?if (isset($_POST['search_by']) && $_POST['search_by']=='ip')   echo "selected";?> style="text-align: center;" class="cellSubHeading" value="ip"   >search by player IP</option>
        <option <?if (isset($_POST['search_by']) && $_POST['search_by']=='id')   echo "selected";?> style="text-align: center;" class="cellSubHeading" value="id"   >search by player ID</option>
      </select> 

      <input CLASS="cellSubHeading" style="text-align: center; border-width: 1"   type="Text"   name="search_txt" size="20">
      <input CLASS="cellSubHeading" style="text-align: center; border-width: 1" type="Submit" name="search_btn" value="&nbsp;search&nbsp;">
      <input type="hidden" name="sort_by" value="$sort_by">
      </form>
      <!-- search form end       ################################################-->
    </TD>

    </TR>
  </table>
  <!-- navbar end            ################################################-->
  <?
}
//******************************************************************************
function drawRandomQuotes($in_no)
{
  global $db;
  
  /*
  $sql="select count(playerID) 
          from {$GLOBALS['cfg']['db']['table_prefix']}playerdata 
          where dataName='quote'
       ";
  $rs=$db->Execute($sql);
  $quote_total=$rs->fields[0];
  mt_srand();
  $quote_random_no=mt_rand(0, $quote_total-$in_no);
  */
  
  //echo $quote_random_no;
  
  $sql="select playerName,{$GLOBALS['cfg']['db']['table_prefix']}playerdata.playerID,dataValue
          from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile,{$GLOBALS['cfg']['db']['table_prefix']}playerdata
          where dataName='quote' 
                AND {$GLOBALS['cfg']['db']['table_prefix']}playerdata.playerID={$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID
          ORDER BY RAND()
       ";
  //echo $sql;
  $rs=$db->SelectLimit($sql,$in_no,0);
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- quote     table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
      <TR>
      <TD COLSPAN="2" CLASS="cellHeading" style="text-align: center">Random Quote(s)</TD>
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
        ?>
        <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
        <TD style="text-align: right">
        <A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[1])."&amp;config=$GLOBALS[config]";?>"
        <?print processColors(htmlentities($rs->fields[0]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length'],1);?></A>
        </TD>
        <TD WIDTH="100%" style="text-align: left">"&nbsp;<?print processColors(htmlentities($rs->fields[2]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length_big']);?>&nbsp;"</TD>
        </TR>
        <?
      } while ($rs->MoveNext());
    ?>
    </table>
    <!-- quote     table end ##################################################-->
    <BR>
    <?
  }

}
//******************************************************************************
function drawPlayersList()
{
  global $db,$start_from,$config,$sort;

  $sql = "select STD(games) from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile";
  $rs=$db->Execute($sql);
  $avg_games=$rs->fields[0];
            

  if ($GLOBALS['settings']['display']['playerlist_conditions'])
  {
    $sql="select playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
            from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile 
            where {$GLOBALS['settings']['display']['playerlist_conditions']}
            order by {$GLOBALS['sort']} {$GLOBALS['order']}
         ";
  }
  else
  {
    $sql="select playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
            from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile
            order by {$GLOBALS['sort']} {$GLOBALS['order']}
         ";
  }
  //echo $sql;
  if (isset($_POST['search_txt']) || isset($_POST['search_btn']))
  {

    $search_txt=$_POST['search_txt'];
    if (get_magic_quotes_gpc())
      $search_txt=stripslashes($search_txt);

     

    if ($_POST['search_by']=='name')
    {
      //echo $search_txt."<BR>";
      $search_txt=preg_replace("/(.)/e", "'(`#[0-9a-fA-F]{6})*'.preg_quote(preg_quote('\\1','\''),'\'')", $search_txt);
      //echo $search_txt."<BR>";

      $sql="select distinct PP.playerID as playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
              from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP,{$GLOBALS['cfg']['db']['table_prefix']}playerdata as PD
              where dataName='alias' 
                AND dataValue REGEXP '$search_txt'
                AND PP.playerID=PD.playerID
              order by {$GLOBALS['sort']} {$GLOBALS['order']}
           ";
      //echo $sql;
    }
    else if ($_POST['search_by']=='id')
    {
      $qsearch_txt=$db->qstr('%'.$search_txt.'%');
      
      //echo $qsearch_txt;
      $sql="select playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
              from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile
              where playerID LIKE $qsearch_txt
              order by {$GLOBALS['sort']} {$GLOBALS['order']}
           ";
    }
    else if ($_POST['search_by']=='ip')
    {
      $search_txt_full=$search_txt;
      
      // only allow to search on first two groups in ip
      $search_txt='127.';
      if (preg_match("/^(\d{1,3}(\\.\d{1,3})?)/", $search_txt_full, $ma))
        $search_txt=$ma[1];
      //echo $search_txt;
      
      $sql="select distinct PP.playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
              from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP,{$GLOBALS['cfg']['db']['table_prefix']}playerdata as PD
              where dataName='ip' and dataValue LIKE \"$search_txt%\" and PP.playerID=PD.playerID
              order by {$GLOBALS['sort']} {$GLOBALS['order']}
           ";
      //echo $sql;
    }
    else if ($_POST['search_by']=='guid')
    {
      $search_txt_full=$search_txt;
      
      $sql="select distinct PP.playerID,playerName,skill as skill,kills,deaths,kill_streak,death_streak,games 
              from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP,{$GLOBALS['cfg']['db']['table_prefix']}playerdata as PD
              where dataName='guid' and dataValue LIKE \"%$search_txt%\" and PP.playerID=PD.playerID
              order by {$GLOBALS['sort']} {$GLOBALS['order']}
           ";
      //echo $sql;
    }

  }  
  
  
  $rs=$db->SelectLimit($sql,$GLOBALS['cfg']['display']['record_limit'],$GLOBALS['start_from']);
  
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- mainstats table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
      <TR>

        <TD CLASS="cellHeading" WIDTH="100%" COLSPAN="5" style="text-align: left; border-right: 0">
        Player Listing
        </TD>

        <TD CLASS="cellHeading" COLSPAN="6" style="text-align: left; border-left: 0">

          <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
            <TR>
              <TD WIDTH="100%" CLASS="cellHeading" style="border-width: 0; text-align: right">
                &nbsp;
              </TD>
              <TD CLASS="cellSubHeading" style="text-align: right">&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from=0"; ?>">first</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['total_records']}"; ?>">last</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['prev']}"; ?>">prev</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['next']}"; ?>">next</A>&nbsp;</TD>            
            </TR>
          </table>
        </TD>

      </TR>

      <TR CLASS="cellSubHeading">
      <TD WIDTH="3%">
        #
      </TD>


      <? 
      if (isset($_POST['search_by']) && $_POST['search_by']=='id')
      {
      
        ?>
        <TD WIDTH="25%" style="text-align: left  ">
          <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=playerID&amp;order=ASC";?>" CLASS="tooltip" TITLE="Sort by Player ID">ID</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=playerID&amp;order=DESC";?>" CLASS="tooltip" TITLE="DESCENDING order">-</A>
        </TD>
        <?
      
      }
      else
      {
        ?>      
        <TD WIDTH="25%" style="text-align: left  ">
          <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=playerName&amp;order=ASC";?>" CLASS="tooltip" TITLE="Sort by Player Name">Name</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=playerName&amp;order=DESC";?>" CLASS="tooltip" TITLE="DESCENDING order">-</A>
        </TD>
        <?      
      }
      ?>
      
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kills&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Kills">Kills</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kills&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=deaths&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Deaths">Deaths</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=deaths&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=efficiency&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Efficiency [(Kills / (1+Kills+Deaths)) x 100]">Eff%</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=efficiency&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kill_streak&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Kill Streak">KS</a>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kill_streak&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=death_streak&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Death Streak">DS</a>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=death_streak&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kd&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Kills per Death">K:D</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kd&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+ </A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kg&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Kills per Game">K:G</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=kg&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=games&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Games Played">Games</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=games&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
      <TD WIDTH="8%">
        <A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=skill&amp;order=DESC";?>" CLASS="tooltip" TITLE="Sort by Skill">Skill</A>&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]&amp;sort=skill&amp;order=ASC";?>" CLASS="tooltip" TITLE="ASCENDING order">+</A>
      </TD>
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

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
      <TD><?print $GLOBALS['start_from']+$count;?></TD>


      <? 
      if (isset($_POST['search_by']) && $_POST['search_by']=='id')
      {
        ?>
        <TD style="text-align: left  "><A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>"><?print (htmlentities($rs->fields[0]));?></A></TD>
        <?
      }
      else
      {
        ?>
        <TD style="text-align: left  "><A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>"<?print processColors(htmlentities($rs->fields[1]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length'],1);?></A></TD>
        <?
      }
      ?>



      <TD><?print $rs->fields[3];?></TD>
      <TD><?print $rs->fields[4];?></TD>

      <TD><?printf("%0.2f",100*$rs->fields[3]/(1+$rs->fields[3]+$rs->fields[4]));?>%</TD>

      <TD><?print $rs->fields[5];?></TD>
      <TD><?print $rs->fields[6];?></TD>

      <TD><?printf("%0.2f",$rs->fields[3]/(1+$rs->fields[4]));?></TD>
      <TD><?printf("%0.2f",$rs->fields[3]/(1+$rs->fields[7]));?></TD>

      <TD><?print $rs->fields[7];?></TD>

      <TD><?printf("%d",$rs->fields[2]);?></TD>

      </TR>
      <?
      
    }while ($rs->MoveNext());


    ?>




  <TR>
    
    <TD colspan="11" CLASS="cellHeading" style="border-width: 0; border-left-width: 0; border-right-width: 0; text-align: left" width="100%">

      <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
        <TR>
         <TD WIDTH="100%" style="border-width: 0; text-align: left">
          <!-- goto   form begin     ################################################-->
          <form style="display:inline" method="post" action="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort"; ?>">
          <input CLASS="cellSubHeading" style="text-align: center; border-width: 1" type="Submit" name="goto_btn" value="&nbsp;goto #&nbsp;">&nbsp;<input CLASS="cellSubHeading" style="text-align: center; border-width: 1"   type="Text"   name="goto_txt" size="10">
          <input type="hidden" name="sort_by" value="$sort_by">
          </form>
          <!-- goto   form end       ################################################-->
        </TD>

        <TD CLASS="cellSubHeading" style="text-align: right">&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from=0"; ?>">first</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['total_records']}"; ?>">last</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['prev']}"; ?>">prev</A>&nbsp;|&nbsp;<A HREF="<? print "$_SERVER[PHP_SELF]?config=$config&amp;sort=$sort&amp;start_from={$GLOBALS['next']}"; ?>">next</A>&nbsp;</TD>            

        </TR>
      </table>


    </TD>
  </TR>








    </table>
    <!-- mainstats table end ##################################################-->
    <?
  }
}
//******************************************************************************
function drawAwards()
{
  global $db;

  $sql="select name,image,playerName,category,{$GLOBALS['cfg']['db']['table_prefix']}awards.playerID,awardID 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards,{$GLOBALS['cfg']['db']['table_prefix']}playerprofile
          where {$GLOBALS['cfg']['db']['table_prefix']}awards.playerID={$GLOBALS['cfg']['db']['table_prefix']}playerprofile.playerID
          order by category,name
       ";
  //echo $sql;
  $rs=$db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- awards    table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
      <TD COLSPAN="2" WIDTH="100%"  CLASS="cellHeading" style="text-align: center; padding-left: 50; padding-right: 50;">Awards List</TD>
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
      do
      {
        $count++;
        if ($count%2 == 1)
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

        ?>
        <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
          <TD style="text-align: center "><A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[5])."&amp;config=$GLOBALS[config]";?>"><IMG alt="" name="<?print "AWARD_".$rs->fields[5];?>" BORDER=0 CLASS="tooltip" TITLE="<?print $rs->fields[0];?>" SRC="<?print $award_image;?>"></A></TD>
          <TD WIDTH="100%" style="text-align: left "><A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[4])."&amp;config=$GLOBALS[config]";?>"<?print processColors(htmlspecialchars($rs->fields[2]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length'],1);?></A></TD>
        </TR>
        <?
      }while($rs->MoveNext() && strcmp($cat,$rs->fields[3])==0);
    
    }while(!$rs->EOF);
    
    ?>
    </table>
    <!-- awards    table end ##################################################-->
    <?
  }
}
//******************************************************************************
function drawGamesList()
{
  global $db;


  $sql="select distinct gameID
          from {$GLOBALS['cfg']['db']['table_prefix']}gamedata 
          ORDER BY gameID DESC
       ";
  //echo $sql;
  $rs=$db->SelectLimit($sql,$GLOBALS['cfg']['display']['record_limit']);

  if ($rs && !$rs->EOF)
  {
    $gameID_max = $rs->fields[0];
    $rs->MoveLast();
    $gameID_min = $rs->fields[0];
  }

  $sql="select gameID,value 
          from {$GLOBALS['cfg']['db']['table_prefix']}gamedata 
          where gameID >= $gameID_min
                AND gameID <= $gameID_max
                AND (name='_v_map' OR name='_v_time_start')
          ORDER BY gameID DESC,name ASC
       ";
  //echo $sql;
  $rs=$db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- gamestats table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
      <TR>
      <TD COLSPAN="2" CLASS="cellHeading" style="text-align: center; padding-left: 50; padding-right: 50;">Recent Games</TD>
      </TR>

      <TR>
      <TD COLSPAN="2" CLASS="cellSubHeading" style="text-align: center">Time, Map</TD>
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

      $map=$rs->fields[1];
      $rs->MoveNext();
      $time_start=$rs->fields[1];

      ?>
      <TR CLASS="<?print "$cell_class"?>" onMouseOver="this.className='rowHighlight';" onMouseOut="this.className='<?print "$cell_class"?>';" >
      <TD style="border-right-width: 0; "><?print $count;?></TD>
      <TD style="text-align: left; border-left-width: 0;">
      <A CLASS="tooltip" TITLE="<?print "$time_start, $map"?>" HREF="gamestat.php?gameID=<?print $rs->fields[0]."&amp;config=$GLOBALS[config]";?>">
      <? 
        print substr($time_start,5,11).", ".processColors(htmlentities($map),0,$GLOBALS['settings']['display']['max_char_length_small']); 
      ?>
      </A>
      </TD>
      </TR>
      <?

    }while ($rs->MoveNext());

    ?>
    </table>
    <!-- gamestats table end ##################################################-->
    <?
  }
}
//******************************************************************************
function displayStats()
{
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
      <? drawHeadBar(); ?>
    </TD>
  </TR>


  <TR>
    <?
    if ($GLOBALS['settings']['display']['mini_awardstats_list'])
    {
      ?>
      <TD style="vertical-align: top; padding: 0 0px 10px 10px; border-width: 0 0 0 0;" CLASS="cellBG">
        <? drawAwards(); ?>
      </TD>
      <?
    }
    ?>

    <TD style="vertical-align: top; padding: 0 10px 10px 10px; border-width: 0 0 0 0;" CLASS="cellBG" WIDTH="80%">  
      <? 
        if ($GLOBALS['settings']['display']['quotes']>0)
        {
          drawRandomQuotes($GLOBALS['settings']['display']['quotes']); 
        }
        drawPlayersList(); 
      ?>
    </TD>

    <?
    if ($GLOBALS['settings']['display']['gamestats'] && $GLOBALS['settings']['display']['mini_gamestats_list'])
    {
      ?>
      <TD style="vertical-align: top; padding: 0 10px 10px 0px; border-width: 0 0 0 0;" CLASS="cellBG">
        <? drawGamesList(); ?>
      </TD>
      <?
    }
    ?>




  </TR>

  <TR>
    <TD COLSPAN=3 style="vertical-align: top; padding: 0 0 0 0; border-width: 0 0 0 0;" CLASS="cellBG">
      <?
      drawCredits();
      ?>
    </TD>
  </TR>
  </table>
  <!-- layout table end   ##################################################-->
  <?
}
//******************************************************************************
function setupVars()
{
  global $db,$start_from,$sort,$order,$prev,$next,$total_records;

  $sql="select count(*) 
          from {$GLOBALS['cfg']['db']['table_prefix']}playerprofile
       ";
  $rs=$db->Execute($sql);
  $total_records=$rs->fields[0];

  

  //******************
  if (isset($_POST['goto_btn']) || isset($_POST['goto_txt'])) 
  {
    $start_from=intval($_POST['goto_txt'])-1;
  }
  else if (isset($_GET['start_from']))
  {
    $start_from=$_GET['start_from'];
  }
  
  //********
  // limit checks
  if ($start_from>=$total_records)
  {
    $start_from=$total_records-$GLOBALS['cfg']['display']['record_limit'];
  }
  if (!isset($start_from) || $start_from<0) 
  {
    $start_from=0;
  }
  //********
  //******************
  
  
  //******************
  $next=$start_from+$GLOBALS['cfg']['display']['record_limit'];
  $prev=$start_from-$GLOBALS['cfg']['display']['record_limit'];

  //********
  // limit checks
  if ($prev<0)
    $prev=0;

  if ($next>$total_records)
    $next=$total_records;
  //********
  //******************
  
  if (isset($_GET['order'])) 
    $order=$_GET['order'];
  
  if (!isset($order) || ($order!='ASC' && $order!='DESC'))
    $order='DESC';

  if ($order=='DESC')
    $new_order='ASC';
  else if ($order=='ASC')
    $new_order='DESC';

  if (isset($_GET['sort'])) 
    $sort=$_GET['sort'];
  
  if (!isset($sort) || strstr($sort,";"))
    $sort=$GLOBALS['settings']['display']['default_sort'];
  
  if ($sort=="efficiency")
    $sort="((kills*100)/(1+kills+deaths))";

  if ($sort=="kd")
    $sort="(kills/(1+deaths))";

  if ($sort=="kg")
    $sort="(kills/(1+games))";


  //******************


  if (!is_dir("../../games/{$GLOBALS['cfg']['game']['name']}"))
  {
    $GLOBALS['cfg']['game']['name']='default';
  }

  
}


//******************************************************************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>vsp stats</TITLE>
<meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-1">
<LINK REL=stylesheet HREF="<? print $GLOBALS['stylesheet']; ?>" TYPE="text/css">
<? if ($settings['display']['javascript_tooltips']) includeDOMTT();?>
</HEAD>
<?ob_start("compactHTML");?>
<BODY>
<?
  $db = &ADONewConnection($GLOBALS['cfg']['db']['adodb_driver']);
  if(!$db->Connect($GLOBALS['cfg']['db']['hostname'], $GLOBALS['cfg']['db']['username'], $GLOBALS['cfg']['db']['password'], $GLOBALS['cfg']['db']['dbname']))
  {
    print "error: cannot establish database connection or database {$GLOBALS['cfg']['db']['dbname']} does not exist\n";
    exit();
  }
  //$db->SetFetchMode(ADODB_FETCH_ASSOC);
  $db->SetFetchMode(ADODB_FETCH_NUM);
  setupVars();
  
  displayStats();

  if ($settings['display']['javascript_tooltips'])
  {
    ?>
    <script type="text/javascript">domTT_replaceTitles();</script>
    <?
  }
  $pre_time=timeElapsed($start_time);
  ob_end_flush(); // flush after compactHTML
  echo "<center>page loaded in ".timeElapsed($start_time)."s (".$pre_time."s)</center>";

?>
</BODY>
</HTML>
