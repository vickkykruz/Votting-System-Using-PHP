<?php

session_start();
$timeTableCommiteSubTitle = $lecturSubTitle = "";
$stundentSubTitle = "Register";
include_once('./partials/headers/_auth_header.php')

if (isset($_GET['category']) == "candidate_reg") {
  $action = "./static/functions/register_student.php?category=candidate_reg";
} else if (isset($_GET['category']) == "e-votting") {
  $action = "./static/functions/register_student.php?category=e-votting";
}else {
  $action = "./static/functions/register_student.php";
}
?>


<div class="card">
	<div class="card-body">
		<div class="m-sm-4">
			<form action="<?= $action ?>" method="POST">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">First Name <span class="text-danger">*</span></label>
							<input class="form-control form-control-lg" type="text" name="firstname" placeholder="Enter first name" />
						</div>
					</div>
					<div class="col-lg-6">
						<div class="mb-3">
							<label class="form-label">Last Name <span class="text-danger">*</span></label>
							<input class="form-control form-control-lg" type="text" name="lastname" placeholder="Enter last name" />
						</div>
					</div>
				</div>
				<div class="mb-3">
					<label class="form-label">Middle Name (optional)</label>
					<input class="form-control form-control-lg" type="text" name="surname" placeholder="Enter middle name" />
				</div>
				<div class="mb-3">
					<label class="form-label">Email <span class="text-danger">*</span></label>
					<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter email address" />
				</div>
				<div class="mb-3">
					<label class="form-label">Password <span class="text-danger">*</span></label>
					<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
				</div>
				<div class="mb-3">
					<label class="form-label">Re-Type Password <span class="text-danger">*</span></label>
					<input class="form-control form-control-lg" type="password" name="re_password" placeholder="Enter re-type password" />
				</div>
				<div class="text-center mt-3">
					<button type="submit" name="submit" class="btn btn-lg btn-primary">Register</button>
				</div>
				<div class="mt-3">
					<p class=""> Already have an account? <b><a href="https://sacoeteccscdept.com.ng/students/login.php">Login</a></b>. Or <b><a href="https://sacoeteccscdept.com.ng/">Go Home</a></b></p>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include_once('./partials/scripts/_auth_script.php') ?>
