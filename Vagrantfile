# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "hashicorp/precise64"
  
  config.vm.hostname = "RAWDEV"
  config.vm.network :forwarded_port, guest: 80, host: 8086, auto_correct: true
  config.vm.network :forwarded_port, guest: 3306, host: 9906, auto_correct: true
  config.vm.network :forwarded_port, guest: 22, host: 2229, auto_correct: true
  config.vm.network "private_network", ip: "192.168.56.108"
  
  config.ssh.forward_agent = true

  config.vm.synced_folder "../../", "/var/www"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
	vb.customize ["modifyvm", :id, "--name", "teammob"]
	vb.customize ["modifyvm", :id, "--memory", "512"]
	vb.customize ["modifyvm", :id, "--vram", "128"]
  end
  
  config.vm.provision :shell, :path=>"base_script.sh"
  
end
