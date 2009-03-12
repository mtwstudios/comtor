<?php

require_once("config.php");

session_start();
//check for session id
if(!isset($_SESSION['userId']))
{
  header("Location: http://" . URL_PATH . "/loginForm.php");
  exit;
}

require_once("smarty/Smarty.class.php");
require_once("XML/RSS.php");

$tpl = new Smarty();

require_once("header1.php");

if ($_SESSION['acctType'] == "student")
  $tpl->assign("url", "dropbox.php");
  
if ($_SESSION['acctType'] == "admin")
{ 
  // Get number of requests
  $requests = getNumPendingRequests();
  if ($requests !== false)
    $tpl->assign('requests', $requests);
}

// Fetch template
$tpldata = $tpl->fetch("welcome.tpl");

// Assign breadcrumbs
$breadcrumbs = array();
$breadcrumbs[] = array('text' => 'COMTOR', 'href' => 'index.php');
$tpl->assign('breadcrumbs', $breadcrumbs);

// Assign page html
$tpl->assign('tpldata', $tpldata);

// Display template
$tpl->display("htmlmain.tpl");

?>
