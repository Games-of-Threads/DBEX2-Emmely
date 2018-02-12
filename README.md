# DBEX2-Emmely
Emmely Lundberg cph-el69

On your Linux machine or in the Vagrant file attached use the following commands to set up the MongoDB, install PHP7 and Mongdb driver for PHP:

```sudo apt-get install -y git```
```sudo apt-get install -y wget```
```wget -O - https://bit.ly/docker-install | bash```

```sudo docker run --rm -v $(pwd)/data:/data/db --name dbms --publish=27018:27017 -d mongo:latest```
```sudo docker run -it --link dbms:mongo --rm mongo sh -c 'exec mongo "$MONGO_PORT_27017_TCP_ADDR:$MONGO_PORT_27017_TCP_PORT/test"'
```

###In the database server:


```apt-get update```

```apt-get install -y wget```

```apt-get install -y unzip```
```wget http://cs.stanford.edu/people/alecmgo/trainingandtestdata.zip```

```unzip trainingandtestdata.zip```

```sed -i '1s;^;polarity,id,date,query,user,text\n;' training.1600000.processed.noemoticon.csv```

```head -2 training.1600000.processed.noemoticon.csv```

```mongoimport --drop --db tweets --collection tweets --type csv --headerline --file training.1600000.processed.noemoticon.csv```


Exit database server by 
```exit```
You can always enter again with this one but don't do that now.
```docker exec -it dbms bash```
```sudo apt-get update```
```apt-get install apache2```
```apt-get -y install php7.0 libapache2-mod-php7.0 php7.0-mcrypt```
```systemctl restart apache2```


```sudo apt-get install php-pear```

```sudo apt-get install php-pecl```

```sudo apt-get install php7.0-dev```


```pecl channel-update pecl.php.net```


```echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"```

```sudo pecl install -f mongodb-1.4.0```

## Use the application
[My set up on Dgital ocean](http://128.199.43.226/DBEX2-Emmely/index.php)
I use Digital ocean Ubuntu machine 1GB and follow the guide above.
## Result
[![https://gyazo.com/8295c229c0a43150d61d4e19f7198073](https://i.gyazo.com/8295c229c0a43150d61d4e19f7198073.png)](https://gyazo.com/8295c229c0a43150d61d4e19f7198073)

[![https://gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3](https://i.gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3.png)](https://gyazo.com/d6dbb434b3fc4233c0d2bb0b3f93e6c3)
	
[![https://gyazo.com/f0ed75f9049f7af216782d2aa6a4ce54](https://i.gyazo.com/f0ed75f9049f7af216782d2aa6a4ce54.png)](https://gyazo.com/f0ed75f9049f7af216782d2aa6a4ce54)


[![https://gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df](https://i.gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df.png)](https://gyazo.com/cb4fc6f5f73fd388e2b9f0cc857a40df)


```happy|excited|nice|glad```

[![https://gyazo.com/3a826bd55833ec52769c2349d107b8c1](https://i.gyazo.com/3a826bd55833ec52769c2349d107b8c1.png)](https://gyazo.com/3a826bd55833ec52769c2349d107b8c1)


[![https://gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67](https://i.gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67.png)](https://gyazo.com/1bfd52f80ca7dafa36cd669de4c6cd67)

