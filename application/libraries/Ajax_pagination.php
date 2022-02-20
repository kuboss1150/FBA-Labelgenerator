<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Pagination Class
 *
 * @package   CodeIgniter
 * @link      http://codeigniter.com/user_guide/libraries/pagination.html
 * 
 * Modified by CodexWorld.com
 * @Ajax pagination functionality has added with this library. 
 * @It will helps to integrate Ajax pagination with loading image in CodeIgniter application.
 * @TutorialLink http://www.codexworld.com/ajax-pagination-in-codeigniter-framework/
 */
class Ajax_pagination
{

    var $display_prev_link = false;
    var $display_next_link = false;

    var $base_url        = ''; // The page we are linking to
    var $total_rows      = ''; // Total number of items (database results)
    var $per_page        = 10; // Max number of items you want shown per page
    var $num_links       =  5; // Number of "digit" links to show before/after the currently viewed page
    var $cur_page        =  0; // The current page being viewed
    var $first_link      = '«';
    var $next_link       = '›';
    var $prev_link       = '‹';
    var $last_link       = '»';
    var $uri_segment     = 3;
    var $full_tag_open   = '<ul class="pagination pagination-sm pull-right">';
    var $full_tag_close  = '</ul>';
    var $first_tag_class  = 'page-item';
    var $first_tag_disable_class  = 'page-item disabled';
    var $last_tag_class  = 'page-item';
    var $last_tag_disable_class  = 'page-item disabled';
    var $cur_tag_class    = 'page-item active';
    var $next_tag_class  = 'page-item';
    var $next_tag_disable_class  = 'page-item disabled';
    var $prev_tag_class  = 'page-item';
    var $prev_tag_disable_class  = 'page-item disabled';
    var $num_tag_class  = 'page-item';
    var $target          = '';
    var $anchor_class    = 'page-link';
    var $show_count      = true;
    var $link_func       = 'getData';
    var $loading         = '.loading';

    /**
     * Constructor
     * @access    public
     * @param    array    initialization parameters
     */
    function CI_Pagination($params = array())
    {
        if (count($params) > 0) {
            $this->initialize($params);
        }
        log_message('debug', "Pagination Class Initialized");
    }

    /**
     * Initialize Preferences
     * @access    public
     * @param    array    initialization parameters
     * @return    void
     */
    function initialize($params = array())
    {
        if (count($params) > 0) {
            foreach ($params as $key => $val) {
                if (isset($this->$key)) {
                    $this->$key = $val;
                }
            }
        }

        // Apply class tag using anchor_class variable, if set.
        if ($this->anchor_class != '') {
            $this->anchor_class = 'class="' . $this->anchor_class . '" ';
        }
    }

    /**
     * Generate the pagination links
     * @access    public
     * @return    string
     */
    function create_links()
    {
        // If our item count or per-page total is zero there is no need to continue.
        if ($this->total_rows == 0 or $this->per_page == 0) {
            return '';
        }

        // Add a trailing slash to the base URL if needed
        $this->base_url = rtrim($this->base_url, '/') . '/';

        ?>
        <script>
            var sort_field = '';
            function getData(page) {
                page = page ? page : 0;
                const length = $('#page_length').length>0 ?$('#page_length').val(): <?= $this->per_page; ?>;
                $.ajax({
                    method: "POST",
                    url: "<?php echo $this->base_url; ?>",
                    data: 'page=' + page + '&' + 'length=' + length + '&' + $('#filter_form').serialize(),
                    beforeSend: function() {
                        $('<?php echo $this->loading; ?>').show();
                    },
                    success: function(data) {
                        $('<?php echo $this->loading; ?>').hide();
                        $('<?php echo $this->target; ?>').html(data);
                        if($('#sort_field').val()!==''){
                            let sort_field = $('#sort_field').val();
                            let sort_direction = $('#sort_direction').val();
                            $(`th[data-field='${sort_field}']`).removeClass(`sorting sorting_desc sorting_asc`);
                            $(`th[data-field='${sort_field}']`).addClass(`sorting_${sort_direction}`);
                        }
                    }
                });
            }
        </script>
        <?php
        // Calculate the total number of pages
        $num_pages = ceil($this->total_rows / $this->per_page);

        // Is there only one page? Hm... nothing more to do here then.
        if ($num_pages == 1) {
            $info = '';
            if($this->show_count)
                $info = 'Showing : ' . $this->total_rows;
            return $info;
        }

        // Determine the current page number.        
        $CI = &get_instance();
        if ($CI->input->post('page') != 0) {
            $this->cur_page = $CI->input->post('page');
            // Prep the current page - no funny business!
            $this->cur_page = (int) $this->cur_page;
        }

        $this->num_links = (int) $this->num_links;
        if ($this->num_links < 1) {
            show_error('Your number of links must be a positive number.');
        }

        if (!is_numeric($this->cur_page)) {
            $this->cur_page = 0;
        }

        // Is the page number beyond the result range?
        // If so we show the last page
        if ($this->cur_page > $this->total_rows) {
            $this->cur_page = ($num_pages - 1) * $this->per_page;
        }

        $uri_page_number = $this->cur_page;
        $this->cur_page = floor(($this->cur_page / $this->per_page) + 1);

        // Calculate the start and end numbers. These determine
        // which number to start and end the digit links with
        $start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
        $end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;


        // And here we go...
        $output = '';

        // SHOWING LINKS
        if ($this->show_count) {
            $curr_offset = $CI->input->post('page');
            $info = 'Showing ' . ($curr_offset + 1) . ' to ';

            if (($curr_offset + $this->per_page) < ($this->total_rows - 1))
                $info .= $curr_offset + $this->per_page;
            else
                $info .= $this->total_rows;

            $info .= ' of ' . $this->total_rows . ' | ';
            $output .= $info;
        }

        // Render the "First" link
        if ($this->cur_page > $this->num_links) {
            $output .= "<li class='{$this->first_tag_class}'>"
                . $this->getAJAXlink('', $this->first_link)
                . "</li>";
        } else {
            $output .= "<li class='{$this->first_tag_disable_class}'>"
                . "<a {$this->anchor_class} href='javascript:void()'>$this->first_link</a>"
                . "</li>";
        }

        // Render the "previous" link
        if ($this->cur_page != 1) {
            $i = $uri_page_number - $this->per_page;
            if ($i == 0) $i = '';
            $output .= "<li class='{$this->prev_tag_class}'>"
                . $this->getAJAXlink($i, $this->prev_link)
                . "</li>";
        } else {
            $output .= "<li class='{$this->prev_tag_disable_class}'>"
                . $this->getAJAXlink('', $this->prev_link)
                . "</li>";
        }


        if ($start > 2) {
            $output .= "<li class='{$this->num_tag_class}'>"
                . $this->getAJAXlink(($this->cur_page - $this->num_links - 2) * $this->per_page, '...')
                . "</li>";
        }
        // Write the digit links
        for ($loop = $start - 1; $loop <= $end; $loop++) {
            $i = ($loop * $this->per_page) - $this->per_page;
            if ($i >= 0) {
                if ($this->cur_page == $loop) {
                    $output .= "<li class='{$this->cur_tag_class}'><span {$this->anchor_class}>" . $loop . "</span></li>"; // Current page
                } else {
                    $n = ($i == 0) ? '' : $i;
                    $output .= "<li class='{$this->num_tag_class}'>"
                        . $this->getAJAXlink($n, $loop)
                        . "</li>";
                }
            }
        }

        if ($end < $num_pages) {
            $output .= "<li class='{$this->num_tag_class}'>"
                . $this->getAJAXlink(($this->cur_page + $this->num_links) * $this->per_page, '...')
                . "</li>";
        }

        // Render the "next" link
        if ($this->cur_page < $num_pages) {
            $output .= "<li class='{$this->next_tag_class}'>"
                . $this->getAJAXlink($this->cur_page * $this->per_page, $this->next_link)
                . "</li>";
        } else {
            $output .= "<li class='{$this->next_tag_disable_class}'>"
                . $this->getAJAXlink($this->cur_page * $this->per_page, $this->next_link)
                . "</li>";
        }

        // Render the "Last" link
        if (($this->cur_page + $this->num_links) < $num_pages) {
            $i = (($num_pages * $this->per_page) - $this->per_page);
            $output .= "<li class='{$this->last_tag_class}'>"
                . $this->getAJAXlink($i, $this->last_link)
                . "</li>";
        } else {

            $output .= "<li class='{$this->last_tag_disable_class}'>"
                . "<a {$this->anchor_class} href='javascript:void()'>$this->last_link</a>"
                . "</li>";
        }

        // Kill double slashes.  Note: Sometimes we can end up with a double slash
        // in the penultimate link so we'll kill all double slashes.
        $output = preg_replace("#([^:])//+#", "\\1/", $output);

        // Add the wrapper HTML if exists
        $length_select = "
            <select id='page_length' onchange='getData()' style='width:100px'>
                <option value='10' ".($this->per_page==10 ? 'selected': '').">10</option>
                <option value='20' ".($this->per_page==20 ? 'selected': '').">20</option>
                <option value='50' ".($this->per_page==50 ? 'selected': '').">50</option>
                <option value='100' ".($this->per_page==100 ? 'selected': '').">100</option>
            </select>";
        $output = $length_select. $this->full_tag_open . $output . $this->full_tag_close;
        return $output;
    }

    function getAJAXlink($count, $text)
    {
        $pageCount = $count ? $count : 0;
        return '<a href="javascript:void(0);"' . $this->anchor_class . ' onclick="' . $this->link_func . '(' . $pageCount . ')">' . $text . '</a>';
    }
}
// END Pagination Class
