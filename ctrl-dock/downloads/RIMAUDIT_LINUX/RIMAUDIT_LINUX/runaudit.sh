#!/bin/bash
clear
echo "Please wait, while the system is audited ...."

sh audit $1 > audit.log

echo "The audit has been completed and the results submitted to $1"