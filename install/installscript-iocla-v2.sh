#!/bin/bash

######################################
##### PACKAGES FOUND IN THE REPO #####
######################################

# install essentials
apt-get install git gcc gdb nasm ipython vim vim-gnome radare2 python-pip -y
apt-get -y install gzip bzip2 zip unzip unrar p7zip lzma xz-utils
apt-get install bless valgrind -y

# nice to have
apt-get install chromium-browser -y

# install ssh server
apt-get install openssh-server -y

# 32 bit libraries
sudo dpkg --add-architecture i386
apt-get -y install libc6:i386 libc6-dev:i386 libstdc++-4.9-dev:i386
apt-get -y install gcc-multilib g++-multilib

####################################
##### OTHER PROGRAMS AND TOOLS #####
####################################

# install SASM (32 bit)
wget -O ~/Downloads/sasm.deb http://download.opensuse.org/repositories/home:/Dman95/xUbuntu_16.04/i386/sasm_3.9.0_i386.deb
dpkg -i /home/student/Downloads/sasm.deb
apt-get -f install
dpkg -i /home/student/Downloads/sasm.deb

# install binary.ninja
# not available in 32bit format :C
#sudo dpkg --add-architecture amd64
#sudo apt-get install lib64z1
#sudo apt-get install libglib2.0-0:amd64 libxext6:amd64 libgl1-mesa-glx:amd64
#sudo apt-get install libxcb-xkb1:amd64 libxcb-icccm4:amd64 libxcb-image0:amd64 libxcb-render-util0:amd64

# install gdb-peda and create an alias for launching it
git clone https://github.com/longld/peda.git ~/peda
echo -ne "def peda\nsource ~/peda/peda.py\nend\n" > ~/.gdbinit

# install pwntools
apt-get update
apt-get install python2.7 python-pip python-dev git libssl-dev libffi-dev build-essential -y
pip install --upgrade pip
pip install --upgrade pwntools

# install vimrc
git clone --depth=1 https://github.com/amix/vimrc.git ~/.vim_runtime
sh ~/.vim_runtime/install_awesome_vimrc.sh

##########################
##### FIXES / TWEAKS #####
##########################

# disable ASLR system-wide
echo -ne "kernel.randomize_va_space = 0\n" > /etc/sysctl.d/01-disable-aslr.conf

# fix plymouthd crash ?
apt-get install plymouth-x11 -y
touch /var/log/boot.log
mkdir -p /lib/plymouth

# setup swapfile
dd if=/dev/zero of=/mnt/swapspace bs=1M count=512
mkswap /mnt/swapspace
chmod 600 /mnt/swapspace
swapon /mnt/swapspace
echo "/mnt/swapspace swap swap defaults 0 0" >> /etc/fstab

# add alias for booting in CLI / GUI
echo -ne 'alias boot-cli="systemctl set-default multi-user.target"\nalias boot-graphical="systemctl set-default graphical.target"\n' > ~/.bash_aliases

# packages needed for system monitor extension
apt-get install gir1.2-gtop-2.0 gir1.2-networkmanager-1.0