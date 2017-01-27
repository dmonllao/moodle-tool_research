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
 * Strings for tool_inspire.
 *
 * @package tool_inspire
 * @copyright 2016 David Monllao {@link http://www.davidmonllao.com}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['enabled'] = 'Enabled';
$string['erroralreadypredict'] = '{$a} file has already been used to predict';
$string['errordisabledmodel'] = '{$a} model is disabled and can not be used to predict';
$string['errornoenabledmodels'] = 'There are not enabled models to train';
$string['errornoenabledandtrainedmodels'] = 'There are not enabled and trained models to predict';
$string['errornoindicators'] = 'This model does not have any indicator';
$string['errornopredictresults'] = 'No results returned from the predictions processor, check the output directory contents for more info';
$string['errornorunrecord'] = 'Couldn\'t locate the current run record in the database';
$string['errornotimesplittings'] = 'This model does not have any time splitting method';
$string['errornoroles'] = 'Student or teacher roles have not been defined. Define them in inspire plugin settings page.';
$string['errornotarget'] = 'This model does not have any target';
$string['errornottrainedmodel'] = '{$a} model has not been trained yet';
$string['errorpredictionsprocessor'] = 'Predictions processor error: {$a}';
$string['errorpredictwrongformat'] = 'The predictions processor return can not be decoded: "{$a}"';
$string['errorunexistingtimesplitting'] = 'The selected time splitting method is not available';
$string['analysingsitedata'] = 'Analysing the site';
$string['evaluationminscore'] = 'Evaluation minimum score';
$string['indicator:accessesafterend'] = 'Accesses after the end date';
$string['indicator:accessesbeforestart'] = 'Accesses before the start date';
$string['indicator:anywrite'] = 'Any write action';
$string['indicator:readactions'] = 'Read actions amount';
$string['indicator:completeduserprofile'] = 'User profile is completed';
$string['indicator:userforumstracking'] = 'User is tracking forums';
$string['indicators'] = 'Indicators';
$string['inspiremodels'] = 'Inspire models';
$string['invalidtimesplitting'] = 'Model with id {$a} needs a time splitting method before it can be used to train';
$string['modeloutputdir'] = 'Models output directory';
$string['modelslist'] = 'Models list';
$string['modeltimesplitting'] = 'Time splitting';
$string['nocourses'] = 'No courses to analyse';
$string['notdefined'] = 'Not yet defined';
$string['predictmodels'] = 'Predict models';
$string['predictionsprocessor'] = 'Predictions processor';
$string['processingcourse'] = 'Processing course {$a}';
$string['processingcourses'] = 'Processing courses...';
$string['pluginname'] = 'Inspire';
$string['skippingcourse'] = 'Skipping course {$a}';
$string['studentroles'] = 'Student roles';
$string['subplugintype_predict'] = 'Predictions processor';
$string['subplugintype_predict_plural'] = 'Predictions processors';
$string['target'] = 'Target';
$string['target:coursedropout'] = 'Drop out of a course';
$string['target:coursecompleted'] = 'Course completed';
$string['teacherroles'] = 'Teacher roles';
$string['timemodified'] = 'Last modification';
$string['trainandenablemodel'] = 'Select which model you want to enable';
$string['trained'] = 'Trained';
$string['trainingmodel'] = 'Training {$a} model';
$string['trainmodels'] = 'Train models';
