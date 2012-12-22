<a class="button secondary left" href="transactions/view/<?=$this->previous;?>">Previous</a>
<a class="button secondary right floatRight" href="transactions/view/<?=$this->next;?>">Next</a>

<table class="statement">
	<thead>
		<tr>
			<th>Date</th>
			<th>Description</th>
			<th>Category</th>
			<th>In</th>
			<th>Out</th>
			<th></th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<td colspan="2"></td>
			<th>Totals:</th>
			<td class="number"><?= $this->currency ?> <?= number_format($this->totalIn, 2) ?></td>
			<td class="number"><?= $this->currency ?> <?= number_format($this->totalOut, 2) ?></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td colspan="2" class="number"><?= $this->currency ?> <?= number_format($this->total, 2) ?></td>
			<td></td>
		</tr>
	</tfoot>
	
	<tbody>
	<?php if (count($this->transactions)) : ?>
		<?php foreach ($this->transactions as $t): ?>
		<tr>
			<td class="date"><?= $t->get('date') ?></td>
			<td>
				<p class="description">
					<?= $t->get('description') ?>
				</p>
				<a class="button expandDescription">…</a>
			</td>
			<td class="category"><?= $this->categories[$t->get('category_id')] ?></td>
			<td class="number">
				<?php if ($t->get('income') > 0): ?>
					<?= $this->currency ?> <?= $t->get('income') ?>
				<?php endif; ?>
			</td>
			<td class="number">
				<?php if ($t->get('outgoing') > 0): ?>
					<?= $this->currency ?> <?= $t->get('outgoing') ?>
				<?php endif; ?>
			</td>
			<td class="buttons">
				<div class="buttonGroup">
					<a href="#" class="button">1</a>
					<a href="#" class="button">2</a>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="6">No transactions were found for <?= $this->date ?></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<a class="button secondary left" href="transactions/view/<?= $this->previous ?>">Previous</a>
<a class="button secondary right floatRight" href="transactions/view/<?= $this->next ?>">Next</a>
