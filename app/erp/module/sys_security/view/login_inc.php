<!DOCTYPE html>
<html lang="us">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?php echo PORTAL_NAME ?></title>

		<meta http-equiv="expires" content="0">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">

		<link href="/css/stylesheet.css" rel="stylesheet">
		<link href="/css/default.css" rel="stylesheet">
		<link href="/css/login.css" rel="stylesheet">

	</head>
	<body data-gr-c-s-loaded="true">
		<div class="companylogo" id="companylogo">
			<div class="loginContainer" id="container">
				<div class="loginLogo" id="login_logo"><?php echo PORTAL_NAME ?></div>
				<div id="login_box">
					<?php echo '<form action="'.actionURL('checklogin','').'" method="post" >'; ?>
					<?php
					if(isset($vlValidation)) {
						echo '<span class="alertMsg errorMsg">';
						echo $vlValidation->getProblemMsg();
						echo '</span>';
							}
					?>

				<span class="formRow">
							<span class="formLabel">
								<label for="login_username">Username</label>
							</span>
							<span class="formInput">
								<input id="login_username" type="text" name="security[sUserID]" class="six" value="" placeholder="User ID" required >
							</span>
						</span>
						<span class="formRow">
							<span class="formLabel">
								<label for="login_password">Password</label>
							</span>
							<span class="formInput">
								<input id="login_password" type="password" name="security[sPassword]" class="four" value="" placeholder="Password" required>
							</span>
						</span>
						<span class="formRow">
							<button class="loginBtn" type="submit">Login</button>
						</span>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
