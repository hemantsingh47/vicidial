<?php
# welcome.php - VICIDIAL welcome page
# 
# Copyright (C) 2023  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# CHANGELOG:
# 141007-2140 - Finalized adding QXZ translation to all admin files
# 161106-1920 - Changed to use newer design and dynamic links
# 220228-1109 - Added allow_web_debug system setting
# 231119-1540 - Added HCI Screen link if hopper_hold_inserts are allowed on the system
#

header ("Content-type: text/html; charset=utf-8");

require_once("dbconnect_mysqli.php");
require("functions.php");

# if options file exists, use the override values for the above variables
#   see the options-example.php file for more information
if (file_exists('options.php'))
	{
	require('options.php');
	}

#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,enable_languages,language_method,default_language,agent_screen_colors,admin_web_directory,agent_script,allow_web_debug,hopper_hold_inserts FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'01001',$VD_login,$server_ip,$session_name,$one_mysql_log);}
#if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =				$row[0];
	$SSenable_languages =		$row[1];
	$SSlanguage_method =		$row[2];
	$default_language =			$row[3];
	$agent_screen_colors =		$row[4];
	$admin_web_directory =		$row[5];
	$SSagent_script =			$row[6];
	$SSallow_web_debug =		$row[7];
	$SShopper_hold_inserts =	$row[8];
	}
if ($SSallow_web_debug < 1) {$DB=0;}
##### END SETTINGS LOOKUP #####
###########################################

##### BEGIN Define colors and logo #####
$SSmenu_background='015B91';
$SSframe_background='D9E6FE';
$SSstd_row1_background='9BB9FB';
$SSstd_row2_background='B9CBFD';
$SSstd_row3_background='8EBCFD';
$SSstd_row4_background='B6D3FC';
$SSstd_row5_background='A3C3D6';
$SSalt_row1_background='BDFFBD';
$SSalt_row2_background='99FF99';
$SSalt_row3_background='CCFFCC';

if ($agent_screen_colors != 'default')
	{
	$stmt = "SELECT menu_background,frame_background,std_row1_background,std_row2_background,std_row3_background,std_row4_background,std_row5_background,alt_row1_background,alt_row2_background,alt_row3_background,web_logo FROM vicidial_screen_colors where colors_id='$agent_screen_colors';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'01XXX',$VD_login,$server_ip,$session_name,$one_mysql_log);}
	if ($DB) {echo "$stmt\n";}
	$qm_conf_ct = mysqli_num_rows($rslt);
	if ($qm_conf_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$SSmenu_background =		$row[0];
		$SSframe_background =		$row[1];
		$SSstd_row1_background =	$row[2];
		$SSstd_row2_background =	$row[3];
		$SSstd_row3_background =	$row[4];
		$SSstd_row4_background =	$row[5];
		$SSstd_row5_background =	$row[6];
		$SSalt_row1_background =	$row[7];
		$SSalt_row2_background =	$row[8];
		$SSalt_row3_background =	$row[9];
		$SSweb_logo =				$row[10];
		}
	}
$Mhead_color =	$SSstd_row5_background;
$Mmain_bgcolor = $SSmenu_background;
$Mhead_color =	$SSstd_row5_background;

$selected_logo = "./images/vicidial_admin_web_logo.png";
$logo_new=0;
$logo_old=0;
if (file_exists('../$admin_web_directory/images/vicidial_admin_web_logo.png')) {$logo_new++;}
if (file_exists('vicidial_admin_web_logo.gif')) {$logo_old++;}
if ($SSweb_logo=='default_new')
	{
	$selected_logo = "./images/vicidial_admin_web_logo.png";
	}
if ( ($SSweb_logo=='default_old') and ($logo_old > 0) )
	{
	$selected_logo = "../$admin_web_directory/vicidial_admin_web_logo.gif";
	}
if ( ($SSweb_logo!='default_new') and ($SSweb_logo!='default_old') )
	{
	if (file_exists("../$admin_web_directory/images/vicidial_admin_web_logo$SSweb_logo")) 
		{
		$selected_logo = "../$admin_web_directory/images/vicidial_admin_web_logo$SSweb_logo";
		}
	}
##### END Define colors and logo #####
?>
<!doctype html>
<html lang="en">
  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> <?php echo _QXZ("Welcome Screen"); ?> </title>
	<link rel="stylesheet" type="text/css" href="../agc/css/style.css" />
	<link rel="stylesheet" type="text/css" href="../agc/css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
  </head>
<body class="register-page bg-body-secondary">
    <main class="welcome-box">
      <!-- /.register-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header">
          <div class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover d-flex align-items-center justify-content-center text-decoration-none">
			  <img src="<?php echo$selected_logo?>"  alt="Agent Screen" />
		  </div>
			<div class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover d-flex align-items-center justify-content-center text-decoration-none">
            <h3 class="mb-2"><b><?php echo _QXZ("Welcome to Gama Dial"); ?></b></h3>
			
		</div>
		<div class="text-center">
		<h6 class="mb-2 text-sm text-muted"><?php echo _QXZ("Advanced Contact Center & Call Management Platform"); ?></h6>
		</div>
        </div>
        <div class="card-body register-card-body">
          <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <a href="../<?php echo $admin_web_directory ?>/admin.php" class="btn btn-gama">
              <?php echo _QXZ("Administration"); ?>
            </a>

            <a href="../agc/<?php echo $SSagent_script?>" class="btn btn-primary">
				<?php echo _QXZ("Agent Login"); ?>
            </a>
			<?php if ($hide_timeclock_link < 1) { ?> 
				<a href="../agc/timeclock.php?referrer=welcome" class="btn btn-secondary">
					<?php echo _QXZ("Agent Time Tracking"); ?>
				</a>
			
			<?php } ?>

			<?php if ($SShopper_hold_inserts > 0) { ?> 
				<a href="../<?php echo $admin_web_directory ?>/hci_screen.php" class="btn btn-warning">
					<?php echo _QXZ("HCI Screen"); ?>
				</a>
			
			<?php } ?>

            
          </div>


         
        </div>

      </div>
    </main>

  </body>