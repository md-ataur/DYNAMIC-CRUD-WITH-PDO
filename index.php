<?php
	include 'inc/header.php';
	include 'lib/Session.php';
	Session::init();
?>


<?php
	$msg = Session::get('msg');
	if (!empty($msg)) {
		echo "<h5 class='alert alert-success'>".$msg."</h5>";
		Session::unset();
	} 
	
?>
	
<div class="mt-3 mb-3">
	<div class="titl">
		<h5>Student List</h5> 
		<div class="btn btn-info float-right">
			<a href="addstudent.php">Add Student</a>
		</div>
		<div class="clearer"></div>
	</div>
	<div class="panel">
		<div class="list-data">
			<table class="table table-hover">
				<tr>
					<th>No</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Action</th>
				</tr>
				<?php
					$table = "tbl_student";
					$order_by = array("order_by" => "id DESC");
				/*
				$selectcond = array('select' => 'name');
				$wherecond = array(
					'where' => array('id' => '2', 'email' => 'araf@gmail.com'),
					'return_type' => 'single'
				);
				$limit = array('start' => '2', 'limit' => '4');
				$limit = array('limit' => '3');
				*/
					$studentdata = $db->select($table, $order_by);
				?>
				<?php
					if (!empty($studentdata)) {
						$i = 0;
						foreach ($studentdata as $data) { 
							$i++;
						?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $data['name'];?></td>
					<td><?php echo $data['email'];?></td>
					<td><?php echo $data['phone'];?></td>
					<td>
						<a class="btn btn-info" href="editstudent.php?editid=<?php echo $data['id'];?>">Edit</a>
						<a class="btn btn-danger" href="lib/process_student.php?action=delete&id=<?php echo $data['id'];?>" onclick="return confirm('Are you sure to delete')">Delete</a>
					</td>
				</tr>
				<?php } } else { ?>
					<tr><td colspan="5">No Student Data Found...</td> </tr>
				<?php }?>
			</table>
		</div>	
	</div>
</div>
<?php
	include 'inc/footer.php';
?>