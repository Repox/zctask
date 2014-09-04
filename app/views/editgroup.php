<div class="row">
	<div class="col-md-12">
		<h1>Rediger gruppe</h1>
		<form method="post" action="" role="form">
		  <div class="form-group">
		    <label for="exampleInputName1">Gruppenavn</label>
		    <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="Gruppenavn" value="<?php echo issetOr($_POST['name'], $group['name']); ?>">
		  </div>
		  
		  <button type="submit" class="btn btn-default">Gem</button>
  		</form>		

  	</div>
</div>