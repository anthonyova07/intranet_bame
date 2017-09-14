<?php

header("Content-Type: application/vnd.ms-excel");
if (isset($filename)) {
    header("Content-Disposition: attachment; filename=".$filename.".xls");
} else {
    header("Content-Disposition: attachment; filename=filename.xls");
}
header("Pragma: no-cache");
header("Expires: 0");
