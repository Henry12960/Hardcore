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
use HenryDM\Hardcore\commands\HardcoreCommand;

class Main extends PluginBase implements Listener {  
    
    /*** @var Main|null */
    private static Main|null $instance;

    /*** @var Config */
    public Config $cfg;    

    public function onEnable() : void {
        $this->saveResource("config.yml");
        $this->cfg = $this->getConfig(); 
        $this->LoadWorlds();

        $events = [
            DeathEvent::class,
            RespawnEvent::class,
            HardcoreConfig::class,
            HardcoreCommand::class
        ];
        foreach($events as $ev) {
            $this->getServer()->getPluginManager()->registerEvents(new $ev($this), $this);
        }
    }

    private function LoadWorlds() : void {
        if($this->getConfig()->get("auto-load-hardcore-world") === true) {
            $this->getServer()->getWorldManager()->loadWorld($this->getConfig()->get("hardcore-world"));
        }
    }

    public function onLoad() : void {
        self::$instance = $this;
    }

    public function getInstance() : Main {
        return self::$instance;
    }

    public function getMainConfig() : Config {
        return $this->cfg;
    }
}
