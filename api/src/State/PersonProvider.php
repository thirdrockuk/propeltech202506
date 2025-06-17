<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
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

        $id = isset($uriVariables['id']) && is_string($uriVariables['id']) ? $uriVariables['id'] : null;

        return !is_null($id) ? $this->personRepository->find($id) : null;
    }
}
