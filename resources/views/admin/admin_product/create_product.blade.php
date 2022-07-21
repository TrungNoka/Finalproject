@extends('admin.layout.master')

@section('body')
<div class="container-fluid py-4 mt-10">
    <div class="row mt-4">
      <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card ">
          <div class="card-header pb-0 p-3">
                <form action="{{ route('admin.product.postcreate',['id'=>$old_post->id ?? '']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="post_name">Tên sản phẩm</label>
                      <input value="{{ $old_post->post_name ?? '' }}" type="text" class="form-control" placeholder="Áo phông 80 ................" id="post_name" name="post_name">
                    </div>
                    <div class="form-group">
                      <label for="pwd">Danh mục sản phẩm</label>
                      <select  class="" name="category" id=""  style="width:300px">
                        @if ($old_cate != []) 
                          <option value="{{ $old_post->category_id ?? '' }}">{{ $old_post->category->category_name ?? ''}}</option>
                          @foreach ($old_cate as $value)
                              <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                          @endforeach
                        @else
                          @foreach ($category_list as $value)
                            <option value="{{ $value->id }}">{{ $value->category_name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                    <div class="form-group">
                        <label for="color">Màu sắc</label>
                        <input type="hidden" value="{{ $old_post->color ?? '' }}" class="hidden-color">
                        <select class="select2-color" name="color[]" id="" multiple="multiple" style="width:300px" value="{{ $old_post->color?? "" }}" required>
                          @foreach ($color_list as $value)
                              <option value="{{ $value->id }}">{{ $value->color_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="size">Kích cỡ</label>
                        <select class="select2-size" name="size[]" id="" multiple="multiple" style="width:300px " required>
                          @foreach ($size_list as $value)
                              <option value="{{ $value->id }}">{{ $value->size_name }} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="price">Giá tiền </label>
                        <input value="{{ $old_post->price ?? '' }}" type="text" name="price" id="" class="input-element" placeholder="Nhập giá tiền (VND)" required>
                      </div>
                      <div class="form-group">
                        <textarea id="editor-ckeditor" name="content" class="form-control">{!! old('content', 'test editor conádtent') !!}</textarea>
                      </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                      <div class="form-group">
                        <label for="img">Ảnh sản phẩm</label>
                        <input type="file" name="img" >
                        @if(isset($old_post->img) && $old_post->img)
                            <img src="{{ asset($old_post->img ?? '') }}" alt="" width="100px" height="200px">
                        @endif
                      </div>
                      <div class="form-group">
                        <label for="img">Ảnh thêm</label>
                        <input type="file" name="imgadd[]" accept="imgage/*" multiple >
                        @if(isset($old_post->imgadd) && $old_post->imgadd)
                          @foreach (json_decode($old_post->imgadd ?? "") as $data)
                          <img src="{{ asset($data ?? '') }}" alt="" width="100px" height="200px">
                          @endforeach
                        @endif
                      </div>
                    <button type="submit" class="btn btn-primary">{{ $old_post->id?? "" ? 'Cập nhật' : 'Thêm mới'  }}</button>
                  </form>
          </div>
          <div class="table-responsive">

          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.0/tinymce.min.js" integrity="sha512-dr3qAVHfaeyZQPiuN6yce1YuH7YGjtUXRFpYK8OfQgky36SUfTfN3+SFGoq5hv4hRXoXxAspdHw4ITsSG+Ud/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'editor-ckeditor' ,{
	filebrowserBrowseUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
	filebrowserUploadUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
	filebrowserImageBrowseUrl : 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});
</script>
  <script>
    $(document).ready(function(){
      var dataColor = new Array({{  implode(',',$old_post['arrayColor']) }} );
      var dataSize = new Array({{  implode(',', $old_post['arraySize']) }} );

      if(!dataColor[0] ){
        dataColor = '{{  implode(',',$old_post['arrayColor']) }}' 
      }
      if(!dataSize[0] ){
        dataSize = '{{  implode(',',$old_post['arraySize']) }}' 
      }

      $(".select2-color").val(dataColor)
      $(".select2-size").val(dataSize)
        $(".select2-color").select2({
            placeholder: "Select a color",
            allowClear: true,
            tags: true,
            tokenSeparators: ['.', ' '],
        });
        $(".select2-size").select2({
            placeholder: "Select a size",
            allowClear: true,
            tags: true,
            tokenSeparators: ['.', ' '],
        });
    })
  </script>
@endsection

