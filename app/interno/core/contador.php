<?php
    
   global $time;
    
   function getTime(){
      return microtime(TRUE);
   }
    
   function startExec(){
      global $time;
      $time = getTime();
   }
    
   function endExec(){
      global $time;      
      $finalTime = getTime();
      $execTime = $finalTime - $time;
      return $execTime;
   }
    
?>