editoreye
=========

to run the application, you should install memcached

Step 1.
$ sudo apt-get install memcached 
Step 2. 
$ sudo apt-get install php5-memcached 
Step 3. 
$ sudo /etc/init.d/apache2 restart 

to schedule the command to run every 10 minutes

step 1
$ crontab -e
step 2, add this to the file with edited path
10 * * * * /usr/bin/php /path/to/Projects/editoreye/bin/console  weather london

Create a small Symfony2 app, no web front-end is needed only a Console

The app should have a single command, which calls the Yahoo Weather API or some equivalent to retrieve the current weather in a single location

e.g. for London from Yahoo: 

````
https://query.yahooapis.com/v1/public/yql?q=select%20item.condition%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22London%2C%20UK%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys
````

If the weather (either temperature or conditions) has changed since it was last called, it should fire an event.

An EventListener, which on seeing a change in either the temperature or conditions, should publish a message with information describing the change (e.g. temperature has risen/fallen from X to Y). In a real-world scenario this message might be published to AWS SNS, this test could use a service which mimics that.

This command should be scheduled to run every 10 minutes.
