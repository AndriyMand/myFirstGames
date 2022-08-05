<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Model;

/**
 * Description of Deck
 *
 * @author Andriy
 */
class Deck
{
    private $cards;

    const COUNT_DECK_CARDS = 104;

    public function __construct($cardsCount = self::COUNT_DECK_CARDS)
    {
        for ($i = 1; $i <= $cardsCount; $i++) {
            $this->cards[] = [
                'v' => $i,
                'p' => $this->getCardPoints($i)
            ];
        }
        
        shuffle($this->cards);
    }

    /**
     * Remove cards form deck and return removed cards
     * 
     * @param int $count - count of cards to distribute
     * @return array
     */
    public function getCards($count)
    {
        return array_splice($this->cards, 0, $count);
    }
    
    private function getCardPoints($value)
    {
        if ($value == 55) {
            return 7;
        }
        
        if ($value % 11 == 0) {
            return 5;
        }
        
        if ($value % 10 == 0) {
            return 3;
        }
        
        if ($value % 5 == 0) {
            return 2;
        }
        
        return 1;
    }
}