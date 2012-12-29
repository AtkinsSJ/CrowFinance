<table>
	<thead>
		<tr>
			<th rowspan="2">Third Party</th>
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
			<td><a href="thirdparties/create" class="button primary right">Create new Third Party</a></td>
		</tr>
	</tfoot>

	<tbody>
		<?php foreach ($this->thirdParties as $thirdParty): ?>
		<tr>
			<td><?= $thirdParty->get('name') ?></td>
			<td><?= $thirdParty->get('count') ?></td>
			<td><?= $this->currency ?> <?= $thirdParty->get('income') ?></td>
			<td><?= $this->currency ?> <?= $thirdParty->get('outgoing') ?></td>
			<td>
				<div class="buttonGroup">
					<a href="thirdparties/edit/<?= $thirdParty->get('id') ?>" class="button edit">Edit</a>
					<a href="thirdparties/delete/<?= $thirdParty->get('id') ?>" class="button delete">Delete</a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>