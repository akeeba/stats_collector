<?php
/*
 * @package   stats_collector
 * @copyright Copyright (c)2023-2023 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\UsageStats\Collector\Sender;

use Akeeba\UsageStats\Collector\Sender\Adapter\AdapterInterface;

class Sender
{
	private const ADAPTERS = [];

	/**
	 * The adapter to get the site's URL
	 *
	 * @var   null|AdapterInterface
	 * @since 1.0.0
	 */
	private $adapter = null;

	/**
	 * The URL to send the statistics to
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $serverUrl = '';

	/**
	 * The request timeout for sending the usage statistics, in seconds
	 *
	 * @var   int
	 * @since 1.0.0
	 */
	private $timeout = 5;

	public function __construct(string $serverUrl, int $timeout)
	{
		$this->serverUrl = $serverUrl;
		$this->timeout = $timeout;
	}

	/**
	 * Send the usage statistics information to the server
	 *
	 * @param   array  $queryParameters  The information to send
	 *
	 * @return  void
	 * @since   1.0.0
	 */
	public function sendStatistics(array $queryParameters): void
	{
		$adapter = $this->getAdapter();

		if ($adapter === null)
		{
			return;
		}

		$adapter->sendStatistics($queryParameters);
	}

	/**
	 * Get the appropriate adapter for sending statistics to the server
	 *
	 * @return  AdapterInterface|null
	 * @since   1.0.0
	 */
	private function getAdapter(): ?AdapterInterface
	{
		if ($this->adapter !== null)
		{
			return $this->adapter;
		}

		foreach (self::ADAPTERS as $className)
		{
			if (!class_exists($className))
			{
				continue;
			}

			/** @var AdapterInterface $o */
			$o = new $className;

			if (!$o->isAvailable())
			{
				continue;
			}

			$o->setServerUrl($this->serverUrl);
			$o->setTimeout($this->timeout);

			return $this->adapter = $o;
		}

		return null;
	}
}