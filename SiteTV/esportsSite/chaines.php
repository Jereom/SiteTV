<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>WebTV</title>
<link rel="stylesheet"
	href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="content">
			<div class="page-header">
				<h1>
					WebTV <small>Ajout d'une nouvelle chaine</small>
				</h1>
			</div>
			<div class="row">
				<div class="span4">
					<h2>Nouveau</h2>
					<form action="addStream.php" method="post"
						enctype="multipart/form-data">
						<em>id : <input type="text" name="id" /> Type : <select
							name="type">
								<option value="dm">Dailymotion</option>
								<option value="jtv">Twitch</option>
								<option value="ls">Livestream</option>
						</select> <input type="submit" value="Valider" />
						</em>
					</form>
				</div>
				<div class="span10">
					<h3>Chaines</h3>
					<script src="jquery-1.7.1.min.js"></script>
					<script src="jquery.tablesorter.min.js"></script>
					<script>
					$(function() {
						$("table#sortTableExample").tablesorter({ sortList: [[2,1]] });
						});    
					</script>
					<table id="sortTableExample" class="zebra-striped">
						<thead>
							<tr>
								<th class="yellow header headerSortDown">Id</th>
								<th class="blue header">Type</th>
								<th class="green header">Onair</th>
							</tr>
						</thead>
						<tbody>
						<?php require("connect.php");?>
						<?php require("refreshDB.php");?>
						<?php
						require_once 'Dailymotion.php';

						$streams = mysql_query('SELECT * FROM es_stream');          // 3
						$nb = mysql_num_rows($streams);                               // 4
						echo 'Il y a '.$nb.' enregistrement(s).';  // 5
							
						$query="SELECT value FROM es_infos WHERE es_infos.key='lastupdate'";
						$lastUpdate = tryquery($query);
						$lastUpdate=mysql_fetch_assoc($lastUpdate);
						$lastUpdate = $lastUpdate['value'];
						$delta=(time() - $lastUpdate) / 60;
						if($delta > 0){
						   $lastUpdate = time();
						   $ret = mysql_update_infos('lastupdate',$lastUpdate);
						   	
						   refreshDM();
						   
						   $delta=0;
						}
						printf(' (Mise à jour il y a %s min)', $delta);
						while ($donnees = mysql_fetch_assoc($streams))
						{
						   ?>
							<tr>
								<td>                                    
								<?php echo $donnees['title']; ?>
								</td>
								<td>
								<?php echo $donnees['type']; ?>
								</td>
								<td>
								<?php echo $donnees['onair']; ?>
								</td>
							</tr>
                        <?php
                        }
                        mysql_close($db);  // 6 
                        ?>                                                 
              </tbody>
					</table>
				</div>
			</div>
		</div>
		<footer>
			<p>&copy; Jereom 2012</p>
		</footer>
	</div>
	<!-- /container -->
</body>
</html>
