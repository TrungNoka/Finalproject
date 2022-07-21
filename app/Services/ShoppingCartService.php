<?php

namespace App\Services;

use App\Repositories\ShoppingCartRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Cart;
use Illuminate\Support\Facades\Auth;


class ShoppingCartService extends BaseService
{
    function repositoryName(): string
    {
        return ShoppingCartRepository::class;
    }

    public function updateOrDelete($request)
    {
        
        if ($request->deleteIdCard || $request->minusIdCard || $request->plusIdCard) {
           
            if ($request->deleteIdCard){
                Cart::remove($request->deleteIdCard); 
            }
            if ($request->minusIdCard){
                Cart::update($request->minusIdCard, $request->dataMinus - 1);
            }
            if ($request->plusIdCard) {
                Cart::update($request->plusIdCard, $request->dataPlus + 1);
            }
            
            if(Auth::check()){
                $cart = session('cart')['default'];
                $datas = [
                    'post_name' => $cart,
                    'user_id' => Auth::id(),
                ];
                $this->deteleCard($datas);
            }
        }

        if (Auth::check()) {
            if (session('cart')) {
                $cart = session('cart')['default'];
                $datas = [
                    'post_name' => $cart,
                    'user_id' => Auth::id(),
                ];
                $this->createOrUpdateUserId($datas);
                Cart::destroy();
            }
            $params = [
                'wheres' => [
                    'user_id' => Auth::id(),
                ]
            ];
            $cart = $this->filter($params)->first();
            $datas = $cart->post_name;
            foreach (json_decode($datas) as $data) {
                Cart::add(['id' => $data->id, 'name' => $data->name, 'qty' => $data->qty, 'price' => $data->price, 'weight' => 0, 'options' => ['img' => $data->options->img]]);
            }
        }
    }
}
