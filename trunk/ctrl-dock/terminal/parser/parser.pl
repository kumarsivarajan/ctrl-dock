#!/usr/bin/perl
use strict;
use warnings;
use Mysql;
use Time::Local;

open IN, '/var/log/anytermd.log' or die 'Could not open anyterm log';
open OUT, '>output.txt' or die 'Could not open output file';

my $user = '';
my @users = ();
if (0 == length($ARGV[0])){
	$user = 'root';
} else{
	$user = $ARGV[0];
}
my $user_count=0;
my $cmd = '';
my %usercmd = ();
my $year = 2011;
my %months = 	qw(
					jan 1 feb 2 mar 3 apr 4 may 5 jun 6
					jul 7 aug 8 sep 9 oct 10 nov 11 dec 12
				);

#MySQL related declarations
my $host = "localhost";
my $database = "uttam";
my $tablename = "audit";
my $sqluser = "uttam";
my $sqlpw = "uttam";

# PERL MYSQL CONNECT()
my $connect = Mysql->connect($host, $database, $sqluser, $sqlpw);

# SELECT DB
$connect->selectdb($database);

# For Demo - TRUNCATE Audit table before use;
#Insert row into database
#my $tr_sql_query = "DELETE FROM audit where audit_record_type='SSH'";
#my $execute = $connect->query($tr_sql_query);

#my $auto_sql_query = "ALTER TABLE audit AUTO_INCREMENT=1";
#my $executee = $connect->query($auto_sql_query);


#Begin while loop for getting all sessions started.
while (<IN>){
	chomp();
	#print OUT "String under test: $_\n";
	# DEFINE A MySQL QUERY
			my $execute = "SELECT audit_timestamp FROM $tablename order by audit_id desc limit 1";
			my @results='';
			# EXECUTE THE QUERY FUNCTION
			$execute = $connect->query($execute);

			# FETCHROW ARRAY
			my $atimestamp='';
			while (@results = $execute->fetchrow()) {
			$atimestamp=$results[0];
			
			}
			#my $readable_time = localtime($atimestamp);
			
			#open FILE, "</var/log/anytermd.log";
			#my @lines = <FILE>;
			#print "Lined that matched $readable_time\n";
			#for (@lines) {
			#if ($_ =~ /$readable_time/) {
			#	print "$_\n";
			#}
			#}

			#print "$readable_time\n";
	if (m/Starting New Session for User /){
		m/(\w+)\s+(\d+) (\d+):(\d+):(\d+)(.*)Starting New Session for User .(.*)./;
		if (($user eq $3) or ($user eq 'all')){
			my $unixtime = timelocal($5,$4,$3,$2, $months{lc substr($1, 0,3)}-1,$year);
			print OUT "$1 **** User $6 **** Logged in\n";
		}
	}
	elsif (m/(\w+)\s+(\d+) (\d+):(\d+):(\d+)(.*)anytermd(.*)Session ID .(.*)., User .(.*)@(.*) (.*) (.*)., Key .(.*)./){
		if (exists $usercmd{$8}){
		}
		else{
			#print OUT "$1 $2 $3:$4:$5 **** User $9 **** Host $10 **** Session $8 **** Created New Session\n";
			my $unixtime = timelocal($5,$4,$3,$2, $months{lc substr($1, 0,3)}-1,$year); #Beware!!! timelocal uses Month indexed by 0 - Jan-0, Feb = 1.
			#Insert row into database
			if($atimestamp < $unixtime)
			{
			my $my_sql_query = "INSERT INTO $tablename 
			(audit_timestamp, audit_username, audit_ssnname, audit_hostname, audit_command,audit_comments,audit_luser,audit_record_type) 
			VALUES ('$unixtime', '$9', '$8', '$10', '', 'New Session Created','$12','SSH')";
			my $execute = $connect->query($my_sql_query);
			}
			$usercmd{$8}='';
		}
		my $len = length ($13);
		my $offset = 0;
		#print OUT "Length of key is $len\n";
		while ($offset < $len){
			my $tmpStr = substr($13, $offset, 1);
			if (ord($tmpStr) == 8){ #User hit backspace; chop the last entered key
				chop($usercmd{$8});
				#print OUT "Encountered Backspace at $1\n";
			}
			elsif (ord($tmpStr) == 13){ #User hit the Enter Key.
				if (length($usercmd{$8}) > 0){
					#print OUT "$1 $2 $3:$4:$5 **** User $9 **** Host $10 **** Session $8 **** Executed Command - $usercmd{$8}"."\n"; 
					my $unixtime = timelocal($5,$4,$3,$2, $months{lc substr($1, 0,3)}-1,$year); #Beware!!! timelocal uses Month indexed by 0 - Jan-0, Feb = 1
					#Insert row into database
					if($atimestamp < $unixtime)
					{
					my $my_sql_query = "INSERT INTO $tablename 
					(audit_timestamp, audit_username, audit_ssnname, audit_hostname, audit_command, audit_luser,audit_record_type) 
					VALUES ('$unixtime', '$9', '$8', '$10', '$usercmd{$8}', '$12','SSH')";
					my $execute = $connect->query($my_sql_query);
					}
					$usercmd{$8} = '';
				}

			}	
			else{
				$usercmd{$8} = $usercmd{$8}.$tmpStr;
			}
			$offset = $offset + 1;
		}
	}
	else{
		#print OUT "$usercmd{$8}...Error in parsing\n";
	}
}

