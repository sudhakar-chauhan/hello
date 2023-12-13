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
							if($session->has('message') && $session->get('message') != ''){
								echo $session->getFlashdata('message');
									}
							?>
        </div>
        <div class="col">
                <a href="<?= base_url('admin/add-blog')?>" class="btn btn-primary mb-3" > Add New</a>
            </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Blogs</h6>
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
                                <button type="button" id="bulkApplyBlog" class="btn btn-primary mb-3">Apply</button>
                            </div>
                        </form>

                        <div class="filter-form">
                            <form action="<?= base_url('admin/blogs/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>

                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/blogs/filter') ?>" method="GET" class="row g-3">


                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Category</label>
                                    <select class="form-select" aria-label="Default" name="category">
                                        <option value="all" selected>Select a Category</option>
                                        <?php if ($category) :
                                            foreach ($category as $row) :
                                        ?>
                                                <option value="<?= $row->blog_category_id ?>" <?= $request->getGet('category') == $row->blog_category_id ? 'selected' : '' ?>><?= $row->category_name ?></option>
                                        <?php
                                            endforeach;
                                        endif;

                                        ?>

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
                                        <a class="text-success ms-4" href="<?= base_url('admin/blogs') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>
                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="CheckBox:" style="width: 50px;">CheckBox</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 40px;">Feature Image</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 250px;">Heading</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending" style="width: 80px;">Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Stock date: activate to sort column ascending" style="width: 100px;">Author</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Stock date: activate to sort column ascending" style="width: 100px;">Created On</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">CheckBox</th>
                                                <th rowspan="1" colspan="1">Feature Image</th>
                                                <th rowspan="1" colspan="1">Name</th>
                                                <th rowspan="1" colspan="1">Category</th>
                                                <th rowspan="1" colspan="1">Author</th>
                                                <th rowspan="1" colspan="1">Created On</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if ($data) :
                                                foreach ($data as $row) :
                                            ?>

                                                    <tr role="row" class="even" id="ct<?= $row->blog_id ?>">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox" name="checkbox" data-id="<?= $row->blog_id ?>">
                                                        </td>
                                                        <td class="sorting_1 feature_image"><img src="<?=base_url('public/assets/uploads/blog/').$row->feature_image?>" 
                                                        width="50" height="50" alt=""></td>
                                                        <td class=""><a href="<?= base_url('admin/edit-blog/') . $row->blog_slug ?>" class="heading"><?= $row->heading ?></a>

                                                            <div class="edit-wrapper-all edit-wrapper-blog d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->blog_id ?></button>
                                                                <a href="<?= base_url('admin/edit-blog/') . $row->blog_slug ?>" type="button" class="btn text-black">Edit</a>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->blog_id ?>">Quick Edit</button>
                                                                <button type="button" class="btn text-danger " id="deleteConfirm" data-id="<?= $row->blog_id ?>">Delete</button>
                                                                <a href="<?= base_url('blog/'.$row->blog_slug) ?>" type="button" class="btn text-black btnView">View</a>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 category"><?= $row->category_name ?></td>
                                                        <td class="author"><?= $row->created_by ?></td>
                                                        <td class="created_on"><?= date('d-M-Y', strtotime($row->created_at)) ?></td>

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