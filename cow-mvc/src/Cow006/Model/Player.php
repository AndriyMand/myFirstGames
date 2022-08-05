<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Model;

/**
 * Description of Player
 *
 * @author Andriy
 */
class Player
{
    use GetCardsTrait;

    protected $name   = '';
    protected $ready  = false;
    protected $cards  = [];
    protected $points = 0;

    public function __construct($name = null)
    {
        $this->name = empty($name) ? $this->name : $name;
    }

    public function giveCards($cards)
    {
        $this->cards = $cards;
    }

    /**
     * Take the card from player's hand
     * (return value and remove from hand)
     * 
     * @param int $num
     * @return array
     */
    protected function takeCard($num)
    {
        return current(array_splice($this->cards, (int)$num, 1));
    }

    public function countOfCards()
    {
        return count($this->cards);
    }

    public function addPoints($points)
    {
        $this->points += (int)$points;
    }

    public function __get($name)
    {
        if(isset($this->{$name})) {
            return $this->{$name};
        }
    }
}