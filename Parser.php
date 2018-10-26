<?php


class Parser
{

    private const WALK = 'walk';
    private const TURN = 'turn';

    /**
     * @var array
     */
    private $input;

    private $instructions;

    private $position;

    /**
     * Parser constructor.
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * @return Parser
     * @throws Exception
     */
    public function parse(): Parser
    {
        $strings = explode(PHP_EOL, $this->input);

        foreach ($strings as $string) {
            if (!strstr($string, ' ')) {
                $this->instructions[$string] = [];
                $this->position = $string;
            } else {
                $this->parseInstruction(explode(' ', $string));
            }
        }

        return $this;
    }

    /**
     * @param float $x
     * @param float $y
     */
    public function draw(float $x, float $y): void
    {
        foreach ($this->instructions as $count => $instructionsByCount) {
            if ($count == 0) {
                continue;
            }

            $currentX = 0;
            $currentY = 0;
            $currentDistance = 0;
            /** @var Instruction $instruction */
            foreach ($instructionsByCount as $instruction) {
                $currentX += $instruction->getCurrentX();
                $currentY += $instruction->getCurrentY();
                $currentDistance += $instruction->calculateDistance($x, $y);
            }
            echo sprintf('%f %f %f', $currentX / $count, $currentY / $count, $currentDistance / $count);
            echo PHP_EOL;
        }
    }

    /**
     * @param array $instructions
     * @throws Exception
     */
    private function parseInstruction(array $instructions): void
    {
        $instruction = new Instruction($instructions[0], $instructions[1]);
        $instruction->start($instructions[3]);

        for ($i = 4; $i < count($instructions); $i += 2) {
            switch ($instructions[$i]) {
                case self::WALK:
                    $instruction->walk($instructions[$i + 1]);
                    break;
                case self::TURN:
                    $instruction->turn($instructions[$i + 1]);
                    break;
                default:
                    throw new Exception(sprintf('Wrong instruction: \'%s\'', $instructions[$i]));
            }
        }

        $this->instructions[$this->position][] = $instruction;
    }


}