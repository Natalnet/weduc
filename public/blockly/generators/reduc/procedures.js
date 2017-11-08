/**
 * @license
 * Visual Blocks Language
 *
 * Copyright 2012 Google Inc.
 * https://developers.google.com/blockly/
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * @fileoverview Generating Reduc for procedure blocks.
 * @author fraser@google.com (Neil Fraser)
 */
'use strict';

goog.provide('Blockly.Reduc.procedures');

goog.require('Blockly.Reduc');

// Defining a procedure without a return value uses the same generator as
// a procedure with a return value.
Blockly.Reduc['procedures_defnoreturn'] = function(block) {
  // Define a procedure with a return value.
  var funcName = Blockly.Reduc.variableDB_.getName(
      block.getFieldValue('NAME'), Blockly.Procedures.NAME_TYPE);
  var branch = Blockly.Reduc.statementToCode(block, 'STACK');
  if (Blockly.Reduc.STATEMENT_PREFIX) {
    branch = Blockly.Reduc.prefixLines(
        Blockly.Reduc.STATEMENT_PREFIX.replace(/%1/g,
        '\'' + block.id + '\''), Blockly.Reduc.INDENT) + branch;
  }
  if (Blockly.Reduc.INFINITE_LOOP_TRAP) {
    branch = Blockly.Reduc.INFINITE_LOOP_TRAP.replace(/%1/g,
        '\'' + block.id + '\'') + branch;
  }
  var code = 'tarefa ' + funcName + '{\n' + branch + '}';
  code = Blockly.Reduc.scrub_(block, code);
  // Add % so as not to collide with helper functions in definitions list.
  Blockly.Reduc.definitions_['%' + funcName] = code;
  return null;
};

Blockly.Reduc['procedures_callnoreturn'] = function(block) {
  // Call a procedure with no return value.
  var funcName = Blockly.Reduc.variableDB_.getName(
      block.getFieldValue('NAME'), Blockly.Procedures.NAME_TYPE);
  var code = funcName + '\n';
  return code;
};