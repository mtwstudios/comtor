<?
//check for session id
session_start();
if(!isset($_SESSION['userID'])) {
	include("redirect.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta name="generator" content="HTML Tidy, see www.w3.org">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Comment Mentor</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<style type=text/css>
#body{width:80%;}
#report{border:double; padding: 10px; font-size: 20px; text-align:left; margin-bottom:15px;}
#reportList {width:300px;  margin-left:auto; margin-right:auto;}
#class{font-size: 18px; font-weight: bold}
#method{padding-left:25px; padding-top:5px; font-size: 14px; font-style: italic}
#comment{padding-left:50px; font-size: 12px}
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<center>

<hr noshade="noshade" width="65%"/>
<code> /* // # rem ' /** (* // */ // rem ' # # /**/ */ (* *) ' rem *) </code>
<hr noshade="noshade" width="65%"/>

<table cellpadding="1" cellspacing="0" border="0" width="95%">
 <tr></tr>
 <tr>
  <td align="center">
	<table id="frame" cellpadding="3" cellspacing="3" border="0">
	 <tr>
	  <td>&nbsp;</td>
	  <td>
		<table cellpadding="0" cellspacing="0">
		 <tr>
		  <td align="center">
		  <img alt="ComTor" src="img/comtor.png" border="0">
		  </td>
		 </tr>
		</table>
	  </td>
	  <td>&nbsp;</td>
	 </tr>
	</table>
  </td>
 </tr>
</table>

<br><br>
	
<table cellpadding="1" cellspacing="1" border="0">
 <tr>
  <td>[<a href="topten.jsp">Top 10 Comments</a>] </td>
  <td>[<a href="moderate.jsp">Moderate Comments</a>] </td>
  <td>[<a href="features.php">Features We Measure</a>] </td>
  <td>[<a href="faq.php">FAQ</a>] </td>
  <td>[<a href="comtor.tar.gz">Download</a>] </td>
 </tr>
</table>
<table cellpadding="1" cellspacing="1" border="0">
 <tr>
  <td>[<a href="index.php">Home</a>] </td>
	<?	
  	if(isset($_SESSION['userID']) && ($_SESSION['userID'] != ""))
	{
	  ?><td>[<a href="changePasswordForm.php">Change Password</a>] </td>
		<td>[<a href="reports.php">View Report</a>] </td>
	 	<td>[<a href="disableAccount.php">Disable Account</a>] </td>
	 	<td>[<a href="logout.php">Logout</a>] </td><?
	}
	else
	{
		?><td>[<a href="registerForm.php">Create An Account</a>] </td>
  		<td>[<a href="recoverPasswordForm.php">Password Recovery]</a> </td><?
	}
	?>
 </tr>
</table><?

if($_SESSION['acctType']=="admin")
{?>
<table cellpadding="1" cellspacing="1" border="0">
 <tr>
  <td>[<a href="manageAccounts.php">Account Management</a>] </td>
  <td>[<a href="adminReports.php">Admin Reports</a>] </td>
 </tr>
</table><?
}?> 

<br><br>
	
<!-- InstanceBeginEditable name="EditRegion" -->

<div id="body">
<?
//connect to database
include("connect.php");

//checks for admin permissions, else use current user id
if((isset($_GET['id'])) && ($_SESSION['acctType'] == "admin"))
{
	$userID = $_GET['id'];
}
else {
	$userID = $_SESSION['userID'];
}

//display current user information
$userInfo = mysql_query("SELECT * FROM users WHERE userID='$userID'");
$row = mysql_fetch_array($userInfo);
?><div id="reportList"><?
echo $row['name'] . "<br>";
echo $row['email'] . "<br>";
echo $row['school'] . "<br><br>";
?></div><?

// if there is no report selected, show list of user's reports
if(!isset($_GET['report'])) {
	?><div id="class">--System Usage--</div><?
	//display name of report
	$query = mysql_query("SELECT * FROM reports");
	while($row = mysql_fetch_assoc($query))
	{
		$name = $row['reportName'];
		$id = $row['reportID'];
		
		echo "" . $name . " - ";
		
		//calculate and display number of times the report was run
		$query2 = mysql_query("SELECT reportID FROM data WHERE reportID='$id' AND userID='$userID' GROUP BY dateTime, userID");
		$numRows = mysql_num_rows($query2);
		echo "selected " . $numRows . " times<br>";
	}
	
	//display list of reports
	?><br><div id="class">--Reports--</div><?
	$times = mysql_query("SELECT dateTime FROM data WHERE userID='$userID' GROUP BY dateTime ORDER BY dateTime desc");
	while($row = mysql_fetch_assoc($times)) {
		$dateTime = $row['dateTime'];
		$displayDateTime = formatDateTime($dateTime);
		?><div id="reportList"><? echo "<a href=\"reports.php?id=$userID&report=$dateTime\"> $displayDateTime </a><br>"; ?></div><?
	}
}	
//if a report is selected, display report
else
{
	$dateTime = $_GET['report'];
	$userID = $_GET['id'];
	
	$query = mysql_query("SELECT * FROM reports");
	while($row = mysql_fetch_assoc($query))
	{
		$reportID = $row['reportID'];
		$name = $row['reportName'];
		$description = $row['reportDescription'];
	
		$report = mysql_query("SELECT * FROM data WHERE userID='$userID' AND reportID='$reportID' AND dateTime='$dateTime' ORDER BY attribute");
		if (mysql_num_rows($report) > 0) {
			?><div id="report"><? echo $name . " (" . $description . ")";
			
			//checks the index to see whether the attribute is a class, method, or comment
			//the index is from the property list, examples shown below
			while($row = mysql_fetch_assoc($report)) {
				$index = $row['attribute'];
					//property list index - 011
					if(strlen($index) == 3) {
						?><hr><div id="class"><? echo $row['value']; ?></div><?
					}
					//property list index - 011.002
					else if(strlen($index) == 7) {
						?><div id="method"><? echo $row['value']; ?></div><?
					}
					//property list index - 001.002.a 
					else if(strlen($index) > 7) {
						?><div id="comment"><? echo $row['value']; ?></div><?
					}	
			}
			?></div><?
		}
	}
}	

//formate date
function formatDateTime($timestamp)
{
    $year=substr($timestamp,0,4);
    $month=substr($timestamp,5,2);
    $day=substr($timestamp,8,2);
    $hour=substr($timestamp,11,2);
    $minute=substr($timestamp,14,2);
    $second=substr($timestamp,17,2);
	$date = date("M d, Y -- g:i:s A", mktime($hour, $minute, $second, $month, $day, $year));
	RETURN ($date);
}
?>
</div>

<!-- InstanceEndEditable -->

<br><br>
<hr noshade="noshade" width="65%"/>
<font size="2">
<a href="about.php">About Comment Mentor</a> | &copy; 2006 TCNJ
</font>
<br/><br/>
<a href="http://www.tcnj.edu"><img src="img/tcnj_logo-small.gif" border="0"></a>
</center>
</body>
<!-- InstanceEnd --></html>