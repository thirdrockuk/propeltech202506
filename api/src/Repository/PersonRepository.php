<?php

namespace App\Repository;

use App\Entity\Person;
use App\DataTransformer\PersonDataTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpKernel\KernelInterface;

class PersonRepository
{
    private ?string $filePath = null;
    /** @var array<string,array<string,string>> */
    private array $personsDataIndexedOnId = [];

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly PersonDataTransformer $personDataTransformer,
    ) {
        $fileDir = $this->kernel->getProjectDir().'/var/data';
        $this->filePath = $fileDir.'/storage.json';

        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        if (!file_exists($this->filePath)) {
            $this->initialiseStorage();
        }

        try {
            $personsData = json_decode(file_get_contents($this->filePath), true);
            foreach ($personsData as $personData) {
                $this->personsDataIndexedOnId[$personData['id']] = $personData;
            }
        } catch (\Exception $e) {
            $this->personsDataIndexedOnId = [];
        }
    }

    private function initialiseStorage(): void
    {
        file_put_contents($this->filePath, json_encode([]));
    }

    private function updateStorage(): void
    {
        file_put_contents($this->filePath, json_encode(array_values($this->personsDataIndexedOnId)));
    }

    /**
     * @return Collection<int,Person>
     */
    public function findAll(): Collection
    {
        $persons = new ArrayCollection();
        foreach ($this->personsDataIndexedOnId as $personData) {
            $persons->add($this->personDataTransformer->transformToEntity($personData));
        }

        return $persons;
    }

    public function delete(Person $person): void
    {
        unset($this->personsDataIndexedOnId[$person->getId()]);
        $this->updateStorage();
    }

    public function find(string $id): ?Person
    {
        $personData = $this->personsDataIndexedOnId[$id] ?? null;
        if (is_null($personData)) {
            return null;
        }

        return $this->personDataTransformer->transformToEntity($personData);
    }

    public function save(Person $person): Person
    {
        $personData = $this->personDataTransformer->transformToData($person);
        $this->personsDataIndexedOnId[$person->getId()] = $personData;

        $this->updateStorage();
        
        return $person;
    }
}