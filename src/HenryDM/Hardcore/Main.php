<?php

namespace HenryDM\Hardcore;

# =======================
#    Pocketmine Class
# =======================

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

# =======================
#      Plugin Class
# =======================

use HenryDM\Hardcore\Events\DeathEvent;
use HenryDM\Hardcore\Events\RespawnEvent;
use HenryDM\Hardcore\Events\HardcoreConfig;

# =======================
#      Command Class
# =======================

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use HenryDM\Hardcore\utils\PluginUtils;
use Vecnavium\FormsUI\SimpleForm;

class Main extends PluginBase implements Listener {  
    
    /*** @var Main|null */
    private static Main|null $instance;

    /*** @var Config */
    public Config $cfg;    

    public function onEnable() : void {
        $this->saveResource("config.yml");
        $this->cfg = $this->getConfig();

        $events = [
            DeathEvent::class,
            RespawnEvent::class,
            HardcoreConfig::class
        ];
        foreach($events as $ev) {
            $this->getServer()->getPluginManager()->registerEvents(new $ev($this), $this);
        }
    }

    public function onLoad() : void {
        self::$instance = $this;
    }

    public function getInstance() : Main {
        return self::$instance;
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
                    $message = $this->cfg->get("join-game-message");
					$command = $this->cfg->get("tp-game-command");
                    $this->getServer()->dispatchCommand($player, $command);
                    $player->sendMessage($message);
                break;

                case 1: 
                    PluginUtils::playSound($player, $this->cfg->get("start-game-form-button-exit-sound"), 1, 1);
                break;
            }
    
            });
            $form->setTitle($this->cfg->get("start-game-form-title"));
            $form->setContent($this->cfg->get("start-game-form-content"));
            $form->addButton($this->cfg->get("start-game-form-button-tp"));
            $form->addButton($this->cfg->get("start-game-form-button-exit"));
			$form->sendToPlayer($player);
            return $form;
    }

    public function getMainConfig() : Config {
        return $this->cfg;
    }
}