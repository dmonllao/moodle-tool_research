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
 * View model predictions.
 *
 * @package    tool_inspire
 * @copyright  2017 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

$contextid = required_param('contextid', PARAM_INT);
$modelid = optional_param('modelid', false, PARAM_INT);

$context = context::instance_by_id($contextid);

if ($context->contextlevel === CONTEXT_MODULE) {
    list($course, $cm) = get_module_from_cmid($context->instanceid);
    require_login($course, true, $cm);
} else if ($context->contextlevel >= CONTEXT_COURSE) {
    $coursecontext = $context->get_course_context(true);
    require_login($coursecontext->instanceid);
} else {
    require_login();
    $PAGE->set_context($context);
}

require_capability('tool/inspire:listinsights', $context);

// Get all models that are enabled, trained and have predictions at this context.
$othermodels = \tool_inspire\manager::get_all_models(true, true, $context);
if (!$modelid && count($othermodels)) {
    // Autoselect the only available model.
    $model = reset($othermodels);
    $modelid = $model->get_id();
}
if ($modelid) {
    unset($othermodels[$modelid]);
}

$params = array('contextid' => $contextid);
$url = new \moodle_url('/admin/tool/inspire/insights.php', $params);
if ($modelid) {
    $url->param('modelid', $modelid);
}

$PAGE->set_url($url);
$PAGE->set_pagelayout('report');

$renderer = $PAGE->get_renderer('tool_inspire');

// No models with predictions available at this context level.
if (!$modelid) {
    echo $renderer->render_no_predictions($context);
    exit(0);
}

$model = new \tool_inspire\model($modelid);

$insightinfo = new stdClass();
$insightinfo->contextname = $context->get_context_name();
$insightinfo->insightname = $model->get_target()->get_name();
$title = get_string('insightinfo', 'tool_inspire', $insightinfo);


if (!$model->is_enabled() && !has_capability('tool/inspire:managemodels', $context)) {
    echo $renderer->render_model_disabled($insightinfo);
    exit(0);
}

$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();

$renderable = new \tool_inspire\output\predictions_list($model, $context, $othermodels);
echo $renderer->render($renderable);

echo $OUTPUT->footer();
