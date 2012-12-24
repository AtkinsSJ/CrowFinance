<div class="block form">
	<h2 class="title">Delete Category</h2>

	<div class="content">
		<p class="description">Are you sure you want to delete the '<?= $this->category->get('name') ?>' category?</p>
		<form action="categories/delete/<?= $this->category->get('id') ?>" method="post">

			<div class="formLine buttons">
				<input type="hidden" name="sure" value="true" />
				<a class="button left" href="categories">Cancel</a>
				<button type="submit" class="button primary right">Delete</button>
			</div>
		</form>
	</div>
</div>