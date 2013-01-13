<div class="block form">
	<h2 class="title"><?= $this->title ?></h2>
	<div class="content">
		<div class="description">
			<p>Enter the details for your transaction below.</p>
		</div>

		<form action="transactions/create" method="post">
			<div class="formLine">
				<label for="date">Date</label>
				<input type="date" id="date" name="date"/>
			</div>

			<div class="formLine">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="53" rows="6"></textarea>
			</div>

			<div class="formLine">
				<label for="category">Category</label>

				<input type="checkbox" id="categoryEnabled" class="enabler" />

				<select name="category" id="category">
					<?php foreach ($this->categories as $category): ?>
					<option value="<?= $category->get('id') ?>"><?= $category->get('name') ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="formLine">
				<span>Type</span>
				<div class="radioGroup">
					<div class="radioOption">
						<label for="typeIn">Income</label>
						<input type="radio" name="type" id="typeIn" value="in"/>
					</div>
					<div class="radioOption">
						<label for="typeOut">Outgoing</label>
						<input type="radio" name="type" id="typeOut" value="out"/>
					</div>
				</div>
			</div>

			<div class="formLine">
				<label for="amount">Amount</label>
				<input type="number" id="amount" class="currency" name="amount" min="0" step="0.01" value="0"/>
			</div>

			<div class="formLine">
				<label for="thirdParty">Third Party</label>

				<input type="checkbox" id="thirdPartyEnabled" class="enabler" />

				<select name="thirdParty" id="thirdParty">
					<?php foreach ($this->thirdParties as $thirdParty): ?>
					<option value="<?= $thirdParty->get('id') ?>"><?= $thirdParty->get('name') ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="formLine buttons">
				<a href="transactions/view" class="button secondary left">Cancel</a>
				<button type="submit" class="button primary right">Save</button>
			</div>
		</form>
	</div>
</div>

<?php $this->script = <<<'SCRIPT'
$(document).ready(function(){
	var $fadingInputs = $('#amount,#thirdPartyEnabled'),
		$fadingDivs = $fadingInputs.parent(),
		$categorySelector = $('#category'),
		$thirdPartySelector = $('#thirdParty');
	$fadingInputs.attr('disabled', true).trigger("liszt:updated");
	$fadingDivs.addClass('disabled');

	$('#typeIn, #typeOut').one('change', function(e){
		$fadingInputs.attr('disabled', false).trigger("liszt:updated");
		$fadingDivs.removeClass('disabled');
	});

	$('#categoryEnabled').on('change', function(e){
		$categorySelector.attr('disabled', !e.target.checked)
						.trigger("liszt:updated");
	}).trigger('change');

	$('#thirdPartyEnabled').on('change', function(e){
		$thirdPartySelector.attr('disabled', !e.target.checked)
						.trigger("liszt:updated");
	}).trigger('change');
});
SCRIPT;
?>