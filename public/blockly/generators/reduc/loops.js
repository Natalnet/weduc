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
 * @fileoverview Generating Reduc for loop blocks.
 * @author fraser@google.com (Neil Fraser)
 */
'use strict';

goog.provide('Blockly.Reduc.loops');

goog.require('Blockly.Reduc');


Blockly.Reduc['controls_repeat_ext'] = function(block) {
  // Repeat n times.
  if (block.getField('TIMES')) {
    // Internal number.
    var repeats = String(Number(block.getFieldValue('TIMES')));
  } else {
    // External number.
    var repeats = Blockly.Reduc.valueToCode(block, 'TIMES',
        Blockly.Reduc.ORDER_ASSIGNMENT) || '0';
  }
  var branch = Blockly.Reduc.statementToCode(block, 'DO');
  branch = Blockly.Reduc.addLoopTrap(branch, block.id);
  var code = '';
  var endVar = repeats;
  code += 'repita ' + repeats + ' vezes {\n' +
      branch + '}\n';
  return code;
};

Blockly.Reduc['controls_repeat'] =
    Blockly.Reduc['controls_repeat_ext'];

Blockly.Reduc['controls_whileUntil'] = function(block) {
  // Do while/until loop.
  var until = block.getFieldValue('MODE') == 'UNTIL';
  var argument0 = Blockly.Reduc.valueToCode(block, 'BOOL',
      until ? Blockly.Reduc.ORDER_LOGICAL_NOT :
      Blockly.Reduc.ORDER_NONE) || 'falso';
  var branch = Blockly.Reduc.statementToCode(block, 'DO');
  branch = Blockly.Reduc.addLoopTrap(branch, block.id);
  if (until) {
    argument0 = '!' + argument0;
  }
  return 'enquanto (' + argument0 + ') farei {\n' + branch + '}\n';
};

Blockly.Reduc['controls_for'] = function(block) {
  // For loop.
  var variable0 = Blockly.Reduc.variableDB_.getName(
      block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
  var argument0 = Blockly.Reduc.valueToCode(block, 'FROM',
      Blockly.Reduc.ORDER_ASSIGNMENT) || '0';
  var argument1 = Blockly.Reduc.valueToCode(block, 'TO',
      Blockly.Reduc.ORDER_ASSIGNMENT) || '0';
  var increment = Blockly.Reduc.valueToCode(block, 'BY',
      Blockly.Reduc.ORDER_ASSIGNMENT) || '1';
  var branch = Blockly.Reduc.statementToCode(block, 'DO');
  branch = Blockly.Reduc.addLoopTrap(branch, block.id);
  var code;
  if (Blockly.isNumber(argument0) && Blockly.isNumber(argument1) &&
      Blockly.isNumber(increment)) {
    // All arguments are simple numbers.
    code = 'para ' + variable0 + ' de ' + argument0 + ' ate ' +
        argument1;
    var step = Math.abs(parseFloat(increment));
    code += ' passo ' + step + ' farei {\n' + branch + '}\n';
  } else {
    code = '';
  }
  return code;
};
