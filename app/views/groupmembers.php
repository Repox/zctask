<div class="row">
	<div class="col-md-12">
<h3>Medlemmer i "<?php echo $group['name']; ?>"</h3>
<table class="table table-striped">
	<thead>
		<tr>
		  	<th>ID</th>
		  	<th>E-email</th>
		  	<th>Oprettet</th>
		  	<th></th>
	  	</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['created_at']; ?></td>
			<td class="text-right">
				<a href="<?php echo url("/user/edit/{$user['id']}"); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></a>	
				<a href="<?php echo url("/user/delete/{$user['id']}"); ?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	</div>
</div>
