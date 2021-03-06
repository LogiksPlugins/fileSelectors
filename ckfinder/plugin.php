<?php
if(function_exists("getWebPath")) {
	$webPath=getWebPath(__FILE__);
} else {
	$host="";
	if(isset($_SERVER['HTTPS'])) $host="https://"; else $host="http://";
	$host.=$_SERVER['HTTP_HOST'];
	
	$a=dirname($_SERVER['SCRIPT_FILENAME']);
	$a=substr($a,strlen($_SERVER['DOCUMENT_ROOT'])+1);
	$webPath=$host."/".$a."/ckfinder/";
}
/*
//checkModule("fileselectors")

$root=dirname(dirname(dirname(dirname(dirname(__FILE__)))))."";
$a=dirname(dirname(__FILE__))."/index.php";

if(strpos($_SERVER['DOCUMENT_ROOT'],"chroot")>1) {
	$b=$root.$_SERVER["PHP_SELF"];
} else {
	$b=$_SERVER['DOCUMENT_ROOT'].$_SERVER["PHP_SELF"];
}
//$b=dirname($b);
if($a!=$b) {
	
	$path=str_replace($root,$host,dirname(dirname(__FILE__)));
	$path=$path."/index.php?".$_SERVER['QUERY_STRING'];
	
	echo $b;
	exit();
	//header("Location:$path");
}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Logiks Media Browser</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<script type="text/javascript" src="<?=$webPath?>ckfinder.js"></script>
	<style type="text/css">
		body, html, iframe, #ckfinder {
			margin: 0;
			padding: 0;
			border: 0;
			width: 100%;
			height: 100%;
			overflow: hidden;
		}
	</style>
</head>
<body>
	<div id="ckfinder"></div>
	<script type="text/javascript">
(function()
{
		var config = {
		};
		var get = CKFinder.tools.getUrlParam;
		var getBool = function( v )
		{
			var t = get( v );

			if ( t === null )
				return null;

			return t == '0' ? false : true;
		};

		var tmp;
		if ( tmp = get( 'basePath' ) )
			CKFINDER.basePath = tmp;

		if ( tmp = get( 'startupPath' ) )
			config.startupPath = decodeURIComponent( tmp );

		config.id = get( 'id' ) || '';

		if ( ( tmp = getBool( 'rlf' ) ) !== null )
			config.rememberLastFolder = tmp;

		if ( ( tmp = getBool( 'dts' ) ) !== null )
			config.disableThumbnailSelection = tmp;

		if ( tmp = get( 'data' ) )
			config.selectActionData = tmp;

		if ( tmp = get( 'tdata' ) )
			config.selectThumbnailActionData = tmp;

		if ( tmp = get( 'type' ) )
			config.resourceType = tmp;

		if ( tmp = get( 'skin' ) )
			config.skin = tmp;

		if ( tmp = get( 'langCode' ) )
			config.language = tmp;

		// Try to get desired "File Select" action from the URL.
		var action;
		if ( tmp = get( 'CKEditor' ) )
		{
			if ( tmp.length )
				action = 'ckeditor';
		}
		if ( !action )
			action = get( 'action' );

		var parentWindow = ( window.parent == window )
			? window.opener : window.parent;

		switch ( action )
		{
			case 'js':
				var actionFunction = get( 'func' );
				if ( actionFunction && actionFunction.length > 0 )
					config.selectActionFunction = parentWindow[ actionFunction ];

				actionFunction = get( 'thumbFunc' );
				if ( actionFunction && actionFunction.length > 0 )
					config.selectThumbnailActionFunction = parentWindow[ actionFunction ];
				break ;

			case 'ckeditor':
				var funcNum = get( 'CKEditorFuncNum' );
				if ( parentWindow['CKEDITOR'] )
				{
					config.selectActionFunction = function( fileUrl, data )
					{
						fileUrl="<?=$_SESSION["SITELOCATION"]?>"+fileUrl;
						parentWindow['CKEDITOR'].tools.callFunction( funcNum, fileUrl, data );
					};

					config.selectThumbnailActionFunction = config.selectActionFunction;
				}
				break;

			default:
				if ( parentWindow && parentWindow['FCK'] && parentWindow['SetUrl'] )
				{
					action = 'fckeditor' ;
					config.selectActionFunction = parentWindow['SetUrl'];

					if ( !config.disableThumbnailSelection )
						config.selectThumbnailActionFunction = parentWindow['SetUrl'];
				}
				else
					action = null ;
		}

		config.action = action;

		// Always use 100% width and height when nested using this middle page.
		config.width = config.height = '100%';

		var ckfinder = new CKFinder( config );
		ckfinder.replace( 'ckfinder', config );
})();
	</script>
</body>
</html>
