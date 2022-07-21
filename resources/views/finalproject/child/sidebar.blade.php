<div id="sidebar">
    <h3>CART</h3>
    <div id="cart">
        
    </div>
    
    <h3>CATEGORIES</h3>
    <div class="checklist_v2">
        <ul>
            @foreach ( $category_list as $cate)
                <li><input class="checkbox-filter checkbox-filter-cate" name="category" value="{{ $cate->id }}" type="radio"><a href=""><span></span>{{ $cate->category_name }}</a></li>
            @endforeach
        </ul>
    </div>
    
    <h3>COLORS</h3>
    <div class="checklist colors color-filter">
        <ul class="d-flex flex-wrap">
            @foreach ($color_list as $data)
                <input class="checkbox-filter  " name="color"  type="checkbox" value="{{ $data->id }}">
                <li class="w-75 padding-left-35"><span style="background:{{ $data->color }};border: 1px solid #e8e9eb;width:13px;height:13px;border-radius:50px"></span>{{ $data->color_name }}</li>
            @endforeach
        </ul>     
    </div>
    
    <h3>SIZES</h3>
    <div class="checklist sizes size-filter">
        <ul class="d-flex flex-wrap">
            @foreach ($size_list as $data)
                <input class="checkbox-filter" name="size"  type="checkbox" value="{{ $data->id }}">
                <li class="w-75 padding-left-35">{{ $data->size_name }}</li>
            @endforeach
        </ul>
    </div>
    
     <h3>PRICE RANGE</h3>
     <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/245657/price-range.png" alt="" />
</div>

<script>
    $('#sidebar input').on('click',function(){
		var checkvalue = [];
		var checksize = [];
		var data_cate ;
		$.each($("input[name='category']:checked"), function(){            
			data_cate = $(this).val();
		});	
		
		$.each($("input[name='color']:checked"), function(){            
			checkvalue.push($(this).val());
		});	

		$.each($("input[name='size']:checked"), function(){            
			checksize.push($(this).val());
		});	
       
		$.ajax({
			url: 'http://finalproject.test/filter',
            dataType: "html",
			data: {
				data_cate : data_cate,
				checkvalue: checkvalue,
				checksize: checksize,
			},
			success: function (data) {
				$('#grid').html(data);
			},
			error: function () {
				alert('error handing here');
			}
		});
	})
</script>