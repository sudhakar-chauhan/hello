
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
										<img src="<?= base_url('public/assets/uploads/logo/richmane-logo1.webp')?>" width="150" alt="">
										<h3 class="mt-4 mb-3 font-weight-bold">Foget Passowrd</h3>
									</div>
									<div class="">
                                   <?php 

                                if($session->has('message') && $session->get('message') != ''){
                                    echo $session->getFlashdata('message');                                   
                                }
                                   ?>
										<div class="form-body">

                                        <?= form_open('admin/forget-password', 'class="row g-3"')?>
                                        <div class="col-12">
                                            <?= form_input($inputEmail) ?>
                                        </div>
                                                <div class="col-12">
													<div class="d-grid">
														<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Submit</button>
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



</html>