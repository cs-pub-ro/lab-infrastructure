#!/bin/bash

# script ce automatizeaza actiunile de freeze/unfreeze/halt/reboot pentru statiile din laborator

ids="s2 s3 s4 s5 s6 s7 s8 s9 s10 s11 s12 s13 s14 s1"
ssh_ops="-o StrictHostKeyChecking=no"

case "$1" in 
	"unfreeze")
	for i in $ids
	do
		ssh $ssh_ops "root@$i.local" "umount /etc/ -l"
		scp $ssh_ops /etc/init.d/sysufs "root@$i.local:/etc/init.d/" 
		ssh $ssh_ops "root@$i.local" "reboot"
	done
	;;
	"freeze")
	for i in $ids
	do
		scp $ssh_ops /etc/init.d/sysufs "root@$i.local:/etc/init.d/" 
		ssh $ssh_ops "root@$i.local" "reboot"
	done
	;;
	"reboot")
	for i in $ids
	do
		ssh $ssh_ops "root@$i.local" "reboot"
	done
	;;
	"halt")
	for i in $ids
	do
		ssh $ssh_ops "root@$i.local" "halt"
	done
	;;
	*)
	echo "Unknown command"
	;;
esac

