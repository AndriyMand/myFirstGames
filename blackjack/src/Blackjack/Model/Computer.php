<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Model;

/**
 * Description of Computer
 *
 * @author Andriy
 */
class Computer extends Player
{
    protected $name = 'Computer';

    public function oneMore($deck)
    {
        $maxPoint = Game::GOAL_POINTS - $this->points;

        $countCurrentCard = Game::COUNT_OF_DECKS * Game::COUNT_CARD_SUITS;

        $countAllowedCards = 0;
        foreach ($deck->getSuitCards() as $name => $points) {
            if($points <= $maxPoint) {
                $countAllowedCards++;
            }
        }
        $countAllowedCards *= $countCurrentCard;
        
        foreach ($this->cards as $i => $card) {
            if($card->point <= $maxPoint) {
                $countAllowedCards--;
            }
        }

        $possibility = $countAllowedCards / (Game::COUNT_DECK_CARDS * Game::COUNT_OF_DECKS - count($this->cards));
         
        if ($possibility > 0.7) {
            return true;
        }
    }

}