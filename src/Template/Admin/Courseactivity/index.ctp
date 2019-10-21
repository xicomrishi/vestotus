
<style>
	#editlearner{ display: none; }
	.courseactivityuser{ width:50%; float:left; }
	.courseactivityuser1{ width:50%; float:left; }
	.courseactivityuser1 a{ padding:5px;  }
</style>

<script>
function showlearner(id)
{
	$("#editlearner"+id).toggle();
}

function showmanager(id)
{
	$("#editmanager"+id).toggle();
}
</script>
<?php
	echo '<table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >';
		echo '<thead>';
			echo '<tr role="row">';
				echo '<th>SN</th>';
				echo '<th>Learner</th>';
				echo '<th>Manager</th>';
				echo '<th>Assigned on</th>';
				//echo '<th>Chapters and status</th>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		if(!empty($enrollments))
		{
			$i=1;
			foreach($enrollments as $enrollment)
			{
				//print_r($enrollment);
				echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td><div class="courseactivityuser"><a href="javascript:void(0)" onclick="showlearner('.$enrollment['user']['id'].')">'.$enrollment['user']['fname'].' '. $enrollment['user']['lname'].'</a> </div>   <div  class="courseactivityuser1" id="editlearner'.$enrollment['user']['id'].'" style="display:none; width:50%; float:left;">'.

					$this->Html->link('View', array('controller' => 'Users','action' => 'index',), array(
								        'target'=>'_blank', 
								        'escape' => false
								    )).
					$this->Html->link('Manage', array('controller' => 'Users','action' => 'update_learner', $enrollment['user']['id']), array(
								        'target'=>'_blank', 
								        'escape' => false
								    )).
					'</div></td>';

					echo '<td>
							<div class="courseactivityuser"><a href="javascript:void(0)" onclick="showmanager('.$enrollment['user']['id'].')">'.$enrollment['manager']['fname'].' '. $enrollment['manager']['lname'].'</a>
							</div>
							<div id="editmanager'.$enrollment['user']['id'].'" class="courseactivityuser1"  style="display:none;">'.

								$this->Html->link('View', array('controller' => 'Users','action' => 'index', 'manager'), array(
							        'target'=>'_blank', 
							        'escape' => false
							    )).
								$this->Html->link('Manage', array('controller' => 'Users','action' => 'update', $enrollment['manager']['id']), array(
							        'target'=>'_blank', 
							        'escape' => false
							    )).
							'</div></td>';

					// echo '<td><a href="users/update_learner/'.$enrollment['user']['id'].'" target="_blank">'.$enrollment['user']['fname'].' '. $enrollment['user']['lname'].'</a></td>';
					// echo '<td><a href="users/update/'.$enrollment['manager']['id'].'" target="_blank">'.$enrollment['manager']['fname'].' '. $enrollment['manager']['lname'].'</td>';

					echo '<td>'.date('M d, Y', strtotime($enrollment['created'])).'</td>';
					//echo '<td></td>';
				echo '</tr>';
				$i++;
			}
		}
		else
		{
			echo '<tr colspan="5">';
				echo '<td>No activity found</td>';
			echo '</tr>';
		}

		echo '</tbody>';
	echo '</table';
?>