<?php

$conf['useacl']      = 1;               
$conf['superuser']   = '@assistant';

$conf['authtype']   = 'ldap';

$conf['auth']['ldap']['server'] = "ldaps://ldap2.grid.pub.ro/";
$conf['auth']['ldap']['usertree'] = 'dc=curs, dc=cs, dc=pub, dc=ro';
$conf['auth']['ldap']['userfilter']  = '(uid=%{user})'; 

$conf['auth']['ldap']['debug'] = 1;
$conf['auth']['ldap']['starttls'] = 0;

$conf['auth']['ldap']['mapping']['name'] = 'uid';

# Fara asta nu merge ldap de pe grid
putenv('LDAPTLS_REQCERT=never') or die("Failed to setup the env.");

# Grupuri de utilizatori. Momentan, assistant si teacher. Devin grupuri acl
$conf['auth']['ldap']['assistants'] = array (
	'ieftimie', 
	'mbardac', # not sure about it
	'gmilescu',
	'ajuncu', 
	'abuhaiu',
	'ciorgulescu',
	'Andrei.Faur',
	'viancu',
	'andrei.soare',
	'rdeaconescu',
	'mihai.maruseac',
	'ddogaru',
	'andrei.dumitru'
); # 
#$conf['auth']['ldap']['teachers'] = array (); # ...
