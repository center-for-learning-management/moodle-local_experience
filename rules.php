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
$PAGE->set_url(new \moodle_url('/local/experience/rules.php', []));
$PAGE->set_context(\context_system::instance());
$PAGE->set_heading(get_string('pluginname', 'local_experience'));
$PAGE->set_title(get_string('pluginname', 'local_experience'));
$PAGE->requires->css('/local/experience/main.css');

echo $OUTPUT->header();
if (!is_siteadmin()) {
    echo $OUTPUT->render_from_template('local_experience/alert', [
        'type' => 'danger',
        'content' => get_string('access_denied', 'local_experience'),
        'url' => new \moodle_url('/my', []),
    ]);
    echo $OUTPUT->footer();
    die();
}

if (!empty(optional_param('store', '', PARAM_ALPHANUM))) {
    $names = optional_param_array('name', '', PARAM_TEXT);
    $sorts = optional_param_array('sort', 0, PARAM_INT);
    $elementstoset = optional_param_array('elementstoset', '', PARAM_TEXT);
    $ids = array_keys($names);
    $success = [];
    $failed = [];
    foreach ($ids as $id) {
        if (empty($names[$id])) {
            $DB->delete_records('local_experience_c_r', ['ruleid' => $id]);
            $DB->delete_records('local_experience_rules', ['id' => $id]);
            $success[$id] = true;
        } else {
            $obj = (object)[
                'id' => $id,
                'name' => $names[$id],
                'sort' => $sorts[$id],
                'elementstoset' => $elementstoset[$id],
            ];
            if ($DB->update_record('local_experience_rules', $obj)) {
                $success[$id] = true;
            } else {
                $failed[$id] = true;
            }
        }
    }
    // @todo show messages.
    echo $OUTPUT->render_from_template('local_experience/alert', [
        'content' => 'ok',
        'type' => 'success',
    ]);
}

if (!empty(optional_param('addrule', '', PARAM_ALPHANUM))) {
    lib::addrule();
}

$rules = array_values($DB->get_records('local_experience_rules', [], 'name ASC, sort ASC'));
echo $OUTPUT->render_from_template('local_experience/rules', ['rules' => $rules, 'wwwroot' => $CFG->wwwroot]);
echo $OUTPUT->footer();
