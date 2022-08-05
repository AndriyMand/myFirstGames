<?php

namespace Cow006\Model;

class Human extends Player
{
    protected $name = 'Human';
    
    public function makeChoice($index)
    {
        return $this->takeCard($index);
    }
}