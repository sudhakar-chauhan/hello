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
                <h5 class="txt-dark">Categories</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li><a href="#">Categories</a></li>

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
                <button class="btn btn-primary mb-3" type="btn" id="addNewCategory" > Add New</button>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Categories</h6>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>

                    <div class="fitler-wrapper d-flex justify-content-between p-3">
                        <form action="#bulkEdit" method="POST" class="row g-3 ">
                            <div class="col-auto">
                                <label for="staticEmail2" class="visually-hidden">Bulk Edit</label>
                                <select class="form-select" id="bulkSelect" aria-label="Default" name="bulk">
                                    <option selected>Bulk Edit</option>
                                    <option value="delete">Delete</option>

                                </select>
                            </div>


                            <div class="col-auto">
                                <button type="button" id="bulkApplyCategory" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/categories/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>


                        </div>
                    </div>


                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <div class="product-data d-flex justify-content-between align-items-center g-4 mb-2">
                                        <a class="text-success ms-4" href="<?= base_url('admin/categories') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Parent Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Count</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Name</th>
                                                <th rowspan="1" colspan="1">Parent Category</th>
                                                <th rowspan="1" colspan="1">Count</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                         
                                            <?php if ($categories) :
                                                foreach ($categories as $row) :

                                            ?>



                                                    <tr role="row" class="even" id="ct<?= $row->category_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->category_id ?>">
                                                        </td>
                                                        <td><span class="category-name"><?= $row->child_category_name ?></span>

                                                            <div class=" edit-wrapper-all edit-wrapper-categories d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->category_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->category_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="<?= $row->category_id ?>">Delete</button>
                                                                <a href="<?=base_url('shop/'.str_replace(" ", "-",strtolower($row->child_category_name)))?>" type="button" class="btn text-black btnView">View</a>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 parent-category"><?= $row->parent_category_name?></td>
                                                        <td class="count"><a href="<?=base_url('shop/'.str_replace(" ", "-",strtolower($row->child_category_name)))?>">  <?= $row->product_count?></a></td>

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

