<?php
include 'config.php';
include 'functions.php';

$conn = andrwo_get_connection();

//print_r(andrwo_get_date($conn));
//exit(0);

$evt_code = andrwo_get_new_wo_id($conn);

header('Content-Type: application/json');

//if ($evt_code==-1) {
//	echo json_encode('No new work order ID alert');
//	exit(-1);
//}

move_uploaded_file($_FILES['bmp']['tmp_name'], $evt_code.'.png');

$evt = array(
'code' => $evt_code, 
'desc' => $_POST['probDesc'], 
'workaddress' => $_POST['loc'],
'udfchar01' => NULL, 
'udfchar02' => NULL, 
'udfchar03' => NULL, 
'srqcallname' => NULL, 
'phone' => NULL, 
'email' => NULL, 
'target' => NULL, 
'schedend' => NULL, 
'udfdate01' => NULL, 
'tfpromisedate' => NULL, 
'status' => $config['evtstatus'], 'rstatus' => $config['evtrstatus'],
'mrc' => $config['evtmrc'], 
'object' => $config['evtobject'], 'object_org' => $config['evtobjectorg'],
'class' => $config['evtclass'], 'class_org' => $config['evtclassorg'], 
'jobtype' => $config['evtjobtype'], 
'priority' => $config['evtpriority'], 
'org' => $config['evtorg'],
);

andrwo_put_wo($conn, $evt);

andrwo_shutdown_connection($conn);

echo json_encode('Done');
exit(0);