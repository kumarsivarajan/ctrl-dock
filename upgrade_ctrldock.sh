#!/bin/bash

# Unpack the files
echo "Unpacking the files.."
cp -rf ctrl-dock/ temp/

# Copy configuration files
echo "Copying Configuration Files.."
cp -rf -p $1/include/config.php temp/include/config.php
cp -rf -p $1/include/config_ldap.php temp/include/config_ldap.php
cp -rf -p $1/include/config_sms.php temp/include/config_sms.php

# Copy System Data
echo "Copying System Data.."
cp -rf -p $1/documents/files/*  temp/documents/files/
cp -rf -p $1/images/logo.png temp/images/logo.png
cp -rf -p $1/eztickets/attachments/* temp/eztickets/attachments/
cp -rf -p $1/broadcast/attachments/* temp/broadcast/attachments/
cp -rf -p $1/backup/* temp/backup/

# Update the Database
echo "Upgrade the Database"
line=$(grep "DATABASE_NAME" $1/include/config.php)
DBNAME=${line#*=}
DBNAME=$(echo ${DBNAME%\;})
DBNAME=$(echo ${DBNAME%\"})
DBNAME=$(echo ${DBNAME#?})

line=$(grep "DATABASE_SERVER" $1/include/config.php)
DBSERVER=${line#*=}
DBSERVER=$(echo ${DBSERVER%\;})
DBSERVER=$(echo ${DBSERVER%\"})
DBSERVER=$(echo ${DBSERVER#?})

line=$(grep "DATABASE_PORT" $1/include/config.php)
DBPORT=${line#*=}
DBPORT=$(echo ${DBPORT%\;})
DBPORT=$(echo ${DBPORT%\"})
DBPORT=$(echo ${DBPORT#?})

line=$(grep "DATABASE_USERNAME" $1/include/config.php)
DBUSER=${line#*=}
DBUSER=$(echo ${DBUSER%\;})
DBUSER=$(echo ${DBUSER%\"})
DBUSER=$(echo ${DBUSER#?})

line=$(grep "DATABASE_PASSWORD" $1/include/config.php)
DBPASS=${line#*=}
DBPASS=$(echo ${DBPASS%\;})
DBPASS=$(echo ${DBPASS%\"})
DBPASS=$(echo ${DBPASS#?})

mysql -h $DBSERVER -P $DBPORT -u $DBUSER -p$DBPASS $DBNAME < temp/db_schema/$2.upg
mysql -h $DBSERVER -P $DBPORT -u $DBUSER -p$DBPASS "$DBNAME"_oa < temp/db_schema/"$2"_oa.upg

mv $1 $1.orig
mv temp $1
chown -R apache:apache $1
chmod 755 $1 -R
chmod 775 $1/terminal -R
chmod 775 $1/termstart -R
