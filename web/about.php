<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta name="generator" content="HTML Tidy, see www.w3.org">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Comment Mentor</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->

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

<table width="90%" cellpadding="1" cellspacing="1" border="0">
       <tr>
        <td align="left">
        The Comment Mentor was conceived in mid-2005 as an educational
        tool to assist both seasoned developers and new programmers
        learn better source code-level documentation strategies. Current
        conventions for documenting at the source level are not 
        well-codified. Because of this lack of standards, it is hard to
        empirically measure the &quot;quality&quot; of a comment, and
        therefore difficult to objectively measure comment quality over
        time or in relation to the developing code base.
        <P>
        Those folks responsible for teaching the science, art, hobby, and 
        job of programming (e.g., high-school teachers, college professors,
        technical advisors, and managers) often lack a tool for formally
        &quot;grading&quot; a student's (or developer/programmer's) comments.
        The state of the art amounts to hand-generated notes or verbal
        feedback at varying levels of detail. This details can range from
        the unhelpful &quot;OK, looks like you put a few comments in.&quot;  
        on a homework printout to precise criticism of how the comments (and
        code structure in general) deviates from accepted programming
        standards of the organization (often generated during a formal
        and exhausting peer code review). This range illustrates that
        comment &quot;grading&quot; is an imprecise, labor-intensive
        procedure at best.
        <P>
        As a result, there is little incentive to offer meangingful
        feedback, and little incentive for students and new programmers
        to actually improve their comment style and substance along with
        the code. New developers and student programmers really are not
        stakeholders in their code or assignments: they typically work
        on a piece of code short term (3 months at the most, and more
        typically a week or two) and throw it over the wall with little
        thought for maintenance.
        <P>
        Comment Mentor attempts to address these difficulties by providing
        a tool that automates the grading process. Not only does it assist
        the grader, it can assist the student or developer before code is
        submitted by making sure comments are at some threshold level of
        quality before code is submitted. Guessing games are, in large
        part, eliminated. Of course, some may still be tempted to game the
        system, but any improvement is likely to have a large impact.
        <P>
        Comment Mentor can be used as a web service and a command-line
        tool. It currently understands how to parse Java language source
        code because it takes advantage of the JavaDoc tool and API.
        Other languages are slated for development; we welcome your
        suggestions and help on developing the appropriate tools.
        <P>
        Comment Mentor is <b>not</b> a compiler. It doesn't alter your
        source code, only derives measurements from comments that are
        encoded a certain way.
        <P>
        Comment Mentor does <b>not</b> assess the quality of other
        software engineering documentation. In particular, it does
        not use design diagrams, requirements specification lists,
        dataflow diagrams, or other documents. We expect that some
        of this information is best described in those documents as
        well as source-level comments, and if this information is in
        comments, we can use it as part of our scoring model, but 
        Comment Mentor doesn't explicitly deal with those other
        types of documentation.
        <P>
        Good luck, and we hope you enjoy using the tool. We are happy to
        receive any feedback you may have at:
        <br/>
        <center> 
        <code>comtor [at] tcnj &lt;.&gt; edu</code>
        </center>
        You can also visit the 
        <a href="http://cs.tcnj.edu">CS Dept. website</a>.
        </td>
       </tr>
    </table>

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