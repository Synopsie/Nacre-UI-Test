<?php
declare(strict_types=1);

namespace test;

use pocketmine\plugin\PluginBase;
use test\commands\FormCommand;
use test\commands\GuiCommand;

class Main extends PluginBase {

    protected function onEnable() : void {
        $this->getLogger()->info("Enable Nacre-UI test plugin.");

        $this->getServer()->getCommandMap()->registerAll('Test', [
            new FormCommand(),
            new GuiCommand()
        ]);
    }

}