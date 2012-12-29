<div class="block form">
	<h2 class="title">Create New Category</h2>

	<div class="content">
		<div class="description">
			<p>
				Create a category to organise your transactions.
			</p>
		</div>
		<form action="categories/create" method="post">
			<div class="formLine">
				<label for="name">Name</label>
				<input type="text" id="name" name="name" required/>
			</div>

			<div class="formLine buttons">
				<a class="button left" href="categories">Cancel</a>
				<button type="submit" class="button primary right">Save</button>
			</div>
		</form>
	</div>
</div>