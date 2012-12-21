<? if (!$this->loggedIn): ?>
<div class="block form">
	<h2 class="title">Log in</h2>
	
	<div class="content">
		
		<div class="description">
			<p>In order to manage your finances, you first need to log in.</p>
			<p>Enter your username and password below.</p>
		</div>

		<form action="login" method="post">
			<div class="formLine">
				<label for="username">Username</label>
				<input type="text" name="username" id="username"/>
			</div>
			
			<div class="formLine">
				<label for="password">Password</label>
				<input type="password" name="password" id="password"/>
			</div>
			
			<div class="formLine buttons">
				<button type="submit" class="button primary right">Submit</button>
			</div>
		</form>
	</div>
</div>
<? else: ?>
<div class="block">
	<h2 class="title">Already Logged In</h2>
	<p>You are already logged in as <?= $this->user->getDisplayName() ?>.</p>
</div>
<? endif; ?>