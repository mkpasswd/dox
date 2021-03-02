<?php
include('./mini.inc.php');
include 'App.php';
$app->header('Containers');
?>
<DIV class="BBUNCH">
<Button id="compact">Compact</button>
<Button id="extended">Extended</button>
<input type="checkbox" id="all">&nbsp;<label for="all">All</label> 
</DIV>

<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<!-- as browser may reorganize elements when HTML syntax is inappropriate
(ie: firefox tables), GO templates comment should go in HTML comments dor safety reasons -->
<template id="v1">
	<TABLE class="DEFSHOW">
	<THEAD><TR><TH>Names</TH><TH>Image</TH><TH>State</TH><TH>Ports</TH><TH>Mounts</TH></TR></THEAD>
	<TBODY>
	<!-- {{range $cN, $c := .}} -->
	<TR>
	<TD class="name"><A href="./container?id={{$c.Id}}">
	{{range $name := $c.Names }}
	{{ $name }}
	{{end}}
	</A></TD>
	<TD><A href="./image.php?id={{ $c.ImageID }}">{{ printf "%.20s" $c.Image }}</A></TD>
	<TD>{{ $c.State }}</TD>
	<TD>
	{{range $port := $c.Ports }}
	{{ $port.PublicPort }} &larr; {{ $port.PrivatePort }}<br>
	{{end}}
	</TD>
	<TD>
	{{range $mount := $c.Mounts }}
		{{if eq $mount.Type "bind" }}
		<SPAN title="{{ $mount.Destination }}">{{ printf "%.20s" $mount.Source }}</SPAN> (host)<br>
		{{else}}
		<SPAN title="{{ $mount.Destination }}">{{ printf "%.20s" $mount.Name }}</SPAN><br>
		{{end}}
	{{end}}
	</TD>
	</TR>
	<!-- {{end}} -->
	</TBODY>
	</TABLE>
</template>
<!-- =========== -->
<template id="v2">
	<TABLE class="DEFSHOW">
	<THEAD><TR><TH>Names</TH><TH>State</TH><TH>Status</TH><TH>IP</TH><TH>Ports</TH><TH>Mounts</TH></TR></THEAD>
	<TBODY>
	<!-- {{range $cN, $c := .}} -->
	<TR>
	<TD class="name"><A href="./container?id={{$c.Id}}">
	{{range $name := $c.Names }}
	{{ $name }}
	{{end}}
	</A></TD>
	<TD>{{ $c.State }}</TD>
	<TD>{{ $c.Status }}</TD>
	<TD>{{ $c.NetworkSettings.Networks.bridge.IPAddress }}</TD>
	<TD>
	{{range $port := $c.Ports }}
	{{ $port.PublicPort }} &larr; {{ $port.PrivatePort }}<br>
	{{end}}
	</TD>
	<TD>
	{{range $mount := $c.Mounts }}
	<SPAN title="{{ $mount.Destination }}">{{ $mount.Name }}</SPAN><br>
	{{end}}
	</TD>
	</TR>
	<!-- {{end}} -->
	</TBODY>
	</TABLE>
</template>

<!-- ============================ -->
<!-- RENDER ZONE ================ -->
<div id="insertHere"></div>

<!-- ============================ -->
<!-- CONTROLER ================== -->
<SCRIPT>
function render(view) {
	var ep='';
	if($('#all').prop('checked')) 
		//ep='?filters='+encodeURIComponent('{"status": ["running","exited,"paused"]}');
		// ep='?filters={"status": ["running","exited,"paused"]}');
		ep='?all=true';
	ttify('/containers/json'+ep,view,'#insertHere');}
	
$(function() {
	console.log('Init...');

	$('#compact').click(function() {render('#v1');});
	$('#extended').click(function() {render('#v2');});

	render('#v1');
	});
</SCRIPT>
<?$app->tailer();?>
