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

if (isset($_GET['awardID']))
{
  $awardID=$_GET['awardID'];
  if (get_magic_quotes_gpc())
    $awardID=stripslashes($awardID);
}
else
{
  $sql="select awardID from {$GLOBALS['cfg']['db']['table_prefix']}awards where LENGTH(playerID)>0 order by rand()";
  $rs=$db->SelectLimit($sql,1,0);
  $awardID=$rs->fields[0];
}

$qawardID=$db->qstr($awardID); // awardID quoted for sql


setSkin();
setupVars();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-1">
<TITLE>vsp (award stats)</TITLE>
<LINK REL=stylesheet HREF="<? print $GLOBALS['stylesheet']; ?>" TYPE="text/css">
</HEAD>
<?ob_start("compactHTML");?>
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
      <B>Award Stats</B>
    </TD>
    </TR>
  </table>
  <!-- navbar end            ################################################-->
  <?
}
//*************************************************************************
function drawAllAwards()
{

  global $db;
  
  $sql="SELECT awardID,name,category,image,playerName,A.playerID 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards as A, {$GLOBALS['cfg']['db']['table_prefix']}playerprofile as PP 
          where PP.playerID=A.playerID 
          order by category,name ASC
       ";
  
  //echo $sql;
  $rs = $db->Execute($sql);
  
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- allawards table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
    <TR>
      <TD COLSPAN=3 WIDTH="100%"  CLASS="cellHeading" style="text-align: center">Awards List</TD>
    </TR>
    <?
    do
    {
      ?>
      <TR>
        <TD COLSPAN="3" WIDTH="100%"  CLASS="cellSubHeading" style="text-align: center "><?print $rs->fields[2];?></TD>
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
          <TD style="text-align: center"><A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>"><IMG alt="" border=0 name="<?print "AWARD_".$rs->fields[0];?>" src="<?print $award_image;?>"></A></TD>
          <TD style="text-align: left" width="100%">
            <A HREF="awardstat.php?awardID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>">
            <?print processColors(htmlspecialchars($rs->fields[1]),$GLOBALS['settings']['display']['color_names'],0);?>
            </A>
          </TD>
          <TD style="text-align: center">
            <A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[5])."&amp;config=$GLOBALS[config]";?>">
            <?print processColors(htmlspecialchars($rs->fields[4]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length']);?>
            </A>
          </TD>
        </TR>
        <?

      }while($rs->MoveNext()  && strcmp($cat,$rs->fields[2])==0);
    
    }while(!$rs->EOF);
    ?>
    </table>
    <!-- allawards table end ##################################################-->
    <?
  }

}
//*************************************************************************
function drawAwardList()
{
  global $start_from;
  $start_from=0;
  global $db;
  $sql="select sql,name 
          from {$GLOBALS['cfg']['db']['table_prefix']}awards as A
          where A.awardID = {$GLOBALS['qawardID']}
       ";
  //echo $sql;
  $rs=$db->SelectLimit($sql,1,0);
  
  $award_name = $rs->fields[1];
  
  
  
  $rs=$db->SelectLimit($rs->fields[0],$GLOBALS['cfg']['display']['record_limit'],$GLOBALS['start_from']);
  
  $no_of_cols = count($rs->fields);
  //echo $rs->fields[0];
  if ($rs && !$rs->EOF)
  {
    ?>
    <!-- awardstats table begin ##################################################-->
    <table style="border-width: 0" CELLSPACING=0 CELLPADDING=2 WIDTH="100%">
      <TR>
      <TD CLASS="cellHeading" style="text-align: center" COLSPAN="<? echo $no_of_cols?>">Award Listing for <?echo fstr($award_name);?> (top <?echo $GLOBALS['cfg']['display']['record_limit'];?>) </TD>
      </TR>


      <TR>
      <TD CLASS="cellSubHeading" style="text-align: right">#</TD>
      <TD CLASS="cellSubHeading" style="text-align: left" width="100%">Player Name</TD>
      <?
      for ($i=2;$i<$no_of_cols;$i++)
      {
        $fldi=$rs->FetchField($i);
        ?>
        <TD CLASS="cellSubHeading" style="text-align: center">
        <?print "&nbsp;".fstr($fldi->name)."&nbsp;";?>
        </TD>
        <?
      }
      ?>
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
      <TD><?print "$count"?></TD>

      <TD style="text-align: left" >
      <A HREF="playerstat.php?playerID=<?print rawurlencode($rs->fields[0])."&amp;config=$GLOBALS[config]";?>">
      <?print processColors(htmlspecialchars($rs->fields[1]),$GLOBALS['settings']['display']['color_names'],$GLOBALS['settings']['display']['max_char_length']);?>
      </A>
      </TD>

      <?

      for ($i=2;$i<$no_of_cols;$i++)
      {
        ?>
        <TD style="text-align: center">
        <?print $rs->fields[$i];?>
        </TD>
        <?
      }
      ?>
      </TR>
      <?

    }while ($rs->MoveNext());

    ?>
    </table>
    <!-- awardstats table end ##################################################-->
    <?
  }
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
  <TD style="vertical-align: top; padding: 10px 10px 10px 10px; border-width: 0 0 0 0;" COLSPAN=2 CLASS="cellBG">
    <?
    drawHeadBar();
    ?>
  </TD>
</TR>

<tr>
  <TD style="vertical-align: top; padding: 0px 0 10px 10px; border-width: 0 0 0 0;" CLASS="cellBG">
    <?drawAllAwards();?>
  </td>

  <TD style="vertical-align: top; padding: 0px 10px 10px 10px; border-width: 0 0 0 0;" CLASS="cellBG" WIDTH="100%">
    <? drawAwardList(); ?>
  </td>
</tr>

<TR>
  <TD COLSPAN=2 style="vertical-align: top; padding: 0 0 0 0; border-width: 0 0 0 0;" CLASS="cellBG">
    <?
    drawCredits();
    ?>
  </TD>
</TR>

</table>
<!-- layout table end ##################################################-->
<?
$pre_time=timeElapsed($start_time);
ob_end_flush(); // flush after compactHTML
echo "<center>page loaded in ".timeElapsed($start_time)."s (".$pre_time."s)</center>";
?>

</BODY>
</HTML>


