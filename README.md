Blackxperience Connect
=========

BLackxperience Connect / Bx Connect is a simple REST API. This repository contains the open source PHP Class that allows you to access BX Platform from your PHP app.

- Simple implements
- Facebook Connect
- Twitter Connect
- Email Register
- Get users profile

Easy to install with composer
=========

```php
{
    "require": {
        "redbuzz/bxconnect": "dev-master"
    }
}
```

Usage
=========

In this case you are assumed to have an application on facebook and twitter, then you are also listed on the BX Connect application, the first step you should do is configure some parameters array with the following example:

```php
$Blackxperience = array (
	"CLIENT_ID" 			=> "YOUR_BX_CLIENT_ID",
	"CLIENT_KEY" 			=> "YOUR_BX_CLIENT_KEY",
	"CLIENT_APP_NAME" 		=> "YOUR_BX_APP_NAME",
	"FB_APP_ID" 			=> "YOUR_FACEBOOK_APP_ID",
	"FB_APP_SECRET" 		=> "YOUR_FACEBOOK_APP_SECRET",
	"TW_CONSUMER_ID" 		=> "YOUR_TWITTER_CONSUMER_ID",
	"TW_CONSUMER_SECRET" 	=> "YOUR_TWITTER_CONSUMER_SECRET"
);

$BxConnect = new BxConnect\BlackxperienceAuth($Blackxperience);
```

After doing the above configuration, the next line you have to make a callback URL, it is required to do a redirect to your application.

```php
$BxConnect::setCallbackUrl("http://YOUR_PHP_APP_WEBSITE_URL");
```

The final step is to apply the requirements of your application is very easy, consider the example below:
```php

if (@$_GET['act'] == 'logout') {
	$obj::logoutData();
	header ("location: http://YOUR_PHP_APP_WEBSITE_URL");
}

if ($BxConnect::getUserData() == false) {
	if (!isset($_GET['status_code'])) {
		echo "
		
		<form method='post' action='". $BxConnect::getEmailLoginUrl() ."'>
			<table>
				<tr>
					<td>Username/Email</td>
					<td><input type='text' name='BX_USERNAME' /></td>
				</tr>
				<tr>
					<td>Password</td> 
					<td><input type='password' name='BX_PASSWORD' /><td />
				</tr>
				<tr>
					<td colspan='2'>
					<button type='submit'>Login</button>
					<button type='button' onclick='location.href=\"". $BxConnect::twitterUrl() . "\"'>Twitter Login</button>
					<button type='button' onclick='location.href=\"". $BxConnect::facebookUrl() . "\"'>Facebook Login</button>
					<button type='button' onclick='location.href=\"". $BxConnect::registerUrl() . "\"'>Register</button>
					<button type='button' onclick='location.href=\"". $BxConnect::getForgotPassUrl() . "\"'>Forgot Password</button>
					</td>
				</tr>
			</table>

		</form>";
	}
	else if ($_GET['status_code'] == '0000') {
		var_dump($BxConnect::getUserData());
		echo "<br /><br />";
		echo "<a href='http://localhost/c.php?act=logout'>Logout</a> ";
		echo "<a href='". $BxConnect::updateUserUrl() . "'>Update User</a>";
	}	
	else {
		echo "Error code : " . $_GET['status_code'] ;
	}
}
else {
	var_dump($BxConnect::getUserData());
	echo "<a href='http://localhost/c.php?act=logout'>Logout</a> ";
	echo "<a href='". $BxConnect::updateUserUrl() . "'>Update User</a>";
}
```