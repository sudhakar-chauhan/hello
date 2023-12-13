<?php
$session = session();
helper('inflector');
$request = \Config\Services::request();
$validation = \Config\Services::validation();

?>
<div class="page-wrapper" style="min-height: 910px;">
	<div class="container-fluid">
		<!-- Title -->
		<div class="row heading-bg">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h5 class="txt-dark">Edit Blog</h5>
			</div>
			<!-- Breadcrumb -->
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
					<li class="active"><span>eidt-blog</span></li>
				</ol>
			</div>
			<!-- /Breadcrumb -->
		</div>
		<!-- /Title -->

		<!-- Row -->

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default card-view">
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							<?php
							if ($session->has('message') && $session->get('message') != '') {
								echo $session->getFlashdata('message');
							}
							?>
							<div class="form-wrap">
								<form action="<?= base_url('admin/edit-blog') ?>" method="POST" enctype="multipart/form-data">


                                <div class="d-none">
                                    <input type="hidden" name="id" value="<?=$data[0]->blog_id?>">
                                </div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>Edit Blog</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="d-none">
										</div>
										<div class="col-md-12">
											<?= csrf_field() ?>
											<div class="form-group">
												<label for="heading" class="control-label mb-10">Heading</label>
												<input type="text" id="heading" name="heading" value="<?= $data[0]->heading ?>" class="form-control <?= validation_show_error('heading') ? "error" : "" ?>" placeholder="Heading" required>
												<?= validation_show_error('heading') ?>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="shortDescription" class="control-label mb-10">Short Description (max character : 250)</label>
													<textarea class="form-control  <?= validation_show_error('shortDescription') ? "error" : "" ?>" id="shortDescription" name="shortDescription" rows="4" maxlength="250"><?= $data[0]->short_description?></textarea>
												</div>
											</div>
										</div>

									</div>
									<!-- Row -->
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="category" class="control-label mb-10">Category</label>
												<select class="form-select <?= validation_show_error('category') ? "error" : "" ?>" name="category" data-placeholder="Choose a Category" tabindex="1">
													<option value="<?=$data[0]->category?>"><?= $data[0]->category_name?></option>

													<?php if ($category) :
														foreach ($category as $row) : ?>
															<option value="<?= $row->blog_category_id ?>">
																<?= $row->category_name ?></option>
													<?php endforeach;
													endif;
													?>
												</select>
											</div>
										</div>
									</div>
							
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Blog Description</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<textarea class="form-control blogDescription <?= validation_show_error('blogDescription') ? "error" : "" ?>" name="blogDescription" placeholder="Blog Description" rows="4"><?= $data[0]->description ?></textarea>
											</div>
										</div>
									</div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i>Feature image</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-lg-12">
											<div class="img-upload-wrap">
												<img class="img-responsive mb-2" id="imagePreview" src="<?= base_url('public/assets/uploads/blog/').$data[0]->feature_image?>" alt="upload_img" width="200" height="200">
											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Feature Image</span>

												<input type="file" id="featureImage" class="upload <?= validation_show_error('featureImage') ? "error" : "" ?>" name="featureImage" accept="image/*">
											</div>
										</div>
									</div>

									<div class="form-actions mt-3">
										<button type="submit" class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span>Update</span></button>
										<button type="button" class="btn btn-warning pull-left">Cancel</button>
										<div class="clearfix"></div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- /Row -->
	</div>
</div>