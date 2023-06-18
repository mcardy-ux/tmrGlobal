<?php
/**
 * Dashboard Header
 *
 * @author Jegstudio
 * @since 1.3.0
 * @package jeg-element
 */

use Jeg\Elementor_Kit\Dashboard\Dashboard;

$dashboard = new Dashboard();
?>
<div class="jkit-dashboard-header-wrap">
	<h2 class="jkit-dashboard-header-tab">
		<ul>
			<?php
			$allmenu  = $dashboard->get_admin_menu();
			$tempmenu = array();

			$position = array_column( $allmenu, 'priority' );
			array_multisort( $position, SORT_ASC, $allmenu );

			foreach ( $allmenu as $menu ) {
				$tabactive = isset( $_GET['page'] ) && ( $_GET['page'] === $menu['slug'] ) ? 'tab-active' : '';
				$pageurl   = menu_page_url( $menu['slug'], false );

				if ( isset( $menu['parent'] ) && $menu['parent'] ) {
					$menuitem =
						'<li>
							<a href="' . esc_url( $pageurl ) . '" class="' . esc_attr( $tabactive ) . '">
								' . esc_html( $menu['title'] ) . '
							</a>
						</li>';

					if ( $tabactive ) {
						$tempmenu[ $menu['parent'] ]['class'] = 'tab-active';
					}

					if ( isset( $tempmenu[ $menu['parent'] ]['child'] ) ) {
						$tempmenu[ $menu['parent'] ]['child'] .= $menuitem;
					} else {
						$tempmenu[ $menu['parent'] ]['child'] = $menuitem;
					}
				} else {
					$tempmenu[ $menu['slug'] ]['parent'] =
						'<a href="' . esc_url( $pageurl ) . '" class="' . esc_attr( $tabactive ) . '">
							<i class="fa ' . $menu['icon'] . '"></i>
							' . esc_html( $menu['title'] ) . '
						</a>';
				}
			}

			foreach ( $tempmenu as $menu ) {
				$classmenu = '';
				$menuitem  = $menu['parent'];

				if ( isset( $menu['child'] ) && $menu['child'] ) {
					$menuitem .= '<ul class="jkit-submenu">' . $menu['child'] . '</ul>';
				}

				if ( isset( $menu['class'] ) && $menu['class'] ) {
					$classmenu = 'class="' . $menu['class'] . '"';
				}

				?>
				<li <?php echo $classmenu; ?>><?php echo $menuitem; ?></li>
				<?php
			}
			?>
		</ul>
	</h2>
</div>
