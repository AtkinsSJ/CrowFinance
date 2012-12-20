<!doctype html>
<html lang="<?=$this->lang?>" class="no-js">
<head><meta charset="utf-8"/>
	<title><?php if (isset($this->title)) { echo "{$this->title} -"; }?> Crow Finance</title>
	<base href="<?=$this->base?>" />
	<?php foreach ($this->styles as $style): ?>
	<?=$style?>
	<?php endforeach; ?>
	<script type="text/javascript" src="js/modernizr-2.0.6.min.js"></script>
</head>
<body>