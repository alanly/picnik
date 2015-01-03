<?php namespace Picnik\Requests;

interface SourceDictionaryInterface
{

	/**
	 * The dictionary to use as the source for the request. Please refer to the
	 * API documentation in order to see the available options. This method is 
	 * chainable.
	 * @param  string  $dictionary the source dictionary to use
	 * @return AbstractRequest
	 */
	public function sourceDictionary($dictionary);

}
