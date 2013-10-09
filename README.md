# WordPress boilerplate

This is a repo where i collect WordPress best-practices, and try to make managing a WordPress site under git less of a hassle.

## Setup

**WARNING: This has not yet been tested. If someone actually use this I'd appreciate any help with keeping the readme correct/helpful or suggestions of better ways of doing things.**

1.  Clone this repository

        # Download this repo along with WordPress
        git clone --recursive git@github.com:alcesleo/wordpress-boilerplate.git

        # Forgot to add the --recursive flag? No problem!
        git submodule init
        git submodule update


2. Swap out the origin of the project to your own

        # Change into the repo
        cd wordpress-boilerplate

        # Remove origin
        git remote rm origin

        # Add your own origin
        git remote add origin <url_from_your_repo>

3.  Check out the version of WordPress you want.

        cd wordpress
        git fetch --tags
        git checkout 3.6

4.  Commit the submodule state in the parent repo

        cd ..
        git add wordpress
        git commit -m 'Checked out version 3.6 of WordPress'

5. Create a `local-config.php` with the contents of this [gist](https://gist.github.com/alcesleo/6319370) in the `www/`-directory to set up your credentials.

6. Start working on your site! Don't forget to replace this readme with your own.

### Very advanced optional step

If you do not want the commit history of this repository in your own, you can
rebase the entire repo into a single commit. This is very nice to do since
you get a clean initial installation of this boilerplate, but none of its history
(that is in no way related to your project anyway). It does however require some
git skills.

    # This only works in newer versions of git
    git rebase --root -i

This will open your default editor with a list of commits with the word *pick* before them.
Change every instance of the word *pick* to say *squash* instead. **Except for the first one, Initial commit**. Then save and exit.

Git will then open your editor again with a list of all commit-messages. This time, replace
the whole list with simply 'Initial commit'. Save and exit.

Git will now rebase the entire repo into one commit. If you run `git log` you will see
that only the 'Initial commit' shows up, but every file is still in place.


### Versioning the database

**NOTE: `mysqldump` needs to be in your path for this to work.** If you are using MAMP that is not the case by default.

You can either add a symlink in your local bin:

    ln -s /Applications/MAMP/Library/bin /usr/local/bin

Or simply add it to your path.

#### The manual way

1. Run `scripts/backupdb.sh` to save the database as a text file and stage it.
2. `git commit` it.

I tend to use this way, since I have more control and not just dumping WordPress settings
I don't even know I've changed alongside with code-changes. But many people seem to like
having a snapshot of the database tied to every commit.

#### The automatic way (with hooks)

Here, we use git-hooks to run the script every time we do a commit.

Symlink the script to the hooks-directory

    ln -s scripts/backupdb.sh .git/hooks/pre-commit

Mark it as executable

    chmod +x .git/hooks/pre-commit

## Managing the submodule

### Updating / downgrading WordPress:

    cd wordpress
    git checkout 3.5.1
    cd ..
    git add wordpress
    git commit -m "Checked out WordPress to 3.5.1"
    git push

Then you need to visit the sites admin and update the database (this is a matter of clicking ok, and you're done).

Another developer who wants to have WordPress changed to that tag, does this:

    git pull
    git submodule update

`git pull` changes which commit their submodule directory points to. `git submodule update` actually merges in the new code.

## Deployment

There is quite a lot to think about when deploying a WordPress site. In short, you need to:

1. **Upload the files to your hosting server.** You can do this manually (with something like FileZilla), or you can use an automated tool like git-ftp, or if you're really serious, and have SSH-access - Capistrano.

2. **Restore the database.** Use phpMyAdmin or plain MySQL commands to restore the `database.sql`-file to your live server.

3. **Update the links.** Easiest way is `searchreplacedb2.php`, but can be done with MySQL-commands as well.



### Using [git-ftp](https://github.com/git-ftp/git-ftp)

1.  Install it:

        brew install git-ftp

2. Configure it:

        git config git-ftp.user username
        git config git-ftp.url ftp.example.com
        git config git-ftp.password longSecurePassword

        # This makes git-ftp only upload files inside the www-directory.
        # Anything above that will not be uploaded to your server,
        # even if it is tracked by git.
        git config git-ftp.syncroot www/

3. Upload the files in **one** of the following ways:

    Since the `uploads`-folder, `searchreplacedb2.php` etc should not be under git, you need to upload them separately.

    + Using git-ftp to begin with:

            # this uploads all files tracked by git
            git ftp init

        Then upload anything else that's ignored afterwards.

    + Doing an initial manual upload:

        1. Upload everything manually, with something like FileZilla.
        2. Run this:

                git ftp catchup

            This tells git-ftp that you know what you're doing,
            and you're sure that what you've uploaded exactly matches what's in your
            repository.


4. You're all set! Now, pushing your changes to the server is as simple as:

        git ftp push

A bit of a setup-phase, and it can be a little tinkery with setting the syncroot etc. But `git ftp push` is fantastic and it is totally worth it.

### Using [searchreplacedb2.php](http://interconnectit.com/products/search-and-replace-for-wordpress-databases/)

WordPress stores a lot of links in the database including your domain. If you've been developing locally there's probably a bunch of links like <http://localhost:8888/somestuff> that needs to change to <http://www.yourdomain.com/somestuff>.

This is exactly what this tool does. Upload it to you webroot, go to that address and follow the steps to do a search and replace.

**Don't forget to remove the file when you're done.**

## Troubleshooting

This is things I've figured out about WordPress in general, not just about this repository.

+ If your links stop working when you move the site, turn off and turn on permalinks.
+ Custom Post Types also need a re-save of the permalink-structure to work.
+ Really most of 404-problems can be solved with re-saving the permalink-structure.
+ Can't change the page-slug, getting something like "page-2"? Empty the trash!

## Tips

+ These plugins are really worth checking out:
    + Contact Form 7
    + Adminimize
    + Clean Options
    + Widget Logic
    + Better Delete Revision - In case you didn't disable them from the start


## TODO


+ add db-backup-folder?
+ wp-content
    + templates?
        + plugin
        + child theme
+ wp-config
    + local-config
