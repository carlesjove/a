<h1><?php echo $title; ?></h1>
<p><?php echo $body; ?></p>
<br>
<p><?php echo $after_body; ?></p>
<ul>
	<?php foreach ( $list as $k => $item ): ?>
	<li>
		<a href="<?php echo $this->nav("list/{$k}"); ?>">
			<?php echo $item['title']; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>