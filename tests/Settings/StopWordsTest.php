<?php

use MeiliSearch\Client;
use Tests\TestCase;

class StopWordsTest extends TestCase
{
    private static $client;
    private static $index;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$client = new Client('http://localhost:7700', 'masterKey');
        static::$client->deleteAllIndexes();
        static::$index = static::$client->createIndex('uid');
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        static::$client->deleteAllIndexes();
    }

    public function testGetDefaultStopWords()
    {
        $res = static::$index->getStopWords();
        $this->assertIsArray($res);
        $this->assertEmpty($res);
    }

    public function testUpdateStopWords()
    {
        $new_sw = ['the'];
        $res = static::$index->updateStopWords($new_sw);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('updateId', $res);
        static::$index->waitForPendingUpdate($res['updateId']);
        $sw = static::$index->getStopWords();
        $this->assertIsArray($sw);
        $this->assertEquals($new_sw, $sw);
    }

    public function testResetStopWords()
    {
        $res = static::$index->resetStopWords();
        $this->assertIsArray($res);
        $this->assertArrayHasKey('updateId', $res);
        static::$index->waitForPendingUpdate($res['updateId']);
        $sw = static::$index->getStopWords();
        $this->assertIsArray($sw);
        $this->assertEmpty($sw);
    }
}
