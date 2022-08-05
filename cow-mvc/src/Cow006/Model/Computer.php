<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Model;

/**
 * Description of Computer
 *
 * @author Andriy
 */
class Computer extends Player
{
    protected $name = 'Computer';

    public function makeChoice()
    {
        return $this->takeCard(rand(0, $this->countOfCards() - 1));
    }
}