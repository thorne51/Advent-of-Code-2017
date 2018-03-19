<?php
/**
 * Created by PhpStorm.
 * User: thorn
 * Date: 2018/03/18
 * Time: 23:10
 */

class Duet
{
    /**
     * @var array Stores input instruction set
     */
    private $instructions = [];

    /**
     * @var $registers array Stores register values
     */
    private $registers = [];

    /**
     * @var int Keeps track of current instruction from input.
     */
    private $instruction_index = 0;

    /**
     * @var $last_frequency_played int Keeps track of last frequency played.
     */
    private $last_frequency_played = 0;

    /**
     * Duet constructor.
     *
     * @param $instructions array
     */
    public function __construct($instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * Helper function to read a value from an instruction as an integer.
     * If the value passed is not an integer, it is retrieved from the
     * register being referenced.
     *
     * @param $value int|string Value from an instruction
     *
     * @return int Parsed integer value
     */
    private function readValue($value)
    {
        return intval(is_numeric($value) ? $value : $this->registers[$value]);
    }

    public function executeInstructions()
    {
        // continue execution of instructions indefinitely
        while (true) {
            // error checking
            if (!isset($this->instructions[$this->instruction_index])) {
                die("Invalid instruction index reached: {$this->instruction_index}\n");
            }

            echo $this->instructions[$this->instruction_index]."\n";

            // break up instruction
            $instruction_parts = explode(' ', $this->instructions[$this->instruction_index]);
            $instruction = $instruction_parts[0];
            $register = $instruction_parts[1];
            $value = isset($instruction_parts[2]) ? $this->readValue($instruction_parts[2]) : null;

            // initialize register as 0 if it does not exist yet
            if (!isset($this->registers[$register])) {
                $this->registers[$register] = 0;
            }

            // handle different instructions
            switch ($instruction) {
                case 'snd':
                    $this->last_frequency_played = $this->registers[$register];
                    break;

                case 'set':
                    $this->registers[$register] = $value;
                    break;

                case 'add':
                    $this->registers[$register] += $value;
                    break;

                case 'mul':
                    $this->registers[$register] *= $value;
                    break;

                case 'mod':
                    $this->registers[$register] %= $value;
                    break;

                case 'rcv':
                    if ($this->registers[$register] != 0) {
                        echo "'rcv' called with non-zero value: {$this->last_frequency_played}\n";
                        break 2;
                    }
                    break;

                case 'jgz':
                    if (is_numeric($register) || $this->registers[$register] > 0) {
                        $this->instruction_index += $this->readValue($value);
                        continue 2; // don't increment $instruction_index
                    }
                    break;

                default:
                    die("Unhandled instruction: {$instruction[$this->instruction_index]}\n");
                    break;
            }

            // continue to next instruction
            $this->instruction_index++;
        }
    }
}

// read input and extract all instructions
$input = file_get_contents('input.txt');
$instructions = explode("\n", $input);

// test input instructions
//$instructions = [
//    'set a 1',
//    'add a 2',
//    'mul a a',
//    'mod a 5',
//    'snd a',
//    'set a 0',
//    'rcv a',
//    'jgz a -1',
//    'set a 1',
//    'jgz a -2',
//];

$duet = new Duet($instructions);
$duet->executeInstructions();


