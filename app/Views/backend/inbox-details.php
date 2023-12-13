      <!-- Main Content -->
      <div class="page-wrapper">
          <div class="container-fluid">
              <!-- Title -->
              <div class="row heading-bg">
                  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                      <h5 class="txt-dark">inbox-detail</h5>
                  </div>
                  <!-- Breadcrumb -->
                  <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                      <ol class="breadcrumb">
                          <li><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                          <li class="active"><span>inbox-detail</span></li>
                      </ol>
                  </div>
                  <!-- /Breadcrumb -->
              </div>
              <!-- /Title -->

              <!-- Row -->
              <div class="row">
                  <div class="col-lg-12">
                      <div class="panel panel-default card-view  pa-0">
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
                                                      <a href="<?=base_url('admin/inbox')?>"><i class="zmdi zmdi-inbox"></i> Inbox <span class="label label-danger ml-10"><?=$totalUnread?></span></a>
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
                                                  </div>
                                                  <div class="panel-wrapper collapse in">
                                                      <div class="panel-body inbox-body pa-0">
                                                          <div class="heading-inbox">
                                                              <div class="container-fluid">
                                                                  <div class="pull-left">
                                                                      <div class="compose-btn">
                                                                      </div>
                                                                  </div>
                                                                  <div class="pull-right text-right">
                                                                    <form action="<?=base_url('admin/inbox/delete')?>" method="post">

                                                                    <?= csrf_field()?>
                                                                    <div class="d-none">
                                                                        <input type="hidden" name="id" value="<?= $inbox[0]->id?>">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-sm mr-10" title=""><i class="zmdi zmdi-delete"></i></button>
                                                                    </form>
                                                                     
                                                                  </div>
                                                              </div>
                                                              <hr class="light-grey-hr mt-10 mb-15" />
                                                              <div class="container-fluid mb-20">
                                                                  <h4 class="weight-500"> Intrested In <?= $inbox[0]->product_interests ?></h4>
                                                              </div>
                                                          </div>
                                                          <div class="sender-info">
                                                              <div class="container-fluid">

                                                                  <div class="sender-details   pull-left">
                                                                      <span class="capitalize-font pr-5 txt-dark block font-15 weight-500 head-font"><?= $inbox[0]->representative_name ?></span>
                                                                      <span class="block">
                                                                          <span><?= $inbox[0]->company_name ?></span>
                                                                      </span>
                                                                  </div>
                                                                  <div class="pull-right">
                                                                      <div class="inline-block mr-5">
                                                                          <span class="inbox-detail-time-1 font-12"><?= date('M/d/Y', strtotime($inbox[0]->created_at)) ?></span>
                                                                      </div>

                                                                  </div>
                                                                  <div class="clearfix"></div>
                                                              </div>
                                                          </div>
                                                          <div class="container-fluid view-mail mt-20">
                                                              <p><?= $inbox[0]->message ?></p>

                                                          </div>
                                                          <hr class="light-grey-hr mt-20 mb-20" />
                                                          <div class="container-fluid attachment-mail mt-40 mb-40">



                                                              <div class="mb-2">

                                                                  <h6>Email:</h6> <span><?= $inbox[0]->email ?></span>

                                                              </div>

                                                              <div class="mb-2">

                                                                  <h6>Phone:</h6> <span><?= $inbox[0]->phone ?></span>

                                                              </div>

                                                              <div class="mb-2">

                                                                  <h6>Website:</h6> <span><?= $inbox[0]->website ?></span>

                                                              </div>

                                                              <div class="mb-2">

                                                                  <h6>Facebook:</h6> <span><?= $inbox[0]->facebook ?></span>

                                                              </div>
                                                              <div class="mb-2">

                                                                  <h6>Estimated Monthly:</h6> <span><?= $inbox[0]->estimated_monthly ?></span>

                                                              </div>



                                                              </ul>
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
              <!-- /Row -->
          </div>


      </div>