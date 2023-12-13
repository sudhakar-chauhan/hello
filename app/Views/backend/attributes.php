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
                <h5 class="txt-dark">Attributes</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li><a href="#">Attributes</a></li>

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
                            <h6 class="panel-title txt-dark">Attributes</h6>
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="fitler-wrapper d-flex justify-content-between p-3">
                        
                    <div>

                  </div>


                        <div class="filter-form">
                            <form action="<?= base_url('admin/attributes/search') ?>" method="GET" class="row g-3 justify-content-end">

                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Search</label>
                                    <input class="form-control" type="text" value="<?= $searchTerm ?>" name="search" placeholder="Search">

                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-3">Search</button>
                                </div>

                            </form>
                            <!---------  Filter   --------------->
                            <form action="<?= base_url('admin/attributes/filter') ?>" method="GET" class="row g-3">


                                <div class="col-auto">
                                    <label for="staticEmail2" class="visually-hidden">Attribute Category</label>
                                    <select class="form-select" aria-label="Default" name="category">
                                        <option value="all" selected>Select a Attribute Category</option>
                                        <?php if ($attributeCategory) :
                                            foreach ($attributeCategory as $row) :
                                        ?>
                                        <?php if($row->categorie_name == 'perm'): ?>
                                            <optgroup label="Perm">
                                            <option value="<?= $row->categorie_name ?>" <?= $request->getGet('category') == $row->categorie_name ? 'selected' : '' ?>><?= $row->title ?></option>
                                            <option value="permyes" <?= $request->getGet('category') == 'permyes' ? 'selected' : '' ?>>Perm Yes</option>
           
                                       </optgroup>

                                       <?php elseif($row->categorie_name == 'curl'): ?>
                                        <optgroup label="Curl">
                                            <option value="<?= $row->categorie_name ?>" <?= $request->getGet('category') == $row->categorie_name ? 'selected' : '' ?>><?= $row->title ?></option>
                                            <option value="curlMen" <?= $request->getGet('category') == 'curlMen' ? 'selected' : '' ?>>Curl Men</option>
                                            <option value="curlWomen" <?= $request->getGet('category') == 'curlWomen' ? 'selected' : '' ?>>curl Women</option>
           
                                       </optgroup>
                                          
                                       <?php elseif($row->categorie_name == 'greyHair'): ?>
                                        <optgroup label="Grey Hair">
                                            <option value="<?= $row->categorie_name ?>" <?= $request->getGet('category') == $row->categorie_name ? 'selected' : '' ?>><?= $row->title ?></option>
                                            <option value="greyHairType" <?= $request->getGet('category') == 'greyHairType' ? 'selected' : '' ?>>Grey Hair Type</option>
                                           
           
                                       </optgroup>
                                          

                                            <?php else: ?>
                                                <option value="<?= $row->categorie_name ?>" <?= $request->getGet('category') == $row->categorie_name ? 'selected' : '' ?>><?= $row->title ?></option>
                                        <?php endif; ?>    
                                               
                                                
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
                                        <a class="text-success ms-4" href="<?= base_url('admin/attributes') ?>">All (<?= $total ?>)</a>
                                        <p class="text-dark">Showing <?= $total > $perPage ? $perPage : $total ?> of <?= $total ?></p>

                                    </div>
                                    <table id="datable_1" class="table table-hover display  pb-30 dataTable" role="grid" aria-describedby="datable_1_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" aria-sort="descending" style="width: 320px;">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Attribute Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="datable_1" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 162px;">Price</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">Title</th>
                                                <th rowspan="1" colspan="1">Attribute Category</th>
                                                <th rowspan="1" colspan="1">Price</th>


                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php if ($attributes) :
                                                foreach ($attributes as $row) :

                                            ?>
                                                    <tr role="row" class="even">

                                                        <td><span class="category-name"><?= $row->attribute_name ?></span>

                                                            <div class=" edit-wrapper-all edit-wrapper-attributes d-flex g-2 pt-2">
                                                                <button type="btn" class="btn text-black ">ID: <?= $row->attribute_id ?></button>
                                                                <button type="button" class="btn text-black quick-edit" data-id="<?= $row->attribute_id ?>">Quick Edit</button>
                                                            </div>

                                                        </td>
                                                        <td class="sorting_1 attribute-categorie"><?= ucfirst($row->attribute_categorie) ?></td>
                                                        <td class="sorting_1 price"><?= $row->price ?></td>

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