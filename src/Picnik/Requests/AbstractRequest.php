<?php namespace Picnik\Requests;

use GuzzleHttp\Message\ResponseInterface;
use Picnik\Client;
use Picnik\Exceptions\AuthorizationException;

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
	protected $parameters = [];

	public function __construct(Client $client)
	{
		$this->setClient($client);
	}

	/**
	 * Set the client instance to be used for the request.
	 * @param Client $client
	 */
	public function setClient(Client $client)
	{
		$this->client = $client;
	}

	/**
	 * Gets the client instance used for the request.
	 * @return Client
	 */
	public function getClient()
	{
		return $this->client;
	}

	/**
	 * Set a parameter to be used for the request.
	 * @param string $key
	 * @param mixed  $value
	 */
	public function setParameter($key, $value)
	{
		if (is_bool($value)) $value = ($value ? 'true' : 'false');

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
	 * Execute the request and return the parsed response.
	 * @return mixed
	 */
	public function get()
	{
		// Include the API key into the request parameters.
		$this->appendApiKeyToRequestParameters();
		
		// Create the query target.
		$target = $this->generateRequestTarget();
		 
		// Execute the request and return the parsed response.
		return $this->performGetRequest($target, $this->parameters);
	}

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
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	abstract protected function generateRequestTarget();

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

	/**
	 * Gets the API key from the Client instance and adds it to the request
	 * parameters. An `AuthorizationException` is thrown when the API key is
	 * missing from the Client.
	 * @throws  AuthorizationException  If API key is missing.
	 */
	private function appendApiKeyToRequestParameters()
	{
		if (! $this->client->getApiKey())
			throw new AuthorizationException('Missing API key.');

		$this->setParameter(
			Client::API_KEY_PARAM_NAME,
			$this->client->getApiKey()
		);
	}
	
}
