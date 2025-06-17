<?php

namespace App\DataTransformer;

use App\Entity\Person;

class PersonDataTransformer
{
    /**
     * @param array<string,string> $personData
     */
    public function transformToEntity(array $personData): Person
    {
        $person = new Person();
        $person->setId($personData['id']);
        $person->setFirstName($personData['first_name']);
        $person->setLastName($personData['last_name']);
        $person->setPhone($personData['phone']);
        $person->setEmail($personData['email']);

        return $person;
    }

    /**
     * @return array<string,string>
     */
    public function transformToData(Person $person): array
    {
        $personData = [
            'id' => $person->getId() ?? '',
            'first_name' => $person->getFirstName() ?? '',
            'last_name' => $person->getLastName() ?? '',
            'phone' => $person->getPhone() ?? '',
            'email' => $person->getEmail() ?? '',
        ];

        return $personData;
    }
}
