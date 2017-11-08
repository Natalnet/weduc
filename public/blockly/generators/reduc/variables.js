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
 * @fileoverview Generating Reduc for variable blocks.
 * @author fraser@google.com (Neil Fraser)
 */
'use strict';

goog.provide('Blockly.Reduc.variables');

goog.require('Blockly.Reduc');


Blockly.Reduc['variables_get'] = function(block) {
  // Variable getter.
  var code = Blockly.Reduc.variableDB_.getName(block.getFieldValue('VAR'),
      Blockly.Variables.NAME_TYPE);
  return [code, Blockly.Reduc.ORDER_ATOMIC];
};

Blockly.Reduc['variables_set'] = function(block) {
  var TYPES = {
    'NUMBER': 'numero ',
    'TEXT': 'texto ',
    'BOOLEAN': 'booleano '
  };
  var type = TYPES[block.getFieldValue('TYPE')];
  // Variable setter.
  var argument0 = Blockly.Reduc.valueToCode(block, 'VALUE',
      Blockly.Reduc.ORDER_ASSIGNMENT) || '0';
  var varName = Blockly.Reduc.variableDB_.getName(
      block.getFieldValue('VAR'), Blockly.Variables.NAME_TYPE);
  return type + varName + ' = ' + argument0 + '\n';
};
