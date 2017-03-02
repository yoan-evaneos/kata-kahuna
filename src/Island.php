<?php

namespace Kata;

/**
 * Class Island
 *
 * @package Kata
 **/
class Island
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ConnectionIsland[]
     */
    private $connectionIslands;

    public function __construct($name)
    {
        $this->name = $name;
        $this->connectionIslands = [];
    }

    /**
     * @return int
     */
    public function countUnusedConnections()
    {
        return count(array_filter($this->connectionIslands, function (ConnectionIsland $connectionIsland) {
                return !$connectionIsland->isUsed();
            })
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Kata\ConnectionIsland $connectionIsland
     * @throws \InvalidArgumentException
     */
    public function addConnection(ConnectionIsland $connectionIsland)
    {
        if (isset($this->connectionIslands[spl_object_hash($connectionIsland)])) {
            throw new \InvalidArgumentException('This connection already exists for this island');
        }
        $this->connectionIslands[spl_object_hash($connectionIsland)] = $connectionIsland;
    }

    /**
     * @param \Kata\ConnectionIsland $connectionIsland
     * @throws \RuntimeException
     */
    public function putBridgeOnConnection(ConnectionIsland $connectionIsland, Player $player) {
        if ($connectionIsland->isUsed()) {
            throw new \RuntimeException('Connection island is already used');
        }
        $connectionIsland->putBridge($player);
        $this->checkOwnership($player);
    }

    /**
     * @param \Kata\ConnectionIsland $connectionIsland
     */
    public function removeBridgeOnConnection(ConnectionIsland $connectionIsland) {
        if (!$connectionIsland->isUsed()) {
            throw new \RuntimeException('Connection island is already used');
        }
        $connectionIsland->removeBridge();
    }

    public function isOwned(Player $player)
    {
        $ownedConnections = $this->countUsedConnectionsBy($player);
        return $ownedConnections > (count($this->connectionIslands) - $ownedConnections);
    }

    /**
     * @param \Kata\Player $player
     *
     * @return int
     */
    public function countUsedConnectionsBy(Player $player)
    {
        return count(array_filter($this->connectionIslands, function (ConnectionIsland $connectionIsland) use ($player) {
                return $connectionIsland->isUsedBy($player);
            })
        );
    }

    /**
     * @param \Kata\Player $player
     */
    private function checkOwnership(Player $player)
    {
        if ($this->isOwned($player)) {
            array_walk($this->connectionIslands, function (ConnectionIsland $connectionIsland) use ($player) {
                if (!$connectionIsland->isUsedBy($player)) {
                    $this->removeBridgeOnConnection($connectionIsland);
                }
            });
        }
    }
}
