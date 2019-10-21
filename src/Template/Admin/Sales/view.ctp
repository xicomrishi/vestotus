<?php $this->assign('title',"Sale Detail") ?>
<?php //echo $submenu; die; ?>
<!-- <div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Sale Detail</h3>
        </div>
    </div>
    <div class="clearfix"></div> -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Sale Detail <small> </small></h2>
                    <!-- <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul> -->
                    <div class="clearfix"></div> 
                </div>
                <div class="x_content">
                     <!-- $this->Form->create($tag,['class'=>'form-horizontal form-label-left'])  -->
                    <?php $this->Form->templates($form_templates['fullForm']); ?>
                    <div class="col-md-12">

                        <div class="col-md-6">
                            <div class="row">
                                <h5><b>Order Details:</b></label>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Order Number:</label>
                                <p class="col-md-8"><?= $sale->order_num ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">User:</label>
                                <p class="col-md-8">
                                    <?php
                                        if( ($sale['user']['role'] == 2) || ($sale['user']['role'] == 3) ){ //manager / instructor
                                            echo $this->Html->link(ucfirst($sale['user']['fname']).' '.$sale['user']['lname'],['controller'=>'Users','action'=>'update',$sale['user']['id'] ]);
                                        } else if($sale['user']['role'] == 4){
                                            echo $this->Html->link(ucfirst($sale['user']['fname']).' '.$sale['user']['lname'],['controller'=>'Users','action'=>'update_learner',$sale['user']['id'] ]);
                                        } else{
                                            echo ucfirst($sale['user']['fname'].' '.$sale['user']['lname']);
                                        }
                                    ?>
                                    (<?= 'User Role: '.ucfirst($sale['user']['user_role']['name']) ?>)
                                </p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Company:</label>
                                <p class="col-md-8"><?= ucfirst($sale['user']['company']['company_name']) ?></p>
                            </div>
                            <?php /*
                            <div class="row">
                                <label class="col-md-4">User Role:</label>
                                <p class="col-md-8"><?= ucfirst($sale['user']['user_role']['name']) ?></p>
                            </div> */ ?>
                            <div class="row">
                                <label class="col-md-4">Order Amount:</label>
                                <p class="col-md-8">$<?= $sale['amount'] ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Date & Time:</label>
                                <p class="col-md-8"><?= $sale['modified']->format('M d, Y, h:i a') ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <h5><b>Payment Details:</b></label>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Transaction ID:</label>
                                <p class="col-md-8"><?= $sale['trans_id'] ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Name:</label>
                                <p class="col-md-8"><?= ucfirst($sale['name']) ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Email:</label>
                                <p class="col-md-8"><?= $sale['email'] ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Phone:</label>
                                <p class="col-md-8"><?= $sale['phone'] ?></p>
                            </div>
                            <div class="row">
                                <label class="col-md-4">Address:</label>
                                <p class="col-md-8"><?= $sale['address'] ?><?= (!empty($sale['postal_code'])) ? ', Pincode : '.$sale['postal_code'] :'' ?></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 style="margin-top: 20px;"><b>Order Items</b></h5>
                        </div>
                        <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                            <thead>
                                <tr role="row">
                                    <th>Sr. No</th>
                                    <th>Course Name</th>
                                    <th>Price/Unit</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if(!empty($sale['order_items'])){
                                    foreach ($sale['order_items'] as $order_item) {
                                        $lid = $this->Common->myencode($order_item['id']);
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $order_item['course']['title'] ?></td>
                                        <td>$<?= number_format($order_item['price'],2) ?></td>
                                        <td><?= $order_item['quantity'] ?></td>
                                        <td>$<?= number_format($order_item['amount'],2) ?></td>
                                    </tr>
                                    <?php $i++; 
                                    }
                                } else{ ?>
                                    <tr><td colspan="5" class="text-center">No items found</td></tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><b>Order Total</b></td>
                                    <td><b>$<?= number_format($sale['amount'],2) ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary" onClick='window.history.back(-1);'>Back</button>

                        <!-- <div class="clear"> </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <?= $this->Form->submit('Save',['class'=>'btn btn btn-success']) ?>
                                <?= $this->Form->button('Cancel',['type'=>'button','id'=>'cancelButton','class'=>'btn btn-primary','onClick'=>'window.history.back(-1);']) ?>
                            </div>
                        </div> -->
                    </div>
                    <!-- </form>  -->
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
