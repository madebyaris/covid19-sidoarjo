<?php
/**
 * This is where the main app reside.
 * See all the comments below for documentation.
 */

use voku\helper\HtmlDomParser as parser;
class Covid19 {

// Define kecamatan by ID
    private $list_kecamatan = array(
        'sidoarjo'      => 1,
        'buduran'       => 2,
        'candi'         => 3,
        'gedangan'      => 4,
        'tanggulangin'  => 5,
        'porong'        => 6,
        'jabon'         => 7,
        'taman'         => 8,
        'krembung'      => 9,
        'wonoayu'       => 10,
        'tulangan'      => 11,
        'krian'         => 12,
        'prambon'       => 13,
        'sukodono'      => 14,
        'sedati'        => 15,
        'waru'          => 16,
        'balongbendo'   => 17,
        'tarik'         => 18,
        'luar-wilayah'  => 19,
        'tanpa-wilayah' => 20
    );
 
    private $url_api_kecamatan = 'https://covid19.sidoarjokab.go.id/Newcase/totalkecamatan';
    private $url_covid_sidoarjo = 'https://covid19.sidoarjokab.go.id/';


    /**
     * Excute the function here.
     * if you want to create a simple background service with cron, you can place your code here.
     */
    public function __construct() {
    }

    /**
     * Get data kecamatan covid per distrct/kecamatan
     * 
     * @var integer $id_kecamatan
     * @return array
     */
    public function process_per_kecamatan( $id_kecamatan ) {
        $data = array();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url_api_kecamatan);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'id' => $id_kecamatan ) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);
        return $data;
    }

    /**
     * Create json data and file for per_kecamatan.
     * 
     * @return none
     */
    public function create_json_per_kecamatan() {
        foreach( $this->list_kecamatan as $kecamatan => $kecamatan_id ) {
            $data_kecamatan = $this->process_per_kecamatan($kecamatan_id);
            $file_create = fopen('json/'. $kecamatan .'.json', 'w');
            fwrite($file_create, json_encode( $data_kecamatan ) ); 
            fclose($file_create);
        }
    }

    /**
     * Get data from the site.
     */
    public function process_total_data_covid() {
        $data = array();
        $parent_dom = parser::file_get_html( $this->url_covid_sidoarjo );

        // Get the positive case
        $total_positive = (int) $this->get_data_by_query( $parent_dom, '.col-sm-12.col-md-4.mb-3' );
        
        // get the ODP case
        $total_odp = (int) $this->get_data_by_query( $parent_dom, '.col.mb-3', false, 1 );
        
        // get the PDP case
        $total_pdp = (int) $this->get_data_by_query( $parent_dom, '.col.mb-1' );

        $data = array(
            'positif' => $total_positive,
            'odp'     => $total_odp,
            'pdp'     => $total_pdp
        );

        return $data;
    }


    /**
     * Get the dom data and store the result.
     *  
     * @var object $the_dom you need to place the dom here
     * @var string $the_selector get the dom by query class / ID
     * @var boolean $is_single set true if the dom is single
     * @var integer $selector_number get the order data
     * 
     * @return integer/string.
     */
    public function get_data_by_query( $the_dom, $the_selector, $is_single = true, $selector_number = 1 ) {
        $result = '';

        if ( $is_single ) {
            $dom_data = $the_dom->findOne( $the_selector );
        } else {
            $dom_data = $the_dom->findMulti( $the_selector )[$selector_number];
        }
        
        $dom_data   = $dom_data->plaintext;
        $dom_data   = str_replace( 'POSITIF COVID-19', '', $dom_data );
        $dom_data   = str_replace( 'Orang Dalam Pemantauan (ODP)', '', $dom_data );
        $dom_data   = str_replace( 'Pasien Dalam Pengawasan (PDP)', '', $dom_data );
        $dom_data   = str_replace( 'Orang', '', $dom_data);
        $dom_result = str_replace(' ', '', $dom_data);

        if ( $dom_result != false || $dom_result != null ) {
            $result = $dom_result;
        }

        return $result;
    }

    /**
     * Create json file, make it easier for the dev.
     * this is simple way to create an cache.
     */
    public function create_json_total_data_covid() {
        $data_covid = $this->process_total_data_covid();

        $file_create = fopen('json/kecamatan.json', 'w');
        fwrite($file_create, json_encode( $data_covid ) ); 
        fclose($file_create);
    }


}
?>