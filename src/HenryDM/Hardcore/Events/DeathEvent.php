<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerDeathEvent;
use davidglitch04\libEco\libEco;
use HenryDM\Hardcore\utils\PluginUtils;

class DeathEvent implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onDeath(PlayerDeathEvent $event) {

# ===============================================
        $player = $event->getPlayer();        
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
        $message = $this->getMain()->cfg->get("broadcast-message");
        $amount = $this->getMain()->cfg->get("death-money-value");
        $kickreason = $this->getMain()->cfg->get("death-kick-message");
# ===============================================

        if(in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
            $event->setDrops([]);
            if($this->getMain()->cfg->get("hardcore-death-broadcast") === true) {
               $this->main->getServer()->broadcastMessage($message);
            }
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
        
        if($this->getMain()->cfg->get("kick-on-death") === true) {
            if (in_array($worldName, $this->getMain()->cfg->get("hardcore-world", []))) {
                $player->kick($kickreason);
            }
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}
