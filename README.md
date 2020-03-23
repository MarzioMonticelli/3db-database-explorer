# 3db - Explore database structure in a 3D environment.  
> A simple web application integrating an experimental WebGL database explorer written using three.js. 
It was developed by Marzio Monticelli as final project for the course of Interactive Graphics (academic year 2017/2018) at Sapienza, University of Rome. 

![](preview.png)

The project is based on the idea to develop a 3D Web Service to manage databases and see a 3D representation of the data space through simply web interfaces. 

## Installation

Create a folder called 3dB in the root directory of your local server. The local path to the folder you have just created should look like:

```sh
C:\Programs\Apache\htdocs\3dB
```

than copy the content of this reposity in the created folder. 
Finally open your MySql panel and create a new dabase called

```sh
3dbcentral
```

importing in it the database you can found in the documentation folder (3dbcentral.sql).
That's it.

If the installation was successful you should be able to see the welcome page at:

```sh
http://localhost/3dB/
```


## Usage example

To make the access to the admin panel and see the experimental 3D experience you can use the following credentials:

```sh
email: admin@example.com
password: password
```


## Release History

* 0.1.0
    * The first proper release
    * The project is for presentation prupose only.
    * There will be no further releases at the moment

## Meta

Marzio Monticelli – marzio.monticelli@gmail.com

Distributed under the MIT license. See ``LICENSE`` for more information.

[https://github.com/MarzioMonticelli/3db](https://github.com/MarzioMonticelli/3db/)