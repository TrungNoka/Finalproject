<?php

namespace App\Repositories;

use App\Traits\HasQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository {
    use HasQuery;

    protected Model $model;

    abstract function modelName(): string;

    public function __construct()
    {
        $this->setModel();
    }

    private function setModel()
    {
        $modelName = $this->modelName();
        $model = new $modelName;
        if (!($model instanceof Model)) {
            throw new \Exception('Model not found');
        }
        $this->model = $model;
    }

    function getModel(): Model
    {
        return $this->model;
    }

    public function find(int $id): ?Model
    {
        return $this->findBy($id);
    }

    public function findNotId(int $id)
    {
        return $this->findByNot($id);
    }

    public function with($with, $value, $column = 'id'){
        return $this->getModel()->with($with)->where($column, $value)->first();
    }

    public function findBy($value, $column = 'id'): ?Model
    {
        return $this->getModel()->where($column, $value)->first();
    }

    public function findByNot($value, $column = 'id')
    {
        return $this->getModel()->where($column, '!=' , $value)->get();
    }

    public function filter(array $params): Builder
    {
        $query = $this->getModel()->query();

        // query common field
        $whereEquals = $this->buildWhereEqual(array_merge($params['where_equals'] ?? [], $params['wheres'] ?? []));
        $whereLikes = $this->buildWhereLike(array_merge($params['where_likes'] ?? [], $params['likes'] ?? []));
        $whereIns = $this->buildWhereIn($params['where_ins'] ?? []);
        $whereHas = $this->cleanValueNull($params['where_has'] ?? []);
        $orWheres = $this->cleanValueNull($params['or_wheres'] ?? []);
        $inMonth = $this->cleanValueNull($params['in_month'] ?? []);
        $whereRaws = $params['where_raw'] ?? [];
        $notNull = $params['not_null'] ?? '';
        $sort = $this->buildSort($params['sort'] ?? '');
        $relates = $params['relates'] ?? null;

        // multi sort
        $sorts = [];
        $sortsParam = ($params['sorts'] ?? []);
        if (is_array($sortsParam)) {
            foreach ($sortsParam as $sortParam){
                $sorts[] = $this->buildSort($sortParam);
            }
        }

        $query
            ->when($notNull, function ($query) use ($notNull) {
                $query->whereNotNull($notNull);
            })
            ->when($whereRaws, function ($query) use ($whereRaws) {
                $query->whereRaw($whereRaws);
            })
            ->when($inMonth, function ($query) use ($inMonth) {
                foreach ($inMonth as $key => $monthYear){
                    $query->whereYear($key, date_format($monthYear, 'Y'));
                    $query->whereMonth($key, date_format($monthYear, 'm'));
                }
            })
            ->when($whereEquals, function ($query) use ($whereEquals) {
                $query->where($whereEquals);
            })
            ->when($whereIns, function ($query) use ($whereIns) {
                foreach ($whereIns as $key => $in)
                    $query->whereIn($key, $in);
            })
            ->when($whereLikes, function ($query) use ($whereLikes) {
                $query->where($whereLikes);
            })
            ->when(!empty($whereHas), function ($query) use ($whereHas) {
                foreach ($whereHas as $relateName => $conditions) {
                    if (!empty($conditions)) {
                        if (is_array($conditions)) {
                            $query->whereHas($relateName, function ($subQuery) use ($conditions) {
                                foreach ($conditions as $column =>$condition) {
                                    if (is_array($condition) && ($condition[0] ?? false) && ($condition[2] ?? false) && strtoupper($condition[1] ?? false) === 'IN') {
                                        $subQuery->whereIn($condition[0], $condition[2]);
                                    } else if (is_callable($condition)) {
                                        $subQuery->where($condition);
                                    } else if (is_array($condition)) {
                                        $subQuery->where([$condition]);
                                    } else {
                                        $subQuery->where($column, $condition);
                                    }
                                }
                            });
                        } else {
                            $query->whereHas($relateName, $conditions);
                        }
                    }
                }
            })
            ->when(!empty($orWheres), function ($query) use ($orWheres) {
                $query->where(function ($query) use ($orWheres) {
                    foreach ($orWheres as $orWhere) {
                        $query->orWhere($orWhere);
                    }
                });
            })
            ->when(!empty($sorts), function ($query) use ($sorts) {
                foreach ($sorts as $sort) {
                    if (!empty($sort)) {
                        if (str_contains($sort['column'], 'raw|')) {
                            $sort['column'] = str_replace('raw|', '', $sort['column']);
                            $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                        } else {
                            $query->orderBy($sort['column'], $sort['direction']);
                        }

                    }
                }
            })
            ->when(!empty($sort), function ($query) use ($sort) {
                if (str_contains($sort['column'], 'raw|')) {
                    $sort['column'] = str_replace('raw|', '', $sort['column']);
                    $query->orderByRaw($sort['column'] . ' ' . $sort['direction']);
                } else {
                    $query->orderBy($sort['column'], $sort['direction']);
                }
            })
            ->when(!empty($relates), function ($query) use ($relates) {
                $query->with($relates);
            });
        return $query;
    }

    public function get(array $params = []): Collection
    {
        return $this->filter($params)->get();
    }

    public function paginate(array $params = [], $limit = PER_PAGE)
    {
        return $this->filter($params)->paginate($limit);
    }

    public function create(array $params)
    {
        return $this->getModel()->create($params);
    }

    public function update($id, array $params)
    {
        $result = $this->getModel()->find($id);
        $result->fill($params);
        $saved = $result->save();

        return $saved ? $result : null;
    }

    public function createOrUpdate(array $params)
    {
        $model = $this->getModel();

        if(!empty($params['_find']) && $filter = $this->filter($params['_find'])->first())
            $model = $filter;

        $model->fill($params);
        return $model->save();
    }

    public function createOrUpdateUserId($params)
    {
        $model = $this->getModel();
        if($filter = $this->getModel()->where('user_id',$params['user_id'])->first()){
            $dataPost = json_decode($filter->post_name,true);
                foreach($dataPost as $key => $data){
                    $check_data = $params['post_name']->whereIn('id',$data['id'])->first();
                    if(!$check_data){
                        $params['post_name'][] = $data;
                    }
                }
                $filter->post_name = json_encode($params['post_name']);
            $model = $filter;
        }else{
            $params['post_name'] = json_encode($params['post_name']);
        }
        // dd($params);
        // $model->fill($params);
        $model->save();
        return true;
    }

    public function deteleCard($params)
    {
        $model = $this->getModel()->where('user_id',$params['user_id'])->first();
        $model->post_name = json_encode($params['post_name']);
            
        $model->save();
        return true;
    }

    public function updateWithTimestamp($id, array $params, $timestamps  = true)
    {
        $result = $this->getModel()->find($id);
        $result->fill($params);
        $result->timestamps = $timestamps;
        $saved = $result->save();

        return $saved ? $result : null;
    }

    public function searchPost($data){
        $model = $this->getModel();
        return $model->where('post_name', 'like', '%' . $data . '%')->get();
    }

    public function delete(int $id)
    {
        return $this->getModel()->where('id', $id)->delete();
    }

    public function forceDelete(int $id)
    {
        return $this->getModel()->where('id', $id)->forceDelete();
    }

    public function deleteAll(array $ids)
    {
        return $this->getModel()->whereIn('id', $ids)->delete();
    }

    public function insert(array $params)
    {
        return $this->getModel()->insert($params);
    }

    public function deleteBy($value, $column = 'id')
    {
        return $this->getModel()->where($column, $value)->delete();
    }

    public function getTable(){
        return $this->getModel()->getTable();
    }
}
