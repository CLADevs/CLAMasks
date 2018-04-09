<?php

/*
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

use pocketmine\item\Item;
use pocketmine\scheduler\PluginTask;
use pocketmine\entity\{
    Effect, EffectInstance
};

use CLAMasks\Main;

class MaskTask extends PluginTask{

    /** @var Main */
    private $plugin;

    public function __construct(Main $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }

    public function onRun(int $tick) : void{
        foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
            $inv = $player->getArmorInventory();
            $helmet = $inv->getHelmet();
            if($helmet->getId() === Item::MOB_HEAD){
                switch($helmet->getDamage()){
                    case 0: //skeleton
                        $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10, 1, false));
                        return;
                    case 4: //creeper
                        $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10, 1, false));
                        return;
                }
            }
        }
    }
}
