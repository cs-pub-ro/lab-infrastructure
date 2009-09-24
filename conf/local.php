<?php

$conf['useacl']      = 1;                //Use Access Control Lists to restrict access?
$conf['superuser']   = 'admin';

$conf['authtype']   = 'ldap';

$conf['auth']['ldap']['server'] = "ldaps://ldap2.grid.pub.ro/";
$conf['auth']['ldap']['usertree'] = 'dc=curs, dc=cs, dc=pub, dc=ro';
$conf['auth']['ldap']['userfilter']  = '(uid=%{user})'; # TODO ou=Asistent/Student

#$conf['auth']['ldap']['debug'] = 1;
$conf['auth']['ldap']['starttls'] = 0;

$conf['auth']['ldap']['mapping']['name'] = 'uid';
# TODO other mappings

# Fara asta nu merge ldap de pe grid
putenv('LDAPTLS_REQCERT=never') or die("Failed to setup the env.");
