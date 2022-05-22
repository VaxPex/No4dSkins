<?php

declare(strict_types=1);

namespace VaxPex;

use pocketmine\entity\Skin;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChangeSkinEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener
{

	protected function onEnable(): void
	{
		$this->saveResource("steve.json");
		$this->saveResource("alex.json");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$skin = $player->getSkin();
		$this->checkAndSetSkin($player, $skin);
	}

	public function onSkinChange(PlayerChangeSkinEvent $event)
	{
		$player = $event->getPlayer();
		$newSkin = $event->getNewSkin();
		$this->checkAndSetSkin($player, $newSkin);
	}

	private function checkAndSetSkin(Player $player, Skin $skin) {
		if ($skin->getGeometryName() === "geometry.humanoid.custom") {
			$player->setSkin(new Skin($player->getSkin()->getSkinId(),
				$player->getSkin()->getSkinData(),
				$player->getSkin()->getCapeData(),
				$player->getSkin()->getGeometryName(),
				file_get_contents($this->getDataFolder() . "steve.json"))
			);
			$player->sendSkin();
		} else if ($skin->getGeometryName() === "geometry.humanoid.customSlim") {
			$player->setSkin(new Skin($player->getSkin()->getSkinId(),
				$player->getSkin()->getSkinData(),
				$player->getSkin()->getCapeData(),
				$player->getSkin()->getGeometryName(),
				file_get_contents($this->getDataFolder() . "alex.json"))
			);
			$player->sendSkin();
		}
	}
}
