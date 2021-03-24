<?php
include('./mini.inc.php');
include('App.php');
include('T.class.php');

$title=T::gp('title','&lt;unset&gt;');
$app->header("Container $title");
?>
<DIV class="BBUNCH">
<Button id="inspect">Inspect</button>
<!-- <Button id="stats">Stats</button> -->
<Button id="top">Top</button>
<Button id="logs">Logs</button>
<Select id="tlog">
<option value="?stderr=true&stdout=true&tail=100">last 100</option>
<option value="?stderr=true&stdout=true">stderr+stdout</option>
<option value="?stderr=true">stderr</option>
<option value="?stdout=true">stdout</option>
</select>
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
	</FIELDSET>
</template>
<!-- =========== -->
<template id="topView">
	<TABLE class="DEFSHOW" id="{{RandId}}">
	<THEAD><TR>
	<!-- {{range $th := .Titles }} -->
		<TH class="TSORT">{{ $th }}</TH>
	<!-- {{end}} -->
	</TR></THEAD>
	<TBODY>
	<!-- {{range $tr := .Processes }} -->
		<TR>
		<!-- {{range $td := $tr }} -->
		<TD>{{ $td }}</TD>
		<!-- {{end}} -->
		</TR>	
	<!-- {{end}} -->
	</TBODY>
	</TABLE>
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

function render(ws,view) {
	ttify(ws,view,'#insertHere');
	}

/*
function tafit() {
	var el=document.getElementById('inspect');
	var rect = el.getBoundingClientRect();
	console.log('inspect : ');console.log(rect);
	console.log($('#inspect').offset());
	el=document.getElementById('insertHere');
	rect = el.getBoundingClientRect();
	console.log('insertHere');console.log(rect);
	console.log('=============');
	console.log($('#insertHere').offset());
	console.log($('#insertHere FIELDSET').offset());
	}
*/

function scrollBot() {
	var szone=$('#insertHere TEXTAREA');
	if(szone.length) {
		// szone=szone.first();
		// console.log('YO length');
		// console.log(szone[0].scrollHeight+'   '+szone.height());
		szone.scrollTop(szone[0].scrollHeight-szone.height());
		};
	}

$(function() {	
	$('#logs').click(function() {dcall('/containers/'+cid+'/logs'+$('#tlog').val(),'#insertHere',scrollBot);});
	$('#inspect').click(function() {render('/containers/'+cid+'/json','#inspectView');});
	$('#top').click(function() {render('/containers/'+cid+'/top','#topView');});

	render('/containers/'+cid+'/json','#inspectView');

	});
</SCRIPT>
<?$app->tailer();?>
