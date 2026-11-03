<?php
/**
 * Compatibility layer for Polylang 2.6.5 on WordPress 6.4+ and PHP 8.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', 'jcci_polylang_compat_load_walkers', 0 );
add_action( 'wp_loaded', 'jcci_polylang_compat_prepare_rewrite_rules', 9 );

function jcci_polylang_compat_load_walkers() {
	if ( ! defined( 'POLYLANG_VERSION' ) || '2.6.5' !== POLYLANG_VERSION ) {
		return;
	}

	if ( ! class_exists( 'PLL_Walker_Dropdown', false ) ) {
		class PLL_Walker_Dropdown extends Walker {
			public $db_fields = array( 'parent' => 'parent', 'id' => 'id' );

			public function start_el( &$output, $element, $depth = 0, $args = array(), $current_object_id = 0 ) {
				$value = $args['value'];
				$output .= sprintf(
					"\t" . '<option value="%1$s"%2$s%3$s>%4$s</option>' . "\n",
					esc_attr( $element->$value ),
					method_exists( $element, 'get_locale' ) ? sprintf( ' lang="%s"', esc_attr( $element->get_locale( 'display' ) ) ) : '',
					selected( isset( $args['selected'] ) && $args['selected'] === $element->$value, true, false ),
					esc_html( $element->name )
				);
			}

			public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
				$element = (object) $element;
				$element->parent = $element->id = 0;
				parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
			}

			public function walk( $elements, $max_depth = -1, ...$args ) {
				if ( is_array( $max_depth ) ) {
					$args = $max_depth;
				} else {
					$args = isset( $args[0] ) ? $args[0] : array();
				}

				$args = wp_parse_args( $args, array( 'value' => 'slug', 'name' => 'lang_choice' ) );
				$output = '';

				if ( ! empty( $args['flag'] ) ) {
					$current = wp_list_filter( $elements, array( $args['value'] => $args['selected'] ) );
					$lang = reset( $current );
					$output = sprintf(
						'<span class="pll-select-flag">%s</span>',
						empty( $lang->flag ) ? esc_html( $lang->slug ) : $lang->flag
					);
				}

				$output .= sprintf(
					'<select name="%1$s"%2$s%3$s%4$s>' . "\n" . '%5$s' . "\n" . '</select>' . "\n",
					$name = esc_attr( $args['name'] ),
					isset( $args['id'] ) && ! $args['id'] ? '' : ' id="' . ( empty( $args['id'] ) ? $name : esc_attr( $args['id'] ) ) . '"',
					empty( $args['class'] ) ? '' : ' class="' . esc_attr( $args['class'] ) . '"',
					disabled( empty( $args['disabled'] ), false, false ),
					parent::walk( $elements, -1, $args )
				);

				return $output;
			}
		}
	}

	if ( ! class_exists( 'PLL_Walker_List', false ) ) {
		class PLL_Walker_List extends Walker {
			public $db_fields = array( 'parent' => 'parent', 'id' => 'id' );

			public function start_el( &$output, $element, $depth = 0, $args = array(), $current_object_id = 0 ) {
				$output .= sprintf(
					'%6$s<li class="%1$s"><a lang="%2$s" hreflang="%2$s" href="%3$s">%4$s%5$s</a></li>%7$s',
					esc_attr( implode( ' ', $element->classes ) ),
					esc_attr( $element->locale ),
					esc_url( $element->url ),
					$element->flag,
					$args['show_flags'] && $args['show_names'] ? sprintf( '<span style="margin-%1$s:0.3em;">%2$s</span>', is_rtl() ? 'right' : 'left', esc_html( $element->name ) ) : esc_html( $element->name ),
					'discard' === $args['item_spacing'] ? '' : "\t",
					'discard' === $args['item_spacing'] ? '' : "\n"
				);
			}

			public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
				$element = (object) $element;
				$element->parent = $element->id = 0;
				parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
			}

			public function walk( $elements, $max_depth = -1, ...$args ) {
				if ( is_array( $max_depth ) ) {
					$args = $max_depth;
					$max_depth = -1;
				} else {
					$args = isset( $args[0] ) ? $args[0] : array();
				}

				return parent::walk( $elements, $max_depth, $args );
			}
		}
	}
}

function jcci_polylang_compat_prepare_rewrite_rules() {
	if ( ! defined( 'POLYLANG_VERSION' ) || '2.6.5' !== POLYLANG_VERSION ) {
		return;
	}

	global $polylang;

	if ( isset( $polylang->links_model ) && method_exists( $polylang->links_model, 'prepare_rewrite_rules' ) ) {
		$polylang->links_model->prepare_rewrite_rules( null );
	}
}
