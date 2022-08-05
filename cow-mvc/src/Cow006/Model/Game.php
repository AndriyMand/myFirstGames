<?php

namespace Cow006\Model;

class Game
{
    private $cardsOnTable;

    const POINTS_LIMIT          = 35;
    const COUNT_OF_ROWS         = 4;
    const CARDS_IN_HAND         = 10;
    const LIMIT_OF_CARDS_IN_ROW = 5;

    /**
     * Preparation for the game
     * 
     * @param \Cow006\Model\CardsOnTable $table
     */
    public function __construct(CardsOnTable $table)
    {
        $this->cardsOnTable = $table;
    }
}