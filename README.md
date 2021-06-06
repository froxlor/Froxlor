[![Build Status](https://travis-ci.com/Froxlor/Froxlor.svg?branch=master)](https://travis-ci.com/Froxlor/Froxlor)
[![Gitter](https://badges.gitter.im/Froxlor/community.svg)](https://gitter.im/Froxlor/community?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

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
https://github.com/Froxlor/Froxlor/wiki/Install-froxlor-from-tarball

## Help

You may find help in the following places:

### IRC

froxlor may be found on freenode.net, channel #froxlor:
irc://chat.freenode.net/froxlor

### Forum

The community is located on https://forum.froxlor.org/

### Wiki

More documentation may be found in the froxlor - wiki:
https://github.com/Froxlor/Froxlor/wiki

## License

May be found in COPYING

## Downloads

### Tarball
https://files.froxlor.org/releases/froxlor-latest.tar.gz [MD5](https://files.froxlor.org/releases/froxlor-latest.tar.gz.md5) [SHA1](https://files.froxlor.org/releases/froxlor-latest.tar.gz.sha1)

### Debian repository

[HowTo](https://github.com/Froxlor/Froxlor/wiki/Install-froxlor-on-debian)

```
apt-get -y install apt-transport-https lsb-release ca-certificates
wget -O - https://deb.froxlor.org/froxlor.gpg | apt-key add -
echo "deb https://deb.froxlor.org/debian $(lsb_release -sc) main" > /etc/apt/sources.list.d/froxlor.list
```

### Ubuntu repository

[HowTo](https://github.com/Froxlor/Froxlor/wiki/Install-froxlor-on-ubuntu)

```
apt-get -y install apt-transport-https lsb-release ca-certificates
wget -O - https://deb.froxlor.org/froxlor.gpg | apt-key add -
echo "deb https://deb.froxlor.org/ubuntu $(lsb_release -sc) main" > /etc/apt/sources.list.d/froxlor.list
```

## Contributing

[see here](.github/CONTRIBUTING.md)
