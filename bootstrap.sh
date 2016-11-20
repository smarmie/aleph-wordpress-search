#!/bin/bash

apt clean
apt update
apt -y upgrade
apt -y install php7.0-cli php7.0-xml php7.0-soap
