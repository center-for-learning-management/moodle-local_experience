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
 * Manage the rules of local_experience.
 */

namespace local_experience;

require('../../config.php');
require_once(__DIR__ . '/locallib.php');

require_login();
$PAGE->set_url(new \moodle_url('/local/experience/rules.php', array()));
$PAGE->set_context(\context_system::instance());
$PAGE->set_heading(get_string('pluginname', 'local_experience'));
$PAGE->set_title(get_string('pluginname', 'local_experience'));
$PAGE->requires->css('/local/experience/main.css');

echo $OUTPUT->header();
if (!is_siteadmin()) {
    echo $OUTPUT->render_from_template('local_experience/alert', array(
        'type' => 'danger',
        'content' => get_string('access_denied', 'local_experience'),
        'url' => new \moodle_url('/my', array()),
    ));
    echo $OUTPUT->footer();
    die();
}

echo $OUTPUT->render_from_template('local_experience/rules', array('rules' => $rules));
echo $OUTPUT->footer();
