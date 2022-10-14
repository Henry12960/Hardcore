<?php

namespace HenryDM\Hardcore\Forms;

use pocketmine\Server;
use Vecnavium\FormsUI\CustomForm;
use pocketmine\player\Player;

use HenryDM\utils\PluginUtils;

class JoinForm {

    public function openHardcoreUI($player) {
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null) {
                return true;
            }
    
            switch($data) {
                case 0:
                    $message = Main::getInstance()->cfg->get("join-game-message");
		            $command = Main::getInstance()->cfg->get("tp-game-command");
                    Main::getInstance()->getServer()->dispatchCommand($player, $command);
                    $player->sendMessage($message);
                break;

                case 1: 
                    PluginUtils::playSound($player, Main::getInstance()->cfg->get("start-game-form-button-exit-sound"), 1, 1);
                break;
            }
    
            });
            $form->setTitle(Main::getInstance()->cfg->get("start-game-form-title"));
            $form->setContent(Main::getInstance()->cfg->get("start-game-form-content"));
            $form->addButton(Main::getInstance()->cfg->get("start-game-form-start-button"));
            $form->addButton(Main::getInstance()->cfg->get("start-game-form-exit-button"));
	        $form->sendToPlayer($player);
            return $form;
    }
}