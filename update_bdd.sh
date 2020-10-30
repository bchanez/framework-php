#!/bin/bash
# affiche_param.sh

user=""
password=""
dbname=""
while read line ; do
  case $( echo $line | cut -d"=" -f1) in
    "dbname") dbname=$( echo $line | cut -d"=" -f2);;
    "user") user=$( echo $line | cut -d"=" -f2);;
    "password") password=$( echo $line | cut -d"=" -f2)
  esac
done < ".env"

if [ $# -gt 0 ]
then
  if [ $1 = "reset" ]
  then
    echo $(mysql -u $user -p$password -e "DROP DATABASE IF EXISTS "$dbname";")
    echo $(mysql -u $user -p$password -e "CREATE DATABASE "$dbname" CHARACTER SET 'utf8';")
    mysql -u $user -p$password $dbname < ./patch/001_create_table_version.sql;
  fi
fi
number=$( echo $(mysql -u $user -p$password $dbname -e "SELECT number FROM Version;") | cut -d" " -f2)

for eachfile in $(ls ./patch/*.sql)
do
  scriptNumber=$( echo $( echo $( echo $eachfile) | cut -d"/" -f3) | cut -d"_" -f1)
  if [ $scriptNumber -gt $number ]
  then
    echo $eachfile "+"
    if mysql -u $user -p$password $dbname < $eachfile;
    then
      echo $(mysql -u $user -p$password $dbname -e "UPDATE Version SET number="$scriptNumber" WHERE id=1;")
    else
      exit 1
    fi
  else
    echo $eachfile "="
  fi
done
