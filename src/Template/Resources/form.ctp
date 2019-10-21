 <div id="main">
            <div class="visible-md visible-xs visible-sm mobile-menu">
                <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
            </div>

            <section class="bgw clearfix course-detail-master">           	
			        
			         <div class="page-title bgg">
			            <div class="container-fluid clearfix">
			                <div class="title-area pull-left">
			                    <h2>Update Resource </h2>
			                </div><!-- /.pull-right -->
			                <div class="pull-right hidden-xs">
			                    <div class="bread">
			                        <ol class="breadcrumb">
			                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
			                            <li ><a href="<?= BASEURL?>departments/">Resources</a></li>
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
                                                        <span> Resources Details </span>
                                                    </h2>
                                                </div><!-- end big-title -->
<div class="loginform learners-form">
<?= $this->Form->create($resource,['class'=>'row','type'=>'file']) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('course_id',['empty'=>true,'empty'=>'Select Course','class'=>'form-control','options'=>$this->Common->mycourses($this->request->session()->read('Auth.User.id'))]) ?>
</div>
<div class="form-group">
<?= $this->Form->input('name',['label'=>'Title','class'=>'form-control','placeholder'=>'Title']) ?>
</div>
<div class="form-group">
<label> Update pdf </label><br>
 <?php if($resource['files'] ) { 
                          echo $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',COURSE_RESOURCE.$resource['files'],['escape'=>false,'style'=>'font-size:25px;','target'=>'_blank']) ;
                  } ?><br>
                  <?= $this->Form->input('pdf',['type'=>'File','label'=>'PDF','accept'=>'application/pdf']) ?>
</div>
<div class="form-group">
<label> Global  Resource</label><br>
<?= $this->Form->checkbox('is_global',['class'=>'','label'=>'Global']) ?>
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



 