Local Delegate Plugin
================================

Installation
------------
Go to [ Site administration > Plugins(Plugins) > Install plugins ] and just upload or drag & drop downloaed ZIP file.
To install, place all downloaded files in /local/delegate and visit /admin/index.php in your browser.
This block is written by Sandipa Mukherjee<contact.erudisiya@gmail.com>.

Overview
--------
The delegate plugin is a useful solution, with this plugin a delegator can apply for a specific delegatee to the admin. The plugin send email & push notification to the admin for approval. If the admin approves the application then the delegatee and delegator both get an email & push notification.

Setup
-----
Needs attention to manage wide range of capabilities from site adminstration > users > define roles > choose your custom role.
Target Roles are given below :
local/delegate:view
local/delegate:create
local/delegate:update
local/delegate:delete
local/delegate:approve
local/delegate:decline
local/delegate:emailnotifysubmission
local/delegate:emailconfirmsubmission
local/delegate:delegateeapprovemail

Source Control
--------------
https://github.com/erudisiya/local_delegate

Bug Tracker
--------------
https://github.com/erudisiya/local_delegate/issues

How to Apply
------------
Go to selected Course that you want to apply for > More > Delegate Application > New Application for Delegate.

How to Approve or Decline
-------------------------
Go to selected Course that you want to see > More > Delegate Application > All Application List > Approve or Decline button / click details button and then approve or decline.

Uninstall
---------
Admin can uninstall this plugin from- Site administration > Plugins >   > Plugins overview > uninstall [ Delegate Application ].