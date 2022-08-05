<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Model;

/**
 * Description of Deck
 *
 * @author Andriy
 */
class Deck
{
    private $cards = [];
    private $suit  = [
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
        'A' => 11,
    ];

    public function __construct()
    {
        // fill deck
        for ($i = 0; $i < Game::COUNT_OF_DECKS; $i++) {
            $deck = [];
            for ($s = 1; $s <= Game::COUNT_CARD_SUITS; $s++) {
                foreach ($this->suit as $name => $points) {
                    $deck[] = new Card($name, $points, $s);
                }
            }
            $this->cards = array_merge($deck, $this->cards);
        }

        shuffle($this->cards);
    }

    public function getCard()
    {
        return array_pop($this->cards);
    }

    public function getSuitCards()
    {
        return $this->suit;
    }
}