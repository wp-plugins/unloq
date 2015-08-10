=== UNLOQ.io Passwordless authentication ===
Contributors: unloqer
Tags: two-factor, two factor, 2 step authentication, 2 factor, 2FA, admin, ios, android, authentication, encryption, iphone, log in, login, mfa, mobile, multi factor, unloq, password, passwordless, phone, secure, security, smartphone, ssl, strong authentication, tfa, two factor authentication, two step, wp-admin, wp-login, authorization
Requires at least: 3.5
Tested up to: 4.2.1
Stable tag: trunk
License: MIT
License URI: http://opensource.org/licenses/MIT

UNLOQ provides a free, easy to use and integrate, strong authentication systems that replaces passwords with your phone.

== Description ==

# UNLOQ.io Wordpress Plugin

## SHORT DESCRIPTION

UNLOQ provides a free, easy to use and integrate, strong authentication systems that replaces passwords with a user’s phone.

## DESCRIPTION

UNLOQ increases the security of your digital properties through a distributed authentication system that doesn’t require your users to remember any passwords. From now on you can forget about them wherever you see the UNLOQ login box. Just click the UNLOQ button and you’ll receive an authentication request on your phone for you to approve or deny.

No connection on your phone? Lost phone? We’ve got you covered. Click the menu button on the bottom right corner to see the other login option the application allows. These might come either as time based one time password (you’ll find the code under the Tokens menu option in the UNLOQ app) or e-mail login.

We believe it’s about your application & your users. Make the authentication system your own:
- Personalize the appearance of the notification messages and choose a plugin theme to go with your design,
- Set the data you want your users to provide when registering or signing in,
- Determine what security measures works best for you. You may want to restrict the login backup methods, to request TOTP for each login, set up request origin paths and timers

## INSTALLATION

From your WordPress dashboard:
1. Visit "Plugins > Add New"
2. Search for "UNLOQ" and install the official plugin

Manually via upload
1. Download UNLOQ (https://github.com/UNLOQIO/wordpress-client/releases - latest release)
2. Upload the "unloq.zip" into your plugins directory
3. Install it

##### Once activated
1. Open the UNLOQ setup page
2. Enter your API Key / API Secret and click the "SETUP" button.
>> Note: You must first register at https://unloq.io , create an organization, verify your site's domain and finally create an application. For more details, please visit https://unloq.io/developers/get-started/
3. Choose which type of login you would want to allow (UNLOQ and/or regular passwords)
4. Select the UNLOQ box theme.

If you have any questions or installation issues, send us an e-mail at team@unloq.io . We will be happy to help you get started with UNLOQ.

## FAQ

##### Is UNLOQ really free?
The basic version is and will always be free. Your free account includes:
- unlimited applications, domains, users and logins
- e-mail and chat support
- basic analytics


##### How do you keep the lights on?
UNLOQ authentication system is offered under a freemium model. The basic plan is free and it will always be free, but we also offer premium plans that adds additional security features, detailed analytics and support features for your customers. You may want to consider them when implementing UNLOQ.

##### Can existing users on my WordPress site sign in with UNLOQ after I install the plugin?
Of course they can. As long as your users register on their UNLOQ mobile apps using the same e-mail address as their WordPress accounts, they can start using UNLOQ without any other configurations. You could also use UNLOQ to invite your users by e-mails.

##### How does UNLOQ accommodate logins for WordPress users who do not have smartphones or don’t have internet access on their phone?
UNLOQ offers three ways to authenticate: UNLOQ push notification, time-based one time password and e-mail login. Users without internet connection or without a smartphone may use one of the other two options. You can choose what authentication methods you want to make available to your users from UNLOQ administrative panel.

##### What should I do if my phone is lost, stolen, or if I switch to a new phone?
If you lose or change your phone, you can deactivate your account from your device and reactivate it on a new phone. To deactivate your phone, go to https://account.unloq.io/deactivate .

##### How secure is UNLOQ authentication system?
UNLOQ’s security architecture is fully distributed, which means UNLOQ stores no user passwords on its servers. We only store your e-mail, name and profile picture (the last two are not required, but might enhance the user experience), but these cannot be used to login into any service by themselves. Only you, from your phone (or e-mail in case of e-mail login) can authorize the authentication request. All data on your phone are kept encrypted with AES-256-CBC and we use SSL on all communication channels.

##  Other notes

##### Language
For now, UNLOQ is available in English. Please consider helping translate UNLOQ.




