<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositiry
{
    /**
     * @var Model
     */
    public $model;
    
    /**
     * @param Model $model
     */
    public function __construct(Model $mode = null)
    {
        $this->model = $mode;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    public function latest()
    {
        $query = $this->model::query();

        //Boolean: checking Is model has timestamps `true or false`
        return $this->model->timestamps ? $query->latest() : $query->latest("id");
    }

    public function getLatest($columns = ['*'])
    {
        return $this->latest()->get($columns);
    }

    /**
     * @param integer $id
     * @return Model|null
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param integer $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param string $slug
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findByQuery($query)
    {
        return $this->model->where($query)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->model->query();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function instance(array $attributes = [])
    {
        $model = $this->model;
        return new $model($attributes);
    }

    /**
     * @param int|null $perPage
     * @return mixed
     */
    public function paginate($perPage = null, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data = [])
    {
        return $this->model->create($data);
    }

    public function store(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param integer $id
     * @param array $data
     * @return Model
     */
    public function update(array $data = [], $id)
    {
        $instance = $this->findOrFail($id);
        $instance->fill($data);
        $instance->save();
        return $instance;
    }

    /**
     * @param integer $id
     * @return Model
     * @throws \Exception
     */
    public function delete($id)
    {
        $model = $this->findOrFail($id);
        $model->delete();
    }

    public function getSingle($id)
    {
        return $this->model::singleInfo()->findorfail($id);
    }

    public function getPaginated($data = [], $columns = ['*'])
    {
        $pagination_length = $data["page_size"] ?? 10;
        $query = $this->model::listingInfo()->filters($data);

        //Boolean: checking Is model has timestamps `true or false`
        $this->model->timestamps ? $query->latest() : $query->latest("id");

        return $query->paginate($pagination_length, $columns);
    }
}