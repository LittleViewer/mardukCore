Before Use:
*Set defaults permission*
setfacl -R -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)
setfacl -R -d -m u::rwx,g::rwx,o::--- /var/www/html/mardukCore/[youre dir with futur class] (advice:devForUserFold)