<?php

use MeiliSearch\Client;
use Tests\TestCase;

class AcceptNewFieldsTest extends TestCase
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

    public function testGetDefaultAcceptNewFields()
    {
        $res = static::$index->getAcceptNewFields();
        $this->assertTrue($res);
    }

    public function testUpdateAcceptNewFields()
    {
        $res = static::$index->updateAcceptNewFields(false);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('updateId', $res);
        static::$index->waitForPendingUpdate($res['updateId']);
        $this->assertFalse(static::$index->getAcceptNewFields());
    }
}
