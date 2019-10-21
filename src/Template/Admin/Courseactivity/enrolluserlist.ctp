<?php
if($enrollments)
{
	echo '<table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >';
		echo '<thead>';
			echo '<tr role="row">';
				echo '<th>SN</th>';
				echo '<th>User</th>';
				echo '<th>Enroll method</th>';
				//echo '<th>Chapters and status</th>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
			$i=1;
			foreach($enrollments as $enroll)
			{
				echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'. $enroll['user']['fname'] . ' ' . $enroll['user']['lname']. '</td>';
					if($enroll['enroll_method']==1) echo '<td>Direct enrollment</td>';
					elseif($enroll['enroll_method']==2) echo '<td>Enrolled by key</td>';
					else echo '<td>Enrolled by rule of course</td>';

				echo '</tr>';
				$i++;
			}
	echo '</tbody>';
	echo '</table';
}
else
{
	echo '<table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >';
		echo '<thead>';
			echo '<tr role="row">';
				echo '<th>No enrollment assigned on this course.</th>';
			echo '</tr>';
		echo '</thead>';
		
	echo '</table';
}
?>