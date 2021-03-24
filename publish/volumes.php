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
	<!-- {{ if gt (len $v.Name) 30 }} -->
		<TD class="name" title="{{$v.Name}}" data-sort="zzzzz-{{$v.Name}}"><A href="./volume.php?id={{$v.Name}}&title={{$v.Name}}">{{printf "%.20s" $v.Name}}&hellip;</A></TD>
	<!-- {{else}} -->
		<TD class="name"><A href="./volume.php?id={{$v.Name}}&title={{$v.Name}}">{{ $v.Name }}</A></TD>
	<!-- {{end}} -->
	<TD data-sort="{{ $v.CreatedAt }}">{{ printf "%.10s" $v.CreatedAt }}</A></TD>
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
