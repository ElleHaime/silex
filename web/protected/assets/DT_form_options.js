$(document).ready(function ($) {
	
	$('#make_status_active').on('click', function () { 
		changeEntityStatus(1, $(this).data('url'), 'green', 'Опубликовано'); 
	});
	$('#make_status_inactive').on('click', function () { 
		changeEntityStatus(0, $(this).data('url'), 'grey', 'Скрыто'); 
	});
	$('#delete_entities').on('click', function () { 
		checkedIds = getCheckedEntitiesIds();
		deleteEntities(checkedIds, 'batch', $(this).data('url'));
	});
	$('.delete-entity-tbl').on('click', function () {
		checkedIds = [$(this).data('id')];
		deleteEntities(checkedIds, 'single', $(this).data('url'));
	});
});


function changeEntityStatus(status, url, resultColor, resultText)
{
	checkedIds = getCheckedEntitiesIds();
	request = {};

	if (checkedIds.length) {
		request.ids = checkedIds;
		request.newStatus = status;

		$.when(sendRequest('post', url, request)).then(function(response) {
			if (response.state == 'OK') {
				for (index = 0; index < response.ids.length; ++index) {
					$('#entityFullList tbody #item_status-' + response.ids[index]).css('color', resultColor).html(resultText);
				}
				if ($('#entityFullList thead input[name="masterCheck"]').checked) {
					$('#entityFullList thead input[name="masterCheck"]').trigger('click');
				}
				$('#entityFullList tbody input[type="checkbox"]:checked').trigger('click');
			} else {
				displayNotification('error', 'Shit happens, try later', true);
			}
		});

	} else {
		displayNotification('error', 'Не выбран ни один элемент', true);
	}
}

function deleteEntities(checkedIds, type, url)
{
	request = {};
	
	if (checkedIds.length) {
		request.ids = checkedIds;

		$.when(sendRequest('post', url, request)).then(function(response) {
			if (response.state == 'OK') {
				for (i = 0; i < response.ids.length; ++i) {
					tblIndex = $('#entityFullList tbody #item_row-' + response.ids[i]).index();
					$('#entityFullList').dataTable().fnDeleteRow(tblIndex);
				}
				if (type == 'batch' && $('#entityFullList thead input[name="masterCheck"]').checked) {
					$('#entityFullList thead input[name="masterCheck"]').trigger('click');
				}
			} else {
				displayNotification('error', 'Shit happens, try later', true);
			}
		});

	} else {
		displayNotification('error', 'Не выбран ни один элемент', true);
	}
}

function getCheckedEntitiesIds(tblName)
{	
	var checkedEntitiesIds = []; 
	
	$('#entityFullList tbody input[type="checkbox"]:checked').each(function() {
		checkedEntitiesIds.push($(this).data('id'));
	});
	
	return checkedEntitiesIds;
}

function displayNotification(type, content, autohide)
{
	$('#flash_noti_content').html(content);
	$('#block_notifications').toggleClass('alert-' + type).show().delay(3000).fadeOut('slow');
}

function sendRequest(type, url, data)
{
	//console.log(JSON.stringify(data));
	return $.ajax({
	    type: type,
	    url: url,
	    contentType: "application/json",
	    data: JSON.stringify(data),
	    success: function(response) {
	    	return response;
	    }
	});
}