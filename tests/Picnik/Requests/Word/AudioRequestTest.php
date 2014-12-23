<?php namespace Picnik\Requests\Word;

use Picnik\TestCase;

class AudioRequestTest extends TestCase
{

	protected function getRequestInstance($word)
	{
		$client = $this->getClientMock();
		return new AudioRequest($client, $word);
	}

	public function testLimitParameter()
	{
		$inst = $this->getRequestInstance('foobar');
		$inst->limit(15);

		$this->assertSame(15, $inst->getParameters()['limit']);
	}
	
}
