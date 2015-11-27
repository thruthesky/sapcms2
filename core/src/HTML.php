<?php
namespace sap\src;
class HTML {

    protected $meta = [];
    protected $body = null;
    protected $title = null;
    protected $content = null;

    public static function create()
    {
        return new HTML();
    }

    public function meta($key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    public function body($html)
    {
        $this->body = $html;
    }
    public function get()
    {
        $m = "<!doctype html>";
        $m .= "<html>\n";
        $m .= "<head>\n";
        foreach( $this->meta as $k => $v ) {
            $m .= "<meta $k='$v'>\n";
        }
        $m .= "</head>\n";
        $m .= $this->body;
        $m .= "<body>\n";
        $m .= "</body>\n";
        $m .= "</html>\n";
        return $m;
    }

    public function box($attr)
    {
    }




    /**
     *
     * Returns HTML elements for displaying page navigation
     * @param $page_no - current page number
     * @param $total_record - the whole number of item for the forum/mall category/table
     * @param $no_of_items_per_page - items per page
     * @param $qs - Extra query string.
     *      - If you want to add some http query.
     *      - Query string
     * @param int $no_of_pages_in_navigation_bar - is the number of pages in navigation. How many pages you want to show in the navigation bar.
     * @param array $text - Texts on navigation bar.
     *        - This is the text on the navigation bar.
     *      - You can set a text for first page, previous page, next page, last page and so on.
     *      - ex) $text = array("First ", "Previous (n)", "Next (n)", "Last");
     *          -- Where '(n)' is number of actual page.
     * @param $path - is the page of the index.php
     * @return string
     * @code
     *      echo HTML::paging(page_no(), $total_record, $no_item, $no_page);
     * @endcode
     * @code How to display list and navigation bar.
     *      // Get current page no
     *      if ( $in[page_no] ) $page_no = $in[page_no];
     *      else $page_no = 1;
     *      // Get number of item to show in one page.
     *      $no_of_items_per_page = 15;
     * // Get total number of records.
     *      $total_record = 123456;
     *      // How to get the list from database.
     *      $rows = mysql_query("select * from table_name order by UID desc limit " . ($page_no - 1) * $no_of_items_per_page . ", ". $no_of_items_per_page, $connect);
     * // display content...
     *      // display navigation bar like below.
     *      echo paging( $page_no, $total_record, $no_of_items_per_page );
     * @endcode
     *
     * @code
    $qs = request();
    unset($qs["page_no"]);
    unset($qs["idx"]);
    unset($qs["idx_comment"]);
    $qs['id'] = post_config()->getCurrent()->get('id');
    $q = http_build_query($qs);
    echo HTML::paging(page_no(), $total_record, $no_item, $no_page, null, $q, '/post/list');
     * @endcode
     *
     *
     * @note If you omit $qs, $_GET['page_no'] will be deleted and set new page no.
     * @note How to design
     *      - You can edit style with CSS Style Overriding
     *      - Each block has a class='cell'
     *      - ex) .navigator .cell { ... }
     *
     *
     * @note CSS classes
     *
     * - nav.navigation-bar - is the wrapper
     *      - class='first_page' - is the first page.
     *      - class='previous_page' - is the previous page.
     *      - class='page_no' - is each page.
     *      - class='selected' - is the current page.
     *      - class='next_page' - is next page.
     *      - class='last_page' '- is last page.
     *
     * @note Sample CSS Code
    nav.navigation-bar a {
    display:inline-block;
    margin:0 1px;
    padding:4px 6px;
    background-color: #d3e8f4;
    border-radius: 2px;
    }
     */
    public static function paging(
        $page_no,
        $total_record,
        $no_of_items_per_page,
        $no_of_pages_in_navigation_bar=10,
        $text=null,
        $qs=NULL,
        $path=null
    )
    {
        if ( empty($total_record) ) return NULL;
        if ( empty($text) ) $text = array("&lt;&lt;", "Previous (n)", "Next (n)", "&gt;&gt;");
        $paging = $no_of_pages_in_navigation_bar;



        /// If you uncomment below, "[ 1 ]" will not appear on a list where there is only 1 page.
        if ( $total_record <= $no_of_items_per_page ) return NULL;


        /**
         * @Attention Do not edit this code. It will ruin every where if you edit it.
         */
        if ( $qs === null ) {
            /// @warning when the input of $qs is empty,
            /// it returns the value of HTTP input except page_no and idx
            /// and it puts $in[action]='list'
            $qv = Request::get();
            unset($qv["page_no"]);
            unset($qv["idx"]);//added by benjamin
            $qs = http_build_query($qv);
        }


        // Number pages to show in navigation bar.
        // Default number of pages is 10.
        if ( !$paging ) $paging = 10;

        // Number of pages to display on navigatio bar.
        $text[1] = str_replace("(n)", $paging, $text[1]);
        $text[2] = str_replace("(n)", $paging, $text[2]);


        // Total number of pages.
        if ( $total_record % $no_of_items_per_page != 0 ) {
            $totalpage = intval($total_record / $no_of_items_per_page) + 1;
        } else {
            $totalpage = intval($total_record / $no_of_items_per_page);
        }





        // Page number that begins on the navigation bar.
        if ( $page_no % $paging == 0 ) {
            $startpage = $page_no - ( $paging - 1 );
        } else {
            $startpage = intval( $page_no / $paging ) * $paging + 1;
        }


        // Prvious Page number
        $prevpage = $startpage - 1;

        // Next Page number
        $nextpage = $startpage + $paging;

        // Lst Page number
        if ( $totalpage / $paging > 1 ) {
            $laststartpage = (intval($totalpage / $paging) * $paging ) + 1;
        } else {
            $laststartpage = 1;
        }


        $rt = "<div class='navigation-bar'>";

        /** @short first page button.
         *
         * @note If the text is empty, it does not show the first page button.
         */
        $first_page = "$text[0]";
        if ( $first_page && $page_no > $paging ) {

            if ( $qs ) {
                $rt .= "<a class='first-page' href='$path?page_no=1&".$qs."'>";
            } else {
                $rt .= "<a class='first-page' href='$path?page_no=1'>";
            }
            $rt .= "$first_page</a>";
        } else {

        }


        // Previous page button
        $previous_page = "$text[1]";
        if ( $totalpage > $paging && $page_no > $paging ) {
            if ( $qs ) {
                $rt .= "<a class='prev-page' href='$path?page_no=".$prevpage."&".$qs."'>";
            } else {
                $rt .= "<a class='prev-page' href='$path?page_no=".$prevpage."'>";
            }
            $rt .= "<span class='no'>$previous_page</span></a>";
        } else {
        }



        // This is list has only one(1) page?
        if ( $totalpage <= 1 ) {
            $rt .= "<div class='one-page'>1</div>";
        }
        else {
            // Page number list.
            for ( $i = $startpage ; $i <= ($startpage + ($paging - 1) ) ; $i++ ) {
                // If this page number is not the current page,
                if ( $page_no != $i ) {
                    if ( $qs ) {
                        $rt .= "<a class='page' href='$path?page_no=".$i."&".$qs."'>".$i."</a>";
                    } else {
                        $rt .= "<a class='page' href='$path?page_no=".$i."'>".$i."</a>";
                    }
                }
                // If this page number is the current page,
                else {
                    $rt .= "<a class='page selected' href='javascript:void(0);'>".$i."</a>";
                }

                //
                if ( $i >= $totalpage ) {
                    break;
                }
            }
        }

        // 'Move to Next block' button
        $next_page = "$text[2]";

        if ( $startpage + $paging - 1 < $totalpage) {
            if ( $qs ) {
                $rt .= "<a class='next-page' href='$path?page_no=".$nextpage."&".$qs."'>";
            } else {
                $rt .= "<a class='next-page' href='$path?page_no=".$nextpage."'>";
            }
            $rt .= "$next_page</a>";
        } else {

        }


        /** @short Move to last page button.
         *
         * @note If the text is empty, it does not show the last page button.
         */
        $last_page = "$text[3]";
        if ( $last_page && $page_no < intval($laststartpage) ) {
            if ( $qs ) {
                $rt .= "<a class='last-page' href='$path?page_no=".$totalpage."&".$qs."'>";
            } else {
                $rt .= "<a class='last-page' href='$path?page_no=".$totalpage."'>";
            }
            $rt .= "$last_page</a>";
        }
        else {
        }

        $rt .= "</div>";

        return $rt;
    }


}