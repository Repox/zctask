<div class="row">
	<div class="col-md-12">
		<h1>Opret bruger</h1>
		<form method="post" action="" role="form">
		  <div class="form-group">
		    <label for="exampleInputEmail1">E-mail addresse</label>
		    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="E-mail adresse" value="<?php echo issetOr($_POST['email']); ?>">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Kodeord</label>
		    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Kodeord">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword2">Kodeord (igen)</label>
		    <input type="password" name="password_confirm" class="form-control" id="exampleInputPassword2" placeholder="Kodeord (igen)">
		  </div>		  
		  <div class="form-group">
		  <?php foreach($groups as $group): ?>

			<label class="checkbox-inline">
			  <input type="checkbox" name="groups[<?php echo $group['id']; ?>]" id="inlineCheckbox1" value="<?php echo $group['id']; ?>"<?php echo (issetOr($_POST['groups'][$group['id']], false)) ? ' checked' : ''; ?>> <?php echo $group['name']; ?>
			</label>

			<?php endforeach; ?>
			</div>		  
		  <button type="submit" class="btn btn-default">Opret</button>
  		</form>		

  	</div>
</div>