<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Locator\TableLocator;

class DatabaseUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users;
    /**
     * @var TableLocator
     */
    private $tableLocator;


    public function __construct(\Cake\ORM\Locator\TableLocator $tableLocator)
    {
        $this->tableLocator = $tableLocator;
    }

    public function findAll(): array
    {
        return $this->tableLocator->get('Users')
            ->find()
            ->all()
            ->map(fn($entity) => $this->mapUser($entity))
            ->toArray();
    }

    public function findUserOfId(int $id): User
    {
        try {
            $user = $this->tableLocator->get('Users')->get($id);

            return $this->mapUser($user);
        } catch (RecordNotFoundException $e) {
            throw new UserNotFoundException();
        }
    }

    protected function mapUser($entity)
    {
        return new User(
            $entity->get('id'),
            $entity->get('username'),
            $entity->get('first_name'),
            $entity->get('last_name')
        );
    }
}
