<?php

namespace HenryDM\Hardcore\Commands;

use pocketmine\Server;
use HenryDM\Hardcore\Main;
use pocketmine\player\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseCommand;

class Hardcore extends BaseCommand {

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if($sender instanceof Player) {
            Main::getInstance()->joinform->JoinForm($sender);
        } else {
            $sender->sendMessage("Use this command in-game!");
        }
    }

    protected function prepare(): void {
        $this->setPermission("hardcore.use");
    }
}