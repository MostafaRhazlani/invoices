@extends('layouts.master')
@section('title')
تعديل فاتورة
@stop
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ حالة الدفع</span>
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
			<!-- row -->
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card">
						<div class="card-body">
							<form action="{{ route('update_payment_status', $invoices->id) }}" method="get">
								@csrf
								{{-- 1 --}}
									<div class="row">
									<div class="col">
										<label for="" class="control-label">رقم الفاتورة</label>
										<input type="hidden" name="id_invoice" value="{{ $invoices->id }}">
										<input type="text" class="form-control" id="" name="invoice_number" value="{{ $invoices->invoice_number }}" title="يرجي ادخال رقم الفاتورة" readonly>
									</div>

									<div class="col">
										<label for="">تاريخ الفاتورة</label>
										<input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->invoice_date }}" readonly>
									</div>

									<div class="col">
										<label>تاريخ الاستحقاق</label>
										<input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->due_date }}" readonly>
									</div>
								</div><br>

								{{-- 2 --}}
								<div class="row">
									<div class="col">
										<label for="" class="control-label">القسم</label>
										{{-- <input type="text" class="form-control" id="" name="section_name" value="{{ $invoices->section->section_name }}" readonly> --}}
										<select name="section" class="form-control SlectBox" readonly>
											<!--placeholder-->
											<option value=" {{ $invoices->section->id }}">
													{{ $invoices->section->section_name }}
											</option>
                    </select>
									</div>

									<div class="col">
										<label for="" class="control-label">المنتج</label>
										{{-- <input type="text" class="form-control" id="" name="product" value="{{ $invoices->product }}" readonly> --}}
										<select id="product" name="product" class="form-control" readonly>
											<option value="{{ $invoices->product }}"> {{ $invoices->product }}</option>
									</select>

									</div>

									<div class="col">
											<label for="" class="control-label">مبلغ التحصيل</label>
											<input type="text" class="form-control" id="" name="amount_collection"
													oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ $invoices->amount_collection }}" readonly>
									</div>
								</div><br>

								{{-- 3 --}}
								<div class="row">
									<div class="col">
										<label for="" class="control-label">مبلغ العمولة</label>
										<input type="text" class="form-control form-control-lg" id="amount_commission"
												name="amount_commission" value="{{ $invoices->amount_commission }}" readonly>
									</div>

									<div class="col">
											<label for="" class="control-label">الخصم</label>
											<input type="text" class="form-control form-control-lg" id="discount" name="discount" value="{{ $invoices->discount }}" readonly>
									</div>

									<div class="col">
										<label for="" class="control-label">نسبة ضريبة القيمة المضافة</label>
										<input type="text" class="form-control form-control-lg" id="rate_vat" name="rate_vat" value="{{ $invoices->rate_vat }}" readonly>
										
									</div>
								</div><br>

								{{-- 4 --}}
								<div class="row">
									<div class="col">
										<label for="" class="control-label">قيمة ضريبة القيمة المضافة</label>
										<input type="text" class="form-control" id="value_vat" name="value_vat" readonly value="{{ $invoices->value_vat }}">
									</div>

									<div class="col">
										<label for="" class="control-label">الاجمالي شامل الضريبة</label>
										<input type="text" class="form-control" id="total" name="total" readonly value="{{ $invoices->total }}">
									</div><br>
								</div>

								{{-- 5 --}}
								<div class="row">
									<div class="col">
										<label for="exampleTextarea">ملاحظات</label>
										<textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>{{ $invoices->note }}</textarea>
									</div>
								</div><br>
								
								<div class="row">
									<div class="col">
										<label for="status" class="control-label">حالة الدفع</label>
										<select id="status" name="status" class="form-control">
											<!--placeholder-->
											<option value="" selected disabled>حدد حالة الدفع</option>
											<option value="مدفوعة">مدفوعة</option>
											<option value="مدفوعة جزئيا">مدفوعة جزئيا</option>
										</select>
									</div>

									<div class="col">
										<label for="">تاريخ الدفع</label>
										<input class="form-control fc-datepicker" name="payment_date" placeholder="YYYY-MM-DD" type="text" value="">
									</div>
								</div><br>

								<div class="d-flex justify-content-center">
									<button type="submit" class="btn btn-primary-gradient">تحديث حالة الدفع</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- row closed -->
		</div>
		<!-- Container closed -->
	</div>
	<!-- main-content closed -->
@endsection
@section('js')
 <!-- Internal Select2 js-->
 <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
 <!--Internal Fileuploads js-->
 <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
 <!--Internal Fancy uploader js-->
 <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
 <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
 <!--Internal  Form-elements js-->
 <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
 <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
 <!--Internal Sumoselect js-->
 <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
 <!--Internal  Datepicker js -->
 <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
 <!--Internal  jquery.maskedinput js -->
 <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
 <!--Internal  spectrum-colorpicker js -->
 <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
 <!-- Internal form-elements js -->
 <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

 <script>
	var date = $('.fc-datepicker').datepicker({
			dateFormat: 'yy-mm-dd'
	}).val();

</script>

@endsection
