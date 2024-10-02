`<?php
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$email = $_POST["email"];
	$academic_standing = $_POST["academic_standing"];
	$standing = "";
	$inmajor = $_POST["major"];
	$major = "";

	function setAcademicStanding($academic_standing)
	{
		if ($academic_standing == "highschool") {
			$standing = 'High School Student';
		}
		if ($academic_standing == "freshman") {
			$standing = "College Freshman";
		}
		if ($academic_standing == "sophmore") {
			$standing = "College Sophmore";
		}
		echo $standing;
	}

	function setMajor($inmajor)
	{
		if ($inmajor == "cis") {
			$major = "Computer Information Systems";
		}
		if ($inmajor == "gd") {
			$major = "Graphic Design";
		}
		if ($inmajor == "wd") {
			$major = "Web Development";
		}
		echo $major;
	}




	?>
<!DOCTYPE html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WDV101 Basic Form Handler Example</title>
	<link rel="stylesheet" type="text/css" href="../styles/stylesheet_flex_responsive.css">
</head>

<body>
	<div class="wrapper">
		<header>
			<h1>WDV101 Intro HTML and CSS</h1>
			<h2>UNIT 3 Forms - Lesson 2 Server Side Processes</h2>
		</header>
		<p>This page will demonstrate how a server side application will take the data that was entered on a form and display it within an HTML table. This example will work for any form. It is setup to read any or all fields on a form without needing any changes. Other applications are more specific to the form they process and require updates anytime the form is changed.</p>

		<h3>Instructions</h3>
		<ol>
			<li>Place the file name 'demonstrateFormHandler.php' in the action attribute of your form. This is using the default pathname and will look for this file in the same location as the form.html page. You may place server side processes in their own folder on the server. It is common to use a folder called 'files' which contains server side processes. In that case you would include the pathname in your action attribute. Example: action='files/demonstrateFormHandler.php' </li>
			<li>Move your form.html page AND this page to your host server.</li>
			<li>Use your browser to locate and run the form.html page on your host server. </li>
			<li>Complete the form and click Submit.</li>
		</ol>
		<p>The table below displays the 'name=value' pairs that were entered on the form and processed on the server. This page is a result of that server side process.</p>
		<p>The <strong>Field Name</strong> column contains the value of the name attribute for each field on the form. <em>Example: &lt;input name=&quot;first_name&quot;&gt;</em> This displays what you coded into the HTML. NOTE: If you do not have a name attribute for a field OR if the name attribute does not have a value the form will NOT send the data to the server.</p>
		<p>The <strong>Value of Field</strong> column contains the value of each field that was sent to the server by the form. This will vary depending upon the HTML form element and how the value attribute was used for a field.</p>
		<h3>Form Name-Value Pairs</h3>
		<?php

		echo "<table border='1'>";
		echo "<tr><th>Field Name</th><th>Value of Field</th></tr>";
		foreach ($_POST as $key => $value) {
			echo '<tr>';
			echo '<td>', $key, '</td>';
			echo '<td>', $value, '</td>';
			echo "</tr>";
		}
		echo "</table>";
		echo "<p>&nbsp;</p>";

		?>
		<p>Dear <?php echo ($_POST["first_name"]); ?> <?php echo ($_POST["last_name"]); ?>,</p>

		<p>Thank you for your interest in DMACC.</p>

		<p>We have you listed as a <?php setAcademicStanding($academic_standing) ?> starting this fall.</p>

		<p>You have declared <?php setMajor($inmajor); ?> as your major.</p>

		<p>Based upon your responses we will provide the following information in our confirmation email to you at <?php echo $_POST["email"]; ?>.</p>

		<p>
			<?php
			//$info = $_GET['connect'];
			echo "You chose the following contact option(s): <br><br>";
			//checking if checkbox was checked
			if (isset($_POST['connect1'])) {
				echo "Please contact me with program information <br>";
			}
			if (isset($_POST['connect2'])) {
				echo "I would like to contact a program advisor <br>";
			} else {
				echo "You did not choose a contact option. <br>";
			}
			?>
		</p>

		<!-- <p><?php echo $_POST["connect1"]; ?></p>

<p><?php echo $_POST["connect2"]; ?></p> -->

		<p>You have shared the following comments which we will review: </p>

		<p><?php echo $_POST["comments"]; ?></p>


		<div class="footer">
			<a class="" href="../wdv321Homework.html">Christianson Homework Page</a>
			<a href="https://github.com/mistichris/wdv341.git">Git Hub Link</a>
			<a class="" href="../../../index.html">Christianson Home Page</a>
		</div>
	</div>
</body>

</html>