#!/usr/bin/env bash
# You can change what anaconda version you want at
# https://repo.continuum.io/archive/
wget https://repo.continuum.io/archive/Anaconda3-4.3.1-Linux-x86_64.sh -O $HOME/anaconda.sh
bash $HOME/anaconda.sh -b -p $HOME/anaconda
rm -f $HOME/anaconda.sh
# add conda to our path
export PATH="$HOME/anaconda/bin:$PATH"
# Refresh .bashrc so we can use the conda command
source .bashrc
conda update conda -y

# install nvm and use that to install node/npm
rm -rf ~/.nvm && git clone https://github.com/creationix/nvm.git ~/.nvm && (cd ~/.nvm && git checkout `git describe --abbrev=0 --tags`) && source ~/.nvm/nvm.sh && nvm install node