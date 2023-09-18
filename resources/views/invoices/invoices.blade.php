@extends('layouts.master')

@section('title')
قائمة الفواتير
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

	@if(session()->has('Add'))
		<script>
			window.onload = function() {
				notif({
					msg: "تم اضافة الفاتورة بنجاح",
					type: "success"
				})
			}
		</script>
	@endif

	@if(session()->has('Edit'))
		<script>
			window.onload = function() {
				notif({
					msg: "تم تعديل الفاتورة بنجاح",
					type: "success"
				})
			}
		</script>
	@endif

	@if(session()->has('Edit_payment'))
	<script>
		window.onload = function() {
			notif({
				msg: "تم تغيير حالة الدفع",
				type: "success"
			})
		}
	</script>
@endif

	@if(session()->has('Delete'))
		<script>
			window.onload = function() {
				notif({
					msg: "تم حذف الفاتورة بنجاح",
					type: "success"
				})
			}
		</script>
	@endif

	@if(session()->has('Restore'))
		<script>
			window.onload = function() {
				notif({
					msg: "تم الغاء الارشفة بنجاح",
					type: "success"
				})
			}
		</script>
	@endif
				<!-- row -->
				<div class="row">
					<!--div-->
					<div class="col-xl-12">
            <div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="col col-6">
								@can('اضافة فاتورة')
									<a class="btn btn-primary-gradient w-25" href="invoices/create"><i class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
								@endcan
								@can('تصدير EXCEL')
										<a class="btn btn-success-gradient w-25 modal-effect" href="{{ url('export_invoices') }}"><i class="fas fa-file-download"></i>&nbsp; تصدير اكسيل</a>
								@endcan
								</div>
							</div>
                <div class="card-body">
									<div class="table-responsive">
										<table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'style="text-align: center">
											<thead>
												<tr>
													<th class="border-bottom-0">#</th>
													<th class="border-bottom-0">رقم الفاتورة</th>
													<th class="border-bottom-0">تاريخ القاتورة</th>
													<th class="border-bottom-0">تاريخ الاستحقاق</th>
													<th class="border-bottom-0">المنتج</th>
													<th class="border-bottom-0">القسم</th>
													<th class="border-bottom-0">الخصم</th>
													<th class="border-bottom-0">نسبة الضريبة</th>
													<th class="border-bottom-0">قيمة الضريبة</th>
													<th class="border-bottom-0">الاجمالي</th>
													<th class="border-bottom-0">الحالة</th>
													<th class="border-bottom-0">ملاحظات</th>
													<th class="border-bottom-0">العمليات</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 0; ?>
												@foreach ($invoices as $invoice)
													<?php $i++; ?>
													<tr>
														<td>{{ $i }}</td>
														<td>
															<a href="{{ url('invoicesDetails') }}/{{ $invoice->id  }}">
																{{ $invoice->invoice_number }}
															</a>
														</td>
														<td>{{ $invoice->invoice_date }}</td>
														<td>{{ $invoice->due_date }}</td>
														<td>{{ $invoice->product }}</td>
														<td>{{ $invoice->section->section_name }}</td>
														<td>{{ $invoice->discount }}</td>
														<td>{{ $invoice->rate_vat }}</td>
														<td>{{ $invoice->value_vat }}</td>
														<td>{{ $invoice->total }}</td>
	
														@if ($invoice->value_status == 1)
															<td class="text-success">{{ $invoice->status }}</td>
														@elseif ($invoice->value_status == 2)
															<td class="text-danger">{{ $invoice->status }}</td>
														@else
															<td class="text-warning">{{ $invoice->status }}</td>
														@endif
														<td>{{ $invoice->note }}</td>
														<td>
															<div class="dropdown">
																<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary-gradient btn-sm"
																data-toggle="dropdown" type="button">العمليات <i class="fas fa-caret-down ml-1"></i></button>
																<div  class="dropdown-menu tx-13">
																	@can('تعديل الفاتورة')
																		<a class="dropdown-item" href="{{ route('editInvoice', $invoice->id) }}"><span class="text-primary"><i class="typcn typcn-edit"></i></span> تعديل الفاتورة</a>
																	@endcan
																	@can('تغير حالة الدفع')
																		<a class="dropdown-item" href="{{ route('edit-payment-status', $invoice->id) }}"><span class="text-success"><i class="fe fe-credit-card"></i></span> تغيير حالة الدفع</a>
																	@endcan
																	@can('طباعةالفاتورة')
																		<a class="dropdown-item" href="{{ route('print_invoice', $invoice->id) }}"><span class="text-primary"><i class="icon ion-ios-print"></i></span> طباعة الفاتورة</a>
																	@endcan
																	@can('ارشفة الفاتورة')
																		<a class="dropdown-item" data-id_invoice="{{ $invoice->id }}" data-toggle="modal" data-target="#invoices_archive" href=""><span class="text-warning"><i class="typcn typcn-arrow-back-outline"></i></span> نقل الى الارشيف</a>
																	@endcan
																	@can('حذف الفاتورة')
																		<a class="dropdown-item" data-id_invoice="{{ $invoice->id }}" data-toggle="modal" data-target="#delete_invoice" href=""><span class="text-danger"><i class="las la-trash"></i></span> حذف الفاتورة</a>
																	@endcan
																</div>
															</div>																		
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
				</div>
				<!-- row closed -->

				<!-- delete -->
				<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="{{ route('invoices.destroy', 'test') }}" method="post">
								@method('delete')
								@csrf
								<div class="modal-body">
									<p class="text-center">
										<h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
									</p>
									<input type="hidden" name="id_invoice" id="id_invoice" value="">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-danger">تاكيد</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="modal fade" id="invoices_archive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">ارشفة الفواتير</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="{{ route('invoices.destroy', 'test') }}" method="post">
								@method('delete')
								@csrf
								<div class="modal-body">
									<p class="text-center">
										<h6 style="color:green"> هل انت متاكد من عملية الارشفة ؟</h6>
									</p>
									<input type="hidden" name="id_invoice" id="id_invoice" value="">
									<input type="hidden" name="id_page" id="id_page" value="2">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-success">تاكيد</button>
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
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

<script>
	$('#delete_invoice').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var id_invoice = button.data('id_invoice')
			var modal = $(this)

			modal.find('.modal-body #id_invoice').val(id_invoice);
	})
</script>

<script>
	$('#invoices_archive').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget)
			var id_invoice = button.data('id_invoice')
			var modal = $(this)

			modal.find('.modal-body #id_invoice').val(id_invoice);
	})
</script>
@endsection