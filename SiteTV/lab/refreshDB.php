<?php
require_once 'Dailymotion.php';

function refreshDM(){
    
   $streams = mysql_query('SELECT * FROM es_stream WHERE type="dm"');
    
   while ($donnees = mysql_fetch_assoc($streams))
   {
      if($donnees['type'] == 'dm'){
         $apiDM = new Dailymotion();
         $result = $apiDM->call('/video/'.$donnees['idstream'],
         array('fields' => array('onair', 'title', 'mode')));

         $oa = 0;
         if($result['onair']){
            $oa = 1;
         }

         $req = "UPDATE es_stream i SET i.onair='".$oa."' WHERE i.idstream='".$donnees['idstream']."'";
         tryquery($req);
         $req = "UPDATE es_stream i SET i.title='".$result['title']."' WHERE i.idstream='".$donnees['idstream']."'";
         tryquery($req);

         $donnees['title'] =  $result['title'];
         $donnees['onair'] = $oa;
      }
   }
}


?>