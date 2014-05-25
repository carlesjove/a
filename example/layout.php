<!DOCTYPE html>
<html dir="ltr" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width" />
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="/assets/css/example.css">
	</head>
	<body>
		<div class="page">
			<header>
				<h1>
					<a href="/"><?php echo $title; ?></a>
				</h1>
				<nav>
					<ul>
						<li><a href="<?php echo $this->nav('my-page'); ?>">My Page</a></li>
						<li><a href="<?php echo $this->nav('my/subpage'); ?>">My Sub Page</a></li>
						<li><a href="<?php echo $this->nav('list'); ?>">My List</a></li>
						<li><a href="<?php echo $this->nav('a/non-exisiting-page'); ?>">Non Exisiting Page</a></li>
					</ul>
				</nav>

				<ul class="lang-list">
					<li><a href="<?php echo $this->lang('ca'); ?>">Català</a></li>
					<li><a href="<?php echo $this->lang('es'); ?>">Castellano</a></li>
					<li><a href="<?php echo $this->lang('en'); ?>">English</a></li>
				</ul>
			</header>
			
			<main>
			<?php $this->content(); ?>
			</main>
			
			<footer>
				<p><?php echo $colophon; ?></p>
			</footer>
		</div>
	</body>
</html>