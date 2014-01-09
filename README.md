Catalyst IT academy
===================

Here is the complete code for the PHP tutorial. This should serve as an
introduction to PHP, but is not meant to be secure code. There are numerous
exploits in the code ;)

Database restore
----------------

$ sudo -u postgres psql

postgres # DROP DATABASE movie;
DROP DATABASE

postgres # CREATE DATABASE movie OWNER movie;
CREATE DATABASE

\q

$ sudo -u postgres psql -f setup/Movie.dump movie

Add a new movie
---------------

$ psql -Umovie movie

movie=# INSERT INTO movies (title, genre, location) VALUES ('The Fast and the Furious','Action','Lighthouse Cinema');
INSERT 0 1
