<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV341 Email Contact Form Handler</title>
	<link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
</head>

<!-- 5. The formHandler.php will do the following things:

		-The email message will include the information from the form. It will be formatted 
				in a readable, conversation format.
		-The email message will Include the date of contact in the mm/dd/yyyy format.
		-It will send a confirmation email to the Contact Email Address.  

			--This confirms to the customer that you have received the customer's information 
				and will respond to it.
			--This email should be formatted using HTML and CSS.  It should look like it is 
				from the same site as the form page. 

		-It will also send an email to YOU with the form information.  In this case you are 
				acting as the point of contact for the client.  

			--This email should be formatted as a list showing all information provided by the customer.
			--It should include the date of contact in mm/dd/yyyy format.
			--I would recommend using your personal email address.  You can use your DMACC address 
				but it may not come through. You could send it to your email@yourhost.com and 
				explore that process.

		gullydsm@gmail.com     
-->



<body>
	<div class="wrapper">
		<header>
			<h1>WDV341 Intro PHP</h1>
			<h2>PROJECT: Email Contact Form </h2>
		</header>
		<section class="frame">
			<?php
			$firstName = $_POST["first_name"];
			$lastName = $_POST["last_name"];
			$temp_reason = $_POST["reason"];
			$reason = '';
			$comments = $_POST["comments"];
			$date = date('m/d/Y');

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

			$to = $_POST["email"];
			$subject = "Contact Request WDV341: " . $reason;
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
				mail($admin, $reason, $admin_content, $headers);
				if (mail($to, $subject, $htmlContent, $headers)) {
					echo $successMsg;
				} else {
					echo "Message failed to send. Please try again.";
				}
			} catch (Exception $e) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
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