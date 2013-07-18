CREATE TABLE `user_awards` (
  `award_index` int(255) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `organization` varchar(255) default NULL,
  `award` varchar(255) default NULL,
  PRIMARY KEY  (`award_index`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `user_driving_license` (
  `username` varchar(255) NOT NULL default '',
  `license_no` varchar(255) default NULL,
  `license_issue_date` varchar(255) default NULL,
  `license_valid_till` varchar(255) default NULL,
  `category` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `user_education` (
  `education_index` int(255) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `type_of_course` varchar(255) default NULL,
  `name_of_course` varchar(255) default NULL,
  `university_institution` varchar(255) default NULL,
  `year_of_completion` varchar(255) default NULL,
  PRIMARY KEY  (`education_index`)
) ENGINE=MyISAM AUTO_INCREMENT=221 DEFAULT CHARSET=latin1;


CREATE TABLE `user_experience` (
  `username` varchar(255) default NULL,
  `organization` varchar(255) default NULL,
  `from_date` varchar(255) default NULL,
  `to_date` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user_family_member` (
  `username` varchar(255) default NULL,
  `member_name` varchar(255) default NULL,
  `member_date_of_birth` varchar(255) default NULL,
  `relationship` varchar(255) default NULL,
  `member_blood_group` varchar(255) default NULL,
  `comments` varchar(255) default NULL,
  `dependent` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `user_overseas_travel` (
  `username` varchar(255) default NULL,
  `country_visited` varchar(255) default NULL,
  `year_of_visit` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user_personal_information` (
  `username` varchar(255) default NULL,
  `gender` varchar(255) default NULL,
  `date_of_birth` varchar(255) default NULL,
  `date_of_joining` varchar(255) default NULL,
  `blood_group` varchar(255) default NULL,
  `marital_status` varchar(255) default NULL,
  `date_of_marriage` varchar(255) default NULL,
  `passport_number` varchar(255) default NULL,
  `passport_issue_location` varchar(255) default NULL,
  `passport_issue_date` varchar(255) default NULL,
  `passport_valid_till` varchar(255) default NULL,
  `date_of_leaving` varchar(255) default NULL,
  `pan_no` varchar(20) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user_financial_information` (
  `username` varchar(255) default NULL,
  `bank` varchar(255) default NULL,
  `bank_branch` varchar(255) default NULL,
  `bank_ifsc_code` varchar(255) default NULL,
  `bank_account` varchar(255) default NULL,
  `pf_no` varchar(255) default NULL,
  `esi_no` varchar(255) default NULL,
  `pan_no` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `user_vehicle` (
  `username` varchar(255) default NULL,
  `vehicle_type` varchar(255) default NULL,
  `vehicle_make` varchar(255) default NULL,
  `vehicle_no` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user_visa_information` (
  `username` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `visa_type` varchar(255) default NULL,
  `valid_till` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `leave_comp_off` (
  `off_no` int(11) NOT NULL auto_increment,
  `username` varchar(50) default NULL,
  `work_date` int(255) default NULL,
  `work_notes` varchar(255) default NULL,
  `status` int(10) default '0',
  `approval_date` int(255) default NULL,
  `approval_username` varchar(50) default NULL,
  `comments` varchar(255) default NULL,
  PRIMARY KEY  (`off_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

CREATE TABLE `leave_form` (
  `leave_no` int(255) NOT NULL auto_increment,
  `username` varchar(255) default '',
  `from_date` int(255) default NULL,
  `to_date` int(255) default NULL,
  `reason` varchar(1000) default NULL,
  `leave_category_id` int(10) default NULL,
  `leave_status` int(2) default NULL,
  `approval_username` varchar(255) default NULL,
  `approval_date` int(255) default NULL,
  `comments` varchar(255) default NULL,
  PRIMARY KEY  (`leave_no`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;


CREATE TABLE `leave_type` (
  `leave_category_id` int(10) NOT NULL auto_increment,
  `leave_category` varchar(50) default NULL,
  `credit_period` varchar(50) default NULL,
  `credit_value` double default NULL,
  PRIMARY KEY  (`leave_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


insert into services values ('HRMS','HR Management System');

CREATE TABLE `hrost_api_key` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `isactive` tinyint(1) NOT NULL default '1',
  `ipaddr` varchar(16) NOT NULL,
  `apikey` varchar(255) NOT NULL,
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ipaddr` (`ipaddr`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `hrost_api_key` */

insert  into `hrost_api_key`(id,isactive,ipaddr,apikey,updated,created) values (1,1,'192.168.1.5','siri!','2010-09-20 16:14:57','2010-09-20 16:14:57');


CREATE TABLE `hrost_config` (
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
  `ticket_autoresponder` tinyint(1) unsigned NOT NULL default '0',
  `message_autoresponder` tinyint(1) unsigned NOT NULL default '0',
  `ticket_notice_active` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `ticket_alert_admin` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_dept_manager` tinyint(1) unsigned NOT NULL default '1',
  `ticket_alert_dept_members` tinyint(1) unsigned NOT NULL default '0',
  `message_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `message_alert_laststaff` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `message_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `note_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `note_alert_laststaff` tinyint(1) unsigned NOT NULL default '1',
  `note_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `note_alert_dept_manager` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_active` tinyint(1) unsigned NOT NULL default '0',
  `overdue_alert_assigned` tinyint(1) unsigned NOT NULL default '1',
  `overdue_alert_dept_manager` tinyint(1) unsigned NOT NULL default '1',
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
  `time_format` varchar(32) NOT NULL default ' h:i A',
  `date_format` varchar(32) NOT NULL default 'm/d/Y',
  `datetime_format` varchar(60) NOT NULL default 'm/d/Y g:i a',
  `daydatetime_format` varchar(60) NOT NULL default 'D, M j Y g:ia',
  `reply_separator` varchar(60) NOT NULL default '-- do not edit --',
  `admin_email` varchar(125) NOT NULL default '',
  `helpdesk_title` varchar(255) NOT NULL default 'osTicket Support Ticket System',
  `helpdesk_url` varchar(255) NOT NULL default '',
  `api_passphrase` varchar(125) NOT NULL default '',
  `ostversion` varchar(16) NOT NULL default '',
  `updated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `isoffline` (`isonline`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `hrost_config`(id,isonline,timezone_offset,enable_daylight_saving,staff_ip_binding,staff_max_logins,staff_login_timeout,staff_session_timeout,client_max_logins,client_login_timeout,client_session_timeout,max_page_size,max_open_tickets,max_file_size,autolock_minutes,overdue_grace_period,alert_email_id,default_email_id,default_dept_id,default_priority_id,default_template_id,default_smtp_id,spoof_default_smtp,clickable_urls,allow_priority_change,use_email_priority,enable_captcha,enable_auto_cron,enable_mail_fetch,enable_email_piping,send_sql_errors,send_mailparse_errors,send_login_errors,save_email_headers,strip_quoted_reply,log_ticket_activity,ticket_autoresponder,message_autoresponder,ticket_notice_active,ticket_alert_active,ticket_alert_admin,ticket_alert_dept_manager,ticket_alert_dept_members,message_alert_active,message_alert_laststaff,message_alert_assigned,message_alert_dept_manager,note_alert_active,note_alert_laststaff,note_alert_assigned,note_alert_dept_manager,overdue_alert_active,overdue_alert_assigned,overdue_alert_dept_manager,overdue_alert_dept_members,auto_assign_reopened_tickets,show_assigned_tickets,show_answered_tickets,hide_staff_name,overlimit_notice_active,email_attachments,allow_attachments,allow_email_attachments,allow_online_attachments,allow_online_attachments_onlogin,random_ticket_ids,log_level,log_graceperiod,upload_dir,allowed_filetypes,time_format,date_format,datetime_format,daydatetime_format,reply_separator,admin_email,helpdesk_title,helpdesk_url,api_passphrase,ostversion,updated) values (1,1,5.5,0,0,10,10,0,4,2,30,25,0,104857600,3,0,2,1,1,2,1,0,0,1,0,0,0,0,1,1,1,1,1,0,1,1,1,1,1,0,1,1,0,0,1,1,0,0,1,1,0,0,1,1,0,1,0,0,0,0,1,1,1,1,0,0,2,3,'/data/portal.yourcompany.com/ez/tickets/attachments','.doc, .pdf, .txt, .xls, .html, .htm, .ppt, .rtf',' h:i A','d m Y','d m Y g:i a','D, M j Y g:ia','-- do not edit --','administrator@demo.com','Help Desk','http://portal.yourcompany.com/ez/tickets/','','1.6 ST','2010-09-20 16:14:57');

CREATE TABLE `hrost_department` (
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
  PRIMARY KEY  (`dept_id`),
  UNIQUE KEY `dept_name` (`dept_name`),
  KEY `manager_id` (`manager_id`),
  KEY `autoresp_email_id` (`autoresp_email_id`),
  KEY `tpl_id` (`tpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert  into `hrost_department`(dept_id,tpl_id,email_id,autoresp_email_id,manager_id,dept_name,dept_signature,ispublic,ticket_auto_response,message_auto_response,can_append_signature,updated,created) values (1,0,1,0,1,'Human Resources','Human Resources',1,1,1,1,'2010-09-20 16:25:05','2010-09-20 16:14:57');

CREATE TABLE `hrost_email` (
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert  into `hrost_email`(email_id,noautoresp,priority_id,dept_id,email,name,userid,userpass,mail_active,mail_host,mail_protocol,mail_encryption,mail_port,mail_fetchfreq,mail_fetchmax,mail_delete,mail_errors,mail_lasterror,mail_lastfetch,smtp_active,smtp_host,smtp_port,smtp_secure,smtp_auth,created,updated) values (1,0,2,1,'admin@demo.com','Support','','',0,'','POP','NONE',NULL,5,30,0,0,NULL,NULL,0,'',NULL,1,1,'2010-09-20 16:14:57','2010-09-20 16:14:57'),(2,0,1,1,'alerts@demo.com','osTicket Alerts','','',0,'','POP','NONE',NULL,5,30,0,0,NULL,NULL,0,'',NULL,1,1,'2010-09-20 16:14:57','2010-09-20 16:14:57');

CREATE TABLE `hrost_email_banlist` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL default '',
  `submitter` varchar(126) NOT NULL default '',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `hrost_email_banlist`(id,email,submitter,added) values (1,'test@example.com','System','2010-09-20 16:14:57');

CREATE TABLE `hrost_email_template` (
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

insert  into `hrost_email_template`(tpl_id,cfg_id,name,notes,ticket_autoresp_subj,ticket_autoresp_body,ticket_notice_subj,ticket_notice_body,ticket_alert_subj,ticket_alert_body,message_autoresp_subj,message_autoresp_body,message_alert_subj,message_alert_body,note_alert_subj,note_alert_body,assigned_alert_subj,assigned_alert_body,ticket_overdue_subj,ticket_overdue_body,ticket_overlimit_subj,ticket_overlimit_body,ticket_reply_subj,ticket_reply_body,created,updated) values (1,1,'osTicket Default Template','Default osTicket templates','Support Ticket Opened [#%ticket]','%name,\r\n\r\nA request for support has been created and assigned ticket #%ticket. A representative will follow-up with you as soon as possible.\r\n\r\nYou can view this ticket\'s progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\nIf you wish to send additional comments or information regarding this issue, please don\'t open a new ticket. Simply login using the link above and update the ticket.\r\n\r\n%signature','[#%ticket] %subject','%name,\r\n\r\nOur customer care team has created a ticket, #%ticket on your behalf, with the following message.\r\n\r\n%message\r\n\r\nIf you wish to provide additional comments or information regarding this issue, please don\'t open a new ticket. You can update or view this ticket\'s progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\n%signature','New Ticket Alert','%staff,\r\n\r\nNew ticket #%ticket created.\r\n-------------------\r\nName: %name\r\nEmail: %email\r\nDept: %dept\r\n\r\n%message\r\n-------------------\r\n\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\n- Your friendly Customer Support System - powered by osTicket.','[#%ticket] Message Added','%name,\r\n\r\nYour reply to support request #%ticket has been noted.\r\n\r\nYou can view this support request progress online here: %url/view.php?e=%email&t=%ticket.\r\n\r\n%signature','New Message Alert','%staff,\r\n\r\nNew message appended to ticket #%ticket\r\n\r\n----------------------\r\nName: %name\r\nEmail: %email\r\nDept: %dept\r\n\r\n%message\r\n-------------------\r\n\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\n- Your friendly Customer Support System - powered by osTicket.','New Internal Note Alert','%staff,\r\n\r\nInternal note appended to ticket #%ticket\r\n\r\n----------------------\r\nName: %name\r\n\r\n%note\r\n-------------------\r\n\r\nTo view/respond to the ticket, please login to the support ticket system.\r\n\r\n- Your friendly Customer Support System - powered by osTicket.','Ticket #%ticket Assigned to you','%assignee,\r\n\r\n%assigner has assigned ticket #%ticket to you!\r\n\r\n%message\r\n\r\nTo view complete details, simply login to the support system.\r\n\r\n- Your friendly Support Ticket System - powered by osTicket.','Stale Ticket Alert','%staff,\r\n\r\nA ticket, #%ticket assigned to you or in your department is seriously overdue.\r\n\r\n%url/scp/tickets.php?id=%id\r\n\r\nWe should all work hard to guarantee that all tickets are being addressed in a timely manner. Enough baby talk...please address the issue or you will hear from me again.\r\n\r\n\r\n- Your friendly (although with limited patience) Support Ticket System - powered by osTicket.','Support Ticket Denied','%name\r\n\r\nNo support ticket has been created. You\'ve exceeded maximum number of open tickets allowed.\r\n\r\nThis is a temporary block. To be able to open another ticket, one of your pending tickets must be closed. To update or add comments to an open ticket simply login using the link below.\r\n\r\n%url/view.php?e=%email\r\n\r\nThank you.\r\n\r\nSupport Ticket System','[#%ticket] %subject','%name,\r\n\r\nA customer support staff member has replied to your support request, #%ticket with the following response:\r\n\r\n%response\r\n\r\nWe hope this response has sufficiently answered your questions. If not, please do not send another email. Instead, reply to this email or login to your account for a complete archive of all your support requests and responses.\r\n\r\n%url/view.php?e=%email&t=%ticket\r\n\r\n%signature','2010-09-20 16:14:57','2010-09-20 16:14:57');

CREATE TABLE `hrost_groups` (
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
  PRIMARY KEY  (`group_id`),
  KEY `group_active` (`group_enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert  into `hrost_groups`(group_id,group_enabled,group_name,dept_access,can_create_tickets,can_edit_tickets,can_delete_tickets,can_close_tickets,can_transfer_tickets,can_ban_emails,can_manage_kb,created,updated) values (1,1,'Admins','1',1,1,1,1,1,1,1,'2010-09-20 16:14:57','2010-09-20 16:14:57'),(2,1,'Managers','1',1,1,0,1,1,1,1,'2010-09-20 16:14:57','2010-09-20 16:14:57'),(3,1,'Staff','1',1,0,0,0,0,0,0,'2010-09-20 16:14:57','2010-09-20 16:14:57');

CREATE TABLE `hrost_help_topic` (
  `topic_id` int(11) unsigned NOT NULL auto_increment,
  `isactive` tinyint(1) unsigned NOT NULL default '1',
  `noautoresp` tinyint(3) unsigned NOT NULL default '0',
  `priority_id` tinyint(3) unsigned NOT NULL default '0',
  `dept_id` tinyint(3) unsigned NOT NULL default '0',
  `topic` varchar(32) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`topic_id`),
  UNIQUE KEY `topic` (`topic`),
  KEY `priority_id` (`priority_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

insert  into `hrost_help_topic`(topic_id,isactive,noautoresp,priority_id,dept_id,topic,created,updated) values (1,1,0,2,1,'Compensation','2010-09-20 16:14:57','2010-09-20 16:42:49'),(3,1,0,2,1,'Leave','2010-09-20 16:34:57','2010-09-20 17:00:12'),(4,1,0,3,1,'New Staff Request','2010-09-20 16:42:03','2010-09-20 16:42:03'),(9,1,0,3,1,'Deletion / Termination','2010-09-20 17:01:49','2010-09-20 17:01:49'),(5,1,0,2,1,'Organization Change','2010-09-20 16:43:21','2010-09-20 16:43:21'),(6,1,0,2,1,'Update Personal Information','2010-09-20 16:43:45','2010-09-20 16:43:45'),(7,1,0,2,1,'Travel / Visa','2010-09-20 16:44:55','2010-09-20 16:44:55'),(8,1,0,1,1,'Address / Employment Proof','2010-09-20 16:45:34','2010-09-20 16:45:34'),(10,1,0,2,1,'Recruitment','2010-09-20 17:02:16','2010-09-20 17:02:16');

CREATE TABLE `hrost_kb_premade` (
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

insert  into `hrost_kb_premade`(premade_id,dept_id,isenabled,title,answer,created,updated) values (1,0,1,'What is osTicket (sample)?','\r\nosTicket is a widely-used open source support ticket system, an attractive alternative to higher-cost and complex customer support systems - simple, lightweight, reliable, open source, web-based and easy to setup and use.','2010-09-20 16:14:57','2010-09-20 16:14:57'),(2,0,1,'Sample (with variables)','\r\n%name,\r\n\r\nYour ticket #%ticket created on %createdate is in %dept department.\r\n\r\n','2010-09-20 16:14:57','2010-09-20 16:14:57');

CREATE TABLE `hrost_staff` (
  `staff_id` int(11) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '0',
  `username` varchar(32) NOT NULL default '',
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
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `username` (`username`),
  KEY `dept_id` (`dept_id`),
  KEY `issuperuser` (`isadmin`),
  KEY `group_id` (`group_id`,`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `hrost_staff`(staff_id,group_id,dept_id,username,firstname,lastname,passwd,email,phone,phone_ext,mobile,signature,isactive,isadmin,isvisible,onvacation,daylight_saving,append_signature,change_passwd,timezone_offset,max_page_size,auto_refresh_rate,created,lastlogin,updated) values (1,1,1,'administrator','Support','Administrator','200ceb26807d6bf99fd6f4f0d1ca54d4','administrator@demo.com','','','','',1,1,1,0,0,0,0,5.5,0,0,'2010-09-20 16:14:57','2010-09-20 16:15:46','2010-09-20 16:18:02');

CREATE TABLE `hrost_syslog` (
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `hrost_syslog`(log_id,log_type,title,log,logger,ip_address,created,updated) values (1,'Debug','osTicket installed!','Congratulations osTicket basic installation completed!\n\nThank you for choosing osTicket!','','192.168.1.105','2010-09-20 16:14:57','2010-09-20 16:14:57');

CREATE TABLE `hrost_ticket` (
  `ticket_id` int(11) unsigned NOT NULL auto_increment,
  `ticketID` int(11) unsigned NOT NULL default '0',
  `dept_id` int(10) unsigned NOT NULL default '1',
  `priority_id` int(10) unsigned NOT NULL default '2',
  `topic_id` int(10) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `email` varchar(120) NOT NULL default '',
  `name` varchar(32) NOT NULL default '',
  `subject` varchar(64) NOT NULL default '[no subject]',
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

insert  into `hrost_ticket`(ticket_id,ticketID,dept_id,priority_id,topic_id,staff_id,email,name,subject,helptopic,phone,phone_ext,ip_address,status,source,isoverdue,isanswered,duedate,reopened,closed,lastmessage,lastresponse,created,updated) values (1,295165,1,2,0,0,'support@osticket.com','osTicket Support','osTicket Installed!','Commercial support',NULL,NULL,'','open','Web',0,0,NULL,NULL,NULL,NULL,NULL,'2010-09-20 16:14:57','0000-00-00 00:00:00');

CREATE TABLE `hrost_ticket_attachment` (
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


CREATE TABLE `hrost_ticket_lock` (
  `lock_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `expire` datetime default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`lock_id`),
  UNIQUE KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `hrost_ticket_message` (
  `msg_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `messageId` varchar(255) default NULL,
  `message` text NOT NULL,
  `headers` text,
  `source` varchar(16) default NULL,
  `ip_address` varchar(16) default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  PRIMARY KEY  (`msg_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `msgId` (`messageId`),
  FULLTEXT KEY `message` (`message`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert  into `hrost_ticket_message`(msg_id,ticket_id,messageId,message,headers,source,ip_address,created,updated) values (1,1,NULL,'Thank you for choosing osTicket.\n\nPlease make sure you join the osTicket forums at http://osticket.com/forums to stay up to date on the latest news, security alerts and updates. The osTicket forums are also a great place to get assistance, guidance, tips, and help from other osTicket users. In addition to the forums, the osTicket wiki provides a useful collection of educational materials, documentation, and notes from the community. We welcome your contributions to the osTicket community.\n\nIf you are looking for a greater level of support, we provide professional services and commercial support with guaranteed response times, and access to the core development team. We can also help customize osTicket or even add new features to the system to meet your unique needs.\n\nFor more information or to discuss your needs, please contact us today at http://osticket.com/support/. Your feedback is greatly appreciated!\n\n- The osTicket Team',NULL,'Web','','2010-09-20 16:14:57',NULL);

CREATE TABLE `hrost_ticket_note` (
  `note_id` int(11) unsigned NOT NULL auto_increment,
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(10) unsigned NOT NULL default '0',
  `source` varchar(32) NOT NULL default '',
  `title` varchar(255) NOT NULL default 'Generic Intermal Notes',
  `note` text NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`note_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `staff_id` (`staff_id`),
  FULLTEXT KEY `note` (`note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `hrost_ticket_priority` (
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

insert  into `hrost_ticket_priority`(priority_id,priority,priority_desc,priority_color,priority_urgency,ispublic) values (1,'low','Low','#DDFFDD',4,1),(2,'normal','Normal','#FFFFF0',3,1),(3,'high','High','#FEE7E7',2,1),(4,'emergency','Emergency','#FEE7E7',1,0);

CREATE TABLE `hrost_ticket_response` (
  `response_id` int(11) unsigned NOT NULL auto_increment,
  `msg_id` int(11) unsigned NOT NULL default '0',
  `ticket_id` int(11) unsigned NOT NULL default '0',
  `staff_id` int(11) unsigned NOT NULL default '0',
  `staff_name` varchar(32) NOT NULL default '',
  `response` text NOT NULL,
  `ip_address` varchar(16) NOT NULL default '',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`response_id`),
  KEY `ticket_id` (`ticket_id`),
  KEY `msg_id` (`msg_id`),
  KEY `staff_id` (`staff_id`),
  FULLTEXT KEY `response` (`response`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `hrost_timezone` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `offset` float(3,1) NOT NULL default '0.0',
  `timezone` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

insert  into `hrost_timezone`(id,offset,timezone) values (1,-12.0,'Eniwetok, Kwajalein'),(2,-11.0,'Midway Island, Samoa'),(3,-10.0,'Hawaii'),(4,-9.0,'Alaska'),(5,-8.0,'Pacific Time (US & Canada)'),(6,-7.0,'Mountain Time (US & Canada)'),(7,-6.0,'Central Time (US & Canada), Mexico City'),(8,-5.0,'Eastern Time (US & Canada), Bogota, Lima'),(9,-4.0,'Atlantic Time (Canada), Caracas, La Paz'),(10,-3.5,'Newfoundland'),(11,-3.0,'Brazil, Buenos Aires, Georgetown'),(12,-2.0,'Mid-Atlantic'),(13,-1.0,'Azores, Cape Verde Islands'),(14,0.0,'Western Europe Time, London, Lisbon, Casablanca'),(15,1.0,'Brussels, Copenhagen, Madrid, Paris'),(16,2.0,'Kaliningrad, South Africa'),(17,3.0,'Baghdad, Riyadh, Moscow, St. Petersburg'),(18,3.5,'Tehran'),(19,4.0,'Abu Dhabi, Muscat, Baku, Tbilisi'),(20,4.5,'Kabul'),(21,5.0,'Ekaterinburg, Islamabad, Karachi, Tashkent'),(22,5.5,'Bombay, Calcutta, Madras, New Delhi'),(23,6.0,'Almaty, Dhaka, Colombo'),(24,7.0,'Bangkok, Hanoi, Jakarta'),(25,8.0,'Beijing, Perth, Singapore, Hong Kong'),(26,9.0,'Tokyo, Seoul, Osaka, Sapporo, Yakutsk'),(27,9.5,'Adelaide, Darwin'),(28,10.0,'Eastern Australia, Guam, Vladivostok'),(29,11.0,'Magadan, Solomon Islands, New Caledonia'),(30,12.0,'Auckland, Wellington, Fiji, Kamchatka');


CREATE TABLE `timesheet` (
   `record_index` int(255) not null auto_increment,
   `agency_index` int(10) default '1',
   `context_id` int(10) default '1',
   `username` varchar(255),
   `start_date` int(255),
   `end_date` int(255),
   `activity` varchar(1000),
   `project_index` int(10) default '1',
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `timesheet_context` (
   `context_id` int(10) not null auto_increment,
   `description` varchar(255),
   PRIMARY KEY (`context_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

INSERT INTO `timesheet_context` (`context_id`, `description`) VALUES 
('1', 'WORK - OFFICE'),
('2', 'WORK - ON-SITE'),
('3', 'WORK - HOME'),
('4', 'LEAVE');


CREATE TABLE `timesheet_delete` (
   `record_index` int(255) not null,
   `agency_index` int(10) default '1',
   `context_id` int(10) default '1',
   `username` varchar(255),
   `start_date` int(255),
   `end_date` int(255),
   `activity` varchar(1000),
   `deleted_on` int(255),
   `deleted_by` varchar(255),
   `comments` varchar(255),
   PRIMARY KEY (`record_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `timesheet_exception` (
   `username` varchar(255)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `timesheet_minhrs` (
   `business_group_index` int(10),
   `min_hrs` int(10)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `timesheet_project` (
   `project_index` int(10),
   `project_description` varchar(255),
   `project_status` varchar(10),
    PRIMARY KEY (`project_index`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into timesheet_project (project_index,project_description,project_status) values ('1','Routine / Standard Activity','Active');


CREATE TABLE `expense_authorization` (
   `auth_id` int(10) not null auto_increment,
   `username` varchar(255),
   `expense_type_id` int(10),
   `auth_price` float,
   PRIMARY KEY (`auth_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `expense_log` (
   `log_id` int(10) not null auto_increment,
   `expense_id` int(10),
   `action` varchar(255),
   `action_by` varchar(255),
   `action_date` int(10),
   `action_comments` varchar(255),
   PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `expense_report` (
   `expense_id` int(10) not null auto_increment,
   `expense_desc` varchar(255),
   `username` varchar(255),
   `status` varchar(50) default 'DRAFT',
   PRIMARY KEY (`expense_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `expense_report_info` (
   `entry_id` int(10) not null auto_increment,
   `expense_id` int(10),
   `expense_date` int(10),
   `expense_type_id` int(10),
   `description` varchar(255),
   `qty` int(10),
   `unit_price` float,
   `total` float,
   `bill_no` varchar(20),
   PRIMARY KEY (`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE `expense_type` (
   `expense_type_id` int(10) not null auto_increment,
   `expense_type` varchar(255),
   `uom` varchar(10),
   `unit_price` float,
   `auth_reqd` int(2) default '0',
   PRIMARY KEY (`expense_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;


INSERT INTO `expense_type` (`expense_type_id`, `expense_type`, `uom`, `unit_price`, `auth_reqd`) VALUES 
('1', 'Communication : Mobile', 'Per Month', '0', '1'),
('2', 'Communication : Data', 'Per Month', '0', '1'),
('3', 'Conveyance : 4 Wheeler', 'Kms', '8.5', '0'),
('4', 'Conveyance : 2 Wheeler', 'Kms', '2.75', '0'),
('5', 'Conveyance : Others', 'NA', '0', '0'),
('6', 'Food : Restaurant / Hotel', 'NA', '0', '0'),
('7', 'Lodging : Hotel', 'NA', '0', '0'),
('8', 'Travel Fare : Air / Train / Bus', 'NA', '0', '0'),
('9', 'Miscellaneous', 'NA', '0', '0'),
('10', 'Office Expenses', 'NA', '0', '0');

CREATE TABLE `ezhr_groups` (
  `group_id` int(10) NOT NULL auto_increment,
  `group_name` varchar(50) default NULL,
  `group_description` varchar(255) default NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert  into `ezhr_groups`(`group_id`,`group_name`,`group_description`) values (1,'HR Executive','Users with restricted privileges');
insert  into `ezhr_groups`(`group_id`,`group_name`,`group_description`) values (2,'HR Manager','Users with admin privileges');
insert  into `ezhr_groups`(`group_id`,`group_name`,`group_description`) values (3,'Finance Executive','Users with privileges to Expenses module');


CREATE TABLE `ezhr_feature_master` (
  `feature_id` int(10) NOT NULL auto_increment,
  `feature_description` varchar(255) default NULL,
  PRIMARY KEY  (`feature_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('1','Staff : Listing');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('2','Staff : General Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('3','Staff : Contact Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('4','Staff : Organization');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('5','Staff : Financial Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('6','Staff : Travel Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('7','Staff : Education');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('8','Staff : Work Experience');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('9','Staff : Awards');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('10','Staff : Leave Management');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('11','Staff : Documents');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('12','Staff : Family Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('13','Staff : Timesheets');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('14','Timesheets');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('15','Expense Management');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('16','Reporting');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('17','Settings');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('18','Staff : Vehicle Information');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('19','Ticket Management');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('20','Ticket Administration');
insert  into `ezhr_feature_master`(`feature_id`,`feature_description`) values ('21','Staff : Add');

CREATE TABLE `ezhr_group_feature` (
  `group_id` int(10) default NULL,
  `feature_id` int(10) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,1);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,2);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,3);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,4);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,5);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,6);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,7);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,8);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,9);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,10);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,11);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,12);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,13);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,14);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,15);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,16);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,18);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (1,19);

insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,1);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,2);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,3);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,4);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,5);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,6);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,7);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,8);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,9);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,10);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,11);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,12);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,13);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,14);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,15);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,16);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,17);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,18);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,19);
insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (2,20);

insert  into `ezhr_group_feature`(`group_id`,`feature_id`) values (3,15);



CREATE TABLE `ezhr_user_group` (
  `group_id` int(10) default NULL,
  `username` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `config_ezportal` (
   `site_name` varchar(255),
   `site_logo_path` varchar(255),
   `site_banner_path` varchar(255),
   `site_banner_height` varchar(255),
   `user_photo_path` varchar(255),
   `ezq_url` varchar(255),
   `ftr_leave` tinyint(1),
   `ftr_leave_balance` tinyint(1),
   `ftr_leave_credit` tinyint(1),
   `ftr_expenses` tinyint(1),
   `expense_currency` varchar(255),
   `expense_prefix` varchar(20),
   `company` varchar(255),
   `company_address` varchar(255),
   `leave_calendar_start` int(10),
   `compensatory_leave_validity` int(10),
   `ftr_timesheets` tinyint(1),
   `hr_notifications` varchar(255)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `lm_leave_type_master` (
   `leave_type_id` int(3) not null auto_increment,
   `leave_type` varchar(50),
   PRIMARY KEY (`leave_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

INSERT INTO `lm_leave_type_master` (`leave_type_id`, `leave_type`) VALUES 
('1', 'Annual Leave'),
('2', 'Casual Leave'),
('3', 'Loss of Pay'),
('4', 'Compensatory Off');

CREATE TABLE `lm_policy_master` (
   `policy_id` int(3) not null auto_increment,
   `policy_desc` varchar(50),
   PRIMARY KEY (`policy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

CREATE TABLE `lm_leave_policy_details` (
   `policy_id` int(3),
   `leave_type_id` int(3),
   `credit_value` float,
   `credit_day` int(2)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `lm_user_leave_policy` (
   `username` varchar(255) not null,
   `policy_id` int(10),
   PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `lm_leave_register` (
   `username` varchar(255) not null,
   `leave_type_id` int(3),
   `date` int(10),
   `transaction` enum('debit','credit'),
   `transaction_source` varchar(50),
   `value` float,
   `leave_no` int(10)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `config_ezportal` (`site_name`, `site_logo_path`, `site_banner_path`, `site_banner_height`, `user_photo_path`, `ezq_url`, `ftr_leave`, `ftr_leave_balance`, `ftr_leave_credit`, `ftr_expenses`, `expense_currency`, `expense_prefix`, `company`, `company_address`, `leave_calendar_start`, `compensatory_leave_validity`) VALUES 
('Intranet', 'http://portal.yourcompany.com/data/images/logo.png', 'http://portal.yourcompany.com/data/banner.php', '50', '../ezhr/data/user_photos', 'http://portal.yourcompany.com/ezportal/my_profile/', '1', '1', '1', '1', 'Rs.', '11-12', 'Your Company Inc', 'This Street, That City, Our World 76543', '1', '30','hrnotifications@company.com');
