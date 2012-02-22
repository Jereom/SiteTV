<?php 
header('content-type: application/json; charset=utf-8'); 
    function ownedTVcheck() {

        $xml = simplexml_load_file($_GET["feed"]);

        foreach ( $xml->liveEvent as $liveEvent )
        {

            $isLive = (string) $liveEvent->isLive;
            $liveViewers = (int) $liveEvent->liveViewers;
            $liveDuration = (int) $liveEvent->liveDuration;

        }

        $liveTab = array('isLive' => $isLive, 'liveViewers' => $liveViewers, 'liveDuration' => $liveDuration);

        return $liveTab;

    }
    
    $infosStream = ownedTVcheck();
    echo '{liveViewers:'. $infosStream['liveViewers'].', isLive:'.$infosStream['isLive'].'}';
    
?>