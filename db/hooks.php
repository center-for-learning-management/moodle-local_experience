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
 * @copyright  2020 Center for Learning Management (http://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$callbacks = [
    [
        'hook' => \core\hook\after_config::class,
        'callback' => [\local_experience\hook_callbacks::class, 'after_config'],
        'priority' => 500,
    ],
    [
        'hook' => \core\hook\output\before_http_headers::class,
        'callback' => [\local_experience\hook_callbacks::class, 'before_http_headers'],
        'priority' => 500,
    ],
    [
        'hook' => \core\hook\output\before_standard_head_html_generation::class,
        'callback' => [\local_experience\hook_callbacks::class, 'before_standard_head_html_generation'],
        'priority' => 500,
    ],
];
