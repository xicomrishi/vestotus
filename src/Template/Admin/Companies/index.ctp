<?php $this->assign('title','Manage Companies') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>
<div class="row">
    <div class="x_panel">
        <div class="row col-md-12">
            <div class="x_title">
                <h2>Filter Companies<small></small></h2>
                <div class="clearfix"></div>
            </div>
            <?= $this->Form->create('filters',['type'=>'get']) ?>
            <div class="col-md-12 ">
               <div class="form-group col-md-3">
                    <?= $this->Form->input('keyword',['value' => @$search['keyword'], 'class'=>'form-control', 'label'=>false, 'placeholder' => 'Enter Company Name' ]) ?>
                </div>
                <div class="form-group col-md-3">
                    <input type="submit" value="Search" class="btn  btn-primary" name="">
                    <a href="<?= BASEURL.'admin/companies' ?>"><input type="button" value="Reset" class="btn  btn-primary"></a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="x_panel">
        <div class="x_title">
            <!-- <h2>Manage Companies  <small> List</small></h2> -->
            <h2>Companies List</h2>
            <!-- <ul class="nav navbar-right panel_toolbox">
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
                            <th class="" >Logo </th>
                            <th class="" ><?= $this->Paginator->sort('company_name',__('Company Name <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('description',__('Description  <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('is_whitelabel',__('White Label? <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th class="" ><?= $this->Paginator->sort('created',__('Created On <i class="fa fa-arrow-'.$arrow.' aria-hidden="true"></i>'),['escape'=>false]) ?></th>
                            <th>Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i = 1;
                             foreach($lists as $list) {
                               //print "<pre>";print_r($list);
                               $lid = $this->Common->myencode($list['id']);
                               if($i % 2 == 0)
                               {
                                 $cl = 'even';
                               }
                               else
                               {
                                 $cl = 'odd';
                               }
                            
                              ?>
                        <tr role="row" class="<?= $cl ?>" id="<?= $list['id']?>">
                            <td> <?php if($list['logo']){ $img = BASEURL.'uploads/'.$list['logo']; } else { $img = BASEURL."images/imgplaceholder.jpg"; } ?>
                                <?= $this->Html->image($img,['height'=>"40px",'class'=>'img_preview']) ?>
                            </td>
                            <td tabindex="0" class="sorting_1"><?= ucfirst($list['company_name']) ?></td>
                            <td><?= $this->Text->truncate($list['description'],30) ?></td>
                            <td><?= ($list['is_whitelabel'] == 1) ? "Yes" : "No" ?></td>
                            <td><?= $list['created']->format('M d, Y') ?></td>
                            <td>
                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',['action'=>'form',$list['id']],['escape'=>false,'class'=>'btn btn-info btn-xs']) ?>
                                <?php echo $this->Html->link('<i class="fa fa-file-text-o"></i> Profile',['action'=>'profile',$lid],['escape'=>false,'class'=>'btn btn-success btn-xs']) ?>
                                <?= $this->Html->link('<i class="fa fa-trash"></i> Delete',['action'=>'delete',$lid],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you want to delete this Company : '.strtoupper($list['company_name'])]) ?>
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