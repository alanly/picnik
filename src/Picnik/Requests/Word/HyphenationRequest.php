<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;
use Picnik\Requests\LimitTrait;
use Picnik\Requests\SourceDictionaryInterface;
use Picnik\Requests\SourceDictionaryTrait;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class HyphenationRequest
	extends AbstractWordRequest
	implements LimitableInterface, SourceDictionaryInterface
{

	use LimitTrait;
	use SourceDictionaryTrait;

	const API_METHOD = 'hyphenation';

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