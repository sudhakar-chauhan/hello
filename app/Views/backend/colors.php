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
                <h5 class="txt-dark">Colors</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li><a href="#">Colors</a></li>

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
                <button class="btn btn-primary mb-3" type="btn" id="addNewColor"> Add New</button>
            </div>
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Colors</h6>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="fitler-wrapper d-flex justify-content-between p-3">
                        <form action="#bulkEdit" method="POST" class="row g-3 ">
                            <div class="col-auto">
                                <label for="staticEmail2" class="visually-hidden">Bulk Edit</label>
                                <select class="form-select" id="bulkSelect" aria-label="Default" name="bulk">
                                    <option selected>Bulk </option>
                                    <option value="delete">Delete</option>

                                </select>
                            </div>


                            <div class="col-auto">
                                <button type="button" id="bulkApplyColor" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/colors/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>


                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/colors/filter') ?>" method="GET" class="row g-3">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Color Gender</label>
                                    <select class="form-select" aria-label="Default" name="gender">
                                        <option value="all" <?= $request->getGet('gender') == "all" ? 'selected' : '' ?>>Select Gender</option>
                                        <option value="hairColorMen" <?= $request->getGet('gender') == "hairColorMen" ? 'selected' : '' ?>>Men</option>
                                        <option value="hairColorWomen" <?= $request->getGet('gender') == "hairColorWomen" ? 'selected' : '' ?>>Women</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Color Category</label>
                                    <select class="form-select" aria-label="Default" name="category">
                                        <option value="all" selected>Select a color Category</option>

                                        <option value="dark" <?= $request->getGet('category') == "dark" ? 'selected' : '' ?>>Dark</option>
                                        <option value="brown" <?= $request->getGet('category') == "brown" ? 'selected' : '' ?>>Brown</option>
                                        <option value="blonde" <?= $request->getGet('category') == "blonde" ? 'selected' : '' ?>>Blonde</option>
                                        <option value="redish" <?= $request->getGet('category') == "redish" ? 'selected' : '' ?>>Redish</option>
                                        <option value="gray" <?= $request->getGet('category') == "gray" ? 'selected' : '' ?>>Gray</option>



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
                                        <a class="text-success ms-4" href="<?= base_url('admin/colors') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Color Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Color Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Gender</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Created At</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Color Name</th>
                                                <th rowspan="1" colspan="1">Color Category</th>
                                                <th rowspan="1" colspan="1">Gender</th>
                                                <th rowspan="1" colspan="1">Created At</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if ($colors) :
                                                foreach ($colors as $row) :

                                            ?>
                                                    <tr role="row" class="even" id="ct<?= $row->attribute_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->attribute_id ?>">
                                                        </td>
                                                        <td><span class="color-name"><?= $row->attribute_name ?></span>

                                                            <div class=" edit-wrapper-all edit-wrapper-color d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->attribute_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->attribute_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="<?= $row->attribute_id ?>">Delete</button>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 color-category"><?= ucfirst($row->color_categorie) ?></td>
                                                        <td class="attribute-category"><?= $row->attribute_categorie == 'hairColorMen' ? "Men" : "Women" ?></td>
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



    