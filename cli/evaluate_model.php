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
 * Evaluates the provided model.
 *
 * @package    tool_inspire
 * @copyright  2016 David Monllao {@link http://www.davidmonllao.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->libdir.'/clilib.php');

$help = "Evaluates the provided model.

Options:
--modelid              Model id
--non-interactive      Not interactive questions
--timesplitting        Restrict the evaluation to 1 single time splitting method (Optional)
--filter               Analyser dependant. e.g. A courseid would evaluate the model using a single course (Optional)
--reuse-prev-analysed  Reuse recently analysed courses instead of analysing the whole site. Set it to false while" .
    " coding indicators. Defaults to true (Optional)" . "
-h, --help             Print out this help

Example:
\$ php admin/tool/inspire/cli/evaluate_model.php --modelid=1 --timesplitting='\\tool_inspire\\local\\time_splitting\\quarters' --filter=123,321
";

// Now get cli options.
list($options, $unrecognized) = cli_get_params(
    array(
        'help'                  => false,
        'modelid'               => false,
        'timesplitting'         => false,
        'reuse-prev-analysed'   => true,
        'non-interactive'       => false,
        'filter'                => false
    ),
    array(
        'h' => 'help',
    )
);

if ($options['help']) {
    echo $help;
    exit(0);
}

if ($options['modelid'] === false) {
    echo $help;
    exit(0);
}

// Reformat them as an array.
if ($options['filter'] !== false) {
    $options['filter'] = explode(',', $options['filter']);
}

// We need admin permissions.
\core\session\manager::set_user(get_admin());

$modelobj = $DB->get_record('tool_inspire_models', array('id' => $options['modelid']), '*', MUST_EXIST);
$model = new \tool_inspire\model($modelobj);

mtrace(get_string('analysingsitedata', 'tool_inspire'));
mtrace(get_string('evaluationinbatches', 'tool_inspire'));

$analyseroptions = array(
    'filter' => $options['filter'],
    'timesplitting' => $options['timesplitting'],
    'reuseprevanalysed' => $options['reuse-prev-analysed'],
);
// Evaluate its suitability to predict accurately.
$results = $model->evaluate($analyseroptions);

$renderer = $PAGE->get_renderer('tool_inspire');
echo $renderer->render_evaluate_results($results, $model->get_analyser()->get_logs());

if (!empty($results) && !$model->is_enabled() && $options['non-interactive'] === false) {

    // Select a dataset, train and enable the model.
    $input = cli_input(get_string('clienablemodel', 'tool_inspire'));
    while (!\tool_inspire\manager::is_valid($input, '\tool_inspire\local\time_splitting\base') && $input !== 'none') {
        mtrace(get_string('errorunexistingtimesplitting', 'tool_inspire'));
        $input = cli_input(get_string('clienablemodel', 'tool_inspire'));
    }

    if ($input === 'none') {
        exit(0);
    }

    // Refresh the instance to prevent unexpected issues.
    $model = new \tool_inspire\model($modelobj);

    // Set the time splitting method file and enable it.
    $model->enable($input);

    mtrace(get_string('executingmodel', 'tool_inspire'));

    // Train the model with the selected time splitting method and start predicting.
    $model->train();
    $model->predict();
}

exit(0);
