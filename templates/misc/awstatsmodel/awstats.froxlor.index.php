<?php
$path = '{CUSTOMER_DOCROOT}';
$domain = '{SITE_DOMAIN}';

header('Content-type: text/html; charset=utf-8');
?><html>
<head>
<title>awstats - <?=$domain?></title>
</head>
<body>
<div style="font-family:Verdana, sans-serif;width: 200px; height: 100%; float: left; clear: both; background-color: #FFFFFF; color: #000000;">
<?php
$pathhandle = opendir($path);
while($year = readdir($pathhandle)){
        if (is_dir($year) && $year != '.' && $year != '..') { 

	      echo "<h3>$year</h3><ul>";

	      // Every subdir is a month, now month by month
	      $yearhandle = opendir("$path/$year");
	      while ($currmonth = readdir($yearhandle)) {	
		  if ($currmonth != '.' && $currmonth != '..') { 
			$month[] = $currmonth;		// Save
		  }
	      }
	      closedir($yearhandle);

	      sort($month,SORT_NUMERIC);	// Order month
	      foreach ($month as $currmonth) {
		    echo "<li><a href=\"$year/$currmonth/index.html\" target=\"conFrame\">$currmonth - $year</a></li>\n";
	      }

	      unset($month);
	      echo '</ul>';
	}
}
closedir($pathhandle);
//Aktuellen Monat als ersten anzeigen
$showCurrent="./"."".date("Y")."/".date("n")."/index.html";
?>
</div>
<iframe name="conFrame" style="position: absolute; top: 0px; left: 205px;height: 100%; min-width: 800px; width: 80%;float: left; clear: none;" src="<?php echo $showCurrent; ?>" />

</body></html>