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

In this case you are assumed to have an application on facebook and twitter, then you are also listed on the BX Connect application, after you do all that, the first step you should do is configure some parameters of the array with the following example:

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
