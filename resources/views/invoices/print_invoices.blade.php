@extends('layouts.master')

@section('title')
طباعة الفاتورة
@endsection

@section('css')
  <style>
    @media print {
      #print_button{
        display: none;
      } 
    }
  </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل طباعة الفاتورة</span>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12" >
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoice-header">
										<h1 class="invoice-title">تفاصيل الفاتورة</h1>
										<div class="billed-from">
											<h6>BootstrapDash, Inc.</h6>
											<p>201 Something St., Something Town, YT 242, Country 6546<br>
											Tel No: 324 445-4544<br>
											Email: youremail@companyname.com</p>
										</div><!-- billed-from -->
									</div><!-- invoice-header -->
									<div class="row mg-t-20">
										<div class="col-md">
											<label class="tx-gray-600">Billed To</label>
											<div class="billed-to">
												<h6>Juan Dela Cruz</h6>
												<p>4033 Patterson Road, Staten Island, NY 10301<br>
												Tel No: 324 445-4544<br>
												Email: youremail@companyname.com</p>
											</div>
										</div>
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتورة</span> <span>{{ $print_invoice->invoice_number }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاصدار</span> <span>{{ $print_invoice->invoice_date }}</span></p>
											<p class="invoice-info-row"><span>تاريخ الاستحقاق</span> <span>{{ $print_invoice->due_date }}</span></p>
											<p class="invoice-info-row"><span>القسم</span> <span>{{ $print_invoice->section->section_name }}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">المنتج</th>
													<th class="tx-center">مبلغ التحصيل</th>
													<th class="tx-center">مبلغ العمولة</th>
													<th class="tx-center">الاجمالي</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td class="tx-12">{{ $print_invoice->product }}</td>
													<td class="text-center tx-center">${{ number_format($print_invoice->amount_collection, 2)  }}</td>
													<td class="text-center tx-right">${{ number_format($print_invoice->amount_commission, 2)  }}</td>

                          <?php $total =  $print_invoice->amount_collection + $print_invoice->amount_commission?>
													<td class="text-center tx-right">${{ number_format($total, 2) }}</td>
												</tr>
                        <tr>
                          <td colspan="5" rowspan="1"></td>
                        </tr>
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">ملاحضات</label>
															<p>{{ $print_invoice->note }}</p>
														</div><!-- invoice-notes -->
													</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبة ({{ $print_invoice->rate_vat }})</td>
													<td class="tx-right" colspan="2"><span class="text-success">+ </span>${{ number_format($print_invoice->value_vat, 2) }}</td>
												</tr>
												<tr>
													<td class="tx-right">قيمة الخصم</td>
													<td class="tx-right" colspan="2"><span class="text-danger">- </span>${{ number_format($print_invoice->discount, 2) }}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">${{ number_format($print_invoice->total, 2) }}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									<a href="#" id="print_button" onclick="printDiv()" class="btn btn-danger float-left mt-3 mr-2">
										<i class="mdi mdi-printer ml-1"></i>طباعة
									</a>
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script>
  function printDiv() {
    let printContent = document.getElementById('print').innerHTML;
    let originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    window.reload();
  }
</script>
@endsection