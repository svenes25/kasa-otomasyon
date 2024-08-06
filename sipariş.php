<?php
	include("header.php");
	$id=$_SESSION['id'];
	$sql="select * from mesai where p_id=$id
	order by id desc";
	$result=mysqli_query($baglanti,$sql);
	$row=mysqli_fetch_all($result);
	if($row)
	{
		$durum=$row[0][3];
	}
	else
	{
		$durum=1;
	}
	if(isset($_POST['mesai']))
	{
		if($durum)
		{
		}
		else
		{
			$ydurum=1;
			$anlik=date('Y-m-d H:i:s');
			$sqlm="insert into mesai(p_id,zaman,durum) values('$id','$anlik','$ydurum')";
			$resultm=mysqli_query($baglanti,$sqlm);
			if($resultm)
			{
				header("Location:Anasayfa");
			}
			else
			{
				$message='Mesai Bitirilirken Hata Oluştu';
			}
		}
		json_encode(['message' => $message]);
	}
	if(isset($_POST['ekle']))
	{
		header("Location:Ekle");
	}
	if(isset($_POST['guncelle']))
	{
		header("Location:Güncelle");
	}
	if(isset($_POST['sil']))
	{
		header("Location:Sil");
	}
	echo"<div class='container' align='center'> 
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div class='col-sm-6'>
				<div class='ekran'>";
					if($message)
					{
						echo"<div class='alert alert-$tur' role='alert'>
							$message
						</div>";
					}
					echo"<form method='POST'>
						<div class='row'>
							<div class='col-lg-6'>
								<button type='submit' class='btn m' name='mesai'>Mesai Bitir</button>";
							echo"</div>
							<div class='col-lg-6'>
								<button type='submit' class='btn e' name='ekle'>Sipariş Gir</button>
							</div>
						</div>
						<div class='row'>
							<div class='col-lg-6'>
								<button type='submit' class='btn g' name='guncelle'>Sipariş Güncelle</button>
							</div>
							<div class='col-lg-6'>
								<button type='submit' class='btn s' name='sil'>Sipariş Sil</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class='col-sm-3'>
			</div>
		
		</div>
	</div>";
	include("footer.php");
?>