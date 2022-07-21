<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Services\ColorService;
use App\Services\SizeService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostControllerAdmin extends Controller
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

    public function create(Request $request)
    {
        $post['arrayColor'] = [];
        $post['arraySize'] = [];
        if($request->id){
            $post = $this->postService->find($request->id);
            $old_cate = $this->categoryService->findNotId($post->category_id);
            if($post){
                $post['arrayColor'] = json_decode($post->color);
                $post['arraySize'] = json_decode($post->size);
            }else{
                return redirect()->route('admin.home');
            }
        }
        $viewdata =[
            'old_post' =>$post??'',
            'old_cate' =>$old_cate??[],
        ];
        return view('admin.admin_product.create_product')->with($viewdata);
    }

    public function postcreate(Request $request)
    {
        $file = $request->img;
        $files = $request->imgadd;
        $data = [
            'post_name' => $request->post_name,
            'category_id' => $request->category,
            'color' => json_encode($request->color) ,
            'size' => json_encode($request->size),
            'price' => str_replace(',','',$request->price),
            'content' => $request->content,
        ];
        if($file){
            $file_name = $this->postService->saveImg($file);
            $data['img'] = '/img/' . $file_name;
        }
        if($files){
            $imgs = $this->postService->saveImgs($files);
            $data['imgadd'] =json_encode($imgs);
        }
        if(request('id')){
            $data['_find'] =[
                'wheres' => ['id' => request('id')]
            ];
        }

        $this->postService->createOrUpdate($data);
        return redirect('/admin/home')->with('success', 'Thêm mới sản phẩm thành công');  
    }

    public function delete(Request $request , $id = NULL){
        if($request->data){
           $this->postService->deleteId($request->data);
           return redirect()->back()->with('errors', 'Xóa sản phẩm thành công');  
        }
       else{
            $this->postService->find($id)->delete();
            return redirect()->back()->with('errors', 'Xóa sản phẩm thành công');
        }
         
    }

    public function search (Request $request){
        $post = $this->postService->searchPost($request->data);
        $viewdata =[
            'post' => $post,
        ];
        return view('admin.admin_product.search_product')->with($viewdata);
    }
}
