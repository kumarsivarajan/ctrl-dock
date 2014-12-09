/*Table structure for table `office_locations` */

DROP TABLE IF EXISTS `office_locations`;

CREATE TABLE `office_locations` (
  `office_index` int(10) NOT NULL auto_increment,
  `address` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `showhide` tinyint(1) NOT NULL default 1,
  PRIMARY KEY  (`office_index`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `office_locations` */

insert  into `office_locations`(`office_index`,`address`,`country`,`phone`,`fax`) values (1,'ABC STREET','INDIA','+91 12 3456 7890','+91 12 4567 8901');

/*Table structure for table `services` */

DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `service` varchar(255) NOT NULL default '',
  `comments` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `service_properties` */

CREATE TABLE `service_properties` (
  `service` varchar(255) default NULL,
  `type` varchar(50) default NULL,
  `url` varchar(255) default NULL,
  `port` varchar(255) default NULL,
  `username` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `domain` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `service_type` */

CREATE TABLE `service_type` (
  `service_type` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/*Data for the table `service_type` */

insert into `service_type` (`service_type`) values('RDP');
insert into `service_type` (`service_type`) values('SSH');
insert into `service_type` (`service_type`) values('TELNET');
insert into `service_type` (`service_type`) values('WEB');


/*Table structure for table `user_master` */

DROP TABLE IF EXISTS `user_master`;

CREATE TABLE `user_master` (
  `username` varchar(255) NOT NULL default '',
  `password` varchar(255) default NULL,
  `staff_number` varchar(255) default NULL,
  `first_name` varchar(255) default NULL,
  `last_name` varchar(255) default NULL,
  `contact_phone_office` varchar(255) default NULL,
  `contact_phone_residence` varchar(255) default NULL,
  `contact_phone_mobile` varchar(255) default NULL,
  `contact_address` varchar(255) default NULL,
  `permanent_address` varchar(255) default NULL,
  `office_index` int(10) default NULL,
  `official_email` varchar(255) default NULL,
  `personal_email` varchar(255) default NULL,
  `account_type` varchar(255) default NULL,
  `account_status` varchar(255) default NULL,
  `account_expiry` varchar(255) default NULL,
  `account_created_on` varchar(255) default NULL,
  `account_created_by` varchar(255) default NULL,
  `agency_index` int(10) default '1',
  `business_group_index` int(10) default '1',
  `grade_id` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `user_master` */

insert  into `user_master`(`username`,`password`,`staff_number`,`first_name`,`last_name`,`contact_phone_office`,`contact_phone_residence`,`contact_phone_mobile`,`contact_address`,`permanent_address`,`office_index`,`official_email`,`personal_email`,`account_type`,`account_status`,`account_expiry`,`account_created_on`,`account_created_by`,`agency_index`,`business_group_index`) values ('administrator','administrator','ADMIN','System','Administrator',NULL,NULL,NULL,NULL,NULL,1,'administrator',NULL,'service_account','Active','',NULL,NULL,1,1);

/*Table structure for table `user_organization` */

DROP TABLE IF EXISTS `user_organization`;

CREATE TABLE `user_organization` (
  `username` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `direct_report_to` varchar(255) default NULL,
  `dot_report_to` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/*Table structure for table `broadcast` */

DROP TABLE IF EXISTS `broadcast`;

CREATE TABLE `broadcast` (
  `broadcast_id` int(100) NOT NULL auto_increment,
  `broadcast_to` varchar(255) default NULL,
  `broadcast_subject` varchar(255) default NULL,
  `broadcast_msg` blob,
  `broadcast_date` int(255) default NULL,
  `username` varchar(255) default NULL,
  `attachment_path` varchar(255) default NULL,
  PRIMARY KEY  (`broadcast_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `quicklinks` */

DROP TABLE IF EXISTS `quick_links`;

CREATE TABLE `quick_links` (
  `link_id` int(10) NOT NULL auto_increment,
  `link` varchar(255) default NULL,
  `link_name` varchar(50) default NULL,
  `link_priority` int(10) default NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

insert  into `quick_links`(`link_id`,`link`,`link_name`,`link_priority`) values ('1','downloads/RIMAUDIT_WIN.zip','RIMAUDIT - WIN','100');
insert  into `quick_links`(`link_id`,`link`,`link_name`,`link_priority`) values ('2','downloads/RIMAUDIT_LINUX.zip','RIMAUDIT - LINUX','101');


/*Table structure for table `account_status` */

DROP TABLE IF EXISTS `account_status`;

CREATE TABLE `account_status` (
  `account_status` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `account_status` */

insert  into `account_status`(`account_status`) values ('Active');
insert  into `account_status`(`account_status`) values ('Disabled');
insert  into `account_status`(`account_status`) values ('Obsolete');

/*Table structure for table `account_type` */

DROP TABLE IF EXISTS `account_type`;

CREATE TABLE `account_type` (
  `account_type` varchar(255) default NULL,
  `description` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `account_type` */

insert  into `account_type`(`account_type`,`description`) values ('employee','Employee');
insert  into `account_type`(`account_type`,`description`) values ('contingent_staff','Contingent Staff');
insert  into `account_type`(`account_type`,`description`) values ('external_user','External User');
insert  into `account_type`(`account_type`,`description`) values ('service_account','Service Account');

/*Table structure for table `agency` */

DROP TABLE IF EXISTS `agency`;

CREATE TABLE `agency` (
  `agency_index` int(10) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `type` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `contact_phone` varchar(255) default NULL,
  `contact_fax` varchar(255) default NULL,
  `contact_email` varchar(255) default NULL,
  `prim_contact` varchar(255) default NULL,
  `prim_phone` varchar(255) default NULL,
  `prim_email` varchar(255) default NULL,
  `sec_contact` varchar(255) default NULL,
  `sec_phone` varchar(255) default NULL,
  `sec_email` varchar(255) default NULL,  
  `comments` varchar(255) default NULL,
  `payment_terms` varchar(255) default NULL,
  `bank_info` varchar(255) default NULL,
  `latitude` float(50) default NULL,
  `longitude` float(50) default NULL,
  PRIMARY KEY  (`agency_index`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Data for the table `agency` */

insert  into `agency`(`agency_index`,`name`,`type`,`address`,`contact_phone`,`contact_fax`,`contact_email`,`prim_contact`,`prim_phone`,`prim_email`,`sec_contact`,`sec_phone`,`sec_email`) values (1,'Internal','vendor','NA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `agency_type` */

DROP TABLE IF EXISTS `agency_type`;

CREATE TABLE `agency_type` (
  `agency_type` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `agency_type` */

insert  into `agency_type`(`agency_type`) values ('Client');
insert  into `agency_type`(`agency_type`) values ('Consultant');
insert  into `agency_type`(`agency_type`) values ('Vendor');

/*Table structure for table `asset` */

DROP TABLE IF EXISTS `asset`;

CREATE TABLE `asset` (
  `assetid` int(11) NOT NULL auto_increment,
  `assetcategoryid` int(10) NOT NULL default '0',
  `statusid` int(10) NOT NULL default '0',
  `agencyid` int(10) NOT NULL default '0',
  `model` varchar(30) default NULL,
  `serialno` varchar(30) default NULL,
  `employee` varchar(255) default NULL,
  `invoiceno` varchar(30) default NULL,
  `invoicedate` varchar(30) default NULL,
  `invoiceamount` varchar(30) default NULL,
  `comments` varchar(200) default NULL,
  `hostname` varchar(50) default NULL,
  `office_index` int(10) default NULL,
  `location_desc` varchar(255) default NULL,
  `rentalinfo` varchar(10) NOT NULL default 'No',
  `rentalreference` varchar(20) default NULL,
  `rentalstartdate` varchar(30) default NULL,
  `rentalenddate` varchar(30) default NULL,
  `rentalvalue` varchar(30) default NULL,
  `assetidentifier` varchar(25) default NULL,
  `ipaddress` varchar(50) default NULL,
  `auditstatus` tinyint(1) NOT NULL default '1',
  `assigned_type` varchar(50) default 'employee',
  `assigned_agency` varchar(50) default NULL,
  `assigned_bg` varchar(50) default NULL,
  `parent_assetid` varchar(50) default '0',
  `paymentref` varchar(255) default NULL,
  `po_date` varchar(30) default '',
  `po_num` varchar(30) default '',
  PRIMARY KEY  (`assetid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `asset` */

/*Table structure for table `assetcategory` */

DROP TABLE IF EXISTS `assetcategory`;

CREATE TABLE `assetcategory` (
  `assetcategoryid` int(10) NOT NULL auto_increment,
  `assetcategory` varchar(50) NOT NULL,
  PRIMARY KEY  (`assetcategoryid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `assetcategory` */

insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (1,'Desktop');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (2,'Laptop');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (3,'Keyboard');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (4,'Mouse');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (5,'Monitor');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (6,'Camera');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (7,'Web Camera');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (8,'Modem');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (9,'Data Card');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (10,'Phone');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (11,'Cell Phone');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (12,'SIM');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (13,'UPS');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (14,'Printer / Fax');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (15,'Network Switch');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (16,'Network Router');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (17,'Wireless Access Point');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (18,'Firewall');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (19,'Server-Tower');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (20,'Server-RackMount');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (21,'External Power Supply');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (22,'External Hard Disk');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (23,'External DVD');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (24,'Projector');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (25,'Cloud Service');
insert  into `assetcategory`(`assetcategoryid`,`assetcategory`) values (26,'Virtual Host');

/*Table structure for table `assetlogs` */

DROP TABLE IF EXISTS `assetlogs`;

CREATE TABLE `assetlogs` (
  `assetid` int(11) default NULL,
  `modification_by` varchar(50) default NULL,
  `employee` varchar(255) default NULL,
  `modification_date` varchar(50) default NULL,
  `modification_time` varchar(50) default NULL,
  `statusid` int(10) default NULL,
  `invoiceno` varchar(30) default NULL,
  `assetcategoryid` int(10) default NULL,
  `agencyid` int(10) default NULL,
  `model` varchar(50) default NULL,
  `serialno` varchar(50) default NULL,
  `invoicedate` varchar(50) default NULL,
  `invoiceamount` varchar(50) default NULL,
  `comments` varchar(200) default NULL,
  `hostname` varchar(50) default NULL,
  `rentalinfo` varchar(10) NOT NULL default 'No',
  `rentalreference` varchar(20) default NULL,
  `rentalstartdate` varchar(30) default NULL,
  `rentalenddate` varchar(30) default NULL,
  `rentalvalue` varchar(30) default NULL,
  `assetidentifier` varchar(25) default NULL,
  `ipaddress` varchar(50) default NULL,
  `auditstatus` tinyint(1) NOT NULL default '1',
  `assigned_type` varchar(50) default 'employee',
  `assigned_agency` varchar(50) default NULL,
  `assigned_bg` varchar(50) default NULL,
  `parent_assetid` varchar(50) default '0',
  `paymentref` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `assetlogs` */

/*Table structure for table `assetstatus` */

DROP TABLE IF EXISTS `assetstatus`;

CREATE TABLE `assetstatus` (
  `statusid` int(10) NOT NULL auto_increment,
  `status` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`statusid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `assetstatus` */

insert  into `assetstatus`(`statusid`,`status`) values (1,'Active');
insert  into `assetstatus`(`statusid`,`status`) values (2,'In-Active');
insert  into `assetstatus`(`statusid`,`status`) values (3,'Lost');
insert  into `assetstatus`(`statusid`,`status`) values (4,'Damaged / Not-Working');
insert  into `assetstatus`(`statusid`,`status`) values (5,'None');
insert  into `assetstatus`(`statusid`,`status`) values (6,'Obsolete');

/*Table structure for table `business_groups` */

DROP TABLE IF EXISTS `business_groups`;

CREATE TABLE `business_groups` (
  `business_group_index` int(10) NOT NULL auto_increment,
  `business_group` varchar(255) default NULL,
  `prefix` varchar(10) default NULL,
  PRIMARY KEY  (`business_group_index`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `business_groups` */

insert  into `business_groups`(`business_group_index`,`business_group`) values (1,'Information Systems');
insert  into `business_groups`(`business_group_index`,`business_group`) values (2,'Finance');
insert  into `business_groups`(`business_group_index`,`business_group`) values (3,'Human Resources');
insert  into `business_groups`(`business_group_index`,`business_group`) values (4,'Administration');
insert  into `business_groups`(`business_group_index`,`business_group`) values (5,'Sales');
insert  into `business_groups`(`business_group_index`,`business_group`) values (6,'Marketing');
insert  into `business_groups`(`business_group_index`,`business_group`) values (7,'Engineering');
insert  into `business_groups`(`business_group_index`,`business_group`) values (8,'QA');
insert  into `business_groups`(`business_group_index`,`business_group`) values (9,'Operations');
insert  into `business_groups`(`business_group_index`,`business_group`) values (10,'Service Delivery');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `group_id` int(10) NOT NULL auto_increment,
  `group_name` varchar(50) default NULL,
  `group_description` varchar(255) default NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `groups` */
insert into `groups` (`group_id`,`group_name`,`group_description`) values ('1','ADMINISTRATORS','ADMINISTRATORS');

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `group_id` int(10) default NULL,
  `username` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `user_group` */
insert into `user_group` (`group_id`,`username`) values ('1','administrator');


/*Table structure for table `group_service` */

DROP TABLE IF EXISTS `group_service`;

CREATE TABLE `group_service` (
  `group_id` int(10) default NULL,
  `service` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



/*Table structure for table `isost_api_key` */

DROP TABLE IF EXISTS `isost_api_key`;

CREATE TABLE `isost_api_key` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `isactive` tinyint(1) NOT NULL default '1',
  `ipaddr` varchar(16) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ipaddr` (`ipaddr`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_api_key` */

insert  into `isost_api_key`(`id`,`isactive`,`ipaddr`,`apikey`,`updated`,`created`) values (1,1,'192.168.1.5','siri!','2010-09-20 16:14:57','2010-09-20 16:14:57');

/*Table structure for table `isost_config` */

DROP TABLE IF EXISTS `isost_config`;

CREATE TABLE `isost_config` (
  `id` tinyint(1) unsigned NOT NULL auto_increment,
  `isonline` tinyint(1) unsigned NOT NULL default '0',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `enable_daylight_saving` tinyint(1) unsigned NOT NULL default '0',
  `staff_ip_binding` tinyint(1) unsigned NOT NULL default '1',
  `staff_max_logins` tinyint(3) unsigned NOT NULL default '4',
  `staff_login_timeout` int(10) unsigned NOT NULL default '2',
  `staff_session_timeout` int(10) unsigned NOT NULL default '30',
  `client_max_logins` tinyint(3) unsigned NOT NULL default '4',
  `client_login_timeout` int(10) unsigned NOT NULL default '2',
  `client_session_timeout` int(10) unsigned NOT NULL default '30',
  `max_page_size` tinyint(3) unsigned NOT NULL default '25',
  `max_open_tickets` tinyint(3) unsigned NOT NULL default '0',
  `max_file_size` int(11) unsigned NOT NULL default '1048576',
  `autolock_minutes` tinyint(3) unsigned NOT NULL default '3',
  `overdue_grace_period` int(10) unsigned NOT NULL default '0',
  `alert_email_id` tinyint(4) unsigned NOT NULL default '0',
  `default_email_id` tinyint(4) unsigned NOT NULL default '0',
  `default_dept_id` tinyint(3) unsigned NOT NULL default '0',
  `default_priority_id` tinyint(2) unsigned NOT NULL default '2',
  `default_template_id` tinyint(4) unsigned NOT NULL default '1',
  `default_smtp_id` tinyint(4) unsigned NOT NULL default '0',
  `spoof_default_smtp` tinyint(1) unsigned NOT NULL default '0',
  `clickable_urls` tinyint(1) unsigned NOT NULL default '1',
  `allow_priority_change` tinyint(1) unsigned NOT NULL default '0',
  `use_email_priority` tinyint(1) unsigned NOT NULL default '0',
  `enable_captcha` tinyint(1) unsigned NOT NULL default '0',
  `enable_auto_cron` tinyint(1) unsigned NOT NULL default '0',
  `enable_mail_fetch` tinyint(1) unsigned NOT NULL default '0',
  `enable_email_piping` tinyint(1) unsigned NOT NULL default '0',
  `send_sql_errors` tinyint(1) unsigned NOT NULL default '1',
  `send_mailparse_errors` tinyint(1) unsigned NOT NULL default '1',
  `send_login_errors` tinyint(1) unsigned NOT NULL default '1',
  `save_email_headers` tinyint(1) unsigned NOT NULL default '1',
  `strip_quoted_reply` tinyint(1) unsigned NOT NULL default '1',
  `log_ticket_activity` tinyint(1) unsigned NOT NULL default '1',
  `ticket_autoresponder` tinyint(1) unsigned NOT NULL default '1',
  `message_autoresponder` tinyint(1) unsigned NOT NULL default '1',
  `ticket_notice_active` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_active` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_admin` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_dept_members` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_active` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_laststaff` tinyint(1) unsigned NOT NULL default '0',
  `message_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `note_alert_active` tinyint(1) unsigned NOT NULL default '1',
  `note_alert_laststaff` tinyint(1) unsigned NOT NULL default '0',
  `note_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `note_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_assigned` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_dept_members` tinyint(1) unsigned NOT NULL default '0',
  `auto_assign_reopened_tickets` tinyint(1) unsigned NOT NULL default '1',
  `show_assigned_tickets` tinyint(1) unsigned NOT NULL default '0',
  `show_answered_tickets` tinyint(1) NOT NULL default '0',
  `hide_staff_name` tinyint(1) unsigned NOT NULL default '0',
  `overlimit_notice_active` tinyint(1) unsigned NOT NULL default '0',
  `email_attachments` tinyint(1) unsigned NOT NULL default '1',
  `allow_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_email_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_online_attachments` tinyint(1) unsigned NOT NULL default '0',
  `allow_online_attachments_onlogin` tinyint(1) unsigned NOT NULL default '0',
  `random_ticket_ids` tinyint(1) unsigned NOT NULL default '1',
  `log_level` tinyint(1) unsigned NOT NULL default '2',
  `log_graceperiod` int(10) unsigned NOT NULL default '12',
  `upload_dir` varchar(255) NOT NULL default '',
  `allowed_filetypes` varchar(255) NOT NULL default '.doc, .pdf',
  `time_format` varchar(32) NOT NULL default 'H:i',
  `date_format` varchar(32) NOT NULL default 'd M y',
  `datetime_format` varchar(60) NOT NULL default 'd M y H:i',
  `daydatetime_format` varchar(60) NOT NULL default 'D d M y H:i',
  `reply_separator` varchar(60) NOT NULL default '-- do not edit --',
  `admin_email` varchar(125) NOT NULL default '',
  `helpdesk_title` varchar(255) NOT NULL default 'Support Ticket System',
  `helpdesk_url` varchar(255) NOT NULL default '',
  `api_passphrase` varchar(125) NOT NULL default '',
  `ostversion` varchar(16) NOT NULL default '',
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `isoffline` (`isonline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_config` */
INSERT INTO `isost_config` VALUES (1,1,5.5,0,0,10,10,0,4,2,30,25,0,104857600,0,0,0,1,1,2,1,1,0,1,0,0,0,0,1,1,0,1,0,0,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,0,0,0,0,1,1,1,0,0,1,1,1,1,0,0,2,3,'/data/rim/eztickets/attachments','.doc,.pdf,.txt,.xls,.html,.htm,.ppt,.rtf,.docx,.xlsx,.zip,.pptx, .log,.gif,.jpg, .jpeg','H:i','d M Y','d M Y H:i','D d M Y H:i','-- -- -- -- -- -- -- -- -- --','admin@demo.com','Help Desk','http://company.com/eztickets','','1.6 ST','2010-09-20 05:14:57');
update isost_config set ticket_notice_active=1,ticket_alert_active=1,ticket_alert_dept_members=1,message_alert_active=1,message_alert_laststaff=0,message_alert_assigned=1;
update isost_config set note_alert_active=1,note_alert_laststaff=0,note_alert_assigned=1,overdue_alert_active=0;
update isost_config set ticket_autoresponder=1,message_autoresponder=1;
/*Table structure for table `isost_department` */

DROP TABLE IF EXISTS `isost_department`;

CREATE TABLE `isost_department` (
  `dept_id` int(11) unsigned NOT NULL auto_increment,
  `tpl_id` int(10) unsigned NOT NULL default '0',
  `email_id` int(10) unsigned NOT NULL default '0',
  `autoresp_email_id` int(10) unsigned NOT NULL default '0',
  `manager_id` int(10) unsigned NOT NULL default '0',
  `dept_name` varchar(32) NOT NULL default '',
  `dept_signature` tinytext NOT NULL,
  `ispublic` tinyint(1) unsigned NOT NULL default '1',
  `ticket_auto_response` tinyint(1) NOT NULL default '1',
  `message_auto_response` tinyint(1) NOT NULL default '0',
  `can_append_signature` tinyint(1) NOT NULL default '1',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `bg_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`dept_id`),
  UNIQUE KEY `dept_name` (`dept_name`),
  KEY `manager_id` (`manager_id`),
  KEY `autoresp_email_id` (`autoresp_email_id`),
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_department` */

insert  into `isost_department`(`dept_id`,`tpl_id`,`email_id`,`autoresp_email_id`,`manager_id`,`dept_name`,`dept_signature`,`ispublic`,`ticket_auto_response`,`message_auto_response`,`can_append_signature`,`updated`,`created`,`bg_id`) values (1,0,1,0,1,'Information Systems','IT HELP DESK',1,1,1,1,'2010-12-09 13:50:27','2010-09-20 16:14:57',1);

/*Table structure for table `isost_email` */

DROP TABLE IF EXISTS `isost_email`;

CREATE TABLE `isost_email` (
  `email_id` int(11) unsigned NOT NULL auto_increment,
  `noautoresp` tinyint(1) unsigned NOT NULL default '0',
  `priority_id` tinyint(3) unsigned NOT NULL default '2',
  `dept_id` tinyint(3) unsigned NOT NULL default '0',
  `email` varchar(125) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `userid` varchar(125) NOT NULL,
  `userpass` varchar(125) NOT NULL,
  `mail_active` tinyint(1) NOT NULL default '0',
  `mail_host` varchar(125) NOT NULL,
  `mail_protocol` enum('POP','IMAP') NOT NULL default 'POP',
  `mail_encryption` enum('NONE','SSL') NOT NULL,
  `mail_port` int(6) default NULL,
  `mail_fetchfreq` tinyint(3) NOT NULL default '5',
  `mail_fetchmax` tinyint(4) NOT NULL default '30',
  `mail_delete` tinyint(1) NOT NULL default '0',
  `mail_errors` tinyint(3) NOT NULL default '0',
  `mail_lasterror` datetime default NULL,
  `mail_lastfetch` datetime default NULL,
  `smtp_active` tinyint(1) default '0',
  `smtp_host` varchar(125) NOT NULL,
  `smtp_port` int(6) default NULL,
  `smtp_secure` tinyint(1) NOT NULL default '1',
  `smtp_auth` tinyint(1) NOT NULL default '1',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`email_id`),
  UNIQUE KEY `email` (`email`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_email` */

insert  into `isost_email`(`email_id`,`noautoresp`,`priority_id`,`dept_id`,`email`,`name`,`userid`,`userpass`,`mail_active`,`mail_host`,`mail_protocol`,`mail_encryption`,`mail_port`,`mail_fetchfreq`,`mail_fetchmax`,`mail_delete`,`mail_errors`,`mail_lasterror`,`mail_lastfetch`,`smtp_active`,`smtp_host`,`smtp_port`,`smtp_secure`,`smtp_auth`,`created`,`updated`) values (1,0,2,1,'admin@demo.com','Support','','',0,'','POP','NONE',NULL,5,30,0,0,NULL,NULL,0,'',NULL,1,1,'2010-09-20 16:14:57','2010-09-20 16:14:57');


/*Table structure for table `isost_email_banlist` */

DROP TABLE IF EXISTS `isost_email_banlist`;

CREATE TABLE `isost_email_banlist` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `submitter` varchar(126) NOT NULL default '',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_email_banlist` */

insert  into `isost_email_banlist`(`id`,`email`,`submitter`,`added`) values (1,'test@example.com','System','2010-09-20 16:14:57');

/*Table structure for table `isost_email_template` */

DROP TABLE IF EXISTS `isost_email_template`;

CREATE TABLE `isost_email_template` (
  `tpl_id` int(11) NOT NULL auto_increment,
  `cfg_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(32) NOT NULL default '',
  `notes` text,
  `ticket_autoresp_subj` varchar(255) NOT NULL default '',
  `ticket_autoresp_body` text NOT NULL,
  `ticket_notice_subj` varchar(255) NOT NULL,
  `ticket_notice_body` text NOT NULL,
  `ticket_alert_subj` varchar(255) NOT NULL default '',
  `ticket_alert_body` text NOT NULL,
  `message_autoresp_subj` varchar(255) NOT NULL default '',
  `message_autoresp_body` text NOT NULL,
  `message_alert_subj` varchar(255) NOT NULL default '',
  `message_alert_body` text NOT NULL,
  `note_alert_subj` varchar(255) NOT NULL,
  `note_alert_body` text NOT NULL,
  `assigned_alert_subj` varchar(255) NOT NULL default '',
  `assigned_alert_body` text NOT NULL,
  `ticket_overdue_subj` varchar(255) NOT NULL default '',
  `ticket_overdue_body` text NOT NULL,
  `ticket_overlimit_subj` varchar(255) NOT NULL default '',
  `ticket_overlimit_body` text NOT NULL,
  `ticket_reply_subj` varchar(255) NOT NULL default '',
  `ticket_reply_body` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`tpl_id`),
  KEY `cfg_id` (`cfg_id`),
  FULLTEXT KEY `message_subj` (`ticket_reply_subj`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_email_template` */

insert into `isost_email_template` (`tpl_id`, `cfg_id`, `name`, `notes`, `ticket_autoresp_subj`, `ticket_autoresp_body`, `ticket_notice_subj`, `ticket_notice_body`, `ticket_alert_subj`, `ticket_alert_body`, `message_autoresp_subj`, `message_autoresp_body`, `message_alert_subj`, `message_alert_body`, `note_alert_subj`, `note_alert_body`, `assigned_alert_subj`, `assigned_alert_body`, `ticket_overdue_subj`, `ticket_overdue_body`, `ticket_overlimit_subj`, `ticket_overlimit_body`, `ticket_reply_subj`, `ticket_reply_body`, `created`, `updated`) values('1','1','ezTicket Default Template','Default ezTicket templates',' [#%ticket] Support Ticket Opened','%name,\r\n\r\nA request for support has been created and assigned ticket #%ticket. A representative will follow-up with you as soon as possible.\r\n\r\nYou can view this ticket\'s progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\nIf you wish to send additional comments or information regarding this issue, please don\'t open a new ticket. Simply login using the link above and update the ticket.\r\n\r\n%signature','[#%ticket] %subject','%name,\r\n\r\nOur customer care team has created a ticket, #%ticket on your behalf, with the following message.\r\n\r\n%message\r\n\r\nIf you wish to provide additional comments or information regarding this issue, please don\'t open a new ticket. You can update or view this ticket\'s progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\n%signature','#%ticket : New Ticket','%staff,\r\n\r\nNew ticket #%ticket created by %name \r\n-------------------\r\n%message\r\n-------------------\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\nIT HELP DESK','[#%ticket] Message Added','%name,\r\n\r\nYour reply to support request #%ticket has been noted.\r\n\r\nYou can view this support request progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\n%signature','#%ticket : New Message','%staff,\r\n\r\nMessage appended to #%ticket by %name \r\n-------------------\r\n%message\r\n-------------------\r\n\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\nIT HELP DESK','#%ticket : Internal Note','%staff,\r\n\r\nInternal note appended to ticket #%ticket\r\n-------------------\r\n%note\r\n-------------------\r\n\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\nIT HELP DESK','Ticket #%ticket Assigned to you','%assignee,\r\n\r\n%assigner has assigned ticket #%ticket to you!\r\n-------------------\r\n%message\r\n-------------------\r\n\r\nTo view complete details, simply login to the support system.\r\n\r\nIT HELP DESK','Stale Ticket Alert','%staff,\r\n\r\nA ticket, #%ticket assigned to you or in your department is overdue.\r\n\r\n%url/scp/tickets.php?id=%id\r\n\r\nIT HELP DESK','Support Ticket Denied','%name\r\n\r\nNo support ticket has been created. You\'ve exceeded maximum number of open tickets allowed.\r\n\r\nThis is a temporary block. To be able to open another ticket, one of your pending tickets must be closed. To update or add comments to an open ticket simply login using the link below.\r\n\r\n%url/view.php?e=%email\r\n\r\nThank you.\r\n\r\nSupport Ticket System','[#%ticket] %subject','%name,\r\n\r\nA customer support staff member has replied to your support request, #%ticket with the following response:\r\n\r\n%response\r\n\r\nWe hope this response has sufficiently answered your questions. If not, please do not send another email. Instead, reply to this email or login to your account for a complete archive of all your support requests and responses.\r\n\r\n%url/view.php?e=%email&t=%ticket\r\n\r\n%signature','2010-09-20 16:14:57','2011-04-26 17:48:32');


/*Table structure for table `isost_groups` */

DROP TABLE IF EXISTS `isost_groups`;

CREATE TABLE `isost_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `group_enabled` tinyint(1) unsigned NOT NULL default '1',
  `group_name` varchar(50) NOT NULL default '',
  `dept_access` varchar(255) NOT NULL default '',
  `can_create_tickets` tinyint(1) unsigned NOT NULL default '1',
  `can_edit_tickets` tinyint(1) unsigned NOT NULL default '1',
  `can_delete_tickets` tinyint(1) unsigned NOT NULL default '0',
  `can_close_tickets` tinyint(1) unsigned NOT NULL default '0',
  `can_transfer_tickets` tinyint(1) unsigned NOT NULL default '1',
  `can_ban_emails` tinyint(1) unsigned NOT NULL default '0',
  `can_manage_kb` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `bg_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  KEY `group_active` (`group_enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_groups` */

insert  into `isost_groups`(`group_id`,`group_enabled`,`group_name`,`dept_access`,`can_create_tickets`,`can_edit_tickets`,`can_delete_tickets`,`can_close_tickets`,`can_transfer_tickets`,`can_ban_emails`,`can_manage_kb`,`created`,`updated`,`bg_id`) values (1,1,'Information Systems - Staff',1,1,1,0,1,1,0,1,'2010-09-20 16:14:57','2010-09-20 16:14:57',1);
/*Table structure for table `isost_help_topic` */

DROP TABLE IF EXISTS `isost_help_topic`;

CREATE TABLE `isost_help_topic` (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `isactive` tinyint(1) unsigned NOT NULL default '1',
  `noautoresp` tinyint(3) unsigned NOT NULL default '0',
  `priority_id` tinyint(3) unsigned NOT NULL default '0',
  `dept_id` tinyint(3) unsigned NOT NULL default '0',
  `topic` varchar(40) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `parent_topic_id` int(11) default '0',
  `ticket_type_id` tinyint(3) default '1',
  PRIMARY KEY  (`topic_id`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `isost_help_topic` */

insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (1,1,0,2,1,'Antivirus','2010-12-11 08:03:20','2010-12-11 08:03:20','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (2,1,0,2,1,'EMail','2010-12-11 08:03:01','2010-12-11 08:03:01','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (3,1,0,2,1,'Office Suite','2010-12-11 08:02:39','2010-12-11 08:02:39','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (4,1,0,2,1,'Drivers','2010-12-11 08:02:16','2010-12-11 08:02:16','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (5,1,0,2,1,'Operating System','2010-12-11 08:01:53','2010-12-11 08:01:53','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (6,1,0,2,1,'Hardware','2010-12-11 08:01:36','2010-12-11 08:01:36','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (7,1,0,2,1,'Applications','2010-12-11 08:03:39','2010-12-11 08:03:39','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (8,1,0,2,1,'Instant Messaging','2010-12-11 08:04:06','2010-12-11 08:04:06','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (9,1,0,3,1,'Backup','2010-12-11 08:04:25','2010-12-11 08:04:25','30');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (10,1,0,3,1,'Hardware','2010-12-11 08:06:04','2010-12-11 08:06:04','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (11,1,0,3,1,'Operating System','2010-12-11 08:06:30','2010-12-11 08:06:30','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (12,1,0,3,1,'Drivers','2010-12-11 08:06:47','2010-12-11 08:06:47','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (13,1,0,2,1,'Antivirus','2010-12-11 08:07:07','2010-12-11 08:07:07','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (14,1,0,2,1,'Configuration','2010-12-11 08:07:31','2010-12-11 08:07:31','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (15,1,0,3,1,'Troubleshooting','2010-12-11 08:07:56','2010-12-11 08:07:56','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (16,1,0,2,1,'Maintenance','2010-12-11 08:08:11','2010-12-11 08:08:11','31');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (17,1,0,2,1,'Projection Systems','2010-12-11 08:08:39','2010-12-11 08:08:39','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (18,1,0,2,1,'Conferencing Systems','2010-12-11 08:08:52','2010-12-11 08:08:52','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (19,1,0,2,1,'Website / Portal Management','2010-12-11 08:09:08','2010-12-11 08:09:08','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (20,1,0,2,1,'User / Account Management','2010-12-11 08:09:31','2010-12-11 08:09:31','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (21,1,0,2,1,'Internet Service Provider','2010-12-11 08:09:53','2010-12-11 08:09:53','32');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (22,1,0,2,1,'Wireless','2010-12-11 08:10:09','2010-12-11 08:10:09','32');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (23,1,0,2,1,'VPN','2010-12-11 08:10:26','2010-12-11 08:10:26','32');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (24,1,0,2,1,'Configuration','2010-12-11 08:10:58','2010-12-11 08:10:58','32');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (25,1,0,2,1,'Information / Documentation','2010-12-11 08:11:35','2010-12-11 08:11:35','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (26,1,0,2,1,'Vendor Management','2010-12-11 08:11:59','2010-12-11 08:11:59','0');
insert  into `isost_help_topic`(`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values (27,1,0,2,1,'Miscellaneous','2010-12-11 08:12:14','2010-12-11 08:12:14','0');
insert into `isost_help_topic` (`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values(28,1,0,4,1,'System Alert','2011-04-27 14:50:19','2011-04-27 14:50:19','0');
insert into `isost_help_topic` (`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values(29,1,0,2,1,'Scheduled Activity','2011-04-27 14:50:19','2011-04-27 14:50:19','0');
insert into `isost_help_topic` (`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values(30,1,0,2,1,'Desktop / Laptop','2011-04-27 14:50:19','2011-04-27 14:50:19','0');
insert into `isost_help_topic` (`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values(31,1,0,2,1,'Server','2011-04-27 14:50:19','2011-04-27 14:50:19','0');
insert into `isost_help_topic` (`topic_id`,`isactive`,`noautoresp`,`priority_id`,`dept_id`,`topic`,`created`,`updated`,`parent_topic_id`) values(32,1,0,2,1,'Network','2011-04-27 14:50:19','2011-04-27 14:50:19','0');

/*Table structure for table `isost_kb_premade` */

DROP TABLE IF EXISTS `isost_kb_premade`;

CREATE TABLE `isost_kb_premade` (
  `premade_id` int(10) unsigned NOT NULL auto_increment,
  `dept_id` int(10) unsigned NOT NULL default '0',
  `isenabled` tinyint(1) unsigned NOT NULL default '1',
  `title` varchar(125) NOT NULL default '',
  `answer` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`premade_id`),
  UNIQUE KEY `title_2` (`title`),
  KEY `dept_id` (`dept_id`),
  KEY `active` (`isenabled`),
  FULLTEXT KEY `title` (`title`,`answer`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `isost_kb_premade` */

/*Table structure for table `isost_staff` */

DROP TABLE IF EXISTS `isost_staff`;

CREATE TABLE `isost_staff` (
  `staff_id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '0',
  `username` varchar(255) NOT NULL default '',
  `firstname` varchar(32) default NULL,
  `lastname` varchar(32) default NULL,
  `passwd` varchar(128) default NULL,
  `email` varchar(128) default NULL,
  `phone` varchar(24) NOT NULL default '',
  `phone_ext` varchar(6) default NULL,
  `mobile` varchar(24) NOT NULL default '',
  `signature` tinytext NOT NULL,
  `isactive` tinyint(1) NOT NULL default '1',
  `isadmin` tinyint(1) NOT NULL default '0',
  `isvisible` tinyint(1) unsigned NOT NULL default '1',
  `onvacation` tinyint(1) unsigned NOT NULL default '0',
  `daylight_saving` tinyint(1) unsigned NOT NULL default '0',
  `append_signature` tinyint(1) unsigned NOT NULL default '0',
  `change_passwd` tinyint(1) unsigned NOT NULL default '0',
  `timezone_offset` float(3,1) NOT NULL default '0.0',
  `max_page_size` int(11) unsigned NOT NULL default '0',
  `auto_refresh_rate` int(10) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastlogin` datetime default NULL,
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `new_tkt_not` tinyint(1) default '1',
  `close_tkt_not` tinyint(1) default '0',
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `username` (`username`),
  KEY `dept_id` (`dept_id`),
  KEY `issuperuser` (`isadmin`),
  KEY `group_id` (`group_id`,`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_staff` */

insert  into `isost_staff`(`staff_id`,`group_id`,`dept_id`,`username`,`firstname`,`lastname`,`passwd`,`email`,`phone`,`phone_ext`,`mobile`,`signature`,`isactive`,`isadmin`,`isvisible`,`onvacation`,`daylight_saving`,`append_signature`,`change_passwd`,`timezone_offset`,`max_page_size`,`auto_refresh_rate`,`created`,`lastlogin`,`updated`) values (1,1,1,'administrator','System','Administrator','200ceb26807d6bf99fd6f4f0d1ca54d4','rimadmin@axonnetworks.com','','','','',1,1,1,0,0,0,0,5.5,0,0,'2010-09-20 16:14:57','2010-12-13 09:55:27','2010-09-20 16:18:02');

/*Table structure for table `isost_syslog` */

DROP TABLE IF EXISTS `isost_syslog`;

CREATE TABLE `isost_syslog` (
  `log_id` int(11) unsigned NOT NULL auto_increment,
  `log_type` enum('Debug','Warning','Error') NOT NULL,
  `title` varchar(255) NOT NULL,
  `log` text NOT NULL,
  `logger` varchar(64) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`log_id`),
  KEY `log_type` (`log_type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `isost_syslog` */

insert  into `isost_syslog`(`log_id`,`log_type`,`title`,`log`,`logger`,`ip_address`,`created`,`updated`) values (1,'Debug','osTicket installed!','Congratulations osTicket basic installation completed!\n\nThank you for choosing osTicket!','','192.168.1.105','2010-09-20 16:14:57','2010-09-20 16:14:57');
insert  into `isost_syslog`(`log_id`,`log_type`,`title`,`log`,`logger`,`ip_address`,`created`,`updated`) values (2,'Warning','Failed login attempt (staff)','Username: administrator\nIP: 122.181.21.250\nTIME: Dec 9, 2010, 2:25 pm IST\n\nAttempts #2','','122.181.21.250','2010-12-09 14:25:40','2010-12-09 14:25:40');

/*Table structure for table `isost_ticket` */

DROP TABLE IF EXISTS `isost_ticket`;

CREATE TABLE `isost_ticket` (
  `ticket_id` int(11) unsigned NOT NULL auto_increment,
  `ticketID` int(11) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '1',
  `priority_id` int(10) unsigned NOT NULL default '2',
  `topic_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `email` varchar(120) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '[no subject]',
  `helptopic` varchar(255) default NULL,
  `phone` varchar(16) default NULL,
  `phone_ext` varchar(8) default NULL,
  `ip_address` varchar(16) NOT NULL default '',
  `status` enum('open','closed') NOT NULL default 'open',
  `source` enum('Web','Email','Phone','Other') NOT NULL default 'Other',
  `isoverdue` tinyint(1) unsigned NOT NULL default '0',
  `isanswered` tinyint(1) unsigned NOT NULL default '0',
  `duedate` datetime default NULL,
  `reopened` datetime default NULL,
  `closed` datetime default NULL,
  `lastmessage` datetime default NULL,
  `lastresponse` datetime default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `track_id` int(11) NOT NULL,
  `asset_id` int(11) default NULL,
  `ticket_type_id` int(10) NOT NULL default 1,
  `close_tkt_location` varchar(50),
  `poa_activity_id` int(10) default 0,
  `pending_approval` tinyint(1) default 0,
  PRIMARY KEY  (`ticket_id`),
  UNIQUE KEY `email_extid` (`ticketID`,`email`),
  KEY `dept_id` (`dept_id`),
  KEY `staff_id` (`staff_id`),
  KEY `status` (`status`),
  KEY `priority_id` (`priority_id`),
  KEY `created` (`created`),
  KEY `closed` (`closed`),
  KEY `duedate` (`duedate`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket` */

/*Table structure for table `isost_ticket_attachment` */

DROP TABLE IF EXISTS `isost_ticket_attachment`;

CREATE TABLE `isost_ticket_attachment` (
  `attach_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `ref_id` int(11) unsigned NOT NULL default '0',
  `ref_type` enum('M','R') NOT NULL default 'M',
  `file_size` varchar(32) NOT NULL default '',
  `file_name` varchar(128) NOT NULL default '',
  `file_key` varchar(128) NOT NULL default '',
  `deleted` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  PRIMARY KEY  (`attach_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `ref_type` (`ref_type`),
  KEY `ref_id` (`ref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_attachment` */

/*Table structure for table `isost_ticket_lock` */

DROP TABLE IF EXISTS `isost_ticket_lock`;

CREATE TABLE `isost_ticket_lock` (
  `lock_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `expire` datetime default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`lock_id`),
  UNIQUE KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_lock` */

/*Table structure for table `isost_ticket_message` */

DROP TABLE IF EXISTS `isost_ticket_message`;

CREATE TABLE `isost_ticket_message` (
  `msg_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `messageId` varchar(255) default NULL,
  `message` text NOT NULL,
  `headers` text,
  `source` varchar(16) default NULL,
  `ip_address` varchar(16) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  `track_id` int(11) NOT NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `msgId` (`messageId`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_message` */

/*Table structure for table `isost_ticket_merge` */

DROP TABLE IF EXISTS `isost_ticket_merge`;

CREATE TABLE IF NOT EXISTS `isost_merge` (
  `id` int(11) NOT NULL auto_increment,
  `ticket_id` varchar(500) NOT NULL,
  `track_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

/*Table structure for table `isost_ticket_note` */

DROP TABLE IF EXISTS `isost_ticket_note`;

CREATE TABLE `isost_ticket_note` (
  `note_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `source` varchar(32) NOT NULL default '',
  `title` varchar(255) NOT NULL default 'Generic Intermal Notes',
  `note` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `time_spent` int (10) default 0,
  PRIMARY KEY  (`note_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`),
  FULLTEXT KEY `note` (`note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_note` */

/*Table structure for table `isost_ticket_priority` */

DROP TABLE IF EXISTS `isost_ticket_priority`;

CREATE TABLE `isost_ticket_priority` (
  `priority_id` tinyint(4) NOT NULL auto_increment,
  `priority` varchar(60) NOT NULL default '',
  `priority_desc` varchar(30) NOT NULL default '',
  `priority_color` varchar(7) NOT NULL default '',
  `priority_urgency` tinyint(1) unsigned NOT NULL default '0',
  `ispublic` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`priority_id`),
  UNIQUE KEY `priority` (`priority`),
  KEY `priority_urgency` (`priority_urgency`),
  KEY `ispublic` (`ispublic`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_priority` */

insert  into `isost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (1,'low','LOW','#FFFF66',4,1);
insert  into `isost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (2,'normal','NORMAL','#82A0DF',3,1);
insert  into `isost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (3,'high','HIGH','#FF6600',2,1);
insert  into `isost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (4,'emergency','EMRG','#CC0000',1,0);
insert  into `isost_ticket_priority`(`priority_id`,`priority`,`priority_desc`,`priority_color`,`priority_urgency`,`ispublic`) values (5,'exception','EXCP','#00FFFF',4,0);


/*Table structure for table `isost_ticket_response` */

DROP TABLE IF EXISTS `isost_ticket_response`;

CREATE TABLE `isost_ticket_response` (
  `response_id` int(11) unsigned NOT NULL auto_increment,
  `msg_id` int(11) unsigned NOT NULL default '0',
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(11) unsigned NOT NULL default '0',
  `staff_name` varchar(32) NOT NULL default '',
  `response` text NOT NULL,
  `ip_address` varchar(16) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `time_spent` int (10) default 0,
  PRIMARY KEY  (`response_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `msg_id` (`msg_id`),
  KEY `staff_id` (`staff_id`),
  FULLTEXT KEY `response` (`response`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `isost_ticket_response` */

/*Table structure for table `isost_timezone` */

DROP TABLE IF EXISTS `isost_timezone`;

CREATE TABLE `isost_timezone` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `offset` float(3,1) NOT NULL default '0.0',
  `timezone` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `isost_timezone` */

insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (1,-12.0,'Eniwetok, Kwajalein');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (2,-11.0,'Midway Island, Samoa');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (3,-10.0,'Hawaii');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (4,-9.0,'Alaska');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (5,-8.0,'Pacific Time (US & Canada)');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (6,-7.0,'Mountain Time (US & Canada)');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (7,-6.0,'Central Time (US & Canada), Mexico City');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (8,-5.0,'Eastern Time (US & Canada), Bogota, Lima');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (9,-4.0,'Atlantic Time (Canada), Caracas, La Paz');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (10,-3.5,'Newfoundland');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (11,-3.0,'Brazil, Buenos Aires, Georgetown');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (12,-2.0,'Mid-Atlantic');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (13,-1.0,'Azores, Cape Verde Islands');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (14,0.0,'Western Europe Time, London, Lisbon, Casablanca');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (15,1.0,'Brussels, Copenhagen, Madrid, Paris');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (16,2.0,'Kaliningrad, South Africa');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (17,3.0,'Baghdad, Riyadh, Moscow, St. Petersburg');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (18,3.5,'Tehran');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (19,4.0,'Abu Dhabi, Muscat, Baku, Tbilisi');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (20,4.5,'Kabul');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (21,5.0,'Ekaterinburg, Islamabad, Karachi, Tashkent');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (22,5.5,'Bombay, Calcutta, Madras, New Delhi');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (23,6.0,'Almaty, Dhaka, Colombo');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (24,7.0,'Bangkok, Hanoi, Jakarta');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (25,8.0,'Beijing, Perth, Singapore, Hong Kong');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (26,9.0,'Tokyo, Seoul, Osaka, Sapporo, Yakutsk');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (27,9.5,'Adelaide, Darwin');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (28,10.0,'Eastern Australia, Guam, Vladivostok');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (29,11.0,'Magadan, Solomon Islands, New Caledonia');
insert  into `isost_timezone`(`id`,`offset`,`timezone`) values (30,12.0,'Auckland, Wellington, Fiji, Kamchatka');


CREATE TABLE `escalations` (
  `esc_id` int(10) NOT NULL,
  `ticket_type_id` tinyint(3) default NULL,
  `emergency` float(5,2) default NULL,
  `high` float(5,2) default NULL,
  `medium` float(5,2) default NULL,
  `low` float(5,2) default NULL,
  `exception` float(5,2) default NULL,
  `dept_id` int(10) default NULL,
  `esc_phone` varchar(50) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
 
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('1','1','0.25','4','16','24','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('2','1','0.5','6','20','26','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('3','1','1','7','24','48','120','1','');

insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('1','3','0.25','4','16','24','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('2','3','0.5','6','20','26','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('3','3','1','7','24','48','120','1','');

insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('1','4','0.25','4','16','24','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('2','4','0.5','6','20','26','120','1','');
insert into `escalations` (`esc_id`, `ticket_type_id`, `emergency`, `high`, `medium`, `low`, `exception`,`dept_id`,`esc_phone`) values('3','4','1','7','24','48','120','1','');


CREATE TABLE `escalation_email` (
  `email` varchar(500) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `escalations_log` */

DROP TABLE IF EXISTS `escalations_log`;

CREATE TABLE `escalations_log` (
  `ticket_id` int(10) default NULL,
  `level` int(10) default NULL,
  `timestamp` int(10) default NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `hosts_master` */

DROP TABLE IF EXISTS `hosts_master`;

CREATE TABLE `hosts_master` (
  `host_id` int(10) NOT NULL auto_increment,
  `hostname` varchar(255) default NULL,
  `status` int(1) default NULL,
  `platform` varchar(10) default NULL,
  `description` varchar(255) NOT NULL,
  `alert_status`  int(1) default 1,
  PRIMARY KEY  (`host_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `hosts_nw` */

DROP TABLE IF EXISTS `hosts_nw`;

CREATE TABLE `hosts_nw` (
  `host_id` int(10) default NULL,
  `count` int(2) default NULL,
  `timeout` int(2) default NULL,
  `enabled` int(1) default '1',
  `alarm_threshold` int(10) default '2',
  `flap_timeout` int (2) default '500',
  `flap_threshold` int (10) default '5'
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `hosts_nw_log` */

DROP TABLE IF EXISTS `hosts_nw_log`;

CREATE TABLE `hosts_nw_log` (
  `record_id` int(255) NOT NULL auto_increment,
  `host_id` int(10) default NULL,
  `nw_status` int(1) default NULL,
  `min` float default NULL,
  `avg` float default NULL,
  `max` float default NULL,
  `timestamp` int(10) default NULL,
  PRIMARY KEY  (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `hosts_service` */

DROP TABLE IF EXISTS `hosts_service`;

CREATE TABLE `hosts_service` (
  `host_id` int(10) default NULL,
  `port` int(10) default NULL,
  `description` varchar(255) default NULL,
  `enabled` int(1) default '1',
  `alarm_threshold` int(10) default '2',
  `pattern` varchar(100),
  `timeout` int(5),
  `url` varchar(255)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


/*Table structure for table `hosts_service_log` */

DROP TABLE IF EXISTS `hosts_service_log`;

CREATE TABLE `hosts_service_log` (
  `record_id` int(255) NOT NULL auto_increment,
  `host_id` int(10) default NULL,
  `port` int(10) default NULL,
  `svc_status` int(1) default NULL,
  `timestamp` int(10) default NULL,
  `url` varchar(255) default NULL,
  `loadtime` int(10) default NULL,
  PRIMARY KEY  (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `rim_master` (
  `agency_index` int(10) default NULL,
  `exception` int(10) default NULL,
  `emergency` int(10) default NULL,
  `high` int(10) default NULL,
  `normal` int(10) default NULL,
  `low` int(10) default NULL,
  `unassigned` int(10) default NULL,
  `hosts_nw_status` int(10) default NULL,
  `hosts_svc_status` int(10) default NULL,
  `hosts_perf_status` int(10) default NULL,
  `timestamp` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `rim_master_escalation_log` (
  `record_index` int(255) NOT NULL auto_increment,
  `agency_index` int(10) NOT NULL,
  `ticket_id` int(10) NOT NULL,
  `ticket_date` int(10) NOT NULL,
  `ticket_summary` varchar(255) default NULL,
  `ticket_type` varchar(50) default NULL,
  `ticket_priority` varchar(50) default NULL,
  `assigned_to` varchar(255) default NULL,
  `escalation_level` int(10) default NULL,
  `escalation_date` int(10) NOT NULL,
   PRIMARY KEY  (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `rim_master_mytickets` (
  `agency_index` int(10) default NULL,
  `assigned_to` varchar(255) default NULL,
  `ticket_count` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `rim_master_nw` (
  `agency_index` int(10) default NULL,
  `hostname` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `platform` varchar(255) default NULL,
  `network` int(10) default NULL,
  `live` int(10) default NULL,
  `count` int(10) default NULL,
  `snmp` int(1) default NULL,
  `network_snmp_cpu_status` int(1) default NULL,
  `cpu` varchar(10) default NULL,
  `network_snmp_mem_status` int(1) default NULL,
  `mem` varchar(10) default NULL,
  `network_snmp_dsk_status` int(1) default NULL,
  `dsk` varchar(500) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE `scheduled_tasks` (
  `task_id` int(10) NOT NULL auto_increment,
  `task_summary` varchar(255) default NULL,
  `task_description` varchar(255) default NULL,
  `scheduled_day` varchar(10) default NULL,
  `scheduled_hr` varchar(10) default NULL,
  `scheduled_min` varchar(10) default NULL,
  `recurchoice` ENUM('day','week','date','last day of month') NOT NULL,
  `recur` int(10) default NULL,
  `scheduled_date` int(10) default NULL,
  `task_posted` int(10) default NULL,
  PRIMARY KEY  (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `config` (
  `account_as_email` int(1) default '0',
  `md5_enable` int(1) default '0',
  `asset_prefix` varchar(10) default 'AX',
  `audit_expiry` int(3) default '15',
  `ezrim` int(1) default '0',
  `master_url` varchar(255) default NULL,
  `master_api_key` varchar(255) default NULL,
  `agency_id` int(10) default '1',
  `service_dash` int(1) default '1',
  `service_ezasset` int(1) default '1',
  `service_ezticket` int(1) default '1',
  `service_network` int(1) default '1',
  `https` int(1) default '0',
  `snmp` INT(1) NOT NULL DEFAULT '1',
  `terminal` INT(1) NOT NULL DEFAULT '1',
  `terminalport` VARCHAR(255) NULL,
  `menu_bgcolor` varchar(20) default '#336699'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



insert into `config` (`account_as_email`, `md5_enable`, `asset_prefix`, `audit_expiry`, `ezrim`, `master_url`, `master_api_key`, `agency_id`, `service_dash`, `service_ezasset`, `service_ezticket`, `service_network`, `https`,`menu_bgcolor`) values('0','0','AX','15','0','','','1','1','1','1','1','0','#336699');

CREATE TABLE `super_admin` (
  `username` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into `super_admin` (`username`) values('administrator');


/* Table Structure for isost_ticket_type */

CREATE TABLE `isost_ticket_type` (
	`ticket_type_id` 	INT     (10) 	NOT NULL 	AUTO_INCREMENT 	PRIMARY KEY ,
	`ticket_type` 		VARCHAR (30) 	NOT NULL
) ENGINE = MYISAM DEFAULT CHARSET=latin1;

insert into `isost_ticket_type` (`ticket_type_id`,`ticket_type`) values (1,'Incident');
insert into `isost_ticket_type` (`ticket_type_id`,`ticket_type`) values (2,'Problem');
insert into `isost_ticket_type` (`ticket_type_id`,`ticket_type`) values (3,'Change Request');
insert into `isost_ticket_type` (`ticket_type_id`,`ticket_type`) values (4,'Service Request');

/* Table Structure for audit */

CREATE TABLE `audit` (
  `audit_id` int(11) unsigned NOT NULL auto_increment,
  `audit_timestamp` varchar(16) default NULL,
  `audit_username` varchar(20) default NULL,
  `audit_luser` varchar(20) default NULL,
  `audit_ssnname` varchar(16) default NULL,
  `audit_hostname` varchar(16) default NULL,
  `audit_command` varchar(100) default NULL,
  `audit_comments` varchar(100) default NULL,
  `audit_record_type` varchar(25) default NULL,
  KEY `audit_id` (`audit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



CREATE TABLE `rim_groups` (
  `group_id` int(10) NOT NULL auto_increment,
  `group_name` varchar(50) default NULL,
  `group_description` varchar(255) default NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert  into `rim_groups`(`group_id`,`group_name`,`group_description`) values (1,'SUPER ADMINISTRATOR','Users with all privileges');
insert  into `rim_groups`(`group_id`,`group_name`,`group_description`) values (2,'ADMINISTRATOR','User with restricted previliges');
insert  into `rim_groups`(`group_id`,`group_name`,`group_description`) values (3,'READONLY','Read-Only Access');


CREATE TABLE `rim_feature_master` (
  `feature_id` int(10) NOT NULL auto_increment,
  `feature_description` varchar(255) default NULL,
  `feature_comments` varchar(255) default NULL,
  PRIMARY KEY  (`feature_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('1','User : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('2','User : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('3','User : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('4','Groups : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('5','Groups : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('6','Groups : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('7','Groups : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('8','Office Locations : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('9','Office Locations : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('10','Office Locations : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('11','Office Locations : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('12','Departments : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('13','Departments : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('14','Departments : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('15','Departments : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('16','Services : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('17','Services : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('18','Services : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('19','Services : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('20','Quick Links : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('21','Quick Links : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('22','Quick Links : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('23','Quick Links : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('24','Tasks : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('25','Tasks : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('26','Tasks : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('27','Escalations',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('28','Broadcast',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('29','Network : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('30','Network : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('31','Network : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('32','Network : Delete',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('33','Documents : Read',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('34','Tickets',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('35','Assets : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('36','Assets : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('37','Assets : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('38','Agencies : List',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('39','Agencies : Add',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('40','Agencies : Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('41','Configuration',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('42','Documents : Write',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('43','Profile Management',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('44','Reports',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('45','Tickets - Admin',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('46','SOPBOX',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('47','Root Cause Analysis - Create',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('48','Root Cause Analysis - Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('49','Planned Activities - Create',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('50','Planned Activities - Edit',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('51','Root Cause Analysis - View',NULL);
insert  into `rim_feature_master`(`feature_id`,`feature_description`,`feature_comments`) values ('52','Planned Activities - View',NULL);

CREATE TABLE `rim_group_feature` (
  `group_id` int(10) default NULL,
  `feature_id` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,1);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,2);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,3);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,4);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,5);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,6);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,7);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,8);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,9);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,10);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,11);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,12);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,13);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,14);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,15);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,16);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,17);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,18);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,19);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,20);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,21);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,22);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,23);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,24);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,25);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,26);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,27);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,28);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,29);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,30);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,31);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,32);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,33);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,34);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,35);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,36);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,37);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,38);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,39);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,40);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,41);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,42);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,43);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,44);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,45);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,46);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,47);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,48);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,49);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,50);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,51);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (1,52);

insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,1);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,2);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,3);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,4);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,5);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,6);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,29);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,34);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,35);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,36);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,37);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,38);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,39);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,40);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,44);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,46);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,48);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,49);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,50);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,51);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (2,52);


insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,1);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,4);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,8);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,12);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,16);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,20);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,24);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,29);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,34);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,35);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,38);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,44);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,46);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,51);
insert  into `rim_group_feature`(`group_id`,`feature_id`) values (3,52);


CREATE TABLE `rim_user_group` (
  `group_id` int(10) default NULL,
  `username` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into `rim_user_group`(`group_id`,`username`) values (1,'administrator');

DROP TABLE IF EXISTS `hosts_nw_snmp`;

CREATE TABLE `hosts_nw_snmp` (
  `host_id` int(10) default NULL,
  `retry_count` int(2) default NULL,
  `timeout` int(2) default NULL,
  `enabled` int(1) default '1',
  `community_string` varchar(50) default NULL,
  `alarm_threshold` int(10) default '2',
  `port` int(3) default '161',
  `version` varchar(5) default 'v2',
  `disk_exclude` varchar(255),
  `v3_user` varchar(50),
  `v3_pwd` varchar(50)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `hosts_nw_snmp_log`;

CREATE TABLE `hosts_nw_snmp_log` (
  `record_id` int(255) NOT NULL auto_increment,
  `host_id` int(10) default NULL,
  `nw_snmp_cpu_status` int(1) default NULL,
  `nw_snmp_mem_status` int(1) default NULL,
  `nw_snmp_dsk_status` int(1) default NULL,
  `cpu_user` int (3) default NULL,
  `cpu_system` int (3) default NULL,
  `cpu_idle` int (3) default NULL,
  `mem_utilization` varchar(10) default NULL,
  `disk_utilization` varchar(500) default NULL,
  `cpu_snmp_result` varchar(1000) default NULL,
  `mem_snmp_result` varchar(1000) default NULL,
  `timestamp` int(10) default NULL,
  PRIMARY KEY  (`record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `hosts_nw_snmp_thresholds`;

CREATE TABLE `hosts_nw_snmp_thresholds` (
	`id` int(255) NOT NULL auto_increment,
	`host_id` int(10) default NULL,
	`snmp_parameter` varchar(100) default NULL,
	`param_value` varchar(20) default NULL,
	`enabled` int(1) default '1',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `bizgroup_grade_mapping` (
  `id` int(11) NOT NULL auto_increment,
  `business_group_index` varchar(255) default NULL,
  `grade_id` int(2) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `sys_uptime_email` (
 `id` int(11) NOT NULL auto_increment,
 `email_id` varchar(255) default NULL,
 `created` datetime NOT NULL default '0000-00-00 00:00:00',
 `status` enum('active','inactive') NOT NULL default 'active',
 `host_id` int(11) default NULL,
 `continuos_alerts` int(2) default 0,
 PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `rca_master` (
   `activity_id` int(10) not null auto_increment,
   `project` varchar(255),
   `action` varchar(50),
   `action_by` varchar(255),
   `action_date` int(10),
   PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `rca_information` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `open_date` int(10),
   `attended_date` int(10),
   `closure_date` int(10),
   `description` varchar(1000),
   `symptoms` varchar(1000),
   `impact_analysis` varchar(1000),
   `ca_root_cause` varchar(1000),
   `ca_reason` varchar(1000),
   `ca_action` varchar(1000),
   `pa_action` varchar(1000),
   `recommendations` varchar(1000),
   `observations` varchar(1000),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `rca_approval_history` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `approver_name` varchar(255),
   `approver_email` varchar(255),
   `approver_key` varchar(255),
   `action` varchar(50),
   `action_date` int(10),
   `action_by` varchar(255),
   `comments` varchar(255),
   `item_order` int(10),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `poa_master` (
   `activity_id` int(10) not null auto_increment,
   `project` varchar(255),
   `action` varchar(50),
   `action_by` varchar(255),
   `action_date` int(10),
   PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `poa_information` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `scheduled_start_date` int(10),
   `scheduled_end_date` int(10),
   `actual_start_date` int(10),
   `actual_end_date` int(10),
   `activity_description` varchar(255),
   `activity_impact` varchar(255),
   `activity_services` varchar(1024),
   `activity_verification` varchar(1024),
   `location` varchar(255),
   `action` varchar(50),
   `action_by` varchar(255),
   `action_date` varchar(255),
   `release_notes` varchar(1024),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `poa_activity_plan` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `task_description` varchar(255),
   `task_duration` int(10),
   `task_owner` varchar(255),
   `item_order` int(10),
   `action` varchar(50),
   `action_by` varchar(255),
   `action_date` int(10),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `poa_rollback_plan` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `task_description` varchar(255),
   `task_duration` int(10),
   `task_owner` varchar(255),
   `item_order` int(10),
   `action` varchar(50),
   `action_by` varchar(255),
   `action_date` int(10),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `poa_approval_history` (
   `record_index` int(10) not null auto_increment,
   `activity_id` int(10),
   `approver_name` varchar(255),
   `approver_email` varchar(255),
   `approver_key` varchar(255),
   `action` varchar(50),
   `action_date` int(10),
   `action_by` varchar(255),
   `comments` varchar(255),
   `item_order` int(10),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `isost_ticket_approval` (
  `approval_id` int(11) NOT NULL auto_increment,
  `ticket_id` int(11) default NULL,
  `request_date` int(10) default NULL,
  `requested_by` varchar(255) default NULL,
  `approval_by` varchar(255) default NULL,
  `approval_date` int(10) default NULL,
  `approval_comments` varchar(255) default NULL,
  `approval_key` varchar(255) default NULL,
  `approval_status` varchar(20) default 'PENDING',
  PRIMARY KEY  (`approval_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE `terminal_login` (
  `username` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `ticket_rating` (
  `ticket_id` int(255) default NULL,
  `rated_staff` varchar(255) default NULL,
  `rated_by` varchar(255) default NULL,
  `rated_date` int(10) default NULL,
  `rating` int(10) default '3',
  `comments` varchar(255) default NULL, 
  `closed_rating` int(1) DEFAULT 0,
  PRIMARY KEY  (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `asset_template` (
`email` varchar(1000)
);

INSERT INTO `asset_template` (`email`) VALUES ("Dear %%user,<div><br></div><div>As per our records, the following assets are assigned to you. Request you to kindly verify / confirm the same.</div><div><br></div><div>%%asset</div><div><br></div><div>Kindly get in touch with us in case there are any discrepancies.&nbsp;</div><div>As always, we thank you for your co-operation and value your feedback.</div><div><br></div><div>Thanks &amp; Regards</div><div>IT Support</div><br><br>");

CREATE TABLE `hosts_timesync_config` (
  `timeservers` varchar(255) DEFAULT 'pool.ntp.org',
  `diffthreshold` int(10) DEFAULT '1500'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into hosts_timesync_config values ('pool.ntp.org','1500');

