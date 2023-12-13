<?php 
$session = session();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Insurance Sorted</title>
	<meta name="description" content="Insurance Sorted is a Dashboard & Admin Site Responsive Template by hencework." />
	<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Insurance sorted Admin, Insurance sortedadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
	<meta name="author" content="LnbDigitalSolution" />

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url('public/assets/backend/img/Insurance sorted-logo1.webp')?>">
	<link rel="icon" href="<?= base_url('public/assets/backend/img/Insurance sorted-logo1.webp') ?>" type="image/x-icon">

	<!-- Data table CSS -->
	<link href="<?= base_url('public/assets/backend/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') ?>" rel="stylesheet" type="text/css" />

	<!-- Toast CSS -->
	<link href="<?= base_url('public/assets/backend/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css') ?>" rel="stylesheet" type="text/css">


	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?= base_url('public/assets/frontend/vendor/css/bootstrap.min.css') ?>">


	<!-- Custom CSS -->
	<link href="<?= base_url('public/assets/backend/dist/css/style.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('public/assets/backend/dist/css/custom.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?= base_url('public/assets/backend/dist/css/dev.css') ?>" rel="stylesheet" type="text/css">

	<!-- jQuery -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/jquery/dist/jquery.min.js') ?>"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>

	<!-- Data table JavaScript -->
	<!-- <script src="<?= base_url('public/assets/backend/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') ?>"></script> -->
	<!-- Data table JavaScript -->
	<!-- <script src="<?= base_url('public/assets/backend/dist/js/dataTables-data.js') ?>"></script> -->


	<script src="<?= base_url('public/assets/backend/dist/js/tinymce.min.js') ?>"></script>

	<!-- Slimscroll JavaScript -->
	<script src="<?= base_url('public/assets/backend/dist/js/jquery.slimscroll.js') ?>"></script>

	<!-- Progressbar Animation JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') ?>"></script>
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/jquery.counterup/jquery.counterup.min.js') ?>"></script>

	<!-- Fancy Dropdown JS -->
	<script src="<?= base_url('public/assets/backend/dist/js/dropdown-bootstrap-extended.js') ?>"></script>

	<!-- Sparkline JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') ?>"></script>

	<!-- Owl JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js') ?>"></script>

	<!-- Switchery JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/switchery/dist/switchery.min.js') ?>"></script>



	<!-- EChartJS JavaScript -->
	<script src="<?= base_url('public/assets/backend/js/echarts.min.js') ?>"></script>
	<script src="<?= base_url('public/assets/backend/dist/js/echart-data.js') ?>"></script>

	
	<!-- Toast JavaScript -->
	<script src="<?= base_url('public/assets/backend/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js') ?>"></script>

	<!-- Init JavaScript -->
	<script src="<?= base_url('public/assets/backend/dist/js/init.js') ?>"></script>
	
	<!-- <script src="<?= base_url('public/assets/backend/dist/js/dashboard-data.js') ?>"></script> -->

	<!-- Mulitselect -->

	<script src="<?= base_url('public/assets/backend/dist/js/bootstrap-multiselect.js') ?>"></script>
	<link href="<?= base_url('public/assets/backend/dist/css/bootstrap-multiselect.css') ?>"  rel="stylesheet" type="text/css"></link>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

	<script src="<?= base_url('public/assets/frontend/vendor/js/bootstrap.bundle.min.js') ?>"></script>
	<script defer src="<?= base_url('public/assets/backend/js/custom.js') ?>" type="module"></script>
	

</head>
<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>

	<div class="overlay fade"></div>
	<!-- /Preloader -->
	<div class="wrapper  theme-5-active pimary-color-green">
		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="<?= base_url() ?>">
							<img class="brand-img" src="<?= base_url('public/assets/backend/uploads/logo/logo1-2.png') ?>" width="150" alt="brand" />
							<span class="brand-text">Insurance Sorted</span>
						</a>
					</div>
				</div>
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>

			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
				
					<li class="dropdown alert-drp">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i>
						<span class="top-nav-icon-badge">
							20</span></a>
						<ul class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
							<li>
								<div class="notification-box-head-wrap">
									<span class="notification-box-head pull-left inline-block">notifications</span>
									<div class="clearfix"></div>
									<hr class="light-grey-hr ma-0" />
								</div>
							</li>
							<li>
								<div class="streamline message-nicescroll-bar">
									
											<div class="sl-item">
										<a href="<?=base_url('admin/orders')?>">
											<div class="icon bg-green">
												<i class="zmdi zmdi-flag"></i>
											</div>
											<div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">
													New Order By Sahil Yadav</span>
												<span class="inline-block font-11  pull-right notifications-time">20-12-2019</span>
												<div class="clearfix"></div>
												<p class="truncate">3dfsdfsdfsdf sdfsdfs</p>
											</div>
										</a>
									</div>
									<hr class="light-grey-hr ma-0" />
								</div>
							</li>
							<li>
								<div class="notification-box-bottom-wrap">
									<hr class="light-grey-hr ma-0" />
									<div class="clearfix"></div>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="<?=base_url('public/assets/backend/uploads/logo/logo1-2.png') ?>" alt="user_auth" class="user-auth-img img-circle" /></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a href="profile.html"><i class="zmdi zmdi-account"></i><span><?= $session->get('ad_user_name')  ?></span></a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?=base_url('admin/logout')?>"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<!-- /Top Menu Items -->

		<!-- Left Sidebar Menu -->
		<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar d-block">
				<li class="navigation-header">
					<span>Main</span>
					<i class="zmdi zmdi-more"></i>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/dashboard')?>">
						<div class="pull-left"><i class="fa fa-dashboard mr-20"></i><span class="right-nav-text">Dashboard</span></div>
						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/inbox')?>">
						<div class="pull-left"><i class="zmdi zmdi-inbox mr-20"></i><span class="right-nav-text">Inbox</span></div>
						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('admin/edit-product/customize') ?>">
						<div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Customize Product</span></div>

						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#products_dr">
						<div class="pull-left"><i class="zmdi zmdi-shopping-basket mr-20"></i><span class="right-nav-text">Products</span></div>
						<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
						<div class="clearfix"></div>
					</a>
					<ul id="products_dr" class="collapse collapse-level-1">
						<li>
							<a href="<?= base_url('admin/products') ?>">All Products</a>
						</li>
						<li>
							<a href="<?= base_url('admin/add-product') ?>">Add New</a>
						</li>
						<li>
							<a href="<?= base_url('admin/categories') ?>">Categories</a>
						</li>
						<li>
							<a href="<?= base_url('admin/attributes-categories') ?>">Attributes Categories</a>
						</li>
						<li>
							<a href="<?= base_url('admin/attributes') ?>">Attributes</a>
						</li>
					
						<li>
							<a href="<?= base_url('admin/product-reviews') ?>">Reviews</a>
						</li>
						<li>
							<a href="<?= base_url('admin/faq') ?>">Faq</a>
						</li>

					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#blog_dr">
						<div class="pull-left"><i class="zmdi zmdi-shopping-basket mr-20"></i><span class="right-nav-text">Blog</span></div>
						<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
						<div class="clearfix"></div>
					</a>
					<ul id="blog_dr" class="collapse collapse-level-1">
						<li>
							<a href="<?= base_url('admin/blogs') ?>">All Blog</a>
						</li>
						<li>
							<a href="<?= base_url('admin/add-blog') ?>">Add New</a>
						</li>
						<li>
							<a href="<?= base_url('admin/blog-categories') ?>">Blog Categories</a>
						</li>
				
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#global">
						<div class="pull-left"><i class="fa fa-globe me-4"></i><span class="right-nav-text">Global </span></div>
						<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
						<div class="clearfix"></div>
					</a>
					<ul id="global" class="collapse collapse-level-1">
						<li>
							<a href="javascript:void(0);" data-toggle="collapse" data-target="#header">
								<div class="pull-left"><i class="zmdi zmdi-apps mr-20"></i><span class="right-nav-text">Header </span></div>
								<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
								<div class="clearfix"></div>
							</a>
							<ul id="header" class="collapse collapse-level-1">

								
										<li>
											<a href="#"> healder Link</a>
										</li>
								
							</ul>
						</li>

						<!-- Outer -->
						<li>
							<a href="<?= base_url('admin/edit-footer') ?>">Footer</a>
						</li>
						<!-- Outer -->
						<li>
							<a href="<?= base_url('admin/edit-search-quick') ?>">Search Quick Links</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#cms">
						<div class="pull-left"><i class="fa fa-edit me-4"></i><span class="right-nav-text">CMS </span></div>
						<div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
						<div class="clearfix"></div>
					</a>
					<ul id="cms" class="collapse collapse-level-1">
						<li>
							<a href="<?= base_url('admin/edit/home') ?>">Home Page</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/shop') ?>">Shop Page</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/womens') ?>">Womens</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/brand-story') ?>">Brand Story</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/team') ?>">Team</a>
						</li>

						<li>
							<a href="<?= base_url('admin/edit/hair-care') ?>">Hair Care</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/our-mission') ?>">Our Mission</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/conclusion') ?>">Conclusion</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/production') ?>">Our Productions</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/pricing') ?>">Pricing</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/cleaning-tips') ?>">Cleaning Tips</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/conditioning-and-care') ?>">Conditioning and Care</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/custom-options') ?>">Custom Options</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/different') ?>">Different Types of Hair Systems</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/samples') ?>">How to Send in Samples</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/influencer') ?>">Influencer Program</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/template') ?>">Send in Templates Hair Samples</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/wholesale') ?>">Wholesale</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/removing-guide') ?>">Removing Guide</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/useful-suggestions') ?>">Useful Suggestions</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/hair-sample') ?>">Take Hair Samples</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/salon-partner') ?>">Salon Partner Hair Replacement</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/lifestyle') ?>">Lifestyle</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/make-template') ?>">Make Template</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/shampooing-tips') ?>">Shampooing Tips</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/styling-a-hair-system') ?>">Styling a Hair System</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/tape-attaching-guide') ?>">Tape Attaching Guide</a>
						</li>
						<li>
							<a href="<?= base_url('admin/edit/contactus') ?>">Contact us</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="<?= base_url('admin/colors') ?>">
						<div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Colors</span></div>

						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('admin/hair-styles') ?>">
						<div class="pull-left"><i class="zmdi zmdi-flag mr-20"></i><span class="right-nav-text">Hair Style</span></div>

						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('admin/coupons') ?>">
						<div class="pull-left"><i class="fa fa-percent me-4"></i><span class="right-nav-text">Coupons</span></div>

						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('admin/orders') ?>">
						<div class="pull-left"><i class="fa fa-cube me-4"></i><span class="right-nav-text">Orders</span></div>
						<div class="clearfix"></div>
					</a>
				</li>
				<li>
					<a href="<?= base_url('admin/user') ?>">
						<div class="pull-left"><i class="zmdi zmdi-accounts mr-20"></i><span class="right-nav-text">Users</span></div>
						<div class="clearfix"></div>
					</a>
				</li>
				
			</ul>
		</div>
		<!-- /Left Sidebar Menu -->
		<!-- Right Sidebar Backdrop -->
		<div class="right-sidebar-backdrop"></div>
		<!-- /Right Sidebar Backdrop -->