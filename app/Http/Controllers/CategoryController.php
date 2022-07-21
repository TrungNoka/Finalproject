<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }
    public function index(){
        $categories = $this->postService->get();
        $viewdata =[
            'categories' => $categories,
        ];

        return view('finalproject.child.sidebar')->with($viewdata);
    }
}
