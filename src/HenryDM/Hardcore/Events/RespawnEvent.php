<?php 

namespace HenryDM\Hardcore\Events;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

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
        $title = $this->getMain()->cfg->get("game-over-form-title");
        $content = $this->getMain()->cfg->get("game-over-form-content");
        $exitbutton = $this->getMain()->cfg->get("game-over-form-exit-button");
        $image = $this->getMain()->cfg->get("game-over-form-exit-button-image");
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
                $form->setTitle($title);
                $form->setContent($content, 0, );
                $form->addButton($exitbutton, 0, $image);
                $form->sendToPlayer($player);
                return $form;
            }
        }

    public function getMain() : Main {
        return $this->main;
    }
}