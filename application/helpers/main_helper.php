<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/***
	* Debug Error
*/

	if(! function_exists("tesx")) {

		/**  Error Tracing */
		function tesx()
		{
			$env = (ENVIRONMENT == 'production') ? 'none' : 'block; background-color: #c7c5b2;';
			$args = func_get_args();
			if(is_array($args) && count($args)){ foreach($args as $x){
				$echo = "<div style='display:$env'><pre style='padding: 1rem;'>";
				if(is_array($x) || is_object($x)){
					$echo .= print_r($x, true);
				}else{
					$echo .= var_export($x, true);
				}
				$echo .= "</pre><hr /></div>";
				echo $echo;
			}}
			die();
		}
	}

	if(! function_exists("curl")) {
		function curl(){
			$current_url = current_url();
			$string = base_url();

			$url = str_replace($string, '', $current_url);
			return $url;
		}
	}

	if (!function_exists('trim_array')) {
		function trim_array(array $array) {
			$cleaned_array = array();
			foreach ($array as $key => $value) {
			$cleaned_array[$key] = trim($value);
			}
			return $cleaned_array;
		}
	}

	if(! function_exists("cekError")) {
		function cekError($error){

			if ($error['code'] == 1062) {
				// Tangani duplikat entry
				return "Terjadi kesalahan : " .un_char($error['message'])." <br>";
			} elseif ($error['code'] != 0) {
				// Tangani error lain
				return "Terjadi kesalahan : " .un_char($error['message'])." <br>";
			}

		}
	}


/*** -- END Debug Error -- */


/*** Convert Text
	* - Unspace
	* - Unstrip
	* - Strip
	* - Lowecase
	* - Uppercase
	* - Capital
 */

	if(! function_exists("un_char")) {
		function un_char($val){
			$string = str_replace(array('\'','_', '.', '?'), '', $val);
			return $string;
		}
	}

	if(! function_exists("un_space")) {
		function un_space($val){
			$string = str_replace(array(' '), '', $val);
			return $string;
		}
	}

	if(! function_exists("un_strip")) {
		function un_strip($val){
			$string = str_replace(array('_', '.', '?'), ' ', $val);
			return $string;
		}
	}

	if(! function_exists("to_strip")) {
		function to_strip($val){
			$string = strtolower(str_replace(array(' ', '.', '?'), '_', $val));
			return $string;
		}
	}

	if(! function_exists("lowercase")) {
		function lowercase($val){
			$string = strtolower(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

	if(! function_exists("uppercase")) {
		function uppercase($val){
			$string = strtoupper(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

	if(! function_exists("capital")) {
		function capital($val){
			$string = ucwords(str_replace(array('_', '.', '?'), ' ', $val));
			return $string;
		}
	}

/** -- END Convert Text  -- */


/**  Convert Date & Numeric */

	if(! function_exists("currency")) {
		function currency($angka){
			$jd = 'Rp. '.number_format($angka,2,',','.');
			return $jd;
		}
	}

	if(! function_exists("nominal")) {
		function nominal($angka){
			$jd = number_format($angka,2,',','.');
			return $jd;
		}
	}

	if(! function_exists("diskon")) {
		function diskon($angka){
			$jd = number_format($angka,1,',','.').' %';
			return $jd;
		}
	}

	if(! function_exists("tanggal")) {
		function tanggal($date){
			date_default_timezone_set('Asia/Jakarta');

			$c = strtotime($date);

			if($c > 0){
				$result = date("d/m/Y",strtotime($date));
			}else{
				$result = $date;
			}

			return $result;
		}
	}

	if(! function_exists("tanggal_indo")) {
		function tanggal_indo($date){
			date_default_timezone_set('Asia/Jakarta');
			// array hari dan bulan
			$Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

			// pemisahan tahun, bulan, hari, dan waktu
			$tahun = substr($date,0,4);
			$bulan = substr($date,5,2);
			$tgl = substr($date,8,2);
			$waktu = substr($date,11,5);
			$hari = date("w",strtotime($date));
			$result = $Hari[$hari];

			return $result;
		}
	}

	if(! function_exists("nama_hari")) {
		function nama_hari($date){
			date_default_timezone_set('Asia/Jakarta');
			// array hari dan bulan
			$Hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
			$Bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

			// pemisahan tahun, bulan, hari, dan waktu
			$tahun = substr($date,0,4);
			$bulan = substr($date,5,2);
			$tgl = substr($date,8,2);
			$waktu = substr($date,11,5);
			$hari = date("w",strtotime($date));
			$result = $Hari[$hari];

			return $result;
		}
	}

	if(! function_exists("time_ago")) {
		function time_ago($time, $now)
		{
			$periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");

			if($now == NULL){
				$now = time();
			}

			$difference     = $now - $time;
			$tense         = "ago";

			for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				$difference /= $lengths[$j];
			}

			$difference = round($difference);

			if($difference != 1) {
				$periods[$j].= "s";
			}

			return "$difference $periods[$j] ";
		}
	}

	if(! function_exists("selisih_jam")) {
		function selisih_jam($time, $now){

			$diff  = $now-$time;
			$jam   = floor($diff / (60 * 60));
			$menit = $diff - ( $jam * (60 * 60) );
			$detik = $diff % 60;

			$result = $jam . ' Jam : ' . floor( $menit / 60 ) . ' Menit : ' .$detik. ' Detik';
			// tesx($result);
			return $result;
		}
	}

/**  End Convert Date & Numeric */



/**
 * Category Code Helper
 * Helper untuk generate kode kategori dari nama
 */

	if (!function_exists('generate_category_code')) {
		/**
		 * Generate kode kategori dari nama
		 * Default 3 karakter untuk satu kata, boleh lebih untuk multiple kata
		 * 
		 * @param string $name Nama kategori
		 * @return string Kode kategori yang dihasilkan
		 */
		function generate_category_code($name) {
			// Bersihkan nama dari karakter khusus dan spasi
			$clean_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
			$clean_name = trim($clean_name);
			
			if (empty($clean_name)) {
				return 'CAT'; // Default jika nama kosong
			}
			
			// Pisahkan kata-kata
			$words = explode(' ', $clean_name);
			$words = array_filter($words); // Hapus elemen kosong
			$code = '';
			
			// Jika hanya satu kata - default 3 karakter
			if (count($words) == 1) {
				$word = $words[0];
				if (strlen($word) >= 3) {
					$code = strtoupper(substr($word, 0, 3));
				} else {
					$code = strtoupper(str_pad($word, 3, '0', STR_PAD_RIGHT));
				}
			} else {
				// Jika lebih dari satu kata - ambil huruf pertama dari setiap kata
				foreach ($words as $word) {
					if (!empty($word)) {
						$code .= strtoupper(substr($word, 0, 1));
					}
				}
			}
			
			return $code;
		}
	}

	if (!function_exists('generate_unique_category_code')) {
		/**
		 * Generate kode kategori unik dengan suffix angka jika diperlukan
		 * Menyesuaikan dengan panjang kode base yang bervariasi
		 * 
		 * @param string $base_code Kode dasar
		 * @param array $existing_codes Array kode yang sudah ada
		 * @return string Kode unik
		 */
		function generate_unique_category_code($base_code, $existing_codes = array()) {
			$unique_code = $base_code;
			
			// Jika kode belum ada, langsung return
			if (!in_array($unique_code, $existing_codes)) {
				return $unique_code;
			}
			
			$base_length = strlen($base_code);
			
			// Strategi berbeda berdasarkan panjang kode base
			if ($base_length <= 3) {
				// Untuk kode 3 karakter atau kurang, gunakan sistem seperti sebelumnya
				return generate_unique_code_short($base_code, $existing_codes);
			} else {
				// Untuk kode lebih dari 3 karakter, tambahkan suffix angka
				return generate_unique_code_long($base_code, $existing_codes);
			}
		}
		
		/**
		 * Generate kode unik untuk base code pendek (≤3 karakter)
		 * 
		 * @param string $base_code Kode dasar
		 * @param array $existing_codes Array kode yang sudah ada
		 * @return string Kode unik
		 */
		function generate_unique_code_short($base_code, $existing_codes) {
			$base_length = strlen($base_code);
			
			// Level 1: Ganti karakter terakhir dengan angka (1-9)
			if ($base_length >= 2) {
				$base_prefix = substr($base_code, 0, $base_length - 1);
				for ($i = 1; $i <= 9; $i++) {
					$unique_code = $base_prefix . $i;
					if (!in_array($unique_code, $existing_codes)) {
						return $unique_code;
					}
				}
			}
			
			// Level 2: Ganti 2 karakter terakhir dengan angka (10-99)
			if ($base_length >= 3) {
				$base_prefix = substr($base_code, 0, $base_length - 2);
				for ($i = 10; $i <= 99; $i++) {
					$unique_code = $base_prefix . $i;
					if (!in_array($unique_code, $existing_codes)) {
						return $unique_code;
					}
				}
			}
			
			// Level 3: Gunakan 3 digit angka (001-999)
			for ($i = 1; $i <= 999; $i++) {
				$unique_code = str_pad($i, 3, '0', STR_PAD_LEFT);
				if (!in_array($unique_code, $existing_codes)) {
					return $unique_code;
				}
			}
			
			// Fallback
			return 'Z' . str_pad(rand(10, 99), 2, '0', STR_PAD_LEFT);
		}
		
		/**
		 * Generate kode unik untuk base code panjang (>3 karakter)
		 * 
		 * @param string $base_code Kode dasar
		 * @param array $existing_codes Array kode yang sudah ada
		 * @return string Kode unik
		 */
		function generate_unique_code_long($base_code, $existing_codes) {
			// Level 1: Tambah suffix angka 1-99
			for ($i = 1; $i <= 99; $i++) {
				$unique_code = $base_code . $i;
				if (!in_array($unique_code, $existing_codes)) {
					return $unique_code;
				}
			}
			
			// Level 2: Tambah suffix angka 3 digit (100-999)
			for ($i = 100; $i <= 999; $i++) {
				$unique_code = $base_code . $i;
				if (!in_array($unique_code, $existing_codes)) {
					return $unique_code;
				}
			}
			
			// Fallback: Potong dan tambah random
			$short_base = substr($base_code, 0, 2);
			return $short_base . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
		}
	}

	if (!function_exists('clean_category_name')) {
		/**
		 * Bersihkan nama kategori dari karakter yang tidak diinginkan
		 * 
		 * @param string $name Nama kategori
		 * @return string Nama yang sudah dibersihkan
		 */
		function clean_category_name($name) {
			// Hapus karakter khusus kecuali huruf, angka, dan spasi
			$clean = preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
			// Hapus spasi berlebihan
			$clean = preg_replace('/\s+/', ' ', $clean);
			return trim($clean);
		}
	}

/* End of file category_code_helper.php */



/**  Helper Auth User */

	if(! function_exists("check")) {

		/** Check if current user is logged in. */
		function check()
		{
			$auth = new Auth();
			return $auth->loginStatus();
		}
	}

	if(! function_exists("can")) {

		/**  Check if current user has a permission by its name.
		 *   Example: if( can('edit-posts') ) {} or if( can(['edit-posts', 'publish-posts']) ) {}
		 */
		function can($permissions)
		{
			$auth = new Auth();
			return $auth->can($permissions);
		}
	}

	if(! function_exists("hasRole")) {

		/**  Checks if the current user has a role by its name. */
		function hasRole($roles)
		{
			$auth = new Auth();
			return $auth->hasRole($roles);
		}
	}

/** End Helper Auth User */