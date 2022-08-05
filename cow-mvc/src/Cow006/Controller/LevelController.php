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
class LevelController extends AbstractController
{
    public function indexAction()
    {
        if (isset($_SESSION)) {
            session_destroy();
        }
        
        $this->view()->levels = $this->dataBase->selectAll('level', ['name'], 'enabled = 1', '`size` ASC');
    }
}