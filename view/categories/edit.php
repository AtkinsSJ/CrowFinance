<div class="block form">
	<h2 class="title">Edit Category</h2>

	<div class="content">
		<form action="categories/edit/<?= $this->category->get('id') ?>" method="post">
			<div class="formLine">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" value="<?= $this->category->get('name') ?>"/>
			</div>

			<div class="formLine buttons">
				<a class="button left" href="categories">Cancel</a>
				<button type="submit" class="button primary right">Save</button>
			</div>
		</form>
	</div>
</div>