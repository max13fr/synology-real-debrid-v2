# Synology : real-debrid v2 host

A working FileHost for Real-debrid in Synology Download Station.
Inspired by https://github.com/robinwit/synology-realdebrid.

This is a functional, [RealDebrid](http://real-debrid.com) file hosting module for Synology Download Station. It uses the new API of real-debrid that use your private token instead of user/password combinaison.

The existing RealDebrid module isn't working for me, idem for robinwit's module, so I created a new one based on the [official developer guide](https://global.download.synology.com/download/Document/DeveloperGuide/Developer_Guide_to_File_Hosting_Module.pdf) & robinwit's module.

## Installing

Download Station -> Settings -> File Hosting -> Add -> *real_debrid_v2.host*

/!\ This script use the new API of real-debrid that use a private token /!\
* Username : Enter you API token (https://real-debrid.com/apitoken)
* Password : fill with random characters just to avoid errors

Enjoy :)

## Editing

Modify INFO & realdebrid_v2.php as you want then :

```
tar zcf realdebrid_v2.host INFO realdebrid_v2.php
```

And add `realdebrid2.host` as a file hosting module in the Download Station settings.

Then update in Download Station (see Installing)

