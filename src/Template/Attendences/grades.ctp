<div id="main">
<div class="visible-md visible-xs visible-sm mobile-menu">
<button type="button" data-toggle="offcanvas"><i class="fa fa-bars"></i></button>
</div>
<section class="bgw clearfix course-detail-master">           	
<div class="page-title bgg">
<div class="container-fluid clearfix">
<div class="title-area pull-left">
<h2>Grades <small></small></h2>
</div><!-- /.pull-right -->
<div class="pull-right hidden-xs">
<div class="bread">
<ol class="breadcrumb">
<li><a href="<?= BASEURL?>users/dashboard">Home</a></li>
<li><a href="<?= BASEURL?>courses/">Courses</a></li>
<li><a href="<?= BASEURL?>sessions/index/<?= $this->Common->myencode($session['course_id']) ?>">Sessions</a></li>
<li class="active">Grades</li>
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
<span>Manage Grades</span>
</h2>
</div><!-- end big-title -->
<?= $this->Form->create('attendence',['class'=>'','id'=>'dsds'])  ?>
<table class="attendencetable">
<tr>
<th> Learner </th>

<th> Grade A </th>
<th> Grade B </th>
<th> Grade C </th>
<th> Grade D </th>

</tr>
<?php 
$i = 1;
foreach($getusers as $user) { 

	//pr($user);exit;
?>
<tr>
<td> <?php 
echo ucfirst($user['user']['fullname']) ?></td>
		<input type="hidden"  name="attendence[<?= $i ?>][user_id]" value = "<?= $user['user']['id'] ?>">
    <td> <input type="radio" <?php if($this->Common->getGradeByUser($session['id'],$user['user']['id']) == 'A' ) { echo "checked='checked'"; } ?>  name="attendence[<?= $i ?>][grade]" value = "A" >  </td>
    <td> <input type="radio" <?php if($this->Common->getGradeByUser($session['id'],$user['user']['id']) == 'B' ) { echo "checked='checked'"; } ?>   name="attendence[<?= $i ?>][grade]" value = "B" >  </td>
    <td> <input type="radio" <?php if($this->Common->getGradeByUser($session['id'],$user['user']['id']) == 'C' ) { echo "checked='checked'"; } ?>  name="attendence[<?= $i ?>][grade]" value = "C" >  </td>
    <td> <input type="radio" <?php if($this->Common->getGradeByUser($session['id'],$user['user']['id']) == 'D' ) { echo "checked='checked'"; } ?>  name="attendence[<?= $i ?>][grade]" value = "D" >  </td>
  
</tr>
<?php  $i++;} ?>
</table>
<button type="submit" class="btn btn-primary">Update</button>
<button type="button" class="btn btn-secondary" onclick="window.location.href = '<?= BASEURL?>sessions/index/<?= $this->Common->myencode($user['course_id']) ?>'; ">Back</button>
<?= $this->Form->end() ?>
</div><!-- end course-table -->			
</div><!-- end col -->
</div><!-- end row -->

</div><!-- end container -->
</section><!-- end section -->
</section><!-- end section -->
</div>
</div><!-- end main -->
