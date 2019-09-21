#!/bin/bash


install_apt_package() {
	sudo apt -y install "$1"
}

install_packages_file() {
	packages_file="$1"
	while read line; do
		# allow comments and empty lines in packages file
		if [[ "$line" =~ "#"  || -z "$line" ]]; then
			continue
		fi

		# allow inclusion of other packages files
		if [[ "$line" =~ ^\+ ]]; then
			install_packages_file "${line:1}"
			continue
		fi

		install_apt_package "$line"
	done < "$packages_file"
}

sudo apt clean
sudo apt autoclean
sudo apt update

sudo dpkg --add-architecture i386

for packages_file; do
	install_packages_file "$packages_file"
done

sudo apt clean
sudo apt autoclean
sudo apt-file update
