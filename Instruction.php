<?php


class Instruction
{

    /** @var float */
    private $currentX;

    /** @var float */
    private $currentY;

    /** @var float */
    private $currentDegree;

    /**
     * @param float $x
     * @param float $y
     */
    public function __construct(float $x, float $y)
    {
        $this->currentX = $x;
        $this->currentY = $y;
    }

    /**
     * @param int $degree
     */
    public function start(int $degree): void
    {
        $this->currentDegree = deg2rad($degree);
    }

    /**
     * @param float $distance
     */
    public function walk(float $distance): void
    {
       $this->currentX = $this->currentX + cos($this->currentDegree) * $distance;
       $this->currentY = $this->currentY + sin($this->currentDegree) * $distance;
    }

    /**
     * @param int $degree
     */
    public function turn(int $degree): void
    {
        $this->currentDegree = deg2rad($degree);
    }

    /**
     * @return float
     */
    public function getCurrentX()
    {
        return $this->currentX;
    }

    /**
     * @return float
     */
    public function getCurrentY()
    {
        return $this->currentY;
    }

    /**
     * @param float $x
     * @param float $y
     * @return float
     */
    public function calculateDistance(float $x, float $y): float
    {
        return sqrt(pow($x - $this->currentX, 2) + pow($y - $this->currentY, 2));
    }
}