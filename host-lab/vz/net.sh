#!/bin/bash

if [ $VEID -eq 100 ]
then
	nr=2
	bridge[1]="br100-200"
	eth[1]="veth100.1" 
	bridge[2]="br100-400"
	eth[2]="veth100.0"
elif [ $VEID -eq 200 ]
then
	nr=2
	bridge[1]="br100-200"
	eth[1]="veth200.0"
	bridge[2]="br200-300"
	eth[2]="veth200.1"
elif [ $VEID -eq 300 ]
then
	nr=2
	bridge[1]="br200-300"
	eth[1]="veth300.0"
	bridge[2]="br300-400"
	eth[2]="veth300.1"
elif [ $VEID -eq 400 ]
then
	nr=2
	bridge[1]="br300-400"
	eth[1]="veth400.0"
	bridge[2]="br100-400"
	eth[2]="veth400.1"
else
	exit 0
fi

echo "VZ Custom Configuration Script"

i=1
while [ $i -le $nr ]
do
	isbridge=`brctl show | grep -i ${bridge[$i]}`
	if [ -z "$isbridge" ]
	then
		echo "Create bridge: ${bridge[$i]}"
		brctl addbr "${bridge[$i]}"
		ip link set "${bridge[$i]}" up
	fi
	for iface in ${eth[$i]}
	do
		isiface=`ip a s | grep "$iface"`
		if [ ! -z "$isiface" ]
		then
			ip link set "$iface" up
			ifaceinbridge=`brctl show | grep -i "$iface"`
			if [ -z "$ifaceinbridge" ]
			then
				echo "Add if $iface to bridge ${bridge[$i]}"
				brctl addif "${bridge[$i]}" "$iface"
			fi
		fi
	done
	i=$((i+1))
	
done


