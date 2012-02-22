<?php require("connect.php");?>
<?php

$idstream = $_POST['id'];
$type = $_POST['type'];
$ret = mysql_insert('es_stream', array(
    'idstream' => $idstream,
    'type' => $type,
	'onair' => '0',
));

if($ret){
	echo "<meta http-equiv=\"refresh\" content=\"0;url=chaines.php\">";
}else{
	echo 'insertion échoué : '.$idstream.' '.$type.' ' ;
}

mysql_close($db);  // 6
?>