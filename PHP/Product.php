<?php 
class Product{
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function getDescription()
    {
        return "Name: " . $this->name;
    }
}
?>