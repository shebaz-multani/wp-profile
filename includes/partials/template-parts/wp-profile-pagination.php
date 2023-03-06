<div class="wp-profile-pagination">
    <?php
        $total_pages = $profiles->max_num_pages;
        $current_page = ( isset( $_POST['paged'] ) && absint( $_POST['paged'] ) ) ? absint( $_POST['paged'] ) : 1;;
       
        for ($page = 1; $page <= $total_pages; $page++) {
            if ($page == $current_page) {
                echo '<span>'.$page.'</span>';
            } else {
                echo '<a href="'.$page.'" >'.$page.'</a>';
            }
        }
    ?>
</div>