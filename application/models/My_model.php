<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_model extends CI_Model
{
    // Menampilkan Data
    function ambilData($table)
    {
        return $this->db->get($table);
    }

    // Menambahkan Data
    function tambahData($data, $table)
    {
        $this->db->insert($table, $data);
    }

    // Mengambil ID untuk Mengubah Data
    function ambilId($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    // Melakukan Ubah Data
    function ubahData($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    // Menghapus Data
    function hapusData($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
}
