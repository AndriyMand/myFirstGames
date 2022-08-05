<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Model;

/**
 *
 * @author Andriy
 */
trait GetCardsTrait
{
    public function getCard()
    {
        return $this->cards;
    }
}