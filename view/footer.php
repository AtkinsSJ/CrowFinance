			</div>
		</div>

		<footer class="foot mainFoot">
			<div class="line">
				<small class="unit copyright">
					&copy; Copyright Samuel Atkins 2012
				</small>
				
				<nav class="unit lastUnit">
					<ul class="navList footerNavList">
						<li>
							<a href="help">Help</a>
						</li>
						<li>
							<a href="about">About</a>
						</li>
					</ul>
				</nav>
			</div>
		</footer>
	</div>
	
	<script type="text/javascript" src="js/jquery-1.7.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.min.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php // Page-specific JS files
	foreach ($this->js as $js):?>
		<script type="text/javascript" src="<?=$js;?>"></script>
	<?php endforeach; ?>
	
	<?php // Page-specific inline JS
	if (isset($this->script)): ?>
	<script type="text/javascript" defer>
		<?=$this->script;?>
	</script>
	<?php endif; ?>
	
</body>
</html>