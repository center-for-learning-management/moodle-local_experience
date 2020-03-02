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

if (!empty(optional_param('store', '', PARAM_ALPHANUM))) {
    $sorts = optional_param_array('sort', 0, PARAM_INT);
    $patternscriptnames = optional_param_array('patternscriptnames', '', PARAM_TEXT);
    $patternparameters = optional_param_array('patternparameters', '', PARAM_TEXT);
    $elementstohide = optional_param_array('elementstohide', '', PARAM_TEXT);
    $elementstoset = optional_param_array('elementstoset', '', PARAM_TEXT);
    $ids = array_keys($sorts);
    $success = array();
    $failed = array();
    foreach ($ids AS $id) {
        if (empty($sorts[$id])) {
            $DB->delete_records('local_experience_rules', array('id' => $id));
            $success[$id] = true;
        } else {
            $obj = (object)array(
                'id' => $id,
                'sort' => $sorts[$id],
                'patternscriptnames' => $patternscriptnames[$id],
                'patternparameters' => $patternparameters[$id],
                'elementstohide' => $elementstohide[$id],
                'elementstoset' => $elementstoset[$id],
            );
            if ($DB->update_record('local_experience_rules', $obj)) {
                $success[$id] = true;
            } else {
                $failed[$id] = true;
            }
        }
    }
    // @todo show messages.
    echo $OUTPUT->render_from_template('local_experience/alert', array(
        'content' => 'ok',
        'type' => 'success'
    ));
}

if (!empty(optional_param('addrule', '', PARAM_ALPHANUM))) {
    lib::addrule();
}

$rules = array_values($DB->get_records('local_experience_rules', array(), 'sort ASC'));
echo $OUTPUT->render_from_template('local_experience/rules', array('rules' => $rules));
echo $OUTPUT->footer();
