Circle CI

[![CircleCI](https://circleci.com/gh/slistrom/bth-ram-proj.svg?style=svg)](https://circleci.com/gh/slistrom/bth-ram-proj)

Scrutinizer badges

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/slistrom/bth-ram-proj/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/slistrom/bth-ram-proj/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/slistrom/bth-ram-proj/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/slistrom/bth-ram-proj/?branch=main)

This is a repository for the content produced in the final project in the course ramverk1 at Blekinge Tekniska Högskola.
The site is build on the Anax framework and has a forum functionality. The site features simple user functionalities such as registering a user, login in and updating information about the user.

The basic functionality of the forum allows users to post questions that can then have several answers. Each question can have one or more tags so that questions can be found based on similar topics. Both questions and answers to questions can be commented on by users.

## Installation
To install this respository and get your own forum simply clone this repository into a space where you have a webserver running that can handle PHP.
Once that is done you have to run "make install" in the root folder of the repository.

The user and forum functionality requires a sqlite3 database to be created under the /data directory. To get the forum to work "out of the box" you have to name the database db.sqlite. Under the /sql/ddl directory there are two sql files (forum.sql and user.sql) that you need to import into the sqlite database to create all the needed tables.

Once above is done your forum should work as it is. 

## Framework
Check out the [Anax](https://github.com/canax) repository if you want to change or extend the forum by modifying the framework it is built on. 