<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerDeathEvent;

class DeathEvent implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onDeath(PlayerDeathEvent $event) {

# ===============================================
        $player = $event->getPlayer();        
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
# ===============================================

        if (in_array($worldName, $this->getMain()->cfg->get("hardcore-worlds", []))) {
            $player->sendMessage("Test");
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}