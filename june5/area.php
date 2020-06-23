<?php
class area {
  public $height;
  public $width;
  public $area;
  function __construct($height,$width) {
    $this->name = $height*$width; 
  }
  function get_area() {
    return $this->name;
  }
}
$areas = new area(15,15);
echo $areas->get_area();
?>