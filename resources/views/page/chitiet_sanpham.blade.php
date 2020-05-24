@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Sản phẩm {{$sanpham->name}}</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('trang-chu')}}">Trang chủ</a> / <span>Thông tin chi tiết sản phẩm</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="container">
		<div id="content">
			<div class="row">
				<div class="col-sm-9">

					<div class="row">
						<div class="col-sm-4">
							<img src="source/image/product/{{$sanpham->image}}" alt="">
						</div>
						<div class="col-sm-8">
							<div class="single-item-body">
								<p class="single-item-title"><h2>{{$sanpham->name}}</h2></p>
								<p class="single-item-price">
									@if($sanpham->promotion_price==0)
										<span class="flash-sale">{{number_format($sanpham->unit_price)}} đồng</span>
									@else
										<span class="flash-del">{{number_format($sanpham->unit_price)}} đồng</span>
										<span class="flash-sale">{{number_format($sanpham->promotion_price)}} đồng</span>
									@endif
								</p>
							</div>

							<div class="clearfix"></div>
							<div class="space20">&nbsp;</div>

							<div class="single-item-desc">
								<p>{{$sanpham->description}}</p>
							</div>
							<div class="space20">&nbsp;</div>

							<p>Số lượng ({{$sanpham->unit}}):</p>
							<div class="single-item-options">
								<form action="{{route('themgiohang',$sanpham->id)}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
									<select class="wc-select" name="sl">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
									<button class="add-to-cart">
										<i class="fa fa-shopping-cart"></i>
									</button>
									<div class="clearfix"></div>
								</form>
							</div>
						</div>
					</div>

					<div class="space40">&nbsp;</div>
					<div class="woocommerce-tabs">
						<ul class="tabs">
							<li><a href="#tab-description">Mô tả</a></li>
						</ul>

						<div class="panel" id="tab-description">
							<p>{{$sanpham->description}}</p>
						</div>
					</div>
					<div class="space50">&nbsp;</div>
					<div class="beta-products-list">
						<h4>Sản phẩm tương tự</h4>

						<div class="row">
						@foreach($sp_tuongtu as $sptt)
							<div class="col-sm-4" style="margin-bottom: 10px;">
								<div class="single-item">
									@if($sptt->promotion_price!=0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
									@endif
									<div class="single-item-header">
										<a href="{{route('chitietsanpham',$sptt->id)}}"><img src="source/image/product/{{$sptt->image}}" alt="" height="150px"></a>
									</div>
									<div class="single-item-body">
										<p class="single-item-title">{{$sptt->name}}</p>
										<p class="single-item-price" style="font-size: 18px">
											@if($sptt->promotion_price==0)
												<span class="flash-sale">{{number_format($sptt->unit_price)}} đồng</span>
											@else
												<span class="flash-del">{{number_format($sptt->unit_price)}} đồng</span>
												<span class="flash-sale">{{number_format($sptt->promotion_price)}} đồng</span>
											@endif
										</p>
									</div>
									<div class="single-item-caption" style="margin-top: 5px;">
										<a class="add-to-cart pull-left" href="{{route('themgiohang',$sptt->id)}}"><i class="fa fa-shopping-cart"></i></a>
										<a class="beta-btn primary" href="{{route('chitietsanpham',$sptt->id)}}">Details <i class="fa fa-chevron-right"></i></a>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
						<div class="row">{{$sp_tuongtu->links()}}</div>
					</div> <!-- .beta-products-list -->
				</div>
				<div class="col-sm-3 aside">
					<div class="widget">
						<h3 class="widget-title">Best Sellers</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 12)}}"><img src="source/image/product/210215-banh-sinh-nhat-rau-cau-body- (6).jpg" alt=""></a>
									<div class="media-body">
										Bánh sinh nhật rau câu trái cây
										<span class="beta-sales-price">$31.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 13)}}"><img src="source/image/product/banh kem sinh nhat.jpg" alt=""></a>
									<div class="media-body">
										Bánh kem Chocolate Dâu
										<span class="beta-sales-price">$32.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 14)}}"><img src="source/image/product/Banh-kem (6).jpg" alt=""></a>
									<div class="media-body">
										Bánh kem Dâu III
										<span class="beta-sales-price">$33.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 15)}}"><img src="source/image/product/banhkem-dau.jpg" alt=""></a>
									<div class="media-body">
										Bánh kem Dâu I
										<span class="beta-sales-price">$34.55</span>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- best sellers widget -->
					<div class="widget">
						<h3 class="widget-title">New Products</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 1)}}"><img src="source/image/product/1430967449-pancake-sau-rieng-6.jpg" alt=""></a>
									<div class="media-body">
										Bánh Crepe Sầu riêng
										<span class="beta-sales-price">$31.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 2)}}"><img src="source/image/product/crepe-chocolate.jpg" alt=""></a>
									<div class="media-body">
										Bánh Crepe Chocolate
										<span class="beta-sales-price">$32.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 3)}}"><img src="source/image/product/crepe-chuoi.jpg" alt=""></a>
									<div class="media-body">
										Bánh Crepe Sầu riêng - Chuối
										<span class="beta-sales-price">$33.55</span>
									</div>
								</div>
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham', 4)}}"><img src="source/image/product/crepe-dao.jpg" alt=""></a>
									<div class="media-body">
										Bánh Crepe Đào
										<span class="beta-sales-price">$34.55</span>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- best sellers widget -->
				</div>
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection