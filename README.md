# Database exercise 2 (MongoDB)

I have created a small Database Application in a PHP file called index.php. 

It connects and execute queries from a MongoDB database running in a container on the same server as the PHP file. The docker container is same as used in the lecture ( note I made a small change to the port number).

I have set up the solution on a Digital Ocean Machine where you can execute the queries and get the result also by adding your own text to match the mood queries [test the application here](http://128.199.43.226/DBEX2-Emmely/index.php).

## Instructions to set up the solution on a Linux/Ubuntu Machine
### Requirement

A Linux/Ubuntu machine with docker installed. 

### Set up a Ubuntu/Linux environment 

I have attached the Vagrant file I use for development or if you want to create droplet in Digital Ocean (also works with these instructions).
Run the vagrant file in you bash terminal with

```vagrant up```

```vagrant ssh```

Install Docker:


```sudo apt-get install -y git```

```sudo apt-get install -y wget```

```wget -O - https://bit.ly/docker-install | bash```


#### Set up the Docker container with MongoDB:

Set up the MongoDB (same as we did during the lecture):

```sudo docker run --rm -v $(pwd)/data:/data/db --name dbms --publish=27018:27017 -d mongo:latest```
```sudo docker run -it --link dbms:mongo --rm mongo sh -c 'exec mongo "$MONGO_PORT_27017_TCP_ADDR:$MONGO_PORT_27017_TCP_PORT/test"'```

#### Import the data from CSV to MongoDB:

In the docker container import the data into a database/collection called tweets/tweets.

```apt-get update```

```apt-get install -y wget```

```apt-get install -y unzip```

```wget http://cs.stanford.edu/people/alecmgo/trainingandtestdata.zip```

```unzip trainingandtestdata.zip```

```sed -i '1s;^;polarity,id,date,query,user,text\n;' training.1600000.processed.noemoticon.csv```

```head -2 training.1600000.processed.noemoticon.csv```

```mongoimport --drop --db tweets --collection tweets --type csv --headerline --file training.1600000.processed.noemoticon.csv```


The docker container is now prepared. Exit the docker cotainer by 

```exit```


You can always enter again with this one but don't do that now.

```docker exec -it dbms bash```


#### Install Apache/PHP7 on your Ubuntu/Linux machine:

```sudo apt-get update```

```apt-get install apache2```

```apt-get -y install php7.0 libapache2-mod-php7.0 php7.0-mcrypt```

```systemctl restart apache2```

You should be able to see some PHP information by navigating to the IP address of you machine.

#### Install MongoDB Driver for PHP:


```sudo apt-get install php-pear```

```sudo apt-get install php-pecl```

```sudo apt-get install php7.0-dev```


```pecl channel-update pecl.php.net```


```sudo pecl install -f mongodb-1.4.0```

```echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"```


```systemctl restart apache2```


#### Clone the application from GitHub

``` cd /var/www/html ```

``` git clone https://github.com/Games-of-Threads/DBEX2-Emmely.git ```

``` cd DBEX2-Emmely```

You should be able to see the application by navigating to the IP address of you machine /DBEX2-Emmely.


## Use the application
[My set up on Digital Ocean](http://128.199.43.226/DBEX2-Emmely/index.php)
I have set up a Digital Ocean Ubuntu machine 1GB by following the guide above.
## My results of the queries

[![https://gyazo.com/8295c229c0a43150d61d4e19f7198073](https://i.gyazo.com/8295c229c0a43150d61d4e19f7198073.png)](https://gyazo.com/8295c229c0a43150d61d4e19f7198073)

[![https://gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3](https://i.gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3.png)](https://gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3)
	
[![https://gyazo.com/2d064811e79c3a49720e81124d8a9a62](https://i.gyazo.com/2d064811e79c3a49720e81124d8a9a62.png)](https://gyazo.com/2d064811e79c3a49720e81124d8a9a62)

[![https://gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df](https://i.gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df.png)](https://gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df)


```happy|excited|nice|glad```

[![https://gyazo.com/3a826bd55833ec52769c2349d107b8c1](https://i.gyazo.com/3a826bd55833ec52769c2349d107b8c1.png)](https://gyazo.com/3a826bd55833ec52769c2349d107b8c1)


[![https://gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67](https://i.gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67.png)](https://gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67)

--------
Implemented by Emmely Lundberg cph-el69
