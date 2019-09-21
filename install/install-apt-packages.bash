#!/bin/bash


install_apt_package() {
	sudo apt -y install "$1"
}

# Update apt-file cache.
sudo apt update

sudo dpkg --add-architecture i386

for package_file; do
	while read package; do
		# allow comments and empty lines in packages file
		if [[ "$package" =~ "#"  || -z "$package" ]]; then
			continue
		fi

		install_apt_package "$package"
	done < "$package_file"
done
