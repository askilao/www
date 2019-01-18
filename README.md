# WWW-Teknologi repository
Created by Askil Olsen

Dockerfile is used to create Xampp docker container
To run do:
* Install Docker for debian/Ubuntu
 * `sudo curl -sSL https://get.docker.com/ | sh`
* Build image from Docker file
 * `sudo docker build /path/to/Dockerfile`
* Start container
 * `sudo docker run --name myXampp -p 41061:22 -p 41062:80 -d -v ~/my_web_pages:/www <NAME/ID OF IMAGE>`
 * If you dont know the ID run `sudo docker image ls` to find the image you just created

You will now have a container running Xampp, to see the Xampp page go to **http://\<IPOFSERVER\>:41062/** <br>
To see the website go to **http://\<IPOFSERVER\>:41062/www** <br>

*The content of the website is in the www/ folder in the container, this is what you mapped the folder /my\_web\_pages to, if you want another folder for your websites then edit the part in the docker run command.*

The Dockerfile is based on [tomsik68/dockerxampp](https://github.com/tomsik68/docker-xampp)
