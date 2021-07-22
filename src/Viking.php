<?php

declare(strict_types=1);

namespace Tournament;

/**
 * Class Viking.
 */
class Viking extends Participant
{
    public string $name = 'Viking';
    public string $defaultGun = 'axe';
    public string $gun;
    public int $dmg;
    public int $hitPoints = 120;
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
