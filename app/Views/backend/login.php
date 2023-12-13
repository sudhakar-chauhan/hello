<?php 
$session = session();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<title><?= trim($title) != '' ? $title : 'Richmane'; ?> </title>
	<!--favicon-->
	<link rel="icon" href="<?= base_url('public/backend/assets/images/favicon-32x32.png')?>" type="image/png" />

    <!-- =========================== icons Font Awesome  =================== -->
<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/0fa72d8ab3.js" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= base_url('public/assets/frontend/vendor/css/bootstrap.min.css') ?>">
    <link href="<?= base_url('public/assets/backend/dist/css/custom.css') ?>" rel="stylesheet" type="text/css">

</head>
<?php 

$labelEmail = [
    'class'=>'form-label'
];

$inputEmail = [
    'type'=> 'email',
    'class'=>'form-control',
    'id'=> 'inputEmailAddress',
    'placeholder'=> 'Email Address',
    'name'=>'email',
    'required' => true
];

$labelPassword = [
    'class'=>'form-label'
];
$inputPassword = [
    'type'=> 'password',
    'class'=>'form-control border-end-0',
    'id'=> 'inputEmailPassword',
    'placeholder'=> 'Enter Password',
    'name'=> 'password',
    'required' => true
];

?>
<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="section-authentication-login d-flex align-items-center justify-content-center mt-4">
			<div class="row">
				<div class="col-12 mx-auto">
					<div class="card radius-15 overflow-hidden">
						<div class="row g-0">
							<div class="col-12">
								<div class="card-body p-5">
									<div class="text-center">
										<img src="<?= base_url('public/assets/backend/uploads/logo/logo1-2.png')?>" width="150" alt="">
										<h3 class="mt-4 font-weight-bold">Welcome Back</h3>
									</div>
									<div class="">
                                   <?php 

                                if($session->has('message') && $session->get('message') != ''){
                                    echo $session->getFlashdata('message');                                   
                                }
                                   ?>
										<div class="form-body">
                                        <?= form_open('admin/login', 'class="row g-3"')?>
                                        <div class="col-12">
                                            <?= form_label("Email Address", "inputEmailAddress", $labelEmail) ?>
                                            <?= form_input($inputEmail) ?>
                                        </div>
                                        <div class="col-12">
                                            <?= form_label("Enter Password", "inputChoosePassword", $labelPassword) ?>
                                            <div class="input-group" id="show_hide_password">
                                                <?= form_input($inputPassword) ?> <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                                <a class="password-eye" id="eyeButton"><i class="fa-regular fa-eye-slash"></i></a>
                                            </div>
                                           
                                        </div>
                                        <div class="col-md-6">
													<div class="form-check form-switch">
														<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
														<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
													</div>
												</div>
                                                <div class="col-md-6 text-end">	<a href="<?= base_url('admin/forget-password')?>" class="text-dark">Forgot Password ?</a>
												</div>

                                                <div class="col-12">
													<div class="d-grid">
														<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
													</div>
												</div>        


                                        <?= form_close() ?>
										</div>
									</div>
								</div>
							 </div>
							
						</div>
						<!--end row-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
	<!-- jQuery -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/jquery/dist/jquery.min.js') ?>"></script>
	<!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url('public/assets/frontend/vendor/js/bootstrap.bundle.min.js') ?>"></script>
<!--Password show & hide js -->
<script>
	$(document).ready(function () {
		$("#show_hide_password a").on('click', function (event) {
			event.preventDefault();
			if ($('#show_hide_password input').attr("type") == "text") {
				$('#show_hide_password input').attr('type', 'password');
				$('#show_hide_password i').addClass("bx-hide");
				$('#show_hide_password i').removeClass("bx-show");
                $(this).html('<i class="far fa-eye-slash"></i>');
			} else if ($('#show_hide_password input').attr("type") == "password") {
				$('#show_hide_password input').attr('type', 'text');
				$('#show_hide_password i').removeClass("bx-hide");
				$('#show_hide_password i').addClass("bx-show");
                $(this).html('<i class="far fa-eye"></i>');
			}
		});
	});
</script>

</html>