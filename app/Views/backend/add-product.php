<?php
$session = session();
helper('inflector');
$request = \Config\Services::request();
$validation = \Config\Services::validation();


$productCategoryName = $request->getGet('gender');


?>
<div class="page-wrapper" style="min-height: 910px;">
	<div class="container-fluid">
		<!-- Title -->
		<div class="row heading-bg">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h5 class="txt-dark">Add Product</h5>
			</div>
			<!-- Breadcrumb -->
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
					<li class="active"><span>Add-product</span></li>
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
								<form action="<?= base_url('admin/add-product') ?>" method="POST" enctype="multipart/form-data">
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>about product</h6>
									<input id="productGender" type="hidden" value="<?= $request->getGet('gender') ?>">
									<hr class="light-grey-hr">
									<div class="row">
										<div class="d-none">
										</div>
										<div class="col-md-12">
											<?= csrf_field() ?>
											<div class="form-group">
												<label for="productName" class="control-label mb-10">Product Name</label>
												<input type="text" id="productName" name="productName" value="<?= old('productName') ?>" class="form-control <?= validation_show_error('productName') ? "error" : "" ?>" placeholder="Product Name" required>
												<?= validation_show_error('productName') ?>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="shortDescription" class="control-label mb-10">Short Description (max character : 250)</label>

													<textarea class="form-control <?= validation_show_error('shortDescription') ? "error" : "" ?>" id="shortDescription" name="shortDescription" rows="4" maxlength="250"><?= old('shortDescription') ?></textarea>
												</div>
											</div>
										</div>


									</div>
									<!-- Row -->
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="productCategory" class="control-label mb-10">Category</label>
												<select class="form-select <?= validation_show_error('productCategory') ? "error" : "" ?>" name="productCategory" data-placeholder="Choose a Category" tabindex="1">
													<option value="">Select Category</option>

													<?php if ($category) :
														foreach ($category as $row) : ?>
															<option value="<?= $row->category_id ?>" <?= old('productCategory') == $row->category_id ? "selected" : "" ?>>
																<?= $row->category_name ?></option>


													<?php endforeach;
													endif;
													?>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="featured" class="control-label mb-10">New Product</label>
												<select class="form-select <?= validation_show_error('featured') ? "error" : "" ?>" id="featured" name="featured" data-placeholder="Choose a Category" tabindex="1">
													<option value="">Select Feature Product</option>
													<option value="1" <?= old('featured') == 1 ? "selected" : "" ?>>YES</option>
													<option value="0" <?= old('featured') == 0 ? "selected" : "" ?>>NO</option>

												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="stockStatus" class="control-label mb-10">Stock Status</label>
												<select class="form-select <?= validation_show_error('stockStauts') ? "error" : "" ?>" id="stockStatus" name="stockStatus" data-placeholder="Choose a Category" tabindex="1">
													<option value="1" <?= old('stockStaus') == 1 ? "selected" : "" ?>>In Stock</option>
													<option value="0">Out of Stock</option>

												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="isVisible" class="control-label mb-10">Visible</label>
												<select class="form-select <?= validation_show_error('isVisible') ? "error" : "" ?>" id="isVisible" name="isVisible" data-placeholder="Choose a Category" tabindex="1">
													<option value="1" <?= old('isVisible') == 1 ? "selected" : "" ?>>YES</option>
													<option value="0">NO</option>

												</select>
											</div>
										</div>

									</div>
									<!--/row-->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="price" class="control-label mb-10">Price</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="ti-money"></i></div>
													<input type="text" name="price" class="form-control <?= validation_show_error('price') ? "error" : "" ?>" value="<?= old('price') ?>" id="price" placeholder="price" requried>
												</div>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label for="salePrice" class="control-label mb-10">Sale Price</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="ti-cut"></i></div>
													<input type="text" value="<?= old('salePrice') ?>" name="salePrice" class="form-control <?= validation_show_error('salePrice') ? "error" : "" ?>" id="salePrice">
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="sku" class="control-label mb-10">SKU</label>
												<input type="text" name="sku" value="<?= old('sku') ?>" class="form-control <?= validation_show_error('sku') ? "error" : "" ?>" id="sku" maxlength="100" placeholder="sku">
											</div>
										</div>

										<!--/span-->
										<div class="col-md-4">
											<div class="form-group">
												<label for="stockQuantity" class="control-label mb-10">Stock Quantity</label>
												<input type="text" name="stockQuantity" value="<?= old('stockQuantity') ?>" class="form-control <?= validation_show_error('stockQuantity') ? "error" : "" ?>" id="stockQuantity" placeholder="Stock Quanity" required>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-4">
											<div class="form-group">
												<label for="maxQuantity" class="control-label mb-10">Max Quanity (User Buy)</label>
												<select class="form-select <?= validation_show_error('maxQuantity') ? "error" : "" ?>" id="maxQuantity" name="maxQuantity" tabindex="1">
													<option value="5" <?= old('maxQuantity') == 5 ? "selected" : "" ?>>5</option>
													<option value="1" <?= old('maxQuantity') == 1 ? "selected" : "" ?>>1</option>
													<option value="10" <?= old('maxQuantity') == 10 ? "selected" : "" ?>>10</option>

												</select>
											</div>
										</div>
									</div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Product Description</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<textarea class="form-control <?= validation_show_error('productDescription') ? "error" : "" ?>" name="productDescription" placeholder="productDescription" rows="4"><?= old('productDescription') ?></textarea>
											</div>
										</div>
									</div>


									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>general info</h6>
									<hr class="light-grey-hr">

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="baseDesign" class="control-label mb-10">Base Design</label>
												<input type="text" id="baseDesign" value="<?= old('baseDesign') ?>" name="baseDesign" class="form-control <?= validation_show_error('baseDesign') ? "error" : "" ?>" placeholder="Base Design">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="basesize" class="control-label mb-10">Base size (eg: 8" X 10")</label>
												<select class="form-select <?= validation_show_error('baseSize') ? "error" : "" ?>" id="baseSize" name="baseSize" tabindex="1">
													<option value="">Select Base Size</option>
													
													<option value="2 X 2"> 2 inches x 2 inches</option>
													<option value="3 X 2.5"> 3 inches x 2.5 inches</option>
													<option value="4 X 4"> 4 inches x 4 inches</option>
													<option value="5 X 5"> 5 inches x 5 inches</option>
													<option value="6 X 8"> 6 inches x 8 inches</option>
													<option value="6 X 9"> 6 inches x 9 inches</option>
													<option value="7 X 9">7 inches x 9 inches</option>
													<option value="7 X 10">7 inches x 10 inches</option>
													<option value="8 X 10">8 inches x 10 inches</option>
													<option value="6 X 1">6 inches x 1 inches</option>
													<option value="6 X 1.5">6 inches x 1.5 inches</option>
													<option value="6 X 2">6 inches x 2 inches</option>
													<option value="4 X 4">4 inches x 4 inches</option>
													<option value="5 X 5">5 inches x 5 inches</option>
													<option value="7 X 4">7 inches x 4 inches</option>
													<option value="4 x 4, 5 x 5">4''x4'', 5''x5''</option>
													<option value="6 x 0.75, 6 x 1, 6 x 1.5, 6 x 2">6''x0.75'', 6''x1'', 6''x1.5'', 6''x2''</option>
													<option value="6 x 8, 6 x 9, 7 x 9, 7 x 10, 8 x 10">6" x 8", 6" x 9", 7" x 9", 7" x 10", 8" x 10"</option>
													
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairColor" class="control-label mb-10">Hair Color</label>
												<select class="form-select <?= validation_show_error('hairColor') ? "error" : "" ?>" id="hairColor" name="hairColor" tabindex="1">
													<option value="">Select Hair Color</option>
													<option value="Dark"> Dark</option>
													<option value="Brown"> Brown</option>
													<option value="Blonde">Blonde</option>
													<option value="Gray">Gray</option>
													<option value="Redish">Redish</option>
													<option value="Dual Color">Dual Color</option>
													<option value="Dural Color">Dural Color</option>


												</select>

											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="baseMaterial" class="control-label mb-10">Base Material Color</label>
												<select class="form-select <?= validation_show_error('baseMaterial') ? "error" : "" ?>" id="baseMaterial" name="baseMaterial" tabindex="1">
													<option value="">Select Base Material</option>
													<option value="Full lace">Full lace</option>
													<option value="Lace front"> Lace front</option>
													<option value="Lace with perimeters">Lace with perimeters</option>
													<option value="Full mono">Full mono</option>
													<option value="Mono with perimeters">Mono with perimeters</option>
													<option value="Thin skin">Thin skin</option>
													<option value="Silicon skin">Silicon skin</option>
													<option value="Integration">Integration</option>
													<option value="Flesh">Flesh</option>
													<option value="Transparent">Transparent</option>


												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="frontContour" class="control-label mb-10">Front Contour</label>
												<select class="form-select <?= validation_show_error('frontContour') ? "error" : "" ?>" id="frontContour" name="frontContour" tabindex="1">
													<option value="">Select Front Contour</option>
													<option value="S (Standard)">S (Standard)</option>
													<option value="A-6606"> A</option>
													<option value="CC"> CC</option>
												</select>
											</div>
										</div>

										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairLength" class="control-label mb-10">Hair Length (Eg: 5-6 )</label>
												<input type="text" id="hairLength" value="<?= old('hairLength') ?>" name="hairLength" class="form-control <?= validation_show_error('hairLength') ? "error" : "" ?>" placeholder="Hair Length">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairDensity" class="control-label mb-10">Hair Density</label>
												<select class="form-select <?= validation_show_error('hairDensity') ? "error" : "" ?>" id="hairDensity" name="hairDensity" tabindex="1">
													<option value="">Select Hair Density</option>
													<option value="Extra Light 60%" <?= old('hairDensity') == 'Extra Light 60%' ? "selected" : "" ?>>Extra Light 60%</option>
													<option value="Extra Light 70%" <?= old('hairDensity') == 'Extra Light 70%' ? "selected" : "" ?>>Extra Light 70%</option>
													<option value="Light 80%" <?= old('hairDensity') == 'Light 80%' ? "selected" : "" ?>>Light 80%</option>
													<option value="Light to Medium Light 90%" <?= old('hairDensity') == 'Light to Medium Light 90%' ? "selected" : "" ?>>Light to Medium Light 90%</option>
													<option value="Medium Light 100%" <?= old('hairDensity') == 'Medium Light 100%' ? "selected" : "" ?>>Medium Light 100%</option>
													<option value="Medium-light to Medium 110%" <?= old('hairDensity') == 'Medium-light to Medium 110%' ? "selected" : "" ?>>Medium-light to Medium (110%)</option>
													<option value="Medium Light 120%" <?= old('hairDensity') == 'Medium Light 120%' ? "selected" : "" ?>>Medium Light 120%</option>
													<option value="Medium Heavy 140%" <?= old('hairDensity') == 'Medium Heavy 140%' ? "selected" : "" ?>>Medium Heavy 140%</option>

												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairType" class="control-label mb-10">Hair Type</label>
												<select class="form-select <?= validation_show_error('hairType') ? "error" : "" ?>" id="hairType" name="hairType" tabindex="1">
													<option value="">Select Hair Type</option>
													<option value="Remy Hair">Remy Hair</option>
													<option value="Indian Human Hair"> Indian Human Hair</option>
													<option value="European Human Hair"> European Human Hair</option>
													<option value="Human hair (Gray hair is synthetic)"> Human hair (Gray hair is synthetic) </option>
													<option value="100% Chiness Remy hair"> 100% Chiness Remy hair </option>
													<option value="Human Remy hair"> Human Remy hair </option>


												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairStyle" class="control-label mb-10">Hair Style</label>
												<select class="form-select <?= validation_show_error('hairStyle') ? "error" : "" ?>" id="hairStyle" name="hairStyle" tabindex="1">
													<option value="">Select Hair Style</option>
													<option value="Amber">Amber</option>
													<option value="BandFall">BandFall</option>
													<option value="Diamond">Diamond</option>
													<option value="Divine">Divine</option>
													<option value="Emerald">Emerald</option>
													<option value="Gisele">Gisele</option>
													<option value="Halle">Halle</option>
													<option value="HatFall">HatFall</option>
													<option value="Luxe">Luxe</option>
													<option value="Nicole">Nicole</option>
													<option value="Onyx">Onyx</option>
													<option value="Ponytail">Ponytail</option>
													<option value="Princess">Princess</option>
													<option value="Reese">Reese</option>
													<option value="Sapphire">Sapphire</option>
													<option value="Secret">Secret</option>
													<option value="Topaz">Topaz</option>
													<option value="U-Shape">U-Shape</option>
													<option value="Victoria">Victoria</option>


												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairCurl" class="control-label mb-10">Curl & Wave (eg: 20 mm)</label>
												<input type="text" id="hairCurl" value="<?= old('hairCurl') ?>" name="hairCurl" class="form-control <?= validation_show_error('hairCurl') ? "error" : "" ?>" placeholder="Curl and Wave">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairDirection" class="control-label mb-10">Hair Direction</label>
												<input type="text" id="hairDirection" value="<?= old('hairDirection') ?>" name="hairDirection" class="form-control <?= validation_show_error('hairDirection') ? "error" : "" ?>" placeholder="Hair Direction">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lifeSpan" class="control-label mb-10">Life Span</label>
												<textarea id="lifeSpan" name="lifeSpan" class="form-control <?= validation_show_error('lifeSpan') ? "error" : "" ?>" placeholder="Life Span"><?= old('lifeSpan') ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="advantages" class="control-label mb-10">Advantages</label>
												<textarea id="advantages" name="advantages" class="form-control <?= validation_show_error('advantages') ? "error" : "" ?>" placeholder="Advantages"><?= old('advantages') ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="delivery" class="control-label mb-10">Delivery</label>
												<textarea id="delivery" name="delivery" class="form-control <?= validation_show_error('delivery') ? "error" : "" ?>" placeholder="Delivery"><?= old('delivery') ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="kindReminder" class="control-label mb-10">Kind Reminder</label>
												<textarea id="kindReminder" name="kindReminder" class="form-control <?= validation_show_error('kindReminder') ? "error" : "" ?>" placeholder="Kind Reminder"><?= old('kindReminder') ?></textarea>
											</div>
										</div>

									</div>


									
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Video Link</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="text" class="form-control <?= validation_show_error('video') ? "error" : "" ?>" name="video" placeholder="video Link">
											</div>
										</div>
									</div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i>upload image</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-lg-12">
											<div class="img-upload-wrap">
												<img class="img-responsive mb-2 d-none" id="imagePreview" src="" alt="upload_img" width="200" height="200">
											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Feature Image</span>

												<input type="file" id="featureImage" class="upload <?= validation_show_error('featureImage') ? "error" : "" ?>" name="featureImage" accept="image/*">
											</div>
										</div>
									</div>


									<h6 class="txt-dark capitalize-font mt-3"><i class="zmdi zmdi-collection-image mr-10"></i>Product Gallery</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-lg-12">
											<div class="product-gallery-wrapper">

											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">UploadProduct Gallery</span>
												<input type="file" id="produtGallery" class="uploads <?= validation_show_error('upload') ? "error" : "" ?>" name="productGallery[]" multiple accept="image/*">
											</div>
										</div>
									</div>
									<div class="seprator-block"></div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Product Attributes Category</h6>
									<hr class="light-grey-hr">

									<div class="row  product-attributes-category" id="attributeCategoryWrapper">

										<?php if ($productAttributeCategory) :
											foreach ($productAttributeCategory as $row) : ?>
												<?php if ($row->attribute_categorie_id == 15) {
													continue;
												}

												if ($productCategoryName == 'men' && ($row->attribute_categorie_id == 20)) {

													continue;
												}
												if ($productCategoryName  == 'women' && ($row->attribute_categorie_id == 16)) {
													continue;
												}

												?>
												<div class="form-check col-2 mb-2">
													<input class="form-check-input" type="checkbox" name="attributeCategory[]" <?= old('attributesCategory') == $row->attribute_categorie_id ? "checked" : "" ?> value="<?= $row->attribute_categorie_id ?>" data-category="<?= $row->categorie_name ?>" id="<?= $row->categorie_name ?>">
													<label class="form-check-label" for="<?= $row->categorie_name ?>">
														<?= $row->title ?>
													</label>
												</div>

										<?php endforeach;
										endif;
										?>

									</div>

									<div class="seprator-block"></div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Recommended Product</h6>
									<hr class="light-grey-hr">

									<div class="">

										<select id="multiple-checkboxes" multiple="multiple" name="recommendedProduct[]">

									<?php if($recommendedProduct): foreach($recommendedProduct as $row): ?>
										<option value="<?=$row->product_id?>"><?= $row->product_name?></option>
                                   <?php endforeach; endif; ?>
										
											
										</select>
									</div>


									<div class="seprator-block"></div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Help me Choose</h6>
									<hr class="light-grey-hr">

									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="helpGender" id="gender-label" class="control-label mb-10">Gender</label>
												<select class="form-select <?= validation_show_error('helpGender') ? "error" : "" ?>" id="helpGender" name="helpGender" data-placeholder="Choose a Category" tabindex="1">
													<option value="">Select Gender</option>
													<option value="1" <?= old('helpGender') == 1 ? "selected" : "" ?>>Male</option>
													<option value="2" <?= old('helpGender') == 2 ? "selected" : "" ?>>Female</option>

												</select>
											</div>
										</div>


									</div>
									<div class="row help-me-chosse-options">

									</div>
									<div class="form-actions">
										<button type="submit" class="btn btn-success btn-icon left-icon mr-10 pull-left"> <i class="fa fa-check"></i> <span>Save</span></button>
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
	<!-- Modal for men or women -->

	<!-- Modal -->

	<?php if ($productCategoryName == '' && !$request->getGet('gender')) : ?>
		<div class="overlay fade active"></div>
		<div class="modal fade in d-block" id="newProductGender" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
			<div class="modal-dialog  modal-notify modal-danger" role="document">
				<!--Content-->
				<div class="modal-content text-center">
					<!--Header-->
					<div class="modal-header d-flex justify-content-center">
						<p class="heading">Select Product Gender For</p>
					</div>
					<div id="#errorWrapper"> </div>
					<!--Body-->
					<div class="modal-body">

						<div class="mb-3">

							<a class="btn btn-success btn-icon left-icon mr-10" href="<?= base_url('admin/add-product?gender=men') ?>">MEN</a>
							<a class="btn btn-success btn-icon left-icon mr-10" href="<?= base_url('admin/add-product?gender=women') ?>">Women</a>
						</div>



					</div>
					<!--Footer-->


					<div class="modal-footer flex-center">
						<button type="button" class="btn border border-2 text-black" id="modalClose">Close</button>
					</div>

				</div>
				<!--/.Content-->
			</div>
		</div>


	<?php endif; ?>

</div>