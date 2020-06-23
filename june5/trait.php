<?php
class log
{
 public function Write($strFileName, $strData)
 {
  if(!is_Writable($strFileName))
  die('Chance your CHMOD permission to'. $strFileName);
 
  $handle=fopen($strFileName, 'a+');
 
  fwrite($handle, "\r". $strData);
  fclose($handle);
  }
  public function Read($strFileName)
  {
   $handle=fopen($strFileName, 'r');
   return file_get_contents($strFileName);
   }
}