<?php

	$host = "localhost";
	$kullaniciadi = "root";
	$parola = "";
	$vt = "kasa";
	
	$baglanti = mysqli_connect($host,$kullaniciadi,$parola,$vt);
	mysqli_set_charset($baglanti,"UTF8");
	
	if($baglanti)
	{
	}
	else
	{
			echo "<script  type='text/javascript'>
				confirm('Bağlantıda Hata Oluştu');
				</script>";
	}
?>