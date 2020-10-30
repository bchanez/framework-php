<?php

$finder = Symfony\Component\Finder\Finder::create()
  ->notPath('vendor')
  ->in(__DIR__)
  ->name('*.php');

return PhpCsFixer\Config::create() ->setRules([
  '@PSR2' => true,
  'array_syntax' => ['syntax' => 'short'],
  'array_indentation' => true,
  'combine_consecutive_unsets' => true,
  'method_separation' => true,
  'no_multiline_whitespace_before_semicolons' => true,
  'single_quote' => true,
  'binary_operator_spaces' => [
      'align_double_arrow' => true,
      'align_equals' => false
  ],
  'blank_line_after_opening_tag' => true,
  'blank_line_before_return' => true,
  'braces' => [
      'allow_single_line_closure' => true
  ],
  'concat_space' => ['spacing' => 'one'],
  'declare_equal_normalize' => true,
  'function_typehint_space' => true,
  'hash_to_slash_comment' => true,
  'include' => true,
  'lowercase_cast' => true,
  'no_extra_consecutive_blank_lines' => [
      'curly_brace_block',
      'extra',
      'parenthesis_brace_block',
      'square_brace_block',
      'throw',
      'use',
  ],
  'no_multiline_whitespace_around_double_arrow' => true,
  'no_spaces_around_offset' => true,
  'no_unused_imports' => true,
  'no_whitespace_before_comma_in_array' => true,
  'no_whitespace_in_blank_line' => true,
  'object_operator_without_whitespace' => true,
  'single_blank_line_before_namespace' => true,
  'ternary_operator_spaces' => true,
  'trim_array_spaces' => true,
  'unary_operator_spaces' => true,
  'whitespace_after_comma_in_array' => true,
])
->setIndent("  ")
->setLineEnding("\n")
->setFinder($finder);
