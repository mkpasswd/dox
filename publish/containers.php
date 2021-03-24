<?php
include('./mini.inc.php');
include 'App.php';
$app->header('Containers');
?>
<DIV class="BBUNCH">
<Button id="reload">Refresh</button>
<input type="checkbox" id="all">&nbsp;<label for="all">All</label> 
<input type="checkbox" id="Xview">&nbsp;<label for="Xview">Extended view</label> 
</DIV>

<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<!-- as browser may reorganize elements when HTML syntax is inappropriate
(ie: firefox tables), GO templates comment should go in HTML comments for safety reasons -->

<!-- =========== -->
<template id="v1">
	<TABLE class="DEFSHOW" id="{{RandId}}">
	<THEAD><TR><TH class="TSORT">Names</TH><TH class="TSORT X">Image</TH><TH class="TSORT">State</TH><TH class="X">Status</TH><TH class="X">IP</TH><TH class="TSORT">Ports</TH><TH>Mounts</TH></TR></THEAD>
	<TBODY>
	<!-- {{range $cN, $c := .}} -->
	<TR>
	<TD class="name" data-sort="{{ index $c.Names 0 }}"><A href="./container.php?id={{$c.Id}}&title={{index $c.Names 0}}">
	{{range $name := $c.Names }}
	{{ $name }}
	{{end}}
	</A></TD>
	<TD class="X" data-sort="{{ $c.Image }}"><A href="./image.php?id={{ $c.ImageID }}&title={{$c.Image}}">{{Ellipsify $c.Image }}</A></TD>
	<TD data-sort="{{ $c.State }}">{{ $c.State }}</TD>
	<TD class="X">{{ $c.Status }}</TD>
	<TD class="X">{{ $c.NetworkSettings.Networks.bridge.IPAddress }}</TD>
	<!--
	{{ if $c.Ports }}
	{{ $firstPort :=index $c.Ports 0 }}
	-->
	<TD data-sort="{{ $firstPort.PublicPort }}">
	<!-- {{else}} -->
	<TD data-sort="0">
	<!-- {{ end }} -->
	{{range $port := $c.Ports }}
	{{ $port.PublicPort }} &larr; {{ $port.PrivatePort }}<br>
	{{end}}
	</TD>
	<TD>
	{{range $mount := $c.Mounts }}
		{{if eq $mount.Type "bind" }}
		<SPAN title="{{ $mount.Destination }}">{{Ellipsify $mount.Source }}</SPAN> (host)<br>
		{{else}}
		<A title="{{ $mount.Destination }}" href="./volume.php?id={{$mount.Name}}&title={{Ellipsify $mount.Name}}">{{Ellipsify $mount.Name}}</A><br>
		{{end}}
	{{end}}
	</TD>
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
function render(view) {
	var ep='';
	if($('#all').prop('checked')) 
		//ep='?filters='+encodeURIComponent('{"status": ["running","exited,"paused"]}');
		// ep='?filters={"status": ["running","exited,"paused"]}');
		ep='?all=true';
	ttify('/containers/json'+ep,view,'#insertHere',dealXview);
	}

function dealXview() {
	if($('#Xview').prop('checked')) $('.X').show();
	else $('.X').hide();
	}

	
$(function() {
	$('#all,#reload').click(function() {render('#v1');});
	$('#Xview').click(function() {dealXview();});

	render('#v1');
	});
</SCRIPT>
<?$app->tailer();?>
