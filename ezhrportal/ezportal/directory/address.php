<?
  include("../include/config.php"); 
  include("../include/db.php"); 

  $country=$_REQUEST["country"];

  $date=getdate();
  $report_date =$date[mday];
  $report_date .="-";
  $report_date .=$date[month];
  $report_date .="-";
  $report_date .=$date[year];
  $report_date .="-";
  $report_date .=$date[hours];
  $report_date .=$date[minutes];

  $filename="AddressBook-";
  $filename .=$report_date;

  header("Content-Type: application/force-download");
  header("Content-disposition: attachment; filename=$filename.csv\n");

  $endofline = "\r\n";
  $Comma = ",";
  $Filler = "\"\"";

  echo "First Name,Last Name,Business Phone,Mobile Phone,Home Phone,E-mail Address,Business Country\r\n";

  $sql = "select a.first_name, a.last_name, a.contact_phone_office, a.contact_phone_mobile,a.contact_phone_residence,a.official_email, b.country from user_master a, office_locations b where a.office_index=b.office_index and account_status='Active' and b.country='$country'";
  $sql .=" order by first_name";
  $result = mysql_query($sql);
  while ($row = mysql_fetch_row($result)) {
	echo "$row[0]";	//First Name
	echo "$Comma";
	echo "$row[1]";	//Last Name
	echo "$Comma";
	echo "$row[2]";	//Business Phone
	echo "$Comma";
	echo "$row[3]";	//Mobile Phone
	echo "$Comma";
	echo "$row[4]";	//Home Phone
	echo "$Comma";
	echo "$row[5]";	//EMail Address
	echo "$Comma";
	echo "$row[6]";	//Business Country
	echo "$Comma";
	echo "$endofline";
  }
?>
