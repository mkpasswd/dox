<?php
include('./mini.inc.php');
include 'App.php';
$app->header('Images');
?>
<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<template id="v1">
	<TABLE class="DEFSHOW">
	<THEAD><TR><TH class="TSORT">RepoTags</TH><TH class="TSORT">Created</TH><TH>Size</TH></TR></THEAD>
	<TBODY>
	<!-- {{range $cN, $c := .}} -->
	<TR>
	<TD class="name" data-sort="{{ index $c.RepoTags 0 }}"><A href="./image.php?id={{$c.Id}}">
	{{range $name := $c.RepoTags }}
	{{ $name }} <BR>
	{{end}}
	</A></TD>
	<TD data-sort="{{ TSShort $c.Created }}">{{ TSDate $c.Created }}</A></TD>
	<TD>{{ MiB $c.Size }}</TD>
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
$(function() {ttify('/images/json','#v1','#insertHere');});
</SCRIPT>
<?$app->tailer();?>
