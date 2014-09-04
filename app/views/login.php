<div class="container">

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form class="form-signin" role="form" method="post" action="<?php echo url('/login'); ?>">
			<h2>Log ind</h2>
			<input type="username" class="form-control" placeholder="Brugernavn" required autofocus>
			<input type="password" class="form-control" placeholder="Kodeord" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Log ind</button>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<h4>Endnu ikke registreret?</h4>
			<a href="<?php echo url('/registrer'); ?>" title="Opret bruger">Opret en bruger med det samme!</a>
		</div>
	</div>

</div>