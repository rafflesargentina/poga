#!/bin/bash

/usr/bin/find ./storage -type d -exec chmod 775 {} \;
/usr/bin/find ./storage -type f -exec chmod 664 {} \;
/usr/bin/find ./bootstrap/cache -type d -exec chmod 775 {} \;
/usr/bin/find ./bootstrap/cache -type f -exec chmod 664 {} \;

setfacl -m user:poga:rwx ./storage/logs
