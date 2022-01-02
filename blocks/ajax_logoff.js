$( document ).ready(function() {
    $("#logoffbtn").click(
		function(){
			sendAjaxForm('result_form_logoff', 'ajax_form_logoff', 'blocks/ajax_logoff.php');
			return false; 
		}
	);
});
 
function sendAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url:     url, //url страницы php
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
            if((result.error) == 0) {    //если ошибок не возникло,
                document.location.href = "../index.php"; //перебрасываем пользователя на страницу с авторизацией 
            }
            else{
                $('#'+result_form).html("<br>"+result.errorsing); 
            }
    	},
    	error: function(response) { // Данные не отправлены
            $('#'+result_form).html('Ошибка. Данные не отправлены.');
    	}
 	});
}