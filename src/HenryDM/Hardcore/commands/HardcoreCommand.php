<?php 

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
        switch ($command->getName()) {

            case "hardcore":
                if ($sender instanceof Player) {
                    $this->openHardcoreUI($sender);
                } else {
                    $sender->sendMessage("Use this command in game!");
                break;
            }
        }
        return true;
    }

    public function openHardcoreUI($player) {
        $form = new SimpleForm(function(Player $player, int $data = null){
            if($data === null) {
                return true;
            }
    
            switch($data) {
                case 0:
                    $message = $this->getMain()->cfg->get()->cfg->get("join-game-message");
					$command = $this->getMain()->cfg->get("tp-game-command");
                    $this->getServer()->dispatchCommand($player, $command);
                    $player->sendMessage($message);
                break;

                case 1: 
                    PluginUtils::playSound($player, $this->getMain()->cfg->get("start-game-form-button-exit-sound"), 1, 1);
                break;
            }
    
            });
            $form->setTitle($this->getMain()->cfg->get("start-game-form-title"));
            $form->setContent($this->getMain()->cfg->get("start-game-form-content"));
            $form->addButton($this->getMain()->cfg->get("start-game-form-button-tp"));
            $form->addButton($this->getMain()->cfg->get("start-game-form-button-exit"));
			$form->sendToPlayer($player);
            return $form;
    }

    public function getMain() : Main {
        return $this->main;
    }
}    