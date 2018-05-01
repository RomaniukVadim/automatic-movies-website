<?php
  
class TGrabberWPOptions
{
    
    var $options = array();
    
    function get($name)
    {
        $name = "wpg_$name";
        return isset($this->options[$name]) ? $this->options[$name] : get_option($name);
    }
    
    function set($name, $value)
    {
        $name = "wpg_$name";
        $this->options[$name] = $value;
    }
}
