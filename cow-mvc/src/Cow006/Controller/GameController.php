<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cow006\Controller;

use Cow006\Model\Deck;
use Cow006\Model\Game;
use Cow006\Model\Human;
use Cow006\Model\Computer;
use Cow006\Model\CardsOnTable;

/**
 * Description of Level
 *
 * @author astolbovyi
 */
class GameController extends AbstractController
{

    /**
     *
     * @var Human
     */
    private $players;

    /**
     * @var \Cow006\Model\CardsOnTable 
     */
    private $table;

//    public function dispatch($action, $config)
//    {
//        //@FIXME: connect to localhost
//        $result = parent::dispatch($action, $config);
//
//        return $result;
//    }

    public function indexAction()
    {
        $this->view()->setTemplate('game\index');

        \session_unset();

        $this->players = [
            new Human(),
            new Computer('A1'),
        ];

        return $this->roundAction();
    }

    public function roundAction()
    {
        $deck        = new Deck();
        $this->table = new CardsOnTable($deck->getCards(Game::COUNT_OF_ROWS));
        $points      = [];
        
        foreach ($this->players as $player) {
            $cards = $deck->getCards(Game::CARDS_IN_HAND);
            
            // Give cards to player
            $player->giveCards($cards);
            
            if ($player instanceof Human) {
                $this->view()->hand = $player->getCards();
            }
            
            $points[$player->name] = $player->points;
        }

        $this->view()->setTemplate('game\round');
        $this->view()->points = $points;
        $this->view()->table  = $this->table->getCards();
    }

    public function playAction()
    {
        // Players makes choise
        $cards = [];

        foreach ($this->players as $key => $player) {
            if ($player instanceof Human) {
                $cards[$key]        = $player->makeChoice($_POST['ChoosedCard']);
                $this->view()->hand = $player->cards;
            } else {
                $cards[$key] = $player->makeChoice();
            }
        }

        // Put cards on table
        $points = $this->table->playCards($cards);

        // Update players scores
        foreach ($points as $key => $points) {
            $this->players[$key]->addPoints($points);
        }

        // Check end of round
        if (0 == $this->players[0]->countOfCards()) {

            if (($looser = $this->looser())) {
                $this->view()->looser = $looser;                
                return $this->indexAction();
            } else {
                return $this->roundAction();
            }
        }

        $this->view()->table = $this->table->getCards();
    }

    public function __construct()
    {
        \session_start();

        if (isset($_SESSION['table'])) {
            $this->table   = unserialize($_SESSION['table']);
            $this->players = unserialize($_SESSION['players']);
        }
    }

    public function __destruct()
    {
        $_SESSION['table']   = serialize($this->table);
        $_SESSION['players'] = serialize($this->players);
    }

    public function looser()
    {
        foreach ($this->players as $player) {
            if ($player->points >= Game::POINTS_LIMIT) {
                return $player;
            }
        }
    }

}