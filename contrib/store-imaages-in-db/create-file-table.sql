CREATE TABLE imagemetadata (
id mediumint(8) unsigned NOT NULL auto_increment,
pid varchar(120) NOT NULL default '',
groupname varchar(120) NOT NULL default '',
user varchar(120) NOT NULL default '',
authorized varchar(120) NOT NULL default '',
activity varchar(120) NOT NULL default '',
description varchar(120) NOT NULL default '',
ordering_practitioner varchar(120) NOT NULL default '',
category varchar(120) NOT NULL default '',
datatype varchar(60) NOT NULL default 'application/octet-stream',
name varchar(120) NOT NULL default '',
size bigint(20) unsigned NOT NULL default '1024',
filedate datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY (id) ) TYPE=MyISAM;

CREATE TABLE imagedata (
id mediumint(8) unsigned NOT NULL auto_increment,
masterid mediumint(8) unsigned NOT NULL default '0',
filedata mediumblob NOT NULL,
PRIMARY KEY (id),
KEY master_idx (masterid) ) TYPE=InnoDB;
