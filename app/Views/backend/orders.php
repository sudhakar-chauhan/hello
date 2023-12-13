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
                <h5 class="txt-dark">Orders</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>

                    <li class="active"><span>Orders</span></li>
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
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Orders</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="fitler-wrapper d-flex justify-content-between p-3">
                        <form action="#bulkEdit" method="POST" class="row g-3 ">
                            <div class="col-auto">
                                <label for="staticEmail2" class="visually-hidden">Bulk Edit</label>
                                <select class="form-select" id="bulkSelect" aria-label="Default" name="bulk">
                                    <option selected>Bulk Edit</option>
                                    <option value="1">Change Status to Processing</option>
                                    <option value="2">Change Status to Shipped</option>
                                    <option value="3">Change Status to Delivered</option>
                                    <option value="4">Change Status to Canceled</option>
                                    <option value="5">Change Status to On Hold</option>

                                </select>
                            </div>


                            <div class="col-auto">
                                <button type="button" id="bulkApplyOrder" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/orders/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>

                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/orders/filter') ?>" method="GET" class="row g-3">


                                <div class="col-auto">
                                    <label for="orderStatus" class="visually-hidden">Order Status</label>
                                    <select class="form-select" id="orderStatus" aria-label="Default" name="order_status">
                                        <option value="" selected>Select a Order Status</option>
                                      
                                                <option value="0">Pending(<?= $pending?>)</option>
                                                <option value="1">Processing(<?= $processing?>)</option>
                                                <option value="2">Shipped(<?= $shipped?>)</option>
                                                <option value="3">Delivered(<?= $deliverd?>)</option>
                                                <option value="4">Canceled(<?= $canceled?>)</option>
                                                <option value="5">On Hold(<?= $onHold?>)</option>
                                                <option value="6">Refunded(<?= $refunded?>)</option>
                                                <option value="8">Payment Failed(<?= $paymentFailed?>)</option>
                                     
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
                                        <a class="text-success ms-4" href="<?= base_url('admin/orders') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>

                          <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Order</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending" style="width: 59px;">Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Stock date: activate to sort column ascending" style="width: 134px;">Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Order</th>
                                                <th rowspan="1" colspan="1">Staus</th>
                                                <th rowspan="1" colspan="1">Total</th>
                                                <th rowspan="1" colspan="1">Date</th>


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
                                            <?php if ($orders) :                                       
                                                foreach ($orders as $row) :

                                            ?>
                                                    <tr role="row" class="even" id="od<?= $row->order_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->order_id ?>">
                                                        </td>
                                                        <td class=""><a href="<?= base_url('admin/edit-product/') . $row->slug ?>" class="order"><?= '<span class="order-number">' .$row->order_number . '</span>'. " " . $row->first_name . " " . $row->last_name ?></a>

                                                            <div class="edit-wrapper-all edit-wrapper-orders d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->order_id ?></button>
                                                                <a href="<?= base_url('admin/edit-order/') . $row->order_id ?>" type="button" class="btn text-black">Edit</a>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->order_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-black view-order" data-id="<?= $row->order_id ?>" >View</button>
                                                                <button type="button" class="btn text-black printInvoice" data-id="<?= $row->order_id ?>" >Print Invoice</button>
                                                                <button type="button" class="btn text-black downloadButton" data-id="<?= $row->order_id ?>" >Download Invoice</button>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 order-status"><?php 
                                                           if($row->order_status == 0){
                                                            echo "<span class='status_pending'> Pending </span>";
                                                            
                                                           }elseif($row->order_status == 1){
                                                             echo "<span class='status_processing'>  Processing </span>";
                                                           }
                                                           elseif($row->order_status == 2){
                                                            echo "<span class='status_shipped'> Shipped </span>";
                                                          }
                                                          elseif($row->order_status == 3){
                                                            echo "<span class='status_delivered'> Delivered </span>";
                                                          }
                                                          elseif($row->order_status == 4){
                                                            echo "<span class='status_canceled'> Canceled </span>";
                                                          }
                                                          elseif($row->order_status == 5){
                                                            echo "<span class='status_hold'> On Hold </span>";
                                                          }
                                                          elseif($row->order_status == 6){
                                                            echo "<span class='status_refunded'> Refunded </span>";
                                                          }
                                                          elseif($row->order_status == 7){
                                                            echo "<span class='status_failed'> Failed </span>";
                                                          }
                                                          elseif($row->order_status == 8){
                                                            echo "<span class='status_payment_failed'> payment Failed </spa>";
                                                          }
                                                        ?></td>
                                                        <td class="product-category"><?= $row->final_price ?></td>
                                                        <td class="product-stock-quantity"><?= $row->order_date ?></td>

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