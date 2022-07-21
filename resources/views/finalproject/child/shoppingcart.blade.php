
@if(session('cart'))
        <p>Tổng tiền : {{ $sum }} <sup>đ</sup></p>
        @foreach ( $cart  as $data)
            <div class='cart-item mb-3'>
                <div class='img-wrap'>
                    <img src='{{ $data->options->img }}' alt='' />
                </div>
                <span class='text-nowrap'>{{ $data->name }}</span>
                <strong>{{ number_format($data->price) }} <sup>đ</sup> </strong>
                <span><small><i class="fa-solid fa-circle-minus mr-2 cursor-pointer	minus-item"></i></small><small><i class="fa-solid fa-circle-plus cursor-pointer	plus-item"></i></small></span>
                <span class="qty">{{ $data->qty }}</span>
                <div class='cart-item-border'></div>
                <div class='delete-item'>
                    <input type="hidden" value="{{ $data->rowId }}" class="rowID">
                    <input type="hidden" value="{{ $data->id }}" class="rowPostID">
                </div>
            </div>
        @endforeach
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.delete-item').click(function(){
		var deleteIdCard = $(this).find('.rowID').val();
        var deleteIdPost = $(this).find('.rowPostID').val();
        $.ajax({
			url: 'http://finalproject.test/shoppingcart',
			data: {
				deleteIdCard: deleteIdCard,
                deleteIdPost: deleteIdPost,
			},
			dataType: "html",
			success: function (data) {
				$('#cart').html(data);
			},
			error: function () {
				alert('error handing here');
			}
		});
	});
    $('.minus-item').click(function(){
		var minusIdCard = $(this).parents('.cart-item').find('.rowID').val();
        var dataMinus = $(this).parents('.cart-item').find('.qty').text();
		$.ajax({
			url: 'http://finalproject.test/shoppingcart',
			data: {
				minusIdCard: minusIdCard,
                dataMinus : dataMinus,
			},
			dataType: "html",
			success: function (data) {
				$('#cart').html(data);
			},
			error: function () {
				alert('error handing here');
			}
		});
	});
    $('.plus-item').click(function(){
		var plusIdCard = $(this).parents('.cart-item').find('.rowID').val();
        var dataPlus = $(this).parents('.cart-item').find('.qty').text();
		$.ajax({
			url: 'http://finalproject.test/shoppingcart',
			data: {
				plusIdCard: plusIdCard,
                dataPlus : dataPlus,
		},
			dataType: "html",
			success: function (data) {
				$('#cart').html(data);
			},
			error: function () {
				alert('error handing here');
			}
		});
	});
</script>
