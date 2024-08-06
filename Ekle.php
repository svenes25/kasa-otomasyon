<?php
include("header.php");
$sql = 'SELECT * FROM urunler';
$result = mysqli_query($baglanti, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);

for ($i = 0; $i < count($row); $i++) {
    if (isset($_POST['ekle' . $i])) {
        $anlik = date('Y-m-d H:i:s');
        $id = $row[$i]['id'];
        $sql1 = "INSERT INTO siparis (u_id, zaman) VALUES ('$id', '$anlik')";
        $result1 = mysqli_query($baglanti, $sql1);
        if ($result1) {
            $message = 'Sipariş Başarıyla Eklendi';
        } else {
            $tur = "danger";
            $message = 'Sipariş Eklenemedi';
        }
    }
}
?>

<div class='container'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='ekle' align='center'>
                <form method='POST'>
                    <?php
                    if ($message) {
                        echo "<div class='alert alert-$tur' role='alert'>
                            $message
                        </div>";
                    }
                    for ($i = 0; $i < count($row); $i++) {
                        $id = $row[$i]['id'];
                        $isim = $row[$i]['isim'];
                        $fiyat = $row[$i]['fiyat'];
                        $gorsel = $row[$i]['gorsel'];

                        if ($i % 3 == 0) {
                            echo "<div class='row urun-row'>";
                        }

                        echo "<div class='col-lg-4'>
                            <div class='card equal-height-card' style='width: 18rem;'>
                                <img class='card-img-top' src='img/$gorsel' alt='Card image cap'>
                                <div class='card-body'>
                                    <h5 class='card-title'>$isim</h5>
                                    <p class='card-text'>$fiyat</p>
                                    <input type='submit' value='Sipariş' name='ekle$i'>
                                </div>
                            </div>
                          </div>";

                        if ($i % 3 == 2) {
                            echo "</div>";
                        }
                    }
                    if ($i % 3 != 0) {
                        echo "</div>";
                    }
                    ?>
                </form>
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
