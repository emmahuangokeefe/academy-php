Catalyst IT academy
===================

Here is the complete code for the PHP tutorial. This should serve as an
introduction to PHP, but is not meant to be secure code. There are numerous
exploits in the code ;)

Database restore
----------------

$ mysql -u root

    DROP DATABASE IF EXISTS movie;
    CREATE DATABASE movie;
    CREATE USER movie@localhost IDENTIFIED BY 'password';
    GRANT ALL PRIVILEGES ON movie.* TO movie@localhost;
    \q

$ mysql -u movie -p movie

    CREATE TABLE movies (
      id     INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
      name   VARCHAR(100) NOT NULL UNIQUE,
      length INTEGER
    );

    CREATE TABLE people (
      id    INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
      name  VARCHAR(100) NOT NULL UNIQUE
    );

    CREATE TABLE votes (
      id         INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
      person_id  INTEGER NOT NULL ,
      movie_id   INTEGER NOT NULL,
      CONSTRAINT person_fk FOREIGN KEY (person_id) REFERENCES people(id),
      CONSTRAINT movie_fk FOREIGN KEY (movie_id) REFERENCES movies(id),
      CONSTRAINT votes_once UNIQUE (person_id, movie_id)
    );

Add a new movie
---------------

$ mysql -u movie -p movie

    INSERT INTO `movie`.`movies` (`id`, `name`, `length`) VALUES (NULL, 'The Matrix', '150');
    INSERT INTO `movie`.`movies` (`id`, `name`, `length`) VALUES (NULL, 'The Matrix Reloaded', '138');
    INSERT INTO `movie`.`movies` (`id`, `name`, `length`) VALUES (NULL, 'The Matrix Revolutions', '129');

Add a new person
----------------

$ mysql -u movie -p movie

    INSERT INTO `movie`.`people` (`id`, `name`) VALUES (NULL, 'Alice');
    INSERT INTO `movie`.`people` (`id`, `name`) VALUES (NULL, 'Bob');
    INSERT INTO `movie`.`people` (`id`, `name`) VALUES (NULL, 'Charlie');
