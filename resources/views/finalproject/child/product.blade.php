<div id="grid">
   @foreach ( $post as $data  )
        <div class="product">
            <div class="make3D">
                <div class="product-front">
                    <div class="shadow"></div>
                    <img src="{{ asset($data['img']) }}" alt="" />
                    <div class="image_overlay"></div>
                    <div class="add_to_cart" style="top:15px">
                        <a href="{{ route('details', ['id' => $data['id']]) }}" style="text-decoration:none;color:white">View Detail</a>
                        <input type="hidden" value="{{ $data['id'] }}" class="add_id_cart">
                    </div>
                    <div class="add_to_cart add_to_cart-shop">Add to cart
                        <input type="hidden" value="{{ $data['id'] }}" class="add_id_cart">
                    </div>
                    <div class="view_gallery">View gallery </div>                
                    <div class="stats">        	
                        <div class="stats-container">
                            <span class="product_price">{{ number_format($data['price']) }}</span>
                            <span class="product_name">FLUTED HEM DRESS</span>   
                            <p>{{ $data->category->category_name }}</p>                                            
                            <div class="product-options">
                            <strong>SIZES</strong>
                            <div class="d-flex">
                                @foreach ($data->sizes()->get()->toArray() as $value)
                                 <span>{{  $value['size_name'] }}&nbsp</span>
                                @endforeach  
                            </div>
                            <strong>COLORS</strong>
                            <div class="colors">
                                <ul class="d-flex list-unstyled">
                                    @foreach ($data->colors()->get()->toArray() as $value)
                                         <li class="list-unstyled"><a href=""><span style="background:{{ $value['color'] }};border: 1px solid #e8e9eb;width:13px;height:13px;"></span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>                       
                        </div>                         
                    </div>
                </div>
                <div class="product-back">
                    <div class="shadow"></div>
                    <div class="carousel">
                        <ul class="carousel-container">
                            @foreach (json_decode($data->imgadd) as $img)
                                <li><img src="{{ asset($img) }}" style="height: 100%" alt="" /></li>
                            @endforeach
                        </ul>
                        <div class="arrows-perspective">
                            <div class="carouselPrev">
                                <div class="y"></div>
                                <div class="x"></div>
                            </div>
                            <div class="carouselNext">
                                <div class="y"></div>
                                <div class="x"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flip-back">
                        <div class="cy"></div>
                        <div class="cx"></div>
                    </div>
                </div>	  
            </div>	
        </div>
   @endforeach
       
</div>
{{ $post->links() }}

{{-- <div class="flex justify-center my-8">
    {{ $post->fragment('result')->onEachSide(1)->appends(request()->all())->links() }}
</div> --}}
