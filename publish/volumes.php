<?php
include('./mini.inc.php');
include 'App.php';
$app->header('Volumes');
?>
<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<template id="view">
	<TABLE class="DEFSHOW" id="{{RandId}}">
	<THEAD><TR><TH class="TSORT">Name</TH><TH class="TSORT">Created</TH></TR></THEAD>
	<TBODY>
	<!-- {{range $v := .Volumes }}-->
	<TR>
	<TD class="name"><A href="./volume.php?id={{$v.Name}}&title={{Ellipsify $v.Name}}">{{Ellipsify $v.Name }}</A></TD>
	<TD data-sort="{{ $v.CreatedAt }}">{{Trunc10 $v.CreatedAt }}</A></TD>
	</TR>
	<!-- {{end}} -->
	</TBODY>
	</TABLE>
</template>

<!-- ============================ -->
<!-- RENDER ZONE ================ -->
<BR>
<div id="insertHere"></div>

<!-- ============================ -->
<!-- CONTROLER ================== -->
<SCRIPT>
$(function() {ttify('/volumes','#view','#insertHere');});
</SCRIPT>
<?$app->tailer();?>
