# A
**A** is a PHP microframework based on file naming, for those times you want to keep things simple. Just name a file `like_this.php` and you'll get a working route `http://example.com/like/this`. No database, no configuration files, no nothing. And it's ready for multilingual sites.

## Overview
**A** is meant for simple sites that do not require database or complex architectures, but still want to have clean URLs and stuff as organized as possible. 

#### Features
- Clean URLs based on file naming
- Simple layout system
- Separation of data and presentation
- 404 (Not Found) template for non-existent routes
- Custom functions
- Multilingual sites

#### Requirements
- PHP 5 or later
- PHP server running Appache

## Usage
**A** works out of the box, no configuration needed. Download the files and start building your site.

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
					<li><a href="<?php echo $this->nav('my-page'); ?>">My Page</a></li>
					<li><a href="<?php echo $this->nav('my-sub-page'); ?>">My Sub Page</a></li>
				</ul>
			</nav>

			<!-- This site is multilingual, so here go the languages -->
			<ul class="lang-list">
				<li><a href="<?php echo $this->lang('ca'); ?>">Català</a></li>
				<li><a href="<?php echo $this->lang('es'); ?>">Castellano</a></li>
				<li><a href="<?php echo $this->lang('en'); ?>">English</a></li>
			</ul>
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
**A** encourages you to keep data and presentation separated. This is particullary interesting in pages with longs lists or large pieces of text.

Within the `data` directory you'll find a file called `global.php` where you can write site wide variables. You can also create individual files that will be only loaded on page request, by simply naming them the same as the page file. So if you have a page named `about.php` **A** will look for a `data/about.php` file and load it. If your page is `very_long_route.php`, then the data for it will be in `data/very_long_route.php`.

#### Lists and single item pages
**A** allows to create individual item pages from a list using a single template, just like in MVC frameworks and most CMS. 

Imagine you have a page called `posts.php` that lists all your posts. You can now create another file called `posts_[id].php` which will be used as the template for individual posts. You need to have the array of posts in `data/posts.php` and name it `$list`, where each array's `key` is the url you want for the post. **A** will load the post data in the `$item` variable. Example:

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

#### Multilingual sites
If you want your sites to support multiple languages, it's really easy. You just need to create a `langs` directory within the `data` directory, and there creating a directory for every language you want to support. And example would be:

```
data/langs/ca
data/langs/es
data/langs/en
```

Now in each language directory, you can create your data files as usual, following the naming pattern, so `my_page.php` will look at `data/langs/[current language]/my_page.php`.

One important thing to know is: **A** won't use translations instead of other data, it will just override it. That means that if your current language is `fr` and your current page is `my_page.php`, **A** will get data first from `data/my_page.php` and then from `data/langs/fr/my_page.php`. This is a convenient way to keep things DRY when a given text doesn't need translation.

If you're creating a multilingual site, you'd really want to use the helper methods `nav()` and `lang()` to preserve routes accross languages.

```
<!-- Make sure current language will be on the navigation links or in lists' links, using nav() -->
<a href="<?php echo $this->nav('my-page'); ?>">My Page</a>

<?php foreach ( $list as $k => $item ): ?>
<li>
	<a href="<?php echo $this->nav("list/{$k}"); ?>">
		<?php echo $item['title']; ?>
	</a>
</li>
<?php endforeach; ?>

<!-- Make sure you will stay on the same page when switching languages, using lang() -->
<a href="<?php echo $this->lang('es'); ?>">Castellano</a>
```

#### Custom functions

Sometimes you want to do things, and you wrap them in functions. You can put them in a file named `functions.php`, and it will be included.

## Changelog
== 0.6 ==
- Code improvements

== 0.5 ==
- Fixes routes being broken because of ending trailing slashes

== 0.4 ==
- Added support for multilingual sites

== 0.3 ==
- Generate .htaccess automatically

== 0.2 ==
- Adds support for `list/:id` items

## License
Do whatever the fuck you want with this code. Really. 
