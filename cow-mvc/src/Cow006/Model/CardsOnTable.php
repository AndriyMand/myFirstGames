<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Model;

/**
 * Description of CardsOnTable
 *
 * @author Andriy
 */
class CardsOnTable
{
    use GetCardsTrait;

    private $cards = [];

    public function __construct($cards)
    {
        for ($i = 0; $i < count($cards); $i++) {
            $this->cards[$i][] = $cards[$i];
        }
    }

    // push checked card in needed row 
    private function pushCardInRow($indexOfRow, $card)
    {
        array_push($this->cards[$indexOfRow], $card);
    }

    // remove cards from current row and return these points
    private function removeCardsFromRow($indexOfRow)
    {
        $sumOfPoints              = $this->calcSumOfPoints($this->cards[$indexOfRow]);
        $this->cards[$indexOfRow] = [];
        return $sumOfPoints;
    }

    /**
     * 
     * @param array $arr - array of cards in row
     * @return int - sum of poinrt in row
     */
    private function calcSumOfPoints($arr)
    {
        $sumPoints = 0;
        foreach ($arr as $card) {
            $sumPoints += $card['p'];
        }
        return $sumPoints;
    }

    // This function is BOSS of functions
    // if set choosed card into cards on table
    private function putCard($card)
    {
        $points = 0;
        if ($this->isCardGreaterThenCardsOnTable($card)){         // checkes if choosed card is greater than any last card in rows
            $indexOfRow = $this->indexOfNeededRow($card);         // $indexOfRow = indexs of row with the smallest different between last card in row and choosed card
            if ($this->isReachedRowLimit($indexOfRow)){           // if choosed card will be sixth card in row
                $points += $this->removeCardsFromRow($indexOfRow); // delete cards in row and set their points in var $points
            }
        } else{
            $indexOfRow = $this->chooseRow();                     // the player must to choose index of row by own
            $points     += $this->removeCardsFromRow($indexOfRow);
        }
        $this->pushCardInRow($indexOfRow, $card);                 // add choosed card to current row
        return $points;
    }
    
    public function playCards($cards)
    {
        $points = [];
        do {
            $index = $this->minCard($cards);
            $points[$index] = $this->putCard($cards[$index]);
            unset($cards[$index]);
        } while (!empty($cards));
        
        return $points;
    }
    
    private function minCard($cards)
    {
        $minKey = 0;
        $min    = current($cards)['v'];
        foreach($cards as $key => $value) {
            if($value['v'] <= $min) {
                $min = $value['v'];
                $minKey = $key;
            }
        }
        return $minKey;
    }

    // defines index of row in which we need to add choosed card
    private function indexOfNeededRow($card)
    {
        // this loop fills into value of array the different between last card in row and player`s choosed card
        for ($i = 0; $i < Game::COUNT_OF_ROWS; $i++) {
            if ($card['v'] > $this->lastCardInRow($i)['v']){
                $different[$i] = abs($this->lastCardInRow($i)['v'] - $card['v']);
            } else {
                $different[$i] = $card['v'];
            }
        }

        // return index of row with the smallest different
        return array_search(min($different), $different);
    }

    // return true if choosed card is greater than any last card in rows
    private function isCardGreaterThenCardsOnTable($card)
    {
        for ($i = 0; $i < Game::COUNT_OF_ROWS; $i++) {
            if ($card['v'] > $this->lastCardInRow($i)['v']){
                return true;
            }
        }
        return false;
    }

    // returns lars card in each row
    private function lastCardInRow($index)
    {
        return end($this->cards[$index]);
    }

    // if choosed card will be sixth card in row
    private function isReachedRowLimit($indexOfRow)
    {
        if (count($this->cards[$indexOfRow]) == Game::LIMIT_OF_CARDS_IN_ROW){
            return true;
        }
        return false;
    }

    public function chooseRow()
    {
        $sumOfPointsInRow = array();
        for ($i = 0; $i < Game::COUNT_OF_ROWS; $i++) {
            $sumOfPointsInRow[$i] = $this->calcSumOfPoints($this->cards[$i]);
        }
        $index = array_search(min($sumOfPointsInRow), $sumOfPointsInRow);
        return $index;
    }

}