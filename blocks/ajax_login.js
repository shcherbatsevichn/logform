$( document ).ready(function() {
    $("#logbtn").click(
		function(){
			sendAjaxForm( 'ajax_form_log', 'blocks/ajax_login.php');
			return false; 
		}
	);
});
 
function sendAjaxForm( ajax_form, url) {
    $.ajax({
        url:     url, //url страницы php
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
            if((result.error) == 0) {    //если ощибок не возникло 
                document.location.href = "../userinterface.php"; //идем на форму userinterface 
                        }
            else{
                for(i=0; i<2;i++){ // записываем ошибки. каждую в свою форму 
                    if(i == 0){
                        $('#result_form_log').html("<br>"+result.errorlog); 
                    }
                    if(i == 1){
                        $('#result_form_psw').html("<br>"+result.errorpsw); 
                    }
                }
            }
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form_log').html('Ошибка. Данные не отправлены.');
    	}
 	});
}