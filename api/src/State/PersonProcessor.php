<?php

namespace App\State;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Person;
use App\Repository\PersonRepository;

/**
 * @implements ProcessorInterface<Person, Person|void>
 */
final class PersonProcessor implements ProcessorInterface
{
    public function __construct(
        private PersonRepository $personRepository,
    ) {
    }

    /**
     * @return Person
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($operation instanceof Delete) {
            $this->personRepository->delete($data);
        } elseif ($operation instanceof Post || $operation instanceof Put) {
            $this->personRepository->save($data);
        }

        return $data;
    }
}