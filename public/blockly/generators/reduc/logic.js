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
 * @fileoverview Generating Reduc for logic blocks.
 * @author q.neutron@gmail.com (Quynh Neutron)
 */
'use strict';

goog.provide('Blockly.Reduc.logic');

goog.require('Blockly.Reduc');


Blockly.Reduc['controls_if'] = function(block) {
  // If/elseif/else condition.
  var n = 0;
  var code = '', branchCode, conditionCode;
  do {
    conditionCode = Blockly.Reduc.valueToCode(block, 'IF' + n,
      Blockly.Reduc.ORDER_NONE) || 'falso';
    branchCode = Blockly.Reduc.statementToCode(block, 'DO' + n);
    code += (n > 0 ? ' senao ' : '') +
        'se (' + conditionCode + ') entao {\n' + branchCode + '}';

    ++n;
  } while (block.getInput('IF' + n));

  if (block.getInput('ELSE')) {
    branchCode = Blockly.Reduc.statementToCode(block, 'ELSE');
    code += ' senao {\n' + branchCode + '}';
  }
  return code + '\n';
};

Blockly.Reduc['controls_ifelse'] = Blockly.Reduc['controls_if'];

Blockly.Reduc['logic_compare'] = function(block) {
  // Comparison operator.
  var OPERATORS = {
    'EQ': '=',
    'NEQ': '!=',
    'LT': '<',
    'LTE': '<=',
    'GT': '>',
    'GTE': '>='
  };
  var operator = OPERATORS[block.getFieldValue('OP')];
  var order = (operator == '=' || operator == '!=') ?
      Blockly.Reduc.ORDER_EQUALITY : Blockly.Reduc.ORDER_RELATIONAL;
  var argument0 = Blockly.Reduc.valueToCode(block, 'A', order) || '0';
  var argument1 = Blockly.Reduc.valueToCode(block, 'B', order) || '0';
  var code = argument0 + ' ' + operator + ' ' + argument1;
  return [code, order];
};

Blockly.Reduc['logic_operation'] = function(block) {
  // Operations 'and', 'or'.
  var operator = (block.getFieldValue('OP') == 'AND') ? 'e' : 'ou';
  var order = (operator == 'e') ? Blockly.Reduc.ORDER_LOGICAL_AND :
      Blockly.Reduc.ORDER_LOGICAL_OR;
  var argument0 = Blockly.Reduc.valueToCode(block, 'A', order);
  var argument1 = Blockly.Reduc.valueToCode(block, 'B', order);
  if (!argument0 && !argument1) {
    // If there are no arguments, then the return value is false.
    argument0 = 'falso';
    argument1 = 'falso';
  } else {
    // Single missing arguments have no effect on the return value.
    var defaultArgument = (operator == 'e') ? 'verdadeiro' : 'falso';
    if (!argument0) {
      argument0 = defaultArgument;
    }
    if (!argument1) {
      argument1 = defaultArgument;
    }
  }
  var code = argument0 + ' ' + operator + ' ' + argument1;
  return [code, order];
};

Blockly.Reduc['logic_negate'] = function(block) {
  // Negation.
  var order = Blockly.Reduc.ORDER_LOGICAL_NOT;
  var argument0 = Blockly.Reduc.valueToCode(block, 'BOOL', order) ||
      'verdadeiro';
  var code = '!' + argument0;
  return [code, order];
};

Blockly.Reduc['logic_boolean'] = function(block) {
  // Boolean values true and false.
  var code = (block.getFieldValue('BOOL') == 'TRUE') ? 'verdadeiro' : 'falso';
  return [code, Blockly.Reduc.ORDER_ATOMIC];
};