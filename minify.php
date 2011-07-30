<?php

require_once('PHPMinifier.php');

$filename = $_REQUEST['output'];

header("Content-Type: application/x-download");
header("Content-Disposition: attachment; filename=\"$filename\"");
fpassthru(PHPMinifier::Minify($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]));

?>