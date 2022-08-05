<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Blackjack\Controller;

use Blackjack\Model\Deck;
use Blackjack\Model\Human;
use Blackjack\Model\Computer;
use Blackjack\Model\Game;

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
    private $dealler;
    private $player;
    private $deck;

//    public function dispatch($action, $config)
//    {
//        //@FIXME: connect to localhost
//        $result = parent::dispatch($action, $config);
//
//        return $result;
//    }

    public function indexAction()
    {
        $this->view()->setTemplate('game\play');

        \session_unset();

        $this->player  = new Human();
        $this->dealler = new Computer();

        $this->deck = new Deck();

        for ($i = 0; $i < Game::COUNT_CARDS_ON_START; $i++) {
            $this->player->takeCard($this->deck->getCard());
            $this->dealler->takeCard($this->deck->getCard());
        }

        $this->view()->hand   = $this->player->getCard();
        $this->view()->points = $this->player->points;
    }

    public function roundAction()
    {
        $this->view()->setTemplate('game\round');
        while ($this->dealler->oneMore($this->deck)) {
            $this->dealler->takeCard($this->deck->getCard());
        }

        $points[$this->player->name]  = $this->player->points;
        $points[$this->dealler->name] = $this->dealler->points;

        $cards[$this->player->name]  = $this->player->getCard();
        $cards[$this->dealler->name] = $this->dealler->getCard();

        $this->view()->winner = $this->winner();
        $this->view()->table  = $cards;
        $this->view()->points = $points;
    }

    public function playAction()
    {
        $this->player->takeCard($this->deck->getCard());
        $this->view()->hand   = $this->player->getCard();
        $this->view()->points = $this->player->points;
    }

    public function __construct()
    {
        \session_start();

        if (isset($_SESSION['deck'])) {
            $this->deck    = unserialize($_SESSION['deck']);
            $this->player  = unserialize($_SESSION['player']);
            $this->dealler = unserialize($_SESSION['dealler']);
        }
    }

    public function __destruct()
    {
        $_SESSION['deck']    = serialize($this->deck);
        $_SESSION['player']  = serialize($this->player);
        $_SESSION['dealler'] = serialize($this->dealler);
    }

    public function winner()
    {
        if ($this->player->points <= Game::GOAL_POINTS && $this->dealler->points <= Game::GOAL_POINTS) {
            if ($this->player->points > $this->dealler->points) {
                return $this->player;
            } else {
                return $this->dealler;
            }
        } elseif ($this->player->points <= Game::GOAL_POINTS) {
            return $this->player;
        } elseif ($this->dealler->points <= Game::GOAL_POINTS) {
            return $this->dealler;
        }
    }

}