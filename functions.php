<?php
$sqltxt_newid = 'INSERT INTO SEQ_S5EVENT(SEQ_DUMMY) VALUES(0); SELECT SCOPE_IDENTITY() newid';
$sqltxt_wo = 'INSERT INTO r5events(
EVT_CODE, EVT_DESC, 
EVT_WORKADDRESS,
EVT_UDFCHAR01, EVT_UDFCHAR02, EVT_UDFCHAR03,
EVT_SRQCALLNAME, 
EVT_PHONE, EVT_EMAIL,
EVT_TARGET, EVT_SCHEDEND, EVT_UDFDATE01, EVT_TFPROMISEDATE,
EVT_TYPE, EVT_RTYPE, 
EVT_DATE, EVT_REPORTED, EVT_CREATED, EVT_CREATEDBY, EVT_ENTEREDBY,
EVT_STATUS, EVT_RSTATUS,
EVT_MRC, 
EVT_OBTYPE, EVT_OBRTYPE, EVT_OBJECT,  EVT_OBJECT_ORG,
EVT_CLASS, EVT_CLASS_ORG, 
EVT_JOBTYPE, 
EVT_PRIORITY, 
EVT_ORG,
EVT_DURATION
) VALUES(
?, ?, 
?,
?, ?, ?,
?, 
?, ?,
?, ?, ?, ?,
\'JOB\', \'JOB\', 
GETDATE(), GETDATE(), GETDATE(), \'R5\', \'R5\',
?, ?,
?, 
\'A\', \'A\', ?,  ?,
?, ?, 
?, 
?, 
?,
1
)';

function andrwo_get_connection() {
	global $config;
	$conn = sqlsrv_connect($config['dbserver'], array(
		'UID' => $config['dbuser'],
		'PWD' => $config['dbpassword'],
		'Database' => $config['dbname'],
	));
	return $conn;
}

function andrwo_shutdown_connection($conn) {
	sqlsrv_close($conn);
}

function andrwo_get_new_wo_id($conn) {
	global $sqltxt_newid;
	$q = sqlsrv_query($conn, $sqltxt_newid);
	if (sqlsrv_next_result($q)) echo 'Got next';
//	$num_rows = sqlsrv_num_rows($q); //num rows func needs a different cursor type
//	if ($num_rows!=1) {
//		echo "Row cnt for new id is $num_rows. ";
//		die( print_r( sqlsrv_errors(), true));
//	}
	$retval = -1;
	if (!$q) die( print_r( sqlsrv_errors(), true));
	if ($row = sqlsrv_fetch_array($q)) {
		$retval = $row['newid'];
	} else {
		echo 'No WO ID';		
	}
	return $retval;
}

function andrwo_put_wo($conn, $evt) {
	global $sqltxt_wo;
	sqlsrv_query($conn, $sqltxt_wo, array(
		$evt['code'], $evt['desc'], 
		$evt['workaddress'],
		$evt['udfchar01'], $evt['udfchar02'], $evt['udfchar03'],
		$evt['srqcallname'], 
		$evt['phone'], $evt['email'],
		$evt['target'], $evt['schedend'], $evt['udfdate01'], 
		$evt['tfpromisedate'],
		$evt['status'], $evt['rstatus'],
		$evt['mrc'], 
		$evt['object'], $evt['object_org'],
		$evt['class'], $evt['class_org'], 
		$evt['jobtype'], 
		$evt['priority'], 
		$evt['org'],
	));
}

function andrwo_get_date($conn) {
	$q = sqlsrv_query($conn, 'SELECT GETDATE() dt');
	$row = sqlsrv_fetch_array($q);
	return $row['dt'];
}
