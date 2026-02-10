<?php
/**
 * Custom Login Form Template
 * Matches the design of distributor/clinic pages
 */

defined('ABSPATH') || exit;

// Get redirect URL from query parameter, default to myaccount or checkout step 1
$redirect = isset($_GET['redirect']) ? esc_url_raw($_GET['redirect']) : wc_get_page_permalink('myaccount');
?>

<div class="container-custom py-8">
        <div class="max-w-2xl mx-auto">
            <?php
            // Display WooCommerce notices (errors, success messages)
            wc_print_notices();
            
            do_action('woocommerce_before_customer_login_form');
            
            // Check if user is coming from email gate with new email (has email param)
            $is_registration_flow = !empty($_GET['email']);
            $registration_enabled = get_option('woocommerce_enable_myaccount_registration') === 'yes';
            ?>

            <div class="grid grid-cols-1 <?php echo ($registration_enabled && !$is_registration_flow) ? 'md:grid-cols-2' : ''; ?> gap-8">
                <!-- Login Form -->
                <?php if (!$is_registration_flow) : ?>
                <div>
                    <h2 class="title-h2 mb-6"><?php esc_html_e('Login', 'woocommerce'); ?></h2>
                    
                    <form class="woocommerce-form woocommerce-form-login login space-y-5" method="post">
                        <?php do_action('woocommerce_login_form_start'); ?>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2 pl-4"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;" 
                                   placeholder="<?php esc_attr_e('Username or email', 'woocommerce'); ?>" required />
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2 pl-4"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                            <input class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500" type="password" name="password" id="password" autocomplete="current-password" 
                                   style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;" 
                                   placeholder="<?php esc_attr_e('Password', 'woocommerce'); ?>" required />
                        </div>

                        <?php do_action('woocommerce_login_form'); ?>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input class="mr-2 w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                                <span class="text-sm text-gray-700"><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
                            </label>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-sm text-primary-500 hover:underline"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                        </div>

                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                        <input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
                        
                        <div>
                            <button type="submit" class="btn-gradient w-full" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('LOG IN', 'woocommerce'); ?></button>
                        </div>

                        <?php do_action('woocommerce_login_form_end'); ?>
                    </form>
                </div>
                <?php endif; ?>

                <?php if ($registration_enabled || $is_registration_flow) : ?>
                    <!-- Registration Form -->
                    <div>
                        <?php if (!$is_registration_flow) : ?>
                        <h2 class="title-h2 mb-6"><?php esc_html_e('Register', 'woocommerce'); ?></h2>
                        <?php else : ?>
                        <h2 class="title-h2 mb-6"><?php esc_html_e('Create Account', 'woocommerce'); ?></h2>
                        <?php endif; ?>
                        
                        <form method="post" class="woocommerce-form woocommerce-form-register register space-y-5" <?php do_action('woocommerce_register_form_tag'); ?>>
                            <?php do_action('woocommerce_register_form_start'); ?>

                            <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                                <div>
                                    <label for="reg_username" class="block text-sm font-medium text-gray-700 mb-2 pl-4"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                    <input type="text" class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" 
                                           style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;" 
                                           placeholder="<?php esc_attr_e('Username', 'woocommerce'); ?>" required />
                                </div>
                            <?php endif; ?>

                            <div>
                                <label for="reg_email" class="block text-sm font-medium text-gray-700 mb-2 pl-4"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                <input type="email" class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500" name="email" id="reg_email" autocomplete="email" value="<?php 
                                // Pre-fill from POST, URL parameter, or leave empty
                                $email_value = '';
                                if (!empty($_POST['email'])) {
                                    $email_value = esc_attr(wp_unslash($_POST['email']));
                                } elseif (!empty($_GET['email'])) {
                                    $email_value = esc_attr(sanitize_email($_GET['email']));
                                }
                                echo $email_value;
                                ?>" 
                                style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;" 
                                placeholder="<?php esc_attr_e('Email address', 'woocommerce'); ?>" required />
                            </div>

                            <?php 
                            // Always show password field if coming from checkout (has email param) or if WooCommerce setting allows it
                            $show_password_field = ('no' === get_option('woocommerce_registration_generate_password')) || !empty($_GET['email']);
                            ?>
                            <?php if ($show_password_field) : ?>
                                <div>
                                    <label for="reg_password" class="block text-sm font-medium text-gray-700 mb-2 pl-4"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
                                    <input type="password" class="w-full px-4 focus:outline-none focus:ring-2 focus:ring-primary-500" name="password" id="reg_password" autocomplete="new-password" 
                                           style="background-color: #EEF2F6; border-radius: 32px; height: 48px; border: none;" 
                                           placeholder="<?php esc_attr_e('Password', 'woocommerce'); ?>" required />
                                </div>
                            <?php else : ?>
                                <p class="text-sm text-gray-600"><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>
                            <?php endif; ?>

                            <?php do_action('woocommerce_register_form'); ?>

                            <div class="text-sm text-gray-600">
                                <?php esc_html_e('Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our', 'woocommerce'); ?> 
                                <a href="<?php echo esc_url(function_exists('wc_privacy_policy_url') ? wc_privacy_policy_url() : home_url('/privacy-policy')); ?>" class="text-primary-500 hover:underline"><?php esc_html_e('privacy policy', 'woocommerce'); ?></a>.
                            </div>

                            <div>
                                <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                                <input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
                                <button type="submit" class="btn-gradient w-full" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('REGISTER', 'woocommerce'); ?></button>
                            </div>

                            <?php do_action('woocommerce_register_form_end'); ?>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
