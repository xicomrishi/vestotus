<?php $this->assign('title',"Manage Users") ?>
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>E-Commerce Pricing </h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> <small> </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div class="col-sm-6">

                    <?= $this->Form->create($user,['novalidate'=>'novalidate','class'=>'form-horizontal form-label-left']); ?>
                    <?php $this->Form->templates($form_templates['fullForm']); ?>
                      <div class="item form-group">
                        <div class="form-group " form-type="text">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Course Price </label> 
                        <div class="col-md-6 col-sm-6 col-xs-12"><label style="padding-top:10px;"> $ <?= $course['purchase_price'] ?> </label></div>
                        </div>                      
                    </div>
                      <div class="item form-group">
                        <?= $this->Form->input('user_id',['label'=>'Select User *','class'=>'form-control col-md-7 col-xs-6','multiple'=>true]) ?>
                      </div>
                       <div class="item form-group">
                        <?= $this->Form->input('price',['label'=>'Price *','value'=>'','class'=>'form-control col-md-7 col-xs-12']) ?>
                      </div>

                    

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                        <?= $this->Form->submit('Save',['escape'=>false,'div'=>false,'class'=>'btn btn btn-success']) ?>
							
						              <?= $this->Form->button('Back',['type'=>'button','id'=>'cancelButton','class'=>'btn btn-primary','onClick'=>'window.location.href : "'.BASEURL.'admin/courses/ecommerce"']) ?>
                        
                        </div>
                      </div>
                    </form>
                    </div>
                    <div class="col-sm-6">
                    <table class="table table-striped table-bordered dataTable no-footer dtr-inline">
                    <thead>
                      <tr>
                          <th> Manager </th>
                          <th> Price </th>
                          <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($pricing as $p) { ?>
                        <tr>
                          <td> <?= ucfirst($p['user']['fname'].' '.$p['user']['lname']) ?> </td>
                          <td> $<?= $p['price'] ?> </td>
                          <td> <?= $this->Html->link('<i class="fa fa-trash"> </i>',['action'=>'deletep',$p['id']],['escape'=>false,'class'=>'btn btn-danger btn-xs']) ?></td>
                        </tr>
                        <?php 
                         } ?>
                    </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

						<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
 	<script>
	$(document).ready(function () {  

    $.get("<?= BASEURL ?>admin/users/getManagers",function(result){
      //console.log(result);
      result = $.parseJSON(result);
		 $('#user-id').select2({data:result,placeholder:"<?= __('Select Manager') ?>", multiple : true});
});
  


  });
	</script>
				

		<style type="text/css">
    .select2-container--default.select2-container--focus .select2-selection--multiple
{
  border-color : #ccc !important;

}
.select2.select2-container.select2-container--default { width:300px !important;  border-radius: 0px !important;
  margin:10px; }  
    </style>