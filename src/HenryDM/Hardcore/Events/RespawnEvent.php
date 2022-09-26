<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\event\player\PlayerRespawnEvent;
use HenryDM\Hardcore\libs\jojoe77777\FormAPI\SimpleForm;

class DeathEvent implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }

    public function onRespawn(PlayerRespawnEvent $event) {

# ===============================================
        $player = $event->getPlayer();        
        $world = $player->getWorld();
        $worldName = $world->getFolderName();
# ===============================================

        if (in_array($worldName, $this->getMain()->cfg->get("hardcore-worlds", []))) {
            $form = new SimpleForm(function(Player $player, int $data = null){
                if($data === null) {
                    return true;
                }
        
                switch($data) {
                    case 0:
                        $this->getServer()->dispatchCommand($player, "");
                    break;
                    }
        
                });
                $form->setTitle("TEST");
                $form->setContent("TEST", 0, );
                $form->addButton("TEST", 0, "");
                $form->sendToPlayer($player);
                return $form;
            }
        }

    public function getMain() : Main {
        return $this->main;
    }
}