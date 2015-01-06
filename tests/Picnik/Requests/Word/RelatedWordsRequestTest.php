<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;
use GuzzleHttp\Subscriber\History as GuzzleHistory;
use GuzzleHttp\Subscriber\Mock as GuzzleMock;
use Picnik\TestCase;

class RelatedWordsRequestTest extends TestCase
{

	protected function getRequestInstance($word = 'foobar')
	{
		$c = $this->getClientMock();
		return new RelatedWordsRequest($c, $word);
	}

	public function testProperRequestGenerated()
	{
		// Create the necessary Guzzle instances to mock the request.
		$gc = new GuzzleClient;
		$gh = new GuzzleHistory;
		$gm = new GuzzleMock([new GuzzleResponse(200)]);

		// Attach subscribers to the client.
		$gc->getEmitter()->attach($gm);
		$gc->getEmitter()->attach($gh);

		$c = $this->getClientMock();
		$c->shouldReceive('getApiKey')->andReturn('foobar');
		$c->shouldReceive('getGuzzle')->andReturn($gc);

		$r = new RelatedWordsRequest($c, 'foobar');
		$r->get();

		$gr = $gh->getLastRequest();

		$expectedTarget = 'https://api.wordnik.com/v4/word.json/foobar/relatedWords';

		$this->assertStringStartsWith($expectedTarget, $gr->getUrl());
		$this->assertEquals($r->getParameters(), $gr->getQuery()->toArray());
	}

	public function testUseCanonicalWorks()
	{
		$r = $this->getRequestInstance();
		$r->useCanonical(true);

		$this->assertArrayHasKey('useCanonical', $r->getParameters());
		$this->assertSame('true', $r->getParameters()['useCanonical']);
	}

	public function testRelationshipTypesWithNullDoesNotAddParameter()
	{
		$r = $this->getRequestInstance();
		$r->relationshipTypes(null);

		$this->assertArrayNotHasKey('relationshipTypes', $r->getParameters());
	}

	public function testRelationshipTypesWithValueAddsParameterAndValue()
	{
		$r = $this->getRequestInstance();
		$r->relationshipTypes('bar');

		$this->assertArrayHasKey('relationshipTypes', $r->getParameters());
		$this->assertSame('bar', $r->getParameters()['relationshipTypes']);
	}

	public function testLimitPerRelationshipTypeMethodAddsParameter()
	{
		$r = $this->getRequestInstance();
		$r->limitPerRelationshipType(7);

		$this->assertArrayHasKey('limitPerRelationshipType', $r->getParameters());
		$this->assertSame(7, $r->getParameters()['limitPerRelationshipType']);
	}

	public function testLimitableMethodWrapsLimitPerRelationshipType()
	{
		$r = $this->getRequestInstance();
		$r->limit(7);

		$this->assertArrayHasKey('limitPerRelationshipType', $r->getParameters());
		$this->assertSame(7, $r->getParameters()['limitPerRelationshipType']);
	}

}
