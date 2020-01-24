<?php

class Jettison_Notices {
  public static function please_login_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
      <p>
        <?php _e( 'Please ' ); ?>
        <a href="/wp-admin/admin.php?page=jettison"><?php _e( 'login' ); ?></a>
        <?php _e( ' to your Jettison account to being syncing.' ); ?>
      </p>
    </div>
    <?php
  }

  /**
   * Returns an array of all of the notice methods on this class. These will
   * be used by the loader to add them into the admin hooks
   *
   * @since 0.0.1
   * @return array String list of notice class names
   */
  public static function show( $notice_name ) {
    add_action( 'admin_notices', __FILE__, 'please_login_notice' );
  }
}