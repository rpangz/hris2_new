<?php
// bagian untuk Paging Artikel
class PagingArtikel{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=artikel&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Training
class PagingTraining{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=training&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}


// bagian untuk Paging Hot Topik
class PagingTopik{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=topik&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Hot Topik
class PagingBerita{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=berita&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Hot Topik
class PagingAgenda{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=agenda&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Training
class PagingMotra{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=motra&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Training
class PagingDownload{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=download&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Training
class PagingKlien{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=klien&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Training
class PagingPhoto{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=photo&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}
// bagian untuk Paging Group
class PagingGroup{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=group&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}


// bagian untuk Paging Iklan
class PagingIklan{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=iklan&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// bagian untuk Paging Link
class PagingLink{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET[halaman])){
			$posisi=0;
			$_GET[halaman]=1;
		}
		else{
			$posisi = ($_GET[halaman]-1) * $batas;	
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link halaman 1,2,3, ...
		for ($i=1; $i<=$jmlhalaman; $i++){
			if ($i == $halaman_aktif){
				$link_halaman .= "<b>$i</b> | ";
			}
			else{
				$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=link&halaman=$i>$i</a> | ";
			}
			$link_halaman .= " ";
		}
		return $link_halaman;
	}
}

// class paging untuk halaman user
class PagingUser{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET['halaman'])){
			$posisi=0;
			$_GET['halaman']=1;
		}
		else{
			$posisi = ($_GET['halaman']-1) * $batas;
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link ke halaman pertama (first) dan sebelumnya (prev)
		
		

		// Link halaman 1,2,3, ...
		$angka = ($halaman_aktif > 3 ? " ... " : " "); 
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
			if ($i < 1)
				continue;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
			}
			$angka .= " <b>$halaman_aktif</b>| ";
	  
		for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
			if($i > $jmlhalaman)
				break;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
		}
		$angka .= ($halaman_aktif+2<$jmlhalaman ? " ... | <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman>$jmlhalaman</a> | " : " ");

		$link_halaman .= "$angka";

		// Link ke halaman berikutnya (Next) dan terakhir (Last) 
		
		
		return $link_halaman;
	}
}



// class paging untuk halaman user-------------------------------------------------
class PagingKontak{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET['halaman'])){
			$posisi=0;
			$_GET['halaman']=1;
		}
		else{
			$posisi = ($_GET['halaman']-1) * $batas;
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		

		// Link halaman 1,2,3, ...
		$angka = ($halaman_aktif > 3 ? " ... " : " "); 
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
			if ($i < 1)
				continue;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
			}
			$angka .= " <b>$halaman_aktif</b> | ";
	  
		for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
			if($i > $jmlhalaman)
				break;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
		}
		$angka .= ($halaman_aktif+2<$jmlhalaman ? " ... | <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman>$jmlhalaman</a> | " : " ");

		$link_halaman .= "$angka";

		
		return $link_halaman;
	}
}
// class paging untuk halaman user
class Paging{
	// Fungsi untuk mencek halaman dan posisi data
	function cariPosisi($batas){
		if(empty($_GET['halaman'])){
			$posisi=0;
			$_GET['halaman']=1;
		}
		else{
			$posisi = ($_GET['halaman']-1) * $batas;
		}
		return $posisi;
	}

	// Fungsi untuk menghitung total halaman
	function jumlahHalaman($jmldata, $batas){
		$jmlhalaman = ceil($jmldata/$batas);
		return $jmlhalaman;
	}

	// Fungsi untuk link halaman 1,2,3 (untuk admin)
	function navHalaman($halaman_aktif, $jmlhalaman){
		$link_halaman = "";

		// Link ke halaman pertama (first) dan sebelumnya (prev)
		if($halaman_aktif > 1){
			$prev = $halaman_aktif-1;
			$link_halaman .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=1><< First</a> | <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$prev>< Prev</a> | ";
		}
		else{ 
			$link_halaman .= "<< First | < Prev | ";
		}

		// Link halaman 1,2,3, ...
		$angka = ($halaman_aktif > 3 ? " ... " : " "); 
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
			if ($i < 1)
				continue;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
			}
			$angka .= " <b>$halaman_aktif</b> | ";
	  
		for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
			if($i > $jmlhalaman)
				break;
				$angka .= "<a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$i>$i</a> | ";
		}
		$angka .= ($halaman_aktif+2<$jmlhalaman ? " ... | <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman>$jmlhalaman</a> | " : " ");

		$link_halaman .= "$angka";

		// Link ke halaman berikutnya (Next) dan terakhir (Last) 
		if($halaman_aktif < $jmlhalaman){
			$next = $halaman_aktif+1;
			$link_halaman .= " <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$next>Next ></a> | <a href=$_SERVER[PHP_SELF]?module=$_GET[module]&halaman=$jmlhalaman>Last >></a> ";
		}
		else{
			$link_halaman .= " Next > | Last >>";
		}
		return $link_halaman;
	}
}
?>