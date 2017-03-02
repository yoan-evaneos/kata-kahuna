<?php
namespace Kata\Test;

use Kata\ConnectionIsland;
use Kata\Island;
use Kata\Player;

/**
 * Class IslandTest
 *
 * @package Kata\Test
 **/
class IslandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_island_links()
    {
        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $this->assertEquals(1, $lale->countUnusedConnections());
    }

     /**
      * @test
      */
     public function create_a_connection_island_that_already_exists_should_not_be_possible()
     {
         $this->setExpectedException(\InvalidArgumentException::class);

         $lale = new Island('lale');

         $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);
         $lale->addConnection($laleKahuConnection);
     }

    /**
     * @test
     */
    public function put_bridge_on_connection_island()
    {
        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $whitePlayer = new Player(Player::WHITE);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);

        $this->assertEquals(0, $lale->countUnusedConnections());
    }

    /**
     * @test
     */
    public function put_bridge_on_unavailable_connection_should_not_be_possible()
    {
        $this->setExpectedException(\RuntimeException::class);

        $whitePlayer = new Player(Player::WHITE);
        $blackPlayer = new Player(Player::BLACK);

        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);

        $lale->putBridgeOnConnection($laleKahuConnection, $blackPlayer);
    }

    /**
     * @test
     */
    public function remove_bridge_on_connection_island()
    {
        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $whitePlayer = new Player(Player::WHITE);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);

        $lale->removeBridgeOnConnection($laleKahuConnection);

        $this->assertEquals(1, $lale->countUnusedConnections());
    }

    /**
     * @test
     */
    public function remove_bridge_on_available_connection_should_not_be_possible() {

        $this->setExpectedException(\RuntimeException::class);

        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $whitePlayer = new Player(Player::WHITE);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);

        $lale->removeBridgeOnConnection($laleKahuConnection);

        $lale->removeBridgeOnConnection($laleKahuConnection);
    }

    /**
     * @test
     */
    public function should_be_owned()
    {
        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);

        $whitePlayer = new Player(Player::WHITE);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);

        $this->assertTrue($lale->isOwned($whitePlayer));
    }
    
    /**
     * @test
     */
    public function it_should_destroy_the_other_player_connections_when_island_is_owned()
    {
        $lale = new Island('lale');

        $laleKahuConnection = $this->givenThereIsAConnectionBetweenLaleAndKahu($lale);
        $laleHunaConnection = $this->givenThereIsAnotherConnectionBetweenLaleAndHuna($lale);
        $laleIffiConnection = $this->givenThereIsAnotherConnectionBetweenLaleAndIffi($lale);

        $whitePlayer = new Player(Player::WHITE);
        $blackPlayer = new Player(Player::BLACK);

        $lale->putBridgeOnConnection($laleKahuConnection, $whitePlayer);
        $lale->putBridgeOnConnection($laleIffiConnection, $blackPlayer);
        $lale->putBridgeOnConnection($laleHunaConnection, $whitePlayer);

        $this->assertTrue($lale->isOwned($whitePlayer));
        $this->assertEquals(1, $lale->countUnusedConnections());
    }

    /**
     * @param \Kata\Island $lale
     *
     * @return \Kata\ConnectionIsland
     */
    private function givenThereIsAConnectionBetweenLaleAndKahu(Island $lale)
    {
        $kahu = new Island('kahu');

        $laleKahuConnectionIsland = new ConnectionIsland($lale, $kahu);

        return $laleKahuConnectionIsland;
    }

    /**
     * @param \Kata\Island $lale
     *
     * @return \Kata\ConnectionIsland
     */
    private function givenThereIsAnotherConnectionBetweenLaleAndIffi(Island $lale)
    {
        $iffi = new Island('iffi');

        $laleIffiConnectionIsland = new ConnectionIsland($lale, $iffi);

        return $laleIffiConnectionIsland;
    }


    /**
     * @param \Kata\Island $lale
     *
     * @return \Kata\ConnectionIsland
     */
    private function givenThereIsAnotherConnectionBetweenLaleAndHuna(Island $lale)
    {
        $huna = new Island('huna');

        $laleHunaConnectionIsland = new ConnectionIsland($lale, $huna);

        return $laleHunaConnectionIsland;
    }
}
