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
use HenryDM\Hardcore\Commands\Hardcore;
use HenryDM\Hardcore\Forms\JoinForm;

class Main extends PluginBase implements Listener {  
    
    /*** @var Main|null */
    private static Main|null $instance;

    /*** @var JoinForm[] */
    public JoinForm $joinfom; 

    /*** @var Config */
    public Config $cfg;    

    public function onEnable() : void {
        $this->saveResource("config.yml");
        $this->cfg = $this->getConfig();
        $this->loadGeneral();

        $events = [
            DeathEvent::class,
            RespawnEvent::class,
            HardcoreConfig::class
        ];
        foreach($events as $ev) {
            $this->getServer()->getPluginManager()->registerEvents(new $ev($this), $this);
        }
    }

    public function loadGeneral() : void {
        $this->getServer()->getCommandMap()->register("hardcore", new Hardcore($this, "hardcore", "Join in a hardcore mode", ["hc"]));    
		$this->joinform = new JoinForm();
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
