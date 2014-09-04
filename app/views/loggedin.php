<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Logget ind som <?php echo $user['email']; ?></h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h3>Grupper du er medlem af:</h3>
			<?php if(empty($groups)): ?>
				Desværre ingen endnu.
			<?php else: ?>
			<?php foreach($groups as $group): ?>
				<?php echo $group['name']; ?><br>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>


