<div class="register-form__container">
	<form action="/register" method="GET" class="register-form rounded p-3">
		<button class="close-btn"></button>
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="text" name="name" placeholder="name" required>
		</div>
	
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="text" name="email" placeholder="email" required>
		</div>
	
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="password" name="password" placeholder="password" required>
		</div>
	
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="password" name="confirm_password" placeholder="confirm password" required>
		</div>
	
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="text" name="first_name" placeholder="first name">
		</div>
	
		<div class="input__container shadow p-3 m-3 bg-white rounded">
			<input type="text" name="last_name" placeholder="last name">
		</div>
	
		<div class="float-right buttons__container m-3">
			<button class="btn submit__button d-block" type="submit">Send</button>
		</div>
	</form>
</div>