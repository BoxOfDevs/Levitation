<?php

/* 
  _                _ _        _   _     
 | |              (_) |      | | (_)
 | |     _____   ___| |_ __ _| |_ _  ___  _ __
 | |    / _ \ \ / / | __/ _` | __| |/ _ \| '_ \
 | |___|  __/\ V /| | || (_| | |_| | (_) | | | |
 |______\___| \_/ |_|\__\__,_|\__|_|\___/|_| |_|
  
 Adding the levitation effect to your game!

*/

namespace BoxOfDevs\Levitation;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\Player;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\plugin\PluginBase;
use pocketmine\level\Level;

class Main extends PluginBase{
    
    public function onEnable(){
        // $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§l§0[§r§bLevitation§0§l]§r§a Enabled");
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
        switch(strtolower($cmd->getName())){
            case "levitate":
            if(!isset($args[0])){
                return false;
            }elseif(!isset($args[1])){ 
                $args[1] = 15;
            }if(!isset($args[2])){ 
                $args[2] = 1;
            }if(!isset($args[3])){
		          $args[3] = false;
            }
            $player = $this->getServer()->getPlayer($args[0]);
            if($player instanceof Player){
                $this->getServer()->getScheduler()->scheduleRepeatingTask(new LevitateTask($this, $player, $args[1], $args[2], $args[3]), 5);
                $sender->sendMessage("§l§0[§r§bLevitation§0§l]§r§a ".$player->getName()." is now levitating for $args[1] seconds!");
            }else{
                $sender->sendMessage("§l§0[§r§bLevitation§0§l]§r§4 Player not found");
            }
        }
        return true;
    }
    
    public function onDisable(){
        $this->getLogger()->info("§l§0[§r§bLevitation§0§l]§r§4 Disabled");
    }
    
}
