<?php

namespace App\Tests\Unit\DataTransformer;

use App\DataTransformer\PersonDataTransformer;
use App\Entity\Person;
use PHPUnit\Framework\TestCase;

class PersonDataTransformerTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function testTransformToEntity(): void
    {
        $personDataTransformer = new PersonDataTransformer();
        $person = $personDataTransformer->transformToEntity([
            'id' => 'Id',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'phone' => 'Phone',
            'email' => 'Email',
        ]);

        $this->assertEquals('Id', $person->getId());
        $this->assertEquals('Firstname', $person->getFirstName());
        $this->assertEquals('Lastname', $person->getLastName());
        $this->assertEquals('Phone', $person->getPhone());
        $this->assertEquals('Email', $person->getEmail());
    }

    public function testTransformToData(): void
    {
        $personDataTransformer = new PersonDataTransformer();

        $person = new Person();
        $person->setId('Id');
        $person->setFirstName('Firstname');
        $person->setLastName('Lastname');
        $person->setPhone('Phone');
        $person->setEmail('Email');

        $personData = $personDataTransformer->transformToData($person);

        $this->assertEquals('Id', $personData['id']);
        $this->assertEquals('Firstname', $personData['first_name']);
        $this->assertEquals('Lastname', $personData['last_name']);
        $this->assertEquals('Phone', $personData['phone']);
        $this->assertEquals('Email', $personData['email']);
    }
}
