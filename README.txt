Local Delegate Plugin
================================

Installation
------------
Go to [ Site administration > Plugins(Plugins) > Install plugins ] and just upload or drag & drop downloaed ZIP file.
To install, place all downloaded files in /local/delegate and visit /admin/index.php in your browser.
This local plugin is written by Sandipa Mukherjee<contact.erudisiya@gmail.com>.

Overview
--------
As a result of a mutual discussion between a delegator and delegatee,
the delegator gives his responsibility to the delegatee.
With this plugin the delegator ie. a teacher / non-editing-teacher / the equivalent
role can ask the admin to delegate their responsibility of any course,
to the delegatee ie. the other teacher / non-editing-teacher / the equivalent role
who both have been already enrolled in the same course.
Admin can accept or decline requests by delegator. With this plugin, the admin knows who wants to take leave.

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
local/delegate:candelegatee

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
Go to selected Course that you want to see > More > Delegate Application >
All Application List > Approve or Decline button / click details button and
then approve or decline.

Uninstall
---------
Admin can uninstall this plugin from Site administration > Plugins > Plugins overview > uninstall Delegate Application.
