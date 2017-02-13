# make src the default folder
sudo sed -i 's:DocumentRoot /home/ubuntu/workspace$:DocumentRoot /home/ubuntu/workspace/src:' /etc/apache2/sites-enabled/001-cloud9.conf

# make sure apache is restarted
sudo service apache2 restart