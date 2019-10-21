<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>

<section class="bgw clearfix course-detail-master">           	

<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Enrollment Keys<small></small></h2>
</div><!-- /.pull-right -->



<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li class="active"><a href="<?= BASEURL?>Enrollment Keys/">Enrollment Keys</a></li>

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
<span>Enrollment Keys</span>
</h2>
</div><!-- end big-title -->

<table class="table">
<thead>
<tr>

<th>Name </th>
<th>Key  </th>
<th>Department  </th>
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
<td><?= $list['department']['title'] ?><?php if($list['subdepartment_id'] ) { echo " / ".$list['sub_department']['title'];} ?></td>
<td><?= $list['max_uses'] ?></td>
<td> <?= $list['times_used'] ?></td>
<td>
<?php $expc = explode(',',$list['courses']);
	echo count($expc);
?> 
</td>
<td> 
<?= $this->Html->link('<i class="fa fa-share" aria-hidden="true"></i>','javascript:void(0);',['class'=>'sharekeybutton','escape'=>false,'id'=>$list['id']]) ?>
  
</tr>
<?php } } else { ?>
	<tr> <td colspan="6"> No Records Found! </td></tr>
	<?php } ?>
</tbody>
</table>


<?= $this->element('paginator'). $this->element('modal_chapter');
 ?>
</div><!-- end course-table -->			
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->
</div>
</div><!-- end main -->

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
			//$('#loader').show();
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
<style>
.modal-backdrop.in{opacity: 0}
</style>