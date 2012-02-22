<?php
$db = mysql_connect('sql.free.fr', 'jereom', 'jereom$1');  // 1
mysql_select_db('jereom',$db);


function mysql_insert($table, $inserts) {
   $values = array_map('mysql_real_escape_string', array_values($inserts));
   $keys = array_keys($inserts);

   $req = 'INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')';
    
   return  tryquery($req);
}

function mysql_update_infos($key, $value) {
   $req = "UPDATE es_infos i SET i.value='".$value."' WHERE i.key='".$key."'";
   return  mysql_update('es_infos',$key, $value);
}
function mysql_update($table, $key, $value) {
   $req = "UPDATE ".$table." i SET i.value='".$value."' WHERE i.key='".$key."'";
   return  tryquery($req);
}
function tryquery($req) {
   $rep=mysql_query($req);
   if(!$rep) {
      $message  = 'Requ�te invalide : ' . mysql_error() . "\n";
      $message .= 'Requ�te compl�te : ' . $req;
      die($message);
   }
   return $rep;
}

?>