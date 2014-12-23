<?php namespace Picnik;

/**
 * @author Alan Ly <hello@alan.ly>
 */
class ClientTest extends TestCase
{

	public function testSetApiInstanceKeyInSetter()
	{
		$c = new Client;
		$c->setApiKey('foobar');

		$this->assertSame('foobar', $c->getApiKey());
	}

	public function testWordRequestInstanceCreatedForWord()
	{
		$c = new Client;
		$c->setApiKey('foobar');

		$request = $c->word('bar');

		$this->assertInstanceOf('Picnik\Requests\Word\WordRequest', $request);
	}

	public function testDefinitionInstanceCreatedForWord()
	{
		$c = new Client;
		$c->setApiKey('foobar');

		$request = $c->wordDefinitions('bar');

		$this->assertInstanceOf('Picnik\Requests\Word\DefinitionsRequest', $request);
	}

	public function testAudioInstanceCreatedForWord()
	{
		$c = new Client;
		$c->setApiKey('foobar');

		$request = $c->wordAudio('bar');

		$this->assertInstanceOf('Picnik\Requests\Word\AudioRequest', $request);
	}

}
