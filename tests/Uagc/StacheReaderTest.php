<?php

use PHPUnit\Framework\TestCase;

class StacheReaderTest extends TestCase
{

    public function testCanBeInstantiatedWithValidParams()
    {
        $this->assertInstanceOf(
            Uagc\StacheReader::class,
            new Uagc\StacheReader([
                'protocol' => 'http',
                'port' => '123',
                'path' => '/one/two/three/',
                'domain' => 'one.two.com',
                'user_agent' => 'Test Agent'
            ])
        );
    }

    public function testCannotBeInstantiatedWithNoParams()
    {
        // at miminum, 'domain' must be passed
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader();
    }

    public function testCannotBeInstantiatedWithInvalidParams()
    {
        // protocol must be 'http' or 'https'
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader(['protocol' => 'invalid']);

        // port must be a number
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader(['port' => 'invalid']);

        // path must be a string (or empty value)
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader(['path' => ['invalid' => 'invalid']]);

        // domain must be a string (or empty value)
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader(['domain' => ['invalid' => 'invalid']]);

        // user_agent must be a string (or empty value)
        $this->expectException(InvalidArgumentException::class);
        new Uagc\StacheReader(['user_agent' => ['invalid' => 'invalid']]);

    }

    public function testReadFailsWithoutValidArgs()
    {
        $this->expectException(InvalidArgumentException::class);
        $sr = new Uagc\StacheReader(['domain' => 'one.two.com']);
        $sr->read();
    }

    public function testReadWorksWithValidArgs()
    {
        // this test only runs if these env vars are set
        if (getenv('STACHE_TEST_DOMAIN') &&
            getenv('STACHE_TEST_ITEM') &&
            getenv('STACHE_TEST_ITEMKEY')) {

            $sr = new Uagc\StacheReader(['domain' => getenv('STACHE_TEST_DOMAIN')]);
            $sItem = $sr->read(
                getenv('STACHE_TEST_ITEM'),
                getenv('STACHE_TEST_ITEMKEY')
            );

            $this->assertTrue(
                is_object($sItem)
            );
        }
    }

}

