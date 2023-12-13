<?php

$session = session();
$currentUrl = current_url(true);


$request = \Config\Services::request();
?>
<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark"></h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#"><span>table</span></a></li>
                    <li class="active"><span> Footer</span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->
        <?php

        if ($session->has('message') && $session->get('message') != '') {
            echo $session->getFlashdata('message');
        }


        ?>
        <!-- Row -->
        <div class="row">

            <h2 class="mb-3">Parent Menu Link</h2>

            <?php if ($link) : ?>
                <form action="<?= base_url('admin/update-header') ?>" method="post" class="form-group">

                    <div class="d-none">
                        <input type="text" name="location" value="link">
                        <input type="text" name="id" value="<?= $link[0]->header_id ?>">
                        <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                    </div>
                    <?= csrf_field() ?>

                    <div class="row align-items-center">
                        <div class="mb-3 col-4">
                            <label for="url" class="form-label">Title</label>
                            <input type="text" maxlength="100" class="form-control" id="title" value="<?= $link[0]->title ?>" placeholder="" name="title">
                        </div>
                        <div class="mb-3 col-6">
                            <label for="url" class="form-label">Url</label>
                            <input type="text" maxlength="100" class="form-control" id="url" value="<?= $link[0]->slug ?>" placeholder="" name="url">
                        </div>
                        <div class="mb-3 col-2">
                            <label for="url" class="form-label">Active</label>
                            <select class="form-select" name="active" aria-label="Default select example">

                                <option value="1" <?= $link[0]->is_active == 1 ? "selected" : "" ?>>Active</option>
                                <option value="0" <?= $link[0]->is_active == 0 ? "selected" : "" ?>>In Active</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Update</button>
                    </div>
                </form>

                <hr>

            <?php endif; ?>


            <?php if ($list) : foreach ($list as $row) :

            ?>



                    <div class="col-md-12">
                        <div class="panel panel-default accordion-custom">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading  d-flex align-items-center <?= $request->getGet('section') ==  $row->header_id ? "activestate" : "" ?>" role="tab" id="">
                                                <a role="button" data-toggle="collapse" href="#<?= $row->header_id ?>" aria-expanded="true" class="accordion-heading collapsed"><?= $row->title ?></a>
                                                <i class="fa fa-chevron-down"></i>
                                                <i class="fa fa-chevron-up"></i>
                                            </div>
                                            <div id="<?= $row->header_id ?>" class="panel-collapse collapse <?= $request->getGet('section') == $row->header_id ? "in" : "" ?>" role="tabpanel" aria-expanded="true">
                                                <div class="panel-body pa-15">
                                                    <form action="<?= base_url('admin/update-header') ?>" method="post" class="form-group">

                                                        <div class="d-none">
                                                            <input type="text" name="location" value="sublink">
                                                            <input type="text" name="id" value="<?= $row->header_id ?>">
                                                            <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                        </div>
                                                        <?= csrf_field() ?>

                                                        <div class="row align-items-center">
                                                            <div class="mb-3 col-4">
                                                                <label for="url" class="form-label">Title</label>
                                                                <input type="text" maxlength="100" class="form-control" id="title" value="<?= $row->title ?>" placeholder="" name="title">
                                                            </div>
                                                            <div class="mb-3 col-6">
                                                                <label for="url" class="form-label">Url</label>
                                                                <input type="text" maxlength="100" class="form-control" id="url" value="<?= $row->slug ?>" placeholder="" name="url">
                                                            </div>
                                                            <div class="mb-3 col-2">
                                                                <label for="url" class="form-label">Active</label>
                                                                <select class="form-select" name="active" aria-label="Default select example">

                                                                    <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                    <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-auto">
                                                            <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                        </div>
                                                    </form>



                                                    <?php if ($row->header_id == 13 || $row->header_id == 16 || $row->header_id == 19 || $row->header_id == 20) : ?>


                                                        <?php if ($sublink) : foreach ($sublink as $rowSub) :

                                                                if ($rowSub->parent_id == $row->header_id) :

                                                        ?>

                                                                    <hr>
                                                                    <h3>Sub Category</h3>
                                                                    <form action="<?= base_url('admin/update-header') ?>" method="post" class="form-group">

                                                                        <div class="d-none">
                                                                            <input type="text" name="location" value="sublink">
                                                                            <input type="text" name="id" value="<?= $rowSub->header_id ?>">
                                                                            <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                                        </div>
                                                                        <?= csrf_field() ?>

                                                                        <div class="row align-items-center">
                                                                            <div class="mb-3 col-4">
                                                                                <label for="url" class="form-label">Title</label>
                                                                                <input type="text" maxlength="100" class="form-control" id="title" value="<?= $rowSub->title ?>" placeholder="" name="title">
                                                                            </div>
                                                                            <div class="mb-3 col-6">
                                                                                <label for="url" class="form-label">Url</label>
                                                                                <input type="text" maxlength="100" class="form-control" id="url" value="<?= $rowSub->slug ?>" placeholder="" name="url">
                                                                            </div>
                                                                            <div class="mb-3 col-2">
                                                                                <label for="url" class="form-label">Active</label>
                                                                                <select class="form-select" name="active" aria-label="Default select example">

                                                                                    <option value="1" <?= $rowSub->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                                    <option value="0" <?= $rowSub->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-auto">
                                                                            <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                                        </div>
                                                                    </form>
                                                                    <h3 class="mb-3">Product List</h3>


                                                                    <form action="<?= base_url('admin/update-header-product-list') ?>" method="post" class="form-group">

                                                                        <div class="d-none">
                                                                            <input type="text" name="headerId" value="<?= $row->header_id ?>">
                                                                            <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                                        </div>
                                                                        <?= csrf_field() ?>

                                                                        <?php if ($headerProduct) : foreach ($headerProduct as $hederProduct) :
                                                                                if ($rowSub->header_id == $hederProduct->header_id) :



                                                                        ?>
                                                                                    <div class="d-none">
                                                                                        <input type="text" name="headerProduct[]" value="<?= $hederProduct->id ?>">
                                                                                    </div>
                                                                                    <div class="row align-items-center">

                                                                                        <div class="mb-3 col-6">
                                                                                            <label for="productId" class="form-label">Product Name</label>
                                                                                            <select class="form-select" aria-label="Default select example" name="product[]">

                                                                                                <?php foreach ($allProduct as $productData) : ?>
                                                                                                    <option value="<?= $productData->product_id ?>" <?= $productData->product_id == $hederProduct->product_id ? "selected" : "" ?>>
                                                                                                        <?= $productData->product_name ?>
                                                                                                    </option>
                                                                                                <?php endforeach; ?>

                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3 col-2">
                                                                                            <label for="url" class="form-label">Active</label>
                                                                                            <select class="form-select" name="active[]" aria-label="Default select example">

                                                                                                <option value="1" <?= $hederProduct->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                                                <option value="0" <?= $hederProduct->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                                            </select>
                                                                                        </div>
                                                                                    </div>




                                                                        <?php endif;
                                                                            endforeach;
                                                                        endif; ?>

                                                                        <?php if ($headerProduct) : ?>


                                                                            <div class="col-auto">
                                                                                <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                                            </div>

                                                                        <?php endif; ?>




                                                                    </form>

                                                        <?php endif;
                                                            endforeach;
                                                        endif; ?>
                                                    <?php elseif (
                                                        $row->header_id == 14 || $row->header_id == 54 ||
                                                        $row->header_id == 55 || $row->header_id == 56 || $row->header_id == 57
                                                    ) : ?>

                                                        <!-- Update Product to  Header List  -->
                                                        <h3 class="mb-3">Image</h3>


                                                        <form action="<?= base_url('admin/update-header') ?>" method="post" class="form-group" enctype="multipart/form-data">
                                                            <div class="d-none">
                                                                <input type="text" name="location" value="sublink">
                                                                <input type="text" name="id" value="<?= $row->header_id ?>">
                                                                <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                            </div>
                                                            <?= csrf_field() ?>
                                                            <div class="row align-items-center d-none ">
                                                                <div class="mb-3 col-4">
                                                                    <label for="url" class="form-label">Title</label>
                                                                    <input type="text" maxlength="100" class="form-control" id="title" value="<?= $row->title ?>" placeholder="" name="title">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="url" class="form-label">Url</label>
                                                                    <input type="text" maxlength="100" class="form-control" id="url" value="<?= $row->slug ?>" placeholder="" name="url">
                                                                </div>
                                                                <div class="mb-3 col-2">
                                                                    <label for="url" class="form-label">Active</label>
                                                                    <select class="form-select" name="active" aria-label="Default select example">

                                                                        <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                        <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 mb-3">
                                                                <div class="img-upload-wrap">
                                                                    <input type="text" name="oldImage" value="<?= $row->input_name ?>" class="d-none">
                                                                    <img class="img-responsive mb-2 <?= $row->input_name != '' ? '' : 'd-none' ?>" id="imagePreview" src="<?= base_url('public/assets/uploads/media/' . $row->input_name) ?>" alt="upload_img" width="200" height="200">
                                                                </div>
                                                                <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload Image</span>

                                                                    <input type="file" id="featureImage" class="upload <?= validation_show_error('featureImage') ? "error" : "" ?>" name="featureImage" accept="image/*">
                                                                </div>
                                                            </div>

                                                            <div class="col-auto">
                                                                <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                            </div>






                                                        </form>



                                                    <?php elseif ($row->header_id == 50 || $row->header_id == 51 || $row->header_id == 52 || $row->header_id == 53) : 
                                                        
                                                          if($sublink): ?>

                                                            <h3 class="mb-3">Sub Link</h3>
                                                            <form action="<?= base_url('admin/update-header-bulk') ?>" method="post" class="form-group" enctype="multipart/form-data">
                                                            <?php  foreach($sublink as $helpSubLink):
                                                            if($row->header_id == $helpSubLink->parent_id):
                                                        
                                                            ?>
                                                            <div class="d-none">
                                                                <input type="text" name="location" value="sublink">
                                                                <input type="text" name="id[]" value="<?= $helpSubLink->header_id ?>">
                                                                <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                            </div>
                                                            <?= csrf_field() ?>
                                                            <div class="row align-items-center">
                                                                <div class="mb-3 col-4">
                                                                    <label for="url" class="form-label">Title</label>
                                                                    <input type="text" maxlength="100" class="form-control" id="title" value="<?= $helpSubLink->title ?>" placeholder="" name="title[]">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="url" class="form-label">Url</label>
                                                                    <input type="text" maxlength="100" class="form-control" id="url" value="<?= $helpSubLink->slug ?>" placeholder="" name="url[]">
                                                                </div>
                                                                <div class="mb-3 col-2">
                                                                    <label for="url" class="form-label">Active</label>
                                                                    <select class="form-select" name="active[]" aria-label="Default select example">

                                                                        <option value="1" <?= $helpSubLink->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                        <option value="0" <?= $helpSubLink->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                   <?php  endif; endforeach; ?>
                                                  
                                                   <div class="col-auto">
                                                                <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                            </div>

                                                            </form>
                                                   <?php endif; ?>
                                                        
                                                    


                                                    <?php else : ?>
                                                        <!-- Update Product to  Header List  -->
                                                        <h3 class="mb-3">Product List</h3>


                                                        <form action="<?= base_url('admin/update-header-product-list') ?>" method="post" class="form-group">

                                                            <div class="d-none">
                                                                <input type="text" name="headerId" value="<?= $row->header_id ?>">
                                                                <input type="text" name="currentUrl" value="<?= $currentUrl->getSegment(4) ?>">
                                                            </div>
                                                            <?= csrf_field() ?>

                                                            <?php if ($headerProduct) : foreach ($headerProduct as $hederProduct) :
                                                                    if ($row->header_id == $hederProduct->header_id) :



                                                            ?>
                                                                        <div class="d-none">
                                                                            <input type="text" name="headerProduct[]" value="<?= $hederProduct->id ?>">
                                                                        </div>
                                                                        <div class="row align-items-center">

                                                                            <div class="mb-3 col-6">
                                                                                <label for="productId" class="form-label">Product Name</label>
                                                                                <select class="form-select" aria-label="Default select example" name="product[]">

                                                                                    <?php foreach ($allProduct as $productData) : ?>
                                                                                        <option value="<?= $productData->product_id ?>" <?= $productData->product_id == $hederProduct->product_id ? "selected" : "" ?>>
                                                                                            <?= $productData->product_name ?>
                                                                                        </option>
                                                                                    <?php endforeach; ?>

                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3 col-2">
                                                                                <label for="url" class="form-label">Active</label>
                                                                                <select class="form-select" name="active[]" aria-label="Default select example">

                                                                                    <option value="1" <?= $hederProduct->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                                    <option value="0" <?= $hederProduct->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>




                                                            <?php endif;
                                                                endforeach;
                                                            endif; ?>

                                                            <?php if ($headerProduct) : ?>


                                                                <div class="col-auto">
                                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                                </div>

                                                            <?php endif; ?>




                                                        </form>

                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            <?php endforeach;
            endif; ?>




        </div>
        <!-- /Row -->

    </div>



</div>
