# Contributing

Before you start working on a PR, contact us via IRC in #froxlor on Freenode or
the forum at https://forum.froxlor.org to get a clue whether someone else isn't
already working on it or if we don't want to invest the effort in favour of
working on Froxlor 2.0.
Of course, bug fixes are always welcome.
However, at this stage of the 0.9.x branch, we are not looking for new
features or refactoring, especially not the kind which requires changes to a
lot of files.
Currently, we are working on a complete re-write, which, at this point in
time, is not yet public to keep delays due to discussions about internal
details to a minimum.




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
make sure your implementation covers both apache **and** nginx.




### l10n

If you add new language strings, please make sure you add the english fallback
strings in

* `lng/english.lng.php`
* `install/lng/english.lng.php` (if applicable)




### New settings
If you add new settings, please make sure you add the default values to

* `install/froxlor.sql`
* handle the update (see `install/updates/froxlor/0.9/update_0.9.inc.php`)
