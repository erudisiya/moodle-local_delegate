<?php
/**Copyright (C) 2020 onwards Erudisiya PVT LTD
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * delegate nav
 *
 * @package   local_mcis
 * @copyright 2020 Erudisiya PVT LTD {contact.erulearn@gmail.com}{http://erulearn.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
defined('MOODLE_INTERNAL') || die();
$settings = null;

if ($hassiteconfig) {
	/*$ADMIN->add('root', new admin_category('local_mcis', get_string('pluginname', 'local_mcis')));
    	$settings = new admin_settingpage('local_mcis_sandbox', get_string('agency_info', 'local_mcis'));
        $ADMIN->add('local_mcis', $settings);
    	$name = 'local_mcis/agency_unit';
        $title = get_string('agency_unit', 'local_mcis');
        $description = "Please enter one numeric value per line.";
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $settings->add($setting);
        $name = 'local_mcis/agent_code';
        $default = "";
        $title = get_string('agent_code', 'local_mcis');
        $description = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $settings->add($setting);*/
    
}