import Base from '../Base.js';

export default class FormRegister extends Base {
	initDOMElements(e) {
        this.els = {
        	_registerBtn: $('.register-btn'),
        	_registerFormContainer: $('.register-form__container'),
        	_registerForm: $('.register-form'),
        	_registerSubmit: $('.register-form .submit__button'),
        	_closeBtn: $('.close-btn')
        }
    }

	onDOMReady(e) {
		this.els._registerBtn.click((e) => this.showRegisterForm(e));
		this.els._registerFormContainer.click((e) => this.closeRegisterFormWithLosingFocus(e));
		this.els._closeBtn.click((e) => this.closeRegisterForm(e));
	}

	showRegisterForm(e) {
		e.preventDefault();
		this.els._registerFormContainer.fadeIn();
	}

	closeRegisterFormWithLosingFocus(e) {
		// checks if descendants was clicked && checks if the element itself was clicked
		if (this.els._registerForm.has(e.target).length == 0 && 
			!this.els._registerForm.is(e.target) ) {
			this.els._registerFormContainer.fadeOut();
		}
	}
	closeRegisterForm(e) {
		e.preventDefault();
		this.els._registerFormContainer.fadeOut();
	}
}