﻿<?php
$str = "Linux;  11; SAMSUNG SM-G973U) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/14.2 Chrome/87.0.4280.141 Mobile Safari/537.36";
// $str = strtolower($str);
echo "$str<br>";
$pattern = "/androd|mobile|iphone/i";
if (preg_match($pattern, $str) === 1) {
	echo "Tem";
} else {
	echo "Não tem";
}	
?>