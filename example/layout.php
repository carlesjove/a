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
						<li><a href="/my-page">My Page</a></li>
						<li><a href="/my/subpage">My Sub Page</a></li>
						<li><a href="/list">My List</a></li>
						<li><a href="/a/non-exisiting-page">Non Exisiting Page</a></li>
					</ul>
				</nav>
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