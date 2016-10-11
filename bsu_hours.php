<?php
/*
Plugin Name: Boise State Hours Manager
Author: Boise State SA Web Team
Description: Manage facility hours
 */

require('plugin/View.php');
require('plugin/Data.php');
require('plugin/Settings.php');
require('plugin/Plugin.php');

new BoiseState\Hours\Plugin();