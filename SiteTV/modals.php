<!-- ######   MODAL  Add content#######  -->
<div class="modal" style="display: none;" id="myModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Ajout de contenu</h3>
	</div>
	<div class="modal-body">
		<h2 style="color: red;">La mémorisation n'est pas encore faite après le refresh de la page</h2>
		<form id="addContent">
			<p>
				Type : <select name="type">
					<option value="stream">Stream</option>

					<option value="playlist">Playlist Dailymotion</option>
				</select>
			</p>
			<p>
				Titre : <input type="text" name="title">
			</p>
			<p>
				Url : <input type="text" name="url">
			</p>
		</form>

		<p>Exemple stream :</p>
		<ul>
			<li>http://www.dailymotion.com/embed/video/xmehe4</li>
			<li>http://www.livestream.com/teamkigyar</li>
		</ul>
		<p>Exemple playlist :</p>
		<ul>
			<li>http://www.dailymotion.com/playlist/x1vmyd_dybex_another</li>
			<li>http://www.dailymotion.com/user/Millenium_TV</li>
		</ul>

	</div>
	<div class="modal-footer">
		<a onclick="saveModal()" class="btn btn-primary " data-dismiss="modal">Save changes</a> <a class="btn" data-dismiss="modal">Close</a>
	</div>

</div>

<!-- ######   MODAL Connexion #######  -->
<div class="modal" style="display: none;" id="connectModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">×</a>
		<h3>Connexion</h3>
	</div>
	<div style="text-align: center;" class="modal-body">
		<form action="checklogin.php" name="form1" method="post" enctype="multipart/form-data">
			<p>
				<input class="input-small" type="text" name="myusername" placeholder="Username">
			</p>
			<p>
				<input class="input-small" type="password" name="mypassword" placeholder="Password">
			</p>
			<p>
				<button class="btn btn-primary" type="submit" name="Submit" value="Login">Connexion</button>
			</p>
			<p>
				<a href="inscription.php">Inscription !</a>
			</p>
		</form>
			 <?php if(isset($_GET['login_error'])){?>
			<div id="alertLogin" class="alert alert-error" style="text-align: center;">
				<a class="close" onclick="$('#alertLogin').remove();">×</a> Erreur d'authentification, veuillez réessayer.
			</div>
			<?php } ?>
			</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">Close</a>
	</div>

</div>
