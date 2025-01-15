<?php
/*
Plugin Name: Car Dealership Deals Display
Description: Displays ongoing car dealership deals dynamically using a JSON file.
Version: 1.6
Author: David Mroz
*/

function display_car_deals_section($atts)
{
    // Open the json
    $json_file = plugin_dir_path(__FILE__) . 'assets/data/deals.json';
    $json_data = json_decode(file_get_contents($json_file), true);

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

            // Layout HTML code
            ?>
            <div class="component">
                <div class="header"><?php echo esc_html($deal['title']); ?></div>
                <div class="sub-header">
                    <div class="horz-text">
                        <p>Available APR</p>
                        <h3 style="font-weight: 700;"><?php echo esc_html($deal['apr']); ?>%</h3>
                        <p>for 72 mos</p>
                    </div>
                </div>

                <div class="content">
                    <div class="grid-container">
                        <div class="image-container">
                            <img src="<?php echo esc_url($deal['car_image']); ?>" alt="Image" />
                        </div>
                        <div class="contact-container">
                            <div class="icon-container">
                                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/phone-call-white-icon.png'; ?>" alt="Image" />
                            </div>
                            <div class="phone-number">
                                <h1>(847)-362-5099</h1>
                            </div>
                        </div>
                    </div>

                    <div class="grid-container">
                        <div class="grid">
                            <?php foreach ($deal['details'] as $detail) : ?>
                                <div class="special-info">
                                    <h2 style=""><?php echo esc_html($detail['label']); ?></h2>
                                    <div class="horz-text">
                                        <p style="font-size:large; margin: 0; font-weight: 700; font-family: Arial, sans-serif;">$</p>
                                        <h1 style="font-weight:700;"><?php echo esc_html($detail['price']); ?></h1>
                                        <?php if (!empty($detail['term'])) : ?>
                                            <h3>/mo</h3>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($detail['term'])) : ?>
                                        <p><?php echo esc_html($detail['term']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="grid-container">
                            <div class="buttons">
                                <button class="big-button">
                                    <div class="horz-text">
                                        <div class="icon-container-button">
                                            <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/price-tag.png'; ?>" alt="Image" />
                                        </div>
                                        Check Availability
                                    </div>
                                </button>
                                <div class="small-buttons">
                                    <button>
                                        <div class="horz-text">
                                            <div class="icon-container-button">
                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/car-icon.png'; ?>" alt="Image" />
                                            </div>
                                            View Vehicle
                                        </div>
                                    </button>
                                    <button>
                                        <div class="horz-text">
                                            <div class="icon-container-button">
                                                <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/apply-for-finance.png'; ?>" alt="Image" />
                                            </div>
                                            Apply For Financing
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            $count++;
        }

        echo '</div>'; // Close the last container
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
}
add_action('wp_enqueue_scripts', 'enqueue_car_deals_assets', 20);