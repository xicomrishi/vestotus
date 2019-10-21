<?php
	echo '<table id="datatable-buttons" class="table table-striped table-bordered dataTable no-footer dtr-inline" role="grid" >';
		echo '<thead>';
			echo '<tr role="row">';
				echo '<th>SN</th>';
				echo '<th>User</th>';
				echo '<th>Owner</th>';
				echo '<th>Assigned on</th>';
				echo '<th>Enroll method</th>';
				//echo '<th>Chapters and status</th>';
			echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
			$i=1;
			foreach($enrollments as $enroll)
			{
				echo '<td>'.$i.'</td>';
				echo '<td>'. $enroll['users']['fname'] . ' ' . $enroll['users']['fname']. '</td>';
				echo '<td>'.$enroll['owner'].'</td>';
				echo '<td>'.date('d M, Y', strtotime($enroll['created']).'</td>';
				echo '<td>'.$enroll['enroll_method'].'</td>';
				$i++;
			}
	echo '</tbody>';
	echo '</table';
?>