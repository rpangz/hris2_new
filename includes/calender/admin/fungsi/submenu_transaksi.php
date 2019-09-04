<?PHP
$menu=mssql_query("SELECT * FROM tblModSubMenu WHERE ModMenuId='2'");
	while ($data =mssql_fetch_array($menu)){	
	echo "<font size=-1><a href='$data[ModSubMenuLink]'>$data[ModSubMenuName]</a> &#187 ";	
	}
	echo"<table id='tfhover' class='tftable' border='1'></p>";
?>