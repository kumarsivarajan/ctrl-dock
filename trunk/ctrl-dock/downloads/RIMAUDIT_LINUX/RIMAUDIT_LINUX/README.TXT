RIMAUDIT LINUX CLIENT
-----------------------
This tool collects system information and shares the same to an OpenAudit Server.
For ease of use, the tool has been packaged so that it can be run from the command line and can suitably be scheduled as a cronjob for periodic audit.


TO AUDIT A SYSTEM
-----------------
Simply run the file runaudit.sh with the URL of the Host to which you wish to post the audit information.
For Eg : ./runaudit.sh http://www.xyz.com

To confirm that the RIMAUDIT Client is working fine, run the above command and check to see if the system gets listed in the list of audited systems on the RIMCLIENT Console.
The RIMAUDIT Client normally takes about 45 to 60 seconds to collect system information and post it to the RIMCLIENT
