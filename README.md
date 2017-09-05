# ykwBonjourAUSY

This README.md is an instruction and a description of the code for the project <Bonjour AUSY>.

**Summary**

[Description of \<Bonjour AUSY>](https://github.com/amelieykw/ykwBonjourAUSY#description-of-bonjour-ausy)
- [Working environment](https://github.com/amelieykw/ykwBonjourAUSY#working-environment)
- [The structure of the whole project](https://github.com/amelieykw/ykwBonjourAUSY#the-structure-of-the-whole-project)
- [Server side (Docker = Nginx + PHP + MySQL)](https://github.com/amelieykw/ykwBonjourAUSY#server-side-docker--nginx--php--mysql)
	- [MySQL](https://github.com/amelieykw/ykwBonjourAUSY#mysql)
		- [Structure](https://github.com/amelieykw/ykwBonjourAUSY#structure)
		- [Usage](https://github.com/amelieykw/ykwBonjourAUSY#usage)
		- [Description of this container](https://github.com/amelieykw/ykwBonjourAUSY#description-of-this-container)
	- [PHP (The core code of server side)](https://github.com/amelieykw/ykwBonjourAUSY#php-the-core-code-of-server-side)
		- [Structure](https://github.com/amelieykw/ykwBonjourAUSY#structure-1)
		- [Usage](https://github.com/amelieykw/ykwBonjourAUSY#usage-1)
		- [Description of this container](https://github.com/amelieykw/ykwBonjourAUSY#description-of-this-container-1)
			- [1. create_table](https://github.com/amelieykw/ykwBonjourAUSY#1-create_table)
			- [2. insert_data](https://github.com/amelieykw/ykwBonjourAUSY#2-insert_data)
			- [3. fetch_data](https://github.com/amelieykw/ykwBonjourAUSY#3-fetch_data)
			- [4. authentication](https://github.com/amelieykw/ykwBonjourAUSY#4-authentication)
			- [5. hotesse](https://github.com/amelieykw/ykwBonjourAUSY#5-hotesse)
			- [6. email_alert](https://github.com/amelieykw/ykwBonjourAUSY#6-email_alert)	
	- [Nginx (The most outside container of the server)](https://github.com/amelieykw/ykwBonjourAUSY#nginx-the-most-outside-container-of-the-server)
		- [Structure](https://github.com/amelieykw/ykwBonjourAUSY#structure-2)
		- [Usage](https://github.com/amelieykw/ykwBonjourAUSY#usage-2)
		- [Description of this container](https://github.com/amelieykw/ykwBonjourAUSY#description-of-this-container-2)
- [docker-compose.yml](https://github.com/amelieykw/ykwBonjourAUSY#docker-composeyml)
	- [Verify the result](https://github.com/amelieykw/ykwBonjourAUSY#verify-the-result)
	- [Interact with the container MySQL](https://github.com/amelieykw/ykwBonjourAUSY#to-interact-with-the-container-mysql)
	- [Interact with the container Nginx](https://github.com/amelieykw/ykwBonjourAUSY#to-interact-with-the-container-nginx)
[Contact](https://github.com/amelieykw/ykwBonjourAUSY#contact)

# Description of \<Bonjour AUSY>
This project <Bonjour AUSY> is for simulating the elec-signature process. 

It has three parts (click to get to the Github repository) : 
- [Server side (Docker = Nginx + PHP + MySQL)](https://github.com/amelieykw/ykwBonjourAUSY) 
- [Web Services Back Office (Angular 4)](https://github.com/amelieykw/ykwBonjourAUSY_Angular4) 
- [Android Tablette App](https://github.com/amelieykw/ykwBonjourAUSY_Android) 

### Working environment
I use the Docker Machine for Mac. For Windows, Docker provides the Docker Machine for Windows. It'll be similar to Docker Machine for Mac. For Linux, we don't need to install Docker Machine, because Docker Machine is used to provide a Linux Host Machine for your PC.

Here, I'll only talk about the Mac version.

1. [Download](https://docs.docker.com/machine/install-machine/) and [install](https://docs.docker.com/docker-for-mac/) Docker Machine for Mac. 

2. Make sure that you have installed Virtualbox on your Mac.

3. Open the terminal and type :
```
docker-machine create --driver virtualbox BonjourAUSY
```
(BonjourAUSY is the name of your docker machine name. You can replace it with any name you like.)

4. Then follow the instructions showed in the terminal. You terminal will be the terminal of your docker machine that you just created.

5. To check the IP address of the docker machine :
```
docker-machine ip BonjourAUSY
```

6. To check all the docker machines and their status :
```
docker-machine ls
```

7. To start, stop, restart, remove the docker machine :
```
docker-machine start BonjourAUSY
docker-machine stop BonjourAUSY
docker-machine restart BonjourAUSY
docker-machine rm BonjourAUSY
```

8. You create a name for your site but you need to let your Mac know the name for the IP address of this docker machine :
In your terminal, type 
```
nano /etc/hosts
```
Then add this line of code at the end of file :
```
192.168.99.100 www.bonjourausy.com
```

Once you create a docker machine, you can create the images and containers on this docker machine.

### The structure of the whole project
ykw_BonjourAUSY
  - images
    - angular4
    - mysql
      - Dockerfile
    - nginx
      - Dockerfile
    - php7_fpm_base
      - Dockerfile
    - server
      - Dockerfile
      -src
        - public 
          - authentication
          - create_table
          - email_alert
          - fetch_data
          - hotesse
          - insert_data
          - connect.php
          - helloworld.php
          - index.php        
  - docker-compose.yml

### Server side (Docker = Nginx + PHP + MySQL)
The server side of this project is made by Docker. It's constructed by three containers: **Nginx, PHP and MySQL**. These three containers link to each other: **Nginx <---(link to)--- PHP <---(link to)--- MySQL**.

#### MySQL 

##### Structure
- mysql
  - Dockerfile
##### Usage 

First, we need to build the image for MySQL. 
Get into the **mysql** repository and run the command :
```
docker build -t ykwBonjourAUSY_mysql .
```
(ykwBonjourAUSY_mysql will be the name of the image you build. You can replace it by any name you want.)

Then check the image you just build by running the command :
```
docker images
```
##### Description of this container
This container has nothing special. It downloads the original MySQL container from Docker :
```
FROM mysql
```
It will be the database of this project.

#### PHP (The core code of server side) 

##### Structure
- php7_fpm_base
  - Dockerfile
- server
  - Dockerfile
  - src
    - public 
       - authentication
          - create_jwt_token.php
          - login.php
          - verify_jwt_token.php
       - create_table
          - create_table_admin.txt
          - create_table_contact.txt
          - create_table_query.php
          - create_table_rdv.txt
          - create_table_sites.txt
       - email_alert
          - create_email.php
       - fetch_data
          - all_sites.php
          - rdv_info_for_candidat.php
          - rdv_info_of_one_site_for_manager.php
       - hotesse
          - annuler_one_Prise_En_Charge_by_hotesse.php
          - annuler_one_rdv_by_hotesse.php
          - create_newRDV.php
          - get_all_contact.php
          - get_all_rdvs.php
          - send_Email_alter.php
          - supprimer_one_rdv_by_hotesse.php
          - valide_one_Prise_En_Charge_by_hotesse.php
          - valide_one_rdv_by_hotesse.php
       - insert_data
          - administrateur_original.txt
          - contacts_original.txt
          - insert_query_file.php
          - rendezvous_original.txt
          - sites_original.txt
          - valide_one_rdv_by_candidat.php
          - valide_one_rdv_by_manager.php
       - connect.php
       - helloworld.php
       - index.php
       
##### Usage 
Our PHP container will be built on the basic php7-fpm container of Docker. 'Cause we need to make some initial setting to this basic container, in order to make each time's docker build easier and faster in the future, we'll make two images here, one for installing the settings on the basic php7-fpm container, one for running our core code on the custom php7-fpm container.

First, we need to build the image for php7_fpm_base. 
Get into the **php7_fpm_base** repository and run the command :
```
docker build -t ykwBonjourAUSY_php7_fpm_base .
```
(ykwBonjourAUSY_php7_fpm_base will be the name of the image you build. You can replace it by any name you want.)
To build this image, it'll take a little time.

Check the image you just build by running the command :
```
docker images
```

Then, we need to build the image for our server side core data. 
Get into the **server** repository and run the command :
```
docker build -t ykwBonjourAUSY_server .
```
(ykwBonjourAUSY_server will be the name of the image you build. You can replace it by any name you want.)

Then check the image you just build by running the command :
```
docker images
```
##### Description of this container
This container is where our core server side code is. It is for handling the requests entered from Nginx container and manipulate the data stored in MySQL container.

First, we need the functions to manipulate the data stored in MySQL container:
1. create_table
2. insert_data
3. fetch_data

Then, for the functions of project, we need:
4. authentication
5. hotesse
6. email_alert

The other three files are :
- connect.php
- helloworld.php
- index.php  

The `connect.php` is used for all the other .php file in this repository to connect to the MySQL database.
The `index.php` is used to create a interface for the server, so that we can verify whether the server works well or not. We can also use it to create the tables and insert data into the tables. We can do more to the situation of the server and the database by adding code into this file.
The `helloworld.php` is for fun.

###### 1. create_table
create_table
  - create_table_admin.txt
  - create_table_contact.txt
  - create_table_query.php
  - create_table_rdv.txt
  - create_table_sites.txt

In order to improve the reuse rate of code, I create a file `create_table_query.php` to be a template of creating a table in the database, so that whenever you want to create a new table, you just need to create a .txt file by using the syntax of MySQL (like the files `create_table_admin.txt`, `create_table_contact.txt`, `create_table_rdv.txt`, `create_table_sites.txt` ). Then change the part of code in server/src/public/index.php (like what I did for table administrateur, site, contact, rendezvous):
```
<p>Choose a file to create a table :</p>
  <form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
	  <select name = "selected_table_create_file">      
		  <option value = "./create_table/create_table_admin.txt">
		      administrator
		  </option>
		  <option value="./create_table/create_table_sites.txt">
		      site
		  </option>
		  <option value="./create_table/create_table_contact.txt">
		      contact
		  </option>
		  <option value="./create_table/create_table_rdv.txt">
		      rendez-vous
		  </option>
	  </select>
	  <input type = "Submit" value="Create table"/>
  </form>
```
Refresh the browser, you can create a new table from the interface **Bonjour AUSY index page**.

**Attention:** You need to create the table in order of administrateur-->site-->contact-->rendezvous because of the links between these tables. 

###### 2. insert_data
insert_data
  - administrateur_original.txt
  - contacts_original.txt
  - insert_query_file.php
  - rendezvous_original.txt
  - sites_original.txt
  - valide_one_rdv_by_candidat.php
  - valide_one_rdv_by_manager.php

Like to create the tables in database, in order to improve the reuse rate of code, I create a file `insert_query_file.php` to be a template of insert data into a table in the database, so that whenever you want to insert data, you just need to create a .txt file by using the syntax of MySQL. (like the files `administrateur_original.txt`, `sites_original.txt`, `contacts_original.txt`, `rendezvous_original.txt`. These four files contain the original test data. Not very good test data, please modify before using them. ) 
Then change the part of code in server/src/public/index.php (like what I did for table administrateur, site, contact, rendezvous):
```
<p>Choose a file of original data to insert :</p>
  <form action = "<?php $_SERVER['PHP_SELF'] ?>" method ="POST">
	  <select name = "selected_insert_original_data_file">
	    <option value="./insert_data/administrateur_original.txt">
		     administrateur
		  </option>      
		  <option value = "./insert_data/sites_original.txt">
		     sites
		  </option>
		  <option value="./insert_data/contacts_original.txt">
		     contacts
		  </option>
		  <option value="./insert_data/rendezvous_original.txt">
		     rendez-vous
		  </option>
	  </select>
	  <input type = "Submit" value="Insert data"/>
  </form>

```
Refresh the browser, you can create a new table from the interface **Bonjour AUSY index page**.

**Attention:** You need to insert data into these tables in order of administrateur-->site-->contact-->rendezvous because of the links between these tables. 

- valide_one_rdv_by_candidat.php
- valide_one_rdv_by_manager.php

These two files are used for Android tablette part of application to **change** the data of one particular RDV once the manager or the candidate valide this RDV.

###### 3. fetch_data
fetch_data
  - all_sites.php
  - rdv_info_for_candidat.php
  - rdv_info_of_one_site_for_manager.php

These three files are used for Android tablette part of application to **get** the data from the database. See details in the description of Android tablette part of application.

###### 4. authentication
authentication
  - create_jwt_token.php
  - login.php
  - verify_jwt_token.php

The web services Back Office part is made by Angular 4. Users, like hotesses, need to login before using the web services. This function authentication is for login. Angular 4 authentication uses JSON Web Token (JWT) to do this function.

`create_jwt_token.php` is to create a JSON Web Token. `login.php` verify the username and password which the user enters from the browser with the data stored in the database. Once verified, it uses the information of the verified user to create a JSON Web Token and send it to the browser. The browser will store the token in the localStorage, so that each time the user asks for web services, the token will be sent to the server and used to verify the user (web services will be offered only when the user is verified). The file `verify_jwt_token.php` is used to verify the user each time the user asks for web services.

###### 5. hotesse
hotesse
  - annuler_one_Prise_En_Charge_by_hotesse.php
  - annuler_one_rdv_by_hotesse.php
  - create_newRDV.php
  - get_all_contact.php
  - get_all_rdvs.php
  - send_Email_alter.php
  - supprimer_one_rdv_by_hotesse.php
  - valide_one_Prise_En_Charge_by_hotesse.php
  - valide_one_rdv_by_hotesse.php

Once the user logged in as a hotesse, the user can have access to these web services. These files will first use the file `verify_jwt_token.php` to verify the user, then to get or change the data stored in the database. These files are included in the code of Angular 4 part of application as the APIs.

###### 6. email_alert
email_alert
  - create_email.php

The code of this function has been written here, but only when the whole application is online, this function can be tested or used.


#### Nginx (The most outside container of the server) 

##### Structure
- nginx
  - Dockerfile
  - bonjourausy.com
  - bonjourausy.conf
  - nginx.conf
  - php7_fpm.conf
  - proxy.conf
       
##### Usage 
Our Nginx container will be built on the basic nginx container of Docker. 

First, we need to build the image for nginx. 
Get into the **nginx** repository and run the command :
```
docker build -t ykwBonjourAUSY_webnginx .

```
(ykwBonjourAUSY_webnginx will be the name of the image you build. You can replace it by any name you want.)

Check the image you just build by running the command :
```
docker images
```

##### Description of this container
This container is the most outside container of our server. It will receive all the requests get from the client (Android tablette or the browser) and then send them to the right containers to be handled (Angular 4 module container or PHP container).

You can see the code in the Dockerfile :
 ```
FROM nginx

#COPY ./bonjourausy.com /etc/nginx/sites-available/bonjourausy.com
#RUN ln -s /etc/nginx/sites-available/bonjourausy.com /etc/nginx/sites-enabled/bonjourausy.com 

#COPY ./nginx.conf /etc/nginx/nginx.conf
#COPY ./proxy.conf /etc/nginx/conf.d/proxy.conf
COPY ./php7_fpm.conf /etc/nginx/conf.d/default.conf
#COPY ./bonjourausy.conf /etc/nginx/conf.d/bonjourausy.conf

```
For now, there's only 
 ```
COPY ./php7_fpm.conf /etc/nginx/conf.d/default.conf
```
which can be actually runned. This `php7_fpm.conf` is the settings for our PHP container which listen 8080 port of the host machine.

`nginx.conf`, `proxy.conf`, `bonjourausy.com` and `bonjourausy.conf` are the files that I want to use to add angular 4 module into the whole application (but I didn't succeed).

**Try 1:**
I want to use `nginx.conf`, `proxy.conf`, `bonjourausy.com` to create an available site in the host machine by the code :
 ```
#COPY ./bonjourausy.com /etc/nginx/sites-available/bonjourausy.com
#RUN ln -s /etc/nginx/sites-available/bonjourausy.com /etc/nginx/sites-enabled/bonjourausy.com 

#COPY ./nginx.conf /etc/nginx/nginx.conf
#COPY ./proxy.conf /etc/nginx/conf.d/proxy.conf
#COPY ./bonjourausy.conf /etc/nginx/conf.d/bonjourausy.conf
```
Where 
- `nginx.conf` is the main configuration
- `proxy.conf` is the proxy configuration
- `bonjourausy.com` is the configuration for the angular 4 module container

But I didn't figure it out. If anyone figured it out, please write the solution here. Thank you!

**Try 2:**
After the Try 1 failed, I want to use `bonjourausy.conf` to link the angular 4 module container directly to the Nginx container like the PHP container.  

But I didn't figure it out. If anyone figured it out, please write the solution here. Thank you!

#### docker-compose.yml
Now since we have the images:
- ykwBonjourAUSY_mysql
- ykwBonjourAUSY_php7_fpm_base
- ykwBonjourAUSY_server
- ykwBonjourAUSY_webnginx

We can use docker-compose.yml to create the containers for Nginx, PHP and MySQL by running these commands :
```
docker-compose up -d --remove-orphan
```
`-d` is for running the docker compose in a detach mode. Without `-d`, you can see the details so that you can see the errors if there are the bugs when you run this command.

You can use 
```
docker-compose ps 
```
to see if all the containers have been created well and work well. If one container has been well created and works well, its status will be "Up".

##### Verify the result
When you see "Up" for each container, you can open the browser and enter 
```
<docker-machine ip>:8080
```
Or
```
www.bonjourausy.com:8080
```
to see the interface.(www.bonjourausy.com is the name of the site you added into /etc/hosts of your mac.) You use this interface to create tables and insert data.

Since in `docker-compose.yml`, I've already add the volumes which copys the core code of server (the code in the repository ./images/server/src/public) into the docker machine, you can refresh the browser to see the changes each time you do the modification in the repository ./images/server/src/public. You don't need to rebuild the containers.
```
php:
  image: 'bonjourausy_server:latest'
  links:
    - mysql
  volumes:
    - ./images/server/src/public:/var/www/html
```


##### To interact with the container MySQL
To enter one container MySQL:
```
docker exec -it ykwBonjourAUSY_mysql_1 /bin/bash
```
(ykwBonjourAUSY_mysql_1 is the name of MySQL container that you can find in the result of command `docker-compose ps`. Replace it with the concret situation.)

To see the data stored in this container, run the command :
```
ls /var/lib/mysql
```

Once you enter in the MySQL container, it means that you can manipulate the database:
1. Login yourself
```
mysql -u root -p
```
Then it'll ask you for the password. The password is written in the `/images/server/src/public/connect.php` after the `root`.

2. Then redirect you the database `bonjourausy`:
```
use bonjourausy
```
Then you can use the  see all the tables you just created by the interface :
```
show tables
```
Then all will be the syntax of MySQL.

3. Use `exit` to leave the MySQL working environment and the MySQL container working environment.


##### To interact with the container Nginx
To enter one container Nginx:
```
docker exec -it ykwBonjourAUSY_webnginx_1 /bin/bash
```
1.Open `/etc/hosts`, you'll see the ip address like 172.*.*.* followed with the containers name which you just created by using docker-compose.yml. These ip addresses are the interal addressed for each container inside the host docker machine.

2. To see the core code of the server you copied into the host machine, run the command :
```
ls /var/www/html
```

3. I didn't copy the data of MySQL into the host machine. If you want to copy the data of MySQL into the host machine to back up, modify the code in the docker-compose.yml from :
```
mysql:
  environment:
    - MYSQL_DATABASE=bonjourausy
    - MYSQL_ROOT_PASSWORD=admin
  image: 'bonjourausy_mysql:latest'
  volumes:
    - /var/lib/mysql
```
to
```
mysql:
  environment:
    - MYSQL_DATABASE=bonjourausy
    - MYSQL_ROOT_PASSWORD=admin
  image: 'bonjourausy_mysql:latest'
  volumes:
    - /var/lib/mysql:/var/lib/mysql
```
Then you can see the data of MySQL from the webnginx container :
```
ls /var/lib/mysql
```


## Contact
If there're some questions, please contact the developer YU Kaiwen:
yu.kaiwen.amelie@gmail.com
