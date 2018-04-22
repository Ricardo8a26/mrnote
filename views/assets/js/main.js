(function(){
	'use strict';
    var API = location.protocol + '//' + location.hostname + '/middleware/index.php/mrnote/';

	class Mrnote{
		constructor(){
            
			var current = this;

            var password = current.getElement('#mrnote_check_password');
            var form_password = current.getElement('#mrnote_password');
            var enter_password = current.getElement('#mrnote_enter_password');
            var confirm_password = current.getElement('#mrnote_confirm_password');

            password.checked = false;


            password.onclick = function() {
                if(password.checked){ 
                    current.changeClass(form_password,'mrnote_hide','mrnote_visible');
                    enter_password.required = true;
                    confirm_password.required = true;
                } else {
                    current.changeClass(form_password,'mrnote_visible','mrnote_hide');
                    enter_password.required = false;
                    confirm_password.required = false;
                }
            };
            if (current.getController() == 'Public') {

            } 
		}
        get(data) {
            return eval(data);
        }
		getElement(element){
			return document.querySelector(element);
		}

		getAllElement(element){
			return document.querySelectorAll(element);
		}

		getMethod() {
            var path = location.pathname.split('/')[2];
            return path;
        }

        getController() {
            var path = location.pathname.split('/')[1];
            return path;
        }
        changeClass(element,classOut,classIn){
        	if(element.classList.contains(classOut)){
                element.classList.remove(classOut);
                element.classList.add(classIn);
        	} else if (!(element.classList.contains(classIn))){
        		element.classList.add(classIn);
        	} 
        }
	}

	new Mrnote();

})();