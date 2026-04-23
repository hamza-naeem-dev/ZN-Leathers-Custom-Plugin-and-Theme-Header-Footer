<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <?php wp_head() ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="nav_bar">
            <!-- <div class="hamburger">

            </div> -->
            <div class="logo">
                <?php the_custom_logo(); ?>
            </div>
            <div class="nav_links">
                <ul>
                    <li><a href="#home" class="<?php echo is_front_page() ? 'active' : ''; ?>">HOME</a></li>
                    <li><a href="#collection" class="<?php echo is_page('collection') ? 'active' : '' ?>">THE COLLECTION</a></li>
                    <li><a href="#craft" class="<?php echo is_page('the-craft') ? 'active' : '' ?>">THE CRAFT</a></li>
                    <li><a href="#inquiry" class="<?php echo is_page('bespoke-inquiries') ? 'active' : '' ?>">BESPOKE INQUIRIES</a></li>
                    
                </ul>
                
            </div>
            <div class="burger_style">
                    <span></span>
                    <span></span>
                    <span></span>
            </div>
        </div>
    </header>
</body>
</html>