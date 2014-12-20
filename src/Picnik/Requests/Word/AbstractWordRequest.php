<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Message\ResponseInterface;
use Picnik\Client;
use Picnik\Exceptions\AuthorizationException;
use Picnik\Exceptions\RequestException;
use Picnik\Requests\AbstractRequest;

abstract class AbstractWordRequest extends AbstractRequest
{
	
	/**
	 * The word being requested.
	 * @var string
	 */
	protected $word;

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

}