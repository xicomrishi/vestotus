 <div id="main">
            <div class="visible-md visible-xs visible-sm mobile-menu">
                <button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
            </div>

            <section class="bgw clearfix course-detail-master">           	
			        
			         <div class="page-title bgg">
			            <div class="container-fluid clearfix">
			                <div class="title-area pull-left">
			                    <h2>Add New Learners <small>Welcome to the our course single page</small></h2>
			                </div><!-- /.pull-right -->
			                <div class="pull-right hidden-xs">
			                    <div class="bread">
			                        <ol class="breadcrumb">
			                            <li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
			                            <li ><a href="<?= BASEURL?>learners/">Learners</a></li>
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
					                                    <span>Basic Profile</span>
					                                </h2>
					                            </div><!-- end big-title -->
<div class="loginform learners-form">
<?= $this->Form->create($user,['class'=>'row']) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="col-md-12">
<div class="form-group">
<?= $this->Form->input('fname',['label'=>'First Name','class'=>'form-control','placeholder'=>'First Name']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('lname',['label'=>'Last Name','class'=>'form-control','placeholder'=>'Last Name']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('username',['label'=>'Username','class'=>'form-control','placeholder'=>'Username']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('email',['label'=>'Email','class'=>'form-control','placeholder'=>'Email']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('password',['value'=>'','label'=>'Password','required'=>false,'class'=>'form-control','placeholder'=>'Password']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('confirm_password',['value'=>'','label'=>'Confirm Password','required'=>false,'class'=>'form-control','placeholder'=>'Confirm Password']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('street',['label'=>'Address','class'=>'form-control','placeholder'=>'Street']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('city',['label'=>'City','class'=>'form-control','placeholder'=>'City']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('zip',['label'=>'Postal Code','class'=>'form-control','placeholder'=>'Postal Code']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('state',['label'=>'State','class'=>'form-control','placeholder'=>'State']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('country',['label'=>'Country','class'=>'form-control','placeholder'=>'Country']) ?>
</div> 
<div class="form-group">
<?= $this->Form->input('department_id',['label'=>'Department','class'=>'form-control','empty'=>'Select Department','options'=>$deplist]) ?>
</div> 
<div class="clear"> </div>


<div class="big-title">
<h2 class="related-title">
<span>Insurance Carrier</span>
</h2>
</div><!-- end big-title -->
<div class="form-group">
<?= $this->Form->input('learner.insurance_carrier',['label'=>'Insurance Carrier','class'=>'form-control','placeholder'=>'Insurance Carrier']) ?>
</div> 
<div class="form-group">
<label> Renewal date </label>
<div class='input-group date' id='datetimepicker1'>
<?= $this->Form->input('learner.renewal_date',['type'=>'text','class'=>'form-control date-set','label'=>false]) ?>
<span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
</div>
<div class="clear">&nbsp; </div>
<div class="form-group">
<div class="col-md-4">
<?= $this->Form->input('learner.no_of_vehicle',['label'=>'Number of Vehicles','class'=>'form-control','escape'=>false]) ?>
</div>

<div class="col-md-4">
<?= $this->Form->input('learner.vehicle_type',['options'=>['Taxi'=>'Taxi','Limo'=>'Limo','Bus'=>'Bus'],'empty'=>'Select','label'=>'Vehicle Type','class'=>'form-control']) ?>
</div>				                                    		

<div class="col-md-4">
<?= $this->Form->input('learner.no_of_passengers',['label'=>'Occupancy','class'=>'form-control','placeholder'=>'No. of Passengers']) ?>
</div>
</div> 

<div class="form-group">
<?= $this->Form->input('learner.no_of_drivers',['class'=>'form-control','label'=>'Number of Drivers','placeholder'=>'Number of Drivers']) ?>
</div>

<div class="clear"> &nbsp; </div>

<div class="big-title">
<h2 class="related-title">
<span>Company Details</span>
</h2>
</div><!-- end big-title -->

<div class="form-group">
<?= $this->Form->input('learner.company_name',['class'=>'form-control','label'=>'Company Name','placeholder'=>'Company Name']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('learner.contact_person',['label'=>'Contact Person','placeholder'=>'Contact Person','class'=>'form-control']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('learner.contact_number',['label'=>'Contact Number','placeholder'=>'Contact Number','class'=>'form-control']) ?>
</div>
<div class="form-group">
<?= $this->Form->input('learner.company_identifier',['label'=>'Contact Identifier','placeholder'=>'Contact Identifier','class'=>'form-control']) ?>
</div>
<div class="form-group">
<label> Company Address </label>
<?= $this->Form->textarea('learner.company_address',['placeholder'=>'Company Address','class'=>'form-control']) ?>
</div>


<div class="clear"> &nbsp; </div>

<div class="big-title">
<h2 class="related-title">
<span>SAFETY MANAGER</span>
</h2>
</div><!-- end big-title -->

<div class="form-group">
<?= $this->Form->input('learner.sm_email',['placeholder'=>'Safety Manager Email','class'=>'form-control','label'=>'Safety Manager Email']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.sm_title',['placeholder'=>'Safety Manager Title','class'=>'form-control','label'=>'Safety Manager Title']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.sm_company_name',['placeholder'=>'Company Name','class'=>'form-control','label'=>'Company Name']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.sm_phone',['placeholder'=>'Phone','class'=>'form-control','label'=>'Phone']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.sm_mobile',['placeholder'=>'Mobile','class'=>'form-control','label'=>'Mobile']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.sm_driver_licence_no',['placeholder'=>'Driver Licence No.','class'=>'form-control','label'=>'Driver Licence No.']) ?>
</div>

<div class="form-group">
<label> Expiry date </label>
<div class='input-group date' id='datetimepicker1'>
<?= $this->Form->input('learner.sm_expiry_date',['type'=>'text','placeholder'=>'Expiry Date','class'=>'form-control date-set','label'=>false]) ?>
<span class="input-group-addon">
<span class="glyphicon glyphicon-calendar"></span>
</span>
</div>

</div>

<div class="form-group">
<?= $this->Form->input('learner.education_level',['placeholder'=>'Education Level','class'=>'form-control','label'=>'Education Level']) ?>
</div>

<div class="form-group">
<?= $this->Form->input('learner.relavant_certification',['placeholder'=>'Relavant Certification','class'=>'form-control','label'=>'Relavant Certification']) ?>
</div>

<?= $this->Form->submit('SEND',['class'=>'button button--wayra btn-block btn-square btn-lg']) ?>

</div>
</form> 
</div>
</div>
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->


<section class="section bgw">
</section>

 