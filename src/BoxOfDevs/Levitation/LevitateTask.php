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

use pocketmine\server;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\utils\TextFormat as C;
use pocketmine\plugin\PluginBase;
use pocketmine\math\Vector3;
use pocketmine\level\particle\SpellParticle;

class LevitateTask extends PluginTask{
    
    private $player;
    private $plugin;
    
    public function __construct($plugin, $player, $time, $amplifier, $hide){
        parent::__construct($plugin);
        $this->player = $player;
        $this->plugin = $plugin;
		$this->seconds = $time * 5;
		$this->miliseconds = 0;
		$this->blocks = ($amplifier + 3) / 4;
		$this->hide = $hide;
    }
    
    public function onRun($tick){
        if($this->miliseconds <=  $this->seconds){
            $this->miliseconds++;
            $this->player->sendMessage($this->miliseconds);
            $x = $this->player->x;
            $y = $this->player->y + $this->blocks;
            $z = $this->player->z;
            $yaw = $this->player->yaw;
            $pitch = $this->player->pitch;
            $this->player->teleport(new Vector3($x, $y, $z), $yaw, $pitch);
            if($this->hide ===! true or $this->hide ===! 1 or $this->hide ===! "t"){
            	$level = $player->getLevel();
                $level->addParticle(new SpellParticle(new Vector3($x, $y, $z), 238, 130, 238, 255));
            }
        }else{
            $this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
    
}
