<?php
include('baglan.php');

if (isset($_POST['urun'])) {
    $urun = $_POST['urun'];
    $sqls = "SELECT * FROM urunler WHERE id='$urun'";
    $results = mysqli_query($baglanti, $sqls);
    $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);

    if (count($rows) > 0) {
        $row = $rows[0];
        echo json_encode([
            'isim' => $row['isim'],
            'fiyat' => $row['fiyat'],
            'gorsel' => $row['gorsel']
        ]);
    } else {
        echo json_encode(['error' => 'Ürün bulunamadı']);
    }
} else {
    echo json_encode(['error' => 'Ürün seçilmedi']);
}
?>
