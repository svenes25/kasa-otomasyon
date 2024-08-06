<?php
include("baglan.php");

if (isset($_POST['index'])) {
    $index = $_POST['index'];
	$sql1 = "SELECT u.id, u.isim, COUNT(u.id) as sayi FROM siparis as s
             INNER JOIN urunler as u ON u.id = s.u_id
             GROUP BY u.id
             ORDER BY sayi DESC";
    $sql2 = "SELECT p.id, p.isim, m.zaman, m.durum FROM mesai as m
             INNER JOIN personel as p ON p.id = m.p_id";
    $sql3 = "SELECT * FROM siparis";
    $sql4 = "SELECT * FROM urunler";
    $sorgu = array($sql1, $sql2, $sql3, $sql4);
    if ($index >= 0 && $index < count($sorgu)) {
        $sql = $sorgu[$index];
        $result = mysqli_query($baglanti, $sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if ($rows) 
		{
            echo "<table class='table'>
                    <thead>
                        <tr>";
            if ($index == 0) 
			{
                echo "<th>Ürün ID</th>
                      <th>Ürün İsmi</th>
                      <th>Toplam Satış</th>";
            }
			else if ($index == 1) 
			{
				$sqlp = "SELECT * FROM personel";
				$resultp = mysqli_query($baglanti, $sqlp);
				$rowp = mysqli_fetch_all($resultp, MYSQLI_ASSOC);

				$rows = array();
				for ($i = 1; $i < count($rowp); $i++)
				{
				$array = array();
				$id = $rowp[$i]['id'];  
				$isim = $rowp[$i]['isim']; 

				$sqlm = "SELECT * FROM mesai WHERE p_id='$id'";
				$resultm = mysqli_query($baglanti, $sqlm);
				$rowm = mysqli_fetch_all($resultm, MYSQLI_ASSOC);

				$totalzamam = 0;
				for ($j = 0; $j < count($rowm); $j++) {
					$durum = $rowm[$j]['durum'];  
					$zaman = $rowm[$j]['zaman'];  

					$saniye = strtotime($zaman);
					if ($durum == 1) {
						$totalzamam += $saniye;
					} else {
						$totalzamam -= $saniye;
					}
				}

				$yillar = floor($totalzamam / (365 * 24 * 60 * 60));
				$totalzamam -= $yillar * 365 * 24 * 60 * 60;

				$aylar = floor($totalzamam / (30 * 24 * 60 * 60));
				$totalzamam -= $aylar * 30 * 24 * 60 * 60;

				$gunler = floor($totalzamam / (24 * 60 * 60));
				$totalzamam -= $gunler * 24 * 60 * 60;

				$saatler = floor($totalzamam / (60 * 60));
				$totalzamam -= $saatler * 60 * 60;

				$dakikalar = floor($totalzamam / 60);
				$totalzamam -= $dakikalar * 60;

				$saniyeler = $totalzamam;
				$zamanString="";
				if($yillar<>0)
				{
					$zamanString.="$yillar yıl, ";
				}
				if($aylar<>0)
				{
					$zamanString.="$aylar ay, ";
				}
				if($gunler<>0)
				{
					$zamanString.="$gunler gün, ";
				}
				if($saatler<>0)
				{
					$zamanString.="$saatler saat, ";
				}
				if($dakikalar<>0)
				{
					$zamanString.="$dakikalar dakika, ";
				}
				$zamanString.="$saniyeler saniye";
				$array = array($id, $isim, $zamanString);
				$rows[] = $array;
				}
                echo "<th>Personel ID</th>
                      <th>Personel İsmi</th>
					  <th>Toplam Mesai</th>";
            }
			else if ($index ==4) 
			{
				$sqls="select u.isim,s.zaman,u.fiyat from siparis as s
				inner join urunler as u on u.id=s.u_id";
				$results=mysqli_query($baglanti,$sqls);
				$rows=mysqli_fetch_all($results);
				for($i=0;$i<count($rows);$i++)
				{
					$urun=$rows[$i][1];
					$zaman=$rows[$i][2];
					$fiyat=$rows[$i][3];
					$sqlm="select * from mesai as m
					inner join personel as p on p.id=m.p_id
					where ";
				}
                echo "<th>Personel ID</th>
                      <th>Personel İsmi</th>
					  <th>Tutar</th>
					  <th>% Cinsinden Verim</th>";
            }
			else if ($index == 3) 
			{
                echo "<th>Personel ID</th>
                      <th>Personel İsmi</th>
					  <th>Tutar</th>
					  <th>% Cinsinden Verim</th>";
            }
            echo "</tr>
                  </thead>
                  <tbody>";
            foreach ($rows as $row)
			{
                echo "<tr>";
                foreach ($row as $value)
				{
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</tbody>
                  </table>";
        } else {
            echo "<div class='alert alert-warning'>Kayıt bulunamadı.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Geçersiz filtre.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Geçersiz istek.</div>";
}
?>
