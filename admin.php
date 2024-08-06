<?php
	include("header.php");
	function resimyukle($resim,$prefix,$dhedef)
	{
		$yer = $resim['tmp_name'];
		$boyut = $resim['size'];
		$max_boyut=10000000;
		if($boyut<$max_boyut)
		{
			$uzanti = strtolower(pathinfo($resim["name"], PATHINFO_EXTENSION));
			$izinverilen=array("jpg", "jpeg", "png"); 
			if(!in_array($uzanti, $izinverilen))
			{
				return array("hata","Fotoğrafın türü tanınamadı, geçerli türler: ".implode(" ", $izinverilen));
			}
			$isim= $prefix."_".time();
			$yeniad = $isim.".".$uzanti;
			$hedef = $dhedef.'/'.$yeniad;
			if (move_uploaded_file($yer, $hedef))
			{
				return array("tamam",$yeniad);
			}
			else
			{
				return array("hata","yeni dosya yazılamadı:".$hedef);
			}
		}
	}
	if(isset($_POST["ekle"]))
	{
		$tur='success';
		$isim=$_POST['isim'];
		$fiyat=$_POST['fiyat'];
		if(isset($_FILES["resim"]["name"]))
		{	
			$file = $_FILES['resim'];
			$resimy = resimyukle($_FILES["resim"],"resim","img");
			if($resimy[0]=="tamam")
			{
				$veriler["resim"] = $resimy[1];
				$grsl=$resimy[1];
				$sql="insert into urunler(isim,fiyat,gorsel) values('$isim','$fiyat','$grsl')";
				$sonuc = mysqli_query($baglanti,$sql);
				if($sonuc)
				{
					$message='Ürün Başarıyla Eklendi...';
				}
				else
				{
					$tur='danger';
					$message='Ürün Eklenemedi...';
				}
			}	
		}
		header("Cache-Control: no-cache, must-revalidate");
	}
	if(isset($_POST["guncelle"]))
	{
		$tur='success';
		$message=null;
		$id=$_POST['urun'];
		$isim=$_POST['gisim'];
		$fiyat=$_POST['gfiyat'];
		$fiyat=(double) $fiyat;
		if(isset($_FILES["resim"]["name"]))
		{	
			$file = $_FILES['resim'];
			$resimy = resimyukle($_FILES["resim"],"resim","img");
			if($resimy[0]=="tamam")
			{
				$veriler["resim"] = $resimy[1];
				$grsl=$resimy[1];
				$message="burda";
				$sql="update urun set gorsel='$grsl', isim='$isim', fiyat='$fiyat' where id='$id'";
				$sonuc = mysqli_query($baglanti,$sql);
				if($sonuc)
				{
					$message='Ürün Başarıyla Güncellendi...';
				}
				else
				{
					$tur='danger';
					$message='Ürün Güncellenemedi...';
				}
			}
			else
			{
				$sql="update urunler set isim='$isim', fiyat='$fiyat' where id='$id'";
				$sonuc = mysqli_query($baglanti,$sql);
				if($sonuc)
				{
					$message='Ürün Başarıyla Güncellendi...';
				}
				else
				{
					$tur='danger';
					$message='Ürün Güncellenemedi...';
				}
			}					
		}
		header("Cache-Control: no-cache, must-revalidate");
	}
	if(isset($_POST['sil']))
	{
		$id=$_POST['urun'];
		if($id)
		{
			$sql="delete from urunler where id='$id'";
			$result=mysqli_query($baglanti,$sql);
			if($result)
			{
				$message="Ürün Başarıyla Silindi...";
			}
			else
			{
				$tur="danger";
				$message="Ürün Silinemedi...";
			}
		}
		else
		{
			$tur="danger";
			$message="Lütfen Bir Ürün Seçin";
		}
	}
	$sql="select * from personel";
	$result=mysqli_query($baglanti,$sql);
	$row=mysqli_fetch_all($result);
	for($i=0;$i<count($row);$i++)
	{
		$id=$row[$i][0];
		if(isset($_POST['psil'.$i]))
		{
			$sqls="delete from personel where id=$id";
			$results=mysqli_query($baglanti,$sqls);
			if($results	)
			{
				$message="Personel Başarıyla Silindi...";
			}
			else
			{
				$tur="danger";
				$message="Personel Silinemedi...";
			}
		}
		if(isset($_POST["pguncelle"]))
		{
			$id=$row[$i][0];
			$isim=$_POST['gisim'.$i];
			$sifre=$_POST['gsifre'.$i];
			$sqlg="update personel set isim='$isim', sifre='$sifre' where id=$id";
			$resultg=mysqli_query($baglanti,$sqlg);
			if($resultg)
			{
				$message="Personel Bilgileri Başarıyla Güncellendi";
			}
			else
			{
				$tur="danger";
				$message="Personel Bilgileri Güncellenemedi";
			}
		}
	}
	if(isset($_POST['pekle']))
	{
		$isim=$_POST['eisim'];
		$sifre=$_POST['esifre'];
		if($isim<>'' and $sifre<>'')
		{
			$sqle="insert into personel(isim,sifre) values('$isim','$sifre')";
			$resulte=mysqli_query($baglanti,$sqle);
			if($resulte)
			{
				$message="Personel Başarıyla Eklendi";
			}
			else
			{
				$tur="danger";
				$message="Personel Eklenemedi";
			}
		}
		else
		{
			$tur="danger";
			$message="Lütfen Değerleri Boş Bırakmayın";
		}
	}
?>
<div class='container' align='center'>
    <div class='row'>
        <div class='col-sm-3'>
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
                <a class="d-flex align-items-center mb-3 mb-md-auto me-md-auto link-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"></svg>
                    <span class="fs-4">Panel</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a class="nav-link link-dark sidebar" data-section='analiz'>
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Analiz
                        </a>
                    </li>
					<li>
                        <a class="nav-link link-dark sidebar" data-section='ekle'>
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Ürün Ekle
                        </a>
                    </li>
                    <li>
                        <a class="nav-link link-dark sidebar" data-section='güncelle'>
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Ürün Güncelle
                        </a>
                    </li>
                    <li>
                        <a class="nav-link link-dark sidebar" data-section='sil'>
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Ürün Sil
                        </a>
                    </li>
					<li>
                        <a class="nav-link link-dark sidebar" data-section='personel'>
                        <svg class="bi me-2" width="16" height="16"></svg>
                        Personel
                        </a>
                    </li>
                </ul>
                <hr>
				<a class="nav-link link-dark" href='/online siparis' data-section='analiz'>
					<svg class="bi me-2" width="16" height="16"></svg>
                    Çıkış
                </a>
            </div>
        </div>
        <div class='col-sm-9'>
			<?php
					if($message)
					{
						echo"<div class='alert alert-$tur' role='alert'>
							$message
						</div>";
					}
				?>
            <div class='panel'>
				<div class='analiz'>
					<table class='table'>
						<?php
						$filtre = array("En Çok Satılan Ürün", "Toplam Mesailer", "Mesaide En Çok Kazandıran", "Son 1 Haftada En Çok Kazandıran Ürün");
						$sql1 = "SELECT u.id, u.isim, COUNT(u.id) as sayi FROM siparis as s
								 INNER JOIN urunler as u ON u.id = s.u_id
								 GROUP BY u_id
								 ORDER BY sayi DESC";
						$sql2 = "SELECT p.id, p.isim, m.zaman, m.durum FROM mesai as m
								 INNER JOIN personel as p ON p.id = m.p_id";
						$sql3 = "SELECT * FROM siparis";
						$sql4 = "SELECT * FROM urunler";
						$sorgu = array($sql1, $sql2, $sql3, $sql4);

						echo "<form id='filterForm'>";
						echo "<tr>";
						echo "<th colspan='3'><label>Filtre Seç</label>
								<select name='filtre' id='filtre'>
									<option value=''>Filtreler</option>";
						for ($i = 0; $i < count($filtre); $i++) {
							echo "<option value='$i'>" . $filtre[$i] . "</option>";
						}
						echo "</select></th>";
						echo "<th colspan='2'><input type='button' value='Seç' id='filtreleButton2'></th>";
						echo "</tr>";
						echo "</form>";
						$sqlmesai="select * from mesai";
						$resultm=mysqli_query($baglanti,$sqlmesai);
						$rowm=mysqli_fetch_all($resultm);
						$mesailer=[];
						$verimler=[];
						for($m=0;$m<count($rowm);$m++)
						{
							$mid=$rowm[$m][0];
							$pid=$rowm[$m][1];
							$zamanm=$rowm[$m][2];
							$durumm=$rowm[$m][3];
							$personel=array($mid,$pid,$zamanm,$durumm);
							$mesailer[]=$personel;
						}
						$id=$mesailer[0][0];
						$p=$mesailer[0][1];
						$zaman=$mesailer[0][2];
						$durum=$mesailer[0][3];
						$persayisi=0;
						//VERİM = (TOTAL SİPARİS)/(SAAT * KİŞİ SAYISI)
						for($i=0;$i<count($mesailer);$i++)
						{
							$ids=$mesailer[$i][0];
							$ps=$mesailer[$i][1];
							$zamans=$mesailer[$i][2];
							$durums=$mesailer[$i][3];
							if($durums==0)
							{
								$persayisi++;
							}
							else
							{
								$persayisi--;
							}
							if($persayisi==0)
							{
								$persayisi++;
							}
							if($durums!=$durum and $ps==$p)
							{
								$sqlv="select * from siparis
								where zaman > '$zaman' and zaman < '$zamans';";
								$resultv=mysqli_query($baglanti,$sqlv);
								$count=mysqli_num_rows($resultv);
								$bitis=strtotime($zamans);
								$basla=strtotime($zaman);
								$fark=$bitis-$basla;
								$fark=(float) ($fark/(60*60));
								if($fark!=0)
								{
									$verim=(float) ($count)/($fark * $persayisi);
									$verims=array($ids,$ps,$verim);
									$verimler[]=$verims;
								}
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							else if($durums==$durum and $ps!=$p)
							{
								$sqlv="select * from siparis
								where zaman > '$zaman' and zaman < '$zamans';";
								$resultv=mysqli_query($baglanti,$sqlv);
								$count=mysqli_num_rows($resultv);
								$bitis=strtotime($zamans);
								$basla=strtotime($zaman);
								$fark=$bitis-$basla;
								$fark=floor($fark/(60*60));
								$fark++;
								if($fark!=0)
								{
									$verim=(float)($count)/($fark * $persayisi);
									$verims=array($ids,$ps,$verim);
									$verimler[]=$verims;
								}
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							else if($durums!=$durum and $ps!=$p)
							{
								$id=$ids;
								$p=$ps;
								$zaman=$zamans;
								$durum=$durums;
							}
							echo $fark."\n";
						}
						echo"<pre>";
						print_r($verimler);
						echo"</pre>";
/*						$mesaiData = [
						['p_id' => 1, 'zaman' => '08:00', 'durum' => 0],
						['p_id' => 1, 'zaman' => '16:00', 'durum' => 1],
						['p_id' => 2, 'zaman' => '10:00', 'durum' => 0],
						['p_id' => 2, 'zaman' => '17:00', 'durum' => 1],
						['p_id' => 3, 'zaman' => '14:00', 'durum' => 0],
						['p_id' => 3, 'zaman' => '18:00', 'durum' => 1],
						['p_id' => 4, 'zaman' => '18:00', 'durum' => 0],
						['p_id' => 4, 'zaman' => '24:00', 'durum' => 1],
					];

					$siparisData = [
						['zaman' => '08:00', 'count' => 30],
						['zaman' => '10:00', 'count' => 40],
						['zaman' => '14:00', 'count' => 60],
						['zaman' => '16:00', 'count' => 50],
						['zaman' => '17:00', 'count' => 30],
						['zaman' => '18:00', 'count' => 20],
					];
			$personelVerim = calculateEfficiency($mesaiData, $siparisData);
			function calculateEfficiency($mesaiData, $siparisData) {
				$personelVerim = [];
				$currentMesai = [];

			foreach ($mesaiData as $mesai) {
				$p_id = $mesai['p_id'];
				$zaman = strtotime($mesai['zaman']);
				$durum = $mesai['durum'];

				if ($durum == 0) { // Mesai başlıyor
					$currentMesai[$p_id] = $zaman;
				} else { // Mesai bitiyor
					$mesaiBaslangic = $currentMesai[$p_id];
					$mesaiBitis = $zaman;
					$mesaiSuresi = ($mesaiBitis - $mesaiBaslangic) / 3600; // Saat cinsinden mesai süresi

					// Mesai süresindeki siparişleri filtreleyin
					$siparisCount = 0;
					foreach ($siparisData as $siparis) {
						$siparisZaman = strtotime($siparis['zaman']);
						if ($siparisZaman >= $mesaiBaslangic && $siparisZaman <= $mesaiBitis) {
							$siparisCount += $siparis['count'];
						}
					}

					// Mesai süresindeki personel sayısını bulun
					$personelSayisi = count(array_filter($currentMesai, function($start) use ($mesaiBitis) {
						return $start <= $mesaiBitis;
					}));

					// Verimi hesaplayın
					if ($mesaiSuresi > 0 && $personelSayisi > 0) {
						$verim = $siparisCount / ($mesaiSuresi * $personelSayisi);
						if (!isset($personelVerim[$p_id])) {
							$personelVerim[$p_id] = [];
						}
						$personelVerim[$p_id][] = $verim;
					}

					unset($currentMesai[$p_id]);
				}
			}

			return $personelVerim;
		}

		// Verim sonuçlarını ekrana yazdır
		foreach ($personelVerim as $p_id => $verimArray) {
			$averageVerim = array_sum($verimArray) / count($verimArray);
			echo "Personel ID: $p_id - Ortalama Verim: " . number_format($averageVerim, 2) . "\n";
		}
*/
			/*$sqlMesai = "SELECT * FROM mesai ORDER BY p_id, zaman";
$resultMesai = mysqli_query($baglanti, $sqlMesai);
$mesaiData = mysqli_fetch_all($resultMesai, MYSQLI_ASSOC);

// Sipariş verilerini çek
$sqlSiparis = "SELECT * FROM siparis ORDER BY zaman";
$resultSiparis = mysqli_query($baglanti, $sqlSiparis);
$siparisData = mysqli_fetch_all($resultSiparis, MYSQLI_ASSOC);

$personelVerim = calculateEfficiency($mesaiData, $siparisData);

function calculateEfficiency($mesaiData, $siparisData) {
    $personelVerim = [];
    $currentMesai = [];
    $currentOrders = [];

    foreach ($mesaiData as $mesai) {
        $p_id = $mesai['p_id'];
        $zaman = strtotime($mesai['zaman']);
        $durum = $mesai['durum'];

        if ($durum == 0) { // Mesai başlıyor
            $currentMesai[$p_id] = $zaman;
        } else { // Mesai bitiyor
            $mesaiBaslangic = $currentMesai[$p_id];
            $mesaiSuresi = ($zaman - $mesaiBaslangic) / 3600; // Saat cinsinden mesai süresi

            // Mesai süresindeki siparişleri filtreleyin
            $siparisCount = 0;
            foreach ($siparisData as $siparis) {
                $siparisZaman = strtotime($siparis['zaman']);
                if ($siparisZaman >= $mesaiBaslangic && $siparisZaman <= $zaman) {
                    $siparisCount++;
                }
            }

            // Mesai süresindeki personel sayısını bulun
            $personelSayisi = count($currentMesai);

            // Verimi hesaplayın
            if ($mesaiSuresi > 0 && $personelSayisi > 0) {
                $verim = $siparisCount / ($mesaiSuresi * $personelSayisi);
                $personelVerim[$p_id][] = $verim;
            }

            unset($currentMesai[$p_id]);
        }
    }

    return $personelVerim;
}

// Verim sonuçlarını ekrana yazdır
foreach ($personelVerim as $p_id => $verimArray) {
    $averageVerim = array_sum($verimArray) / count($verimArray);
    echo "Personel ID: $p_id - Ortalama Verim: " . number_format($averageVerim, 2) . "\n";
}
*/
						?>

					</table>
					<div id="productDetails2"></div>
				</div>
                <div class='ekle'>
                    <form method='POST' enctype='multipart/form-data'>
                        <input type='text' placeholder='İsim' name='isim'>
                        <input type='number' placeholder='Fiyat' min=1 name='fiyat'>
                        <input type='file' name='resim'>
                        <input type='submit' value='Ekle' name='ekle'>
                    </form>
                </div>
                <div class='güncelle'>
					<table>
						<?php
							$sql = 'SELECT * FROM urunler';
							$result = mysqli_query($baglanti, $sql);
							$row = mysqli_fetch_all($result);
							echo "<form id='filterForm'>";
							echo "<tr>";
							echo "<th colspan='3'><label>Ürün Seç</label>
									<select name='urun' id='urun'>
										<option value='0'>Ürünler</option>";
							for ($i = 0; $i < count($row); $i++) {
								echo "<option value=" . $row[$i][0] . ">" . $row[$i][1] . "</option>";
							}
							echo "</th>";
							echo "<th colspan='2'><input type='button' value='Seç' id='filtreleButton'></th>";
							echo "</tr>";
							echo "</form>";
						?>
					</table>
					<div id="productDetails">
					</div>
				</div>
                <div class='sil'>
                    <table>
						<?php
							$sql = 'SELECT * FROM urunler';
							$result = mysqli_query($baglanti, $sql);
							$row = mysqli_fetch_all($result);
							echo "<form method='POST'>";
							echo "<tr>";
							echo "<th colspan='3'><label>Ürün Seç</label>
									<select name='urun' id='urun'>
										<option value='0'>Ürünler</option>";
							for ($i = 0; $i < count($row); $i++) {
								echo "<option value=" . $row[$i][0] . ">" . $row[$i][1] . "</option>";
							}
							echo "</th>";
							echo "<th colspan='2'><input type='submit' value='Sil' name='sil'></th>";
							echo "</tr>";
							echo "</form>";
						?>
					</table>
                </div>
				<div class='personel'>
                    <table>
						<form method='POST'>
						<?php
							$sql = 'SELECT * FROM personel';
							$result = mysqli_query($baglanti, $sql);
							$row = mysqli_fetch_all($result);
							echo"<tr>
								<th>İsim</th>
								<th>Şifre</th>
								<th>Sil</th>
							</tr>";
							for($i=0;$i<count($row);$i++)
							{
								$id=$row[$i][0];
								$isim=$row[$i][1];
								$sifre=$row[$i][2];
								echo "<tr>
								<td><input type='text' value='$isim' name='gisim$i'></td>
								<td><input type='text' value='$sifre' name='gsifre$i'></td>
								<td><input type='submit' value='Sil' name='psil$i'></td>";
							}
							echo"<tr><td colspan='4' align='center'><h5>Personel EKLE</h5></td></tr>
							<tr>
								<td><input type='text' name='eisim' placeholder='İsim'></td>
								<td><input type='text' name='esifre' placeholder='Şifre'></td>
								<td><input type='submit' value='Ekle' name='pekle'></td>
							</tr>
							<tr>
								<td colspan='4' align='center'><h5>Güncelle</h5></td>
							</tr>
							<tr>
								<td colspan='4' align='center'><input type='submit' value='Güncelle' name='pguncelle'><td>
							</tr>";
						?>
						</form>
					</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
	include("footer.php");
?>