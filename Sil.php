<?php	
include("header.php");
$anlik = date('Y-m-d');
$sql = "SELECT s.id,u.isim,u.fiyat,s.zaman FROM siparis as s
inner join urunler as u on u.id=s.u_id
where CAST(zaman AS DATE)='$anlik'
order by s.id desc";
$result = mysqli_query($baglanti, $sql);
$row = mysqli_fetch_all($result);

for ($i = 0; $i < count($row); $i++) {
    if (isset($_POST['sil' . $i])) {
        $id = $row[$i][0];
        $sql1 = "delete from siparis where id='$id'";
        $result1 = mysqli_query($baglanti, $sql1);
        if ($result1) 
		{        
		$message = 'Sipariş Başarıyla Silindi';
        } 
		else {
            $tur = "danger";
            $message = 'Sipariş Silindi';
        }
    }
}
?>

<div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='ekle' align='center'>
                <table class='table'>
					<tr>
						<th>İsim</th>
						<th>Fiyat</th>
						<th>Zaman</th>
						<th>Sil</th>
					</tr>
					<form method='POST'>
						<?php
						if ($message) 
						{
							echo "<div class='alert alert-$tur' role='alert'>
								$message
							</div>";
						}
						for ($i = 0; $i < count($row); $i++) 
						{
							$id = $row[$i][0];
							$isim = $row[$i][1];
							$fiyat=$row[$i][2];
							$tarih = $row[$i][3];
							echo"<tr>
							<th>$isim</th>
							<th>$fiyat</th>
							<th>$tarih</th>
							<th><input type='submit' Value='Sil' name='sil$i'><th>
							</tr>
							";
						}
						?>
					</form>
				</table>
            </div>
        </div>
		<div class='row' align='center'>
			<div class='col-lg-12'>
				<h3><a href='Sipariş'>Geri Dön</a></h3>
			</div>
		</div>
    </div>
</div>

<?php
include("footer.php");
?>
