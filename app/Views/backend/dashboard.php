<!-- Main Content -->


<div class="page-wrapper">
	<div class="container-fluid pt-25">
		<!-- Row -->
		<div class="row">
			<div class="col-12">
			<div class="panel panel-default card-view">
				<div class="panel-heading">
					<div class="pull-left">
						<h6 class="panel-title txt-dark">Total Sales</h6>
					</div>
					<div class="pull-right">
						<div class="pull-left form-group mb-0 sm-bootstrap-select mr-15">
							<div class="btn-group bootstrap-select">
                                <select id="totalSaleMonth" class="selectpicker" data-style="form-control" tabindex="-98">
									<option selected  value="" data-month="1">This Months</option>
									<option value="" data-month="3">Last 3 Months</option>
									<option value="" data-month="6">Last 6 Months</option>
									<option value="" data-month="12">Last 12 Months</option>
									<option value="" data-month="0">Till Date</option>
							   </select>
							</div>
						</div>
						<a href="#" class="pull-left inline-block full-screen">
							<i class="zmdi zmdi-fullscreen"></i>
						</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel-wrapper collapse in">
					<div class="panel-body">
						<ul class="flex-stat mb-10 ml-15">
							<li class="text-left auto-width mr-60">
								<span class="block">Total Sale</span>
								<span class="block txt-dark weight-500 font-18">$<span class="counter-anim total-sale-data"> </span></span>
								<div class="clearfix"></div>
							</li>
						</ul>
						<p class="text-right "> Total Sale of  (<?= date('Y')?>)</p>
						 <div class="d-none">
							<input id="years"  data-years=''>
							<input id="amounts" data-amounts=''>
						 </div>
						<div id="total_sale_chart" data-saletew="[]" class="" style="height: 310px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;">
							
						</div>
					</div>
				</div>
			</div>
			</div>

			<div class=" col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view pa-0">
					<div class="panel-wrapper collapse in">
						<div class="panel-body pa-0">
							<div class="sm-data-box">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
											<span class="txt-dark block counter"><span class="counter-anim"></span></span>
											<span class="weight-500 uppercase-font block font-13">New Customer (This Month)</span>
										</div>
										<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
											<i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view pa-0">
					<div class="panel-wrapper collapse in">
						<div class="panel-body pa-0">
							<div class="sm-data-box">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
											<span class="txt-dark block counter"><span class="counter-anim">70</span></span>
											<span class="weight-500 uppercase-font block">Total Customers </span>
										</div>
										<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
											
											<span class="pe-7s-users" style="font-size: 50px"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view pa-0">
					<div class="panel-wrapper collapse in">
						<div class="panel-body pa-0">
							<div class="sm-data-box">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
											<a href="<?=base_url('admin/orders')?>">
											<span class="txt-dark block counter"><span class="counter-anim"></span></span>
											<span class="weight-500 uppercase-font block font-13">Today Orders</span>
											</a>
										</div>
										<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
										<span class="pe-7s-box2" style="font-size: 50px" ></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default card-view panel-refresh">
					<div class="refresh-container">
						<div class="la-anim-1"></div>
					</div>
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">Top Selling Products</h6>
						</div>
						<div class="pull-right">
						
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body row pa-0">
							<div class="table-wrap">
								<div class="table-responsive">
									<table class="table table-hover mb-0">
										<thead>
											<tr>
												<th>Product Name</th>
												<th>Total Sale</th>
												<th>View</th>
											</tr>
										</thead>
										<tbody>

										
	                                <tr>
												<td><span class="txt-dark weight-500">dfsdfd</span></td>
												<td>
													<span class="txt-dark weight-500">dfdasfdsf</span>
												</td>
												<td>
													<span class=""><a href="#"> View </a></span>
												</td>
											</tr>
											
										
										
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
						<div class="panel panel-default card-view panel-refresh">
							<div class="refresh-container">
								<div class="la-anim-1"></div>
							</div>
							<div class="panel-heading">
								<div class="pull-left">
									<h6 class="panel-title txt-dark">Order Status</h6>
								</div>
								<div class="pull-right">
									
									
								</div>
								<div class="clearfix"></div>
								<div class="clearfix"></div>
							</div>

							<div class="data-wrapper p-3">
								<p id="totalOrder" data-value="" class="mb-2"> <span class="">  </span><a href="#"> <span>Total Orders:</span>  10</a> </p>
								<p id="pendingOrder"  data-value=""  class="mb-2"> <span class="badge status_pending"> </span><sapn>  <a href="<?=base_url('admin/orders/filter?order_status=0&honeypot=')?>">Pending:</sapn> 21</a> </p>
								<p id="processingOrder"  data-value="" class="mb-2"> <span class="badge status_hold"> </span> <a href="<?=base_url('admin/orders/filter?order_status=1&honeypot=')?>"><sapn>Processing:</sapn>  123</a> </p>
								<p id="shippedOrder"  data-value="" class="mb-2"> <span class="badge status_shipped--bg"> </span> <a href="<?=base_url('admin/orders/filter?order_status=2&honeypot=')?>"><span>Shipped:</span> 03</a> </p>
								<p id="deliverdOrder"  data-value="" class="mb-2"> <span class="badge status_delivered"> </span>  <a href="<?=base_url('admin/orders/filter?order_status=3&honeypot=')?>"><sapn>Delivered:</sapn> 04</a></p>
							</div>
							<div class="panel-wrapper collapse in">
								<div id="order_status_chart" class="" style="height: 350px; -webkit-tap-highlight-color: transparent; user-select: none; background: transparent;" _echarts_instance_="ec_1698220912860"><div style="position: relative; overflow: hidden; width: 410px; height: 350px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas width="512" height="437" data-zr-dom-id="zr_0" style="position: absolute; left: 0px; top: 0px; width: 410px; height: 350px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>
							</div>
						</div>
					</div>
			

			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view pa-0">
					<div class="panel-wrapper collapse in">
						<div class="panel-body pa-0">
							<div class="sm-data-box">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
											<span class="txt-dark block counter"><span class="counter-anim">46.41</span>%</span>
											<span class="weight-500 uppercase-font block">bounce rate</span>
										</div>
										<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
											<i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view pa-0">
					<div class="panel-wrapper collapse in">
						<div class="panel-body pa-0">
							<div class="sm-data-box">
								<div class="container-fluid">
									<div class="row">
										<div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
											<span class="txt-dark block counter"><span class="counter-anim">4,054,876</span></span>
											<span class="weight-500 uppercase-font block">pageviews</span>
										</div>
										<div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
											<i class="icon-layers data-right-rep-icon txt-light-grey"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Row -->

		<!-- Row -->
		<div class="row">
			<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default card-view panel-refresh">
					<div class="refresh-container">
						<div class="la-anim-1"></div>
					</div>
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">user statistics</h6>
						</div>
						<div class="pull-right">
							<a href="#" class="pull-left inline-block refresh mr-15">
								<i class="zmdi zmdi-replay"></i>
							</a>
							<a href="#" class="pull-left inline-block full-screen mr-15">
								<i class="zmdi zmdi-fullscreen"></i>
							</a>
							<div class="pull-left inline-block dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
								<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>General</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div id="e_chart_1" class="" style="height:313px;"></div>
							<ul class="flex-stat mt-40">
								<li>
									<span class="block">Weekly Users</span>
									<span class="block txt-dark weight-500 font-18"><span class="counter-anim">3,24,222</span></span>
								</li>
								<li>
									<span class="block">Monthly Users</span>
									<span class="block txt-dark weight-500 font-18"><span class="counter-anim">1,23,432</span></span>
								</li>
								<li>
									<span class="block">Trend</span>
									<span class="block">
										<i class="zmdi zmdi-trending-up txt-success font-24"></i>
									</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view bg-green">
					<div class="panel-wrapper collapse in">
						<div class="panel-body sm-data-box-1">
							<span class="uppercase-font weight-500 font-14 block text-center txt-light">customer satisfaction</span>
							<div class="cus-sat-stat weight-500 txt-light text-center mt-5">
								<span class="counter-anim">93.13</span><span>%</span>
							</div>
							<div class="progress-anim mt-20">
								<div class="progress">
									<div class="progress-bar progress-bar-light
											wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<ul class="flex-stat txt-light mt-5">
								<li>
									<span class="block">Previous</span>
									<span class="block weight-500 font-15">79.82</span>
								</li>
								<li>
									<span class="block">% Change</span>
									<span class="block weight-500 font-15">+14.29</span>
								</li>
								<li>
									<span class="block">Trend</span>
									<span class="block">
										<i class="zmdi zmdi-trending-up font-20"></i>
									</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel panel-default card-view">
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">browser stats</h6>
						</div>
						<div class="pull-right">
							<a href="#" class="pull-left inline-block mr-15">
								<i class="zmdi zmdi-download"></i>
							</a>
							<a href="#" class="pull-left inline-block close-panel" data-effect="fadeOut">
								<i class="zmdi zmdi-close"></i>
							</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div>
								<span class="pull-left inline-block capitalize-font txt-dark">
									google chrome
								</span>
								<span class="label label-warning pull-right">50%</span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10" />
								<span class="pull-left inline-block capitalize-font txt-dark">
									mozila firefox
								</span>
								<span class="label label-danger pull-right">10%</span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10" />
								<span class="pull-left inline-block capitalize-font txt-dark">
									Internet explorer
								</span>
								<span class="label label-success pull-right">30%</span>
								<div class="clearfix"></div>
								<hr class="light-grey-hr row mt-10 mb-10" />
								<span class="pull-left inline-block capitalize-font txt-dark">
									safari
								</span>
								<span class="label label-primary pull-right">10%</span>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="panel panel-default card-view panel-refresh">
					<div class="refresh-container">
						<div class="la-anim-1"></div>
					</div>
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">Visit by Traffic Types</h6>
						</div>
						<div class="pull-right">
							<a href="#" class="pull-left inline-block refresh mr-15">
								<i class="zmdi zmdi-replay"></i>
							</a>
							<div class="pull-left inline-block dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
								<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>General</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div id="e_chart_2" class="" style="height:215px;"></div>
							<hr class="light-grey-hr row mt-10 mb-15" />
							<div class="label-chatrs">
								<div class="">
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">44.46% organic</span><span class="block txt-grey">356 visits</span></span>
									<div id="sparkline_1" class="sp-small-chart pull-right"></div>
									<div class="clearfix"></div>
								</div>
							</div>
							<hr class="light-grey-hr row mt-10 mb-15" />
							<div class="label-chatrs">
								<div class="">
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">5.54% Refrral</span><span class="block txt-grey">36 visits</span></span>
									<div id="sparkline_2" class="sp-small-chart pull-right"></div>
									<div class="clearfix"></div>
								</div>
							</div>
							<hr class="light-grey-hr row mt-10 mb-15" />
							<div class="label-chatrs">
								<div class="">
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">50% Other</span><span class="block txt-grey">245 visits</span></span>
									<div id="sparkline_3" class="sp-small-chart pull-right"></div>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Row -->

		<!-- Row -->
		<div class="row">
			<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
				<div class="panel panel-default card-view panel-refresh">
					<div class="refresh-container">
						<div class="la-anim-1"></div>
					</div>
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">social campaigns</h6>
						</div>
						<div class="pull-right">
							<a href="#" class="pull-left inline-block refresh mr-15">
								<i class="zmdi zmdi-replay"></i>
							</a>
							<a href="#" class="pull-left inline-block full-screen mr-15">
								<i class="zmdi zmdi-fullscreen"></i>
							</a>
							<div class="pull-left inline-block dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
								<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body row pa-0">
							<div class="table-wrap">
								<div class="table-responsive">
									<table class="table table-hover mb-0">
										<thead>
											<tr>
												<th>Campaign</th>
												<th>Client</th>
												<th>Changes</th>
												<th>Budget</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><span class="txt-dark weight-500">Facebook</span></td>
												<td>Beavis</td>
												<td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>2.43%</span></span></td>
												<td>
													<span class="txt-dark weight-500">$1478</span>
												</td>
												<td>
													<span class="label label-primary">active</span>
												</td>
											</tr>
											<tr>
												<td><span class="txt-dark weight-500">Youtube</span></td>
												<td>Felix</td>
												<td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>1.43%</span></span></td>
												<td>
													<span class="txt-dark weight-500">$951</span>
												</td>
												<td>
													<span class="label label-danger">Closed</span>
												</td>
											</tr>
											<tr>
												<td><span class="txt-dark weight-500">Twitter</span></td>
												<td>Cannibus</td>
												<td><span class="txt-danger"><i class="zmdi zmdi-caret-down mr-10 font-20"></i><span>-8.43%</span></span></td>
												<td>
													<span class="txt-dark weight-500">$632</span>
												</td>
												<td>
													<span class="label label-default">Hold</span>
												</td>
											</tr>
											<tr>
												<td><span class="txt-dark weight-500">Spotify</span></td>
												<td>Neosoft</td>
												<td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>7.43%</span></span></td>
												<td>
													<span class="txt-dark weight-500">$325</span>
												</td>
												<td>
													<span class="label label-default">Hold</span>
												</td>
											</tr>
											<tr>
												<td><span class="txt-dark weight-500">Instagram</span></td>
												<td>Hencework</td>
												<td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>9.43%</span></span></td>
												<td>
													<span class="txt-dark weight-500">$258</span>
												</td>
												<td>
													<span class="label label-primary">Active</span>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
				<div class="panel panel-default card-view panel-refresh">
					<div class="refresh-container">
						<div class="la-anim-1"></div>
					</div>
					<div class="panel-heading">
						<div class="pull-left">
							<h6 class="panel-title txt-dark">Advertising & Promotions</h6>
						</div>
						<div class="pull-right">
							<a href="#" class="pull-left inline-block refresh mr-15">
								<i class="zmdi zmdi-replay"></i>
							</a>
							<div class="pull-left inline-block dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
								<ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
									<li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<div id="e_chart_3" class="" style="height:236px;"></div>
							<div class="label-chatrs text-center mt-30">
								<div class="inline-block mr-15">
									<span class="clabels inline-block bg-green mr-5"></span>
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
								</div>
								<div class="inline-block mr-15">
									<span class="clabels inline-block bg-light-green mr-5"></span>
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font">Closed</span>
								</div>
								<div class="inline-block">
									<span class="clabels inline-block bg-xtra-light-green mr-5"></span>
									<span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row -->
	</div>