# WhoKnowsWho project #

## LICENSE INFORMATION ##

The WhoKnowsWho project is Copyright 2009 Channel Four Television Corporation

The source code is released under the GNU General Public License. Details of
this license can be found in the files named COPYING and LICENSE in the root
of this source-code distribution.

In addition, this source may be released under additional (for example
commercial) licenses at the discretion of Channel 4. The release of the
code under another license does not (and cannot) affect this release under
this license.

Some other projects' code are linked to or embedded within the project
structure. These are subject to their own licensing restrictions and the
WhoKnowsWho license does not alter their status in any way. We have
endeavoured to ensure that these packages are accompanied by their original
licenses.





## INSTALLATION ##

You will need to be familiar with:
  * PHP
  * Symfony
  * Doctrine
  * PDO
  * Memcached
  * MySQL
  * Apache (or similar, although you're on your own when it comes to porting the mod\_rewrite rules, sorry)


The following PHP extensions must be installed and enabled
  * PECL memcache (not memcached)
  * PDO and PDO\_mysql
  * cURL

The following PHP extensions are optional but recommended
  * suhosin (caveat: add 'suhosin.server.strip = 0' to your php.ini)
  * PECL stem
  * xcache, apc, eaccelerator, or similar




### 1. Check out a copy of the project ###

```
svn co https://whoknowswho.googlecode.com/svn/ wkw
```

Symfony and all its dependencies (including Doctrine) are configured as externals, so these should all be downloaded at the same time as your main check-out.

### 2. Create the database ###

WKW uses two database connections named `master` and `slave`. This is to allow for master/slave configurations. It's absolutely fine to set up both accounts on the same server if you're just messing around, though.


```
CREATE DATABASE c4foaf_v1 CHARACTER SET utf8;

GRANT all ON c4foaf_v1.* 
TO c4foaf@localhost 
IDENTIFIED BY 'readwrite_password';

GRANT select ON c4foaf_v1.* 
TO c4foaf_read@localhost 
IDENTIFIED BY 'readonly_password';
```

### 3. Configure the database connection ###

Copy `config/databases.yml.dist` to `config/databases.yml` and edit it with your connection details.


### 4. Populate the database ###

You can initialise an empty database from the command-line by running:
```
  ./symfony doctrine:build-db
  ./symfony doctrine:insert-sql
```

There's a small sample data-set you can load by running:

```
  ./symfony doctrine:data-load
```

Bear in mind that if you don't load at least the `00_types.yml` fixture, the app will likely not work out of the box, and you definitely won't be able to log into the admin section.

Have a look in the data/fixtures directory to see the fixture files that are loaded. You can of course edit or delete them, add others, or just ignore them.


### 5. Configure the memcached hosts file ###

Copy `config/hosts-memcached.dist` to `config/hosts-memcached` and then edit it.

Unless you only have one memcached server and it's on the same machine as the application, DON'T use the addresses `localhost` or `127.0.0.1` because you'll confuse memcached.

The hosts file can also contain a path-name to a Scalr/AWS style folder of host names (e.g., `/etc/aws/hosts/caches`), but be aware that because of the way memcached works, if the list changes, the entire cache is invalidated, and you might get a cache stampede, so you'd be better off using a fixed list of servers.

If you don't want to use memcached at all, it should be possible to do without it. Edit the `apps/frontend/config/factories.yml` and `apps/admin/config/factories.yml` to change the view cache and session storage classes to a different one, and then change `config/ProjectConfiguration.class.php` to remove (or replace) the Doctrine Query cache. Several aspects of the site (like the Interest metric, which is based on view counts) use the tuiCacheHandler class to store and retrieve data, so you'll have to replace it with an equivalent.


### 6. Configure API keys and contact email addresses: ###

Edit `apps/frontend/config/app.yml` and add your ReCAPTCHA public and private keys. You can skip this requirement by modifying the forms that embed ReCAPTCHA.
There's also a TheyWorkForYou API key, but you only need this if you plan to run the TWFYPlugin tasks to import MPs, Lords, etc.


### 7. Check file/folder permissions ###

```
  ./symfony project:permissions
```

### 8. Set up your scheduled tasks. ###

The tasks in the `maintenance:` namespace of the symfony command line tool should be run periodically. Example crontab entries can be found in the `/doc` folder.


### 9. Configure your web server ###

Create a vhost (or change the default site) and set the DocumentRoot to the web/ folder of your working copy. DO NOT point it at the root of your working copy, or you'll expose all the application, configuration, log and cache files.

Also ensure that `mod_rewrite` is loaded.

### 10. Reload Apache and check out your app. ###



---


## TIPS: ##
  * Use the Symfony optimize task on your production installation:
> `      ./symfony project:optimize frontend prod `

  * Don't deploy with admin\_dev.php and frontend\_dev.php delete them or use:
> `      ./symfony project:clear-controllers `

> You may also want to disable the admin interface entirely:
> `      ./symfony project:disable admin `

  * The caching is fairly aggressive. During development, use `frontend_dev.php` and `admin_dev.php` which both have caching disabled. Alternatively, turn off the cache in the application settings.yml (but you should still use the `_dev` controllers because they will display errors and the debug bar).


---


## FAQ ##

Q:  Why are some things (esp classes) prefixed with foaf, c4foaf or tui?
A: The codename of the project was FOAF, the client was Channel 4, and the original developers are [Tui Interactive Media](http://www.tui.co.uk).

Q:  Why Subversion and not Mercurial/Git?
A: We may move to Mercurial in the future, but it doesn't have anything like svn:externals at the moment, and it feels a bit odd to be mixing two VCSes.

Q:  Can I submit changes?
A: That'd be lovely. You don't have to share your changes with us directly, but since the code is released under the GPL, you must release any modifications you make under the same licence. This does not apply to configuration files or plugins, of course, since they don't modify the project source. Changes to Symfony or any other project used by WKW are covered by their own licences.

Q:  Why only MySQL
A:  We haven't tried it on anything else. You may find it works just fine, but it's probably not that simple.