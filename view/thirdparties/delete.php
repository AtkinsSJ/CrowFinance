<div class="block form">
	<h2 class="title">Delete Third Party</h2>

	<div class="content">
		<p class="description">Are you sure you want to delete the '<?= $this->thirdParty->get('name') ?>' category?</p>
		<form action="thirdparties/delete/<?= $this->thirdParty->get('id') ?>" method="post">

			<div class="formLine buttons">
				<input type="hidden" name="sure" value="true" />
				<a class="button left" href="thirdparties">Cancel</a>
				<button type="submit" class="button primary right">Delete</button>
			</div>
		</form>
	</div>
</div>