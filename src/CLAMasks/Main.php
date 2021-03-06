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

namespace CLAMasks;

use CLAMasks\task\MaskTask;
use CLAMasks\commands\MaskCommand;
use pocketmine\command\overload\CommandEnum;
use pocketmine\command\overload\CommandParameter;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

    /** @var Main $instance */
    private static $instance;

    public function onEnable() : void{
        self::$instance = $this;
        if(!file_exists($this->getDataFolder() . "config.yml")) $this->initConfig();
        $this->registerCommands();
        $this->getScheduler()->scheduleRepeatingTask(new MaskTask(), 20);
        $this->getLogger()->info(TextFormat::GREEN . "CLAMasks  has been enabled!");
    }

    public static function getInstance() : self{
        return self::$instance;
    }

    private function registerCommands() : void{
        $cmdmap = $this->getServer()->getCommandMap();
        $cmdmap->register("CLAMasks", new MaskCommand("masks", $this));
        $masks = $cmdmap->getCommand("masks");
        $masks->setDescription("Masks Command.");
        if($this->getServer()->getName() == "Altay") $masks->getOverload("default")->setParameter(0, new CommandParameter("options", CommandParameter::ARG_TYPE_STRING, false, new CommandEnum("options", ["give", "list"])));
    }

    private function initConfig() : Config{
        return new Config($this->getDataFolder() . "config.yml", Config::YAML, [
            "Masks" => [],
        ]);
    }

    public function getConf($get){
        $config = new Config($this->getDataFolder() . "config.yml");
        return $config->get($get);
    }
}