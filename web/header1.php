<?php

// Check that user did not switch from development server to production or visa versa
if (isset($_SESSION['userId']) && isset($_SESSION['dev_server']) && $_SESSION['dev_server'] != DEVELOPMENT)
{
  session_destroy();
  session_start();
//  $_SESSION['msg']['error'] = "You have switched from the " . (DEVELOPMENT ? "Development" : "Production") . " site to the " . (DEVELOPMENT ? "Production" : "Development") . " site.  Please logout and log back in to the appropriate server.";
  require_once("redirect.php");
}

require_once("connect.php");

// Checks for a course parameter
if (!isset($courseId))
  $courseId = null;
if (isset($_GET['courseId']) && is_numeric($_GET['courseId']))
{
  $courseInfo = null;

  // Check that course exists
  if (courseExists($_GET['courseId']))
  {
    // Determine professor name
    if (($courseInfo = getCourseInfo($_GET['courseId'])) !== false)
      $courseInfo['profName'] = getUserNameById($courseInfo['profId']);
  }
  else
  {
    $_SESSION['msg']['error'] = "Course does not exist.";
    header ("Location: index.php");
    exit;
  }

  // Set the courseId if user is admin or professor of the course
  if ($_SESSION['acctType'] == "admin")
    $courseId = $_GET['courseId'];
  else if ($_SESSION['acctType'] == "professor")
  {
    // Check that the course id is for the given professor
    if ($courseInfo['profId'] == $_SESSION['userId'])
      $courseId = $_GET['courseId'];
    // Indicate error and redirect
    else
    {
      $_SESSION['msg']['error'] = "You are not professor for this course.";
      header ("Location: courseManage.php");
      exit;
    }
  }
  else
  {
    // Check if student is in course
    if (isUserInCourse($_SESSION['userId'], $_GET['courseId']))
      $courseId = $_GET['courseId'];
    // Indicate error and redirect
    else
    {
      $_SESSION['msg']['error'] = "You are not enrolled in this course.";
      header ("Location: courses.php");
      exit;
    }
  }

  $_SESSION['courseInfo'] = $courseInfo;
  $_SESSION['courseId'] = $courseId;
}

if (isset($_GET['courseId']) && $courseId != $_GET['courseId'])
  unset($_GET['courseId']);

if (isset($_SESSION['username']))
{
  if ($_SESSION['acctType'] == "admin")
    $userCourses = getCourses(false, false, false, 'enabled');
  else if ($_SESSION['acctType'] == "professor")
    $userCourses = getProfCourses($_SESSION['userId'], 'enabled');
  else
    $userCourses = getCourses($_SESSION['userId'], false, false, 'enabled');
  if ($userCourses !== false)
    $tpl->assign('courses', $userCourses);
}

class Link
{
  var $href;
  var $name;
  var $attrs = array();

  function Link($name, $href)
  {
    $this->name = $name;
    $this->href = $href;
  }

  function addAttr($attr, $value)
  {
    array_push($this->attrs, new Attribute($attr, $value));
  }
}

class Attribute
{
  var $attr;
  var $value;

  function Attribute($attr, $value)
  {
    $this->attr = $attr;
    $value = str_replace('"', '\'', $value);
    $this->value = $value;
  }
}


/* Create array of links to go in the Modules Sidebar */
$moduleLinks = array();

// Random string added to important links for security
$md5Rand = md5(session_id());

// Create array of links that are to be shown for each account type
if (isset($_SESSION['acctType']) && isset($_SESSION['courseId']))
{
  array_push($moduleLinks, new Link('Dropbox', 'dropbox.php?courseId='.$_SESSION['courseId']));
  array_push($moduleLinks, new Link('E-mail', 'course_email.php?courseId='.$_SESSION['courseId']));

  // Submit files or Welcome message
  if ($_SESSION['acctType'] == 'student')
    array_push($moduleLinks, new Link('Submit Files', 'submit.php?courseId='.$_SESSION['courseId']));
}

// Show the Modules Sidebar if there are links that go in it
$tpl->assign('modules', $moduleLinks);

$comtorLinks = array();
if (!isset($_SESSION['acctType']))
{
  array_push($comtorLinks, new Link("Login", "loginForm.php"));
  array_push($comtorLinks, new Link("Create An Account", "registerForm.php"));
  array_push($comtorLinks, new Link("Password Recovery", "recoverPasswordForm.php"));
}
else
{
  // Add links for all account types
  array_push($comtorLinks, new Link("Welcome", "index.php"));
  array_push($comtorLinks, new Link("System Usage", "usage.php"));

  if ($_SESSION['acctType'] == "admin")
    array_push($comtorLinks, new Link("Admin Reports", "adminReports.php"));

  // Account Management for Admin
  if ($_SESSION['acctType'] == "admin")
    array_push($comtorLinks, new Link("Account Management", "manageAccounts.php"));
  else
    array_push($comtorLinks, new Link("Account Management", "editAccount.php"));

  // E-mail Notification Options - Professor and Student
  if ($_SESSION['acctType'] == "professor" || $_SESSION['acctType'] == "student")
    array_push($comtorLinks, new Link("E-mail Notifications", "email_notify_edit.php"));

  array_push($comtorLinks, new Link("Requests", "requests.php"));

  /*
  // Add links for all account types
  array_push($comtorLinks, new Link("Change Password", "changePasswordForm.php"));

  // Disable account link
  $link = new Link("Disable Account", "disableAccount.php?userId={$_SESSION['userId']}&amp;rand={$md5Rand}");
  $link->addAttr("onclick", "return confirm(\"Are you sure you want to disable your account?\");");
  array_push($comtorLinks, $link);
  */

  // Determine page for Course Management
  if ($_SESSION['acctType'] == "student")
  {
    array_push($comtorLinks, new Link("Course Management", "courses.php"));
  }
  else if($_SESSION['acctType'] == "professor")
  {
    array_push($comtorLinks, new Link("Course Management", "courses.php"));
  }
  else if ($_SESSION['acctType'] == "admin")
  {
    array_push($comtorLinks, new Link("Course Management", "courses.php"));
  }

  // Add Course - Professor and Admin
  if ($_SESSION['acctType'] == "professor" || $_SESSION['acctType'] == "admin")
  {
    array_push($comtorLinks, new Link("Add Course", "courseAddForm.php"));
  }

  // Add Doclet - Admin
  if ($_SESSION['acctType'] == "admin")
    array_push($comtorLinks, new Link("Add Doclet", "doclet_add.php"));

  // View Reports - All account types
  array_push($comtorLinks, new Link("View All Reports", "reports.php"));
}

$tpl->assign('comtorLinks', $comtorLinks);


// Show success message if any
if (isset($_SESSION['msg']['success']))
  $tpl->assign('success', $_SESSION['msg']['success']);
// Show error message if any
if (isset($_SESSION['msg']['error']))
  $tpl->assign('error', $_SESSION['msg']['error']);

// Remove the messages in the session
if (isset($_SESSION['msg']))
  unset($_SESSION['msg']);

?>