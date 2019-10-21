<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>
<section class="bgw clearfix course-detail-master">           	
<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Leaners List<small>Welcome to the our course single page</small></h2>
</div><!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li class="active">Learners</li>
</ol>
</div><!-- end bread -->
</div><!-- /.pull-right -->
</div>
</div><!-- end page-title -->
<section class="section bgw">
<div class="container-fluid">
<div class="row">			                    
<div id="post-content" class="col-md-12 col-sm-12 single-course">
<hr class="invis">
<div class="leaners-table clearfix">
<div class="big-title">
<h2 class="related-title">
<span>Learners Details</span>
</h2>
</div><!-- end big-title -->
<table class="table">
<thead>
<tr>
<th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
<th>Full Name </th>
<th style="width: 25%;">Username </th>
<th>Email Address </th>
<th>Company Name</th>
<th>Modified Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if(count($list)>0) { 
	foreach ($list as $list) {
		$rnd = rand(0,10);
?>
<tr>
<td> <input class="checkbox" type="checkbox" name="checkuser" value="<?= $list['id'] ?>"/> </td>
<td>
<a href="#"><?= $list['fullname'] ?></a>
</td>
<td> <a href="#"><?= $list['username'] ?></a> </td>
<td> 
<a href="#"><?= $list['email'] ?></a>
<!--<div class="skills text-left">
<div class="progress">
<div class="progress-bar" role="progressbar" data-transitiongoal="<?= $rnd ?>" aria-valuenow="<?= $rnd ?>" style="width: <?= $rnd ?>%;"><span><?= $rnd ?>%</span></div>
</div>
</div> -->
</td>
<td>
<?= $list['learner']['company_name'] ?>
</td>
<td><?= $list['modified']->format('d M, Y') ?> </td>
<td> 
<?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'form',$list['id']],['class'=>'edit','escape'=>false]) ?> &nbsp;
<?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'form',$list['id']],['class'=>'delete','escape'=>false]) ?>
  
</tr>
<?php } } else { ?>
	<tr> <td colspan="5"> No Records Found! </td></tr>
	<?php } ?>
</tbody>
</table>
<?= $this->element('paginator') ?>
</div><!-- end course-table -->			
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->
</div>
</div><!-- end main -->