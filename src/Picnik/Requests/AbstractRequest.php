<?php namespace Picnik\Requests;

use GuzzleHttp\Message\ResponseInterface;
use Picnik\Client;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
abstract class AbstractRequest
{

	/**
	 * @var Picnik\Client
	 */
	protected $client;

	/**
	 * The parameters associated with the request.
	 * @var array
	 */
	protected $parameters;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	/**
	 * Set a parameter to be used for the request.
	 * @param string $key
	 * @param mixed  $value
	 */
	public function setParameter($key, $value)
	{
		$this->parameters[$key] = $value;
	}

	/**
	 * Get an array of the parameters that will be used for the request.
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * Executes the GET request represented by the instance.
	 * @return mixed
	 */
	abstract public function get();

	/**
	 * Orchestrates the GET request and response parsing.
	 * @param  string $target     the target URL for the request
	 * @param  array  $parameters the parameters for the request
	 * @return mixed  the parsed response
	 */
	protected function performGetRequest($target, $parameters)
	{
		$response = $this->doGetRequest($target, $parameters);
		$result = $this->parseResponse($response);
		return $result;
	}

	/**
	 * Parses the request response and returns the appropriate representation.
	 * @param  ResponseInterface $response
	 * @return mixed
	 */
	abstract protected function parseResponse(ResponseInterface $response);

	/**
	 * Executes the GET request over the given target with the given GET parameters.
	 * @param  string $target     the target URL for the request
	 * @param  array  $parameters the parameters for the request
	 * @return ResponseInterface
	 */
	private function doGetRequest($target, $parameters)
	{
		// Execute the GET request to the given target, along with the given parameters.
		$guzzle = $this->client->getGuzzle();
		$response = $guzzle->get($target, ['query' => $parameters]);
		return $response;
	}
	
}
