$(document).ready(function(){
	$('.modal-statistics-trigger').click(function(){
		var statistics_type = $(this).data('statistics-type');

		switch (statistics_type) {
			case "proposals_created":
				$('#modal-statistics-detail-title').empty().append('Proposal Created Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.proposal_name + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'workorder/proposal/' + value.proposal_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "direct_proposals":
				$('#modal-statistics-detail-title').empty().append('Direct Proposals Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.proposal_name + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'workorder/proposal/' + value.proposal_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "brief_proposals":
				$('#modal-statistics-detail-title').empty().append('Brief Proposals Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.proposal_name + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'workorder/proposal/' + value.proposal_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "sold_proposals":
				$('#modal-statistics-detail-title').empty().append('Sold Proposals Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.proposal_name + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'workorder/proposal/' + value.proposal_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "inventories_created":
				$('#modal-statistics-detail-title').empty().append('Inventories Created Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.inventory_planner_title + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'inventory/inventoryplanner/' + value.inventory_planner_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "inventories_linked_with_proposal":
				$('#modal-statistics-detail-title').empty().append('Inventories Linked With Proposals Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.inventory_planner_title + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'inventory/inventoryplanner/' + value.inventory_planner_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "inventories_not_sold":
				$('#modal-statistics-detail-title').empty().append('Inventories Not Sold Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.inventory_planner_title + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'inventory/inventoryplanner/' + value.inventory_planner_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			case "inventories_sold":
				$('#modal-statistics-detail-title').empty().append('Inventories Sold Detail');
				var data = load_statistics_data(statistics_type, $('#dashboard-month').val(), $('#dashboard-year').val());
				$('#table-statistics-detail tbody').empty();
				$.each(data, function(key,value){
					var html = '';
					html += '<tr>';
					html += '<td>' + value.inventory_planner_title + '</td>';
					html += '<td>' + value.user_firstname + ' ' + value.user_lastname + '</td>';
					html += '<td><a href="' + base_url + 'inventory/inventoryplanner/' + value.inventory_planner_id + '" target="_blank">View</a></td>';
					html += '</tr>';
					$('#table-statistics-detail tbody').append(html);
				});
				break;
			default:
				$('#modal-statistics-detail-title').empty().append('-');
				break;
		}
		
	});

	function load_statistics_data(type, month, year){
		var return_data;
		$.ajax({
			url: base_url + 'api/statisticsDetail',
			type: 'POST',
			data: {
					'_token' : $('meta[name="csrf-token"]').attr('content'),
					'statistics_type' : type,
					'month' : month,
					'year' : year
					},
			dataType: 'json',
			async: false,
			success: function(data) {
				return_data = data;
			}
		});

		return return_data;
	}
});