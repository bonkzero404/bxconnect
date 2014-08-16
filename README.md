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

Example Result
=========

```php
array (size=8)
  'username' => string 'johndoe' (length=7)
  'email' => string 'bonkzero404@gmail.com' (length=21)
  'user_profile' => 
    array (size=8)
      'fullname' => string 'John Doe' (length=8)
      'gender' => string 'Male' (length=4)
      'birthdate' => string '1985-04-18' (length=10)
      'city' => string 'Jakarta' (length=7)
      'occupation' => string 'Developer' (length=9)
      'phone' => string '08777529xxxx' (length=12)
      'about_me' => string 'about description' (length=17)
      'photo_profile' => string 'http://connect.blackxperience.com/development/Public/Assets/images/image_profiles/fbbf8f0ba779080d6f954d261e375f22.jpg' (length=118)
  'additional_info' => 
    array (size=3)
      'website_acc' => string 'www.panjisatria.com' (length=20)
      'facebook_acc' => string 'www.facebook.com' (length=16)
      'twitter_acc' => string 'www.twitter.com' (length=15)
  'social_data' => 
    array (size=4)
      'facebook_img_profile' => string 'https://graph.facebook.com/1464164856/picture?type=square' (length=57)
      'twitter_img_profile' => string 'http://abs.twimg.com/sticky/default_profile_images/default_profile_4_normal.png' (length=79)
      'facebook_link' => string 'http://www.facebook.com/1464164856' (length=34)
      'twitter_link' => string 'https://twttier.com/prasgroo' (length=28)
  'register_via' => string 'email' (length=5)
  'login_via' => string 'facebook' (length=8)
  'time_access' => string '2014-08-16 14:51:38' (length=19)
  ```