<?php
$session = session();


// Registration Form 



$cmsAttributes = [
    'id' => 'UpdateForm',
    'autocompleete' => 'off'
];
$label = [
    'class' => 'from-label',
];
$inputHeading = [
    'type' => 'text',
    'id' => 'heading',
    'name' => 'heading',
    'placeholder' => 'Heading',
    'class' => 'form-control',
    'value' => $data[0]->heading

];
$inputSubHeading = [
    'type' => 'text',
    'id' => 'subHeading',
    'name' => 'subHeading',
    'placeholder' => 'Sub Heading',
    'class' => 'form-control',
    'value' => $data[0]->sub_heading


];
$inputDescription = [
    'id' => 'description',
    'name' => 'description',
    'placeholder' => 'Description',
    'class' => 'form-control',
    'value' => $data[0]->description

];
$inputImage1 = [

    'id' => 'image1',
    'name' => 'image1',
    'class' => 'form-control',

];
$inputImage2 = [
    'id' => 'image2',
    'name' => 'image2',
    'class' => 'form-control',

];


$inputYoutubeLink = [
    'type' => 'text',
    'id' => 'youtubeLink',
    'name' => 'youtubeLink',
    'class' => ' form-control ',
    'placeholder' => 'Enter Youtube Link',
    'value' => $data[0]->youtube_link

];
$inputBtnName = [
    'type' => 'text',
    'id' => 'btnName',
    'name' => 'btnName',
    'class' => ' form-control',
    'placeholder' => 'Enter Button Name',
    'value' => $data[0]->btn_name


];
$inputBtnLink = [
    'type' => 'text',
    'id' => 'btnLink',
    'name' => 'btnLink',
    'class' => 'form-control',
    'placeholder' => 'Enter Button Link',
    'value' => $data[0]->btn_link


];


?>


<div class="page-wrapper" style="min-height: 1239px;">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">form element</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#"><span>form</span></a></li>
                    <li class="active"><span>form-element</span></li>
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
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Edit Section</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <?= form_open_multipart('admin/edit-content', $cmsAttributes) ?>


                                  <input type="hidden" name="id" value="<?= base64_encode($data[0]->cms_id)?>">
                                  <input type="hidden" name="url" value="<?= current_url(true)?>">
                                <div class="form-outline mb-4">
                                    <?= form_label('Heading', 'heading', $label) ?>
                                    <?= form_input($inputHeading) ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <?= form_label('Sub heading', 'subHeading', $label) ?>
                                    <?= form_input($inputSubHeading) ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <?= form_label('Description', 'description', $label) ?>
                                    <?= form_textarea($inputDescription) ?>

                                </div>
                                <div class="form-outline mb-4 ">

                                    <?php

                                    if ($data[0]->image_1 != '' && !empty($data[0]->image_1)) :



                                    ?>

                                        <img src="<?= base_url('public/assets/uploads/media/') . $data[0]->image_1 ?>">

                                    <?php

                                    endif;
                                    ?>
                                    <?= form_label('Image 1', 'image1', $label) ?>
                                    <?= form_upload($inputImage1) ?>

                                </div>
                                <div class="form-group mb-4 ">

                                    <?php if ($data[0]->image_2 != '' && !empty($data[0]->image_2)) : ?>

                                        <img src="<?= base_url('public/assets/uploads/media/') . $data[0]->image_2 ?>">
                                    <?php

                                    endif;
                                    ?>

                                    <?= form_label('Image 2', 'image2', $label) ?>
                                    <?= form_upload($inputImage2) ?>

                                </div>

                                <div class="form-group">
                                    <?= form_label('Youtube Link', 'youtubeLink', $label) ?>
                                    <?= form_input($inputYoutubeLink) ?>


                                </div>
                                <div class="form-group">
                                    <?= form_label('Button Text', 'btnText', $label) ?>
                                    <?= form_input($inputBtnName) ?>


                                </div>
                                <div class="form-group">
                                    <?= form_label('Button Url', 'btnUrl', $label) ?>
                                    <?= form_input($inputBtnLink) ?>


                                </div>
                                <div class="col-4">
                                    <select class="form-select" name="active">
                                        <option value="1" <?=$data[0]->is_active == 1 ? "Selected": ""?>>Active</option>
                                        <option value="0" <?=$data[0]->is_active == 0 ? "Selected": ""?>>INACTIVE</option>
                                    </select>
                                </div>

                                <button type="submit" id="registration" class="btn btn-success btn-anim w-100 mt-4">update
                                </button>

                                <?= form_close() ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       










    </div>



</div>