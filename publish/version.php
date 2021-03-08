<?php
include('./mini.inc.php');
include('App.php');

$app->header('Version');
?>
<!-- ============================ -->
<!-- GO TEMPLATES =============== -->
<!-- as browser may reorganize elements when HTML syntax is inappropriate
(ie: firefox tables), GO templates comment should go in HTML comments for safety reasons -->

<!-- =========== -->
<template id="view">
	<FIELDSET class="fset">
	<LABEL>Name&nbsp;:</LABEL>{{ $.Platform.Name }}<BR>
	<LABEL>Version&nbsp;:</LABEL>{{ $.Version }}<BR>
	<LABEL>ApiVersion&nbsp;:</LABEL>{{ $.ApiVersion }}<BR>
	<LABEL>MinApiVersion&nbsp;:</LABEL>{{ $.MinAPIVersion }}<BR>
	<LABEL>Arch&nbsp;:</LABEL>{{ $.Arch }}<BR>
	<LABEL>Os&nbsp;:</LABEL>{{ $.Os }}<BR>
	<LABEL>Kernel&nbsp;:</LABEL>{{ $.KernelVersion }}<BR>
	<LABEL>GoVersion&nbsp;:</LABEL>{{ $.GoVersion }}<BR>
	{{range $compo := .Components}}
	<LABEL><TT>{{$compo.Name}}</TT>&nbsp;:</LABEL>{{$compo.Version}}<BR>
	{{end}}
	</FIELDSET>
</template>

<!-- ============================ -->
<!-- RENDER ZONE ================ -->
<BR>
<div id="insertHere" style="height: 100%"></div>

<!-- ============================ -->
<!-- CONTROLER ================== -->
<SCRIPT>
$(function() {ttify('/version','#view','#insertHere');});
</SCRIPT>
<?$app->tailer();?>
