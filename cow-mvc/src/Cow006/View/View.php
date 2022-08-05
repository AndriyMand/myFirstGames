<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\View;

/**
 * Description of View
 *
 * @author astolbovyi
 */
class View
{
    private $folder;
    private $layout;
    private $template;
    private $content;
    private $response;
    private $baseUrl;
    
    public function __construct($folder, $layout, $template, $baseUrl = '')
    {
        $this->folder  = $folder;
        $this->baseUrl = $baseUrl;
        $this->setLayout($layout)->setTemplate($template);
    }

    public function setLayout($layout)
    {
        $this->layout = $this->folder . $layout . '.phtml';
        return $this;
    }
    
    public function setTemplate($template)
    {
        $this->template = $this->folder . $template . '.phtml';
        return $this;
    }
    
    private function renderTemplate()
    {
        ob_start();
        include $this->template;
        $this->content = ob_get_contents();
        ob_end_clean();
        return $this;
    }
    
    private function renderLayout()
    {
        ob_start();
        include $this->layout;
        $this->response = ob_get_contents();
        ob_end_clean();
        return $this;
    }
    
    public function __toString()
    {
        return $this->renderTemplate()->renderLayout()->response;
    }
    
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }
    
    public function __isset($name)
    {
        return property_exists($this, $name);
    }
    
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }
    }
}