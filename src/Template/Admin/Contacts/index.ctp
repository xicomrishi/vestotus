<?php $this->assign('title','Manage Contact Requests') ?>

<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>

<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>

 
    <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Manage Contact Requests</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">


                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                      <thead>
                        <tr role="row">
                        <th class="sorting_asc" >Name</th>
                        <th class="sorting" >Email</th>
                        <th class="sorting" >Phone</th>
                        <th class="sorting" >Date</th>
                        <th class="sorting" >User type </th>
                        <th>Actions </th></tr>
                      </thead>


                      <tbody>
                 <?php 
                 $i = 1;
                  foreach($pages as $list) {
                    if($i % 2 == 0)
                    {
                      $cl = 'even';
                    }
                    else
                    {
                      $cl = 'odd';
                    }

                   ?>
                  <tr role="row" class="<?= $cl ?>">
                          <td tabindex="0" class="sorting_1"><?= h($list['name']) ?></td>
                          <td><?= $list['email'] ?></td>
                          <td><?= $list['phone'] ?></td>
                          <td><?= $list['created']->nice() ?></td>
                          <td> <?= $this->__get_role($list['user']['role']) ?></td>
                          <td>
                            <a class="btn btn-primary btn-xs" href="javascript:void(0);" data-toggle="modal" data-target="#view_<?= $list['id'] ?>"><i class="fa fa-folder"></i> View</a>
                            <?= $this->Html->link('<i class="fa fa-trash-o"></i> Delete',['action'=>'delete',$list['id']],['escape'=>false,'class'=>'btn btn-danger btn-xs','confirm'=>'Do you really want to delete it ?'])?>
                             


                            <div class="modal fade in" id="view_<?= $list['id'] ?>" >
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Contact Request</h4>
                        </div>
                        <div class="modal-body">
                          
                          <p><strong>Name : </strong> <?= ucwords($list['name']) ?> </p>
                          <p><strong>Email : </strong> <?= ucwords($list['email']) ?> </p>
                          <p><strong>Phone : </strong> <?= ucwords($list['phone']) ?> </p>
                          <p><strong>Subject : </strong> <?= ucwords($list['subject']) ?> </p>
                          <p><strong>Message : </strong> <?= ucwords($list['message']) ?> </p>
                          <p><strong>Date : </strong> <?= $list['created']->nice() ?> </p>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          
                        </div>

                      </div>
                    </div>
                  </div>
                          </td>
                          

                        </tr>
                  <?php $i++; } ?>
                    </tbody>
                    </table></div>
                  </div>
                </div>
              </div>

               <?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.bootstrap.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/dataTables.responsive.min.js')?>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/responsive.bootstrap.js')?>
 
   
               <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>