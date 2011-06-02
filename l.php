<?php
    $base=$_GET['base'];
    if(is_dir($base))
    {
	$d=opendir($base);
	while($f=readdir($d))
	{
	    if($f!='.'&&$f!='..')
		echo "<a href='?base={$base}/{$f}'>{$f}</a><br />";
	}
    }
    else
    {
	header('content-type: application/octet-stream');
	readfile($base);
    }