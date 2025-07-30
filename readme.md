Before Use:<br>
*Set defaults permission*
setfacl -R -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)<br>
setfacl -R -d -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)<br>
