<?php
	if(!empty($learners)  && !empty($course))
	{
		echo $this->Form->create('deletecourse');
		echo '<div class="row" style="margin-top:25px;">';
			echo '<div class="col-lg-12">';
				echo '<div class="col-lg-2">';
					echo 'Course Name';
				echo '</div>';

				echo '<div class="col-lg-4">';

					echo $this->Form->text('coursename', array('id'=>'name', 'class'=>'form-control','readonly'=>'readonly', 'value'=>$course['title']));

					echo $this->Form->text('course_id', array('id'=>'course_id', 'class'=>'form-control','readonly'=>'readonly', 'value'=>$course['id'], 'type'=>'hidden'));

				echo '</div>';
				
			echo '</div>';

			echo '<div class="col-lg-12">';
				echo '&nbsp;';
				
			echo '</div>';

			echo '<div class="col-lg-12">';
				echo '<div class="col-lg-2">';
					echo 'Enrolled Users';
				echo '</div>';

				echo '<div class="col-lg-4">';
					?>
						<select class="form-control" id="learner" name='learner'>
							<option value="">Select User</option>
							<?php
								foreach($learners as $learner)
								{
									?>
										<option value="<?php echo $learner['id'].','.$learner['user_id'] ?>"><?php echo $learner['user']['fname'].' '.$learner['user']['lname'] ?></option>
									<?php
								}
							?>
						</select>
					<?php
				echo '</div>';
				
			echo '</div>';

			echo '<div class="col-lg-12">';
				echo '&nbsp;';
				
			echo '</div>';

			echo '<div class="col-lg-12">';
				echo '<div class="col-lg-2">';
					echo '&nbsp;';
				echo '</div>';

				echo '<div class="col-lg-4">';
					?>
						<input type="button" class="btn btn-default" name="deleteenrollment" value="Delete course from learner" onclick="deletecoursefromlearner()">
					<?php
				echo '</div>';
				
			echo '</div>';



		echo '</div>';

		echo $this->Form->end();
	}
?>



<script>
function deletecoursefromlearner()
{
	var course_id=$("#course_id").val();
	var learner=$("#learner").val();
	if(learner!='')
	{
		$.ajax({
	        type: 'POST',
	        url: siteUrl+'admin/courseactivity/deletecourse',
	        data: { 
	            'course_id': course_id,
	            'learner': learner
	        },
	        success: function(msg){
	            $(".coursereportnavresults").html(msg);
	        }
	    });
	}
	else
	{
		alert("Please select user to delete from course");
	}
}
</script>