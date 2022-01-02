$( document ).ready(function() {
    $("#regbtn").click(
		function(){
			sendAjaxForm('ajax_form', 'blocks/ajax_reg.php');
            
			return false; 
		}
	);
});
 
function sendAjaxForm(ajax_form, url) {
    $.ajax({
        url:     url, //url страницы php
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+ajax_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	result = $.parseJSON(response);
            if((result.error) == 0) {    //если ошибок не возникло 
                document.location.href = "../index.php"; //переходим на форму авторизации
            }
            else{
                for(i=0; i<5;i++){ // записываем ошибки. каждую в свою форму 
                    if(i == 0){
                        $('#result_form_login').html(result.errorlog);
                    }
                    else if(i == 1){
                        $('#result_form_psw').html(result.errorpsw);
                    }
                    else if(i == 2){
                        $('#result_form_pswrp').html(result.errormpsw);
                    }
                    else if(i == 3){
                        $('#result_form_email').html(result.erroremail);
                    }
                    else if(i == 4){
                        $('#result_form_name').html(result.errorname);
                    }
                }
 
            }
    	},
    	error: function(response) { // Данные не отправлены
            $('#result_form_login').html('Ошибка. Данные не отправлены.');
    	}
 	});
}