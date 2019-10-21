<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>

<section class="bgw clearfix course-detail-master">           	

<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2><!-- Courses  -->Resources<small></small></h2>
</div><!-- /.pull-right -->



<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li class="active"><a href="<?= BASEURL?>Resources/">Resources</a></li>

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

<!-- <div class="big-title">
<h2 class="related-title">
<span>Resources</span>
</h2>
</div> -->
<!-- end big-title -->
<?= $this->Html->link('Add Resource',['controller'=>'Resources','action'=>'form'],['class'=>'btn btn-primary btn-square']) ?>
<br><br>
<table class="table">
<thead>
<tr>
<th> <i class="fa fa-list-ul" aria-hidden="true"></i> </th>
<th>Title</th>
<th style="width: 25%;"> Course </th>
<th style="width: 25%;"> File </th>

<th>Modified Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if(count(@$list)>0) {
	$i = 1; 
	foreach ($list as $list) {
?>
<tr>
<td> <?= $i ?> </td>
<td>
<?= $list['name'] ?>
</td>

<td> 
<?= ucfirst($list['course']['title']) ?>

</td>
<td><?php if($list['files']) { echo $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',COURSE_RESOURCE.$list['files'],['escape'=>false]); } ?>

</td>
<td><?= $list['modified']->format('d M, Y') ?> </td>
<td> 
<?= $this->Html->link('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>',['action'=>'form',$this->Common->myencode($list['id'])],['class'=>'edit','escape'=>false]) ?> &nbsp;
<?= $this->Html->link('<i class="fa fa-trash-o" aria-hidden="true"></i>',['action'=>'delete',$this->Common->myencode($list['id'])],['class'=>'delete','escape'=>false,'confirm'=>'Do you really want to delete it ?']) ?>
  
</tr>
<?php $i++;} } else { ?>
	<tr> <td colspan="6"> No Records Found! </td></tr>
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