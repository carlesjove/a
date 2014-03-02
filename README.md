# A
A minimal PHP router based on file naming, for those times you want to keep things simple. Just name a file `like_this.php` and you'll get a route `http://example.com/like/this`. No database, no configuration files, no nothing.

## Overview
**A** is meant for simple sites that do not require database or complex architectures, but still want to have clean URLs and things as organized as possible. 

#### Features
- Clean URLs based on file naming
- Simple layout system
- Separation of data and presentation to keep things clean
- 404 (Not Found) template for non-existent routes

#### Requirements
- PHP 5 or later
- PHP server running Appache

## Usage
**A** works out of the box with no need of configuration. Download the files and start building your site.

#### URIs and file naming
Imagine you want `this/cool/uri` in your site. For it to work, you just need to create a file named `this_cool_uri.php`, and you're done. You probably want a home page for your site, so create a file named `home.php`, and there you go.

#### Layout
If you create a file named `layout.php` **A** will use it as a wrapper for all pages, and thus you can save some time and keep things cleaner. You just need to include `<?php $this->content(); ?>` where you want each page content displayed. Here's an example:

```
<!DOCTYPE html>
<html dir="ltr" lang="en">
	<head>
		<meta charset="utf-8">
		<title>My Site</title>
		<link rel="stylesheet" type="text/css" href="/assets/css/example.css">
	</head>
	<body>
		<header>
			<h1>My Site</h1>
			<nav>
				<ul>
					<li><a href="/my-page">My Page</a></li>
					<li><a href="/my/subpage">My Sub Page</a></li>
				</ul>
			</nav>
		</header>
		
		<main>
		<!-- Here we load each page's content -->
		<?php $this->content(); ?>
		</main>
		
		<footer>
			<p>What a footer!</p>
		</footer>
	</body>
</html>
```

#### Data
**A** encourages you to keep data and presentation separated. This is particullary interesting in pages with listings or long pieces of text.

Within the `data` directory you'll find a file called `global.php` where you can write page wide variables. You can also create individual files named that will be only loaded on request, just by namig them the same as the page file. So if you have a page named `about.php` **A** will look for a `data/bio.php` file and load it. If your page is `very_long_route.php`, then the data for it will be in `data/very_long_route.php`.

#### Lists and single item pages
**A** allows to create individual item pages from a list using a single template, just like in MVC frameworks and most CMS. 

Imagine you have a page called `posts.php` that lists all your posts. You can now create another file called `posts_[id].php` which will be used as the template for individual posts. You need to have the array of posts in `data/posts.php` and name it `$list`, where each array `key` is the url you want for the post. **A** will load the post data in the `$item` variable. Example:

```
// data/posts.php
// The array must be named $list
$list = array(
	'first-post' => array(
		'title' => 'My first post',
		'body'	=> 'A very long post'
	),
	'second-post' => array(
		'title' => 'My second post',
		'body'	=> 'A very long post'
	)
);

// posts_[id].php
// We get the post data in $item
<h1><?php echo $item['title']; ?></h1>
<?php echo $item['body']; ?>
```

## Changelog
== 0.3 ==
- Generate .htaccess automatically

== 0.2 ==
- Adds support for `list/:id` items

## Roadmap
- Add support for multilingual sites (which basically means finding a way to route en_home.php as home.php)
- Add support for multiple layouts

## License
Do whatever the fuck you want with this code. Really. 
