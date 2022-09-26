<?php

namespace HenryDM\Hardcore\commands;

use HenryDM\Hardcore\Main;
use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use HenryDM\Hardcore\utils\PluginUtils;
use Vecnavium\FormsUI\SimpleForm;

class HardcoreCommand implements Listener {

    public function __construct(private Main $main) {
        $this->main = $main;
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        if($this->getMain()->cfg->get("world-manager-plugin") === "MultiWorld") {
            if($command->getName() == "hardcore") {
                if($sender instanceof Player){
                    $this->openHardcoreMW($sender);
                } else {
                    $sender->sendMessage("Use this command in game!");
                }
            }
        }

        if($this->getMain()->cfg->get("world-manager-plugin") === "Worlds") {
            if($command->getName() == "hardcore") {
                if($sender instanceof Player){
                    $this->openHardcoreML($sender);
                } else {
                    $sender->sendMessage("Use this command in game!");
                }
            }
        }
        return true;
    }

    public function openHardcoreMW($player) {
        $message = $this->getMain()->cfg->get("join-game-message"); 
        $world = $this->getMain()->cfg->get("hardcore-world", []);
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null) {
                return true;
            }
    
            switch($data) {
                case 0:
                    $this->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), "mw tp" . $world . $sender);
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

    public function openHardcoreWL($player) {
        $message = $this->getMain()->cfg->get("join-game-message");
        $world = $this->getMain()->cfg->get("hardcore-world", []);
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null) {
                return true;
            }
    
            switch($data) {
                case 0:
                    $this->getServer()->getCommandMap()->dispatch(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), "worlds teleport" . $sender . $world);
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