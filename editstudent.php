<?php
	include 'inc/header.php';
	include 'lib/Session.php';
?>
<?php
if (isset($_GET['editid'])) {
	$id = $_GET['editid'];
}
$table = "tbl_student";
$wherecond = array(
	'where' => array('id' => $id),
	'return_type' => 'single'
);
$getdata = $db->select($table, $wherecond );
if (!empty($getdata)) {
	
?>	
<div class="mt-3 mb-3">
	<div class="titl">
		<h5>Update Student</h5> 
		<div class="btn btn-info float-right">
			<a href="index.php">Back</a>
		</div>
		<div class="clearer"></div>
	</div>
	<div class="panel">
		<div class="add-data">
			<form action="lib/process_student.php" method="post">
				<div class="form-group">
				    <label for="name">Student Name</label>
				    <input type="text" class="form-control" id="name" required="1" value="<?php echo $getdata['name'];?>" name="name">
				</div>
				<div class="form-group">
				    <label for="email">Student Email</label>
				    <input type="text" class="form-control" id="email" required="1" value="<?php echo $getdata['email'];?>" name="email">
				</div>
				<div class="form-group">
				    <label for="phone">Student Phone</label>
				    <input type="text" class="form-control" id="phone" required="1" value="<?php echo $getdata['phone'];?>" name="phone">
				</div>

				<div class="form-group">
					<input type="hidden" name="id" value="<?php echo $getdata['id'];?>" />
					<input type="hidden" name="action" value="edit" />
				    <input class="btn btn-primary" type="submit" name="submit" value="Update" />
				</div>
				
			</form>
		</div>	
	</div>
</div>
<?php } ?>
<?php
	include 'inc/footer.php';
?>