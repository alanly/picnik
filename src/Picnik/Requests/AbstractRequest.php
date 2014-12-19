<?php namespace Picnik\Requests;

use Picnik\Client;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
abstract class AbstractRequest
{

	protected $client;
	protected $requestTarget;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function get()
	{
		return $this->client->get($this->requestTarget);
	}
	
}
