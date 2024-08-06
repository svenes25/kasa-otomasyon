<?php
	include("header.php");
	if(isset($_POST['giris']))
	{
		$kadi=$_POST['kadi'];
		$sifre=$_POST['sifre'];
		if($kadi!=null and $sifre!=null)
		{
			$sql="Select * from personel where isim='$kadi' and sifre='$sifre'";
			$result=mysqli_query($baglanti,$sql);
			$row=mysqli_fetch_all($result);
			if($row)
			{
				$_SESSION['id']=$row[0][0];
				if($row[0][0]!=1)
				{
					header("Location:Anasayfa");
				}
				else
				{
					header("Location:Admin");
				}
			}
			else
			{
				$tur='danger';
				$message='Kullanıcı Adı veya Şifre Yanlış';
			}
		}
		else
		{
			$tur='danger';
			$message='Lütfen Bilgileri Boş Bırakmayın';
		}
	}
?>
	<div class='container' align='center' style=''>
		<div class='row'>
			<div class='col-lg-4'>
			</div>
			<div class='col-lg-4'>
				<div class='ekran'>
					<?php
					if($message)
					{
						echo"<div class='alert alert-$tur' role='alert'>
							$message
						</div>";
					}
					?>
					<form method='POST'>
						<input type='Text' placeholder='Kullanıcı Adı' name='kadi'>
						<input type='password' placeholder='Şifre' name='sifre'>
						<input type='submit' value='Giriş' name='giris'>
					</form>
				</div>
			</div>
			<div class='col-lg-4'>
			</div>
		</div>
	</div>
		
<?php
	include("footer.php");
?>