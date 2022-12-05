# Contribution

Before you start working on a PR, contact us via [Discord](https://discord.froxlor.org) or the forum at [https://forum.froxlor.org](https://forum.froxlor.org) to get a clue whether someone else isn't already working on it or if we don not want/need this certain change. Of course, bugfixes are always welcome.

Please always focus on the **main** branch of our [Github repository](https://github.com/Froxlor/Froxlor).

## Checklist

General rules for PRs are:

* Please save us all some trouble and unnecessary round-trips by _testing_ your changes.
* Re-write your commit history to provide a CLEAN history!
    * i.e. do not provide PRs which contain a commit that changes something, the next changes it back, a third one changes it again, only a little differently...

Thanks!

### Service changes

If you make changes to the functionality of service configurations, please make sure your implementation covers all supported services and distributions.

### l10n

If you add new language strings, please make sure you add the english fallback strings in `lng/en.php`.

### New settings and database-layout changes

If you add new settings or implement database-changes, please make sure you add these to

* `install/froxlor.sql.php`
* handle the update (see [`install/updates/froxlor/update_2.x.inc.php`](https://github.com/Froxlor/Froxlor/blob/main/install/updates/froxlor/update_2.x.inc.php))
* if you have any question on how update-process works, please contact us
