<?php namespace Picnik;

use GuzzleHttp\Client as Guzzle;

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
	 * Create a new word request that allows us to query a specific word from
	 * the API.
	 * @param  string  $word  the word that we want to lookup
	 * @return WordRequest
	 */
	public function word($word)
	{
		return new Requests\Word\WordRequest($this, $word);
	}

	/**
	 * Create a new word:definitions request that allows us to retrieve a
	 * selection of definitions for a specific word from the API.
	 * @param  string  $word  the word to query
	 * @return DefinitionsRequest
	 */
	public function wordDefinitions($word)
	{
		return new Requests\Word\DefinitionsRequest($this, $word);
	}

	/**
	 * Create a new word:audio request that allows us to retrieve a temporary
	 * URL to an audio pronounciation of a word, from the API.
	 * @param  string  $word  the word to query
	 * @return Picnik\Requests\Word\AudioRequest
	 */
	public function wordAudio($word)
	{
		return new Requests\Word\AudioRequest($this, $word);
	}

	/**
	 * Create a new word:hyphenation request that allows us to retrieve the
	 * hyphenated variant of a word from the API.
	 * @param  string $word the word to query
	 * @return Picnik\Requests\Word\HyphentationRequest
	 */
	public function wordHyphenation($word)
	{
		return new Requests\Word\HyphenationRequest($this, $word);
	}

	/**
	 * Create a word:pronunciations request that allows us to retrieve the
	 * pronunciation hints from the API for a specific word.
	 * @param  string  $word  the associated word
	 * @return Picnik\Requests\Word\PronunciationsRequest
	 */
	public function wordPronunciations($word)
	{
		return new Requests\Word\PronunciationsRequest($this, $word);
	}

	/**
	 * Create a new word:relatedWords request that allows us to query for other
	 * words that are associated with the queried word.
	 * @param  string  $word  the associated word
	 * @return Picnik\Requests\Word\RelatedWordsRequest
	 */
	public function wordRelatedWords($word)
	{
		return new Requests\Word\RelatedWordsRequest($this, $word);
	}
	
}