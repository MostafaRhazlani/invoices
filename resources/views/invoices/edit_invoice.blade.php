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
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الفاتورة</span>
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
							<form action="{{ url('invoices/update') }}" method="post">
								@method('PATCH')
								@csrf
								{{-- 1 --}}
									<div class="row">
									<div class="col">
										<label for="inputName" class="control-label">رقم الفاتورة</label>
										<input type="hidden" name="invoice_id" value="{{ $invoices->id }}">
										<input type="text" class="form-control" id="inputName" name="invoice_number" value="{{ $invoices->invoice_number }}" title="يرجي ادخال رقم الفاتورة">
									</div>

									<div class="col">
										<label>تاريخ الفاتورة</label>
										<input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->invoice_date }}">
									</div>

									<div class="col">
										<label>تاريخ الاستحقاق</label>
										<input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD" type="text" value="{{ $invoices->due_date }}">
									</div>
								</div>

								{{-- 2 --}}
								<div class="row">
									<div class="col">
										<label for="inputName" class="control-label">القسم</label>
										<select name="section" class="form-control SlectBox" onclick="console.log($(this).val())" onchange="console.log('change is firing')">
											<!--placeholder-->
											<option value="{{ $invoices->section->id }}" selected disabled>{{ $invoices->section->section_name }}</option>
											@foreach ($sections as $section)
											<option value="{{ $section->id }}"> {{ $section->section_name }}</option>
											@endforeach
										</select>
									</div>

									<div class="col">
											<label for="inputName" class="control-label">المنتج</label>
											<select id="product" name="product" class="form-control">
												<option value="">{{ $invoices->product }}</option>
											</select>
									</div>

									<div class="col">
											<label for="inputName" class="control-label">مبلغ التحصيل</label>
											<input type="text" class="form-control" id="inputName" name="amount_collection"
													oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ $invoices->amount_collection }}">
									</div>
								</div>

								{{-- 3 --}}
								<div class="row">
									<div class="col">
										<label for="inputName" class="control-label">مبلغ العمولة</label>
										<input type="text" class="form-control form-control-lg" id="amount_commission"
												name="amount_commission" title="يرجي ادخال مبلغ العمولة "
												oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{ $invoices->amount_commission }}">
									</div>

									<div class="col">
											<label for="inputName" class="control-label">الخصم</label>
											<input type="text" class="form-control form-control-lg" id="discount" name="discount"
													title="يرجي ادخال مبلغ الخصم "
													oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
													value="{{ $invoices->discount }}">
									</div>

									<div class="col">
										<label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
										<select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()">
											<!--placeholder-->
											<option value="{{ $invoices->rate_vat }}" selected disabled>{{ $invoices->rate_vat }}</option>
											<option value=" 5%">5%</option>
											<option value="10%">10%</option>
										</select>
									</div>
								</div>

								{{-- 4 --}}
								<div class="row">
									<div class="col">
										<label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
										<input type="text" class="form-control" id="value_vat" name="value_vat" readonly value="{{ $invoices->value_vat }}">
									</div>

									<div class="col">
										<label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
										<input type="text" class="form-control" id="total" name="total" readonly value="{{ $invoices->total }}">
									</div>
								</div>

								{{-- 5 --}}
								<div class="row">
									<div class="col">
										<label for="exampleTextarea">ملاحظات</label>
										<textarea class="form-control" id="exampleTextarea" name="note" rows="3">{{ $invoices->note }}</textarea>
									</div>
								</div><br>

								<div class="d-flex justify-content-center">
									<button type="submit" class="btn btn-primary-gradient">حفظ البيانات</button>
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
	// this for date
	var date = $('.fc-datepicker').datepicker({
			dateFormat: 'yy-mm-dd'
	}).val();
</script>

<script>
	// ajax
	$(document).ready(function() {
		$('select[name="section"]').on('change', function() {
				var SectionId = $(this).val();
				if (SectionId) {
					$.ajax({
						url: "{{ URL::to('section') }}/" + SectionId,
						type: "GET",
						dataType: "json",
						success: function(data) {
							console.log('data', data);
							$('select[name="product"]').empty();
							$.each(data, function(key, value) {
								$('select[name="product"]').append('<option value="' + value + '">' + value + '</option>');
							});
						},
					});

				} else {
						console.log('AJAX load did not work');
				}
		});
  });
</script>

<script>
	function myFunction() {
		let amount_commission = parseFloat(document.getElementById("amount_commission").value);
		let discount = parseFloat(document.getElementById("discount").value);
		let rate_vat = parseFloat(document.getElementById("rate_vat").value);
		let value_vat = parseFloat(document.getElementById("value_vat").value);

		let amount_commission2 = amount_commission - discount;

		if (typeof amount_commission === 'undefined' || !amount_commission) {
			alert('يرجى ادخال مبلغ العمولة');
		} else {
			let intResult = amount_commission2 * rate_vat / 100;
			let intResult2 = parseFloat(intResult + amount_commission2);

			sumq = parseFloat(intResult).toFixed(2);
			sumt = parseFloat(intResult2).toFixed(2);
			
			document.getElementById('value_vat').value = sumq;
			document.getElementById('total').value = sumt;
		}
	}
</script>
@endsection
