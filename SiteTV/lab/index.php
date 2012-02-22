<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Web TV Perso</title>
<meta name="description" content="">
<meta name="author" content="">
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
                      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
                    <![endif]-->
<!-- Le styles -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- <link href="players.css" rel="stylesheet"> -->
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(texturetastic_gray.png);
	padding-bottom: 40px;
	padding-top: 20px;
}

#top {
	padding-top: 40px;
}

.row-fluid .span10 {
	margin: 0;
}

.sidebar-nav {
	padding: 9px 0;
}

#loader {
	display: inline-block;
	width: 16px;
	height: 16px;
}

.loading {
	background: url(ajax-loader.gif) no-repeat center center;
}

.tvContainer{
	padding: 10px;
	margin-bottom: 10px;
}

/* @media ( min-width : 1201px) {
	.row-fluid .span6 {
		width: 100%;
	}
	.refreshBut {
		text-align: center;
	}
	.hiddenBut {
		visibility: hidden;
	}
} 

@media ( max-width : 1200px) {
	.row-fluid .span2 {
		width: 100%;
	}
	.row-fluid .span10 {
		width: 100%;
	}
	.row-fluid .span4 {
		width: 45%;
	}
	.hero-unit {
		padding: 10px;
		margin-bottom: 10px;
	}
	.refreshBut {
		margin-top: 30px;
	}
	.hero-unit {
		text-align: center;
	}
	.hiddenBut {
		visibility: yes;
	}
}*/
.accordion-toggle {
	text-align: center;
}

.row {
	min-height: 500px;
	min-width: 950px;
}

.tvContainer {
	text-align: center;
	min-height: 500px;
	min-width: 950px;
}

#live {
	height: 100%;
	width: 100%;
	margin: auto;
	background-image: url("fondTv.jpg");
	background-size: contain;
	background-repeat: no-repeat;
	background-color: #1E1D22;
	background-position: center;
	background-repeat: no-repeat;
}

#live h1 {
	padding: 200px;
}

.liveContainer {
	vertical-align: middle;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: 10px;
	padding: 5px;
	height: 500px;
	width: 930px;
	border: 1px solid #ddd;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
	-moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);
}

#nbAll {
	display: none;
	float: left;
	position: relative;
	left: -0.7em;
	top: -0.5em;
	padding: 2px;
	line-height: 1em;
	padding: 2px;
}

.dropdown-menu {
	max-width: 400px;
}

.icon-live {
	width: 25px;
	text-align: center;
	position: relative;
	left: -30px;
}

.fill {
	display: inline-block;
	width: 100%;
}
</style>
<script type="text/javascript" src="players.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>

</head>
<body>

	<!-- ######   TOP BAR  #######  -->
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="label label-important" id="nbAll"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
				</a> <a class="brand" href="#">Mes Web TV</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="dropdown" id="menu1"><a class="dropdown-toggle" data-toggle="dropdown" href="#menu1"> Chaines 1 <span style="display: none;" class="label label-important" id="nbChaines"></span> <b
								class="caret"></b>
						</a>
							<ul class="dropdown-menu" id="chaines">
							</ul>
						</li>
						<li class="dropdown" id="menu2"><a class="dropdown-toggle" data-toggle="dropdown" href="#menu2"> Chaines 2 <span style="display: none;" class="label label-important" id="nbHub"></span> <b
								class="caret"></b>
						</a>
							<ul class="dropdown-menu" id="jtv">
							</ul>
						</li>
						<li>
							<p class="navbar-text">
								<i id="loader"></i>
							</p>
						</li>
					</ul>
					
					
					
					
<?php if(!isset($_SESSION['myusername'])){ ?>
					<ul class="nav pull-right">
						<li><p class="navbar-text">Bienvenue !</p></li>
						<li class="divider-vertical"></li>
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Visiteur<b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><a onclick="refreshDesc();"> <i class="icon-refresh"></i> Rafraichissement
								</a></li>
								<li style="text-align: center;"><button id="refreshButton" data-toggle="button" class="btn" onclick="toggleAutoRefresh();">
										<i class="icon-refresh"></i> Automatique
									</button></li>
								<li class="divider"></li>
								<li>          
								<a href="#connectModal" data-toggle="modal"><i class="icon-off"></i> Connexion</a>
								</li>
							</ul>
						</li>
					</ul>
<?php } else { ?>
					<ul class="nav pull-right">
						<li><p class="navbar-text">Bienvenue !</p></li>
						<li class="divider-vertical"></li>
						<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['myusername']; ?> <b class="caret"></b> </a>
							<ul class="dropdown-menu">
								<li><a href="configuration.php"><i class="icon-cog"></i> Configuration</a></li>
								<li><a onclick="refreshDesc();"> <i class="icon-refresh"></i> Rafraichissement
								</a></li>
								<li style="text-align: center;"><button id="refreshButton" data-toggle="button" class="btn" onclick="toggleAutoRefresh();">
										<i class="icon-refresh"></i> Automatique (1 min)
									</button></li>
								<li class="divider"></li>
								<li><a href="logout.php"><i class="icon-off"></i> Déconnexion</a></li>
							</ul>
						</li>
					</ul>
<?php } ?>
				</div>
				<!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<!-- ######   CONTENT  #######  -->
	<div class="container">
		<div id="top"></div>
		<div class="row">

			<!--/span-->
			<!-- ######   LIVE TV  #######  -->
			<div class="span12">
				<div class="hero-unit tvContainer">
					<h2 id="tvtitle">Web TV</h2>
					<div class="liveContainer">
						<div id="live"></div>
					</div>
					<p>
						<a class="btn btn-primary btn-large" onclick="stop()"><i class="icon-stop icon-white"></i> Stop </a>
						<!-- 						<a class="btn btn-info btn-small hiddenBut" onclick="jumpToAnchor('#chainesG')"> <i class="icon-chevron-up icon-white"></i></a> -->

					</p>
				</div>
			</div>
		</div>
		
		<!-- #### Channels ##### -->
<style>
<!--
-->
#affichage_streams {
	line-height: 18px;
	margin: 20px 0 70px 0;
}

.streams {
	display: inline-block;
	float: left;
	margin-right: 1px;
	cursor: pointer;
}

.streams a {
	background: none !important;
}

#live_stream {
	position: relative;
	margin: 82px 0 0 0;
}
</style>
		<script src="jquery.tablesorter.min.js" type="text/javascript"></script>
		<script type="text/javascript">
$(function() {
                  $("table#sortTableExample").tablesorter({
                  sortList: [[2,1]] }); });
          </script>
		<div class="row">
			<div class="span12">
				<div class="">
					<h2>Chaines</h2>
					<div id="affichage_streams">
					<?php require("connect.php");?>
					<?php
         			  $streams = mysql_query('SELECT * FROM es_stream');          // 3
         			  $nb = mysql_num_rows($streams);                             // 4
         			  echo 'Il y a '.$nb.' enregistrement(s).';                   // 5
         			?>
						<ul id="liste_streams">
						<?php  while ($donnees = mysql_fetch_assoc($streams))
						{
						   ?>
							<li class="streams <?php echo $donnees['type']; ?> " style="display: block; width: 150px; height: 100px; border: solid; margin: 1em;" id="<?php echo $donnees['idstream']; ?>"><a href="?id= <?php echo $donnees['id']; ?>">
							<?php echo $donnees['title']; ?> <br />
							</a>
							</li>
							<?php
			  }
			  mysql_close($db);  // 6 
			  ?>
            </ul>		</div>
					</div>
			</div>
		</div>
		<!-- ######   PLAYLISTS  #######  -->

		<div class="row">
			<div class="span12">
				<div class="hero-unit" id="videos">
					<h2>Playlists</h2>
				</div>
			</div>

		</div>
		<!--/row-->

		<!--/span-->
		<!--/row-->
		<hr>
		<div id="messages"></div>

		<footer>
			<a href="http://www.adobe.com/go/getflashplayer" target="_blank"><img alt="Download flash" src="Flash_Player.jpg"> </a> <a href="http://affiliates.mozilla.org/link/banner/8294" target="_blank"> <img
				src="ff.png" alt="Télécharger : facile, amusant, génial"></img>
			</a>
			<p style="display: inline; float: right;">© Jereom 2012</p>
		</footer>
		
		
		
		
<?php include_once 'modals.php'; ?>

		<!-- ######   SCRIPT  #######  -->
		<script type="text/javascript">
		//init();
      		 $(document).ready(function(){
      			<?php if(isset($_GET['login_error'])){?>
      			 showModal();
     		    <?php } ?>
      		 });	 
		</script>

	</div>
	<!--/.fluid-container-->
	<!-- Le javascript
                    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!--     <script src="twitter-bootstrap-f68f787/js/jquery.js"></script> -->
	<script src="js/bootstrap-transition.js"></script>
	<script src="js/bootstrap-alert.js"></script>
	<script src="js/bootstrap-modal.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/bootstrap-scrollspy.js"></script>
	<script src="js/bootstrap-tab.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
	<script src="js/bootstrap-popover.js"></script>
	<script src="js/bootstrap-button.js"></script>
	<script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-carousel.js"></script>
	<script src="js/bootstrap-typeahead.js"></script>
</body>
</html>
