View this file in CODE mode

To run site (on apache/linux(Arch)) localy:
1) add 2 lines to /etc/hosts:
   127.0.0.1 simfor
   127.0.0.1 simfor.back
2) clone this repo to /srv/http
3) Create db yii2advanced 
4) in /srv/http/Simfor run sudo ./yii migrate/create "name"
   repace "name" with init, add_verification_token_column_to_user_table, articles, likes, comments
   in the given order
5) in Simfor/console/migrations copy contents from cloned files, to newly create migrations
   by copying the contents of classes with respect to names
6) adjust the db login information in Simfor/common/config/main-local.php
   'username' => ''
   'password' => ''
7) create a2ensite in /usr/local/bin and make it executable by (sudo chmod +x a2ensite)
    #!/bin/bash
    if test -d /etc/httpd/conf/sites-available && test -d /etc/httpd/conf/sites-enabled  ; then
    echo "-------------------------------"
    else
    mkdir /etc/httpd/conf/sites-available
    mkdir /etc/httpd/conf/sites-enabled
    fi
     
    avail=/etc/httpd/conf/sites-available/$1.conf
    enabled=/etc/httpd/conf/sites-enabled
    site=`ls /etc/httpd/conf/sites-available/`
     
    if [ "$#" != "1" ]; then
            echo "Use script: n2ensite virtual_site"
            echo -e "\nAvailable virtual hosts:\n$site"
            exit 0
    else
    if test -e $avail; then
    sudo ln -s $avail $enabled
    else
    echo -e "$avail virtual host does not exist! Please create one!\n$site"
    exit 0
    fi
    if test -e $enabled/$1.conf; then
    echo "Success!! Now restart Apache server: sudo systemctl restart httpd"
    else
    echo  -e "Virtual host $avail does not exist!\nPlease see avail virtual hosts:\n$site"
    exit 0
    fi
    fi
8) create a2dissite in /usr/local/bin and make it executable by (sudo chmod +x a2dissite)
    #!/bin/bash
    avail=/etc/httpd/conf/sites-enabled/$1.conf
    enabled=/etc/httpd/conf/sites-enabled
    site=`ls /etc/httpd/conf/sites-enabled`
     
    if [ "$#" != "1" ]; then
            echo "Use script: n2dissite virtual_site"
            echo -e "\nAvailable virtual hosts: \n$site"
            exit 0
    else
    if test -e $avail; then
    sudo rm  $avail
    else
    echo -e "$avail virtual host does not exist! Exiting"
    exit 0
    fi
    if test -e $enabled/$1.conf; then
    echo "Error!! Could not remove $avail virtual host!"
    else
    echo  -e "Success! $avail has been removed!\nsudo systemctl restart httpd"
    exit 0
    fi
    fi
9) create a simfor.conf in /etc/httpd/conf/
    <VirtualHost *:80>
        ServerName simfor
        DocumentRoot "/srv/http/Simfor/frontend/web"
	      Options +FollowSymlinks
        
        <Directory "/srv/http/Simfor/frontend/web">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php

            # use index.php as index file
            DirectoryIndex index.php

            # ...other settings...
            # Apache 2.4
            Require all granted
            
            ## Apache 2.2
            # Order allow,deny
            # Allow from all
        </Directory>
    </VirtualHost>
    
    <VirtualHost *:80>
	      ServerName simfor.back
        DocumentRoot "/srv/http/Simfor/backend/web/"
        
        <Directory "/srv/http/Simfor/backend/web/">
            # use mod_rewrite for pretty URL support
            RewriteEngine on
            # If a directory or a file exists, use the request directly
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            # Otherwise forward the request to index.php
            RewriteRule . index.php

            # use index.php as index file
            DirectoryIndex index.php

            # ...other settings...
            # Apache 2.4
            Require all granted
            
            ## Apache 2.2
            # Order allow,deny
            # Allow from all
        </Directory>
    </VirtualHost>
10) run sudo a2ensite simfor, if everythig done correct then type simfor/ into the search bar and vuala
    





