 <div id="main">
            <div class="visible-md visible-xs visible-sm mobile-menu">
                <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
            </div>

            <section class="bgw clearfix course-detail-master">           	
			        
			         <div class="page-title bgg">
			            <div class="container-fluid clearfix">
			                <div class="title-area pull-left">
			                    <h2>Update Department </h2>
			                </div><!-- /.pull-right -->
			                <div class="pull-right hidden-xs">
			                    <div class="bread">
			                        <ol class="breadcrumb">
			                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
			                            <li ><a href="<?= BASEURL?>departments/">Departments</a></li>
			                            <li class="active">update</li>
			                        </ol>
			                    </div><!-- end bread -->
			                </div><!-- /.pull-right -->
			            </div>
			        </div><!-- end page-title -->
          
			            	<section class="section bgw">
					            <div class="container">
					                <div class="row">
					                    <div class="col-md-12 col-sm-12">
					         
		
                      <div class="custom-form clearfix">
                                                <div class="big-title">
                                                    <h2 class="related-title">
                                                        <span> Department Details </span>
                                                    </h2>
                                                </div><!-- end big-title -->
<div class="loginform learners-form">
<?= $this->Form->create($department,['class'=>'row']) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('title',['label'=>'Department Name','class'=>'form-control','placeholder'=>'Department Name']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('parent_id',['empty'=>'Select Parent','class'=>'form-control','options'=>$getParentCat]) ?>
</div>


<div class="clear"> </div>




<?= $this->Form->submit('SEND',['class'=>'button button--wayra btn-block btn-square btn-lg']) ?>

</div>
</form> 
</div>
</div>
                    </div>

</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->



 