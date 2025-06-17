<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\Entity\Person;
use App\Repository\PersonRepository;

/**
 * @implements ProviderInterface<Person>
 */
class PersonProvider implements ProviderInterface
{
    public function __construct(
        private PersonRepository $personRepository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): iterable|Person|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->personRepository->findAll();
        }

        return $this->personRepository->find($uriVariables['id']);
    }
}