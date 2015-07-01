<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(__DIR__.'/src')
;

return Symfony\CS\Config\Config::create()
    ->fixers(array(
        'psr0', 'encoding', 'short_tag', 'braces', 'elseif', 'eof_ending', 'function_call_space', 'function_declaration', 'indentation', 'line_after_namespace', 'linefeed', 'lowercase_constants', 'lowercase_keywords', 'method_argument_space', 'multiple_use', 'parenthesis', 'php_closing_tag', 'trailing_spaces', 'visibility', 'concat_without_spaces', 'double_arrow_multiline_whitespaces', 'duplicate_semicolon', 'empty_return', 'extra_empty_lines', 'include', 'multiline_array_trailing_comma', 'namespace_no_leading_whitespace', 'new_with_braces', 'object_operator', 'operators_spaces', 'phpdoc_params', 'remove_leading_slash_use', 'remove_lines_between_use', 'return', 'single_array_no_trailing_comma', 'space_before_semicolon', 'spaces_cast', 'standardize_not_equal', 'ternary_spaces', 'unused_use', 'whitespacy_lines', 'ordered_use', 'strict', 'strict_param'
    ))
    ->finder($finder)
;
