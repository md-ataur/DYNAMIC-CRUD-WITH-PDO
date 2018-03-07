<?php
	include 'inc/header.php';
?>
	
<div class="mt-3 mb-3">
	<div class="titl">
		<h5>Add Student</h5> 
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
				    <input type="text" required="1" class="form-control" name="name">
				</div>
				<div class="form-group">
				    <label for="email">Student Email</label>
				    <input type="text" required="1" class="form-control" name="email">
				</div>
				<div class="form-group">
				    <label for="phone">Student Phone</label>
				    <input type="text" required="1" class="form-control" name="phone">
				</div>

				<div class="form-group">
					<input type="hidden" name="action" value="add" />
				    <input type="submit" class="btn btn-primary" name="submit"  value="Add Student" />
				</div>	
			</form>
		</div>	
	</div>
</div>
<?php
	include 'inc/footer.php';
?>