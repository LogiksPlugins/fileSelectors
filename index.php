<?php
if(strlen(session_id())<=0) {
	//This is direct access module
	//exit("Direct Access Is Not Allowed");
	session_start();
}
$browser="ckfinder";
if(isset($_REQUEST["browser"])) {
	$browser=$_REQUEST["browser"];	
}

$path="";
if(defined("SITENAME")) {
	if(SITENAME=="admincp") {
		if(isset($_REQUEST['forsite'])) {
			$path=APPS_FOLDER.$_REQUEST['forsite']."/";
		} else {
			$path="";
		}
	} elseif(SITENAME=="cms") {
		if(isset($_REQUEST['forsite'])) {
			if(in_array($_REQUEST['forsite'],$_SESSION['SESS_ACCESS_SITES'])) {
				$path=APPS_FOLDER.$_REQUEST['forsite']."/";
			} else {
				$path=APPS_FOLDER.SITENAME."/";
			}
		} else {
			$path=APPS_FOLDER.SITENAME."/";
		}
	} else {
		$path=APPS_FOLDER.SITENAME."/";
	}
	if(!isset($_REQUEST['baseDir'])) {
		if(defined("APPS_MEDIA_FOLDER")) {
			$_REQUEST['baseDir']=APPS_MEDIA_FOLDER;
		} else {
			$_REQUEST['baseDir']="media/";
		}
	} 
	$path=$path.$_REQUEST['baseDir']."/";
	$path=str_replace("//","/",$path);
	$_SESSION["LGKS_EDITOR_FPATH"]=$path;
} else {
	if(isset($_REQUEST['site'])) {
		if(isset($_REQUEST['baseDir'])) {// && substr($_REQUEST['baseDir'],0,8)!="userdata"
			$site=explode("/",$_REQUEST['site']);
			$path="apps/{$site[0]}/{$_REQUEST['baseDir']}/";
			$path=str_replace("//","/",$path);
			$_SESSION["LGKS_EDITOR_FPATH"]=$path;
		} else {
			$site=$_REQUEST['site'];
			$path="apps/{$site}/media/";
			$path=str_replace("//","/",$path);
			$_SESSION["LGKS_EDITOR_FPATH"]=$path;
		}
	}
}

if(!isset($_SESSION["LGKS_EDITOR_FPATH"]))
	exit("Direct Access Is Not Allowed");

if(isset($_REQUEST["popup"])) {	
	include "$browser/plugin.php";
} elseif(isset($_REQUEST["embeded"])) {
	$webPath=getWebPath(__FILE__);
	header("Location: $webPath".$browser."/index.php");
} else {
	$webPath=getWebPath(__FILE__);
	echo "<script type='text/javascript' src='$webPath/ckfinder/ckfinder.js'></script>";
}
?>
