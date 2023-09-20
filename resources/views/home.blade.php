@extends('layouts.master')

@section('title')
	الصفحة الرئيسية
@endsection

@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">اهلا، مرحبا بعودتك</h2>
						  <p class="mg-b-0">لوحة الفواتير</p>
						</div>
					</div>
					<div class="main-dashboard-header-right">
						<div>
							<label class="tx-13">Customer Ratings</label>
							<div class="main-star">
								<i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
							</div>
						</div>
						<div>
							<label class="tx-13">Online Sales</label>
							<h5>563,275</h5>
						</div>
						<div>
							<label class="tx-13">Offline Sales</label>
							<h5>783,675</h5>
						</div>
					</div>
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">${{ number_format(\App\Models\Invoice::sum('total'), 2) }}</h4>
											<p class="mb-0 tx-13 text-white op-8">عدد الفواتير ({{ \App\Models\Invoice::count() }})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">100%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">${{ number_format(\App\Models\Invoice::where('status', 'مدفوعة')->sum('total'), 2) }}</h4>
											<p class="mb-0 tx-13 text-white op-8">عدد الفواتير المدفوعة ({{ \App\Models\Invoice::where('value_status', 1)->count() }})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">{{round((\App\Models\Invoice::where('value_status', 1)->count() / \App\Models\Invoice::count()) * 100)}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير غير مدفوعة</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">${{ number_format(\App\Models\Invoice::where('value_status', 2)->sum('total'), 2) }}</h4>
											<p class="mb-0 tx-13 text-white op-8">عدد الفواتير غير مدفوعة ({{ \App\Models\Invoice::where('value_status', 2)->count() }})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">{{round((\App\Models\Invoice::where('value_status', 2)->count() / \App\Models\Invoice::count()) * 100)}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">${{ number_format(\App\Models\Invoice::where('status', 'مدفوعة جزئيا')->sum('total'), 2) }}</h4>
											<p class="mb-0 tx-13 text-white op-8">عدد الفواتير المدفوعة جزئيا ({{ \App\Models\Invoice::where('value_status', 3)->count() }})</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<?php  ?>
											<?php  ?>
											<?php  ?>
											<span class="text-white op-7">{{round((\App\Models\Invoice::where('value_status', 3)->count() / \App\Models\Invoice::count()) * 100)}}%</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-12 col-xl-7">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">Order status</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								<p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival. To begin, enter your order number.</p>
							</div>
							<div class="card-body">
								<div class="chartjs-wrapper-demo">
									<canvas id="myChart"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-xl-5">
						<div class="card card-dashboard-map-one">
							<label class="main-content-label">Sales Revenue by Customers in USA</label>
							<span class="d-block mg-b-20 text-muted tx-12">Sales Performance of all states in the United States</span>
							<div class="chartjs-wrapper-demo">
								<canvas id="chartPie"></canvas>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script>
	var ctx3 = document.getElementById('myChart').getContext('2d');
	var blueGradient = ctx3.createLinearGradient(0, 0, 0, 250);
	var greenGradient = ctx3.createLinearGradient(0, 0, 0, 250);
	var redGradient = ctx3.createLinearGradient(0, 0, 0, 250);
	var orangeGradient = ctx3.createLinearGradient(0, 0, 0, 250);

	blueGradient.addColorStop(0, '#0db2de');
	blueGradient.addColorStop(1, '#005bea');

	greenGradient.addColorStop(0, '#48d6a8');
	greenGradient.addColorStop(1, '#029666');

	redGradient.addColorStop(0, '#f7778c');
	redGradient.addColorStop(1, '#f93a5a');

	orangeGradient.addColorStop(0, '#efa65f');
	orangeGradient.addColorStop(1, '#f76a2d');
	new Chart(ctx3, {
		type: 'bar',
		data: {
			labels: ['الاجمالي', 'الفواتير المدفوعة', 'الفواتير غير مدفوعة', 'الفواتير المدفوعة جزئيا'],
			datasets: [{
				// label: '# of Votes',
				data: [100, Math.round('{{$resutlPaid}}'), Math.round('{{$resutlUnPaid}}'), Math.round('{{$resutlPartiall}}')],
				backgroundColor: [blueGradient, greenGradient, redGradient, orangeGradient],
				hoverBackgroundColor: ['#0db2de', '#48d6a8', '#f7778c', '#efa65f']
			}]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false,
				labels: {
					display: false
				}
			},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 10,
						fontColor: "rgb(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}],
				xAxes: [{
					ticks: {
						beginAtZero: true,
						fontSize: 11,
						max: 80,
						fontColor: "rgb(171, 167, 167,0.9)",
					},
					gridLines: {
						display: true,
						color: 'rgba(171, 167, 167,0.2)',
						drawBorder: false
					},
				}]
			}
		}
	});
</script>
<script>
	var ctx7 = document.getElementById('chartPie');
	new Chart(ctx7, {
		type: 'pie',
		data: {
			labels: ['الفواتير المدفوعة', 'الفواتير غير مدفوعة', 'الفواتير المدفوعة جزئيا'],
			datasets: [{
				data: [Math.round('{{$resutlPaid}}'), Math.round('{{$resutlUnPaid}}'), Math.round('{{$resutlPartiall}}')],
				backgroundColor: [greenGradient, redGradient, orangeGradient],
				hoverBackgroundColor: ['#48d6a8', '#f7778c', '#efa65f']
			}]
		},
		options: {
			maintainAspectRatio: false,
			responsive: true,
			legend: {
				display: true,
				labels: {
					fontFamily: 'Cairo',
					fontColor: 'black'
				}
			},
			animation: {
				animateScale: true,
				animateRotate: true
			}
		}
	});
</script>
@endsection