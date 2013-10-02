#
# Table structure for table 'tx_devnullevents_event'
#
CREATE TABLE tx_devnullevents_event (
	uid int(11) NOT NULL auto_increment,
	pid int(11) NOT NULL DEFAULT '0',
	tstamp int(11) NOT NULL DEFAULT '0',
	crdate int(11) NOT NULL DEFAULT '0',
	cruser_id int(11) NOT NULL DEFAULT '0',
	deleted tinyint(4) NOT NULL DEFAULT '0',
	hidden tinyint(4) NOT NULL DEFAULT '0',
	parentid int(11) NOT NULL DEFAULT '0',
	label varchar(50) NOT NULL DEFAULT '',
	title tinytext NOT NULL,
	teaser text NOT NULL,
	descr text NOT NULL,
	location int(11) unsigned DEFAULT '0' NOT NULL,
	organizer int(11) unsigned DEFAULT '0' NOT NULL,
	instructor int(11) unsigned DEFAULT '0' NOT NULL,
	cat int(11) NOT NULL DEFAULT '0',
	schedules int(11) NOT NULL DEFAULT '0',
	colorbkg tinytext NOT NULL,
	colortxt tinytext NOT NULL,
	PRIMARY KEY (uid),
	INDEX parent (pid)
);

CREATE TABLE tx_devnullevents_event_partner_mm (
	uid_local int(11) NOT NULL DEFAULT '0',
	uid_foreign int(11) NOT NULL DEFAULT '0',
	linkjoin varchar(60) NOT NULL DEFAULT '',
	sorting int(11) NOT NULL DEFAULT '0',
	INDEX uid_local (uid_local),
	INDEX uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_devnullevents_event_cat_mm'
# 
#
CREATE TABLE tx_devnullevents_event_cat_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  ident varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign),
  KEY ident (ident)
);

#
# Table structure for table 'tx_devnullevents_cat'
#
CREATE TABLE tx_devnullevents_cat (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	parentid int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	description text,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);


#
# Table structure for table 'tx_devnullevents_schedule'
#
CREATE TABLE tx_devnullevents_schedule (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	parentid int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	descr text NOT NULL,
	location int(11) unsigned DEFAULT '0' NOT NULL,
	organizer int(11) unsigned DEFAULT '0' NOT NULL,
	instructor int(11) unsigned DEFAULT '0' NOT NULL,
	fullday tinyint(4) DEFAULT '0' NOT NULL,
	sh_startdate int(11) DEFAULT '0' NOT NULL,
	sh_starttime int(11) DEFAULT '0' NOT NULL,
	sh_enddate int(11) DEFAULT '0' NOT NULL,
	sh_endtime int(11) DEFAULT '0' NOT NULL,
	colorbkg tinytext NOT NULL,
	colortxt tinytext NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_devnullevents_text'
#
CREATE TABLE tx_devnullevents_text (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	descr text NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);
