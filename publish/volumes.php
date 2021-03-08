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
		<TD class="name" title="{{$v.Name}}" data-sort="zzzzz-{{$v.Name}}">{{ printf "%.20s&hellip;" $v.Name }}</TD>
	<!-- {{else}} -->
		<TD class="name">{{ $v.Name }}</TD>
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
