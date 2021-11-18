@extends('layouts.app')

@section('styles')

@endsection

@section('content')

						<!-- PAGE-HEADER -->
						<div class="page-header">
							<div>
								<h1 class="page-title">Cart</h1>
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">E-Commerce</a></li>
									<li class="breadcrumb-item active" aria-current="page">Cart</li>
								</ol>
							</div>
							<div class="ms-auto pageheader-btn">
								<a href="#" class="btn btn-primary btn-icon text-white me-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Account
								</a>
								<a href="#" class="btn btn-success btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
								</a>
							</div>
						</div>
						<!-- PAGE-HEADER END -->

						<!-- ROW-1 OPEN -->
						<div class="row">
							<div class="col-xl-8 col-md-12">
								<div class="card cart">
									<div class="card-header">
										<h3 class="card-title">Shopping Cart</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered table-vcenter text-nowrap mb-0">
												<thead>
													<tr class="border-top">
														<th class="w-5">Product</th>
														<th>Title</th>
														<th>Price</th>
														<th class="w-15">Quantity</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/1.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$568</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="1" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/4.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,027</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="3" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/2.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,027</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="3" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/5.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,027</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="3" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/6.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,027</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="3" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr>
														<td>
															<img src="{{ asset('assets/images/pngs/7.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,027</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="3" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
													<tr class="border-bottom">
														<td>
															<img src="{{ asset('assets/images/pngs/8.png')}}" alt="" class="cart-img">
														</td>
														<td>laborum et dolorum fuga</td>
														<td class="fw-bold">$1,589</td>
														<td >
															<div class="input-group input-indec">
																<span class="input-group-btn">
																	<button type="button" class="minus btn btn-light btn-number br-tl-4 br-tr-0 br-bl-4 br-br-0 " >
																		<i class="fa fa-minus fs-10"></i>
																	</button>
																</span>
																<input type="text"  name="quantity" class="form-control text-center qty" value="2" >
																<span class="input-group-btn">
																	<button type="button" class="quantity-right-plus btn btn-light btn-number br-tr-4 br-tl-0 br-br-4 br-bl-0  add">
																		<i class="fa fa-plus fs-10"></i>
																	</button>
																</span>
															</div>
														</td>
														<td>
															<a href="javascript:void(0)" class="btn btn-square btn-danger-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Save for Wishlist"><i class="icon icon-heart  fs-13"></i></a>
															<a href="javascript:void(0)" class="btn btn-square btn-info-light me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"><i class="icon icon-trash  fs-13"></i></a>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Have coupon?</h3>
									</div>
									<div class="card-body">
										<form>
											<div class="form-group">
												<div class="input-group"> <input type="text" class="form-control coupon" placeholder="Coupon code"> <span class="input-group-btn"> <button class="btn btn-primary btn-apply coupon">Apply</button> </span> </div>
											</div>
										</form>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Price Details</h3>
									</div>
									<div class="card-body">
										<table class="table border-top-0">
											<tr>
												<td class="border-top-0">Sub Total</td>
												<td class="text-end fw-bold border-top-0">$4,360</td>
											</tr>
											<tr>
												<td class="border-top-0">Discount</td>
												<td class="text-end fw-bold border-top-0">5%</td>
											</tr>
											<tr>
												<td class="border-top-0">Shipping</td>
												<td class="text-end fw-bold border-top-0">Free</td>
											</tr>
											<tr>
												<td class="fs-20 fw-bold border-top-0">Total</td>
												<td class="text-end fs-20 fw-bold border-top-0">$3,976</td>
											</tr>
										</table>
									</div>
									<div class="card-footer">
										<div class="step-footer text-end">
											<a href="{{ url('shop')}}" class="btn btn-primary"><i class="fa fa-arrow-left me-1"></i>Continue Shopping</a>
											<a href="{{ url('checkout')}}" class="btn btn-success">Check out<i class="fa fa-arrow-right ms-1"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- COL-END -->
						<!-- ROW-1 CLOSED -->


@endsection('content')

@section('scripts')

		<!-- CHARTJS JS -->
		<script src="{{ asset('assets/plugins/chart/Chart.bundle.js')}}"></script>
		<script src="{{ asset('assets/plugins/chart/utils.js')}}"></script>

@endsection
