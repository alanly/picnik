<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;
use Picnik\Requests\LimitTrait;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class DefinitionsRequest extends AbstractWordRequest implements LimitableInterface
{

	use LimitTrait;

	const API_METHOD = 'definitions';

	/**
	 * Defines the usage of the word. Refer to API documentation for greater
	 * detail and available choices. This method is chainable.
	 * @param  string $value a part-of-speech type
	 * @return DefinitionsRequest
	 */
	public function partOfSpeech($value)
	{
		$this->setParameter('partOfSpeech', $value);
		return $this;
	}

	/**
	 * Include a selection of related words with the requested definition. This
	 * method is chainable.
	 * @param  boolean $include to include related words or not
	 * @return DefinitionsRequest
	 */
	public function includeRelated($include = true)
	{
		$this->setParameter('includeRelated', ($include ? true : false));
		return $this;
	}

	/**
	 * The source dictionaries to retrieve the definition(s) from. Sources may
	 * either be a single option, a comma-delimited list of options, or an array
	 * of options. Please refer to the associated API documentation for greater
	 * detail and available choices. This method is chainable.
	 * @param  mixed $sources the sources to use
	 * @return DefinitionsRequest
	 */
	public function sourceDictionaries($sources = [])
	{
		if (is_array($sources) && count($sources) < 1) {
			$sources = 'all';
		}

		$this->setParameter('sourceDictionaries', $sources);
		return $this;
	}

	/**
	 * Adds XML tags to the definition. Please refer to API documentation for
	 * greater details. This method is chainable.
	 * @param  boolean $include to include XML tags in output or not
	 * @return DefinitionsRequest
	 */
	public function includeTags($include = true)
	{
		$this->setParameter('includeTags', ($include ? true : false));
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
		$method = DefinitionsRequest::API_METHOD;

		return "{$endpoint}/{$baseMethod}.{$format}/{$this->word}/{$method}";
	}
	
}
