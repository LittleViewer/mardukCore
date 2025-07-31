**Before Use:**
*Set defaults permission* (please select just sub-directory with your class)
setfacl -R -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)
setfacl -R -d -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)

*active prerequisites*
sudo a2enmod authn_file
sudo a2enmod authz_user
sudo systemctl restart apache2



**Before launch your project for first time**
*protect your sub-directory with your class*
a first user (if reuse overwrites old user)
sudo htpasswd -cb /etc/apache2/mardukCoreClass.htpasswd [username] [password]
for adduser
sudo htpasswd -b /etc/apache2/mardukCoreClass.htpasswd [username] [password]