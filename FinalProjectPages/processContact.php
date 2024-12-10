<?php
session_start();
if ($_SESSION['validUser'] !== "valid") {
	//you are NOT a valid user and CANNOT access this page
	header("Location: login.php");      //server side redirect
}

$today = date_format(date_create(), "Y");
?>

<!DOCTYPE html>


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>microMANAGER contact page</title>
	<link rel="stylesheet" type="text/css" href="Styles/stylesheet_flex_responsive.css">
</head>

<body>
	<div class="wrapper">
		<header>
		</header>

		<nav class="footer">
			<a class="linkOnDark" href="finalIndex.php">microMANAGEMENT Home</a>
			<a class="linkOnDark" href="about.php">About microMANAGER</a>
			<a class="linkOnDark" href="contact.php">Contact US</a>
			<?php
			if ($_SESSION['validUser'] === "valid") {
				echo "<a class='linkOnDark' href='logout.php'>Logout</a>";
			} else {
				echo "<a class='linkOnDark' href='login.php'>Login</a>";
			}
			?>
		</nav>
		<section class="frame">

			<?php
			if ($_SESSION['validUser'] === "valid") {
			?>
				<div class="sidenav">
					<ul>
						<p><a class="linkOnDark" href="inputUserForm.php">Add New User</a></p>
						<p><a class="linkOnDark" href="viewAllUsers.php">View All Users</a></p>
						<p><a class="linkOnDark" href="inputProjectForm.php">Add New Project</a></p>
						<p><a class="linkOnDark" href="viewAllProjects.php">View All Projects</a></p>
					</ul>
				</div>
			<?php
			}
			?>
			<div class="article">
				<h1>Contact microMANAGER</h1>
				<h2>Email Contact Form </h2>
				<?php
				$inCity = $_POST['city'];
				$inName = $_POST['name'];
				
				if ($inCity === "" && $inName ==="") {         		
				
				
				$firstName = $_POST["first_name"];
				$lastName = $_POST["last_name"];
				$temp_reason = $_POST["reason"];
				$reason = '';
				$comments = $_POST["comments"];
				$date = date('m/d/Y');


				if ($temp_reason == 'services') {
					$reason = 'Sign-up for Services';
				} elseif ($temp_reason == 'help') {
					$reason = 'Site Suggestion(s)';
				} elseif ($temp_reason == 'suggestion') {
					$reason = 'Customer Service';
				} elseif ($temp_reason == 'suggestion') {
					$reason = 'General Suggestion)';
				} elseif ($temp_reason == 'job') {
					$reason = 'Job Opportunity)';
				} else {
					$reason = 'Other';
				}

				$to = $_POST["email"];
				$subject = "Contact Request microMANAGER: " . $reason;
				$htmlContent = '
			<html>
			<head>
				<title>Contact Request Automated Response</title>
				<style>
        			th {
            			background-color: lightslategray;
        			}

        			table {
            			width: 75%;
						border-collapse: collapse;
        			}

        			td {
						text-align: left;
						word-wrap: wordwrap;
						padding-bottom: 5px;
					}
						</style>
			</head>
			<body>
				<p></p>
				<table>
					<tr>
						<th><h1>  microMANAGER </h1></th>
					</tr>
					<tr>
						<th><h2> Contact Form </h2></th>
					</tr>
					<tr>
						<td>Hello ' . $firstName . ' ' . $lastName . ',</td>
					</tr>
					<tr>
						<td>	Thank you for contacting the Misti C website on ' . $date . '. Your message has been 
							sent to the appropriate location for processing. You can expect to get 
							a response within two(2) business days. Below is a summary of your contact
							request:
							 
						</td>
					</tr>
					<tr>
						<td>Contact Reason: ' . $reason . '</td>
					</tr>
					<tr>
						<td>Comments: ' . $comments . '</td>
					</tr>
					<tr>
						<td>Thank you for visiting!</td>
					</tr>
					<tr>
						<td>Misti C</td>
					</tr>
					<tr>
						<th><a class="" href="https://wdv101.misti.pessimistic-it.com/wdv341/homework/6-1EmailContactForm/contactPage.html">wdv101.misti.pessimistic-it.com</a></th>
					</tr>
				</table>
			</body>
			</html>';

				//set content-type header for html email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				//additional headers
				$headers .= 'From: ' . "\r\n";
				$headers .= 'Cc: ' . "\r\n";
				$headers .= 'Bcc: ' . "\r\n";

				$successMsg = '<h3>Your message has been sent!</h3>
			<p>Thank you for reaching out!</p>
			<p>A confirmation email has been sent to ' . $to . '.</p>';

				//send confirmation email to user
				try {
					//send contact request form content
					$admin = "codeine500@hotmail.com";
					$admin_content = '
					<html>
					<head>
						<title>Contact Request Automated Response</title>
					</head>
					<body>
					<table>
						<tr>
							<td>Contact Date: ' . $date . '</td>
						</tr>
						<tr>
							<td>First Name: ' . $firstName . '</td>
						</tr>
						<tr>
							<td>Last Name: ' . $lastName . '</td>
						</tr>
						<tr>
							<td>Email: ' . $to . '</td>
						</tr>
						<tr>
							<td>Reason for contact: ' . $reason . '</td>
						</tr>
						<tr>
							<td>Comments: ' . $comments . '</td>
						</tr>
					</table>
					</body>
					</html>
					';

					// echo $firstName;
					// echo $lastName;
					// echo $temp_reason;
					// echo $comments;
					// echo $date;
					// echo $to;
					// echo $subject;
					// echo $htmlContent;
					// echo $headers;
					// echo $admin;
					// echo $admin_content;

					mail($admin, $reason, $admin_content, $headers);
					if (mail($to, $subject, $htmlContent, $headers)) {
						echo $successMsg;
					} else {
						echo "Message failed to send. Please try again.";
					}

				} else {
					//Something is in the field - MOST likely a BOT has accessed our form
					//DO NOT PROCESS form
					//Can test by making form field visible and entering something in the field
					die("This BOT will not process the form");
				
					//redirect to login page or index/home page		
					header("Location: finalIndex.php");      //server side redirect		
					}
				} catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
				}
				?>
				<p></p>
			</div>
		</section>
		<div class="footer">
			<a class="" href="../wdv341Homework.php">WDV341 Homework Page</a>
			<a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
			<a class="" href="../../../index.html">Christianson Home Page</a>
		</div>
		<div style="text-align: center;">
			<p>Copyright &#169 <?php echo $today ?> microMANAGER All rights reserved.
			<p>
		</div>
		<p>&nbsp;</p>
	</div>

</body>

</html>