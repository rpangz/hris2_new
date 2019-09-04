<?PHP
include "../koneksi/koneksi.php";

$menu=mssql_query("SELECT * FROM tblModSubMenu");
	while ($data = mssql_fetch_array($menu)){	
	echo "<li><a href='$data[ModSubMenuLink]'>$data[ModSubMenuName]</a></li>";	
	}
?>