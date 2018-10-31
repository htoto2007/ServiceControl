<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/login.php");?>
<?
	$PAGE = $_GET['section'];
	$SUBPAGE = $_GET['subsection'];
	$MODEL = $_GET['model'];
	$SUBMODEL = $_GET['submodel'];
	//var_dump($_GET);
	switch($PAGE){
		case "home":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/home.php");
		break;
		case "apartmetsList":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/apartmetsList.php");
		break;
		case "addApartment":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/addApartment.php");
		break;
		case "apartment":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/apartment.php");
		break;
		case "entry":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/entry.php");
		break;
		case "exit":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/exit.php");
		break;
		case "counters":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/counters.php");
		break;
		case "registration":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/registration.php");
		break;
		case "newUser":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/newUser.php");
		break;
		case "privateExpenses":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/privateExpenses.php");
		break;
		case "generalsExpenses":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/generalsExpenses.php");
		break;
		case "apartmentStateTable":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/apartmentStateTable.php");
		break;
		case "users":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/users.php");
		break;
		case "addTitlesGeneralsExpenses":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/addTitlesGeneralsExpenses.php");
		break;
		case "user":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/user.php");
		break;
		case "generalsExspensesTable":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/generalsExspensesTable.php");
		break;
		case "apartmentCard":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/apartmentCard.php");
		break;
		case "salaryTable":
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/salaryTable.php");
		break;
		default:
			include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/home.php");
		break;
	}
?>