<?php
include('./mini.inc.php');
include 'App.php';
$app->header('');
?>
<DIV class="BBUNCH">
<Button class="L" data-dest="containers.php">Containers</button>
<Button class="L" data-dest="images.php">Images</button>
<Button class="L" data-dest="version.php">Version</button>
</DIV>
<SCRIPT>
$(function() {$('.L').click(function() {window.location=$(this).data('dest');});});
</SCRIPT>
<?$app->tailer();?>
