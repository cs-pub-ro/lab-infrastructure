#!/bin/bash

# Mircea Bardac (cs@mircea.bardac.net)
# George Milescu (george.milescu@gmail.com)
# november 2007

# Script for checking if all installed packages have
# all their files on disk

# There were situations when some files were missing and they should
# have been installed, since they were part of an installed package

for pack in `dpkg -l | sed "1,5d"  | tr -s " " | cut -d " " -f 2`; do
	dpkg -L $pack | grep -v "package diverts others to" | grep -v "diverted by" | grep -v "does not contain any files" > all_files
	cat all_files | while read f ; do
		if [[ ! ((-e "$f") ||  (-d "$f")) ]]; then
			echo $pack": "$f >> to_reinstall
		fi
	done
done
