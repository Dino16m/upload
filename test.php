<?php
$string= 'I.am.groot';
$rep= preg_replace('/\./','_', $string);
echo $rep;
?>