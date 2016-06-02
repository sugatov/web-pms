# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
    # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "hashicorp/precise32"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  # config.vm.network "forwarded_port", guest: 80, host: 80
  # config.vm.network "forwarded_port", guest: 3306, host: 3306

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"
  
  config.vm.synced_folder ".", "/vagrant", type: "rsync",
    owner: "vagrant",
    group: "vagrant",
    rsync__args: [
      "--verbose", "--archive", "--delete", "-z", "--copy-links", "--keep-dirlinks",
      "--chmod=Du=rwx,Dg=rwx,Do=rwx,Fu=rwx,Fg=rwx,Fo=rwx",
      "--include=\"source/data/filestorage/stock/***\"",
      "--include=\"public_html/uploads/stock/***\"",
      "--exclude=\".git/\"",
      "--exclude=\"source/lib/vendor/\"",
      "--exclude=\"source/lib/composer.lock\"",
      "--exclude=\"public_html/assets/bower_components/\"",
      "--exclude=\"public_html/uploads/*\"",
      "--exclude=\"source/data/filestorage/*\"",
      "--exclude=\"source/data/cache/filecache/**\"",
      "--exclude=\"source/data/cache/serializer/**\"",
      "--exclude=\"source/data/cache/templates/**\"",
    ]

  config.vm.provider "virtualbox" do |vb|
    vb.gui = false
    vb.memory = "512"
  end

  config.vm.provision "shell", path: "./.provisions/script.sh"
end
