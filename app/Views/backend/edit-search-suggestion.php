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
                    <li class="active"><span> Search Quick Connect</span></li>
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
         
            <!--  Column 2 -->
            <div class="col-md-12">
                <div class="panel panel-default accordion-custom">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="panel-group accordion-struct" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading  d-flex align-items-center activestate" role="tab" id="">
                                        <a role="button" data-toggle="collapse" href="#col-2" aria-expanded="true" class="accordion-heading collapsed">Link</a>
                                        <i class="fa fa-chevron-down"></i>
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                    <div id="col-2" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true">
                                        <div class="panel-body pa-15">
                                            <form action="<?= base_url('admin/update-search-quick-connect') ?>" method="post" class="form-group" enctype="multipart/form-data">

                                            
                                                <?= csrf_field() ?>

                                                <?php if($searchQuickLinks): foreach ($searchQuickLinks as $row) : ?>

                                                  
                                                    <div class="d-none">
                                                        <input name="id[]" value="<?= $row->footer_id?>">
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-4">
                                                            <label for="sublinks" class="form-label">Title</label>
                                                            <input type="text" maxlength="50" class="form-control" value="<?= $row->title ?>" id="sublinks" placeholder="" name="title[]">
                                                        </div>
                                                        <div class="mb-3 col-6">
                                                            <label for="url" class="form-label">Url</label>
                                                            <input type="text" maxlength="100" class="form-control" value="<?= $row->slug ?>" id="url" placeholder="" name="url[]">
                                                        </div>
                                                        <div class="mb-3 col-2">
                                                            <label for="url" class="form-label">Active</label>
                                                            <select class="form-select" name="active[]" aria-label="Default select example">

                                                                <option value="1" <?= $row->is_active == 1 ? "selected" : "" ?>>Active</option>
                                                                <option value="0" <?= $row->is_active == 0 ? "selected" : "" ?>>In Active</option>

                                                            </select>
                                                        </div>
                                                    </div>


                                                <?php


                                                endforeach;
                                            endif;
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

    

</div>
<!-- /Main Content -->