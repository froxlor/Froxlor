# Contributing

Before you start working on a PR, contact us via IRC in #froxlor on Freenode or
the forum at https://forum.froxlor.org to get a clue whether someone else isn't
already working on it or if we don not want/need this certain change.
Of course, bugfixes are always welcome.
However, at this stage of the 0.9.x branch, we are not looking for new
features or refactoring, especially not the kind which requires changes to a
lot of files.
Please focus on our API based version 0.10.x (current master).




## Checklist

General rules for PRs are:
* Please save us all some trouble and unnecessary round-trips by _testing_ your
changes.

* Re-write your commit history to provide a CLEAN history!

	* i.e. do not provide PRs which contain a commit that changes something,
	the next changes it back, a third one changes it again, only a little
	differently...


Thanks!




### Webserver changes
If you make changes to the functionality of webserver configuration, please
make sure your implementation covers all supported webservers.




### l10n

If you add new language strings, please make sure you add the english fallback
strings in

* `lng/english.lng.php`
* `install/lng/english.lng.php` (if applicable)




### New settings and database-layout changnes
If you add new settings or layout changes, please make sure you add these to

* `install/froxlor.sql`
* and handle the update (see `install/updates/froxlor/0.10/update_0.10.inc.php`)
* if you have any question on how update-process works, please contact us

