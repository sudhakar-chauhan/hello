<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                   <div class="print-section">
                   <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Invoice</h6>
                        </div>
                        <div class="pull-right">
                            <h6 class="txt-dark">Order # <?= $order[0]->order_number?></h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">Billed to:</span>
                                    <address class="mb-15">
                                        <span class="address-head mb-5"><?= $order[0]->billing_first_name . ' '. $order[0]->billing_last_name?></span>
                                        <?= $order[0]->billing_address ?> <br>
                                        <?= $order[0]->billing_city .', ' . $order[0]->billing_state . " " . $order[0]->billing_zipcode .", " . $order[0]->billing_country?> <br>
                                        <abbr title="Phone">P: <?= $order[0]->billing_phone_number?></abbr>                             
                                           </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <span class="txt-dark head-font inline-block capitalize-font mb-5">shiped to:</span>
                                    <address class="mb-15">
                                        <span class="address-head mb-5"><?= $order[0]->first_name . ' '. $order[0]->last_name?></span>
                                        <?= $order[0]->address ?> <br>
                                        <?= $order[0]->city .', ' . $order[0]->state . " " . $order[0]->zipcode .", " . $order[0]->country?>  <br>
                                        <abbr title="Phone">P: <?= $order[0]->phone_number?>  </abbr>                            
                                           </address>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <address>
                                        <span class="txt-dark head-font capitalize-font mb-5">Payment Method:</span>
                                        <br>
                                        <?= $order[0]->payment_method?><br>

                                    </address>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <address>
                                        <span class="txt-dark head-font capitalize-font mb-5">order date:</span><br>
                                        <?= $order[0]->order_date?><br><br>
                                    </address>
                                </div>
                            </div>

                            <div class="invoice-bill-table">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Totals</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= $order[0]->product_name?></td>
                                                <td><?= $order[0]->final_price?></td>
                                                <td><?= $order[0]->quantity?></td>
                                                <td><?= $order[0]->final_price?></td>
                                            </tr>
                                          
                                        </tbody>
                                    </table>
                                </div>

                                <div class="clearfix"></div>
                            </div>

                          
                        </div>
                    </div>
                   </div>
                    
                </div>
            </div>
        </div>


    </div>

</div>