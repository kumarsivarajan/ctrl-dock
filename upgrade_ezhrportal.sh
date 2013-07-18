#!/bin/bash

# Unpack the files
echo "Unpacking the files.."
cp -rf ezhrportal/ temp/

# Copy configuration files
echo "Copying Configuration Files.."
cp -rf -p $1/config.php temp/config.php

# Copy System Data
echo "Copying System Data.."
rm -rf temp/data/*
cp -rf -p $1/data/*  temp/data/

# Copy Applications
echo "Copying Application Data.."
rm -rf temp/apps/*
cp -rf -p $1/apps/*  temp/apps/


# Update the Database
echo "=+="
echo "Upgrade the Database"
line=$(grep "DATABASE_NAME" $1/config.php)
DBNAME=${line#*=}
DBNAME=$(echo ${DBNAME%\;})
DBNAME=$(echo ${DBNAME%\"})
DBNAME=$(echo ${DBNAME#?})

# Upgrade Database if it exists
if [ -f $2.upg ];
then
mysql $DBNAME < temp/db_schema/$2.upg
fi

mv $1 $1.orig
mv temp $1
chown -R apache:apache $1
chmod 755 $1 -R



