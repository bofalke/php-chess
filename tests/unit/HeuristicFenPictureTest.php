<?php

namespace Chess\Tests\Unit;

use Chess\Fen;
use Chess\HeuristicFenPicture;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;

class HeuristicFenPictureTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function e4_e5_take_get_picture()
    {
        $fen = (new Fen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
            ->load();

        $pic = (new HeuristicFenPicture($fen))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [ 1, 0.05, 0.4, 0.4, 0, 0.02, 0, 0 ],
            Symbol::BLACK => [ 1, 0.05, 0.4, 0.4, 0, 0.02, 0, 0 ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function e4_e5_take_get_balance()
    {
        $fen = (new Fen('rnbqkbnr/pppp1ppp/8/4p3/4P3/8/PPPP1PPP/RNBQKBNR w KQkq e6 0 2'))
            ->load();

        $balance = (new HeuristicFenPicture($fen))
            ->take()
            ->getBalance();

        $expected = [ 0, 0, 0, 0, 0, 0, 0, 0 ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function benko_gambit_take_get_picture()
    {
        $fen = (new Fen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->load();

        $pic = (new HeuristicFenPicture($fen))
            ->take()
            ->getPicture();

        $expected = [
            Symbol::WHITE => [ 1, 0.08, 0.5, 0.67, 0, 0.03, 0, 0 ],
            Symbol::BLACK => [ 0.97, 0.06, 0.53, 0.56, 0.08, 0.03, 0, 0 ],
        ];

        $this->assertEquals($expected, $pic);
    }

    /**
     * @test
     */
    public function benko_gambit_take_get_balance()
    {
        $fen = (new Fen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->load();

        $balance = (new HeuristicFenPicture($fen))
            ->take()
            ->getBalance();

        $expected = [ 0.03, 0.02, -0.03, 0.11, -0.08, 0, 0, 0 ];

        $this->assertEquals($expected, $balance);
    }

    /**
     * @test
     */
    public function benko_gambit_evaluate()
    {
        $fen = (new Fen('rn1qkb1r/4pp1p/3p1np1/2pP4/4P3/2N3P1/PP3P1P/R1BQ1KNR b kq - 0 9'))
            ->load();

        $evaluation = (new HeuristicFenPicture($fen))->evaluate();

        $expected = [
            Symbol::WHITE => 47.14,
            Symbol::BLACK => 46.01,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
