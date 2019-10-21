<?php
	if($course)
	{
		echo $this->Html->link(
		    'View Activity Report',
		    'javascript:void(0)',
		    ['class' => 'btn btn-default coursereportactivties', 'id'=>'activity'.$course['id'], 'onclick'=>'doaction("activity'.$course['id'].'")']
		);

		echo $this->Html->link(
		    'Course Enrollment',
		    'javascript:void(0)',
		    ['class' => 'btn btn-default coursereportactivties', 'id'=>'enrollment'.$course['id'], 'onclick'=>'doaction("enrollment'.$course['id'].'")']
		);

		if($course['type']==1)
		{
			echo $this->Html->link(
			    'Edit',
			    ['controller'=>'Courses', 'action'=>'update', $this->Common->myencode($course['id'])],
			    ['class' => 'btn btn-default coursereportactivties', 'target', '_blank']
			);
		}
		else
		{
			echo $this->Html->link(
			    'Edit',
			    ['controller'=>'Courses', 'action'=>'instructor_course', $this->Common->myencode($course['id'])],
			    ['class' => 'btn btn-default coursereportactivties', 'target', '_blank']
			);
		}

		echo $this->Html->link(
		    'Deselect',
		    'javascript:void(0)',
		    ['class' => 'btn btn-default coursereportactivties', 'id'=>'deselectcourse'.$course['id'], 'onclick'=>'doaction("deselectcourse'.$course['id'].'")']
		);

		echo $this->Html->link(
		    'Enroll Users',
		    'javascript:void(0)',
		    ['class' => 'btn btn-default coursereportactivties', 'id'=>'enrolluser'.$course['id'], 'onclick'=>'doaction("enrolluser'.$course['id'].'")']
		);


		echo $this->Html->link(
		    'Delete',
		    'javascript:void(0)',
		    ['class' => 'btn btn-default coursereportactivties', 'id'=>'deletecourse'.$course['id'], 'onclick'=>'doaction("deletecourse'.$course['id'].'")']
		);


		
	}
?>