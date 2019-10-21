
<?php $arrow = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down'; ?>
<?= $this->Html->css('../admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')?>
<?= $this->Html->css('../admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')?>

<?= $this->Html->css('../admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')?>
<?php
$controller=new App\Controller\AppController();
$departments=$controller->departments();
$courses=$controller->courses();

?>
  
   <div class="">
       <div class="row">
       <div class="x_panel">
           <div hidden class="row col-md-12">
		 <div class="x_title">
                    <h2>Filter Enrollments <small></small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <?= $this->Form->create('filters',['type'=>'get' ,'style'=>'display:none']) ?>
                       

                                    <div class="col-md-12 date-picker">
                                    <div class="form-group col-md-3 date" id="datetimepicker1">
                                    <input type="text" class="form-control" placeholder="Start Date" name="start_date">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                    <div class="form-group col-md-3 date" id="datetimepicker2">
                                    <input type="text" class="form-control" placeholder="End Date" name="end_date">
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                     <div class="form-group col-md-3">
                                    <input type="text" class="form-control" placeholder="Search Title..." name="search_text">
                                    </div>

                                     <div class="form-group col-md-3">
                                                                <input type="submit" value="Search" class="btn  btn-primary" name="">
                                                            </div>
                                    </div>


                        <?= $this->Form->end() ?>
               
               
	</div>
        
       </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Enrollment Key<small></small></h2>
                      <?= $this->Form->create('Users',['type'=>'file','id'=>'uploadForm']) ?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li> <?= $this->Html->link('<i class="fa fa-plus"></i> Add New',['controller'=>'EnrollKeys','action'=>'form'],['escape'=>false,'class'=>'btn btn-primary','style'=>'color:#fff;']) ?></li>
                      
                     
                    </ul>
                     <?= $this->Form->end() ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >
                     <thead>
<tr>

<th>Name </th>
<th>Key  </th>

<th>Max Users</th>
<th>Time Used</th>
<th>No. Of Courses</th>
<th>Action</th>
</tr>
</thead>
     <tbody>                  
<?php if(count(@$list)>0) { 
	foreach ($list as $list) {
?>
<tr>

<td>
<a href="#"><?= $list['name'] ?></a>
</td>
<td>
<?= $list['key_name'] ?>
</td>

<td><?= $list['max_uses'] ?></td>
<td> <?= $list['times_used'] ?></td>
<td>
<?php $expc = explode(',',$list['courses']);
	echo count($expc);
?> 
</td>
<td> 
<?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'form',$list['id']],['class'=>'edit','escape'=>false]) ?> 
<?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'del',$list['id']],['class'=>'delete','escape'=>false,'confirm'=>'Do you really want to delete it ?']) ?>
<?= '&nbsp'.$this->Html->link('<i class="fa fa-share" aria-hidden="true"></i>','javascript:void(0);',['class'=>'sharekeybutton','escape'=>false,'id'=>$list['id']]) ?>
  
</tr>
<?php } } else { ?>
	<tr> <td colspan="6"> No Records Found! </td></tr>
	<?php } ?>
</tbody>
                        </table>
                   </div>
                 <?= $this->element('paginator'). $this->element('modal_chapter'); ?>
                </div>
              </div>
   </div>   </div>
               <?= $this->Html->script('../admin/vendors/datatables.net/js/jquery.dataTables.min.js')?>
               
<script>
$(function(){
   $('#upload').change(function(){
      $('#uploadForm').submit(); 
   });
});
</script>     

<style>
    .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

.input-group-addon {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    display: ruby;
    position: absolute;
    right: 13px !important;
    top: 3px;
    width: 10px;
</style>
               
 
<script type="text/javascript">
	$(document).ready(function(){
		$('.sharekeybutton').click(function(){
			var getid = $(this).attr('id');
			$('#myModal-shareKey').modal('show');
			$('#keyid').val(getid);
			
		});
		$('#shareKeyform').submit(function(){
		      	var formdata = new FormData($(this)[0]);
			$('.sharemailerror').remove();
			$('#loader').show();
			$.ajax({
				type : 'post',
				url : '<?= BASEURL?>enrollKeys/shareKey',
				data: formdata, 
				contentType: false,       
				cache: false,             
				processData:false, 
				success:function(response){
					console.log(response);

					var result = $.parseJSON(response);
					if(result.status=='error')
					{
						$('#loader').hide();
						$('textarea[name="emails"]').after('<label class="error sharemailerror">'+result.errors+'</label>');
					}
					else if(result.status=='success')
					{
						location.reload(true);
					}
				}
			});
			return false;
		});
	});
</script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(document).ready(function(){
                var date_input=$('.date');
                var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
                date_input.datepicker({
                    format: 'd M, yyyy',
                    container: container,
                    todayHighlight: true,
                    autoclose: true,
                })
            })
        </script>
   
           