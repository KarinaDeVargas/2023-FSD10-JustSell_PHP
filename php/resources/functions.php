<?php

function IsEmpty($array, $key){

//if ( !array_key_exists('txtTitle', $_POST) || $_POST['txtTitle'] == ""){
  if (!array_key_exists($key, $array) || $array[$key] ==  ""){
    return true; 
  } else 
  return false;

}

?>