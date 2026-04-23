<?php
if(!defined("ABSPATH"))
    {
        exit;
    }

class ZNCF_Plugin{
    public function __construct()
    {
        add_shortcode('zncfdesign', array($this, 'zncf_designing'));
        add_action('wp_ajax_nopriv_zncf_submit', array($this, 'cf_submission'));
    }

    public function zncf_designing(){
        ob_start(); ?>
         <form method="POST" enctype="multipart/form-data">
            <label for="fullname" id="full_name">Full Name</label>
            <input id="name" type="text" name="fullname" placeholder="Full Name" required>
            <label for="email" id="email_address">Email Address</label>
            <input id="mail" type="email" name="email" placeholder="example@gmail.com" required>
            <div class="validate_email"></div>
            <label for="mobilenumber" id="mobile">Mobile Number</label>
            <input id="cell" type="tel" name="mobilenumber" placeholder="03---" required>
            <label for="query_type" id="title">Select Query</label>
             <select name="query_type" id="query">
                <option value="General Inquiry">General Inquiry</option>
                <option value="Bulk Order">Bulk Order</option>
                <option value="Custom Design">Custom Design</option>
                <option value="Product Question">Product Question</option>
             </select>
            <label for="inquiry" id="detail_inquiry">Description</label>
            <textarea id="desc" name="inquiry" placeholder="Provide detail about your query" required></textarea>
            <input id="uploading" type="file" name="file"><br/><br/>
            <?php wp_nonce_field('zn_cf_nonce_action', 'zncf_plugin_nonce') ?>
            <div class="qty_field" aria-hidden="true">
                <input type="text" id="qty" name="leather_web" tabindex="-1" autocomplete="off">
            </div>
            <button id="submit_btn" type="submit" name="cf_submit">Send Inquiry</button>
        </form>
        <div id="zncf-message"></div> 
      
    <?php
    return ob_get_clean();
    }
    
    public function cf_submission(){

    //Basic Validation before submitting form data
                /**@var wpdb $wpdb */
                global $wpdb;

                $query_options = array("General Inquiry", "Bulk Order", "Custom Design", "Product Question");

                if(!isset($_POST['zncf_plugin_nonce']) || ! wp_verify_nonce($_POST['zncf_plugin_nonce'], 'zn_cf_nonce_action'))
                    {
                        wp_send_json_error(array("message" => "Security check Failed"));
                    }
                
                if(!isset($_POST['fullname'], $_POST['email'], $_POST['mobilenumber'], $_POST['query_type'], $_POST['inquiry']))
                    {
                        wp_send_json_error(array("message" => "Please fill in the form."));
                    }
                if(!isset($_POST['email']) || !is_email($_POST['email']))
                    {
                        wp_send_json_error(array("message" => "Please provide a valid email address."));
                    }
                if(!in_array($_POST['query_type'], $query_options))
                    {
                        wp_send_json_error(array("message" => "Choose available options from the list."));
                    }
                
                //Sanitize the input fields

                $full_name = sanitize_text_field($_POST['fullname']);
                $email = sanitize_email($_POST['email']);
                $num = absint($_POST['mobilenumber']);
                $subject = sanitize_text_field($_POST['subject']);
                $inquiry = sanitize_textarea_field($_POST['inquiry']);

                //Manage File Uploading
                require_once(ABSPATH. 'wp-admin/includes/file.php');
                $attached_url = "";
                $attachements = array();
                if(!empty($_FILES['file'] ['name']))
                    {
                        $uploaded_file = $_FILES['file'];
                        $upload_override = array('test_form' => false,
                                                'mimes' => array(
                                                    'jpeg|jpg|jpe' => 'image/jpeg',
                                                    'png' => 'image/png',
                                                    'docx' => 'application/docx',
                                                    'pdf' => 'application/pdf'
                                                ));
                        $move_file = wp_handle_upload($uploaded_file, $upload_override);
                        if($move_file && !isset($move_file['error']))
                            {
                                $attached_url = $move_file['url'];
                                $attachements[] = $move_file['file'];
                            }
                    }

                    //Saving data in custom table
                   $tableName = $wpdb->prefix . 'leather_product_queries';
                   $wpdb->insert($tableName, array(
                    'name' => $full_name,
                    'email' => $email,
                    'phone_number' => $num,
                    'subject' => $subject,
                    'message' => $inquiry,
                    'attached_file' => $attached_url,
                    'created_at' => current_time('mysql')
                   ));

                   //Prepare and send email

                   $to = 'hamzanaeem12@gmail.com';
                   $header = array('Content-Type: text/html; charset=UTF-8', 'From: ZN Leathers <znleathers@gmail.com>');

                   $body = '<h2>Query from ZN Leathers</h2>';
                   $body .= '<p><strong> Name: </strong>' . esc_html($full_name) . '</p>';
                   $body .= '<p><strong> Email Address: </strong>' . esc_html($email) . '</p>';
                   $body .= '<p><strong> Phone Number: </strong>' . esc_html($num) . '</p>';
                   $body .= '<p><strong> Query Subject: </strong>' . esc_html($subject) . '</p>';
                   $body .= '<p><strong> Message: </strong>'. esc_html($inquiry) . '</p>';
                   wp_mail($to, "New Order Query: $subject", $body, $header, $attachements);
                   wp_send_json_success(array("message" => "Your query is sent successfully."));
                   
                   
    }

}