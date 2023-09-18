@extends('layouts.master')

@section('title')
المنتجات
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

	@if ($errors->any())
	<div class="alert alert-danger">
			<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
			</ul>
	</div>
	@endif

	@if(session()->has('Add'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Add') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if(session()->has('Edit'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Edit') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

	@if(session()->has('Delete'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>{{ session()->get('Delete') }}</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	@endif

			<!-- row -->
			<div class="row">
				<!--div-->
				<div class="col-xl-12">
					<div class="card mg-b-20">
						<div class="card-header pb-0">
							<div class="d-flex justify-content-between">
								@can('اضافة منتج')
									<button class="btn btn-primary-gradient btn-block w-25" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>&nbsp; اضافة منتج</button>
								@endcan
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
									<thead>
										<tr>
											<th class="border-bottom-0">#</th>
											<th class="border-bottom-0">اسم المنتج</th>
											<th class="border-bottom-0">اسم القسم</th>
											<th class="border-bottom-0">الملاحضات</th>
											<th class="border-bottom-0">العمليات</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 0; ?>
										@foreach ($products as $product)
										<?php $i++; ?>
											<tr>
												<td>{{ $i }}</td>
												<td>{{ $product->product_name }}</td>
												<td>{{ $product->section->section_name }}</td>
												<td>{{ $product->description }}</td>
												<td>
													@can('تعديل منتج')
														<a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
															data-product_name="{{ $product->product_name }}" 
															data-pro_id="{{ $product->id }}" 
															data-section_name="{{ $product->section->section_name }}"
															data-description="{{ $product->description }}" data-toggle="modal"
															href="#exampleModal2" title="تعديل"><i class="las la-pen"></i>
														</a>
													@endcan
	
													@can('حذف منتج')
														<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
															data-product_name="{{ $product->product_name }}"
															data-pro_id="{{ $product->id }}"
															data-toggle="modal" href="#modaldemo9" title="حذف"><i
															class="las la-trash"></i>
														</a>
													@endcan
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--/div-->

				<!-- add -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
									</button>
							</div>
							<form action="{{ route('products.store') }}" method="post">
								@csrf
								<div class="modal-body">
									<div class="form-group">
											<label for="exampleInputEmail1">اسم المنتج</label>
											<input type="text" class="form-control" id="product_name" name="product_name" >
									</div>
									<div class="form-group">
										<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
										<select name="section_id" id="section_id" class="form-control">
												<option value="" selected disabled> حدد القسم</option>
												@foreach ($sections as $section)
														<option value="{{ $section->id }}">{{ $section->section_name }}</option>
												@endforeach
										</select>
									</div>
									<div class="form-group">
											<label for="exampleFormControlTextarea1">ملاحظات</label>
											<textarea class="form-control" id="description" name="description" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
										<button type="submit" class="btn btn-success">تاكيد</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- row closed -->

			<!-- edit -->
		<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
							</button>
					</div>
					<form  action="products/update" method="post">
						@csrf
						@method('PATCH')
						<div class="modal-body">
							<div class="form-group">
									<input type="hidden" name="pro_id" id="pro_id" value="">
									<label for="recipient-name" class="col-form-label">اسم المنتج:</label>
									<input class="form-control" name="product_name" id="product_name" type="text">
							</div>
							<div class="form-group">
								<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
								<select name="section_name" id="section_name" class="form-control">
										@foreach ($sections as $section)
												<option>{{ $section->section_name }}</option>
										@endforeach
								</select>
							</div>
							<div class="form-group">
									<label for="message-text" class="col-form-label">ملاحظات:</label>
									<textarea class="form-control" id="description" name="description"></textarea>
							</div>
						</div>
							<div class="modal-footer">
									<button type="submit" class="btn btn-primary">تعديل</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
							</div>
						</form>
				</div>
			</div>
		</div>

		<!-- delete -->
		<div class="modal" id="modaldemo9">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف المنتج</h6>
						<button aria-label="Close" class="close" data-dismiss="modal" type="button">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
						<form action="products/destroy" method="post">
							@csrf
							@method('delete')
							<div class="modal-body">
									<p>هل انت متاكد من عملية الحذف ؟</p><br>
									<input type="hidden" name="pro_id" id="pro_id" value="">
									<input class="form-control" name="product_name" id="product_name" type="text" readonly>
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-danger">حذف</button>
							</div>
						</form>
				</div>
			</div>
		</div>
		</div>
		<!-- Container closed -->
	</div>
	<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>

<script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var product_name = button.data('product_name')
			var section_name = button.data('section_name')
			var pro_id = button.data('pro_id')
			var description = button.data('description')
			var modal = $(this)
			modal.find('.modal-body #product_name').val(product_name);
			modal.find('.modal-body #section_name').val(section_name);
			modal.find('.modal-body #description').val(description);
			modal.find('.modal-body #pro_id').val(pro_id);
	})


	$('#modaldemo9').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var pro_id = button.data('pro_id')
			var product_name = button.data('product_name')
			var modal = $(this)

			modal.find('.modal-body #pro_id').val(pro_id);
			modal.find('.modal-body #product_name').val(product_name);
	})

</script>
@endsection