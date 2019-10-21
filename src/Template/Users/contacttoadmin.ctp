<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>

<section class="bgw clearfix course-detail-master">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Help & Support </h2>
</div>
<!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li class="active">Help & Support</li>
</ol>
</div>
<!-- end bread -->
</div>
<!-- /.pull-right -->
</div>
</div>
<!-- end page-title -->

<section class="section bgw">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12">

<div class="tab-first">

<?= $this->Form->create($support,['role'=>'form']) ?>
<?php $this->Form->templates($form_templates['frontForm']); ?>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="tab1">
<div class="tab-padding clearfix">
<div class="loginform general-form">
<div class="form-group col-md-6">
<?= $this->Form->input('fname',['class'=>'form-control','label'=>'First Name','value'=>$this->request->session()->read('Auth.User.fname'),'required'=>true]) ?>
</div>
<div class="form-group col-md-6">
<?= $this->Form->input('lname',['class'=>'form-control','label'=>'Last Name','value'=>$this->request->session()->read('Auth.User.lname'),'required'=>true]) ?>
</div>

<div class="form-group col-md-6">
<?= $this->Form->input('email',['class'=>'form-control','label'=>'Email','readonly'=>'readonly','value'=>$this->request->session()->read('Auth.User.email')]) ?>
</div>

<div class="form-group col-md-6">
<?= $this->Form->input('phone',['class'=>'form-control','label'=>'Phone','readonly'=>'readonly','value'=>$this->request->session()->read('Auth.User.phone'),'required'=>true]) ?>
</div>



<div class="form-group col-md-12">
<?= $this->Form->textarea('message',['class'=>'form-control','placeholder'=>'Message','value'=>'','required'=>true]) ?>
</div>



&nbsp; 
<?= $this->Form->button('Save',['class'=>'btn btn-primary btn-square']) ?>
</div>

</div>

</div>


<?= $this->Form->end() ?>

</div>
</div>
</div>
</div>
<!-- end col -->
</div>
<!-- end row -->
</div>
<!-- end container -->
</section>
<!-- end section -->
</section>
<!-- end section -->

<?= $this->Html->script('isotope.js'); ?>
<?= $this->Html->script('imagesloaded.pkgd.js'); ?>
<?= $this->Html->script('masonry-home-01.js'); ?>

