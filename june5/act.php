<title>Trait</title>
<?php
require_once('trait.php');
$Log = new Log();
$Log->Read('test.txt');
echo "<pre>";
echo $Log->Read('test.txt');