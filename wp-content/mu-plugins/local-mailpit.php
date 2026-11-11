<?php
/**
 * Plugin Name: Local Mailpit
 * Description: В локальной среде отправляет всю почту WordPress в Mailpit (http://localhost:8025). На боевом сайте ничего не делает.
 */

if ( wp_get_environment_type() !== 'local' || ! defined( 'SMTP_HOST' ) ) {
	return;
}

add_action( 'phpmailer_init', function ( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host     = SMTP_HOST;
	$phpmailer->Port     = 1025;
	$phpmailer->SMTPAuth = false;
	$phpmailer->SMTPAutoTLS = false;
} );

// «wordpress@localhost» PHPMailer считает недопустимым адресом.
add_filter( 'wp_mail_from', function ( $from ) {
	return str_ends_with( $from, '@localhost' ) ? 'wordpress@site.test' : $from;
} );
