<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact Us</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles.css">
</head>
<body>
	<?php
		require 'emailer.php';

		$isValid = false;
		$name = $email = $message = "";
		$nameErr = $emailErr = $messageErr = "";

		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = cleanInput($_POST["name"]);
			$email = cleanInput($_POST["email"]);
			$message = cleanInput($_POST["message"]);

			validate($name, $email, $message);

			if($nameErr == "" && $emailErr == "" && $messageErr == "") {
				$isValid = true;
				sendEmail($name, $email, $message);
			}
		}

		function cleanInput($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return($data);
		}
		
		function validate($name, $email, $message) {
			global $nameErr, $emailErr, $messageErr;
			
			// Name validation
			if(empty($name)) {
				$nameErr = "Name is required";
			} else if(!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
				$nameErr = "Invalid name";
			}

			// Email validation
			if(empty($email)) {
				$emailErr = "Email is required";
			} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "Invalid email";
			}

			// Message validation
			if(empty($message)) {
				$messageErr = "Message is required";
			}
		}

		function persistData($data, $err) {
			global $isValid;
			if($err == "" && $isValid == false) {
				echo $data;
			} else {
				echo "";
			}
		}

		function textareaPlaceholder() {
			global $messageErr;
			if($messageErr != "") {
				echo $messageErr;
			} else {
				echo "Enter your message here";
			}
		}
	?>
    <main id="container">
		<div id="header"><h1>Get in touch with us!</h1></div>
		
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="contactForm">
			<div id="nameEmailContainer">
				<div class="fieldContainer <?php if($nameErr != "") { echo "error"; } ?>" id="nameContainer">
					<label for="name">Name</label>
					<input type="text" id="name" name="name" placeholder="<?php if($nameErr != "") { echo $nameErr; } ?>" value="<?php persistData($name, $nameErr) ?>">
				</div>
				
				<div class="fieldContainer <?php if($emailErr != "") { echo "error"; } ?>" id="emailContainer">
					<label for="email">Email</label>
					<input type="text" id="email" name="email" placeholder="<?php if($emailErr != "") { echo $emailErr; } ?>" value="<?php persistData($email, $emailErr) ?>">
				</div>
			</div>

			<textarea id="message" class ="<?php if($messageErr != "") { echo "error"; } ?>" name="message" placeholder="<?php textareaPlaceholder()?>"><?php persistData($message, $messageErr) ?></textarea>

			<button type="submit" id="submit">Submit</button>
		</form>
	</main>
</body>
</html>