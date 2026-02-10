<?php
/**
 * My Account Page Template (Custom Profile Layout)
 */

defined('ABSPATH') || exit;

// Let WooCommerce process login/registration forms first
// WooCommerce handles this via hooks that run before template rendering

// If not logged in, render WooCommerce's login/register form and stop.
if (!is_user_logged_in()) {
	// Display any WooCommerce notices (errors, success messages)
	wc_print_notices();
	wc_get_template('myaccount/form-login.php');
	return;
}

// Verify user is valid
$current_user = wp_get_current_user();
if (!$current_user || !$current_user->ID) {
	// If somehow we have an invalid user, show login form
	wc_print_notices();
	wc_get_template('myaccount/form-login.php');
	return;
}

// Handle profile updates (personal info and password) securely.
$profile_updated = false;
$password_updated = false;
if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_POST['forcex_profile_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['forcex_profile_nonce'])), 'forcex_update_profile')) {
	$current_user = wp_get_current_user();
	if ($current_user && $current_user->ID) {
		// Update personal info
		$first   = sanitize_text_field(wp_unslash($_POST['first_name'] ?? ''));
		$last    = sanitize_text_field(wp_unslash($_POST['last_name'] ?? ''));
		$email   = sanitize_email(wp_unslash($_POST['user_email'] ?? ''));
		$phone   = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
		$company = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));

		$user_update = array('ID' => $current_user->ID);
		if ($first !== '') { $user_update['first_name'] = $first; }
		if ($last  !== '') { $user_update['last_name']  = $last; }
		if ($email !== '' && is_email($email)) { $user_update['user_email'] = $email; }
		wp_update_user($user_update);

		if ($phone !== '') { update_user_meta($current_user->ID, 'billing_phone', $phone); }
		if ($company !== '') { update_user_meta($current_user->ID, 'billing_company', $company); }

		$profile_updated = true;

		// Optional password update
		$password = isset($_POST['new_password']) ? (string) $_POST['new_password'] : '';
		if ($password !== '') {
			wp_set_password($password, $current_user->ID);
			wp_set_auth_cookie($current_user->ID);
			$password_updated = true;
		}
	}
}
?>

<style>
/* Make entire account page background white */
body.woocommerce-account,
body.woocommerce-account .site-main,
body.woocommerce-account #main,
body.woocommerce-account .container-custom,
body.woocommerce-account main,
body.woocommerce-account .site-content,
html body.woocommerce-account {
	background-color: white !important;
	background: white !important;
}
</style>

<div class="container-custom py-10" style="background-color: white;">
	<!-- Breadcrumb + Title (Centered) -->
	<div class="text-center mb-6">
		<div class="text-sm text-gray-500 mb-2"><span class="opacity-70">Main</span> <span class="mx-2">/</span> <span class="text-gray-800">Profile</span></div>
		<h1 class="title-h1">Profile</h1>
	</div>

	<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
		<!-- Sidebar with Gradient Background -->
		<div class="lg:col-span-1">
			<div style="background: linear-gradient(135deg, #EEF2F6 0%, #F5F9FC 100%); border-radius: 8px; padding: 24px;">
				<?php 
				$user = wp_get_current_user(); 
				$first_name = $user->first_name ? $user->first_name : '';
				$last_name = $user->last_name ? $user->last_name : '';
				$display_name = trim($first_name . ' ' . $last_name) ?: ($user->display_name ?: $user->user_login);
				$current_endpoint = function_exists('WC') && WC()->query ? WC()->query->get_current_endpoint() : '';
				$is_dashboard = is_account_page() && (!$current_endpoint || $current_endpoint === 'dashboard');
				$is_orders = is_wc_endpoint_url('orders');
				?>
				<?php if ($display_name): ?>
				<div class="flex items-center gap-4 mb-6">
					<div class="w-12 h-12 rounded-full flex items-center justify-center" style="background-color: #BCCBD2;">
						<span class="font-bold text-white text-lg"><?php echo esc_html(strtoupper(substr($first_name ?: $display_name, 0, 1))); ?></span>
					</div>
					<div>
						<div class="text-gray-900 font-semibold"><?php echo esc_html($display_name); ?></div>
					</div>
				</div>
				<?php endif; ?>

				<nav class="">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="flex items-center px-4 py-3 rounded-lg transition-colors <?php echo $is_dashboard ? 'bg-white text-gray-900' : 'text-gray-700 hover:bg-white/50'; ?>">
						<svg class="mr-3 w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="12" cy="12" r="10" stroke="<?php echo $is_dashboard ? '#25AAE1' : '#748394'; ?>" stroke-width="2" fill="none"/>
							<text x="12" y="16" font-family="Arial, sans-serif" font-size="14" font-weight="bold" fill="<?php echo $is_dashboard ? '#25AAE1' : '#748394'; ?>" text-anchor="middle">i</text>
						</svg>
						Personal information
					</a>
					<a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="flex items-center px-4 py-3 rounded-lg transition-colors <?php echo $is_orders ? 'bg-white text-gray-900' : 'text-gray-700 hover:bg-white/50'; ?>">
						<svg class="mr-3 w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="6" y="4" width="12" height="16" rx="2" stroke="<?php echo $is_orders ? '#25AAE1' : '#748394'; ?>" stroke-width="2" fill="none"/>
							<line x1="9" y1="9" x2="15" y2="9" stroke="<?php echo $is_orders ? '#25AAE1' : '#748394'; ?>" stroke-width="2" stroke-linecap="round"/>
							<line x1="9" y1="12" x2="13" y2="12" stroke="<?php echo $is_orders ? '#25AAE1' : '#748394'; ?>" stroke-width="2" stroke-linecap="round"/>
							<line x1="9" y1="15" x2="11" y2="15" stroke="<?php echo $is_orders ? '#25AAE1' : '#748394'; ?>" stroke-width="2" stroke-linecap="round"/>
						</svg>
						Orders
					</a>
					<a href="<?php echo esc_url(wc_logout_url()); ?>" class="mt-6 inline-flex items-center justify-center px-4 py-3 font-semibold text-gray-700 transition-colors hover:bg-white/50" style="background-color: transparent; border: 1px solid #D9E2E7; border-radius: 32px 4px 32px 4px;">
						<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/exist.svg'); ?>" alt="Logout" class="mr-3" style="width: 24px; height: 24px;">
						LOG OUT
					</a>
				</nav>
			</div>
		</div>

		<!-- Main Content -->
		<div class="lg:col-span-3">
			<?php
			// Display WooCommerce notices (errors, success messages)
			wc_print_notices();
			
			// If we're on the dashboard (root) render the custom profile UI; otherwise
			// defer to WooCommerce to load the endpoint template (e.g. orders, addresses, etc.).
			$endpoint = function_exists('WC') && WC()->query ? WC()->query->get_current_endpoint() : '';
			if (!$endpoint || $endpoint === 'dashboard') :
				// Ensure user is valid
				$u = wp_get_current_user();
				if (!$u || !$u->ID) {
					wp_die(__('You must be logged in to view this page.', 'woocommerce'));
				}
				if ($profile_updated) : ?>
					<div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">Your profile has been updated.</div>
				<?php endif; if ($password_updated) : ?>
					<div class="mb-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3">Password changed successfully.</div>
				<?php endif; ?>

				<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
					<!-- Personal information card spans 2 cols -->
					<div class="xl:col-span-2" style="background-color: white; border: 1px solid #D9E2E7; border-radius: 8px; padding: 24px;">
						<h2 class="text-2xl font-semibold text-gray-900 mb-6">Personal information</h2>
						<?php $u = wp_get_current_user(); ?>
						<form method="post" class="space-y-5">
							<?php wp_nonce_field('forcex_update_profile', 'forcex_profile_nonce'); ?>
							<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
								<div>
									<label for="first_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">First name*</label>
									<input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($u->first_name); ?>" 
									       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
									       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
									       placeholder="First name" required>
								</div>
								<div>
									<label for="last_name" class="block text-sm font-medium text-gray-700 mb-2 pl-4">Last name*</label>
									<input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($u->last_name); ?>" 
									       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
									       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
									       placeholder="Last name" required>
								</div>
								<div>
									<label for="user_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4">Email*</label>
									<input type="email" id="user_email" name="user_email" value="<?php echo esc_attr($u->user_email); ?>" 
									       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
									       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
									       placeholder="Email" required>
								</div>
								<div>
									<label for="phone" class="block text-sm font-medium text-gray-700 mb-2 pl-4">Phone*</label>
									<input type="text" id="phone" name="phone" value="<?php echo esc_attr(get_user_meta($u->ID, 'billing_phone', true)); ?>" 
									       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
									       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
									       placeholder="Phone" required>
								</div>
								<div class="md:col-span-2">
									<label for="company" class="block text-sm font-medium text-gray-700 mb-2 pl-4">Company</label>
									<input type="text" id="company" name="company" value="<?php echo esc_attr(get_user_meta($u->ID, 'billing_company', true) ?: '-'); ?>" 
									       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
									       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;"
									       placeholder="Company">
								</div>
							</div>

							<button type="submit" class="btn-gradient mt-4">EDIT INFO</button>
						</form>
					</div>

					<!-- Password card -->
					<div style="background-color: white; border: 1px solid #D9E2E7; border-radius: 8px; padding: 24px;">
						<h2 class="text-2xl font-semibold text-gray-900 mb-6">Password</h2>
						<form method="post">
							<?php wp_nonce_field('forcex_update_profile', 'forcex_profile_nonce'); ?>
							<label for="new_password" class="block text-sm font-medium text-gray-700 mb-2 pl-4">Password*</label>
							<div class="relative mb-4">
								<input type="password" id="new_password" name="new_password" placeholder="********" 
								       class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500"
								       style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none; padding-right: 40px;"
								       autocomplete="new-password">
								<button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" style="cursor: pointer;">
									<svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
									</svg>
								</button>
							</div>
							<button type="submit" class="btn-gradient-dark w-full">CHANGE PASSWORD</button>
						</form>
					</div>
				</div>
			<?php else :
				// Render specific endpoints directly to avoid any recursive hooks.
				if ($endpoint === 'orders') {
					wc_get_template('myaccount/orders.php');
				} else {
					// Fallback to WooCommerce default behavior for other endpoints
					do_action('woocommerce_account_content');
				}
			endif; ?>
		</div>
	</div>
</div>

<script>
function togglePassword() {
	const passwordField = document.getElementById('new_password');
	const eyeIcon = document.getElementById('eye-icon');
	
	if (passwordField.type === 'password') {
		passwordField.type = 'text';
		eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
	} else {
		passwordField.type = 'password';
		eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
	}
}
</script>
