<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;
use Picnik\Requests\LimitTrait;

/**
 * @author  Alan Ly <hello@alan.ly>
 */
class AudioRequest extends AbstractWordRequest implements LimitableInterface
{

	use LimitTrait;

	const API_METHOD = 'audio';

	/**
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	protected function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$baseMethod = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;
		$method = AudioRequest::API_METHOD;

		return "{$endpoint}/{$baseMethod}.{$format}/{$this->word}/{$method}";
	}
	
}
