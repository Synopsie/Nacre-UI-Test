<?php
declare(strict_types=1);

namespace test;

use nacre\NacreUI;
use nacre\scoreboard\ScoreBoard;
use nacre\scoreboard\ScoreBoardContent;
use nacre\scoreboard\ScoreBoardTask;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use test\commands\FormCommand;
use test\commands\GuiCommand;

class Main extends PluginBase implements Listener {

    protected function onEnable() : void {

        require $this->getFile() . 'vendor/autoload.php';

        $this->getLogger()->info("Enable Nacre-UI test plugin.");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $this->getServer()->getCommandMap()->registerAll('Test', [
            new FormCommand(),
            new GuiCommand()
        ]);
        NacreUI::register($this);
    }

    public function sendScoreBoard(PlayerJoinEvent $event) : void {
        $content = new ScoreBoardContent('§eNacre-UI', '§aHello', '§bWorld');
        $scoreboard = new ScoreBoard($event->getPlayer(), $content);
        $this->getScheduler()->scheduleRepeatingTask(new ScoreBoardTask($scoreboard, function (array $lines) : array {
            $lines[0] = '§b' . $lines[0] . mt_rand(0, 9);
            $lines[1] = '§a' . $lines[1] . mt_rand(0, 9);
            return $lines;
        }), 20);
    }

}