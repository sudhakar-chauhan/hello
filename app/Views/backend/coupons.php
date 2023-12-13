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
                <h5 class="txt-dark">Coupons</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li><a href="#">Coupons</a></li>

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
                <button class="btn btn-primary mb-3" type="btn" id="addNewCoupon"> Add New</button>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Coupons</h6>
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
                                <button type="button" id="bulkApplyCoupon" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/coupons/search') ?>" method="GET" class="row g-3 justify-content-end">

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
                                        <a class="text-success ms-4" href="<?= base_url('admin/coupons') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Coupon Code</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Discount Value</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Max Discount</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Start Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">End Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Active</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Coupon Code</th>
                                                <th rowspan="1" colspan="1">Discount Value</th>
                                                <th rowspan="1" colspan="1">Max Discount</th>
                                                <th rowspan="1" colspan="1">Start Date</th>
                                                <th rowspan="1" colspan="1">End Date</th>
                                                <th rowspan="1" colspan="1">Active</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr class="d-none">
                                                <td class="quick-edit-wrapper" colspan="5">
                                                    <div class="">
                                                        <form action="http://localhost/richmane/admin/product/edit" id="editBulkForm" autocompleete="off" class="row px-3" method="post" accept-charset="utf-8">
                                                            <div id="errorWrapper"></div>

                                                            <div class="col-12 mb-3">
                                                                <h5 class="">Bulk Edit Products</h5>
                                                                <div class="product-names-wrapper border border-black rounded-2 p-3">
                                                                    <p>First Product</p>
                                                                    <p>Secound Product</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="productCategory" class="from-label">Product Category</label>
                                                                <select name="productCategory" class="form-select" id="productCategory">
                                                                    <option value="" selected="selected"></option>
                                                                    <option value="">MEN</option>
                                                                    <option value=""> Women</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="price" class="from-label">Price</label>
                                                                <select name="salePrice" class="form-select mb-2" id="regularPrice">
                                                                    <option value="" selected="selected">No Change</option>
                                                                    <option value="1">Chage to:</option>
                                                                    <option value="2">Increase existing price by (fixed amount ):</option>
                                                                    <option value="3">Increase existing price by (fixed %):</option>
                                                                    <option value="4"> Decrease existing price by (fixed amount):</option>
                                                                    <option value="5"> Decrease existing price by (fixed %):</option>

                                                                </select>

                                                                <input type="text" class="form-control" name="price" value="" id="price" placeholder="price*" class="form-control" required>

                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="salePrice" class="from-label">Sale Price</label>
                                                                <select name="salePrice" class="form-select mb-2" id="salePrice">
                                                                    <option value="" selected="selected">No Change</option>
                                                                    <option value="1">Chage to:</option>
                                                                    <option value="2">Increase existing price by (fixed amount ):</option>
                                                                    <option value="3">Increase existing price by (fixed %):</option>
                                                                    <option value="4"> Decrease existing price by (fixed amount):</option>
                                                                    <option value="5"> Decrease existing price by (fixed %):</option>

                                                                </select>
                                                                <input type="text" name="salePrice" value="" id="salePrice" placeholder="sale Price" class="form-control">
                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="featureProduct" class="from-label">Feature Product</label>
                                                                <select name="featureProduct" class="form-select" id="featured">
                                                                    <option value="">Featue Product</option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="0">No</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="stockStatus" class="from-label">Stock Status</label>
                                                                <select name="stockStatus" class="form-select" id="stockStatus">
                                                                    <option value="">Stock Status</option>
                                                                    <option value="1">In Stock</option>
                                                                    <option value="0">Out of Stock</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-outline mb-4 col-4">
                                                                <label for="isVisible" class="from-label">Visible</label>
                                                                <select name="isVisible" class="form-select" id="isVisible">
                                                                    <option value="">Slect Visible</option>
                                                                    <option value="1">Visible</option>
                                                                    <option value="0">Not Visible</option>

                                                                </select>
                                                            </div>
                                                            <div class="button-wrappper">
                                                                <button type="button" id="update" class="btn btn-primary mb-3 me-3" data-id="">Update</button>
                                                                <button type="button" id="cancel" class="btn text-black border border-black border-2 mb-3">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php if ($coupons) :
                                                foreach ($coupons as $row) :

                                            ?>
                                                    <tr role="row" class="even" id="ct<?= $row->coupon_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->coupon_id ?>">
                                                        </td>
                                                        <td><span class="coupon-code"><?= $row->coupon_code ?></span>

                                                            <div class=" edit-wrapper-all edit-wrapper-coupon d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->coupon_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->coupon_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="<?= $row->coupon_id ?>">Delete</button>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 discount_value"><?= $row->discount_value ?><?= $row->discount_type == 1 ? " %" : " $ Fixed Price" ?></td>
                                                        <td class="max-discount"><?= $row->max_discount ?></td>
                                                        <td class="start-date"><?= date('d-M-Y', strtotime($row->start_date)) ?></td>
                                                        <td class="end-date"><?= date('d-M-Y', strtotime($row->end_date)) ?></td>
                                                        <td class="active"><?= $row->is_active == 0 ? "In Active" : "Active" ?></td>

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


