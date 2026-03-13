<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/app_helpers.php';

class Invoice {

	private $host = 'localhost:3306';
	private $user = 'root';
	private $password = "";
	private $database = "newhurungu";

	private $invoiceUserTable = 'invoice_user';
	private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $dbConnect = false;

	public function __construct() {
		if (!$this->dbConnect) {
			$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
			if ($conn->connect_error) {
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			}
			$this->dbConnect = $conn;
			$conn->set_charset("utf8");
		}
	}

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($this->dbConnect));
		}
		$data = [];
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}

	private function esc($value): string {
		return mysqli_real_escape_string($this->dbConnect, (string)$value);
	}

	private function hasColumn(string $table, string $column): bool {
		$table = $this->esc($table);
		$column = $this->esc($column);
		$sql = "SHOW COLUMNS FROM `{$table}` LIKE '{$column}'";
		$res = mysqli_query($this->dbConnect, $sql);
		return $res && mysqli_num_rows($res) > 0;
	}

	public function loginUsers($email, $password) {
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile
			FROM {$this->invoiceUserTable}
			WHERE email='".$this->esc($email)."'
			AND password='".$this->esc($password)."'";
		return $this->getData($sqlQuery);
	}

	public function checkLoggedIn() {
		return !empty($_SESSION['userid']);
	}

	private function collectImagesFromRequest(array $post, array $files, array $existing = []): array {
		$images = $existing;

		$deleteList = [];
		if (!empty($post['deleted_images'])) {
			if (is_array($post['deleted_images'])) {
				$deleteList = $post['deleted_images'];
			} else {
				$decoded = json_decode((string)$post['deleted_images'], true);
				if (is_array($decoded)) {
					$deleteList = $decoded;
				}
			}
		}

		$images = remove_deleted_images($images, $deleteList);

		$uploaded = process_uploaded_images($files, 'valuation_images');
		foreach ($uploaded as $img) {
			$images[] = $img;
		}

		$coverPath = $post['cover_image'] ?? '';
		$images = apply_cover_to_images($images, $coverPath);

		foreach ($images as $i => &$img) {
			$img['sort'] = $i;
		}
		unset($img);

		return array_values($images);
	}

	public function saveInvoice($POST) {
		$images = $this->collectImagesFromRequest($POST, $_FILES, []);
		$imagesJson = images_json_encode($images);
		$coverImage = get_cover_image($images);
		$coverPath = $coverImage['path'] ?? '';

		$columns = [
			"user_id",
			"date",
			"uildverlegch",
			"mark",
			"ulsiin_dugaar",
			"uild_on",
			"or_on",
			"ungu",
			"aral",
			"utas",
			"zzune",
			"tuluulugch",
			"hariutsagch",
			"zereg",
			"zahialagch",
			"turul",
			"akt",
			"unelgeechin",
			"tuslah",
			"order_receiver_name",
			"order_receiver_address",
			"order_total_before_tax",
			"order_total_tax",
			"order_total_after_tax",
			"order_amount_paid",
			"order_total_amount_due",
			"note",
			"zassum",
			"budagune",
			"niitbudag",
			"shuudbus",
			"images",
			"shudzar_ind",
			"bzhz_ind",
			"tz_ind",
			"tb_ind",
			"inj_ind",
			"undur_ind",
			"hana_ind",
			"hiits_ind",
			"bus_ind"
		];

		$values = [
			$this->esc($POST['userId'] ?? ''),
			$this->esc($POST['date'] ?? ''),
			$this->esc($POST['uname'] ?? ''),
			$this->esc($POST['uname1'] ?? ''),
			$this->esc($POST['ulsiin_dugaar'] ?? ''),
			$this->esc($POST['uild_on'] ?? ''),
			$this->esc($POST['or_on'] ?? ''),
			$this->esc($POST['ungu'] ?? ''),
			$this->esc($POST['aral'] ?? ''),
			$this->esc($POST['utas'] ?? ''),
			$this->esc($POST['zzune'] ?? ''),
			$this->esc($POST['tuluulugch'] ?? ''),
			$this->esc($POST['hariutsagch'] ?? ''),
			$this->esc($POST['zereg'] ?? ''),
			$this->esc($POST['zahialagch'] ?? ''),
			$this->esc($POST['turul'] ?? ''),
			$this->esc($POST['akt'] ?? ''),
			$this->esc($POST['unelgeechin'] ?? ''),
			$this->esc($POST['tuslah'] ?? ''),
			$this->esc($POST['companyName'] ?? ''),
			$this->esc($POST['address'] ?? ''),
			$this->esc($POST['subTotal'] ?? ''),
			$this->esc($POST['taxAmount'] ?? ''),
			$this->esc($POST['totalAftertax1'] ?? ''),
			$this->esc($POST['amountPaid'] ?? ''),
			$this->esc($POST['amountDue'] ?? ''),
			$this->esc($POST['notes'] ?? ''),
			$this->esc($POST['zassum'] ?? ''),
			$this->esc($POST['budagune'] ?? ''),
			$this->esc($POST['niitbudag'] ?? ''),
			$this->esc($POST['shuudbus'] ?? ''),
			$this->esc($imagesJson),
			$this->esc($POST['shudzar_ind'] ?? ''),
			$this->esc($POST['bzhz_ind'] ?? ''),
			$this->esc($POST['tz_ind'] ?? ''),
			$this->esc($POST['tb_ind'] ?? ''),
			$this->esc($POST['inj_ind'] ?? ''),
			$this->esc($POST['undur_ind'] ?? ''),
			$this->esc($POST['hana_ind'] ?? ''),
			$this->esc($POST['hiits_ind'] ?? ''),
			$this->esc($POST['bus_ind'] ?? '')
		];

		if ($this->hasColumn($this->invoiceOrderTable, 'cover_image')) {
			$columns[] = 'cover_image';
			$values[] = $this->esc($coverPath);
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'cost_final_value')) {
			$columns[] = 'cost_final_value';
			$values[] = $this->esc($POST['cost_final_value'] ?? '');
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'income_final_value')) {
			$columns[] = 'income_final_value';
			$values[] = $this->esc($POST['income_final_value'] ?? '');
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'market_final_value')) {
			$columns[] = 'market_final_value';
			$values[] = $this->esc($POST['market_final_value'] ?? '');
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'final_reconciled_value')) {
			$columns[] = 'final_reconciled_value';
			$values[] = $this->esc($POST['final_reconciled_value'] ?? '');
		}

		$sqlInsert = "INSERT INTO {$this->invoiceOrderTable} (`" . implode('`,`', $columns) . "`) VALUES ('" . implode("','", $values) . "')";
		mysqli_query($this->dbConnect, $sqlInsert);

		$lastInsertId = mysqli_insert_id($this->dbConnect);

		if (!empty($POST['productCode']) && is_array($POST['productCode'])) {
			for ($i = 0; $i < count($POST['productCode']); $i++) {
				$sqlInsertItem = "
					INSERT INTO {$this->invoiceOrderItemTable}
					(order_id, item_code, order_item_quantity, zasvar, budag, solih, survalj, order_item_price, order_item_final_amount)
					VALUES (
						'".$this->esc($lastInsertId)."',
						'".$this->esc($POST['productCode'][$i] ?? '')."',
						'".$this->esc($POST['quantity'][$i] ?? '')."',
						'".$this->esc($POST['zasvar'][$i] ?? '')."',
						'".$this->esc($POST['budag'][$i] ?? '')."',
						'".$this->esc($POST['solih'][$i] ?? '')."',
						'".$this->esc($POST['survalj'][$i] ?? '')."',
						'".$this->esc($POST['price'][$i] ?? '')."',
						'".$this->esc($POST['total'][$i] ?? '')."'
					)";
				mysqli_query($this->dbConnect, $sqlInsertItem);
			}
		}

		return $lastInsertId;
	}

	public function updateInvoice($POST) {
		if (empty($POST['invoiceId'])) {
			return false;
		}

		$existing = $this->getInvoice($POST['invoiceId']);
		$existingImages = normalize_images_json($existing['images'] ?? '[]');
		$images = $this->collectImagesFromRequest($POST, $_FILES, $existingImages);
		$imagesJson = images_json_encode($images);
		$coverImage = get_cover_image($images);
		$coverPath = $coverImage['path'] ?? '';

		$sqlUpdate = "
			UPDATE {$this->invoiceOrderTable}
			SET
				date = '".$this->esc($POST['date'] ?? '')."',
				uildverlegch = '".$this->esc($POST['uname'] ?? '')."',
				mark = '".$this->esc($POST['uname1'] ?? '')."',
				ulsiin_dugaar = '".$this->esc($POST['ulsiin_dugaar'] ?? '')."',
				uild_on = '".$this->esc($POST['uild_on'] ?? '')."',
				or_on = '".$this->esc($POST['or_on'] ?? '')."',
				ungu = '".$this->esc($POST['ungu'] ?? '')."',
				aral = '".$this->esc($POST['aral'] ?? '')."',
				utas = '".$this->esc($POST['utas'] ?? '')."',
				zzune = '".$this->esc($POST['zzune'] ?? '')."',
				tuluulugch = '".$this->esc($POST['tuluulugch'] ?? '')."',
				hariutsagch = '".$this->esc($POST['hariutsagch'] ?? '')."',
				zereg = '".$this->esc($POST['zereg'] ?? '')."',
				zahialagch = '".$this->esc($POST['zahialagch'] ?? '')."',
				turul = '".$this->esc($POST['turul'] ?? '')."',
				akt = '".$this->esc($POST['akt'] ?? '')."',
				unelgeechin = '".$this->esc($POST['unelgeechin'] ?? '')."',
				tuslah = '".$this->esc($POST['tuslah'] ?? '')."',
				order_receiver_name = '".$this->esc($POST['companyName'] ?? '')."',
				order_receiver_address = '".$this->esc($POST['address'] ?? '')."',
				order_total_before_tax = '".$this->esc($POST['subTotal'] ?? '')."',
				order_total_tax = '".$this->esc($POST['taxAmount'] ?? '')."',
				order_total_after_tax = '".$this->esc($POST['totalAftertax1'] ?? '')."',
				order_amount_paid = '".$this->esc($POST['amountPaid'] ?? '')."',
				order_total_amount_due = '".$this->esc($POST['amountDue'] ?? '')."',
				note = '".$this->esc($POST['notes'] ?? '')."',
				zassum = '".$this->esc($POST['zassum'] ?? '')."',
				budagune = '".$this->esc($POST['budagune'] ?? '')."',
				niitbudag = '".$this->esc($POST['niitbudag'] ?? '')."',
				shuudbus = '".$this->esc($POST['shuudbus'] ?? '')."',
				images = '".$this->esc($imagesJson)."',
				shudzar_ind = '".$this->esc($POST['shudzar_ind'] ?? '')."',
				bzhz_ind = '".$this->esc($POST['bzhz_ind'] ?? '')."',
				tz_ind = '".$this->esc($POST['tz_ind'] ?? '')."',
				tb_ind = '".$this->esc($POST['tb_ind'] ?? '')."',
				inj_ind = '".$this->esc($POST['inj_ind'] ?? '')."',
				undur_ind = '".$this->esc($POST['undur_ind'] ?? '')."',
				hana_ind = '".$this->esc($POST['hana_ind'] ?? '')."',
				hiits_ind = '".$this->esc($POST['hiits_ind'] ?? '')."',
				bus_ind = '".$this->esc($POST['bus_ind'] ?? '')."'";

		if ($this->hasColumn($this->invoiceOrderTable, 'cover_image')) {
			$sqlUpdate .= ", cover_image = '".$this->esc($coverPath)."'";
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'cost_final_value')) {
			$sqlUpdate .= ", cost_final_value = '".$this->esc($POST['cost_final_value'] ?? '')."'";
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'income_final_value')) {
			$sqlUpdate .= ", income_final_value = '".$this->esc($POST['income_final_value'] ?? '')."'";
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'market_final_value')) {
			$sqlUpdate .= ", market_final_value = '".$this->esc($POST['market_final_value'] ?? '')."'";
		}

		if ($this->hasColumn($this->invoiceOrderTable, 'final_reconciled_value')) {
			$sqlUpdate .= ", final_reconciled_value = '".$this->esc($POST['final_reconciled_value'] ?? '')."'";
		}

		$sqlUpdate .= " WHERE order_id = '".$this->esc($POST['invoiceId'])."'";
		mysqli_query($this->dbConnect, $sqlUpdate);

		$this->deleteInvoiceItems($POST['invoiceId']);

		if (!empty($POST['productCode']) && is_array($POST['productCode'])) {
			for ($i = 0; $i < count($POST['productCode']); $i++) {
				$sqlInsertItem = "
					INSERT INTO {$this->invoiceOrderItemTable}
					(order_id, item_code, order_item_quantity, zasvar, budag, solih, survalj, order_item_price, order_item_final_amount)
					VALUES (
						'".$this->esc($POST['invoiceId'])."',
						'".$this->esc($POST['productCode'][$i] ?? '')."',
						'".$this->esc($POST['quantity'][$i] ?? '')."',
						'".$this->esc($POST['zasvar'][$i] ?? '')."',
						'".$this->esc($POST['budag'][$i] ?? '')."',
						'".$this->esc($POST['solih'][$i] ?? '')."',
						'".$this->esc($POST['survalj'][$i] ?? '')."',
						'".$this->esc($POST['price'][$i] ?? '')."',
						'".$this->esc($POST['total'][$i] ?? '')."'
					)";
				mysqli_query($this->dbConnect, $sqlInsertItem);
			}
		}

		return true;
	}

	public function getInvoiceList() {
		$sqlQuery = "SELECT * FROM {$this->invoiceOrderTable} ORDER BY order_id DESC";
		return $this->getData($sqlQuery);
	}

	public function getInvoice($invoiceId) {
		$sqlQuery = "SELECT * FROM {$this->invoiceOrderTable} WHERE order_id = '".$this->esc($invoiceId)."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		return mysqli_fetch_array($result, MYSQLI_ASSOC);
	}

	public function getInvoiceItems($invoiceId) {
		$sqlQuery = "SELECT * FROM {$this->invoiceOrderItemTable} WHERE order_id = '".$this->esc($invoiceId)."'";
		return $this->getData($sqlQuery);
	}

	public function deleteInvoiceItems($invoiceId) {
		$sqlQuery = "DELETE FROM {$this->invoiceOrderItemTable} WHERE order_id = '".$this->esc($invoiceId)."'";
		mysqli_query($this->dbConnect, $sqlQuery);
	}

	public function deleteInvoice($invoiceId) {
		$invoice = $this->getInvoice($invoiceId);
		$images = normalize_images_json($invoice['images'] ?? '[]');

		foreach ($images as $img) {
			$path = $img['path'] ?? '';
			if ($path) {
				$full = __DIR__ . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
				if (is_file($full)) {
					@unlink($full);
				}
			}
		}

		$sqlQuery = "DELETE FROM {$this->invoiceOrderTable} WHERE order_id = '".$this->esc($invoiceId)."'";
		mysqli_query($this->dbConnect, $sqlQuery);
		$this->deleteInvoiceItems($invoiceId);
		return 1;
	}
}
?>