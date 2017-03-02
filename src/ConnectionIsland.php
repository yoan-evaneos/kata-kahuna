<?php

namespace Kata;

/**
 * Class ConnectionIsland
 *
 * @package Kata
 **/
class ConnectionIsland
{
    /**
     * @var \Kata\Island
     */
    private $source;

    /**
     * @var \Kata\Island
     */
    private $target;

    /**
     * @var Player
     */
    private $owner;

    /**
     * ConnectionIsland constructor.
     *
     * @param \Kata\Island $source
     * @param \Kata\Island $target
     */
    public function __construct(Island $source, Island $target)
    {
        $this->source = $source;
        $this->target = $target;
        $this->source->addConnection($this);
        $this->target->addConnection($this);
    }

    /**
     * @param \Kata\Player $player
     */
    public function putBridge(Player $player)
    {
        $this->owner = $player;
    }

    /**
     *
     */
    public function removeBridge()
    {
        $this->owner = null;
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        return $this->owner !== null;
    }


    /**
     * @param \Kata\Player $player
     *
     * @return bool
     */
    public function isUsedBy(Player $player)
    {
        return $this->owner === $player;
    }
}
