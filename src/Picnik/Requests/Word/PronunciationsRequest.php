<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;
use Picnik\Requests\LimitTrait;
use Picnik\Requests\SourceDictionaryInterface;
use Picnik\Requests\SourceDictionaryTrait;

class PronunciationsRequest
	extends AbstractWordRequest
	implements LimitableInterface, SourceDictionaryInterface
{

	use LimitTrait, SourceDictionaryTrait;

	const API_METHOD = 'pronunciations';

	/**
	 * Determines the pronunciation format that should be returned for this
	 * request. Please refer to the API documentation in order to determine the
	 * possible options and appropriate usage. This method is chainable.
	 * @param  string  $format  the pronunciation format to use
	 * @return PronuncationsRequest
	 */
	public function typeFormat($format)
	{
		if (! $format) return $this;
		$this->setParameter('typeFormat', $format);
		return $this;
	}

	/**
	 * Generates the request target URL based on the requested word.
	 * @return string
	 */
	protected function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$baseMethod = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;
		$method = PronunciationsRequest::API_METHOD;

		return "{$endpoint}/{$baseMethod}.{$format}/{$this->word}/{$method}";
	}

}