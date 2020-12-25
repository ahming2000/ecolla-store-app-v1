# Ecolla Product Listing Website (Without payment API or function)

## Description

A product listing and ordering website which designed for Ecolla Enterprise.

This project will use MVC concept to design a dynamic enviroment for the client.

### Version of the component used

Wamp64 is recommended for this project in debugging and testing.
Component used for this project:
- PHP: 7.4.x
  - Imagick 3.4.4 (Native php extension)
- MySQL: 5.7.x

### Things to download
- wamp64: https://sourceforge.net/projects/wampserver/
- ImageMagick: http://www.imagemagick.org/script/download.php
- Imagick PHP extension dll: https://pecl.php.net/package/imagick/3.4.4/windows
  
### Instruction on installation
1. Wamp64
  - Make sure you have installed PHP and MySQL version as the number listed above.
  - Recommend to install in `c:\wamp64\`
2. ImageMagick Extension
  - Make sure you have check x64 or x86 and thread safe enable or disable from phpinfo() (example shown below)
  - Recommend to install the ImageMagick in `c:\imagemagick\`
  - Make sure "Add application directory to your system path" option is ticked while installing the program
  - After ImageMagick installation, copy all files from `C:\imagemagick\modules\coders` and `C:\imagemagick\modules\filters` to `C:\imagemagick` to load ImageMagick supported formats
  - Go to Control Panel -> System -> Advanced Settings -> Environment Variables -> New System Variable -> MAGICK_HOME = `C:\imagemagick`
  - Download the correct version (x64 or x86 and thread safe enable or disable) for extension dll
  - Copy php_imagick.dll to `C:\wamp\bin\php\{selected php version}\ext\`
  - Copy all dll files (*.dll) to `C:\wamp\bin\apache\{selected apache version}\bin\`
  - Edit `php.ini` by left clicking wamp64 icon and choose php, `php.ini` to promt out the editor
  - Add `extension=php_imagick.dll` line in extensions section
3. MySQL Setup
  - Edit `my.ini` by left clicking wamp64 icon and choose MySQL, `my.ini` to promt out the editor
  - Make sure `my.ini` file content element ```character-set-server=utf8``` below ```[mysqld]``` tag to make sure MySQL is running with `utf-8` natively
  - Logon to `phpmyadmin` with `root` and password as blank. Make sure to create the the database named `ecolladb` before importing the database from `assets/database-backup/ecolladb.sql`

### phpinfo() on getPHPInfo.php
```html
<?php
    phpinfo();
?>
```
### Admin login page
You may login to the admin page with username `ahming` and password `Ksm10072000`

### Resource
This project also used:
- gd


## Reference

Coming soon
