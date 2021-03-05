<?php
include('./mini.inc.php');
include 'App.php';
$app->header('');
?>
<DIV class="BBUNCH">
<Button class="LINK MM" data-dest="containers.php">Containers</button>
<Button class="LINK MM" data-dest="images.php">Images</button>
<Button class="LINK" data-dest="version.php">Version</button>
</DIV>
<?$app->tailer();?>
