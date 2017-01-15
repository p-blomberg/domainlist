# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
	config.vm.box = "remram/debian-9-amd64"
	config.vm.box_version = "0.16.11.14"
	config.vm.network "public_network"

	config.vm.provider "virtualbox" do |vb|
		vb.memory = "1024"
	end

	config.vm.provision "ansible" do |ansible|
		ansible.playbook = "ansible/playbook.yml"
	end
end
