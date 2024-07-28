<?php
declare(strict_types=1);

namespace test\commands;

use nacre\form\class\CustomForm;
use nacre\form\class\ModalForm;
use nacre\form\class\SimpleForm;
use nacre\form\elements\buttons\ModalButton;
use nacre\form\elements\buttons\SimpleButton;
use nacre\form\elements\customs\Input;
use nacre\form\elements\customs\Label;
use nacre\form\elements\customs\Slider;
use nacre\form\elements\customs\Toggle;
use nacre\form\elements\icon\IconPath;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;

class FormCommand extends Command {

    public function __construct() {
        parent::__construct(
            'form',
            'Open a form',
            '/form <simple|custom|modal>'
        );
        $this->setPermission(DefaultPermissionNames::GROUP_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
        if (!$sender instanceof Player ) return;

        if(count($args) <= 0) {
            $sender->sendMessage($this->getUsage());
            return;
        }

        if($args[0] === 'simple') {
            $form = new SimpleForm(
                '§6Test',
                '§7Formulaire de test',
                [
                    new SimpleButton('test', '§aTest',null, new IconPath('textures/items/diamond')),
                    new SimpleButton('test2', '§cTest2',null, new IconPath('textures/items/apple'))
                ],
                function (Player $player, $data) : void {
                    $player->sendMessage('§aYou have selected §e' . $data . '§a.');
                }
            );
        }elseif($args[0] === 'custom') {
            $form = new CustomForm(
                '§6Test',
                [
                    new Input('test', '§aTest', '§7Entrez un texte'),
                    new Label( '§7Ceci est un label'),
                    new Slider('test2', '§cTest2', 0, 100, 1, 50),
                    new Toggle('test3', '§eTest3', false)
                ],
                function (Player $player, array $data) : void {
                    $player->sendMessage('§aYou have selected §e' . $data['test'] . '§a.');
                    $player->sendMessage('§aYou have selected §e' . $data['test2'] . '§a.');
                    $player->sendMessage('§aYou have selected §e' . $data['test3'] . '§a.');
                }
            );
        }else{
            $form = new ModalForm(
                '§6Test',
                '§7Formulaire de test',
                new ModalButton('test', '§aTest', null),
                new ModalButton('test2', '§cTest2', null),
                function (Player $player, $data) : void {
                    $player->sendMessage('§aYou have selected §e' . $data . '§a.');
                }
            );
        }
        $sender->sendForm($form);
    }

}