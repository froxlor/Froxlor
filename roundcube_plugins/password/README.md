# Configuration-file for the password plugin for roundcube

This configuration of the password plugin for roundcube allows froxlor users to change their e-mail password within roundcube.

You only have to edit three values:

```php
$config['password_minimum_length'] = 12; // set to corresponding Froxlor password length value
$config['password_algorithm'] = 'blowfish-crypt';
$config['password_algorithm_prefix'] = '{BLF-CRYPT}';
$config['password_db_dsn'] = 'mysql://froxlor:MYSQL_PASSWORD@localhost/froxlor';
$config['password_query'] = 'UPDATE `mail_users` SET `password_enc` = %P WHERE `username` = %u';
```

Replace `MYSQL_PASSWORD` with the password for the froxlor-database-user.

If you do want plaintext-passwords to be stored in the database, adjust the sql query accordingly:

```php
$config['password_query'] = 'UPDATE `mail_users` SET `password` = %p, `password_enc` = %P WHERE `username` = %u';
```

2009-present, the froxlor team
https://www.froxlor.org/
