@extends('admin.layout.master')

@section('body')

<div class="container-fluid py-4 mt-10">
    <div class="row mt-4">
      <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card ">
          @if(session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
              @endif
              @if(session()->has('errors'))
                  <div class="alert alert-danger">
                      {{ session()->get('errors') }}
                  </div>
              @endif
          <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
              <div class="d-flex">
                <h6 class="mb-2" style="margin-right:10px">Danh mục sản phẩm</h6>
                <a class="btn btn-primary" href="{{ route('admin.product.create') }}">Thêm mới sản phẩm</a>
                <div class="md-form active-pink-2 mb-3" style="margin-left:10px;width:250px">
                  <input class="form-control input-search" type="text" placeholder="Search" aria-label="Search">
                </div>
              </div>
              <div>
                <label for="">Tổng sản phẩm hiển thị</label>
                  <select name="" id="selecthome">
                    @foreach (config('paginator') as $data) 
                      <option value="{{ $data['value'] }}">{{  $data['value'] }}</option>
                    @endforeach
                  </select>
              </div>
              <div>
                    <input type="hidden" class="deleteAll">
                    <button class="btn btn-danger btn_delete display-none" >Xóa</button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center ">
              <tbody>
                @foreach($post as $data)
                  <tr>
                    <td class="w-20">
                      <div class="d-flex px-2 py-1 align-items-center">
                        <div>
                          <img src="{{ asset($data->img) }}" width="80px" height="80px" alt="Country flag">
                        </div>
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">Tên sản phẩm</p>
                          <h6 class="text-sm mb-0">{{ $data->post_name }}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Giá</p>
                        <h6 class="text-sm mb-0">{{ number_format($data->price) }}</h6>
                    </div>
                    </td>
                    <td> 
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Loại sản phẩm</p>
                        <h6 class="text-sm mb-0">{{ $data->category->category_name }}</h6>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Size</p>
                        <div class="d-flex justify-content-center">
                              @foreach ($data->sizes()->get()->toArray() as $val)
                               <span class="font-weight-bold">{{  $val['size_name'] }}&nbsp</span>
                              @endforeach  
                          </div>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-1" style="margin-top:11px">Color</p>
                          <ul class="d-flex list-unstyled justify-content-center ">
                              @foreach ($data->colors()->get()->toArray() as $val)
                                   <li class="list-unstyled" style="background:{{ $val['color'] }};border: 1px solid #e8e9eb;width:13px;height:13px; border-radius:50px; margin-right:5px"></li>
                              @endforeach
                          </ul>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <div class="col text-center">
                        <p class="text-xs font-weight-bold mb-0">Chỉnh sửa</p>
                          <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.product.create',['id'=>$data->id])}}" class="margin-right:5px"><i class="fa-solid fa-file-pen" style="color:rgb(81, 70, 198)"></i></a>                              
                            <a class="trash" href="{{ route('admin.product.delete',['id'=>$data->id])}}"><i class="fa-solid fa-trash" style="color:rgb(173, 42, 42)"></i></a>
                          </div>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                        <input value="{{ $data->id }}" type="checkbox" name="checkbox_product" id="">
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{ $post->links() }}
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
<script src="{{ asset('js/script.js') }}" defer></script>
