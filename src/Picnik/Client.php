<?php namespace Picnik;

use GuzzleHttp\Client as Guzzle;
use Picnik\Requests\WordRequest;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class Client
{

	/**
	 * Defines the endpoint of the current version of the Wordnik API.
	 */
	const API_ENDPOINT = 'https://api.wordnik.com/v4';

	/**
	 * Defines the desired response format from the API.
	 */
	const RESPONSE_FORMAT = 'json';

	/**
	 * Defines the parameter key that refers to the API key.
	 */
	const API_KEY_PARAM_NAME = 'api_key';

	/**
	 * The API key used for the current session.
	 * @var string
	 */
	private $apiKey;

	/**
	 * An instance of the GuzzleHttp client.
	 * @var Guzzle
	 */
	protected $guzzle;

	/**
	 * Construct a new Client instance.
	 * @param Guzzle|null $guzzle
	 */
	public function __construct(Guzzle $guzzle = null)
	{
		if (! $guzzle) {
			$this->guzzle = new Guzzle;
		} else {
			$this->guzzle = $guzzle;
		}
	}

	/**
	 * Set the API key to use for the request session.
	 * @param  string  $key
	 * @return void
	 */
	public function setApiKey($key)
	{
		$this->apiKey = $key;
	}

	/**
	 * Gets the API key being used for the request session.
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * Returns an instance of `GuzzleHttp\Client`.
	 * @return Guzzle
	 */
	public function getGuzzle()
	{
		return $this->guzzle;
	}

	/**
	 * Create a new Word request that allows us to query a specific word from
	 * the API.
	 * @param  string $word the word that we want to lookup
	 * @return WordRequest
	 */
	public function word($word)
	{
		return new WordRequest($this, $word);
	}
	
}