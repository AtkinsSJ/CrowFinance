<table>
	<thead>
		<tr>
			<th rowspan="2">Category</th>
			<th colspan="3">In last 12 Months</th>
			<th rowspan="2">Actions</th>
		</tr>
		<tr>
			<th>Transactions</th>
			<th>Income</th>
			<th>Outgoing</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="4"></td>
			<td><a href="categories/create" class="button primary right">Create new Category</a></td>
		</tr>
	</tfoot>

	<tbody>
		<?php foreach ($this->categories as $category): ?>
		<tr>
			<td><?= $category->get('name') ?></td>
			<td><?= $category->get('count') ?></td>
			<td><?= $this->currency ?> <?= $category->get('income') ?></td>
			<td><?= $this->currency ?> <?= $category->get('outgoing') ?></td>
			<td>
				<div class="buttonGroup">
					<a href="categories/edit/<?= $category->get('id') ?>" class="button edit">Edit</a>
					<a href="categories/merge/<?= $category->get('id') ?>" class="button">Merge</a>
					<a href="categories/delete/<?= $category->get('id') ?>" class="button delete">Delete</a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>