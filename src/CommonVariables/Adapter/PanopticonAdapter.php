<?php
/*
 * @package   stats_collector
 * @copyright Copyright (c)2023-2023 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\UsageStats\Collector\CommonVariables\Adapter;

use Akeeba\Panopticon\Factory;
use Awf\Container\Container;

/**
 * Common Variables Interaction Adapter for Akeeba Panopticon
 *
 * @since  1.0.0
 */
class PanopticonAdapter extends AbstractAwfAdapter
{

	/**
	 * @inheritDoc
	 */
	protected function getContainer(): Container
	{
		return Factory::getContainer();
	}

	/**
	 * @inheritDoc
	 */
	public function isAvailable(): bool
	{
		return class_exists(\Akeeba\Panopticon\Container::class);
	}
}