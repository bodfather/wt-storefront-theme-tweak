<?php
// admin/partials/view-toggle.php
defined( 'ABSPATH' ) || exit;
?>
<div class="view-toggle">
	<span></span>
	<a href="?wt_view=grid" class="grid-view <?php echo ( ! isset( $_GET['wt_view'] ) || $_GET['wt_view'] === 'grid' ) ? 'active' : ''; ?>">
		<i class="fas fa-th"></i>
	</a>
	<span>|</span>
	<a href="?wt_view=list" class="list-view <?php echo ( isset( $_GET['wt_view'] ) && $_GET['wt_view'] === 'list' ) ? 'active' : ''; ?>">
		<i class="fas fa-list"></i>
	</a>
</div>
