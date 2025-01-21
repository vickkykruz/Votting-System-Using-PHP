<!DOCTYPE html>
<html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
        <meta name="author" content="AdminKit">
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

        <link rel="preconnect" href="https://fonts.gstatic.com">

        <!-- Favicon -->
    <link href="https://sacoeteccscdept.com.ng/assets/img/logo/school_logo.png" rel="icon">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5Q>

        <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html">

        <title>Sign Up || SACOETEC COMPUTER SCIENCE DEPARTMENT</title>

        <!-- BootStrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5p>

        <!-- TimeTable CSS -->
        <link href="https://sacoeteccscdept.com.ng/assets/css/timetable.css" rel="stylesheet">

        <link href="https://sacoeteccscdept.com.ng/assets/css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
</head>

<body>
  <main class="d-flex w-100">
                <div class="container d-flex flex-column">
                        <div class="row vh-100">
                                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                                        <div class="d-table-cell align-middle">

                                                <div class="text-center mt-4">

                                                        <img src="https://sacoeteccscdept.com.ng/assets/img/logo/school_logo.png" width="100" height="100" alt="logo">
                                                        <p class="lead">
                                                                <?php
                                                                   if ($stundentSubTitle) {
										if ($stundentSubTitle == "Register") {
											echo "Student's Register Page";
											include_once('../students/static/partials/log_messages/_auth_message.php');
										}
                                                                   }
                                                                 ?>
                                                        </p>
                                                </div>
