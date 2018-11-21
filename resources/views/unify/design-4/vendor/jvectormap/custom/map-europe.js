// Europe
$(function(){
	$('#mapEurope').vectorMap({
		map: 'europe_mill',
		zoomOnScroll: false,
		series: {
			regions: [{
				values: gdpData,
				scale: ['#4266b2', '#102f73'],
				normalizeFunction: 'polynomial'
			}]
		},
		backgroundColor: '#ffffff',
	});
});