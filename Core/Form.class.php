<?php
class Form
{
    private $data;

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function surround($html, $surround = 'p', $class = null)
    {
        return "<{$surround} class=\"$class\";>{$html}</{$surround}>";
    } 

    public function input($name, $label, $options = [], $htmlclass = "form-control", $require = 'true')
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $label = '<label>' . $label . '</label>';
        $input = '<input class="' . $htmlclass . '" type="' . $type . '" name="' . $name . '" required=' . $require . '>';
        return $this->surround($label . $input);
    }

    public function submit($name, $value = null, $htmlclass = null)
    {
        return $this->surround('<input type="submit" name="' . $name . '" value="' . $value . '" class="' . $htmlclass . '">');
    }

    public function img($src, $className = null, $alt = null)
    {
        $img = '<img src="' . $src . '" class="' . $className . '"';
        if (isset($alt) && !empty($alt))
            $img .= 'alt="' . $alt . '"';
        $img .= '>';
        return $this->surround($img);
    }

}
