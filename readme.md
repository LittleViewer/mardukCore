**Before Use:**<br>
*set group and owner of file* (depend your context)<br>
chown [your user] /var/www/html/mardukCore/ --recursive <br>
chgrp [your group] /var/www/html/mardukCore/ --recursive <br>
*Set defaults permission* (please select just sub-directory with your class)<br>
setfacl -R -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)<br>
setfacl -R -d -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)<br>

*Set group write for directory of await restrictive directory before launch in apache*<br>
chmod g+w /var/www/html/mardukCore/mardukCore/securityComponement/beforeLaunchProductionVersion/directoryAwaitMove/<br>
setfacl -R -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/mardukCore/securityComponement/beforeLaunchProductionVersion/directoryAwaitMove/<br>
setfacl -R -d -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/mardukCore/securityComponement/beforeLaunchProductionVersion/directoryAwaitMove/<br>


*active prerequisites*<br>
sudo a2enmod authn_file<br>
sudo a2enmod authz_user<br>
sudo systemctl restart apache2<br>



**Before launch your project for first time**<br>
*protect your sub-directory with your class*<br>
a first user (if reuse overwrites old user)<br>
sudo htpasswd -cb /etc/apache2/mardukCoreClassDev.htpasswd [username] [password]<br>
for adduser<br>
sudo htpasswd -b /etc/apache2/mardukCoreClassDev.htpasswd [username] [password]<br>