<?php namespace Picnik\Requests\Word;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Message\Response as GuzzleResponse;
use GuzzleHttp\Subscriber\History as GuzzleHistory;
use GuzzleHttp\Subscriber\Mock as GuzzleMock;
use Picnik\TestCase;

class HyphenationRequestTest extends TestCase
{
	
	protected function getRequestInstance($word)
	{
		$c = $this->getClientMock();
		return new HyphenationRequest($c, $word);
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

		$r = new HyphenationRequest($c, 'foobar');
		$r->get();

		$gr = $gh->getLastRequest();

		$expectedTarget = 'https://api.wordnik.com/v4/word.json/foobar/hyphenation';

		$this->assertStringStartsWith($expectedTarget, $gr->getUrl());
		$this->assertEquals($r->getParameters(), $gr->getQuery()->toArray());
	}

	public function testSourceDictionaryParameterWithValue()
	{
		$r = $this->getRequestInstance('foobar');
		$r->sourceDictionary('foo');

		$this->assertSame('foo', $r->getParameters()['sourceDictionary']);
	}

	public function testSourceDictionaryParameterWithNull()
	{
		$r = $this->getRequestInstance('foobar');
		$r->sourceDictionary(null);

		$this->assertArrayNotHasKey('sourceDictionary', $r->getParameters());
	}

	public function testLimitParameterWorks()
	{
		$r = $this->getRequestInstance('foobar');
		$r->limit(7);

		$this->assertSame(7, $r->getParameters()['limit']);
	}

	public function testUseCanonicalParameterWorks()
	{
		$r = $this->getRequestInstance('foobar');
		$r->useCanonical(true);

		$this->assertSame('true', $r->getParameters()['useCanonical']);
	}

}