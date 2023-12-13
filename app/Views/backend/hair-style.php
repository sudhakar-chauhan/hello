<?php

$currentUrl = current_url(true);
$request = service('request');
$session = session();

?>
<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Hair Style</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li><a href="#">Hair Style</a></li>

                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->

        <div class="row">
            <?php
            if ($session->has('message') && $session->get('message') != '') {
                echo $session->getFlashdata('message');
            }
            ?>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary mb-3" type="btn" id="addNewHairStyle"> Add New</button>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Hair Style</h6>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="fitler-wrapper d-flex justify-content-between p-3">
                        <form action="#bulkEdit" method="POST" class="row g-3 ">
                            <div class="col-auto">
                                <label for="staticEmail2" class="visually-hidden">Bulk Edit</label>
                                <select class="form-select" id="bulkSelect" aria-label="Default" name="bulk">
                          
                                    <option value="delete">Delete</option>

                                </select>
                            </div>


                            <div class="col-auto">
                                <button type="button" id="bulkApplyHairStyle" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/hair-styles/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>
                            </form>
                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/hair-styles/filter') ?>" method="GET" class="row g-3">
                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Color Gender</label>
                                    <select class="form-select" aria-label="Default" name="gender">
                                        <option value="all" <?= $request->getGet('gender') == "all" ? 'selected' : '' ?>>Select Gender</option>
                                        <option value="hairStyleMen" <?= $request->getGet('gender') == "hairStyleMen" ? 'selected' : '' ?>>Men</option>
                                        <option value="hairStyleWomen" <?= $request->getGet('gender') == "hairStyleWomen" ? 'selected' : '' ?>>Women</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Filter</button>
                                </div>
                            </form>


                        </div>
                    </div>


                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <div class="product-data d-flex justify-content-between align-items-center g-4 mb-2">
                                        <a class="text-success ms-4" href="<?= base_url('admin/hair-styles') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Hair Style Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Gender</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Created At</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Hair Style Name</th>
                                                <th rowspan="1" colspan="1">Gender</th>
                                                <th rowspan="1" colspan="1">Created At</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if ($data) :
                                                foreach ($data as $row) :?>
                                                    <tr role="row" class="even" id="ct<?= $row->attribute_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->attribute_id ?>">
                                                        </td>
                                                        <td><span class="hair-name"><?= $row->attribute_name ?></span>

                                                            <div class=" edit-wrapper-all edit-wrapper-hair-style d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->attribute_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->attribute_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="<?= $row->attribute_id ?>">Delete</button>
                                                            </div>

                                                        </td>
                                                        <td class="attribute-category"><?= $row->attribute_categorie == 'hairStyleMen' ? "Men" : "Women" ?></td>
                                                        <td class="created-at"><?= date('d-M-Y', strtotime($row->created_at)) ?></td>


                                                    </tr>
                                            <?php endforeach;
                                            endif;
                                            ?>

                                        </tbody>
                                    </table>
                                    <div class="pagination-wrapper">
                                        <?php if ($pager_links) {
                                            echo $pager_links;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    