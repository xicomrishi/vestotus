<?php
	$line= $orders[0]['Order'];
	$csv->addRow(array_keys($line));
	foreach ($orders as $order){
	  $line = $order['Order'];
	  $csv->addRow($line);
	}
	$filename='orders';
	echo $csv->render($filename);
  ?>