<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;
use Picnik\Requests\LimitTrait;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class HyphenationRequest extends AbstractWordRequest implements LimitableInterface
{

	use LimitTrait;

	const API_METHOD = 'hyphenation';

	/**
	 * The dictionary to retrieve the hyphenation from. Please refer to the API
	 * documentation for further details concerning available options. This method
	 * is chainable.
	 * @param  string  $dictionary the source dictionary to use
	 * @return HyphenationRequest
	 */
	public function sourceDictionary($dictionary = null)
	{
		if (! $dictionary) return $this;

		$this->setParameter('sourceDictionary', $dictionary);
		return $this;
	}

	/**
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	public function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$baseMethod = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;
		$method = HyphenationRequest::API_METHOD;

		return "{$endpoint}/{$baseMethod}.{$format}/{$this->word}/{$method}";
	}
	
}