@extends('body')

<div class="container-fluid py-4 mt-10">
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <div class="d-flex">
                  <h6 class="mb-2" style="margin-right:10px">Danh mục sản phẩm</h6>
                  <a class="btn btn-primary" href="{{ route('admin.product.create') }}">Thêm mới sản phẩm</a>
                </div>
                <div>
                  <label for="">Tổng sản phẩm hiển thị</label>
                    <select name="" id="">
                      @foreach (config('paginator') as $data) 
                        <option value="{{ $data['value'] }}">{{  $data['value'] }}</option>
                      @endforeach
                    </select>
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
                          <h6 class="text-sm mb-0">{{ number_format($data->price)  }}</h6>
                        </div>
                      </td>
                      <td>
                        <div class="text-center">
                          <p class="text-xs font-weight-bold mb-0">Loại sản phẩm</p>
                          <h6 class="text-sm mb-0">{{ $data->category_name }}</h6>
                        </div>
                      </td>
                      <td class="align-middle text-sm">
                        <div class="col text-center">
                          <p class="text-xs font-weight-bold mb-0">Size</p>
                          <div class="d-flex justify-content-center">
                                @foreach ($data->size_name as $val)
                                 <span class="font-weight-bold">{{  $val->size_name }}&nbsp</span>
                                @endforeach  
                            </div>
                        </div>
                      </td>
                      <td class="align-middle text-sm">
                        <div class="col text-center">
                          <p class="text-xs font-weight-bold mb-1" style="margin-top:11px">Color</p>
                            <ul class="d-flex list-unstyled justify-content-center ">
                                @foreach ($data->color_name as $val)
                                     <li class="list-unstyled" style="background:{{ $val->color }};border: 1px solid #e8e9eb;width:13px;height:13px; border-radius:50px; margin-right:5px"></li>
                                @endforeach
                            </ul>
                        </div>
                      </td>
                      <td class="align-middle text-sm">
                        <div class="col text-center">
                          <p class="text-xs font-weight-bold mb-0">Chỉnh sửa</p>
                            <div class="d-flex justify-content-center">
                              <a href="" class="margin-right:5px"><i class="fa-solid fa-file-pen" style="color:rgb(81, 70, 198)"></i></a>                              
                              <a href=""><i class="fa-solid fa-trash" style="color:rgb(173, 42, 42)"></i></a>
                            </div>
                        </div>
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