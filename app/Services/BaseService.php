<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

abstract class BaseService
{
    protected BaseRepository|null $repository = null;

    abstract function repositoryName(): string;

    public function __construct()
    {
        $this->setRepository();
    }

    private function setRepository()
    {
        $repositoryName = $this->repositoryName();
        $repository = app()->make($repositoryName);
        if (!($repository instanceof BaseRepository)) {
            throw new \Exception('Repository not found');
        }
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function get(array $params = [])
    {
        return $this->repository->get($params);
    }

    public function paginate(array $params = [], $limit = LIMIT)
    {
        return $this->repository->paginate($params, $limit);
    }

    public function filter(array $params = [])
    {
        return $this->repository->filter($params);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function findNotId(int $id)
    {
        return $this->repository->findNotId($id);
    }

    public function findBy(array $params = [])
    {
        return $this->repository->filter($params)->first();
    }

    public function create(array $params = [])
    {
        $params = $this->hashPassword($params);
        $item = $this->repository->create($params);

        return $item;
    }

    public function update(int $id, array $params = [])
    {
        $params = $this->hashPassword($params);

        $item = $this->repository->update($id, $params);

        return $item;
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }


    public function deleteAll(array $ids)
    {
        return $this->repository->deleteAll($ids);
    }

    public function deleteBy($value, $column)
    {
        return $this->repository->deleteBy($value, $column);
    }

    public function next($id, array $params = [])
    {
        $params['wheres'] = $params['wheres'] ?? [];
        $params['wheres'][] = ['id', '>', $id];
        $params['sort'] = 'id:asc';

        return $this->repository->filter($params)->first();
    }

    public function prev($id, array $params = [])
    {
        $params['wheres'] = $params['wheres'] ?? [];
        $params['wheres'][] = ['id', '<', $id];
        $params['sort'] = 'id:desc';

        return $this->repository->filter($params)->first();
    }

    protected function hashPassword($params)
    {
        if (!empty($value = Arr::get($params, 'password'))) {
            if ($salt = Arr::get($params, 'password_salt')) {
                $params['password'] = Hash::make($value, ['salt' => $salt]);
            } else {
                $params['password'] = Hash::make($value);
            }
        } else {
            // remove null or empty string password
            unset($params['password']);
            unset($params['password_salt']);
        }

        return $params;
    }

    public function createOrUpdate($params)
    {
        return $this->repository->createOrUpdate($params);
    }

    public function createOrUpdateUserId($params)
    {
        return $this->repository->createOrUpdateUserId($params);
    }

    public function deteleCard($params)
    {
        return $this->repository->deteleCard($params);
    }
    
}
