<?php
include('./mini.inc.php');
include 'App.php';
$app->header('Container');
?>
<DIV class="BBUNCH">
<Button id="Inspect">Inspect</button>
<Button id="Stats">Stats</button>
<Button id="Top">Top</button>
<Button id="Logs">Logs</button>
<!-- <input type="checkbox" id="all">&nbsp;<label for="all">All</label> 
<input type="checkbox" id="Xview">&nbsp;<label for="Xview">Extended view</label>-->
</DIV>

<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<!-- as browser may reorganize elements when HTML syntax is inappropriate
(ie: firefox tables), GO templates comment should go in HTML comments for safety reasons -->

<!-- =========== -->
<template id="inspectView">
	<FIELDSET class="fset">
	<LABEL>Name&nbsp;:</LABEL>{{ $.Name }}<BR>
	<LABEL>Image&nbsp;:</LABEL><A href="./image.php?id={{ $.Image }}">{{ printf "%.20s" $.Image }}&hellip;</A><BR>
	<LABEL>Status&nbsp;:</LABEL>{{ $.State.Status }}<BR>
	<LABEL>RestartPolicy&nbsp;:</LABEL>{{ $.HostConfig.RestartPolicy.Name }}<BR>
	<LABEL>Mounts&nbsp;:</LABEL><DIV>
	{{range $mount := .Mounts }}
		{{if eq $mount.Type "bind" }}
		<SPAN title="{{ $mount.Destination }}">{{ $mount.Source }}</SPAN> (host)<br>
		{{else}}
		<SPAN title="{{ $mount.Destination }}">{{ $mount.Name }}</SPAN><br>
		{{end}}
	{{end}}
	</DIV><BR>
	<LABEL></LABEL><BR>
	<LABEL></LABEL><BR>
	<LABEL></LABEL><BR>
	<LABEL></LABEL><BR>
	<LABEL></LABEL><BR>
	</FIELDSET>
</template>

<!-- ============================ -->
<!-- RENDER ZONE ================ -->
<BR>
<div id="insertHere"></div>

<!-- ============================ -->
<!-- CONTROLER ================== -->
<SCRIPT>
const queryString=window.location.search;
const urlParams=new URLSearchParams(window.location.search);
var cid=urlParams.get('id');

function render(ws,view) {
	ttify(ws,view,'#insertHere');
	}

$(function() {	
	$('#inspect').click(function() {render('/containers/'+cid+'/json','#inspectView');});
	
	render('/containers/'+cid+'/json','#inspectView');

	});
</SCRIPT>
<?$app->tailer();?>
