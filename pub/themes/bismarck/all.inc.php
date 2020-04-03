<?
runAlways();
//******************************************************************************
function runAlways()
{
  define("cROOT_PATH",realpath(dirname(realpath(__FILE__))."/../../"));

  require("./settings.php");
  error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

  if (isset($GLOBALS['cfg']['db']['adodb_path']))
  {
    $GLOBALS['cfg']['db']['adodb_path']=fixPath($GLOBALS['cfg']['db']['adodb_path']);
  }
  else
  {
    //$GLOBALS['cfg']['db']['adodb_path']=fixPath(dirname($_SERVER['SCRIPT_FILENAME'])).'../../adodb/';
    $GLOBALS['cfg']['db']['adodb_path']=fixPath(cROOT_PATH).'lib/adodb/';
  }
}
//******************************************************************************
function includeDOMTT()
{
  ?>
  <STYLE TYPE="text/css">
  <!--
  div.domTT {
      padding: 2px;
      border: 1px solid #000000;
      background-color: #FFFFE1;
      color: #000000;
  }
  -->
  </STYLE>
  <script type="text/javascript" language="javascript" src="../../lib/domTT/domLib.js"></script>
  <script type="text/javascript" language="javascript" src="../../lib/domTT/domTT.js"></script>
  <script language="JavaScript" type="text/javascript">
  var domTT_useGlobalMousePosition = false;
  var domTT_trail = true;
  var domTT_activateDelay = 0;
  var domTT_onePopup = true;
  var domTT_direction = 'southeast';
  var domTT_offsetX = domLib_isIE ? -2 : 0;
  var domTT_mouseHeight = domLib_isIE ? 17 : 19;
  </script>
  <?
}
//******************************************************************************
function getConfig()
{
  global $config;
  $cfg_path="../../configs/";
  //Prevent relative paths and remote files
  //http://voodoo.domain/index.php?config=http://blabla.com/exploit.txt
  if (isset($_GET['config']) && !preg_match("/\\.\\./",$_GET['config']) && is_file($cfg_path.$_GET['config']))
    $config=$_GET['config'];
  else
    $config = "cfg-default.php";
  
  return $cfg_path.$config;
}
//******************************************************************************

function setSkin()
{
  $cookie_expire_time=time()+60*60*24*30*12;

  global $skin,$skin_data,$stylesheet;
  ob_start(); 

  if (!$GLOBALS['settings']['display']['skin_selector'])
  {
    $skin=$GLOBALS['settings']['display']['default_skin'];
  }
  else if (isset($_GET['skin']))
  {
    $skin=$_GET['skin'];
    setcookie('vsp_skin', $_GET['skin'],$cookie_expire_time);
  }
  else if (!isset($_COOKIE['vsp_skin']))
  {
    setcookie('vsp_skin', $GLOBALS['settings']['display']['default_skin'],$cookie_expire_time);
    $skin=$GLOBALS['settings']['display']['default_skin'];
  }
  else
  {
    $skin=$_COOKIE['vsp_skin'];
  }
  
  if (strlen($skin)<1)
    $skin=$GLOBALS['settings']['display']['default_skin'];

  $stylesheet="./skins/$skin/$skin.css";

  $fp_skin = fopen ($stylesheet, "rb");
  if (!$fp_skin)
  {
    if ($skin==$GLOBALS['settings']['display']['default_skin'])
    {
      ob_end_flush();
      print("<HTML><HEAD></HEAD><BODY>ERROR: Default skin \"$stylesheet\" not found!</BODY></HTML>");
    }
    else
    {
      setcookie('vsp_skin', $GLOBALS['settings']['display']['default_skin'],$cookie_expire_time);
      ob_end_flush();
      ?>
      <HTML><HEAD></HEAD><BODY><SCRIPT>window.location="<?print "$_SERVER[PHP_SELF]?config=$GLOBALS[config]"; if (isset($_GET['sort'])) print "&amp;sort=$_GET[sort]";?>"</SCRIPT></BODY></HTML>
      <?
    }
    exit();
  }
  else
  {
    ob_end_flush();
    $line=fgets ($fp_skin, 255);
    fclose ($fp_skin);
    $skin_data['name']=$skin;
    if (preg_match('/<author>(.*)<\/author>/i', $line, $regs))
      $skin_data['author']=$regs[1];
    else if (!isset($skin_author_name) || strlen($skin_author_name)<=0)
      $skin_data['author']="anon";
    if (preg_match('/<email>(.*)<\/email>/i', $line, $regs))
      $skin_data['email']=$regs[1];
    else
      $skin_data['email']="";
  }
}
//******************************************************************************
function drawMainHeading()
{
  ?>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
    <TR>
      <TD HEIGHT=25 WIDTH="100%" CLASS="cellHeading" style="text-align: center; font-size: larger" COLSPAN=3><?print $GLOBALS['cfg']['display']['server_title'];?></TD>
    </TR>
    <?
      if ($GLOBALS['settings']['display']['server_info'])
      {
        ?>
        <TR>
          <TD CLASS="cell1" style="text-align: center"><IMG alt="" SRC="<?print $GLOBALS['cfg']['display']['server_image'];?>"></TD>
          <TD WIDTH="100%" CLASS="cell1" style="vertical-align: top; text-align: left">
            <?print $GLOBALS['cfg']['display']['server_info'];?>
          </TD>
          <TD CLASS="cell1" style="text-align: center"><A href="http://www.clanavl.com/vsp/"><IMG border="0" alt="" SRC="../../images/_v_logo.gif"></A></TD>
        </TR>
        <?
      }
    ?>
  </table>
  <?
}
//******************************************************************************
function drawMenu()
{
  ?>
  <table style="border-width: 0" CELLSPACING=0 CELLPADDING=1 WIDTH="100%">
    <TR>
      <TD HEIGHT="20" WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center; font-size: larger"><A HREF="index.php?config=<? print $GLOBALS['config']; ?>"><B>Player Stats</B></A></TD>
      
      <?
      if ($GLOBALS['settings']['display']['gamestats'])
      {
        ?><TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center; font-size: larger"><A HREF="gamestat.php?config=<? print $GLOBALS['config']; ?>"><B>Game Stats</B></A></TD><?
      }
      ?>
      
      <TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center; font-size: larger"><A HREF="awardstat.php?config=<? print $GLOBALS['config']; ?>"><B>Award Stats</B></A></TD>
      <!--<TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center">Server Stats</TD>-->
      <!--<TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center">Violations</TD>-->
      <!--<TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center; font-size: larger"><A HREF="http://www.clanavl.com/vsp/"><B>F.A.Q.</B></A></TD>-->



      <?
      if ($GLOBALS['settings']['display']['skin_selector'])
      {
        if ($handle = opendir('./skins')) 
        {
           while (false !== ($file = readdir($handle))) 
           {
               if (!preg_match("/^\\./",$file)) 
               {
                   //echo "$file\n";
                   $skin_file[]=$file;
               }
           }
           closedir($handle);
        }
        ?>

        <?
        if (count($skin_file)>1)
        {
          asort($skin_file);
          ?>
          <TD WIDTH="12.5%" CLASS="cellSubHeading" style="text-align: center; font-size: larger">
            <B>Skins:</B>
            <form style="display:inline" method="post" action="<? print "$_SERVER[PHP_SELF]"; ?>">

            <?
            $query_str=$_SERVER['QUERY_STRING'];
            $query_str=preg_replace("/&amp;skin=[^&]*/i",'',$query_str);
            ?>

            <select style="text-align: center;" name="skin_select" size="1" class="cellSubHeading"  OnChange="location.href='<?print $_SERVER['PHP_SELF'] . "?" . htmlentities(preg_replace("/&skin=[^&]+/", "", $query_str))."&amp;skin=";?>'+form.skin_select.options[form.skin_select.selectedIndex].value">
              <?
                     foreach($skin_file as $num => $file)
                     {
                         //echo "$file\n";
                         ?><option <?if ($GLOBALS['skin']=="$file") echo "selected";?> style="text-align: center;" class="cellSubHeading" value="<? print $file; ?>" ><? print $file; ?></option><?
                     }
              ?>
            </select> 
            </form>
          </TD>
          <?
        }
      }
      ?>

    </TR>
  </table>
  <?
}
//******************************************************************************
function drawCredits()
{
  global $skin_data;
  global $db;
  
  $sql="SELECT value
          from {$GLOBALS['cfg']['db']['table_prefix']}gamedata
          where name=".$db->qstr("last update time");
  $rs = $db->Execute($sql);
  if ($rs && !$rs->EOF)
    $last_update_time=$rs->fields[0];
  else
    $last_update_time="?";
  $rs='';
  $sql="SELECT value
          from {$GLOBALS['cfg']['db']['table_prefix']}gamedata
          where name=".$db->qstr("vsp version");
  $rs = $db->Execute($sql);
  if ($rs && !$rs->EOF)
    $vsp_version=$rs->fields[0];
  else
    $vsp_version="?";

  ?>
  <!-- credits   table begin ##################################################-->
  <table CLASS="cellHeading" CELLSPACING=0 CELLPADDING=2 WIDTH="100%" style="border-width: 0">
  <tr>
  <td COLSPAN=3 WIDTH="30%" CLASS="cellHeading" style="text-align: center;" >&nbsp;powered by <A HREF="http://www.clanavl.com/vsp/">vsp stats processor</A> &copy; 2004-2005 by <A HREF="#" TITLE="myrddin8 <AT> gmail <DOT> com">myrddin</A>&nbsp;</td>
  </tr>

  <tr>
  <td WIDTH="35%" CLASS="cellSubHeading" style="text-align: left; border-right-width: 0" >&nbsp;<? print "theme:bismarck by <A HREF=\"#\" TITLE=\"myrddin8 <AT> gmail <DOT> com\">myrddin</A>"; ?>&nbsp;</td>
  <td WIDTH="30%" CLASS="cellSubHeading" style="text-align: center; border-right-width: 0; border-left-width: 0" >&nbsp;<A HREF="http://www.clanavl.com/vsp/">vsp</A> v<? print $vsp_version;?>,&nbsp;last updated @ <? print $last_update_time;?></td>
  <td WIDTH="35%" CLASS="cellSubHeading" style="text-align: right; border-left-width: 0" >&nbsp;<? print "skin:$skin_data[name] by <A HREF=\"#\" TITLE=\"$skin_data[email]\">$skin_data[author]</A>"; ?>&nbsp;</td>
  </tr>
  </table>
  <!-- credits   table end   ##################################################-->
  <?
}
//******************************************************************************

?>