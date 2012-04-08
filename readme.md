# Iceberg

Iceberg is a static file blogging platform, built around **Markdown**. It runs on PHP 5.3+, and unlike many other alternatives, it doesn't require any external libraries or dependencies. It's as simple download, run the script, and you've got yourself a static blog.

Iceberg is still in active development, so using at this time is not recommended and bugs are to be expected in all versions to come. Iceberg is being developed by **Cyril Mengin** (Twitter: [@cyrilmengin](http://twitter.com/cyrilmengin)) as well as various other contributors.

Installing
----------

Installing Iceberg is very simple, as it doesn't require any specific libraries or extensions, other than the ones that are already installed. Git can be nice to have, but is not required. To install Iceberg, just navigate to wherever you want to install Iceberg, and run the following inside a terminal:

    $ git clone git://github.com/cyrilmengin/iceberg.git TestBlog
    $ cd TestBlog

And, that's it! You should be able to go straight into blogging at this stage, but you might want to mess around with the settings to change the output / source directory first, as well as get a proper layout/ theme.

Getting Started
---------------

So, you've installed Iceberg. That wasn't too hard, but what now? Well, you'll want to create a new post of course!
To do this you will need to create a new directory in your data folder. Note that the directory's name will represent the URL of the post.

    $ cd _data
    $ mkdir this-is-my-new-post			# This will later become http://your.blog/articles/this-is-my-new-post

Inside that, you'll want to create your markdown file, as well as an assets folder if you're going to be using images in your post. This can be done in any file browser or editor. Careful, as the name of your markdown file should be the same as the parent directory:

    $ cd this-is-my-new-post
    $ touch this-is-my-new-post.md
    $ mkdir assets

Okay, so that's all the files you'll need to create. If you're using images, stick them all inside the assets directory -- it will later be copied alongside your article. Now, last little bit before you can actually write your post, front-matter! This is just some information that should be placed at the top of the markdown file, in the following format:

    -----
    title: This is my new post!
    author: Cyril Mengin
    layout: post
    -----

And that's it! You can now write your article underneath that. Once you've finished writing, you're ready to generate the static files. Go back to the root of the iceberg install, and type this:

    $ ./iceberg generate this-is-my-new-post
    -> this-is-my-new-post successfully generated at output/articles/this-is-my-new-post/index.html
    
Your new article should now be awaiting you in the output dir!

Writing Hooks
-------------

Iceberg has a hook feature, similar to git. Basically, hooks are scripts that will be run at specific moments during the execution of a command.
Iceberg currently has the following hooks:

+ **preGenerate:** this hook is run before any compiling of posts is done. It will be done for each individual file if the ``--all`` parameter is used.
+ **postGenerate:** this hook is run after any compiling of posts is done. It will be done for each individual file if the ``--all`` parameter is used.

*Iceberg currently only supports shell-script based hooks. Pure PHP hooks are in the works*

To create a hook, simply create a file in the ``lib/hook`` dir, and put the corresponding code inside. The name of the hook *file* should be ucfirst, and have "Hook" appended to it.
For example:
	
	lib/hook/PreGenerateHook.php
	
	<?php
	
	namespace hook;
	
	use iceberg\hook\AbstractShellHook;
	
	class PostGenerateHook extends AbstractShellHook {
	
		protected static $path = "";
		
		// The command you want to run
		protected static $command = "mkdir example";
		
		public static function prepare() {
			// Anything that should be run before the actual shell hook is run.
			// In this case, we're setting the path where the shell hook should be run.
			// I'm too lazy to try and figure out the relative path, so why not make it absolute?
			static::$path = ROOT_DIR."output";
		}
	
	}

Thanks & Credits
----------------

**[Michel Fortin](https://github.com/michelf)** for php-markdown, used to  parse Markdown

The **[SPYC Project](http://code.google.com/p/spyc/)** used for parsing YAML

License
-------

Iceberg is licensed under the [WTFPL](http://sam.zoy.org/wtfpl/COPYING) license, so go wild, do what you want.

However, this is not the case of external libraries used in Iceberg, so please see the licenses of PHP-Markdown and SPYC which are located at the top / bottom of the files used.