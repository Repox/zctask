<div class="row">
	<div class="col-md-12">
		<h1>Dashboard</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
<h3>Brugere</h3>
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

<div class="row">
	<div class="col-md-12">
<h3>Brugergrupper</h3>
<table class="table table-striped">
	<thead>
		<tr>
		  	<th>ID</th>
		  	<th>Navn</th>
		  	<th></th>
	  	</tr>
	</thead>
	<tbody>
		<?php foreach($groups as $group): ?>
		<tr>
			<td><?php echo $group['id']; ?></td>
			<td><?php echo $group['name']; ?></td>
			<td class="text-right">
				<a href="<?php echo url("/group/members/{$group['id']}"); ?>" class="btn btn-xs btn-info"><i class="fa fa-users"></i></a>
				<a href="<?php echo url("/group/edit/{$group['id']}"); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></a>	
				<a href="<?php echo url("/group/delete/{$group['id']}"); ?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
				
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
	</div>
</div>