<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\player\Player;
use pocketmine\event\player\PlayerRespawnEvent;
use Vecnavium\FormsUI\SimpleForm;

class RespawnEvent implements Listener {

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
                        
                    break;
                    }
        
                });
                $form->setTitle($this->getMain()->cfg->get("game-over-form-title"));
                $form->setContent($this->getMain()->cfg->get("game-over-form-content"));
                $form->addButton($this->getMain()->cfg->get("game-over-form-exit-button"));
                $form->sendToPlayer($player);
                return $form;
            }
        }

    public function getMain() : Main {
        return $this->main;
    }
}