<?php

declare(strict_types=1);

namespace Tournament;

/**
 * Class Highlander.
 */
class Highlander extends Participant
{
    public string $name = 'highlander';
    public string $defaultGun = "great sword";
    public int $hitPoints = 150;
    public string $gun;
    public int $dmg;
    public array $options = [];


    public function __construct(string ...$options)
    {
        $this->gun = $this->defaultGun;
        $this->equip($this->gun);
        $this->dmg = $this->equip[$this->gun]['dmg'];
        foreach ($options as $option) {
            $this->options[$option] = $option;
        }
        
        if ($this->isVeteran()) {
            $this->options['hp'] = $this->hitPoints * 0.3;
        }
    }
}
