<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('My_model', 'm');
		$this->load->helper('form');
		$this->load->helper('url');
	}

	public function index()
	{
		$data['title'] = 'CRUD Codeigniter Ajax';

		$this->load->view('home', $data);
	}

	// Menampilkan Data yg ada di Database
	function ambilData()
	{
		$dataBarang = $this->m->ambilData('tb_barang')->result();
		echo json_encode($dataBarang);
	}

	// Menambahkan Data
	function tambahData()
	{
		$kode_barang = $this->input->post('kode_barang');
		$nama_barang = $this->input->post('nama_barang');
		$harga 		 = $this->input->post('harga');
		$stok 		 = $this->input->post('stok');

		// Jika variabel kosong
		if ($kode_barang == '') {
			$result['pesan'] = 'Kode barang harus di isi';
		} elseif ($nama_barang == '') {
			$result['pesan'] = 'Nama barang harus di isi';
		} elseif ($harga == '') {
			$result['pesan'] = 'Harga barang harus di isi';
		} elseif ($stok == '') {
			$result['pesan'] = 'Stok barang harus di isi';
		} else {
			// Ketika semua variabel ada isinya
			$result['pesan'] = "";

			$data = [
				'kode_barang' => $kode_barang,
				'nama_barang' => $nama_barang,
				'harga' 	  => $harga,
				'stok' 		  => $stok,
			];
			$this->m->tambahData($data, 'tb_barang');
		}
		echo json_encode($result);
	}


	// ambil ID untuk Ubah Data
	function ambilId()
	{
		$id = $this->input->post('id');
		$where = ['id' => $id];

		$data = $this->m->ambilId('tb_barang', $where)->result();

		echo json_encode($data);
	}

	// Mengubah Data
	function ubahData()
	{
		$id 		 = $this->input->post('id');
		$kode_barang = $this->input->post('kode_barang');
		$nama_barang = $this->input->post('nama_barang');
		$harga 		 = $this->input->post('harga');
		$stok 		 = $this->input->post('stok');

		// Jika variabel kosong
		if ($kode_barang == '') {
			$result['pesan'] = 'Kode barang harus di isi';
		} elseif ($nama_barang == '') {
			$result['pesan'] = 'Nama barang harus di isi';
		} elseif ($harga == '') {
			$result['pesan'] = 'Harga barang harus di isi';
		} elseif ($stok == '') {
			$result['pesan'] = 'Stok barang harus di isi';
		} else {
			// Ketika semua variabel ada isinya
			$result['pesan'] = '';

			// Meng-ubah Data berdasarkan ID
			$where = ['id' => $id];

			$data = [
				'kode_barang' => $kode_barang,
				'nama_barang' => $nama_barang,
				'harga' 	  => $harga,
				'stok' 		  => $stok,
			];
			$this->m->ubahData($where, $data, 'tb_barang');
		}
		echo json_encode($data);
	}

	// Hapus Data
	function hapusData()
	{
		$id = $this->input->post('id');
		$where = ['id' => $id];

		// Kirim ke Model untuk di hapus
		$this->m->hapusData($where, 'tb_barang');
	}
}
