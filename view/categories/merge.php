<div class="block form">
	<h2 class="title">Merge Category</h2>

	<div class="content">
		<div class="description">
			<p>
				Merging a category will transfer all of its transactions over
				to the chosen target category, and then remove the first category.
			</p>
		</div>
		<form action="categories/merge/<?= $this->category->get('id') ?>" method="post">
			<div class="formLine">
				<label for="target">Target category</label>
				<select name="merge" id="target">
					<?php foreach ($this->categories as $category): ?>
						<option value="<?= $category->get('id') ?>"><?= $category->get('name') ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="formLine buttons">
				<a class="button left" href="categories">Cancel</a>
				<button type="submit" class="button primary right">Merge</button>
			</div>
		</form>
	</div>
</div>