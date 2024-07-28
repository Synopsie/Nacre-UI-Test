<?php
declare(strict_types=1);

namespace test\commands;

use nacre\gui\class\ChestMenu;
use nacre\gui\InventoryContent;
use nacre\gui\transaction\MenuTransaction;
use nacre\gui\transaction\MenuTransactionResult;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;

class GuiCommand extends Command {

    public function __construct() {
        parent::__construct(
            'gui',
            'Open a gui',
            '/gui <chest>'
        );
        $this->setPermission(DefaultPermissionNames::GROUP_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$sender instanceof Player) return;

        if(count($args) <= 0) {
            $sender->sendMessage($this->getUsage());
            return;
        }

        $menu = new ChestMenu(
            $sender,
            'Test',
            true,
            [
                new InventoryContent(10, VanillaItems::AMETHYST_SHARD())
            ],
            function (Player $player, MenuTransaction $result) : MenuTransactionResult {
                $player->sendMessage('Clicked slot ' . $result->getSlot());
                return $result->continue();
            }
        );
        $menu->send($sender);
    }
}