<div class="container text-center mt-5 bg-white py-5 rounded">
	<div class="wrap">
		<h1>404 - File Not Found</h1>
		<p>
			<?php if (!empty($message) && $message !== '(null)'): ?>
				<?= esc($message) ?>
			<?php else: ?>
				Sorry! Cannot seem to find the page you were looking for.
			<?php endif ?>
		</p>
	</div>
</div>
