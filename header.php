<?php
include("baglan.php");
session_start();
$tur='success';
$message=null;
$current_page = basename($_SERVER['PHP_SELF']);
$allowed_pages = array('index.php',);
if (!in_array($current_page, $allowed_pages) && $_SESSION['id'] == null) 
{
    header('Location:/kasa otomasyon');
}
?>
<html>	
	<head>
		<meta charset="utf-8">
		<title>Online Sipariş</title>	
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/owl.carousel.min.css">
		<link rel="shortcut icon" href="img/bt.png" type="image/x-icon"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>		
	<body>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/default.js"></script>
		<div class='container'>
			<div class='row'>
				<div class='col-sm-3 navbar navbar-expand-lg bg-body-tertiary d-flex justify-content-center align-items-center'>
					<a><img src='img/bt.png' style='width:100px'></a>
				</div>
				<div class='col-sm-6 d-flex align-items-center'>
					<nav class="navbar navbar-expand-lg bg-body-tertiary h-100 w-100">
						<div class="container-fluid">
							<div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
								<div class="navbar-nav">
									<a class="nav-link">Hatay Medeniyet Sofrası</a>
								</div>
							</div>
						</div>
					</nav>
				</div>
				<div class='col-sm-3 navbar navbar-expand-lg bg-body-tertiary d-flex justify-content-center align-items-center'>
					<?php
						if($_SESSION)
						{
							echo "<a class='nav-link' href='Çıkış'>Çıkış</a>";
						}
					?>
				</div>
			</div>
		</div>