<!doctype html>
<html lang="<?=$this->lang?>" class="no-js">
<head><meta charset="utf-8"/>
	<title><?php if (isset($this->title)) { echo "{$this->title} -"; }?> Crow Finance</title>
	<base href="<?= $this->base ?>" />
	<?php foreach ($this->styles as $style): ?>
	<?=$style?>
	<?php endforeach; ?>
	<script type="text/javascript" src="js/modernizr-2.0.6.min.js"></script>
</head>
<body>
	<div class="page liquid">
		<header class="head mainHead">
			<?php if ($this->loggedIn): ?>
			<div class="floatRight">
				<span style="padding-right:10px">Logged in as <?=$this->user->getDisplayName()?></span>
				<a class="button" href="dashboard/logout">Logout</a>
			</div>
			<?php endif; ?>
			
			<h1>Crow Finance</h1>
			
			<nav>
				<ul class="navList headerNavList">
					<li>
						<a href="index">Index</a>
					</li>
				<?php if ($this->loggedIn): ?>
					<li>
						<a href="dashboard">Dashboard</a>
					</li>
					<li>
						<a href="transactions/create">Add Transaction</a>
					</li>
					<li>
						<a href="transactions/view/<?=date('Y-m');?>">View Statement</a>
					</li>
					<li>
						<a href="categories">Categories</a>
					</li>
					<li>
						<a href="thirdparties">Third Parties</a>
					</li>
				<?php else: ?>
					<li>
						<a href="login">Login</a>
					</li>
				<?php endif; ?>
				</ul>
			</nav>
				
			<?php // Breadcrumbs ?>
			<?php if (isset($this->breadcrumbs)): ?>
				<ul class="navList breadcrumbs">
					<li><a href="index">Home</a></li>
				<?php foreach ($this->breadcrumbs as $b): ?>
					<li><a href="<?=$b->url;?>"><?=$b->title;?></a></li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</header>
		
		<div rel="main" class="body">
			<div class="main">
			
			<?php if (count($this->messages)): ?>
				<div class="line messages">
				<?php foreach($this->messages as $message): ?>
					<div class="unit size1of1 message message<?=ucfirst($message->type);?>"> <?=$message->msg;?> </div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
			
			<?php /*if (isset($this->title)) {
				echo '<h2 class="contentTitle">', $this->title, '</h2>';
			}*/?>