<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV341 Email Contact Form Handler</title>
	<link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
</head>

<!-- 
	Check if form was submitted via post
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		--proceed as normal
		else-reject; redirect to home page
			send email to admin stating bot attempt to access contact page	(method??)
	Check for honeypot fields to be empty
		If(empty)
		--proceed as normal
		else-reject; redirect to home page
			send email to admin stating bot attempt to access contact page	(method??)

	If both clear; proceed to process contact request
		-confirmation email sent to requestor
		-email of contact sent to admin	(method??)

-->




<body>
	<div class="wrapper">
		<header>
			<h1>WDV341 Intro PHP</h1>
			<h2>PROJECT: Email Contact Form </h2>
		</header>
		<section class="frame">
			<?php


			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				//pull in form information to place in emails and check honeypot
				$inCity = $_POST['city'];
				$inName = $_POST['name'];
				$firstName = $_POST["first_name"];
				$lastName = $_POST["last_name"];
				$temp_reason = $_POST["reason"];
				$comments = $_POST["comments"];
				$date = date('m/d/Y');
				$to = $_POST["email"];

				//set reason string
				$reason = '';
				$subject = "Contact Request WDV341: " . $reason;
				if ($temp_reason == 'opinion') {
					$reason = 'Just Because';
				} elseif ($temp_reason == 's_suggestion') {
					$reason = 'Site Suggestion(s)';
				} elseif ($temp_reason == 'suggestion') {
					$reason = 'General Suggestion(s)';
				} elseif ($temp_reason == 'job') {
					$reason = 'Job Opportunity(ies)';
				} else {
					$reason = 'Other';
				}

				//set admin address and headers
				$admin = "codeine500@hotmail.com";

				//set content-type header for html email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				//additional headers
				$headers .= 'From: ' . "\r\n";
				$headers .= 'Cc: ' . "\r\n";
				$headers .= 'Bcc: ' . "\r\n";

				if ($inCity === "" && $inName === "") {
					//send confirmation email to user
					try {
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
						<th><h1>WDV341 Intro PHP</h1></th>
					</tr>
					<tr>
						<th><h2>Unit-6 Email Contact Form </h2></th>
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

						$successMsg = '<h3>Your message has been sent!</h3>
			<p>Thank you for reaching out!</p>
			<p>A confirmation email has been sent to ' . $to . '.</p>';


						//send contact request form content
						$admin_content = '
					<html>
					<head>
						<title>Contact Request Automated Response PHP Homework:</title>
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
						mail($admin, $reason, $admin_content, $headers);
						if (mail($to, $subject, $htmlContent, $headers)) {
							echo $successMsg;
						} else {
							echo "Message failed to send. Please try again.";
						}
					} catch (Exception $e) {
						echo 'Caught exception: ', $e->getMessage(), "\n";
					}
				} else {	//if there is something entered in the honeypot field
					//redirect to the home page and sent email to admin about 
					//possible bot attempt
					try {
						$admin_content = '
							<html>
							<head>
								<title>Possible BOT Attempt PHP Homework: HONYPOT Failure</title>
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
					} catch (Exception $e) {
						echo 'Caught exception: ', $e->getMessage(), "\n";
					}
					mail($admin, $reason, $admin_content, $headers);
					//Can test by making form field visible and entering something in the field
					die("This BOT will not process the form");

					//redirect to login page or index/home page		
					header("Location: finalIndex.php");      //server side redirect		
				}
			} else { 	//This page should only be accessable through the contact form page
				// access through any other means besides POST should not be allowed
				//redirect to the home page and sent email to admin about 
				//possible bot attempt
				try {
					$admin_content = '
							<html>
							<head>
								<title>Possible BOT Attempt PHP Homework: NON-POST</title>
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
				} catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
				}
				mail($admin, $reason, $admin_content, $headers);
				//Can test by making form field visible and entering something in the field
				die("This BOT will not process the form");

				//redirect to login page or index/home page		
				header("Location: finalIndex.php");      //server side redirect
			}
			?>
			<p></p>
		</section>
		<div class="footer">
			<a class="" href="../../wdv341Homework.php">WDV341 Homework Page</a>
			<a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
			<a class="" href="../../../index.html">Christianson Home Page</a>
		</div>

		<p>&nbsp;</p>
	</div>

</body>

</html>