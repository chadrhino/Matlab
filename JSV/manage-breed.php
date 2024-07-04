<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/sidebar.php'; ?>
<?php include 'session.php'; ?>
<?php
if (isset($_POST['submit'])) {
	$name = $_POST['breed'];

	$query = $db->query("INSERT INTO breed(name)VALUES('$name')");

	if ($query) { ?>
		<script>
			alert('Breed Added. Click OK to close dialogue.')
		</script>
<?php
		header('refresh: 1.5');
	}
}
if (isset($_POST['update'])) {
	$name = $_POST['breed'];
	$id = $_POST['id'];

	$query = $db->query("UPDATE breed SET name = '$name' WHERE id = '$id'");

	if ($query) { ?>
		<script>
			alert('Breed updated successfully. Click OK to close dialogue.')
		</script>
<?php
		header('refresh: 1.5;url=manage-breed.php');
	}
}
if (isset($_GET['delete'])) {
	$id = $_GET['id'];

	$query = $db->query("DELETE FROM breed WHERE id = '$id'");

	if ($query) {
		?>
			<script>
				alert('Breed deleted successfully. Click OK to close dialogue.')
			</script>
		<?php
		header('refresh: 1.5;url=manage-breed.php');
	}
}
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

	<!-- Header -->
	<header class="w3-container" style="padding-top:22px">
		<h5><b><i class="fa fa-dashboard"></i> Pig Management</b></h5>
	</header>

	<?php #include 'inc/data.php'; 
	?>


	<div class="w3-container" style="padding-top:22px">
		<div class="w3-row">
			<h2>Pig Breeds</h2>
			<div class="col-md-12">
				<a title="Check to delete from list" data-toggle="modal" data-target="#_removed" id="delete" class="btn btn-danger"><i class="fa fa-trash"></i>
				</a>
				<form method="post" action="delete_breed.php">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th></th>
								<th>ID</th>
								<th>Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$get = $db->query("SELECT * FROM breed");
							$res = $get->fetchAll(PDO::FETCH_OBJ);
							foreach ($res as $n) { ?>
								<tr>
									<td>
										<input type="checkbox" name="selector[]" value="<?php echo $n->id ?>">
									</td>
									<td> <?php echo $n->id; ?> </td>
									<td> <?php echo $n->name; ?> </td>
									<td class="dropdown">
										<button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i> Option
											<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>
												<a href="?edit&id=<?php echo $n->id ?>"><i class="fa fa-edit"></i> Edit</a>
											</li>
											<li>
												<a onclick="return confirm('Continue delete breed ?')" href="?delete&id=<?php echo $n->id ?>"><i class="fa fa-trash"></i> Delete</a>
											</li>
										</ul>
									</td>
								</tr>
							<?php }

							?>
						</tbody>
					</table>

					<?php include('inc/modal-delete.php'); ?>
				</form>
			</div>

			<?php
			$title = "Add New Breed";
			$name = "";
			$button_name = "submit";
			$id = "";
			if (isset($_GET['edit'])) {
				$id = $_GET['id'];
				$get = $db->query("SELECT * FROM breed WHERE id = '$id'");
				$res = $get->fetch(PDO::FETCH_OBJ);
				$title = "Edit Feed";
				$name = $res->name;
				$button_name = "update";
			}

			?>

			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><?= $title ?></div>
					<div class="panel-body">
						<form method="post">
						<?php
							if ($id !== null) {
								?>
									<input type="hidden" name="id" value="<?= $id ?>">
								<?php
							}
							?>
							<div class="form-group">
								<label class="control-label">Breed Name</label>
								<input type="text" name="breed" class="form-control" placeholder="Enter breed name" value="<?= $name ?>">
							</div>

							<button class="btn btn-sm btn-default" type="submit" name="<?= $button_name ?>">Submit</button>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php include 'theme/foot.php'; ?>