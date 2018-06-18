<?php

/*
 *    _____ _               __  __           _
 *   / ____| |        /\   |  \/  |         | |
 *  | |    | |       /  \  | \  / | __ _ ___| | _____
 *  | |    | |      / /\ \ | |\/| |/ _` / __| |/ / __|
 *  | |____| |____ / ____ \| |  | | (_| \__ \   <\__ \
 *   \_____|______/_/    \_\_|  |_|\__,_|___/_|\_\___/
 *
 * CLAMasks, a public masks plugin for PocketMine-MP
 * Copyright (C) 2017-2018 CLADevs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

declare(strict_types=1);

namespace CLAMasks\task;

use CLAMasks\Main;
use pocketmine\item\Item;
use pocketmine\scheduler\Task;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

class MaskTask extends Task{

    public function onRun(int $tick) : void{
        foreach(Main::getInstance()->getServer()->getOnlinePlayers() as $players){
            $inv = $players->getArmorInventory();
            $helmet = $inv->getHelmet();
            if(!$helmet->getId() === Item::MOB_HEAD) return;
            switch($helmet->getDamage()){
                case 0:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10, 1, false));
                    return;
                case 4:
                    $players->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 10, 1, false));
                    return;
            }
        }
    }
}
