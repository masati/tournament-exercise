<?php

declare(strict_types=1);

namespace Tournament;

/**
 * Class Participant.
 */
class Participant
{
    public const EQUIPMENT = [
            'sword' => ['dmg' => 5],
            'buckler' => ['dmg' => 0, 'blocked' => 0],
            'armor' => ['dmg' => -1, 'def' => 3],
            'axe' => ['dmg' => 6],
            'great sword' => ['dmg' => 12],
            'default' => ['dmg' => 0]
        ];

    /**
     * Add some equipment
     * @param string $name
     * @return $this
     */
    public function equip(string $name = 'default'): static
    {
        $this->equip[$name] = self::EQUIPMENT[$name];

        if (self::EQUIPMENT[$name]['dmg'] > 0) {
            $this->dmg = $this->equip[$name]['dmg'];
        }
        return $this;
    }

    /**
     * This is a duel simulation - Blow exchange
     * @param Participant $b
     */
    public function engage(Participant $b): void
    {
        $a = $this;
        $round = 1;
        
        while ($a->hitPoints > 0 and $b->hitPoints > 0) {
            $this->round($a, $b, $round);
            $round++;
        }
    }

    /**
     * Returns hit points
     * @return int
     */
    public function hitPoints(): int
    {
        return $this->hitPoints;
    }

    /**
     * This is one Blow exchange
     * @param Participant $a
     * @param Participant $b
     */
    public function round(Participant $a, Participant $b, int $round): void
    {
        $dmg = $this->calculateDmg($a, $b, $round);
        $b->hitPoints = ($b->hitPoints - $dmg > 0) ? $b->hitPoints - $dmg : 0;

        $dmg = $this->calculateDmg($b, $a, $round);
        $a->hitPoints = ($a->hitPoints - $dmg > 0) ? $a->hitPoints - $dmg : 0;
    }

    /**
     * Calculate damage of one blow
     * @param Participant $a
     * @param Participant $b
     * @param int $round
     * @return int
     */
    public function calculateDmg(Participant $a, Participant $b, int $round): int
    {
        if (array_key_exists('great sword', $a->equip) and $round % 3 == 0) {
            return 0;
        }
        
        if (array_key_exists('buckler', $b->equip)) {
            $b->equip['buckler']['blocked']++;
            if ($b->equip['buckler']['blocked'] % 2 == 1) {
                if (array_key_exists('axe', $a->equip) and $b->equip['buckler']['blocked'] > 3) {
                    unset($b->equip['buckler']);
                }
                return 0;
            }
        }

        $dmg = $a->dmg;
        if ($a->isVicious() and $round <= 2) {
            $dmg += 20;
        }

        if ($a->isVeteran() and $a->hitPoints <= $a->options['hp']) {
            $dmg *= 2;
        }

        if (array_key_exists('armor', $a->equip)) {
            $dmg = $dmg + $a->equip['armor']['dmg'];
        }

        if (array_key_exists('armor', $b->equip)) {
            $dmg = $dmg - $b->equip['armor']['def'];
        }
        return $dmg;
    }

    /**
     * Check is Participant Vicious
     * @return bool
     */

    public function isVicious(): bool
    {
        return is_array($this->options) and in_array('Vicious', $this->options);
    }

    /**
     * Check is Participant Veteran
     * @return bool
     */
    public function isVeteran(): bool
    {
        return in_array('Veteran', $this->options);
    }
}
