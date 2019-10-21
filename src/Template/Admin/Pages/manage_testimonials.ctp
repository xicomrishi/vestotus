<?php $this->assign('title','Manage Testimonials') ?>
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>

<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>

 
    <div class="col-md-12 col-sm-12 col-xs-12">
     
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Manage Testimonials  <small>Testimonials</small></h2> -->
                    <h2>Testimonials  <small>List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New',['action'=>'addTestimonials'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
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
                        <th class="sorting" width="40%" >Content</th>
                        <th class="sorting" >Date</th>
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
                          <td tabindex="0" class="sorting_1"><?= h($list['title']) ?></td>
                         
                          <td><?= substr(strip_tags($list['content']),0,150) ?>..</td>
                          <td><?= $list['created']->nice() ?></td>
                          <td>
                             <?= $this->Html->link('<i class="fa fa-pencil"></i> Edit',['action'=>'addTestimonials',$list['id']], ['escape'=>false,"class"=>"btn btn-info btn-xs"]) ?></td>

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