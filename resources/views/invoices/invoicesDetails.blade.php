@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">تفاصيل الفاتورة</h4>
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
					<div class="card col-12">
						<div class="card-body">
							<div class="panel panel-primary tabs-style-2">
								<div class=" tab-menu-heading">
									<div class="tabs-menu1">
										<!-- Tabs -->
										<ul class="nav panel-tabs main-nav-line">
											<li><a href="#tab4" class="nav-link active" data-toggle="tab">تفاصيل الفاتورة</a></li>
											<li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
											<li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
										</ul>
									</div>
								</div>
								<div class="panel-body tabs-menu-body main-content-body-right border">
									<div class="tab-content">
										<div class="tab-pane active" id="tab4">
											
											<table class="table table-striped table-hover">
												<tbody>
													<tr>
														<th>رقم الفاتورة</th>
														<th>تاريخ الفاتورة</th>
														<th>تاريخ الاستحقاق</th>
														<th>القسم</th>
													</tr>
													<tr>
														<td>{{ $invoices->invoice_number }}</td>
														<td>2{{ $invoices->invoice_date }}</td>
														<td>{{ $invoices->due_date }}</td>
														<td>{{ $invoices->section->section_name }}</td>
													</tr>
													<tr>
														
														<th>المنتج</th>
														<th>مبلغ التحصيل</th>
														<th>مبلغ العمولة</th>
														<th>الخصم</th>
													</tr>
													<tr>
														<td>{{ $invoices->product }}</td>
														<td>{{ $invoices->amount_collection }}</td>
														<td>{{ $invoices->amount_commission }}</td>
														<td>{{ $invoices->discount }}</td>
													</tr>
													<tr>
														<th>نسبة الضريبة</th>
														<th>قيمة الضريبة</th>
														<th>الاجمالي مع الضريبة</th>
														<th>الحالة</th>
													</tr>
													<tr>
														<td>{{ $invoices->rate_vat }}</td>
														<td>{{ $invoices->value_vat }}</td>
														<td>{{ $invoices->total }}</td>
														@if ($invoices->value_status == 1)
															<td class="text-success">{{ $invoices->status }}</td>
														@elseif ($invoices->value_status == 2)
															<td class="text-danger">{{ $invoices->status }}</td>
														@else
															<td class="text-warning">{{ $invoices->status }}</td>
														@endif
													</tr>
													<tr>
														<th class="text-center" colspan="4">ملاحضات</td>
													</tr>
													<tr>
														<td colspan="4">{{ $invoices->note }}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab5">
											<table class="table table-striped table-hover">
												<thead>
													<tr class="text-center">
														<th>#</th>
														<th class="border-bottom-0">رقم الفاتورة</th>
														<th class="border-bottom-0">نوع المنتج</th>
														<th class="border-bottom-0">القسم</th>
														<th class="border-bottom-0">تاريخ الدفع</th>
														<th class="border-bottom-0">تاريخ الاضافة</th>
														<th class="border-bottom-0">المستخدم</th>
														<th class="border-bottom-0">ملاحضات</th>
														<th class="border-bottom-0">حالة الدفع</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 0; ?>
													@foreach ($details as $detail)
														<?php $i++; ?>
														<tr class="text-center">
															<td>{{ $i }}</td>
															<td>{{ $detail->invoice_number }}</td>
															<td>{{ $detail->invoice->product }}</td>
															<td>{{ $invoices->section->section_name }}</td>
															<td>{{ $detail->payment_date }}</td>
															<td>{{ $detail->created_at }}</td>
															<td class="text-success">{{ $detail->user }}</td>
															<td>{{ $detail->note }}</td>
															@if ($detail->value_status == 1)
																<td>
																	<span class="badge badge-pill badge-success">{{ $detail->status }}</span>
																</td>
															@elseif ($detail->value_status == 2)
																<td>
																	<span class="badge badge-pill badge-danger">{{ $detail->status }}</span>
																</td>
															@else
																<td>
																	<span class="badge badge-pill badge-warning">{{ $detail->status }}</span>
																</td>
															@endif
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab6">
											<div class="card card-statistics">
												<div class="card-body">
													<p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
													<h5 class="card-title">اضافة مرفقات</h5>
													<form method="post" action="{{ url('/InvoiceAttachments') }}" enctype="multipart/form-data">
														@csrf
														<div class="custom-file">
																<input type="file" class="custom-file-input" id="customFile" name="file_name" required>
																<input type="hidden" id="customFile" name="invoice_number" value="{{ $invoices->invoice_number }}">
																<input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoices->id }}">
																<label class="custom-file-label" for="customFile">حدد المرفق</label>
														</div><br><br>
														<button type="submit" class="btn btn-primary-gradient btn-sm" name="uploadedFile">تاكيد</button>
													</form>
												</div>
											</div>
											<br>

											<table class="table table-striped table-hover">
												<thead>
													<tr class="text-center">
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">اسم الملف</th>
														<th class="border-bottom-0">تاريخ الاضافة</th>
														<th class="border-bottom-0">قام بالاضافة</th>
														<th class="border-bottom-0">العمليات</th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 0; ?>
													@foreach ($invoicesAttachments as $attachment)
														<?php $i++; ?>
														<tr class="text-center">
															<td>{{ $i }}</td>
															<td>{{ $attachment->file_name }}</td>
															<td>{{ $attachment->created_at }}</td>
															<td>{{ $attachment->created_by }}</td>
															<td>
																<a class="btn btn-sm btn-success" href="{{ url('viewFile') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}" title="عرض" target="_blank">
																	عرض
																</a>

																<a class="btn btn-sm btn-info" href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}" title="تحميل">
																	تحميل
																</a>
				
																<a class="btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal"
																	data-id_file="{{ $attachment->id }}"
																	data-file_name="{{ $attachment->file_name }}"
																	data-invoice_number="{{ $attachment->invoice_number }}"
																	data-target="#delete_file"
																	href="#delete_file" title="حذف">
																	حذف
																</a>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
				<!-- delete -->
				<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="{{ route('delete_file') }}" method="post">
								@csrf
								<div class="modal-body">
									<p class="text-center">
										<h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
									</p>
									<input type="hidden" name="id_file" id="id_file" value="">
									<input type="hidden" name="file_name" id="file_name" value="">
									<input type="hidden" name="invoice_number" id="invoice_number" value="">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-danger">تاكيد</button>
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
<script>
	$('#delete_file').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var id_file = button.data('id_file')
			var file_name = button.data('file_name')
			var invoice_number = button.data('invoice_number')
			var modal = $(this)

			modal.find('.modal-body #id_file').val(id_file);
			modal.find('.modal-body #file_name').val(file_name);
			modal.find('.modal-body #invoice_number').val(invoice_number);
	})
</script>
@endsection