<?php namespace Picnik\Requests\Word;

use Picnik\Client;
use Picnik\Requests\LimitableInterface;

class RelatedWordsRequest extends AbstractWordRequest implements LimitableInterface
{

	const API_METHOD = 'relatedWords';

	/**
	 * Restrict the returned results to a particular relationship type. Please
	 * refer to the API documentation for the available options. This method is
	 * chainable.
	 * @param  string  $type  the specific relationship type to fetch
	 * @return RelatedWordsRequest
	 */
	public function relationshipTypes($type)
	{
		if (! $type) return $this;

		$this->setParameter('relationshipTypes', $type);
		return $this;
	}

	/**
	 * Limits the number of results returned, *per* relationship type selected.
	 * This method is chainable.
	 * @param  int  $count  the total number of results per type selected
	 * @return RelatedWordsRequest
	 */
	public function limitPerRelationshipType($count)
	{
		$limit = intval($count);
		$this->setParameter('limitPerRelationshipType', $limit);
		return $this;
	}

	/**
	 * Limits the number of results returned, *per* relationship type selected.
	 * This method is chainable.
	 * @param  int  $count  the total number of results per type selected
	 * @return RelatedWordsRequest
	 */
	public function limit($count)
	{
		return $this->limitPerRelationshipType($count);
	}

	/**
	 * Gets the API key from the Client instance and adds it to the request
	 * parameters. An `AuthorizationException` is thrown when the API key is
	 * missing from the Client.
	 * @throws  AuthorizationException  If API key is missing.
	 */
	protected function generateRequestTarget()
	{
		$endpoint = Client::API_ENDPOINT;
		$baseMethod = WordRequest::API_METHOD;
		$format = Client::RESPONSE_FORMAT;
		$method = self::API_METHOD;

		return "{$endpoint}/{$baseMethod}.{$format}/{$this->word}/{$method}";
	}

}
