<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class PersonTest extends ApiTestCase
{
    private array $testPersonValid = [
        'firstName' => 'David',
        'lastName' => "Platt",
        'phone' => '01913478234',
        'email' => 'david.platt@corrie.co.uk',
    ];

    public function testGetPersonsEmpty(): void
    {
        // GET the Persons (zero expected)
        $client = static::createClient();
        $client->request('GET', '/persons');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Person',
            '@type' => 'Collection',
            'totalItems' => 0,
        ]);
    }

    public function testPostPersonsInvalid(): void
    {
        // POST a Person (returns the new Person)
        $personData = $this->testPersonValid;
        $personData['phone'] = 'This is too long';

        $client = static::createClient();
        $client->request('POST', '/persons', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $personData,
        ]);
        $this->assertResponseStatusCodeSame(422);
    }

    public function testPostPersonsValid(): void
    {
        // POST a Person (returns the new Person)
        $client = static::createClient();
        $client->request('POST', '/persons', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $this->testPersonValid,
        ]);
        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains(array_merge(
            [
                '@context' => '/contexts/Person',
                '@type' => 'Person',
            ],
            $this->testPersonValid,
        ));
    }

    public function testGetPersonsAndGetPerson(): void
    {
        // GET the Persons
        $client = static::createClient();
        $client->request('GET', '/persons');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Person',
            '@type' => 'Collection',
            'totalItems' => 1,
        ]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $firstId = $response['member'][0]['id'];

        // GET the first Person
        $client->request('GET', '/persons/'.$firstId);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains(array_merge(
            [
                '@context' => '/contexts/Person',
                '@type' => 'Person',
            ],
            $this->testPersonValid,
        ));
    }

    public function testGetPersonsAndPutPerson(): void
    {
        // GET the Persons
        $client = static::createClient();
        $client->request('GET', '/persons');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Person',
            '@type' => 'Collection',
            'totalItems' => 1,
        ]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $firstId = $response['member'][0]['id'];

        // PUT the first Person (change name from David to Dave)
        $personData = $this->testPersonValid;
        $personData['firstName'] = 'Dave';
        static::createClient()->request('PUT', '/persons/'.$firstId, [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => $personData,
        ]);
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains(array_merge(
            [
                '@context' => '/contexts/Person',
                '@type' => 'Person',
            ],
            $personData,
        ));
    }

    public function testGetPersonsAndDeletePerson(): void
    {
        // GET the Persons
        $client = static::createClient();
        $client->request('GET', '/persons');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Person',
            '@type' => 'Collection',
            'totalItems' => 1,
        ]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $firstId = $response['member'][0]['id'];

        // DELETE the first Person
        static::createClient()->request('DELETE', '/persons/'.$firstId);
        $this->assertResponseStatusCodeSame(204);

        // Check that there are no Persons remaining
        static::createClient()->request('GET', '/persons');
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Person',
            '@type' => 'Collection',
            'totalItems' => 0,
        ]);
    }
}
