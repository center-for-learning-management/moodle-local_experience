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
 * @copyright  2020 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Show information page for big blue button.
 */

require('../../../config.php');
require_login();
$PAGE->set_url(new \moodle_url('/local/experience/pages/bigbluebutton.php', array()));
$PAGE->set_context(\context_system::instance());
$PAGE->set_heading('Big Blue Button');
$PAGE->set_title('Big Blue Button');

echo $OUTPUT->header();
$params = (object) array(
    'wwwroot' => $CFG->wwwroot,
);
echo '<p>' . get_string('injecttext:page-mod-bigbluebuttonbn-mod', 'local_experience', $params) . '</p>';
echo get_string('injecttext:page-mod-bigbluebuttonbn-mod:longtext', 'local_experience', $params);
echo $OUTPUT->footer();
