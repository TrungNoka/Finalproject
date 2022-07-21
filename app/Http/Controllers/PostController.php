<?php

namespace App\Http\Controllers;

use App\Jobs\SendWelcomeEmail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\DB;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\SizeService;
use App\Services\ShoppingCartService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Cart;
use Mail;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostService         $postService,
        private CategoryService     $categoryService,
        private ColorService        $colorService,
        private SizeService         $sizeService,
        private ShoppingCartService $shoppingCartService,
    )
    {

    }

    public function index(Request $request)
    {
        $post = $this->postService->getPostPage(12);
        $viewdata = [
            'post' => $post,
        ];

        return view('finalproject.home')->with($viewdata);
    }

    public function filter(Request $request)
    {
        if ($request->checkvalue || $request->data_cate || $request->checksize) {
            $post = $this->postService->filters($request->data_cate, $request->checkvalue, $request->checksize);
        } else {
            $post = $this->postService->get();
        }
        $viewdata = [
            'post' => $post,
        ];

        return view('finalproject.child.filter')->with($viewdata);
    }

    public function shoppingcart(Request $request)
    {
        $this->postService->addCard($request);
        $this->shoppingCartService->updateOrDelete($request);
        if (session('cart')) {
            $cart = session('cart')['default'];
            $viewdata = [
                'cart' => $cart,
                'sum' => Cart::subtotal(),
            ];

        return view('finalproject.child.shoppingcart')->with($viewdata);
        }
    }

    public function details($id = NULL){
        if(!$id ){
            return redirect('/');
        }
        $post = $this->postService->find($id);
        if(!$post){
            return redirect('/');
        }
        $post->color_name = $post->colors;
        $post->size_name = $post->sizes;
        $params = [
            'wheres' => [
                'category_id' => $post->category_id,
            ],
        ];
        $post_same = $this->postService->paginate($params,5);
        $viewdata = [
            'post' => $post,
            'post_same' =>$post_same,
        ];

        return view('finalproject.child.details')->with($viewdata);
    }

    // public function mail(){
    //     $user = User::find(1);
    //     $mail = new SendMail($user);
    //     Mail::to('quoctrung17520@gmail.com')->queue($mail);
    //     $user = 1;
    //     SendWelcomeEmail::dispatch($user);

    // }
}
