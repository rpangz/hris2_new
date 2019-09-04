<?php 

function Terbilang($satuan){
	$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
	if ($satuan < 12)
		return " " . $huruf[$satuan];
	elseif ($satuan < 20)
		return Terbilang($satuan - 10) . "Belas";
	elseif ($satuan < 100)
		return Terbilang($satuan / 10) . " Puluh" . Terbilang($satuan % 10);
	elseif ($satuan < 200)
		return " seratus" . Terbilang($satuan - 100);
	elseif ($satuan < 1000)
		return Terbilang($satuan / 100) . " Ratus" . Terbilang($satuan % 100);
	elseif ($satuan < 2000)
		return " seribu" . Terbilang($satuan - 1000);
	elseif ($satuan < 1000000)
		return Terbilang($satuan / 1000) . " Ribu" . Terbilang($satuan % 1000);
	elseif ($satuan < 1000000000)
		return Terbilang($satuan / 1000000) . " Juta" . Terbilang($satuan % 1000000);
		
	elseif ($satuan >= 1000000000)
		echo "Hasil terbilang tidak dapat di proses karena nilai uang terlalu besar!"; 
}
?>