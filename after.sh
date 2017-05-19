#!/usr/bin/env bash
# You can change what anaconda version you want at
# https://repo.continuum.io/archive/
wget https://repo.continuum.io/archive/Anaconda3-4.3.1-Linux-x86_64.sh -O ~/anaconda.sh
bash ~/anaconda.sh -b -p ~/anaconda
rm -f ~/anaconda.sh
# add conda to our path
export PATH="~/anaconda/bin:$PATH"
# Refresh .bashrc so we can use the conda command
source .bashrc
conda update conda -y