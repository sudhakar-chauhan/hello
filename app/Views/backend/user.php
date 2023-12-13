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
                <h5 class="txt-dark"></h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>

                    <li class="active"><span> <?= $currentUrl->getSegment(4) ?></span></li>
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
                            <h6 class="panel-title txt-dark">Users</h6>
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
                                <button type="button" id="bulkApplyUser" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/user/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search User">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>

                            <!---------  Filter   --------------->

                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/user/filter') ?>" method="GET" class="row g-3">
                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">User Status</label>
                                    <select class="form-select" aria-label="Default" name="status">
                                        <option value=''  selected>All</option>
                                        <option value="0" <?php if($request->getGet('status')!='' && $request->getGet('status') == 0 ){
                                            echo 'selected';
                                        }?>> Unverified </option>
                                        <option value="1" <?= $request->getGet('status') == 1 ? "selected": ""?>> Active </option>
                                        <option value="2" <?= $request->getGet('status') == 2 ? "selected": ""?>> Blocked </option>
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
                                        <a class="text-success ms-4" href="<?= base_url('admin/user') ?>">All (<?= $total ?>)</a>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending" style="width: 59px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending" style="width: 59px;">Total Orders</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Stock date: activate to sort column ascending" style="width: 134px;">Register On</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Name</th>
                                                <th rowspan="1" colspan="1">Email</th>
                                                <th rowspan="1" colspan="1">Status</th>
                                                <th rowspan="1" colspan="1">Total Orders</th>
                                                <th rowspan="1" colspan="1">Register On</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if ($user) :
                                                foreach ($user as $row) :

                                            ?>

                                                    <tr role="row" class="even" id="pr<?= $row->user_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->user_id ?>">
                                                        </td>
                                                        <td class=""><?= $row->first_name . ' ' .  $row->last_name ?>

                                                            <div class="edit-wrapper-all edit-wrapper-user d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->user_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->user_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirmUser" data-id="<?= $row->user_id ?>">Delete</button>
                                                                <a href="<?= base_url('admin/user') ?>/<?= $row->user_id ?>" target="_blank" type="button" class="btn text-black btnView">View</a>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 user-email"><?= $row->email ?></td>
                                                        <td class="user-status"><?php if ($row->is_active == 0) {
                                                                                            echo 'Unverified';
                                                                                        } else if ($row->is_active == 1) {
                                                                                            echo 'Acitve';
                                                                                        } else if ($row->is_active == 2) {
                                                                                            echo 'Blocked';
                                                                                        }
                                                                                        ?>
                                                        </td>
                                                        <td class="user-orders"><?= $row->no_of_orders ?></td>
                                                        <td class="user-created_at"><?= date('d-M-Y', strtotime($row->created_at)) ?></td>

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