<?php $this->assign('title','Manage Sales') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>


<div class="row">
    <div class="x_panel">
        <div class="row col-md-12">
            <div class="x_title">
                <h2>Search Sales <small></small></h2> <!-- ucfirst($type).'s' -->
                <div class="clearfix"></div>
            </div>
            <?= $this->Form->create('Search', ['method' => 'get']) ?>
            <label class="col-md-1">Date Range</label>
            <div class="form-group col-md-3">
                <?= $this->Form->input('date_range',['label'=>false,'class'=>'form-control start_date','placeholder'=>'Start Date']) ?>
            </div>
            <!-- <div class="form-group col-md-3">
                <?= $this->Form->input('end_date',['label'=>false,'class'=>'form-control end_date','placeholder'=>'End Date']) ?>
            </div> -->
            <div class="form-group col-md-3">
                <input type="submit" value="Search" class="btn  btn-primary" name="">
            </div>
            <!-- <div class="form-group col-md-1 pull-right">
                <label>Total: $120</label>
            </div> -->
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <h2>Manage Sales  <small>(Total Sale: $<?= $total_sale ?>)</small></h2>
            <!-- <ul class="nav navbar-right panel_toolbox">
                <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New Tag',['action'=>'form'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul> -->
            <div class="clearfix"></div> 
        </div>
        <div class="x_content">
            <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                    <thead>
                        <tr role="row">
                            <th class="" ><?= $this->Paginator->sort('order_num',__('Order Number <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('fname',__('User <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('User.type',__('User Type <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('User.company_name',__('Company Name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('amount',__('Amount <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('modified',__('Date <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th>Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($list as $value) {
                            $lid = $this->Common->myencode($value['id']);
                            if ($i % 2 == 0) {
                                $cl = 'even';
                            } else {
                                $cl = 'odd';
                            }
                        ?>
                        <tr role="row" class="<?= $cl ?>" id="<?= $value['id']?>">
                            <td tabindex="0" class="sorting_1"><?= $value['order_num'] ?></td>
                            <td>
                                <?php
                                    if( ($value['user']['role'] == 2) || ($value['user']['role'] == 3) ){ //manager / instructor
                                        echo $this->Html->link(ucfirst($value['user']['fname']).' '.$value['user']['lname'],['controller'=>'Users','action'=>'update',$value['user']['id'] ]);
                                    } else if($value['user']['role'] == 4){
                                        echo $this->Html->link(ucfirst($value['user']['fname']).' '.$value['user']['lname'],['controller'=>'Users','action'=>'update_learner',$value['user']['id'] ]);
                                    } else{
                                        echo ucfirst($value['user']['fname'].' '.$value['user']['lname']);
                                    }
                                ?>
                            </td>
                            <td><?= ucfirst($value['user']['user_role']['name']) ?></td>
                            <td><?= ucfirst($value['user']['company']['company_name']) ?></td>
                            <td>$<?= $value['amount'] ?></td>
                            <td><?= $value['modified']->format('M d, Y, h:i a') ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-pencil"></i> View',['action'=>'view',$this->Common->myencode($value['id'])],['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                                <!-- $this->Html->link('<i class="fa fa-trash"></i> Delete',['action'=>'delete',$lid],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you want to delete course '.strtoupper($value['title'])])  -->
                            </td>
                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
            <?= $this->element('paginator') ?>
        </div>
    </div>
</div>
<?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.bootstrap.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.responsive.min.js')?>
<?= $this->Html->script('../admin/vendors/datatables.net/js/responsive.bootstrap.js')?>

<?= $this->Html->css('bootstrap-material-datetimepicker.css') ?>
<?= $this->Html->script('momentjs.js') ?>
<?= $this->Html->script('bootstrap-material-datetimepicker.js') ?>
<?= $this->Html->script('bootstrap-material-datetimepicker.js') ?>

    <?= $this->Html->script('../admin/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>

<script type="text/javascript"> 
    /*$(document).ready(function() {
      $('.start_date').bootstrapMaterialDatePicker({
        time: false,
        clearButton: true
      });
    });
    */
  $('.start_date').daterangepicker({
    // singleDatePicker: true,
    // startDate: moment().subtract(6, 'days'),
    startDate: '<?= date('d/m/Y',strtotime($start_date)) ?>',
    endDate: '<?= date('d/m/Y',strtotime($end_date)) ?>',
    locale: {
        format:'DD/MM/YYYY'
    }
  });

  /*$('.end_date').daterangepicker({
    singleDatePicker: true,
    startDate: moment()
  });*/
</script>
