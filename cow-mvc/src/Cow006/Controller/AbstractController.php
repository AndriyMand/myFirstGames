<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Controller;

/**
 * Description of Level
 *
 * @author astolbovyi
 */
class AbstractController
{

    /**
     * @var \Cow006\View\View 
     */
    private $view;

    /**
     * @var array 
     */
    private $config;

    /**
     * @var string 
     */
    private $action;

    /**
     * Dispatch
     * 
     * @param string $action
     * @param array $config
     */
    public function dispatch($action, $config)
    {
        // init
        $this->config = $config;
        $this->action = strtolower($action);
        $this->initView();

        // Call action
        $this->{(method_exists($this, $action . 'Action') ? $action : 'notFound') . 'Action'}();

        return $this->view();
    }

    public function notFoundAction()
    {
        $this->view()->setTemplate('404');
    }

    public function indexAction()
    {
        $this->view()->setTemplate('index');
    }

    protected function initView()
    {
        $info       = explode('\\', get_class($this));
        $controller = strtolower(preg_replace('/Controller$/', '', end($info)));
        $this->view = new \Cow006\View\View(
            getcwd() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR, 'layout', "$controller\\{$this->action}", $this->config()['url']['base']
        );
    }

    protected function view()
    {
        return $this->view;
    }

    protected function config()
    {
        return $this->config;
    }

}