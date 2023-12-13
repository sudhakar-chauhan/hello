<?php
$session = session();
$request = service('request');
?>
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">inbox</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="active"><span>inbox</span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <?php 
                if($session->has('message') && $session->get('message') != ''){
                    echo $session->getFlashdata('message');
                        }
                ?>
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="mail-box">
                                <div class="row">
                                    <aside class="col-lg-3 col-md-4 pr-0">
                                        <div class="mt-20 mb-20 ml-15 mr-15">
                                            <a href="#myModal" data-toggle="modal" title="Compose" class="btn btn-success btn-block">
                                                Compose
                                            </a>
                                            <!-- Modal -->
                                            <div aria-hidden="true" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                            <h4 class="modal-title">Compose</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form role="form" class="form-horizontal">
                                                                <div class="form-group">
                                                                    <label class="col-lg-2 control-label">To</label>
                                                                    <div class="col-lg-10">
                                                                        <input type="text" placeholder="" id="inputEmail1" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-lg-2 control-label">Cc / Bcc</label>
                                                                    <div class="col-lg-10">
                                                                        <input type="text" placeholder="" id="cc" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-lg-2 control-label">Subject</label>
                                                                    <div class="col-lg-10">
                                                                        <input type="text" placeholder="" id="inputPassword1" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-lg-2 control-label">Message</label>
                                                                    <div class="col-lg-10">
                                                                        <textarea class="textarea_editor form-control" rows="15" placeholder="Enter text ..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-offset-2 col-lg-10">
                                                                        <div class="fileupload btn btn-info btn-anim mr-10"><i class="fa fa-paperclip"></i><span class="btn-text">attachments</span>
                                                                            <input type="file" class="upload">
                                                                        </div>

                                                                        <button class="btn btn-success" type="submit">Send</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        </div>
                                        <ul class="inbox-nav mb-30">
                                            <li class="active">
                                                <a href="<?= base_url('admin/inbox') ?>"><i class="zmdi zmdi-inbox"></i> Inbox <span class="label label-danger ml-10"> 20 </span></a>
                                            </li>
                                            <li class="">
                                                <a href="<?= base_url('admin/inbox?type=motor-vechile') ?>"><i class="fa fa-automobile"></i> Motor Vehicle<span class="label label-danger ml-10"> 20 </span></a>
                                            </li>
                                            <li class="">
                                                <a href="<?= base_url('admin/inbox?type=home-content') ?>"><i class="fa fa-home"></i> Home & Contents <span class="label label-danger ml-10"> 20 </span></a>
                                            </li>
                                            <li class="">
                                                <a href="<?= base_url('admin/inbox?type=domestic-landloard') ?>"><i class="fa fa-building"></i> Domestic Landlords <span class="label label-danger ml-10"> 20 </span></a>
                                            </li>
                                        </ul>
                                    </aside>

                                    <aside class="col-lg-9 col-md-8 pl-0">
                                        <div class="panel panel-refresh pa-0">
                                            <div class="refresh-container">
                                                <div class="la-anim-1"></div>
                                            </div>
                                            <div class="panel-heading pt-20 pb-20 pl-15 pr-15">
                                                <div class="pull-left">
                                                    <h6 class="panel-title txt-dark">inbox</h6>
                                                </div>
                                                <div class="pull-right">
                                                    <form action="<?= base_url('admin/inbox/search') ?>" method="GET" role="search" class="inbox-search inline-block pull-left mr-15">


                                                        <div class="input-group">
                                                            <input name="search" class="form-control" value="" placeholder="Search" type="text">
                                                            <span class="input-group-btn">
                                                                <button type="submit" class="btn  btn-default" data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
                                                            </span>
                                                        </div>
                                                    </form>

                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="panel-wrapper collapse in">
                                                <div class="panel-body inbox-body pa-0">
                                                    <div class="mail-option pl-15 pr-15">


                                                        <div class="btn-group d-flex justify-content-between">
                                                            <form action="<?= base_url('admin/inbox/filter') ?>" method="GET" class="row g-3">
                                                                <div class="col-auto">
                                                                    <label for="staticEmail2" class="visually-hidden">All</label>
                                                                    <select class="form-select" aria-label="Default" name="messageType">
                                                                        <option value="all" selected>All</option>
                                                                        <option value="read" <?= $request->getGet('messageType') == "read" ? 'selected' : '' ?>>Read</option>
                                                                        <option value="unread" <?= $request->getGet('messageType') == "unread" ? 'selected' : '' ?>>Uread</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button type="submit" class="btn btn-primary mb-3">Filter</button>
                                                                </div>
                                                            </form>
                                                            <form action="#bulkEdit" method="POST" class="row g-3 ">
                                                                <div class="col-auto">
                                                                    <label for="staticEmail2" class="visually-hidden">Bulk Edit</label>
                                                                    <select class="form-select" id="bulkSelect" aria-label="Default" name="bulk">
                                                                        <option selected>Bulk </option>
                                                                        <option value="delete">Delete</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button type="button" id="bulkApplyInbox" class="btn btn-primary mb-3">Apply</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="chk-all">
                                                        </div>
                                                        <ul class="unstyled inbox-pagination">
                                                            <li><span> <a href="<?= base_url('admin/inbox') ?>">All mails</a> 10 of 20 </span></li>

                                                        </ul>
                                                    </div>
                                                    <div class="table-responsive mb-0">
                                                        <table class="table table-inbox table-hover mb-0">
                                                            <tbody>
                                                                        <tr class="unread" id="ct">
                                                                            <td class="inbox-small-cells">
                                                                                <div class="checkbox checkbox-default inline-block">
                                                                                    <input type="checkbox" data-id="1" />
                                                                                    <label for="12"></label>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                #CL0032
                                                                            </td>
                                                                            <td class="view-message  dont-show">Sahil Yadav<span class="label label-warning pull-right">new</span>
                                                                             <br>
                                                                            <a href="<?= base_url('admin/inbox-details/'.base64_encode(1))?>" class="clr-neutral-400"> Read Email  </a></td>
                                                                            <td class="view-message ">Insurace Category</td>
                                                                            <td class="view-message  text-right">
                                                                                <span class="time-chat-history inline-block"><?= date('M/d/Y H:i') ?></span>
                                                                            </td>
                                                                        </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>