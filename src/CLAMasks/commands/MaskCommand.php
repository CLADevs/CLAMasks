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

namespace CLAMasks\commands;

use CLAMasks\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class MaskCommand extends PluginCommand{

    public function __construct(string $name, Main $plugin){
        parent::__construct($name, $plugin);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool{
        if(empty($args[0])){
            $sender->sendMessage(TextFormat::GRAY . "/masks <give | list>");
            return false;
        }

        if($sender instanceof ConsoleCommandSender){
            if($args[0] == "give"){
                return true;
            }
            if($args[0] == "list"){
                $sender->sendMessage(TextFormat::YELLOW . "Avaible Masks:");
                foreach(Main::getInstance()->getConf("Masks") as $masks) $sender->sendMessage(TextFormat::GRAY . "- " . TextFormat::GREEN . $masks);
            }
        }elseif($sender instanceof Player){
            if($sender->hasPermission("cla.masks")){
                if($args[0] == "give"){
                    return true;
                }
                if($args[0] == "list"){
                    $sender->sendMessage(TextFormat::YELLOW . "Avaible Masks:");
                    foreach(Main::getInstance()->getConf("Masks") as $masks) $sender->sendMessage(TextFormat::GRAY . "- " . TextFormat::GREEN . $masks);
                }
            }else{
                $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
                return false;
            }
        }
        return true;
    }
}
