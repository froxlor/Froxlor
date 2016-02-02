# An unofficial froxlor-fork

The server administration software for your needs.
Developed by experienced server administrators, this panel simplifies the effort of managing your hosting platform.

> The additional features of this fork are developed and tested on Debian only! The config-files under "Server -> Configuration"
> for non-debian distributions (including ubuntu) are from original froxlor upstream. The additional features will not work on this distributions!

## Additional Features

* Terminationdate for domains. 
** orange background color in domainlist (admin/customer) for terminated but not expired domains
** red background color in domainlist (admin/customer) for expired domains

## Installation

1. Ensure that your webserver serves /var/www
2. Clone from GitHub  
> git clone https://github.com/megaspatz/Froxlor.git froxlor  
3. Point your browser to http://[ip-of-webserver]/froxlor
4. Follow the installer
5. Login as administrator
6. Adjust "Server > Settings" according to your needs
7. Choose your distribution under "Server > Configuration"
8. Follow the steps for your services
9. Have fun!

## License

May be found in COPYING
