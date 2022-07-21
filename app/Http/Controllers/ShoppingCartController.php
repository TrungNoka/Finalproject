<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }
    public function index(){
        return view('finalproject.child.shoppingdetail');
    }
}
