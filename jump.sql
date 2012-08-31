/** DB CHANGES SINCE LAST UPDATE TO LIVE 
***
*** 
**/

CREATE TABLE `photos` (
	id int(11) NOT NULL auto_increment,
	user_id int(11) NOT NULL,
	photopath varchar(140) NOT NULL,
	caption varchar(140) NOT NULL DEFAULT "",
	photodate date NOT NULL,
	created datetime NOT NULL,
	updated datetime NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;