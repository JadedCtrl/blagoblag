===============================================================================
BLAGOBLAG                                          Simple blogsphere-ish system
===============================================================================

Blagoblag is a pretty simple system that'd be perfectly at home in the
blogosphere.[1]

TL;DR, registered users can create date-stamped posts. Someone can browse
posts by date (from all users) in a format resembling a “newsletter,” or
by user.
Users can create comments on any post after filling out a simple CAPTCHA.

Y'know, stuff along those lines.

[1] https://xkcd.com/181/



----------------------------------------
PRE-REQUISITES
----------------------------------------
	* PHP 7.0
	* Webserver with CGI enabled
	* A paper-clip and soldering-iron
	* Also a lighter



----------------------------------------
INSTALLATION
----------------------------------------
Drop Blagoblag in any directory on your webserver, then create an SQL
database for Blagoblag. Make sure to make a "config.ini" file (from 
"config.ini.example")-- at the minimum, you need to configure the SQL
connection settings.



----------------------------------------
BORING STUFF
----------------------------------------
License is AGPLv3, copyleft.
TL;DR, do whatever, but share the source-code. :)
