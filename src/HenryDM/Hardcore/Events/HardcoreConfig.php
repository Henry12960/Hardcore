<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;
use pocketmine\player\Player;

use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;

class HardcoreConfig implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onWorldChange(EntityTeleportEvent $event)  {
        $player = $event->getEntity();
        if (!$player instanceof Player) return;
        if($this->getMain()->cfg->get("hardcore-world-flight") === false) {
            $player->setAllowFlight(false);
            $player->setFlying(false);
        }
    }

    public function onDamage(EntityDamageEvent $event)  {
        $entity = $event->getEntity();
        $world = $entity->getWorld();
        $worldName = $world->getFolderName();
        $entity = $event->getEntity();
        if($this->getMain()->cfg->get("hardcore-world-pvp") === false) {
            if($event instanceof EntityDamageByEntityEvent) {
                $damager = $event->getDamager();
                if(!$damager instanceof Player) return;
                if(in_array($worldName, $this->getMain()->cfg->getNested("hardcore-worlds", []))) {
                    $event->cancel(); 
                }       
            }
        }

        if($this->getMain()->cfg->get("hardcore-fall-damage") === false) {
            if($event->getCause() === EntityDamageEvent::CAUSE_FALL) {
                $event->cancel();
            }  
        }
    }

    public function onDeath(PlayerDeathEvent $event) {
        $player = $event->getPlayer();
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
        if($this->getMain()->cfg->get("other-keep-inventory") === true) {
            if(in_array($worldName, $this->getMain()->cfg->getNested("other-keep-inventory-worlds", []))) {
                $event->setKeepInventory(true);
            }
        }
    }

    public function getMain() : Main {
        return $this->main;
    }
}