Docker Recipes
==============

Contained are a collection of Dockerfiles that we use internally but for whatever reason haven't yet graduated to the public docker registry as fully-fleged packages. We'll add to them as we continue to adapt them internally, and welcome issues and pull requests.

What's Inside
-------------

All images are based on Ubuntu 14.04.

### GitLab CI Runner
These recipes are based on the Dockerfile provided by GitLab for setting up a CI runner on Ubuntu. They are each tailored towards providing base functionality you could add to, or to cover a specific solution.

**Note**: these setups assume that you have an `id_rsa` private key file in the root context that will be copied in as the private key for the runner. This is so you can use just one deploy key among many runners. If this is not the case then you'll need to remove the `COPY id_rsa /root/.ssh/` line.

* **NodeJS**: Ubuntu packages `npm`, `nodejs` and `nodejs-legacy` and their requirements are installed.
* **Grunt/Gulp Themes**: Based on the `NodeJS` dockerfile, this package adds the `grunt`, `grunt-cli` and `gulp` packages via NPM, as well as installing `compass` and `sass` gems, so you can run tests that include building stylesheets.
* **PHP & Composer**: Ubuntu packages `php5-cli` and `php5-mcrypt` have been installed, and `composer` has been installed and added to system path.
* **PHP, Composer & MariaDB**: Based on the `PHP & Composer` dockerfile, this package adds `MariaDB 5.5` from its own repository as well as installing the `php5-mysqlnd` module from the Ubuntu repository. MariaDB server startup is added to the start commands. This allows you to run tests using PHP and MySQL.
* **SilverStripe**: Based on the `PHP, Composer & MariaDB` dockerfile, this package adds an `_ss_environment.php` file that allows tests using the SilverStripe framework to run using the local database.
