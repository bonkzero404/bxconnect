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

The examples are a good place to start. The minimal connect to BX platform you'll need to have is:

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
