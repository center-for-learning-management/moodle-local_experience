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
 * Manage the conditions of local_experience.
 */

namespace local_experience;

require('../../config.php');
require_once(__DIR__ . '/locallib.php');

require_login();
$PAGE->set_url(new \moodle_url('/local/experience/c_r.php', array()));
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
    $c_rs = optional_param_array('c_r', false, PARAM_BOOL);
    $ids = array_keys($c_rs);
    $success = array();
    $failed = array();
    $DB->delete_records('local_experience_c_r', array());
    foreach ($ids AS $id) {
        $pair = explode('_', $id);
        if (count($pair) != 2) continue;
        if (empty($c_rs[$id])) {
            $DB->delete_records('local_experience_c_r', array('conditionid' => $pair[0], 'ruleid' => $pair[1]));
            $success[$id] = true;
        } else {
            $obj = (object)array(
                'conditionid' => $pair[0],
                'ruleid' => $pair[1],
            );
            if ($DB->execute("INSERT IGNORE {local_experience_c_r} (conditionid,ruleid) VALUES (?,?)", $pair)) {
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


$conditions = array_values($DB->get_records('local_experience_conditions', array(), 'name ASC'));
$rules = array_values($DB->get_records('local_experience_rules', array(), 'name ASC, sort ASC'));
$c_r = array_keys($DB->get_records_sql("SELECT CONCAT(conditionid,'_',ruleid) FROM  {local_experience_c_r}", array()));

foreach ($conditions AS &$condition) {
    $condition->rules = json_decode(json_encode($rules)); // do a cloning
    foreach ($condition->rules AS &$crule) {
        $crule->key = $condition->id . '_' . $crule->id;
        $crule->ischecked = in_array($crule->key, $c_r);
    }
}

echo $OUTPUT->render_from_template('local_experience/c_r', array('conditions' => $conditions, 'rules' => $rules, 'wwwroot' => $CFG->wwwroot));
echo $OUTPUT->footer();
