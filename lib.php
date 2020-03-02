<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_experience
 * @copyright  2018 Digital Education Society (http://www.dibig.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/local/experience/locallib.php');

function block_eduvidual_before_standard_html_head() {
    global $CFG, $CONTEXT, $COURSE, $DB, $PAGE, $USER;

    $injects = array();
    // @TODO echo goes here into the head of the page, not the body!!!
    // Check if we have selected a moo-level if required.
    if ($USER->id > 0 && !isguestuser($USER) && in_array(block_eduvidual::get('role'), array('Teacher', 'Manager', 'Administrator'))) {
        if (in_array(\block_eduvidual::get('role'), array('Administrator', 'Manager', 'Teacher'))) {
            $valid_moolevels = explode(',', get_config('block_eduvidual', 'moolevels'));
            if (count($valid_moolevels) > 0) {
                $context = \context_system::instance();
                $roles = get_user_roles($context, $USER->id, true);
                $found = false;
                foreach ($roles AS $role) {
                    if (in_array($role->roleid, $valid_moolevels)) {
                        $found = true;
                    }
                }
                if (!$found && strpos($_SERVER["SCRIPT_FILENAME"], '/blocks/eduvidual/pages/preferences.php') <= 0) {
                    redirect($CFG->wwroot . '/blocks/eduvidual/pages/preferences.php?act=moolevelinit');
                }
            }
        }
    }

    return implode("\n", $injects);
}
