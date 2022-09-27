<?php

namespace HenryDM\Hardcore\commands;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use HenryDM\Hardcore\utils\PluginUtils;
use Vecnavium\FormsUI\SimpleForm;

class HardcoreCommand implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        if($command->getName() == "hardcore") {
            if($sender instanceof Player){
                $this->openHardcoreUI($sender);
            } else {
                $sender->sendMessage("Use this command in game!");
            }
            return true;
        } 
    }

    public function openHardcoreUI($player) {
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null) {
                return true;
            }
    
            switch($data) {
                case 0:
                    $world = $this->getMain()->cfg->get("hardcore-world", []);
                    $message = $this->getMain()->cfg->get("join-game-message");
                    $player->teleport($this->getServer()->getWorldByName($world)->getSafeSpawn()); 
                    $player->sendMessage($message);
                break;

                case 1: 
                    PluginUtils::playSound($player, $this->getMain()->cfg->get("start-game-button-click-sound"), 1, 1);
                break;
                }
    
            });
            $form->setTitle($this->getMain()->cfg->get("start-game-form-title"));
            $form->setContent($this->getMain()->cfg->get("start-game-form-content"));
            $form->addButton($this->getMain()->cfg->get("tp-game-form-button-tp"), 0, $this->getMain()->cfg->get("tp-game-form-button-tp-texture"));
            $form->addButton($this->getMain()->cfg->get("tp-game-form-button-exit"), 0, $this->getMain()->cfg->get("tp-game-form-button-exit-texture"));
    }

    public function getMain() : Main {
        return $this->main;
    }
}