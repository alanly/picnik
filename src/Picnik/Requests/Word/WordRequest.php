<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Message\ResponseInterface;
use Picnik\Client;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class WordRequest extends AbstractWordRequest
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
	 * Use the canonical variant of the word if necessary. This is a chainable
	 * function. The API does not guarantee the return of a canonical word.
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
	 * function. The API does not guarantee the return of suggested words.
	 * @param  boolean $include
	 * @return WordRequest
	 */
	public function includeSuggestions($include = true)
	{
		$this->setParameter('includeSuggestions', ($include ? true : false));
		return $this;
	}

	/**
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	protected function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$method = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;

		return "{$endpoint}/{$method}.{$format}/{$this->word}";
	}
	
}
