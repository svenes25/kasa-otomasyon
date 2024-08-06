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
			$ydurum=0;
			$anlik=date('Y-m-d H:i:s');
			$sqlm="insert into mesai(p_id,zaman,durum) values('$id','$anlik','$ydurum')";
			$resultm=mysqli_query($baglanti,$sqlm);
			if($resultm)
			{
				header("Location:Sipariş");
			}
			else
			{
				$message='Mesai Başlatılırken Hata Oluştu';
			}
		}
		else
		{
			header("Location:Sipariş");
		}
		json_encode(['message' => $message]);
	}
	echo"<div class='container' align='center'> 
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div class='col-sm-6 ekran'>";
				if($message)
				{
					echo"<div class='alert alert-$tur' role='alert'>
							$message
						</div>";
				}
					echo"<form method='POST'>
						<button type='submit' class='btn m' name='mesai'>Mesai Başlat</button>
					</form>
			</div>
			<div class='col-sm-3'>
			</div>
		
		</div>
	</div>";
	include("footer.php");
?>