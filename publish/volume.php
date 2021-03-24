<?php
include('./mini.inc.php');
include('App.php');
include('T.class.php');

$title=T::gp('title','&lt;unset&gt;');
$app->header("Volume $title");
?>

<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<template id="inspectView">
	<FIELDSET class="fset">
	<LABEL>Name&nbsp;:</LABEL>{{ $.Name }}<BR>
	<LABEL>Driver&nbsp;:</LABEL>{{ $.Driver }}<BR>
	<LABEL>Scope&nbsp;:</LABEL>{{ $.Scope }}<BR>
	<LABEL>CreatedAt&nbsp;:</LABEL>{{ printf "%.10s" $.CreatedAt }}<BR>
	<!-- .Options and .Labels to be dealed with -->
	</FIELDSET>
</template>
<!-- ============================ -->
<!-- RENDER ZONE ================ -->
<BR>
<div id="insertHere" style="height: 100%"></div>

<!-- ============================ -->
<!-- CONTROLER ================== -->
<SCRIPT>
const urlParams=new URLSearchParams(window.location.search);
var cid=urlParams.get('id');
$(function() {	
	ttify('/volumes/'+cid,'#inspectView','#insertHere');
	});
</SCRIPT>
<?$app->tailer();?>
