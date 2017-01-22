<?php

namespace Kata\Bowling;

class Game
{
    protected $rolls = [];

    protected $currentRoll = 0;

    /** @var int */
    protected $score = 0;

    public function roll(int $pins)
    {
        $this->score += $pins;
        $this->rolls[$this->currentRoll++] = $pins;
    }

    public function score(): int
    {
        $score = 0;
        $frameIndex = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($frameIndex)) {
                $score += 10 + $this->strikeBonus($frameIndex);
                $frameIndex++;
            } elseif ($this->isSpare($frameIndex)) {
                $score += 10 + $this->spareBonus($frameIndex);
                $frameIndex += 2;
            } else {
                $score += $this->sumOfBallsInFrame($frameIndex);
                $frameIndex += 2;
            }
        }

        return $score;
    }

    private function isStrike(int $frameIndex): bool
    {
        return $this->rolls[$frameIndex] === 10;
    }

    private function isSpare(int $frameIndex): bool
    {
        return $this->sumOfBallsInFrame($frameIndex) === 10;
    }

    private function strikeBonus(int $frameIndex): int
    {
        return $this->rolls[$frameIndex + 1] + $this->rolls[$frameIndex + 2];
    }

    private function spareBonus(int $frameIndex): int
    {
        return $this->rolls[$frameIndex + 2];
    }

    private function sumOfBallsInFrame(int $frameIndex): int
    {
        return $this->rolls[$frameIndex] + $this->rolls[$frameIndex + 1];
    }
}
