@extends('layouts.master')
@section('content') 
<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <h1><a href="./"><img src=""></a></h1>
                </div>
            </div>
            {{-- <div class="col-sm-6">
                <div class="shopping-item">
                    <a href="cart.html">Tổng tiền - <span class="cart-amunt">{{ Cart::subtotal() }}</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">{{ $cart->count() ?? 0}}</span></a>
                </div>
            </div> --}}
        </div>
    </div>
</div> <!-- End site branding area -->
<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                {{-- <div class="single-sidebar">
                    <h2 class="sidebar-title">Search Products</h2>
                    <form action="">
                        <input type="text" placeholder="Search products...">
                        <input type="submit" value="Search">
                    </form>
                </div> --}}
                
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Products</h2>
                    @foreach($post_same as $data)
                       @if($data->id != $post->id)
                            <a href="{{ route('details', ['id' => $data->id]) }}">
                                <div class="thubmnail-recent">
                                    <img src="{{ $data->img }}" class="recent-thumb" alt="">
                                    <h2><a href="{{ route('details', ['id' => $data->id]) }}">{{ $data->post_name }}</a></h2>
                                    <div class="product-sidebar-price">
                                        <ins>{{ number_format($data->price) }}</ins> <del>{{ number_format($data->price) }}</del>
                                    </div>                             
                                </div>
                            </a>
                       @endif
                    @endforeach
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="product-content-right">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="product-images">
                                <div class="product-main-img">
                                    <img src="{{ asset($post->img) }}" alt="">
                                </div>
                                
                                <div class="product-gallery">
                                    @if($post->imgadd)
                                        @foreach (json_decode($post->imgadd) as $img )
                                            <img src="{{ asset($img) }}" alt="">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="product-inner">
                                <h2 class="product-name">{{ $post->post_name }}</h2>
                                <div class="product-inner-price">
                                    <ins>{{ number_format($post->price) }}</ins> <del>{{ number_format($post->price) }}</del>
                                {{-- </div>    
                                    <button class="add_to_cart_button" type="submit">Add to cart</button>
                                <div class="product-inner-category"> --}}
                                    <p>Category: <a href="">{{ $post->category->category_name }}</a> </p>
                                </div> 
                                
                                <div class="product-inner-category">
                                    <label for="">Content</label>
                                    <p>{!! $post->content !!}</p>
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</div>
@endsection()
