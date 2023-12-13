<?php
$session = session();
helper('inflector');
$validation = \Config\Services::validation(); 
?>

<div class="page-wrapper" style="min-height: 910px;">
	<div class="container-fluid">
		<!-- Title -->
		<div class="row heading-bg">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<h5 class="txt-dark">Edit Product</h5>
			</div>
			<!-- Breadcrumb -->
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="<?= base_url('admin/dashboard')?>">Dashboard</a></li>
					<li class="active"><span>edit-product</span></li>
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
							if($session->has('message') && $session->get('message') != ''){
								echo $session->getFlashdata('message');
									}
							?>
							<div class="form-wrap">
								<form action="<?= base_url('admin/edit-product') ?>" method="POST" enctype="multipart/form-data">
								<div class="d-none">
                               <input id="productGender" type="hidden" value="<?= $products[0]->product_id == 1 ? "unisex": strtolower($productCategoryName) ?>">
                               </div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>about product</h6>
									<hr class="light-grey-hr">
									<div class="row">
									<div class="d-none">
			                    <input type="text" name="productId" id="productId" value="<?=$products[0]->product_id?>"> 
		                      </div>
										<div class="col-md-12">
											<?= csrf_field()?>
											<div class="form-group">
												<label for="productName" class="control-label mb-10">Product Name</label>
												<input type="text" id="productName" name="productName" value="<?= $products[0]->product_name ?>" class="form-control <?=validation_show_error('productName') ? "error" : "" ?>" placeholder="Product Name" required>
												<?=validation_show_error('productName')?>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="shortDescription" class="control-label mb-10">Short Description (max character : 250)</label>

													<textarea class="form-control <?=validation_show_error('shortDescription') ? "error" : "" ?>" id="shortDescription" name="shortDescription" rows="4" maxlength="250"><?= $products[0]->short_description ?></textarea>
												</div>
											</div>
										</div>


									</div>
									<!-- Row -->
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="productCategory" class="control-label mb-10">Category</label>
												<select class="form-select <?=validation_show_error('productCategory') ? "error" : "" ?>" name="productCategory" data-placeholder="Choose a Category" tabindex="1">
													<option value="">Select Category</option>

													<?php if ($category) :
														foreach ($category as $row) : ?>
															<option value="<?= $row->category_id ?>" <?= $row->category_id == $products[0]->category_id ? "selected" : "" ?>>
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
												<select class="form-select <?=validation_show_error('featured') ? "error" : "" ?>" id="featured" name="featured" data-placeholder="Choose a Category" tabindex="1">
													<option value="">Select Feature Product</option>
													<option value="1" <?= $products[0]->featured == 1 ? "selected" : "" ?>>YES</option>
													<option value="0" <?= $products[0]->featured == 0 ? "selected" : "" ?>>NO</option>

												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="stockStatus" class="control-label mb-10">Stock Status</label>
												<select class="form-select <?=validation_show_error('stockStauts') ? "error" : "" ?>" id="stockStatus" name="stockStatus" data-placeholder="Choose a Category" tabindex="1">
													<option value="1" <?= $products[0]->stock_status == 1 ? "selected" : "" ?>>In Stock</option>
													<option value="0" <?= $products[0]->stock_status == 0 ? "selected" : "" ?>>Out of Stock</option>

												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label for="isVisible" class="control-label mb-10">Visible</label>
												<select class="form-select <?=validation_show_error('isVisible') ? "error" : "" ?>" id="isVisible" name="isVisible" data-placeholder="Choose a Category" tabindex="1">
													<option value="1" <?= $products[0]->is_visible == 1 ? "selected" : "" ?>>YES</option>
													<option value="0" <?= $products[0]->is_visible == 0 ? "selected" : "" ?>>NO</option>

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
													<input type="text" name="price" class="form-control <?=validation_show_error('price') ? "error" : "" ?>" value="<?= $products[0]->price ?>" id="price" placeholder="price" requried>
												</div>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-6">
											<div class="form-group">
												<label for="salePrice" class="control-label mb-10">Sale Price</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="ti-cut"></i></div>
													<input type="text" value="<?= $products[0]->sale_price ?>" name="salePrice" class="form-control <?=validation_show_error('salePrice') ? "error" : "" ?>" id="salePrice">
												</div>
											</div>
										</div>
										<!--/span-->
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="sku" class="control-label mb-10">SKU</label>
												<input type="text" name="sku" value="<?= $products[0]->sku ?>" class="form-control <?=validation_show_error('sku') ? "error" : "" ?>" id="sku" maxlength="100" placeholder="sku">
											</div>
										</div>

										<!--/span-->
										<div class="col-md-4">
											<div class="form-group">
												<label for="stockQuantity" class="control-label mb-10">Stock Quantity</label>
												<input type="text" name="stockQuantity" value="<?= $products[0]->stock_quantity ?>" class="form-control <?=validation_show_error('stockQuantity') ? "error" : "" ?>" id="stockQuantity" placeholder="Stock Quanity" required>
											</div>
										</div>
										<!--/span-->
										<div class="col-md-4">
											<div class="form-group">
												<label for="maxQuantity" class="control-label mb-10">Max Quanity (User Buy)</label>
												<select class="form-select <?=validation_show_error('maxQuantity') ? "error" : "" ?>" id="maxQuantity" name="maxQuantity" tabindex="1">
													<option value="5" <?= $products[0]->max_quantity == 5 ? "selected" : "" ?>>5</option>
													<option value="1" <?= $products[0]->max_quantity == 1 ? "selected" : "" ?>>1</option>
													<option value="10" <?= $products[0]->max_quantity == 10 ? "selected" : "" ?>>10</option>
													<option value="1000" <?= $products[0]->max_quantity == 1000 ? "selected" : "" ?>>Unlimited</option>

												</select>
											</div>
										</div>
									</div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Product Description</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<textarea class="form-control <?=validation_show_error('productDescription') ? "error" : "" ?>"
												 name="productDescription" placeholder="productDescription" rows="4"><?= $products[0]->description ?></textarea>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="slug" class="control-label mb-10">Slug</label>

												<input type="text" name="slug" id="slug" class="form-control <?=validation_show_error('slug') ? "error" : "" ?>" value="<?= $products[0]->slug ?>" placeholder="slug" required>
											</div>
										</div>
									</div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>general info</h6>
									<hr class="light-grey-hr">

									<div class="row">
										<div class="col-sm-4">
											<?php $metaData = json_decode($products[0]->meta_data) ?>
											<div class="form-group">
												<label for="baseDesign" class="control-label mb-10">Base Design</label>
												<input type="text" id="baseDesign" value="<?= $metaData->base_design ?>" name="baseDesign" 
												class="form-control <?=validation_show_error('baseDesign') ? "error" : "" ?>" placeholder="Base Design">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="basesize" class="control-label mb-10">Base size (eg: 8" X 10")</label>
												<select class="form-select <?=validation_show_error('baseSize') ? "error" : "" ?>" id="baseSize"
												 name="baseSize" tabindex="1">
												 <option value="">Select Base Size</option>
													<option value="2 X 2" <?= $metaData->base_size == "2 X 2" ? "selected" : "" ?>> 2 inches x 2 inches</option>
													<option value="3 X 2.5" <?= $metaData->base_size == "3 X 2.5" ? "selected" : "" ?>> 3 inches x 2.5 inches</option>
													<option value="4 X 4" <?= $metaData->base_size == "4 X 4" ? "selected" : "" ?>> 4 inches x 4 inches</option>
													<option value="5 X 5" <?= $metaData->base_size == "5 X 5" ? "selected" : "" ?>> 5 inches x 5 inches</option>
													<option value="6 X 8" <?= $metaData->base_size == "6 X 8" ? "selected" : "" ?>> 6 inches x 8 inches</option>
													<option value="6 X 9" <?= $metaData->base_size == "6 X 9" ? "selected" : "" ?>> 6 inches x 9 inches</option>
													<option value="7 X 9" <?= $metaData->base_size == "7 X 9" ? "selected" : "" ?>>7 inches x 9 inches</option>
													<option value="7 X 10" <?= $metaData->base_size == "7 X 10" ? "selected" : "" ?>>7 inches x 10 inches</option>
													<option value="8 X 10" <?= $metaData->base_size == "8 X 10" ? "selected" : "" ?>>8 inches x 10 inches</option>
													<option value="6 X 1" <?= $metaData->base_size == "6 X 1" ? "selected" : "" ?>>6 inches x 1 inches</option>
													<option value="6 X 1.5" <?= $metaData->base_size == "6 X 1.5" ? "selected" : "" ?>>6 inches x 1.5 inches</option>
													<option value="6 X 2" <?= $metaData->base_size == "6 X 2" ? "selected" : "" ?>>6 inches x 2 inches</option>
													<option value="4 X 4" <?= $metaData->base_size == "4 X 4" ? "selected" : "" ?>>4 inches x 4 inches</option>
													<option value="5 X 5" <?= $metaData->base_size == "5 X 5" ? "selected" : "" ?>>5 inches x 5 inches</option>
													<option value="7 X 4" <?= $metaData->base_size == "7 X 4" ? "selected" : "" ?>>7 inches x 4 inches</option>
														<option value="4 x 4, 5 x 5"   <?= $metaData->base_size == "4 x 4, 5 x 5" ? "selected" : "" ?>>4''x4'', 5''x5''</option>
													<option value="6 x 0.75, 6 x 1, 6 x 1.5, 6 x 2" <?= $metaData->base_size == "6 x 0.75, 6 x 1, 6 x 1.5, 6 x 2" ? "selected" : "" ?>>6''x0.75'', 6''x1'', 6''x1.5'', 6''x2''</option>
	                                 <option value="6 x 8, 6 x 9, 7 x 9, 7 x 10, 8 x 10"  <?= $metaData->base_size == "6 x 8, 6 x 9, 7 x 9, 7 x 10, 8 x 10" ? "selected" : "" ?>>6" x 8", 6" x 9", 7" x 9", 7" x 10", 8" x 10"</option>

												</select>
												
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairColor" class="control-label mb-10">Hair Color</label>
												<select class="form-select <?=validation_show_error('hairColor') ? "error" : "" ?>" id="hairColor"
												 name="hairColor" tabindex="1">
													<option value="">Select Hair Color</option>
													<option value="Dark" <?= $metaData->hair_color == "Dark" ? "selected" : "" ?>> Dark</option>
													<option value="Brown" <?= $metaData->hair_color == "Brown" ? "selected" : "" ?>> Brown</option>
													<option value="Blonde" <?= $metaData->hair_color == "Blonde" ? "selected" : "" ?>>Blonde</option>
													<option value="Gray" <?= $metaData->hair_color == "Gray" ? "selected" : "" ?>>Gray</option>
													<option value="Redish" <?= $metaData->hair_color == "Redish" ? "selected" : "" ?>>Redish</option>
													<option value="Dual Color" <?= $metaData->hair_color == "Dual Color" ? "selected" : "" ?>>Dual Color</option>
													<option value="Dural Color" <?= $metaData->hair_color == "Dural Color" ? "selected" : "" ?>>Dural Color</option>


												</select>
											
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="baseMaterial" class="control-label mb-10">Base Material Color</label>

												<select class="form-select <?=validation_show_error('baseMaterial') ? "error" : "" ?>" id="baseMaterial"
												 name="baseMaterial" tabindex="1">
													<option value="">Select Base Material</option>
													<option value="Full lace" <?= $metaData->base_material_color == "Full lace" ? "selected" : "" ?>>Full lace</option>
													<option value="Lace front" <?= $metaData->base_material_color == "Lace front" ? "selected" : "" ?>> Lace front</option>
													<option value="Lace with perimeters" <?= $metaData->base_material_color == "Lace with perimeters" ? "selected" : "" ?>>Lace with perimeters</option>
													<option value="Full mono" <?= $metaData->base_material_color == "Full mono" ? "selected" : "" ?>>Full mono</option>
													<option value="Mono with perimeters" <?= $metaData->base_material_color == "Mono with perimeters" ? "selected" : "" ?>>Mono with perimeters</option>
													<option value="Thin skin" <?= $metaData->base_material_color == "Thin skin" ? "selected" : "" ?>>Thin skin</option>
													<option value="Silicon skin" <?= $metaData->base_material_color == "Silicon skin" ? "selected" : "" ?>>Silicon skin</option>
													<option value="Integration" <?= $metaData->base_material_color == "Integration" ? "selected" : "" ?>>Integration</option>
													<option value="Flesh" <?= $metaData->base_material_color == "Flesh" ? "selected" : "" ?>>Flesh</option>
													<option value="Transparent" <?= $metaData->base_material_color == "Transparent" ? "selected" : "" ?>>Transparent</option>

												</select>
												
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="frontContour" class="control-label mb-10">Front Contour</label>
												<select class="form-select <?=validation_show_error('frontContour') ? "error" : "" ?>" id="frontContour"
												 name="frontContour" tabindex="1">
													<option value="">Select Front Contour</option>
													<option value="S (Standard)" <?= $metaData->front_contour == "S (Standard)" ? "selected" : "" ?>>S (Standard)</option>
													<option value="A-6606" <?= $metaData->front_contour == "A-6606" ? "selected" : "" ?>> A</option>
													<option value="CC" <?= $metaData->front_contour == "CC" ? "selected" : "" ?>> CC</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairLength" class="control-label mb-10">Hair Length (Eg: 5-6 )</label>
												<input type="text" id="hairLength" value="<?= $metaData->hair_length ?>" 
												name="hairLength" class="form-control <?=validation_show_error('hairLength') ? "error" : "" ?>" placeholder="Hair Length">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairDensity" class="control-label mb-10">Hair Density</label>
												<select class="form-select <?=validation_show_error('hairDensity') ? "error" : "" ?>" id="hairDensity" name="hairDensity" tabindex="1">
													<option value="">Select Hair Density</option>
													<option value="Extra Light 60%" <?= $metaData->hair_density == "Extra Light 60%" ? "selected" : "" ?>>Extra Light 60%</option>
													<option value="Extra Light 70%" <?= $metaData->hair_density == "Extra Light 70%" ? "selected" : "" ?>>Extra Light 70%</option>
													<option value="Light 80%" <?= $metaData->hair_density == "Light 80%" ? "selected" : "" ?>>Light 80%</option>
													<option value="Light to Medium Light 90%"  <?= $metaData->hair_density == "Light to Medium Light 90%" ? "selected" : "" ?>>Light to Medium Light 90%</option>
													<option value="Medium Light 100%" <?= $metaData->hair_density == "Medium Light 100%" ? "selected" : "" ?>>Medium Light 100%</option>
													<option value="Medium-light to Medium 110%" <?= $metaData->hair_density == "Medium-light to Medium 110%" ? "selected" : "" ?>>Medium-light to Medium 110%</option>
													<option value="Medium Light 120%" <?= $metaData->hair_density == "Medium Light 120%" ? "selected" : "" ?>>Medium Light 120%</option>
													<option value="Medium Heavy 140%" <?= $metaData->hair_density == "Medium Heavy 140%" ? "selected" : "" ?>>Medium Heavy 140%</option>

												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairType" class="control-label mb-10">Hair Type</label>
												<select class="form-select <?=validation_show_error('hairType') ? "error" : "" ?>" id="hairType"
												 name="hairType" tabindex="1">
												 <option value="">Select Hair Type</option>
													<option value="Remy Hair" <?= $metaData->hair_type == "Remy Hair" ? "selected" : "" ?>>Remy Hair</option>
													<option value="Indian Human Hair" <?= $metaData->hair_type == "Indian Human Hair" ? "selected" : "" ?>> Indian Human Hair</option>
													<option value="European Human Hair" <?= $metaData->hair_type == "European Human Hair" ? "selected" : "" ?>> European Human Hair</option>
													<option value="Human hair (Gray hair is synthetic)" <?= $metaData->hair_type == "Human hair (Gray hair is synthetic)" ? "selected" : "" ?> > Human hair (Gray hair is synthetic) </option>
														<option value="100% Chiness Remy hair" <?= $metaData->hair_type == "100% Chiness Remy hair" ? "selected" : "" ?>> 100% Chiness Remy hair </option>
													<option value="Human Remy hair" <?= $metaData->hair_type == "Human Remy hair" ? "selected" : "" ?>> Human Remy hair </option>

												</select>
											</div>
										</div>
										<div class="col-sm-4">
										
											<div class="form-group">
												<label for="hairStyle" class="control-label mb-10">Hair Style</label>
												<select class="form-select <?=validation_show_error('hairStyle') ? "error" : "" ?>" id="hairStyle"
												 name="hairStyle" tabindex="1">
													<option value="">Select Hair Style</option>
													<option value="Amber" <?= $metaData->hair_style == "Amber" ? "selected" : "" ?>>Amber</option>
													<option value="BandFall" <?= $metaData->hair_style == "BandFall" ? "selected" : "" ?>>BandFall</option>
													<option value="Diamond" <?= $metaData->hair_style == "Diamond" ? "selected" : "" ?>>Diamond</option>
													<option value="Divine" <?= $metaData->hair_style == "Divine" ? "selected" : "" ?>>Divine</option>
													<option value="Emerald" <?= $metaData->hair_style == "Emerald" ? "selected" : "" ?>>Emerald</option>
													<option value="Gisele" <?= $metaData->hair_style == "Gisele" ? "selected" : "" ?>>Gisele</option>
													<option value="Halle" <?= $metaData->hair_style == "Halle" ? "selected" : "" ?>>Halle</option>
													<option value="HatFall" <?= $metaData->hair_style == "HatFall" ? "selected" : "" ?>>HatFall</option>
													<option value="Luxe" <?= $metaData->hair_style == "Luxe" ? "selected" : "" ?>>Luxe</option>
													<option value="Nicole" <?= $metaData->hair_style == "Nicole" ? "selected" : "" ?>>Nicole</option>
													<option value="Onyx" <?= $metaData->hair_style == "Onyx" ? "selected" : "" ?>>Onyx</option>
													<option value="Ponytail" <?= $metaData->hair_style == "Ponytail" ? "selected" : "" ?>>Ponytail</option>
													<option value="Princess" <?= $metaData->hair_style == "Princess" ? "selected" : "" ?>>Princess</option>
													<option value="Reese" <?= $metaData->hair_style == "Reese" ? "selected" : "" ?>>Reese</option>
													<option value="Sapphire" <?= $metaData->hair_style == "Sapphire" ? "selected" : "" ?>>Sapphire</option>
													<option value="Secret" <?= $metaData->hair_style == "Secret" ? "selected" : "" ?>>Secret</option>
													<option value="Topaz" <?= $metaData->hair_style == "Topaz" ? "selected" : "" ?>>Topaz</option>
													<option value="U-Shape" <?= $metaData->hair_style == "U-Shape" ? "selected" : "" ?>>U-Shape</option>
													<option value="Victoria" <?= $metaData->hair_style == "Victoria" ? "selected" : "" ?>>Victoria</option>
												</select>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairCurl" class="control-label mb-10">Curl & Wave (eg: 20 mm)</label>
												<input type="text" id="hairCurl" value="<?= $metaData->curl ?>" name="hairCurl" class="form-control <?=validation_show_error('hairCurl') ? "error" : "" ?>" placeholder="Curl and Wave">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="hairDirection" class="control-label mb-10">Hair Direction</label>
												<input type="text" id="hairDirection" value="<?= $metaData->hair_direction ?>" name="hairDirection" 
												class="form-control <?=validation_show_error('hairDirection') ? "error" : "" ?>" placeholder="Hair Direction">
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="lifeSpan" class="control-label mb-10">Life Span</label>
												<textarea id="lifeSpan" name="lifeSpan" class="form-control <?=validation_show_error('lifeSpan') ? "error" : "" ?>" placeholder="Life Span"><?= $metaData->lifespan ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="advantages" class="control-label mb-10">Advantages</label>
												<textarea id="advantages" name="advantages" class="form-control <?=validation_show_error('advantages') ? "error" : "" ?>" 
												placeholder="Advantages"><?= $metaData->advantages ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="delivery" class="control-label mb-10">Delivery</label>
												<textarea id="delivery" name="delivery" class="form-control <?=validation_show_error('delivery') ? "error" : "" ?>" placeholder="Delivery"><?= $metaData->delivery ?></textarea>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="kindReminder" class="control-label mb-10">Kind Reminder</label>
												<textarea id="kindReminder" name="kindReminder" class="form-control <?=validation_show_error('kindReminder') ? "error" : "" ?>" placeholder="Kind Reminder"><?= $metaData->kind_reminder ?></textarea>
											</div>
										</div>

									</div>


									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i>upload image</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-lg-12">
											<div class="img-upload-wrap">
												 <input type="text" name="oldImage" value="<?= $products[0]->feature_image?>" class="d-none">
												<img class="img-responsive mb-2" id="imagePreview" src="<?= base_url('public/assets/uploads/products/' . $products[0]->feature_image) ?>" alt="upload_img" width="200" height="200">
											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Feature Image</span>
											 
												<input type="file" id="featureImage" class="upload <?=validation_show_error('featureImage') ? "error" : "" ?>" name="featureImage" accept="image/*">
											</div>
										</div>
									</div>


									<h6 class="txt-dark capitalize-font mt-3"><i class="zmdi zmdi-collection-image mr-10"></i>Product Gallery</h6>
									<hr class="light-grey-hr">
									<div class="row">
										<div class="col-lg-12">
											<div class="product-gallery-wrapper d-flex">
												<?php if ($productGallery) :
													foreach ($productGallery as $row) :
												?>
												        
														<div class="product-gallery-image-wrapper">
														 <button type="btn" class="btn" id="deleteImage" data-id="<?= $row->product_image_id?>" data-name="<?= $row->image?>">
														 <svg height="512px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve"
														  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M443.6,387.1L312.4,255.4l131.5-130c5.4-5.4,5.4-14.2,0-19.6l-37.4-37.6c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4  L256,197.8L124.9,68.3c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4L68,105.9c-5.4,5.4-5.4,14.2,0,19.6l131.5,130L68.4,387.1  c-2.6,2.6-4.1,6.1-4.1,9.8c0,3.7,1.4,7.2,4.1,9.8l37.4,37.6c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1L256,313.1l130.7,131.1  c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1l37.4-37.6c2.6-2.6,4.1-6.1,4.1-9.8C447.7,393.2,446.2,389.7,443.6,387.1z"/></svg></button>	
														<img class="mb-2" src="<?= base_url('public/assets/uploads/products/' . $row->image) ?>" alt="upload_img" width="100" height="100">
														</div>

												<?php endforeach;
												endif;
												?>
											</div>
											<div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Product Gallery</span>
												<input type="file" id="produtGallery" class="uploads <?=validation_show_error('upload') ? "error" : "" ?>" name="productGallery[]" multiple accept="image/*">
											</div>
										</div>
									</div>
									<div class="seprator-block"></div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Product Attributes Category</h6>
									<hr class="light-grey-hr">

									<div class="row  product-attributes-category" id="attributeCategoryWrapper">

										<?php if ($productAttributeCategory) :
											foreach ($productAttributeCategory as $row) : ?>
												
	                                            <?php if(($products[0]->product_id != 1) ){

													if($row->attribute_categorie_id == 15 ){
														continue;
													}
												if(strtolower($productCategoryName) == 'men' && ($row->attribute_categorie_id == 20) ){
												
													continue;
	
												} 
												if(strtolower($productCategoryName)  == 'women' && ($row->attribute_categorie_id == 16 )){
													continue;
	
												} 
											      }
											?>

												<div class="form-check col-2 mb-2">
													<input class="form-check-input" <?= $row->product_attribute_id ? "checked" : "" ?> type="checkbox" name="attributeCategory[]" value="<?= $row->attribute_categorie_id ?>" data-category="<?= $row->categorie_name ?>" id="<?= $row->categorie_name ?>">
													<label class="form-check-label" for="<?= $row->categorie_name ?>">
														<?= $row->title ?>
													</label>
												</div>

										<?php endforeach;
										endif;
										?>

									</div>

                       <!-- ========================== Color Start============================== -->

									<?php if($attributes): foreach($attributes as $row): 
										
										  if((strtolower($productCategoryName) == 'men' && $row->product_attribute_id && $row->attribute_id == 44)
										  || (strtolower($productCategoryName)== 'women' && $row->product_attribute_id && $row->attribute_id == 45)):
										?>
	                                     <?php if($color):
										$categories = array();
										$Colorcategories = array();
										$div = '';
										  foreach($color as $row){ 
											$checked = '';

											$colorCategory = $row->color_categorie;
											  $category = $row->attribute_categorie;
											

											  $checked = $row->product_attribute_id ? "checked" : "";
											 
											
											  $clrCategoryHide = 'd-none';
												if(strtolower($productCategoryName) == 'men' &&    $category == 'hairColorMen'){
													$clrCategoryHide = '';

												}else if(strtolower($productCategoryName) == 'women' &&   $category == 'hairColorWomen' ){
													$clrCategoryHide = '';

												}
												if($products[0]->product_id == 1){
													$clrCategoryHide = '';
												 }
												  if (!isset($Colorcategories[$colorCategory])) {
													$Colorcategories[$colorCategory] = true;
								
													// Close the previous ul if any
													if (!empty($div)) {
														$div .= '</div> </div>';
													}
													$div .= ' <div class="attribute-category '. $clrCategoryHide.'" id="adata' . $row->attribute_categorie . '"> 
													<h4> '.$colorCategory.'</h4>
													<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>' . humanize(preg_replace('/([a-z])([A-Z])/', '$1 $2', $row->attribute_categorie)) . '</h6>
													<hr class="light-grey-hr">
													
														<div class="row attributes-wrapper">';
							
													// You can add further content specific to the category wrapper here
												}
								
												$div .= '<div class="form-check col-2">
												<input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$row->attribute_id.'" id="attr'.$row->attribute_name.'"  '.$checked.'>
												<label class="form-check-label" for="attr'.$row->attribute_name.'">
													'.$row->attribute_name.'
												</label>
											</div>';
											
										  }
											
											if (!empty($div)) {
												$div .= '</div> </div>';
											}
										?>
                                   <?php
								   echo $div;
								         endif;  
								   ?>
										<?php  endif; endforeach; endif; ?>
								

<!-- ========================== Color End============================== -->

<!-- ========================== HairStyle Start============================== -->

                    <?php if($attributes): foreach($attributes as $row): 
										
										if((strtolower($productCategoryName) == 'men' && $row->product_attribute_id && $row->attribute_id == 76)
										|| (strtolower($productCategoryName)== 'women' && $row->product_attribute_id && $row->attribute_id == 116)):
									  ?>
									   <?php if($hairStyle):
									  $categories = array();
									  $div = '';
										foreach($hairStyle as $row){ 
										  $checked = '';

											$category = $row->attribute_categorie;

											$checked = $row->product_attribute_id ? "checked" : "";
										   
										  
											  $clrCategoryHide = 'd-none';
											  if(strtolower($productCategoryName) == 'men' &&  $category == 'hairStyleMen'){
												  $clrCategoryHide = '';

											  }else if(strtolower($productCategoryName) == 'women' && $category == 'hairStyleWomen' ){
												  $clrCategoryHide = '';

											  }if($products[0]->product_id == 1){
												$clrCategoryHide = '';
											 }


									  
												// Check if the category is already encountered, if not, create the category wrapper
												if (!isset($categories[$category])) {
												  $categories[$category] = true;
							  
												  // Close the previous ul if any
												  if (!empty($div)) {
													  $div .= '</div> </div>';
												  }
												  $div .= ' <div class="attribute-category '.$clrCategoryHide.'" id="adata'.$row->attribute_categorie.'">
												   <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>'.humanize( preg_replace('/([a-z])([A-Z])/', '$1 $2', $row->attribute_categorie)).'</h6>
												  <hr class="light-grey-hr">
												  
													  <div class="row attributes-wrapper">';
							  
												  // You can add further content specific to the category wrapper here
											  }
							  
											  $div .= '<div class="form-check col-2">
											  <input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$row->attribute_id.'" id="attr'.$row->attribute_name.'"  '.$checked.'>
											  <label class="form-check-label" for="attr'.$row->attribute_name.'">
												  '.$row->attribute_name.'
											  </label>
										  </div>';
										  
										}
										  
										  if (!empty($div)) {
											  $div .= '</div> </div>';
										  }
									  ?>
								 <?php
								 echo $div;
									   endif;  
								 ?>
									  <?php  endif; endforeach; endif; ?>
							  

<!-- ========================== HairStyle End============================== -->

           <!-- ========================== Curl Start============================== -->

            <?php if($attributes): foreach($attributes as $row): 
										
										if((strtolower($productCategoryName) == 'men' && $row->product_attribute_id && $row->attribute_id == 30)
										|| (strtolower($productCategoryName)== 'women' && $row->product_attribute_id && $row->attribute_id == 31)):
									  ?>
									   <?php if($curl):
									  $categories = array();
									  $div = '';
										foreach($curl as $rowCurl){ 
										  $checked = '';

											$category = $rowCurl->attribute_categorie;

											$checked = $rowCurl->product_attribute_id ? "checked" : "";
										   
										  
											  $clrCategoryHide = 'd-none';
											  if(strtolower($productCategoryName) == 'men' &&  $category == 'curlMen'){
												  $clrCategoryHide = '';

											  }else if(strtolower($productCategoryName) == 'women' && $category == 'curlWomen' ){
												  $clrCategoryHide = '';

											  }if($products[0]->product_id == 1){
												$clrCategoryHide = '';
											 }


									  
												// Check if the category is already encountered, if not, create the category wrapper
												if (!isset($categories[$category])) {
												  $categories[$category] = true;
							  
												  // Close the previous ul if any
												  if (!empty($div)) {
													  $div .= '</div> </div>';
												  }
												  $div .= ' <div class="attribute-category '.$clrCategoryHide.'" id="adata'.$rowCurl->attribute_categorie.'">
												   <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>'.humanize( preg_replace('/([a-z])([A-Z])/', '$1 $2', $rowCurl->attribute_categorie)).'</h6>
												  <hr class="light-grey-hr">
												  
													  <div class="row attributes-wrapper">';
							  
												  // You can add further content specific to the category wrapper here
											  }
							  
											  $div .= '<div class="form-check col-2">
											  <input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$rowCurl->attribute_id.'" id="attr'.$rowCurl->attribute_name.'"  '.$checked.'>
											  <label class="form-check-label" for="attr'.$rowCurl->attribute_name.'">
												  '.$rowCurl->attribute_name.'
											  </label>
										  </div>';
										  
										}
										  
										  if (!empty($div)) {
											  $div .= '</div> </div>';
										  }
									  ?>
								 <?php
								 echo $div;
									   endif;  
								 ?>
									  <?php  endif; endforeach; endif; ?>
							  

<!-- ========================== Curl End============================== -->

<!-- ========================== perm Start============================== -->

                                    <?php if($attributes): foreach($attributes as $row): 
										
										if(( $row->product_attribute_id && $row->attribute_id == 143) ):
									  ?>
									   <?php if($perm):
									  $categories = array();
									  $div = '';
										foreach($perm as $permrow){ 
										  $checked = '';

											$category = $permrow->attribute_categorie;

											$checked = $permrow->product_attribute_id ? "checked" : "";
										   
												// Check if the category is already encountered, if not, create the category wrapper
												if (!isset($categories[$category])) {
												  $categories[$category] = true;
							  
												  // Close the previous ul if any
												  if (!empty($div)) {
													  $div .= '</div> </div>';
												  }
												  $div .= ' <div class="attribute-category " id="adata'.$permrow->attribute_categorie.'">
												   <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>'.humanize( preg_replace('/([a-z])([A-Z])/', '$1 $2', $permrow->attribute_categorie)).'</h6>
												  <hr class="light-grey-hr">
												  
													  <div class="row attributes-wrapper">';
							  
												  // You can add further content specific to the category wrapper here
											  }
							  
											  $div .= '<div class="form-check col-2">
											  <input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$permrow->attribute_id.'" id="attr'.$permrow->attribute_name.'"  '.$checked.'>
											  <label class="form-check-label" for="attr'.$permrow->attribute_name.'">
												  '.$permrow->attribute_name.'
											  </label>
										  </div>';
										  
										}
										  
										  if (!empty($div)) {
											  $div .= '</div> </div>';
										  }
									  ?>
								 <?php
								 echo $div;
									   endif;  
								 ?>
									  <?php  endif; endforeach; endif; ?>
							  

<!-- ========================== perm End============================== -->
<!-- ========================== grey Start============================== -->

                                    <?php if($attributes): foreach($attributes as $row): 
										
										if(( $row->product_attribute_id && $row->attribute_id == 143) ):
									  ?>
									   <?php if($grey):
									  $categories = array();
									  $div = '';
										foreach($grey as $permrow){ 
										  $checked = '';

											$category = $permrow->attribute_categorie;

											$checked = $permrow->product_attribute_id ? "checked" : "";
										   
												// Check if the category is already encountered, if not, create the category wrapper
												if (!isset($categories[$category])) {
												  $categories[$category] = true;
							  
												  // Close the previous ul if any
												  if (!empty($div)) {
													  $div .= '</div> </div>';
												  }
												  $div .= ' <div class="attribute-category " id="adata'.$permrow->attribute_categorie.'">
												   <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>'.humanize( preg_replace('/([a-z])([A-Z])/', '$1 $2', $permrow->attribute_categorie)).'</h6>
												  <hr class="light-grey-hr">
												  
													  <div class="row attributes-wrapper">';
							  
												  // You can add further content specific to the category wrapper here
											  }
							  
											  $div .= '<div class="form-check col-2">
											  <input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$permrow->attribute_id.'" id="attr'.$permrow->attribute_name.'"  '.$checked.'>
											  <label class="form-check-label" for="attr'.$permrow->attribute_name.'">
												  '.$permrow->attribute_name.'
											  </label>
										  </div>';
										  
										}
										  
										  if (!empty($div)) {
											  $div .= '</div> </div>';
										  }
									  ?>
								 <?php
								 echo $div;
									   endif;  
								 ?>
									  <?php  endif; endforeach; endif; ?>
							  

<!-- ========================== grey End============================== -->

										<?php  ?>

									<?php if($attributes):
										$categories = array();
										$div = '';
										  foreach($attributes as $row){ 


										
											  $category = $row->attribute_categorie;

											  $checked = $row->product_attribute_id ? "checked" : "";
										
											  $clrHide = '';
											  if($row->attribute_id == 44 || $row->attribute_id == 45 ){

											
												$clrHide = 'd-none';
												if(strtolower($productCategoryName) == 'men' && $row->attribute_id == 44){
													$clrHide = '';

												}else if(strtolower($productCategoryName) == 'women' && $row->attribute_id == 45 ){
													$clrHide = '';

												}
												if($products[0]->product_id == 1){
													$clrHide = '';

												}
											  }
								
											      // Check if the category is already encountered, if not, create the category wrapper
												  if (!isset($categories[$category])) {
													$categories[$category] = true;
								
													// Close the previous ul if any
													if (!empty($div)) {
														$div .= '</div> </div>';
													}
													$div .= ' <div class="attribute-category" id="adata'.$row->attribute_categorie.'">
													 <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>'.humanize( preg_replace('/([a-z])([A-Z])/', '$1 $2', $row->attribute_categorie)).'</h6>
													<hr class="light-grey-hr">
													
									                    <div class="row attributes-wrapper">';
								
													// You can add further content specific to the category wrapper here
												}
								
												$div .= '<div class="form-check col-2 '.$clrHide.'">
												<input class="form-check-input"  name="attributes[]" type="checkbox" value="'.$row->attribute_id.'" id="attr'.$row->attribute_name.'"  '.$checked.'>
												<label class="form-check-label" for="attr'.$row->attribute_name.'">
													'.$row->attribute_name.'
												</label>
											</div>';
											
										  }
											
											if (!empty($div)) {
												$div .= '</div> </div>';
											}
										?>


                                   <?php
								   echo $div;
								         endif;  
								   ?>
								
								<div class="seprator-block"></div>
									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Recommended Product</h6>
									<hr class="light-grey-hr">

									<div class="">

										<select id="multiple-checkboxes" multiple="multiple" name="recommendedProduct[]">

									<?php if($recommendedProduct): foreach($recommendedProduct as $row): ?>
										<option value="<?=$row->product_id?>" <?= $row->recommended_product_id !='' ? "selected": ""?>><?= $row->product_name?></option>
                                   <?php endforeach; endif; ?>
										
											
										</select>
									</div>

							
									<div class="seprator-block"></div>

									<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-calendar-note mr-10"></i>Help me Choose</h6>
									<hr class="light-grey-hr">

									<?php if ($helpMeChoose) : ?>


										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label for="helpGender" id="gender-label" class="control-label mb-10">Gender

													</label>
													<select class="form-select <?=validation_show_error('helpGender') ? "error" : "" ?>" id="helpGender" name="helpGender" data-placeholder="Choose a Category" tabindex="1">
														<option value="">Select Gender</option>
														<option value="1" <?= $helpMeChoose[0]->gender == 1 ? "selected" : "" ?>>Male</option>
														<option value="2" <?= $helpMeChoose[0]->gender == 2 ? "selected" : "" ?>>Female</option>

													</select>
												</div>
											</div>


										</div>
										<?php if ($helpMeChoose[0]->gender == 1) : ?>
											<div class="row help-me-chosse-options">
											
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpHairLoss" class="control-label mb-10">Hair Loss Type</label>
															<select class="form-select <?=validation_show_error('helpHairLoss') ? "error" : "" ?>" id="helpHairLoss" name="helpHairLoss" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Hair Loss Type</option>
																<option value="front" <?= $helpMeChoose[0]->hair_loss == "front" ? "selected" : "" ?>>Hair Thinning At The Front</option>
																<option value="crown" <?= $helpMeChoose[0]->hair_loss == "crown" ? "selected" : "" ?>>Hair Thinning At The Crown</option>
																<option value="top" <?= $helpMeChoose[0]->hair_loss == "top" ? "selected" : "" ?>>Hair Thinning At The Top</option>
																<option value="increase_top" <?= $helpMeChoose[0]->hair_loss == "increase_top" ? "selected" : "" ?>>Increased Hair Thinning At the Top</option>
																<option value="complete" <?= $helpMeChoose[0]->hair_loss == "complete" ? "selected" : "" ?>>Complete Hair Loss</option>

															</select>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpSweat" class="control-label mb-10">Amount of Sweat (1 to 5)</label>
															<select class="form-select <?=validation_show_error('helpSweat') ? "error" : "" ?>" id="helpSweat" name="helpSweat" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Amount of Sweat</option>
																<option value="1" <?= $helpMeChoose[0]->sweat == 1 ? "selected" : "" ?>>1</option>
																<option value="2" <?= $helpMeChoose[0]->sweat == 2 ? "selected" : "" ?>>2</option>
																<option value="3" <?= $helpMeChoose[0]->sweat == 3 ? "selected" : "" ?>>3</option>
																<option value="4" <?= $helpMeChoose[0]->sweat == 4 ? "selected" : "" ?>>4</option>
																<option value="5" <?= $helpMeChoose[0]->sweat == 5 ? "selected" : "" ?>>5</option>

															</select>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpWorkout" class="control-label mb-10">Workout Habit (1 to 5)</label>
															<select class="form-select <?=validation_show_error('helpWorkout') ? "error" : "" ?>" id="helpWorkout" name="helpWorkout" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Amount of Workout</option>
																<option value="1" <?= $helpMeChoose[0]->workout == 1 ? "selected" : "" ?>>1</option>
																<option value="2" <?= $helpMeChoose[0]->workout == 2 ? "selected" : "" ?>>2</option>
																<option value="3" <?= $helpMeChoose[0]->workout == 3 ? "selected" : "" ?>>3</option>
																<option value="4" <?= $helpMeChoose[0]->workout == 4 ? "selected" : "" ?>>4</option>
																<option value="5" <?= $helpMeChoose[0]->workout == 5 ? "selected" : "" ?>>5</option>

															</select>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpQuiff" class="control-label mb-10">Hair Style Quiff or Brush back</label>
															<select class="form-select <?=validation_show_error('helpQuiff') ? "error" : "" ?>" id="helpQuiff
															" name="helpQuiff" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Quiff or Brush back</option>
																<option value="1" <?= $helpMeChoose[0]->quiff == 1 ? "selected" : "" ?>>Yes</option>
																<option value="0" <?= $helpMeChoose[0]->quiff == 0 ? "selected" : "" ?>>NO</option>


															</select>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpHairColor" class="control-label mb-10">Hair Color</label>
															<select class="form-select <?=validation_show_error('helpHairColor') ? "error" : "" ?>" id="helpHairColor" name="helpHairColor" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Hair Color</option>
																<option value="dark" <?= $helpMeChoose[0]->hair_color == "dark" ? "selected" : "" ?>>Dark</option>
																<option value="brown" <?= $helpMeChoose[0]->hair_color == "brown" ? "selected" : "" ?>>Brown</option>
																<option value="blonde" <?= $helpMeChoose[0]->hair_color == "blonde" ? "selected" : "" ?>>Blonde</option>
																<option value="grey" <?= $helpMeChoose[0]->hair_color == "grey" ? "selected" : "" ?>>Grey</option>

															</select>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="form-group">
															<label for="helpHairDensity" class="control-label mb-10">Hair Density</label>
															<select class="form-select" id="helpHairDensity" name="helpHairDensity" data-placeholder="Choose a Category" tabindex="1" required>
																<option value="">Choose Hair Desity</option>
																<option value="60" <?= $helpMeChoose[0]->hair_density == 60 ? "selected" : "" ?>>Extra Light 60%</option>
																<option value="80" <?= $helpMeChoose[0]->hair_density == 80 ? "selected" : "" ?>>Light 80%</option>
																<option value="100" <?= $helpMeChoose[0]->hair_density == 100 ? "selected" : "" ?>>Medium Light 100%(Suits most people)</option>
																<option value="120" <?= $helpMeChoose[0]->hair_density == 120 ? "selected" : "" ?>>Medium Light 120%</option>
																<option value="140" <?= $helpMeChoose[0]->hair_density == 140 ? "selected" : "" ?>>Medium Heavy 140%</option>

															</select>
														</div>
													</div>
											</div>

										<?php else : ?>
											<div class="row help-me-chosse-options">
											<!-- ======================== Women Start ================  -->

											<div class="col-sm-4">
												<div class="form-group">
													<label for="helpHairWig" class="control-label mb-10">Hair wig Product</label>
													<select class="form-select <?=validation_show_error('helpHairWig') ? "error" : "" ?>" id="helpHairWig" name="helpHairWig" data-placeholder="Choose a Category" tabindex="1" required>
														<option value="">Choose Hair Wig Product</option>
														<option value="topper" <?= $helpMeChoose[0]->hair_wig == "topper" ? "selected" : "" ?>>Topper</option>
														<option value="fullCap" <?= $helpMeChoose[0]->hair_wig == "fullCap" ? "selected" : "" ?>>Full Cap</option>
														<option value="extensions" <?= $helpMeChoose[0]->hair_wig == "extensions" ? "selected" : "" ?>>Extensions</option>
														<option value="integration" <?= $helpMeChoose[0]->hair_wig == "integration" ? "selected" : "" ?>>Integration</option>


													</select>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label for="helpAttachmentMethod" class="control-label mb-10">Attachment method</label>
													<select class="form-select <?=validation_show_error('helpAttachmentMethod') ? "error" : "" ?>" id="helpAttachmentMethod" name="helpAttachmentMethod" data-placeholder="Choose a Category" tabindex="1" required>
														<option value="">Choose Attachment method</option>
														<option value="clip" <?= $helpMeChoose[0]->attachment_method == "clip" ? "selected" : "" ?>>Clips (Suitable for minimal hair thinning)</option>
														<option value="glue" <?= $helpMeChoose[0]->attachment_method == "glue" ? "selected" : "" ?>>Glue/Tape (Suitable for major hair thinning)</option>



													</select>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group">
													<label for="helpHairColor" class="control-label mb-10">Hair Color</label>
													<select class="form-select" id="helpHairColor" name="helpHairColor" data-placeholder="Choose a Category" tabindex="1" required>
														<option value="">Choose Hair Color</option>
														<option value="dark" <?= $helpMeChoose[0]->hair_color == "dark" ? "selected" : "" ?>>Dark</option>
														<option value="brown" <?= $helpMeChoose[0]->hair_color == "brown" ? "selected" : "" ?>>Brown</option>
														<option value="blonde" <?= $helpMeChoose[0]->hair_color == "blonde" ? "selected" : "" ?>>Blonde</option>
														<option value="reddish" <?= $helpMeChoose[0]->hair_color == "reddish" ? "selected" : "" ?>>Reddish</option>

													</select>
												</div>
											</div>
											<!-- ======================== Women End ================  -->
										</div>
										<?php endif; ?>

									

									<?php else : ?>

										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label for="helpGender"  id="gender-label" class="control-label mb-10">Gender</label>
													<select class="form-select <?=validation_show_error('helpGender') ? "error" : "" ?>" id="helpGender" name="helpGender" data-placeholder="Choose a Category" tabindex="1">
														<option value="">Select Gender</option>
														<option value="1">Male</option>
														<option value="2">Female</option>

													</select>
												</div>
											</div>
										</div>
										<div class="row help-me-chosse-options">
												
										</div>

									<?php endif; ?>

									<div class="form-actions">
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