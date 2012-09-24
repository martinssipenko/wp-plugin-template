WordPress Plugin Template for CI
===========
This plugin can be used to start developing a new WordPress plugin.
It has folder structure and build scipts included to support continious integration for plugin development.

Tool Setup
===========
First install required tools:

    sudo apt-get install git svn git-svn ant mysql-server-5.5

Setup git user preferences for system:

    sudo git config --system user.name "John Doe"
    sudo git config --system user.email john.doe@exmple.com

Install PHP and some of it's modules

    sudo apt-get install php5-cli php-pear php5-xsl php5-xdebug

Set PEAR to autodiscover and install PEAR packages needed for CI

    sudo pear config-set auto_discover 1
    sudo pear install pear.phpqatools.org/phpqatools PHPDocumentor
    sudo pear install pear.netpirates.net/phpDox-0.4.0

Also we will need WordPress coding standart sniffs

    sudo git clone git://github.com/mrchrisadams/WordPress-Coding-Standards.git $(pear config-get php_dir)/PHP/CodeSniffer/Standards/WordPress

Jenkins Setup
=============
Add Jenkins repo key to you system

    wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -

Add following to your `/etc/apt/sources.list` file

    #Jenkins APT repository
    deb http://pkg.jenkins-ci.org/debian binary/

Update APT and install Jenkins

    sudo apt-get update
    sudo apt-get install jenkins

In some cases `ant` gives error that it can't load some file, this is what helped

    sudo apt-get remove openjdk-6-*

`cd` to your home directory and download jenkins cli

    cd ~
    wget http://localhost:8080/jnlpJars/jenkins-cli.jar

Install Jenkins plugins and restart jenkins

    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin checkstyle
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin cloverphp
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin dry
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin htmlpublisher
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin jdepend
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin plot
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin pmd
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin violations
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin git
    java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin greenballs
    
    java -jar jenkins-cli.jar -s http://localhost:8080 safe-restart

Now lets download a Jenkins template for WP Plugin development into jenkins jobs dir and reload Jenkins configuration

    
    cd /var/lib/jenkins/jobs
    sudo git clone https://github.com/martinssipenko/php-jenkins-template.git wp-plugin-template
    sudo chown -R jenkins:nogroup wp-plugin-template/
    
    cd ~
    java -jar jenkins-cli.jar -s http://localhost:8080 reload-configuration

WordPress Unit Test Framework Setup
===================================
Create a `/src` directory for if you don't already have it

    sudo mkdir /src

Clone WP Unit Test FW from it's offical SVN repo

    sudo svn co http://unit-test.svn.wordpress.org/trunk/ /src/wp_unit

Create a MySQL databse for unit testing, never use existing db, you will loose all data

    mysql -u root -p -e "DROP DATABASE wp_unit; CREATE DATABASE wp_unit;"

Configure WP Test Suite

    cd /src/wp_unit
    sudo cp wp-tests-config-sample.php wp-tests-config.php
_Then edit wp-tests-config.php to connect to your database._

Create your plugin
=================
Create a folder for your plugin and copy all files except `README.md` into your new plugin dir. Run `git init` to initialize repo for your plugin. Now create a new github repository and push you new plugin to it. You can use any versioning you wan't here but I preffer git & github.

    git clone https://github.com/martinssipenko/wp-plugin-template.git /path/to/wordpress/wp-conetnt/plugins/wp-plugin-template

`cd` to your plugin dir and run `phpunit`

    cd /path/to/wordpres/wp-conetnt/plugins/wp-plugin-template
    phpunit --configuration build/phpunit.xml

Create a new Jenkins job from template
======================================

Open Jenkins in your browser `http://localhost:8080` click in `New Job`, type a name for your job and select `Copy existing Job` and in `Copy from` type `wp-plugin-template`. Uncheck the `Disable Build` checkbox. In `Source Code Management` section choose your versioning system and fill required fields. In `Build Triggers` section choose `Poll SCM`. Click `Save` at the bottom of page. Now you can try to build you plugin, by clicking `Build Now`.

Further reading
===============
- http://jenkins-php.org/
- http://www.phpunit.de/manual/current/en/index.html
- http://shop.oreilly.com/product/0636920021353.do
- http://stackoverflow.com/questions/9138215/unit-testing-wordpress-plugins
- http://wp.tutsplus.com/tutorials/creative-coding/the-beginners-guide-to-unit-testing-building-a-testable-plugin/

Links
=====
- http://jenkins-ci.org/
- http://unit-tests.trac.wordpress.org/