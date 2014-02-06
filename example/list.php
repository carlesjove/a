<h1>I'm a list page</h1>
<ul>
	<?php foreach ( $list as $k => $item ): ?>
	<li>
		<a href="/list/<?php echo $k; ?>">
			<?php echo $item['title']; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>