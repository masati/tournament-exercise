<?php

declare(strict_types=1);

namespace Tournament;

/**
 * Class Swordsman.
 */
class Swordsman extends Participant
{
    public string $name = 'Swordsman';
    public string $defaultGun = "sword";
    public int $hitPoints = 100;
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
