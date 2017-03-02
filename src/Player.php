<?php

namespace Kata;

/**
 * Class Player
 *
 * @package Kata
 **/
class Player
{
    const WHITE = 0;
    const BLACK = 1;

    /**
     * @var int
     */
    private $playerColor;

    /**
     * Player constructor.
     *
     * @param $playerColor
     */
    public function __construct($playerColor) {
        $this->playerColor = $playerColor;
    }
}
