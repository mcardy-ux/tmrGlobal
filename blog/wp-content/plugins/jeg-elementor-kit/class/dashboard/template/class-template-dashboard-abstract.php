<?php
/**
 * Template Dashboard Abstract
 *
 * @author Jegtheme
 * @since 2.0.0
 * @package jeg-elementor-kit
 */

namespace Jeg\Elementor_Kit\Dashboard\Template;

use Jeg\Elementor_Kit\Dashboard\Dashboard;

/**
 * Class Template_Dashboard_Abstract
 *
 * @package jeg-elementor-kit
 */
abstract class Template_Dashboard_Abstract {
	/**
	 * Template_Dashboard_Abstract constructor.
	 */
	public function __construct() {
		$this->enqueue();
		$this->render();
	}

	/**
	 * Enqueue script
	 */
	protected function enqueue() {
		wp_enqueue_style( 'notiflix', JEG_ELEMENTOR_KIT_URL . '/assets/js/notiflix/notiflix.min.css', null, '2.7.0' );
		wp_enqueue_script( 'notiflix', JEG_ELEMENTOR_KIT_URL . '/assets/js/notiflix/notiflix.min.js', array(), '2.7.0', true );

		wp_register_script( 'jkit-dashboard-container', JEG_ELEMENTOR_KIT_URL . '/assets/js/dashboard/dashboard-container.js', array( 'jeg-form-builder-script' ), JEG_ELEMENTOR_KIT_VERSION, true );
		wp_register_script( 'jkit-dashboard-template', JEG_ELEMENTOR_KIT_URL . '/assets/js/dashboard/dashboard-template.js', array( 'underscore', 'jquery', 'jquery-ui-draggable', 'jquery-ui-sortable', 'jkit-dashboard-container' ), JEG_ELEMENTOR_KIT_VERSION, true );
		wp_localize_script( 'jkit-dashboard-template', 'JKitTemplateConfig', $this->config() );
		wp_enqueue_script( 'jkit-dashboard-template' );
	}

	/**
	 * JKitTemplateConfig
	 *
	 * @return array
	 */
	protected function config() {
		/** Option */
		$option = array();
		foreach ( static::main_fields() as $key => $field ) {
			$option[ $key ] = jeg_prepare_field( $key, $field );
		}

		/** Option */
		$condition = array();
		$page      = isset( $_GET['page'] ) ? $_GET['page'] : '';
		foreach ( static::condition_fields( null, $page ) as $key => $field ) {
			$condition[ $key ] = jeg_prepare_field( $key, $field );
		}

		return array(
			'tab'     => array(
				array(
					'id'      => 'option',
					'type'    => 'single',
					'title'   => esc_html__( 'Option', 'jeg-elementor-kit' ),
					'default' => $option,
				),
				array(
					'id'      => 'condition',
					'type'    => 'multi',
					'title'   => esc_html__( 'Condition', 'jeg-elementor-kit' ),
					'default' => $condition,
				),
			),
			'nonce'   => wp_create_nonce( jkit_get_nonce_identifier() ),
			'ajax'    => admin_url( 'admin-ajax.php' ),
			'page'    => isset( $_GET['page'] ) ? $_GET['page'] : '',
			'lang'    => $this->language(),
			'success' => esc_html__( 'Success Save Data', 'jeg-elementor-kit' ),
		);
	}

	/**
	 * Create Fields
	 *
	 * @param array $default Default.
	 *
	 * @return array
	 */
	public static function main_fields( $default = null ) {
		$fields = array();

		$fields['title'] = array(
			'type'    => 'text',
			'title'   => esc_html__( 'Template Title', 'jeg-elementor-kit' ),
			'segment' => 'main',
			'default' => static::default_title(),
		);

		return $fields;
	}

	/**
	 * Dafault title
	 *
	 * @return string
	 */
	public static function default_title() {
		return esc_html__( 'Insert Title', 'jeg-elementor-kit' );
	}

	/**
	 * Condition
	 *
	 * @param array $value Option to retrieve.
	 *
	 * @return array
	 */
	public static function condition_fields( $value = null, $page = null ) {
		$fields = array();

		$fields['location'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Location', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Set where should this template will be shown.', 'jeg-elementor-kit' ),
			'options'     => array(
				'all_site' => esc_html__( 'All Site', 'jeg-elementor-kit' ),
				'singular' => esc_html__( 'Singular Page', 'jeg-elementor-kit' ),
				'archives' => esc_html__( 'Archive Page', 'jeg-elementor-kit' ),
			),
			'default'     => '',
		);

		$fields['enclose'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Enclose Status', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose the enclosed status.', 'jeg-elementor-kit' ),
			'options'     => array(
				'include' => esc_html__( 'Include', 'jeg-elementor-kit' ),
				'exclude' => esc_html__( 'Exclude', 'jeg-elementor-kit' ),
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '!=',
					'value'    => 'all_site',
				),
			),
			'default'     => 'include',
		);

		/**
		 * Archive
		 */
		$fields['archives'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Archive Type', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose the archive page type.', 'jeg-elementor-kit' ),
			'options'     => array(
				''       => esc_html__( 'All Archives', 'jeg-elementor-kit' ),
				'author' => esc_html__( 'Author', 'jeg-elementor-kit' ),
				'date'   => esc_html__( 'Date', 'jeg-elementor-kit' ),
				'search' => esc_html__( 'Search', 'jeg-elementor-kit' ),
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'archives',
				),
			),
			'default'     => '',
		);

		$fields['archives']['options'] = array_merge( $fields['archives']['options'], jkit_get_taxonomies() );

		$fields['archives_author'] = array(
			'type'        => 'select',
			'multiple'    => 100,
			'title'       => esc_html__( 'Archive Author', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write the author name to search.', 'jeg-elementor-kit' ),
			'ajax'        => 'jkit_find_author',
			'nonce'       => jkit_create_global_nonce(),
			'options'     => call_user_func(
				function () use ( $value ) {
					return static::get_user_options( $value );
				}
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'archives',
				),
				array(
					'field'    => 'archives',
					'operator' => '===',
					'value'    => 'author',
				),
			),
			'default'     => '',
		);

		$fields['archive_taxonomy'] = array(
			'type'        => 'select',
			'multiple'    => 100,
			'title'       => esc_html__( 'Archive Taxonomy', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write the terms name to search. Leave empty to select all terms.', 'jeg-elementor-kit' ),
			'ajax'        => 'jkit_find_taxonomy',
			'nonce'       => jkit_create_global_nonce(),
			'options'     => call_user_func(
				function () use ( $value ) {
					if ( isset( $value['archive_taxonomy'] ) && $value['archive_taxonomy'] ) {
						return static::get_taxonomy_options( $value['archive_taxonomy'] );
					}
				}
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'archives',
				),
				array(
					'field'    => 'archives',
					'operator' => 'in',
					'value'    => jkit_get_taxonomies( false ),
				),
			),
			'default'     => '',
		);

		/**
		 * Singular
		 */
		$fields['singular'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Singular Type', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose singular type.', 'jeg-elementor-kit' ),
			'options'     => array(
				''         => esc_html__( 'Singular', 'jeg-elementor-kit' ),
				'front'    => esc_html__( 'Front Page', 'jeg-elementor-kit' ),
				'notfound' => esc_html__( '404 Page', 'jeg-elementor-kit' ),
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'singular',
				),
			),
			'default'     => '',
		);

		$fields['posttype'] = array(
			'type'        => 'select',
			'title'       => esc_html__( 'Post Type Filter', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Choose post type as filter.', 'jeg-elementor-kit' ),
			'options'     => jkit_get_public_post_type(),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'singular',
				),
				array(
					'field'    => 'singular',
					'operator' => '===',
					'value'    => '',
				),
			),
			'default'     => '',
		);

		$fields['singular_post'] = array(
			'type'        => 'select',
			'multiple'    => 100,
			'title'       => esc_html__( 'Include Post / Page', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write post or page name to search.', 'jeg-elementor-kit' ),
			'ajax'        => 'jkit_find_posts_object',
			'nonce'       => jkit_create_global_nonce(),
			'options'     => call_user_func(
				function () use ( $value ) {
					if ( isset( $value['singular_post'] ) && $value['singular_post'] ) {
						return static::get_post_options( $value['singular_post'] );
					}
				}
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'singular',
				),
				array(
					'field'    => 'singular',
					'operator' => '===',
					'value'    => '',
				),
			),
			'default'     => '',
		);

		$fields['singular_taxonomy'] = array(
			'type'        => 'select',
			'multiple'    => 100,
			'title'       => esc_html__( 'Terms Name', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write terms name (Ex: category name, tag name, etc) to search.', 'jeg-elementor-kit' ),
			'ajax'        => 'jkit_find_taxonomy',
			'nonce'       => jkit_create_global_nonce(),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'singular',
				),
				array(
					'field'    => 'singular',
					'operator' => '===',
					'value'    => '',
				),
			),
			'options'     => call_user_func(
				function () use ( $value ) {
					return static::get_singular_taxonomy_options( $value );
				}
			),
			'default'     => '',
		);

		$fields['singular_author'] = array(
			'type'        => 'select',
			'multiple'    => 100,
			'title'       => esc_html__( 'Author Name', 'jeg-elementor-kit' ),
			'description' => esc_html__( 'Write the author name to search.', 'jeg-elementor-kit' ),
			'ajax'        => 'jkit_find_author',
			'nonce'       => jkit_create_global_nonce(),
			'options'     => call_user_func(
				function () use ( $value ) {
					return static::get_user_options( $value );
				}
			),
			'dependency'  => array(
				array(
					'field'    => 'location',
					'operator' => '===',
					'value'    => 'singular',
				),
				array(
					'field'    => 'singular',
					'operator' => '===',
					'value'    => '',
				),
			),
			'default'     => '',
		);

		if ( $page && 'jkit-archive-template' === $page ) {
			$fields['location']['title'] = esc_html__( 'Filter By', 'magnitude-essential' );

			unset( $fields['location']['options']['all_site'] );
			unset( $fields['location']['options']['singular'] );

			$fields['location']['options']['product_cat'] = esc_html__( 'Product Categories', 'magnitude-essential' );
			$fields['location']['options']['product_tag'] = esc_html__( 'Product Tags', 'magnitude-essential' );
			$fields['product_cat']                        = array(
				'type'        => 'select',
				'multiple'    => 100,
				'title'       => esc_html__( 'Product Categories', 'magnitude-essential' ),
				'description' => esc_html__( 'Write product category name to search.', 'magnitude-essential' ),
				'ajax'        => 'jkit_find_taxonomy',
				'slug'        => 'product_cat',
				'nonce'       => jkit_create_global_nonce(),
				'options'     => call_user_func(
					function () use ( $value ) {
						if ( isset( $value['product_cat'] ) && $value['product_cat'] ) {
							return self::get_taxonomy_options( $value['product_cat'], false );
						}
					}
				),
				'dependency'  => array(
					array(
						'field'    => 'location',
						'operator' => '===',
						'value'    => 'product_cat',
					),
				),
				'default'     => '',
			);

			$fields['product_tag'] = array(
				'type'        => 'select',
				'multiple'    => 100,
				'title'       => esc_html__( 'Product Tags', 'magnitude-essential' ),
				'description' => esc_html__( 'Write product tag name to search.', 'magnitude-essential' ),
				'ajax'        => 'jkit_find_taxonomy',
				'slug'        => 'product_tag',
				'nonce'       => jkit_create_global_nonce(),
				'options'     => call_user_func(
					function () use ( $value ) {
						if ( isset( $value['product_tag'] ) && $value['product_tag'] ) {
							return self::get_taxonomy_options( $value['product_tag'], false );
						}
					}
				),
				'dependency'  => array(
					array(
						'field'    => 'location',
						'operator' => '===',
						'value'    => 'product_tag',
					),
				),
				'default'     => '',
			);
		}

		if ( $page && 'jkit-single-product' === $page ) {
			$fields['location']['title']                     = esc_html__( 'Filter By', 'magnitude-essential' );
			$fields['location']['options']['']               = esc_html__( 'All Products', 'magnitude-essential' );
			$fields['location']['options']['product_single'] = esc_html__( 'Single Product', 'magnitude-essential' );
			$fields['location']['options']['product_cat']    = esc_html__( 'Product Categories', 'magnitude-essential' );
			$fields['location']['options']['product_tag']    = esc_html__( 'Product Tags', 'magnitude-essential' );

			unset( $fields['location']['options']['archives'] );
			unset( $fields['location']['options']['singular'] );

			$fields['product_cat'] = array(
				'type'        => 'select',
				'multiple'    => 100,
				'title'       => esc_html__( 'Product Categories', 'magnitude-essential' ),
				'description' => esc_html__( 'Write product category name to search.', 'magnitude-essential' ),
				'ajax'        => 'jkit_find_taxonomy',
				'slug'        => 'product_cat',
				'nonce'       => jkit_create_global_nonce(),
				'options'     => call_user_func(
					function () use ( $value ) {
						if ( isset( $value['product_cat'] ) && $value['product_cat'] ) {
							return self::get_taxonomy_options( $value['product_cat'], false );
						}
					}
				),
				'dependency'  => array(
					array(
						'field'    => 'location',
						'operator' => '===',
						'value'    => 'product_cat',
					),
				),
				'default'     => '',
			);

			$fields['product_tag'] = array(
				'type'        => 'select',
				'multiple'    => 100,
				'title'       => esc_html__( 'Product Tags', 'magnitude-essential' ),
				'description' => esc_html__( 'Write product tag name to search.', 'magnitude-essential' ),
				'ajax'        => 'jkit_find_taxonomy',
				'slug'        => 'product_tag',
				'nonce'       => jkit_create_global_nonce(),
				'options'     => call_user_func(
					function () use ( $value ) {
						if ( isset( $value['product_tag'] ) && $value['product_tag'] ) {
							return self::get_taxonomy_options( $value['product_tag'], false );
						}
					}
				),
				'dependency'  => array(
					array(
						'field'    => 'location',
						'operator' => '===',
						'value'    => 'product_tag',
					),
				),
				'default'     => '',
			);

			$fields['product'] = array(
				'type'        => 'select',
				'multiple'    => 100,
				'title'       => esc_html__( 'Insert Products', 'magnitude-essential' ),
				'description' => esc_html__( 'Write product title to search.', 'magnitude-essential' ),
				'ajax'        => 'jkit_find_posts_object',
				'slug'        => 'product',
				'nonce'       => jkit_create_global_nonce(),
				'options'     => call_user_func(
					function () use ( $value ) {
						if ( isset( $value['product'] ) && $value['product'] ) {
							return self::get_post_options( $value['product'] );
						}
					}
				),
				'dependency'  => array(
					array(
						'field'    => 'location',
						'operator' => '===',
						'value'    => 'product_single',
					),
				),
				'default'     => '',
			);
		}

		return apply_filters( 'jkit_template_condition_fileds', $fields );
	}

	/**
	 * Get user option list
	 *
	 * @param array $value Array that contains author name field.
	 *
	 * @return array
	 */
	public static function get_user_options( $value ) {
		$result = array();
		$count  = count_users();

		if ( (int) $count <= jkit_load_resource_limit() ) {
			$users = get_users();
		} else {
			$users = get_users(
				array(
					'include' => $value['author'],
				)
			);
		}

		foreach ( $users as $user ) {
			$result[ $user->ID ] = $user->display_name;
		}

		return $result;
	}

	/**
	 * Get post option list
	 *
	 * @param array $value Array that contains singular_post field.
	 *
	 * @return array
	 */
	public static function get_post_options( $value ) {
		$result = array();

		$posts = get_posts(
			array(
				'post_type' => jkit_get_public_post_type_array(),
				'include'   => $value,
			)
		);

		foreach ( $posts as $value ) {
			$post_type = get_post_type_object( $value->post_type );

			$result[ $value->ID ] = $value->post_title . ' - ' . $post_type->labels->singular_name;
		}

		return $result;
	}

	/**
	 * Get taxonomy option list
	 *
	 * @param array $value Array that contains archive_taxonomy field.
	 * @param bool  $label Show taxonomy label
	 *
	 * @return array
	 */
	public static function get_taxonomy_options( $value, $label = true ) {
		$result = array();

		$terms = get_terms(
			array(
				'include' => $value,
			)
		);

		foreach ( $terms as $key => $term ) {
			if ( $label ) {
				$taxonomy = get_taxonomy( $term->taxonomy );
				$label    = ' - ' . $taxonomy->label;
			}

			$result[ $term->term_id ] = $term->name . $label;
		}

		return $result;
	}

	/**
	 * Get singular taxonomy option list
	 *
	 * @param array $value Array that contains singular_taxonomy field.
	 *
	 * @return array
	 */
	public static function get_singular_taxonomy_options( $value ) {
		$result = array();

		if ( ! empty( $value['singular_taxonomy'] ) ) {
			$terms = get_terms(
				array(
					'include' => $value['singular_taxonomy'],
				)
			);

			foreach ( $terms as $key => $term ) {
				$taxonomy                 = get_taxonomy( $term->taxonomy );
				$result[ $term->term_id ] = $term->name . ' - ' . $taxonomy->label;
			}
		}

		return $result;
	}

	/**
	 * Render
	 */
	protected function render() {
		?>
		<div id="jkit-builder-container"></div>
		<?php
	}


	/**
	 * Language
	 *
	 * @return array
	 */
	public function language() {
		return array(
			'close'           => esc_html__( 'Close', 'jeg-elementor-kit' ),
			'create'          => esc_html__( 'Create', 'jeg-elementor-kit' ),
			'createcondition' => esc_html__( 'Create filter condition', 'jeg-elementor-kit' ),
			'addcondition'    => esc_html__( 'Add Condition', 'jeg-elementor-kit' ),
			'elementname'     => esc_html__( 'Element Name', 'jeg-elementor-kit' ),
			'priority'        => esc_html__( 'Priority', 'jeg-elementor-kit' ),
			'edit'            => esc_html__( 'Edit', 'jeg-elementor-kit' ),
			'clone'           => esc_html__( 'Clone', 'jeg-elementor-kit' ),
			'delete'          => esc_html__( 'Delete', 'jeg-elementor-kit' ),
			'loading'         => esc_html__( 'Loading...', 'jeg-elementor-kit' ),
		);
	}

}
