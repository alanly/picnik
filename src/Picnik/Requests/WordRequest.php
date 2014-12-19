<?php namespace Picnik\Requests;

use Picnik\Client;

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
	 * The word being requested.
	 * @var string
	 */
	private $word;

	/**
	 * The parameters associated with the request.
	 * @var array
	 */
	private $parameters = [
		'useCanonical'       => false,
		'includeSuggestions' => true,
	];

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
		// Generate the appropriate request target.
		// Execute the request using Guzzle
		// Parse the response
		// Return the response
	}

	private function assembleRequestTarget()
	{
		// Append the API key to the parameter array
		// Convert the parameters into an appropriate request string.
		// Combine with the API endpoint, request type, and method name.
		// Return the resulting target.
	}
	
}
