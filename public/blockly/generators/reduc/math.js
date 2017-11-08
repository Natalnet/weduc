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
 * @fileoverview Generating Reduc for math blocks.
 * @author q.neutron@gmail.com (Quynh Neutron)
 */
'use strict';

goog.provide('Blockly.Reduc.math');

goog.require('Blockly.Reduc');


Blockly.Reduc['math_number'] = function(block) {
  // Numeric value.
  var code = parseFloat(block.getFieldValue('NUM'));
  return [code, Blockly.Reduc.ORDER_ATOMIC];
};

Blockly.Reduc['math_arithmetic'] = function(block) {
  // Basic arithmetic operators, and power.
  var OPERATORS = {
    'ADD': [' + ', Blockly.Reduc.ORDER_ADDITION],
    'MINUS': [' - ', Blockly.Reduc.ORDER_SUBTRACTION],
    'MULTIPLY': [' * ', Blockly.Reduc.ORDER_MULTIPLICATION],
    'DIVIDE': [' / ', Blockly.Reduc.ORDER_DIVISION]
  };
  var tuple = OPERATORS[block.getFieldValue('OP')];
  var operator = tuple[0];
  var order = tuple[1];
  var argument0 = Blockly.Reduc.valueToCode(block, 'A', order) || '0';
  var argument1 = Blockly.Reduc.valueToCode(block, 'B', order) || '0';
  var code;
  code = argument0 + operator + argument1;
  return [code, order];
};

Blockly.Reduc['math_constant'] = function(block) {
  return block.getFieldValue('CONSTANT');
};

Blockly.Reduc['math_change'] = function(block) {
  // Add to a variable in place.
  var argument0 = Blockly.Reduc.valueToCode(block, 'DELTA',
      Blockly.Reduc.ORDER_ADDITION) || '0';
  var varName = Blockly.Reduc.variableDB_.getName(
      block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
  return varName + ' = (typeof ' + varName + ' == \'number\' ? ' + varName +
      ' : 0) + ' + argument0 + ';\n';
};
