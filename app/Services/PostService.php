<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Cart;

class PostService extends BaseService
{
    function repositoryName(): string
    {
        return PostRepository::class;
    }

    public function paginate12($limit){
        return $this->paginate($limit);
    }

    public function filters($cate,$color,$size)
    {
        $param = $this->repository->getModel();
        if($cate){
            $param = $param->where('category_id',$cate);
        }
        if($color){
            $arr = [];
            foreach($color as $col){
                $param = $param->where('color','like','%'.$col.'%');
                if($param){
                    $arr[] = $param;
                }
            }
        }
        if($size){
            $arr = [];
            foreach($size as $siz){
                $param = $param->where('size','like','%'.$siz.'%');
                if($param){
                    $arr[] = $param;
                }
            }
        }
        return $param->get();

    }

    public function getPostPage ($perpage){
        $posts = $this->paginate([],$perpage);
        return $posts;
    }

    public function searchPost($data){
        $param = $this->repository->getModel();
        $posts = $param->Where('post_name','like','%'.$data.'%')->get();
        return $posts;
    }

    public function saveImg($file){
        $file_name = $file->getClientOriginalName();
        $file->move(public_path('img'),$file_name);

        return $file_name;
    }

    public function saveImgs($files){
        foreach($files as $value){
            $files_name = $value->getClientOriginalName();
            $value->move(public_path('img'),$files_name);
            $imgs[] = '/img/' . $files_name;
        }

        return $imgs;
    }

    public function deleteId($value){
        $datas =  explode(',',$value);
        foreach ($datas as $data){
            $this->find($data)->delete();
        }
        return true;
    }

    public function addCard($request){
        if ($request->idCard) {
            $post = $this->find($request->idCard);
            Cart::add(['id' => $post->id, 'name' => $post->post_name, 'qty' => 1, 'price' => $post->price, 'weight' => 0, 'options' => ['img' => $post->img]]);
        }
    }
}
