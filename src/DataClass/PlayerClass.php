<?php

namespace App\DataClass;

use App\Entity\Player;
use App\Entity\PNJ;

class PlayerClass
{
    const PVM = 10;
    const PV = 10;
    const PCM = 1;
    const PC = 1;
    const PMM = 0;
    const PM = 0;
    const PD = 1;
    const lvl = 1;
    const dmg_dice = 1;
    const dmg_fixed = 0;
    const strength = 10;
    const intel = 10;
    const social = 10;
    const perception = 10;
    const speed = 10;
    static public function setDefaultStats(Player $entity): void
    {
        $entity->setPVM(self::PVM);
        $entity->setPV(self::PV);
        $entity->setPCM(self::PCM);
        $entity->setPC(self::PC);
        $entity->setPMM(self::PMM);
        $entity->setPM(self::PM);
        $entity->setPD(self::PD);
        $entity->setLvl(self::lvl);
        $entity->setDmgDice(self::dmg_dice);
        $entity->setDmgFixed(self::dmg_fixed);
        $entity->setStrength(self::strength);
        $entity->setIntel(self::intel);
        $entity->setSocial(self::social);
        $entity->setPerception(self::perception);
        $entity->setSpeed(self::speed);
    }
}