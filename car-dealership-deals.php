<?php
/*
Plugin Name: Car Dealership Deals Display
Description: Displays ongoing car dealership deals dynamically using a JSON file.
Version: 2.9
Author: David Mroz
*/

function display_car_deals_section($atts)
{   
    $response = wp_remote_get('https://admin.zyvexia.net/get_data.php?api_key=b4455de6-cbc8-43bd-9de4-4fc195a4628c');
    // Open the json
    $json_file = plugin_dir_path(__FILE__) . 'assets/data/deals.json';
    $json_data = json_decode(wp_remote_retrieve_body($response), true);

    ob_start();

    if (!empty($json_data)) {
        $count = 0;

        foreach ($json_data as $deal) {
            // Open new div every 2 components
            if ($count % 2 === 0) {
                if ($count !== 0) {
                    echo '</div>';
                }
                echo '<div class="container">';
            }

?>
            <div class="component" style="font-family: Arial, sans-serif; font-size: 16px">
                <div class="header" style="font-size: clamp(1.2rem, 5.5vw, 2rem)"><?php echo esc_html($deal['title']); ?></div>
                <div class="sub-header">
                    <div class="horz-text">
                        <p style="font-size: clamp(0.8rem, 1.5vw, 1rem); font-weight: 500;">Available APR <span style="font-weight: 700; font-size: clamp(0.9rem, 2vw, 1.2rem);"><?php echo esc_html($deal['apr']); ?>%</span> for 72 mos</p>
                    </div>
                </div>

                <div class="content">
                    <div class="grid-container">
                        <div class="image-container" style="">
                            <img src="<?php echo esc_url($deal['car_image']); ?>" alt="Image" />
                        </div>
                        <div class="contact-container">
                            <div class="icon-container">
                                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/phone-call-white-icon.png'; ?>" alt="Image" />
                            </div>
                            <div class="phone-number" style="font-size: 16px;">
                                <h2 style="font-size: 1.2em; font-weight: bold;">(847)-362-5099</h2>
                            </div>
                        </div>
                    </div>

                    <div class="grid-container">
                        <div class="grid">
                            <?php foreach ($deal['details'] as $detail) : ?>
                                <div class="special-info">
                                    <h2 style="font-weight:700; font-size: 22px;"><?php echo esc_html($detail['label']); ?></h2>
                                    <div class="horz-text" style="">
                                        <sup style="font-size: 1.4em; margin: 0; font-weight: 700; font-family: Arial, sans-serif;">$</sup>
                                        <h2 style="font-weight:700; font-size: 2.5em"><?php echo esc_html($detail['price']); ?></h2>
                                        <?php if (!empty($detail['term'])) : ?>
                                            <i style="font-size: 1.4em;">/mo</i>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($detail['term'])) : ?>
                                        <p style="font-weight:700; font-size: 0.8em;"><?php echo esc_html($detail['term']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="grid-container" style="justify-content: center;">
                            <div class="buttons">
                                <a style="text-decoration: none;" class="buttons" href="https://www.drivelibertycdjr.com/contact-us/">
                                    <button class="big-button">
                                        <div class="horz-text" style="font-size: 22px; font-weight: 500px;">
                                            <div class="icon-container-button">
                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/price-tag.png'; ?>" alt="Image" />
                                            </div>
                                            Check Availability
                                        </div>
                                    </button>
                                </a>
                                <div class="small-buttons">
                                    <a style="text-decoration: none;" href="<?php echo esc_url($deal['car_data']); ?>">
                                        <button>
                                            <div class="horz-text" style="font-size: 15px; font-weight: 500px;">
                                                <div class="icon-container-button">
                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/car-icon.png'; ?>" alt="Image" />
                                                </div>
                                                View Vehicle
                                            </div>
                                        </button>
                                    </a>
                                    <a style="text-decoration: none;" href="https://www.drivelibertycdjr.com/finance/apply-for-financing/">
                                        <button>
                                            <div class="horz-text" style="font-size: 15px; font-weight: 500px;">
                                                <div class="icon-container-button">
                                                    <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/apply-for-finance.png'; ?>" alt="Image" />
                                                </div>
                                                Apply For Financing
                                            </div>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php

            $count++;
        }

        echo '</div>';
    } else {
        echo '<p>No car deals available at the moment.</p>';
    }

    return ob_get_clean();
}
add_shortcode('car_deals', 'display_car_deals_section');

//Register css to plugin
function enqueue_car_deals_assets()
{
    wp_enqueue_style('car-deals-style', plugin_dir_url(__FILE__) . 'assets/css/car-deals.css');
    wp_enqueue_script('car-deals-script', plugin_dir_url(__FILE__) . 'assets/js/car-deals.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'enqueue_car_deals_assets', 100);
add_theme_support('align-wide');