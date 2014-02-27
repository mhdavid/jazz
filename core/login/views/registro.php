<script type="text/javascript" src="<?php echo BASE_URL; ?>static/js/sha512.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>static/js/forms.js"></script>
<form action="<?php echo BASE_URL; ?>usuarios/main/registraraction" method="post">
	Email: <input type="text" name="email" /><br />
   Password: <input type="password" name="password" id="password"/><br />
   <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
</form>