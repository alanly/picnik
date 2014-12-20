<?php namespace Picnik\Requests;

use GuzzleHttp\Message\ResponseInterface;
use Picnik\Client;
use Picnik\Exceptions\AuthorizationException;
use Picnik\Exceptions\RequestException;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class WordRequest extends AbstractRequest
{

	/**
	 * Declares the API method name that will handle this request.
	 */
	const API_METHOD = 'word';

	/**
	 * The parameters associated with the request.
	 * @var array
	 */
	protected $parameters = [
		'useCanonical'       => false,
		'includeSuggestions' => true,
	];

	/**
	 * The word being requested.
	 * @var string
	 */
	private $word;

	/**
	 * Construct a new word request using a Client and associated word.
	 * @param Client $client the Client instance performing the request
	 * @param string $word   the word that is being requested
	 */
	public function __construct(Client $client, $word)
	{
		parent::__construct($client);
		$this->word = $word;
	}

	/**
	 * Get the word being requested.
	 * @return string
	 */
	public function getWord()
	{
		return $this->word;
	}

	/**
	 * Set the word being requested.
	 * @param string $word
	 */
	public function setWord($word)
	{
		$this->word = $word;
	}

	/**
	 * Use the canonical variant of the word if necessary. This is a chainable
	 * function.
	 *
	 * The API does not guarantee the return of a canonical word.
	 * @param  boolean $use
	 * @return WordRequest
	 */
	public function useCanonical($use = true)
	{
		$this->setParameter('useCanonical', ($use ? true : false));
		return $this;
	}

	/**
	 * Include alternate suggestions for the requested word. This is a chainable
	 * function.
	 *
	 * The API does not guarantee the return of suggested words.
	 * @param  boolean $include
	 * @return WordRequest
	 */
	public function includeSuggestions($include = true)
	{
		$this->setParameter('includeSuggestions', ($include ? true : false));
		return $this;
	}

	/**
	 * Execute the request and return the parsed response as a stdClass object.
	 * @return stdClass
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
	 * Given a response, will check for errors and return the resulting data.
	 * @param  ResponseInterface $response
	 * @return stdClass
	 */
	protected function parseResponse(ResponseInterface $response)
	{
		// Check for response errors (! 200)
		$this->checkResponseErrors($response);
		
		// Decode the JSON response into a PHP object.
		return $response->json(['object' => true]);
	}

	/**
	 * Checks the given response for error codes, throwing the appropriate
	 * exceptions if needed.
	 * @param  ResponseInterface $response
	 */
	protected function checkResponseErrors(ResponseInterface $response)
	{
		$status = intval($response->getStatusCode());

		if ($status === 200) return;

		switch ($status) {
			case 401:
				throw new AuthorizationException($response);
			default:
				throw new RequestException($response);
		}
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

	/**
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	private function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$method = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;

		return "{$endpoint}/{$method}.{$format}/{$this->word}";
	}
	
}
