[![Froxlor-CI](https://github.com/Froxlor/Froxlor/actions/workflows/build-mariadb.yml/badge.svg?branch=0.11-dev)](https://github.com/Froxlor/Froxlor/actions/workflows/build-mariadb.yml)
[![Froxlor-CI](https://github.com/Froxlor/Froxlor/actions/workflows/build-mysql.yml/badge.svg?branch=0.11-dev)](https://github.com/Froxlor/Froxlor/actions/workflows/build-mysql.yml)
[![Discord](https://badgen.net/badge/icon/discord?icon=discord&label)](https://discord.froxlor.org)

# Froxlor

The server administration software for your needs.
Developed by experienced server administrators, this panel simplifies the effort of managing your hosting platform.

## Installation

### Fast install
1. Ensure that your webserver serves /var/www
2. Extract froxlor into /var/www
3. Point your browser to http://[ip-of-webserver]/froxlor
4. Follow the installer
5. Login as administrator
6. Adjust "System > Settings" according to your needs
7. Choose your distribution under "System > Configuration"
8. Follow the steps for your services
9. Have fun!

### Detailed installation
https://docs.froxlor.org/latest/general/installation/

## Help

You may find help in the following places:

### Discord

The froxlor community discord server can be found here: https://discord.froxlor.org

### IRC

froxlor may be found on libera.chat, channel #froxlor:
irc://irc.libera.chat/froxlor

### Forum

The community is located on https://forum.froxlor.org/

### Wiki

More documentation may be found in the froxlor - documentation:
https://docs.froxlor.org/

## License

May be found in [COPYING](COPYING)

## Downloads

### Tarball
https://files.froxlor.org/releases/froxlor-latest.tar.gz [MD5](https://files.froxlor.org/releases/froxlor-latest.tar.gz.md5) [SHA1](https://files.froxlor.org/releases/froxlor-latest.tar.gz.sha1)

### Debian / Ubutnu repository

[HowTo](https://docs.froxlor.org/latets/general/installation/apt-package.html)

#### Debian

```
apt-get -y install apt-transport-https lsb-release ca-certificates curl
curl -sSLo /usr/share/keyrings/deb.froxlor.org-froxlor.gpg https://deb.froxlor.org/froxlor.gpg
echo sh -c '"deb [signed-by=/usr/share/keyrings/deb.froxlor.org-froxlor.gpg] https://deb.froxlor.org/debian $(lsb_release -sc) main" > /etc/apt/sources.list.d/froxlor.list'
```

#### Ubuntu

```
apt-get -y install apt-transport-https lsb-release ca-certificates curl
curl -sSLo /usr/share/keyrings/deb.froxlor.org-froxlor.gpg https://deb.froxlor.org/froxlor.gpg
echo sh -c '"deb [signed-by=/usr/share/keyrings/deb.froxlor.org-froxlor.gpg] https://deb.froxlor.org/ubuntu $(lsb_release -sc) main" > /etc/apt/sources.list.d/froxlor.list'
```

## Contributing

[see here](.github/CONTRIBUTING.md)
