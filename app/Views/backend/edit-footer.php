<?php

$session = session();
$currentUrl = current_url();


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

      if($session->has('message') && $session->get('message') != ''){
    echo $session->getFlashdata('message');
    
    
}


?>
        <!-- Row -->
        <div class="row">
            <!--  Column 1 -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading <?= $request->getGet('section') == "col-1" ? "activestate" : ""?>  d-flex align-items-center" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#col-1" aria-expanded="true" class="accordion-heading collapsed">Footer Column 1 </a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="col-1" class="panel-collapse collapse <?= $request->getGet('section') == "col-1" ? "in" : ""?> " role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group" enctype="multipart/form-data">
                                                <div class="col-12 mb-3">

                                                    <div class="d-none">
                                                        <input type="text" name="location" value="col-1">
                                                    
                                                    </div>
                                                    <?= csrf_field() ?>
                                                    <div class="img-upload-wrap">
                                                        <img class="img-responsive mb-2 <?= $col1[1]->slug != '' ? "" : "d-none" ?>" id="imagePreview" src="<?= base_url('public/assets/uploads/logo/') . $col1[1]->slug ?>" alt="upload_img" width="200" height="200">
                                                    </div>
                                                    <div class="fileupload btn btn-info btn-anim"><i class="fa fa-upload"></i><span class="btn-text">Upload
                                                            Logo</span>

                                                        <input type="file" id="footerlogo" class="upload" name="footerlogo" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Add About Webiste" id="about" name="description" style="height: 100px"><?= $col1[0]->description ?></textarea>
                                                    <label for="about">About</label>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email
                                                        address</label>
                                                    <input type="email" maxlength="50" value="<?= $col1[2]->title ?>" class="form-control" id="email" placeholder="" name="email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" maxlength="15" value="<?= $col1[3]->title ?>" class="form-control" id="phone" placeholder="" name="phone">
                                                </div>

                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  Column 2 -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading  d-flex align-items-center <?= $request->getGet('section') == "col-2" ? "activestate" : ""?>" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#col-2" aria-expanded="true" class="accordion-heading collapsed">Footer Column 2</a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="col-2" class="panel-collapse collapse <?= $request->getGet('section') == "col-2" ? "in" : ""?>" role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group" enctype="multipart/form-data">

                                                <div class="d-none">
                                                    <input type="text" name="location" value="col-2">
                                                
                                                </div>
                                                <?= csrf_field() ?>
                                                <div class="mb-3">
                                                    <label for="heading" class="form-label">Main Heading</label>
                                                    <input type="text" maxlength="50" class="form-control" value="<?= $col2[0]->title ?>" id="heading" placeholder="" name="heading">
               
                                                </div>
                                                <h3 class="mb-3 fw-bold">Sub Links</h3>

                                                <?php foreach ($col2 as $row) :

                                                    if ($row->input_name == 'heading') :

                                                        continue;

                                                    endif; ?>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label for="sublinks" class="form-label">Title</label>
                                                            <input type="text" maxlength="50" class="form-control" value="<?= $row->title ?>" id="sublinks" placeholder="" name="sublinks<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-6">
                                                            <label for="url" class="form-label">Url</label>
                                                            <input type="text" maxlength="100" class="form-control" value="<?= $row->slug ?>" id="url" placeholder="" name="url<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-2">
                                                            <label for="url" class="form-label">Active</label>
                                                            <select class="form-select" name="active<?= $row->footer_id ?>" aria-label="Default select example">

                                                                <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                <?php


                                                endforeach;



                                                ?>


                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  Column 3 -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading  d-flex align-items-center <?= $request->getGet('section') == "col-3" ? "activestate" : ""?>" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#col-3" aria-expanded="true" class="accordion-heading collapsed">Footer Column 3</a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="col-3" class="panel-collapse collapse <?= $request->getGet('section') == "col-3" ? "in" : ""?>" role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group">

                                                <div class="d-none">
                                                    <input type="text" name="location" value="col-3">
                                                </div>
                                                <?= csrf_field() ?>
                                                <div class="mb-3">
                                                    <label for="heading" class="form-label">Main Heading</label>
                                                    <input type="text" maxlength="50" class="form-control" id="heading" value="<?= $col3[0]->title ?>" placeholder="" name="heading">
                                                </div>
                                                <h3 class="mb-3 fw-bold">Sub Links</h3>
                                                <?php foreach ($col3 as $row) :

                                                    if ($row->input_name == 'heading') :

                                                        continue;

                                                    endif; ?>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label for="sublinks" class="form-label">Title</label>
                                                            <input type="text" maxlength="50" class="form-control" value="<?= $row->title ?>" id="sublinks" placeholder="" name="sublinks<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-6">
                                                            <label for="url" class="form-label">Url</label>
                                                            <input type="text" maxlength="100" class="form-control" value="<?= $row->slug ?>" id="url" placeholder="" name="url<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-2">
                                                            <label for="url" class="form-label">Active</label>
                                                            <select class="form-select" name="active<?= $row->footer_id ?>" aria-label="Default select example">

                                                                <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                <?php


                                                endforeach;

                                                ?>



                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--  Column 4 -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading  d-flex align-items-center <?= $request->getGet('section') == "col-4" ? "activestate" : ""?>" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#col-4" aria-expanded="true" class="accordion-heading collapsed">Footer Column 4</a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="col-4" class="panel-collapse collapse <?= $request->getGet('section') == "col-4" ? "in" : ""?>" role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group">

                                                <div class="d-none">
                                                    <input type="text" name="location" value="col-4">
                                                </div>
                                                <?= csrf_field() ?>
                                                <div class="mb-3">
                                                    <label for="heading" class="form-label">Main Heading</label>
                                                    <input type="text" maxlength="50" class="form-control" id="heading" value="<?= $col4[0]->title ?>" placeholder="" name="heading">
                                                </div>
                                                <h3 class="mb-3 fw-bold">Sub Links</h3>
                                                <?php foreach ($col4 as $row) :

                                                    if ($row->input_name == 'heading') :

                                                        continue;

                                                    endif; ?>

                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label for="sublinks" class="form-label">Title</label>
                                                            <input type="text" maxlength="50" class="form-control" value="<?= $row->title ?>" id="sublinks" placeholder="" name="sublinks<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-6">
                                                            <label for="url" class="form-label">Url</label>
                                                            <input type="text" maxlength="100" class="form-control" value="<?= $row->slug ?>" id="url" placeholder="" name="url<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-2">
                                                            <label for="url" class="form-label">Active</label>
                                                            <select class="form-select" name="active<?= $row->footer_id ?>" aria-label="Default select example">

                                                                <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                <?php


                                                endforeach;

                                                ?>



                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  social-icons -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading  d-flex align-items-center <?= $request->getGet('section') == "social-icons" ? "activestate" : ""?>" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#social-icons" aria-expanded="true" class="accordion-heading collapsed">Social Icons</a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="social-icons" class="panel-collapse collapse <?= $request->getGet('section') == "social-icons" ? "in" : ""?>" role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group">

                                                <div class="d-none">
                                                    <input type="text" name="location" value="social-icons">
                                                </div>
                                                <?= csrf_field() ?>


                                                <?php foreach ($socialLinks as $row) : ?>


                                                    <div class="row align-items-center">
                                                        <div class="mb-3 col-3">
                                                            <h6><?= $row->title?></h6>
                                                        </div>
                                                        <div class="mb-3 col-7">
                                                            <label for="url" class="form-label">Url</label>
                                                            <input type="text" maxlength="100" class="form-control" id="url" value="<?= $row->slug?>" placeholder="" name="url<?= $row->footer_id ?>">
                                                        </div>
                                                        <div class="mb-3 col-2">
                                                            <label for="url" class="form-label">Active</label>
                                                            <select class="form-select" name="active<?= $row->footer_id ?>" aria-label="Default select example">

                                                                <option value="1" <?= $row->is_active == 1 ? "selected" : ""?>>Active</option>
                                                                <option value="0" <?= $row->is_active == 0 ? "selected" : ""?>>In Active</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                       


                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <!--  newsletter -->
    <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading <?= $request->getGet('section') == "newsletter" ? "activestate" : ""?>  d-flex align-items-center" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#newsletter" aria-expanded="true" class="accordion-heading collapsed">newsletter </a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="newsletter" class="panel-collapse collapse <?= $request->getGet('section') == "newsletter" ? "in" : ""?> " role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-footer') ?>" method="post" class="form-group" enctype="multipart/form-data">
                                                <div class="col-12 mb-3">

                                                    <div class="d-none">
                                                        <input type="text" name="location" value="newsletter">
                                                    
                                                    </div>
                                                    <?= csrf_field() ?>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Title</label>
                                                    <input type="textt" maxlength="50" value="<?= $newsletter[0]->title ?>" class="form-control" id="title" placeholder="" name="title">
                                                </div>
                                               
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Sub Title</label>
                                                    <input type="text" maxlength="100" value="<?= $newsletter[0]->description ?>" class="form-control" id="subTitle" placeholder="" name="subTitle">
                                                </div>

                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                                                </div>
                                            </form>





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

    </div>



</div>
<!-- /Main Content -->