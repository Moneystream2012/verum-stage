@extends('layouts.personal-office')
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/2.2.7/echarts-all.js"></script>
<script>
	var evoChart = echarts.init ( document.getElementById ( 'full-tree' ) );
	var option = {
		title:   {
			text: ''
		},
		tooltip: {
			trigger:   'item',
			formatter: function ( params ) {
				console.log ( params );
				if ( params[ 2 ].point_left_week == null ) return '-';
				return params[ 2 ].point_left_week + ' | ' + params[ 2 ].point_right_week;
			}
		},
		toolbox: {
			show:    true,
			feature: {
				mark:        {
					show: false
				},
				dataView:    {
					show:     false,
					readOnly: true
				},
				restore:     {
					show: false
				},
				saveAsImage: {
					show: false
				}
			}
		},
		series:  [
			{
				name:         'Binary Tree',
				type:         'tree',
				orient:       'vertical',
				rootLocation: {
					x: 'center',
					y: 50
				},
				nodePadding:  70,
				layerPadding: 70,
				hoverable:    false,
				roam:         true,
				symbolSize:   20,
				itemStyle:    {
					normal:   {
						color:     '#357ebd',
						label:     {
							show:      true,
							position:  'bottom',
							formatter: "{b}",
							textStyle: {
								color:    '#000',
								fontSize: 11
							}
						},
						lineStyle: {
							color: '#ddd',
							type:  'curve' // 'curve'|'broken'|'solid'|'dotted'|'dashed'

						}
					},
					emphasis: {
						color:       '#4883b4',
						label:       {
							show: false
						},
						borderWidth: 0
					}
				},

				data: [
					{!! $json !!}
				]
			}
		]
	};
	evoChart.setOption ( option );
</script>
@endpush
@section('page')
	<div class="container-fluid-md">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-sitemap"></i> Binary Tree Full view
			</div>
			<div class="panel-body">
				<div id="full-tree" style="height:800px;"></div>
			</div>
		</div>
	</div>
@endsection
