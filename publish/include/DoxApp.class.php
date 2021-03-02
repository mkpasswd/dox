<?php

class DoxApp{ 

//   _____ _____ _____ _____ _____ _____ _____ 
//  |_____|_____|_____|_____|_____|_____|_____|
//
function header($title='',$option='') {
$NOJS=(stripos($option,'NOJS')!==false);
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" href="<?=SITE?>/rsc/DoxApp.png" />
	<TITLE><?=APPNAME." $title"?></TITLE>
	<meta name="description" content="Dox Sample App">
	<meta name="viewport" content="width=device-width">
<? if(!$NOJS) { ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/i18n/jquery-ui-i18n.min.js"></script>
	<script src="<?=SITE?>/include/App.js.php"></script>
<? }; ?>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/redmond/jquery-ui.css">	
	<link rel="stylesheet" href="<?=SITE?>/rsc/DoxApp.css">
</head>
<BODY>
<? if(!$NOJS) { ?>
	<script>
	$(function() { 
	$(document).tooltip();
	});
	</script>
<? }; ?>
<DIV class="toptitle ui-widget ui-widget-header ui-corner-all">
<IMG src="<?=SITE?>/rsc/DoxApp.png"><H1 class="toptitle"><?=APPNAME." $title"?></H1>
</DIV>

<?
} 

//   _____ _____ _____ _____ _____ _____ _____ 
//  |_____|_____|_____|_____|_____|_____|_____|
//
function tailer() {
?>
</BODY>
</HTML>
<?
}

}
?>
