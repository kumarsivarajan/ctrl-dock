#!/bin/bash

database=$1
oasuffix="_oa"


echo create database $database | mysql
echo create database $database$oasuffix | mysql

echo "grant all privileges on $database.* to rim_user@'127.0.0.1' identified by 'r1m_u5er' with grant option" | mysql
echo "grant all privileges on $database$oasuffix.* to rim_user@'127.0.0.1' identified by 'r1m_u5er' with grant option" | mysql

mysql $database < rim.sql
mysql $database$oasuffix < rim_oa.sql