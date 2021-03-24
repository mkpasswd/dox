<?php
include('./mini.inc.php');
include('App.php');
include('T.class.php');

$title=T::gp('title','&lt;unset&gt;');
$app->header("Image $title");
?>

<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<template id="inspectView">
	<FIELDSET class="fset">
	<LABEL>RepoTags&nbsp;:</LABEL><DIV>
	{{range $tag := .RepoTags }}
		{{$tag}}<BR>
	{{end}}</DIV><BR>
	<LABEL>Comment&nbsp;:</LABEL>{{ $.Comment }}<BR>
	<LABEL>Created&nbsp;:</LABEL>{{ Trunc10 $.Created }}<BR>
	<LABEL>ExposedPorts&nbsp;:</LABEL>
	{{range $key, $port := .ContainerConfig.ExposedPorts }}
		{{$key}}
	{{end}}<BR>
	<LABEL>WorkingDir&nbsp;:</LABEL>{{ $.Config.WorkingDir}}<BR>
	<LABEL>Entrypoint&nbsp;:</LABEL><DIV>
	{{range $ep := .Config.Entrypoint }}
		{{$ep}}<BR>
	{{end}}</DIV><BR>
	<LABEL>DockerVersion&nbsp;:</LABEL>{{ $.DockerVersion }}<BR>
	<LABEL>Architecture&nbsp;:</LABEL>{{ $.Architecture }}<BR>
	<LABEL>Os&nbsp;:</LABEL>{{ $.Os }}<BR>
	<LABEL>Size&nbsp;:</LABEL>{{ MiB $.Size}}<BR>
	<LABEL>VirtualSize&nbsp;:</LABEL>{{ MiB $.VirtualSize}}<BR>
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
	ttify('/images/'+cid+'/json','#inspectView','#insertHere');
	});
</SCRIPT>
<?$app->tailer();?>
