
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
	<link rel="stylesheet" href="<?= base_url('public/assets/vendor/css/bootstrap.min.css') ?>">
    <link href="<?= base_url('public/backend/dist/css/custom.css') ?>" rel="stylesheet" type="text/css">

</head>
<?php 

$label = [
    'class'=>'form-label'
];

$inputOtp = [
    'type'=> 'text',
    'class'=>'form-control',
    'id'=> 'inputotp',
    'placeholder'=> 'Enter OTP',
    'name'=>'otp',
    'maxlength'=> 4,
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
										<h3 class="mt-4 font-weight-bold">Account Verfication</h3>
									</div>
									<div class="" id="otpVerfication">
                                       <p  class="info">OTP is sent to your registered email</p>
                                   <?php 
                                if($session->has('message') && $session->get('message') != ''){
                                    echo $session->getFlashdata('message');                                   
                                }
                                   ?>
										<div class="form-body" >

                              

                                        <?= form_open('admin/otp-verification', 'class="row g-3"')?>
                                        <div class="col-12">
                                            <?= form_input($inputOtp) ?>
                                        </div>
                                                <div class="col-12">
													<div class="d-grid">
														<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Verify</button>
													</div>
												</div>    
                                                
                                            
                                        <?= form_close() ?>

                                        <div class="card-2 mt-3">
                                        <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get
                                                the code</span> <button  id="resendOtp" class="btn ms-3 me-3" disabled="true" >Resend </button> 
                                                <span class="resendOtpTimer">2<span> </div>     
                                    </div>
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
	<script src="<?= base_url('public/backend/vendors/bower_components/jquery/dist/jquery.min.js') ?>"></script>

	<!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url('public/assets/vendor/js/bootstrap.bundle.min.js') ?>"></script>

<!--Password show & hide js -->
<script>


var baseUrl = 'http://localhost/richmane/';

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



// ========================== Otp Resend ========================== //
$(document).on('click', '#resendOtp', function(){
  



  $(this).append("<div class='spinner spinner-border spinner-border-sm ms-2'  role='status'><span class='visually-hidden'>Loading...</span></div>")
  otpTimer();
  resendOtp()
  .then(function(data){
     $('.spinner').remove();

      $('#otpVerfication .info').html(`<p>
       ${data}
      </p>`)
  }).catch(function(data){
    $('.spinner').remove();
    $('#otpVerfication .info').html(`<p>
    ${data}
   </p>`)    
  });
})

  function otpTimer(){
    const timerDisplay = $('.resendOtpTimer');
    let seconds = 120;
    $('#resendOtp').attr('disabled', true);
    function updateTimer() {
      const minutes = Math.floor(seconds / 60);
      const remainingSeconds = seconds % 60;
      timerDisplay.text(minutes + ':' + (remainingSeconds < 10 ? '0' : '') + remainingSeconds);
  
      seconds--;
  
      if (seconds < 0) {
        clearInterval(timerInterval);
        timerDisplay.text('0:00');
        $('#resendOtp').attr('disabled', false);
      }
    }
  
    const timerInterval = setInterval(updateTimer, 1000);
  }

  function resendOtp() {
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: baseUrl +"session/admin/resend-otp",
        type: "POST",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
        data: {  
        },
        success: function (response) {
          if (response.status === "success") {
            resolve(response.message); // Resolve the promise with the response data
          } else {
            reject(response.message); // Reject the promise with an error message
          }
        },
        error: function (xhr, status, error) {
          reject(error); // Reject the promise with the error message
        },
      });
    });
  }

  otpTimer()
	});
</script>

</html>