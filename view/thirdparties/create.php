<div class="block form">
	<h2 class="title">Create a Third Party</h2>
	<div class="content">
		<div class="description">
			<p>
				Third Parties let you organise transactions by specifying
				where income comes from, and where outgoings go to.
			</p>
		</div>

		<form action="thirdparties/create" method="post">
			<div class="formLine">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" required value="<?= $this->thirdParty->get('name') ?>"/>
			</div>

			<div class="formLine">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="53" rows="6"><?= $this->thirdParty->get('description') ?></textarea>
			</div>

			<div class="formLine buttons">
				<a class="button left" href="thirdparties">Cancel</a>
				<button type="submit" class="button primary right">Save</button>
			</div>
		</form>
	</div>

</div>