@if($post)
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
                        <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/1.jpg" alt="" /></li>
                        <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/2.jpg" alt="" /></li>
                        <li><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/3.jpg" alt="" /></li>
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
@endif
{{-- {{ $post->links() }} --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('js/script.js') }}" defer></script>
