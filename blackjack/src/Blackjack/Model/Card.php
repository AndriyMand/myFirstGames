<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Model;

/**
 * Description of Card
 *
 * @author Admin
 */
class Card
{
    private $value;
    private $point;
    private $suit;
    
    public function __construct($value, $point, $suit)
    {
        $this->value = $value;
        $this->point = $point;
        $this->suit  = $suit;
    }

    public function __get($val) {
        return $this->{$val};
    }
}