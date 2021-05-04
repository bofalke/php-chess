<?php

namespace Chess\Tests\Unit\Heuristic;

use Chess\Board;
use Chess\Heuristic\LinearCombinationEvaluation;
use Chess\Heuristic\Picture\Standard as StandardHeuristicPicture;
use Chess\PGN\Convert;
use Chess\PGN\Symbol;
use Chess\Tests\AbstractUnitTestCase;
use Chess\Tests\Sample\Opening\Benoni\BenkoGambit;
use Chess\Tests\Sample\Opening\RuyLopez\Exchange as ExchangeRuyLopez;

class LinearCombinationEvaluationTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function start()
    {
        $board = new Board();

        $heuristicPic = new StandardHeuristicPicture($board->getMovetext());

        $picture = $heuristicPic->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function w_e4_b_e5()
    {
        $board = new Board();

        $board->play(Convert::toStdObj(Symbol::WHITE, 'e4'));
        $board->play(Convert::toStdObj(Symbol::BLACK, 'e5'));

        $heuristicPic = new StandardHeuristicPicture($board->getMovetext());

        $picture = $heuristicPic->take();

        $expected = [
            Symbol::WHITE => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],

            ],
            Symbol::BLACK => [
                [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
            ],
        ];

        $this->assertEquals($expected, $picture);
    }

    /**
     * @test
     */
    public function evaluate_benko_gambit()
    {
        $board = (new BenkoGambit(new Board()))->play();

        $heuristicPic = new StandardHeuristicPicture($board->getMovetext());

        $evaluation = (new LinearCombinationEvaluation())->evaluate($heuristicPic);

        $expected = [
            Symbol::WHITE => 35.48,
            Symbol::BLACK => 21.36,
        ];

        $this->assertEquals($expected, $evaluation);
    }
}
