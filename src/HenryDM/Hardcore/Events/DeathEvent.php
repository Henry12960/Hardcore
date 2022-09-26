<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerDeathEvent;
use davidglitch04\libEco\libEco;

class DeathEvent implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onDeath(PlayerDeathEvent $event) {

# ===============================================
        $player = $event->getPlayer();        
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
        $amount = $this->getMain()->cfg->get("death-money-value");
# ===============================================

        if(in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
            $event->setDrops([]);
        }

        if($this->getMain()->cfg->get("death-sound") === true) {
            if(in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
                PluginUtils::playSound($player, $this->getMain()->cfg->get("death-sound-name"), 1, 1);
            }
        }

        if($this->getMain()->cfg->get("death-add-xp-level") === true) {
            if(in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
                $player->getXpManager()->addXpLevels($this->getMain()->cfg->get("death-xp-value"));
            }
        }

        if($this->getMain()->cfg->get("death-add-money") === true) {
            if (in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
                libEco::addMoney($player, $amount);
            }
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}