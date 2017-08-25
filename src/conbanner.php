<?php session_start();
if(!$_SESSION['username']){
	header('Location : ./connexion2.php');
	exit();
}
?>
<head>
		<title>FoolBag</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon" href="images/512px-Paper-plane_font_awesome_white.svg.png" type="image/x-icon">
	</head>
		<body class="homepage">
		<div id="page-wrapper">
			<!-- Header -->
				<div id="header-wrapper" style="padding-top: 0px; height: 80px; padding-bottom: 10px;">
					<div id="header" class="container">
						<!-- Logo -->
							<h1 id="logo" ><a href="connected.php">FoolBag</a></h1>
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> - Mon compte</a>
										<ul>
											<li><a href="change.php"><i class="fa fa-cog" aria-hidden="true"></i>  - Gestion de compte</a></li>
											<li><a href="my_obj.php"><i class="fa fa-suitcase" aria-hidden="true"></i>  - Mes Colis</a></li>
											<li><a href="my_path.php"><i class="fa fa-plane" aria-hidden="true"></i>  - Mes Voyages</a></li>
											<li><a href="my_star.php"><i class="fa fa-star" aria-hidden="true"></i>  - Mes appréciations</a></li>
											<li><a href="deconnexion.php"><i class="fa fa-sign-out" aria-hidden="true"></i>  - Déconnexion</a></li>
										</ul>
									</li>
									<li><a href="perso.php"><?php echo $_SESSION['username'];?></a></li>
									<li><a href="sear_obj_result.php">Recherche de Colis</a></li>
									<li><a href="sear_path_result.php">Recherche de Voyages</a></li>
									<li><a href="about2.php"><i class="fa fa-info" aria-hidden="true"></i> - Comment ça marche ?</a></li>
								</ul>
							</nav>
					</div>
				</div>
				</div>
				</body>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>