<?php 
// Secure session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);

ob_start();
session_start();

//! DATABASE CONNECTION
require './database/db.php';

//* Define variables and initialize with empty values
$email = $password = $notkey = $notEmail = "";
$email_err = $password_err = $verify_err = $setting_err = "";
$request = $request0 = $request1 = $request2 = $request3 = $request4 = $request5 = '';

//* Check if the session request is active
if (isset($_SESSION['request'])) {
    $request = $_SESSION['request'];

    //* Check which category is placed
    if($request[0] == 'true' && $request[1] == 'candidate_reg') {
        $request0 = $request[0];
                $request1 = $request[1];
    } else if ($request[0] == 'true' && $request[1] == 'allocation_project') {
        $request0 = $request[0];
    }
    $request1 = $request[1];
    $request2 = $request[2];
    $request3 = $request[3];
    $request4 = $request[4];
    $request5 = $request[5];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //* Check if the email is empty
    if (empty(trim($_POST["user_data"]))) {
        $email_err = 'Please enter an email address.';
    } else {
        $email = trim($_POST["user_data"]);
    }

    //* Check if the password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter your password';
    } else {
        $password = trim($_POST['password']);
    }

    //* Check if the notication key is set
    if (isset($_POST['category']) == "candidate_reg") {
        $category = $_POST['category'];
    } else if (isset($_POST['category']) && isset($_POST['allocation_id']) && isset($_POST['project_id']) && isset($_POST['project_topic']) && isset($_POST['student_name'])) {
        $category = $_POST['category'];
        $allocation_id = $_POST['allocation_id'];
        $project_id = $_POST['project_id'];
        $project_topic = $_POST['project_topic'];
        $student_name = $_POST['student_name'];
        //* Check if notication  key is empty    
        if (empty($category) || empty($allocation_id) || empty($project_id) || empty($project_topic) || empty($student_name)) {
            $setting_err = 'Require Failed, Try again later';
        }
    }

    //* Validating Requests
    if (empty($email_err) && empty($password_err)) {
        //* Prepare a select statement
        $sql = "SELECT email, password FROM students WHERE email COLLATE utf8_general_ci = ? OR memberid COLLATE utf8_general_ci = ?";
        if ($stmt = mysqli_prepare($connection, $sql)) {

            //* Bind the statement value
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_email);

            //* Set the key
            $param_email = $email;

            //* Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                //* Store the result
                mysqli_stmt_store_result($stmt);

                //* Check if the email exists
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    //* Bind result variables
                    mysqli_stmt_bind_result($stmt, $email, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_email);
                            if (!mysqli_stmt_execute($stmt)) {
                                //* Display an error message if the query wasn't successful
                                $setting_err = 'Error: Failed To Process... Try again later';
                            }

                            //* Get the result and verify the user
                            $result = mysqli_stmt_get_result($stmt);
                            if (!$row = mysqli_fetch_assoc($result)) {
                                $verify_err = 'Unable To Verify This Account. Contact Your Administrator';
                            }

                            $userMemberId = $row["memberid"];
                            $userEmail = $row["email"];
                            $_SESSION['studentid'] = $userMemberId;
                            $sql = "SELECT * FROM studentsinfo INNER JOIN students ON studentsinfo.student_id = students.id WHERE memberid = ?";
                            if ($stmt = mysqli_prepare($connection, $sql)) {
                                mysqli_stmt_bind_param($stmt, "s", $userMemberId);
                                if (!mysqli_stmt_execute($stmt)) {
                                    $setting_err = 'Error: Failed to process... Try again later';
                                }
                                mysqli_stmt_store_result($stmt);
                                if (mysqli_stmt_num_rows($stmt) != 1) {
                                    $setting_err = 'Failed To Login. Contact Your Administrator';
                                }
                            }

                            //! Process The Re-direction
                            if ($category != '' || $request0 == 'true') {
                                $_SESSION['login_success'] = "You have successfully logged in.";
                                $_SESSION['logged_in'] = true;
                                if ($category == "candidate_reg" || $request1 == "candidate_reg") {
                                    if ($request[0] != 'true') { unset($_SESSION['request']); }
                                    header("Location: ./votting_system/candidate/candidate_reg.php");
				} else if ($category == "e-votting" || $request1 == "e-votting") {
				    if ($request[0] != 'true') { unset($_SESSION['request']); }
                                    header("Location: ./votting_system/vote_candidate.php");
                                } else if ($category == "" || $request1 == "") {
                                    $notice = mysqli_query($connection, "SELECT * FROM supervisor_remark WHERE (category = '$category' OR category = '$request1') AND ((project_topic_id = '$project_id' OR project_topic_id = '$request3') OR (project_chapter_id = '$project_id' OR project_chapter_id = '$request3'))  AND (allocation_id = '$allocation_id' OR allocation_id = '$request2')");
                                    if (mysqli_num_rows($notice) == 1) {
                                        if ($request[0] != 'true') {
                                            unset($_SESSION['request']);
                                            header("Location: https://sacoeteccscdept.com.ng/students/static/pages/remarks/remarks_details/index.php?category=".$category."&allocation_id=". $allocation_id ."&project_id=". $project_id ."&project_topic=". strtoupper($project_topic) ."&student_name=".  strtoupper($student_name) ."");
                                        }else {
                                            header("Location: https://sacoeteccscdept.com.ng/students/static/pages/remarks/remarks_details/index.php?category=".$category."&allocation_id=". $request2 ."&project_id=". $request3 ."&project_topic=". strtoupper($request4) ."&student_name=".  strtoupper($request5) ."");
                                        }
                                    }
                                }

                            } else {
                                  $_SESSION['login_success'] = "You have successfully logged in.";
                                  $_SESSION['logged_in'] = true;
                                  header("Location: ./static/index.php?success");
                            }

                        }
                    }
                }
            }
        }
    }
}

$stundentSubTitle = $lecturSubTitle = $timeTableCommiteSubTitle = "";
$stundentSubTitle = "Login";
require_once './partials/headers/_auth_header.php' ?>
<div class="card">
    <div class="card-body">
        <div class="m-sm-4">
            <h6 class="text-center" style="color:red;">
                            </h6>
            <h6 class="text-center" style="color:red;">
                            </h6>
            <h6 class="text-center" style="color:red;">
                            </h6>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                          <?php
                            if (isset($_GET['notice']) && isset($_GET['category'])) {
                                $category = $_GET['category'];
				$nofice = $_GET['notice'];
                                if ($category == "candidate_reg" || $category == "e-votting") { 
                                    $_SESSION['request'] = array($nofice, $category);?>
                <input type="hidden" name="category" value="<?php echo $category ?>" />
                                <?php } else if ($category == "allocation_project") {
                                    if (isset($_GET['allocation_id']) && isset($_GET['project_id']) && isset($_GET['project_topic']) && isset($_GET['student_name'])) {
                                                    $allocation_id = $_GET['allocation_id'];
                                                    $project_id = $_GET['project_id'];
                                                    $project_topic = $_GET['project_topic'];
                                                    $student_name = $_GET['allocation_id'];

                                        if (empty($nofice) || empty($category) || empty($allocation_id) || empty($project_id) || empty($project_topic) || empty($student_name)) { ?>
                                <h6 class="text-center" style="color:red;">Request Failed</h6>
                                        <?php } else { 
                                            if ($nofice == 'true') { 
                                                $_SESSION['request'] = array($nofice, $category, $allocation_id, $project_id, $project_topic, $student_name);?>
                <input type="hidden" name="category" value="<?php echo $category ?>" />
                <input type="hidden" name="allocation_id" value="<?php echo $allocation_id ?>" />
                <input type="hidden" name="project_id" value="<?php echo $project_id ?>" />
                <input type="hidden" name="project_topic" value="<?php echo $project_topic ?>" />
                <input type="hidden" name="student_name" value="<?php echo $student_name ?>" />

                                                <?php
                                            } else { ?>
                <h6 class="text-center" style="color:red;">Request Failed</h6>
                                            <?php }
                                        }
                                    }
                                }
                            }

                            ?>
                                <div class="mb-3">
                    <label class="form-label">Email Or Student ID <span class="text-danger">*</span></label>
                    <input class="form-control form-control-lg" type="text" name="user_data" placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password">
                    <small>
                    <a href="https://sacoeteccscdept.com.ng/members/forgot-password.php">Forgot password?</a>
                    </small>
                </div>
                <div>
                    <label class="form-check">
                    <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked="">
                    <span class="form-check-label">
                        Remember me next time
                    </span>
                    </label>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-lg btn-primary">Login</button>
                </div>
                <div class="mt-3">
                                       <?php 
                                        if (isset($_GET['category']) == "candidate_reg") {
                                            ?>
                    <p class=""> Don't have an account? <b><a href="https://sacoeteccscdept.com.ng/students/register.php?category=candidate_reg">Register</a></b>. Or <b><a href="https://sacoeteccscdept.com.ng/">Go Home</a></b></p>
                                        <?php } else { ?>
                    <p class=""> Don't have an account? <b><a href="https://sacoeteccscdept.com.ng/students/register.php">Register</a></b>. Or <b><a href="https://sacoeteccscdept.com.ng/">Go Home</a></b></p>
                                        <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once './partials/scripts/_auth_script.php' ?>
