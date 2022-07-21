<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;
use App\Models\Post;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\SizeService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(
        private PostService $postService,
        private CategoryService $categoryService,
        private ColorService $colorService,
        private SizeService $sizeService,

    )

    {
    }

    public function index(Request $request)
    {
        $post = $this->postService->getPostPage($request->perpage??10);
        $viewdata =[
            'post' => $post,
        ];
        return view('admin.admin')->with($viewdata);
    }
}
