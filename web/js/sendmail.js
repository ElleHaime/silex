$(document).ready(function ($) {

	$('#user_message').submit(
		function(event) {
			event.preventDefault();
			
			isFieldsFilled = checkRequiredFields('#user_message');
			if (isFieldsFilled != undefined) {
				markUserFormError(isFieldsFilled, 'Пожалуйста, заполните все обязательные поля');
				return false;
			}

			if ($('#user_email').val() != '') {
				isEmailValid = checkValidEmail($('#user_email').val());
				if (isEmailValid === false) {
					markUserFormError(isFieldsFilled, 'Некорректный e-mail');
					return false;
				}
			}
				
			$.when(sendUserEmail('#user_message')).then(function(result) {
				if (result.result == 'OK') {
					markUserFormSuccess('Улетело');
					disableForm('#user_message');
				} else {
					markUserFormError('', 'Shit happens');
				}
			});
			
			event.preventDefault();
			return false;
		}
	);
	
	return false;
});

checkRequiredFields = function(formElem) {
	var errorSendMessage; 
	
	inputElems = $(formElem).find(':checked,:selected,:text,textarea');
	inputElems.each(function() {
		if ($(this).data('required') == 1 && !$(this).val()) {
			errorSendMessage = $(this).attr('id');
			return false; 
		}
    });
	return errorSendMessage;
}


disableForm = function(formElem)
{
//	inputElems = $(formElem).find(':checked,:selected,:text,textarea,button');
//	inputElems.each(function() {
//		$(this).prop('disabled', true);
//    });
//	return true;
	$(':input',formElem).not(':button, :submit, :reset, :hidden')
	     				.prop('disabled', true);
	return true;
}

clearForm = function(formElem)
{
	$(':input',formElem).not(':button,:submit,:reset,:hidden')
	  				     .val('')
	  				     .removeAttr('checked');
	return true;
}

checkValidEmail = function (email) {
	var reEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return reEmail.test(email);
}

markUserFormError = function(formElem, errorMessage) {
	$('#user_message_send_error').html(errorMessage);
	return;
}

markUserFormSuccess = function(successMessage) {
	$('#user_message_send_success').html(successMessage);
	return;
}

hideUserFormMessage = function(messageElem) {
	$(messageElem).html('');
	return;
}


sendUserEmail = function(formElem) {
	var userPostData = {}; 
	
	inputElems = $(formElem).find(':checked,:selected,:text,textarea');
	inputElems.each(function() {
		userPostData[$(this).attr('name')] = $(this).val();
    });

	return $.ajax({
	    type: "POST",
	    url: "/contact/send",
	    contentType: "application/json",
	    data: JSON.stringify(userPostData),
	    success: function(data) {
	    	return data.result;
	    }
	});
}


postTrainingToGoogle = function()
{
	var errorSendMessage;
	var userRegisterData = {};
	
	isFieldsFilled = checkRequiredFields('#user_register_on_training');
	if (isFieldsFilled != undefined) {
		hideUserFormMessage('#user_message_send_success');
		markUserFormError(isFieldsFilled, 'Пожалуйста, заполните все обязательные поля');
		return false;
	}
	
	isEmailValid = checkValidEmail($('#user_register_email').val());
	if (isEmailValid === false) {
		hideUserFormMessage('#user_message_send_success');
		markUserFormError(isFieldsFilled, 'Некорректный e-mail');
		return false;
	}

	inputElems = $('#user_register_on_training').find(':checked,:selected,:text,textarea,:hidden');
	inputElems.each(function() {
		userRegisterData[$(this).data('guid')] = $(this).val();
    });

	return $.ajax({
        url: "https://docs.google.com/forms/d/1lta1cDxBCFDkS-Iyn1sR4xHshzKoH0d3x-OgazbxdHs/formResponse",
        data: userRegisterData,
        type: "POST",
        dataType: "xml",
        success: function(data) {
        	hideUserFormMessage('#user_message_send_error');
        	markUserFormSuccess('Спасибо, вы зарегистрированы. Напоминание будет выслано вам на e-mail');
        	clearForm('#user_register_on_training');
        },
        error: function(data) {
        	hideUserFormMessage('#user_message_send_error');
        	markUserFormSuccess('Спасибо, вы зарегистрированы. Напоминание будет выслано вам на e-mail');
        	clearForm('#user_register_on_training');
        },
    });
}
