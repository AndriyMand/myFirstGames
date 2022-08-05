<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Model;

/**
 * Description of Player
 *
 * @author Andriy
 */
class Player
{
    use GetCardsTrait;

    protected $name     = '';
    protected $ready    = false;
    protected $cards    = [];
    protected $points   = 0;
    private $aceCount   = 0;

    public function __construct($name = null)
    {
        $this->name = empty($name) ? $this->name : $name;
    }

    public function takeCard(Card $card)
    {
        $this->cards[] = $card;
        $this->points += $card->point;
        
        // calc count of 'A'
        if($card->point == 'A') {
            $this->aceCount++;
        }

        // if greater 21 than use 1 instead 11
        if ($this->points > Game::GOAL_POINTS && $this->aceCount) {
            $this->points -= 10;
            $this->aceCount--;
        }
    }

    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
    }
}