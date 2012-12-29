<div class="block form">
	<h2 class="title">Edit a Third Party</h2>
	<div class="content">
		<form action="thirdparties/edit/<?= $this->thirdParty->get('id') ?>" method="post">
			<div class="formLine">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" required value="<?= $this->thirdParty->get('name') ?>"/>
			</div>

			<div class="formLine">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="53" rows="6"><?= $this->thirdParty->get('description') ?></textarea>
			</div>

			<div class="formLine buttons">
				<a class="button left" href="categories">Cancel</a>
				<button type="submit" class="button primary right">Save</button>
			</div>
		</form>
	</div>

</div>