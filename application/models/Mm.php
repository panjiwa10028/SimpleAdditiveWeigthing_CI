<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mm extends CI_Model {

   function __construct()
   {
      parent::__construct();
   }

	function get($table, $data=array(), $returnformat='rear')
   {
      $this->db->from($table);

      if (isset($data['select'])) $this->db->select($data['select'], FALSE);

      if (isset($data['join'])) {
         foreach($data['join'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->join($list[0], $list[1], $list[2]);
         }
      }

		if (isset($data['where'])) $this->db->where($data['where']);

		if (isset($data['or_where'])) {
         foreach ($data['or_where'] as $key=>$val){
            $this->db->or_where($key, $val);
         }
		}

      if (isset($data['like'])) {
         foreach ($data['like'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->like($list[0], $list[1], $list[2]);
         }
      }

      if (isset($data['or_like'])) {
         foreach($data['or_like'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->or_like($list[0], $list[1], $list[2]);
         }
      }

		if (isset($data['limit'])) {
		   $offset = ($data['offset']) ? $data['offset']: '';
			$this->db->limit($data['limit'], $offset);
      }

		if (isset($data['order'])) {
            $this->db->order_by($data['order']);
		}

		if (isset($data['group'])) {
         $this->db->group_by($data['group']);
      }

		if (isset($data['having'])) {
         $this->db->having($data['having']);
      }

      $query = $this->db->get();

      switch ($returnformat) {
         case 'rear' :
            return $query->result_array();
         break;
         case 'roar' :
            return $query->row_array();
         break;
      }
	}

	function count($table, $data=array())
   {
      $this->db->from($table);

      if (isset($data['join'])) {
         foreach($data['join'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->join($list[0], $list[1], $list[2]);
         }
      }

		if (isset($data['where'])) $this->db->where($data['where']);

		if (isset($data['or_where'])) {
         foreach ($data['or_where'] as $key=>$val){
            $this->db->or_where($key, $val);
         }
		}

      if (isset($data['like'])) {
         foreach ($data['like'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->like($list[0], $list[1], $list[2]);
         }
      }

      if (isset($data['or_like'])) {
         foreach($data['or_like'] as $list){
            $list[2] = isset($list[2]) ? $list[2] : '';
            $this->db->or_like($list[0], $list[1], $list[2]);
         }
      }

		if (isset($data['group_by'])) {
         $this->db->group_by($data['group_by']);
      }

		return $this->db->count_all_results();
	}

   function save($tabel, $data, $where=null)
   {
      if ($where) {
         $this->db->where($where);

         if ($this->db->update($tabel,$data)) {
            return TRUE;
         }
         else {
            return FALSE;
         }
      }
      else {
         if ($this->db->insert($tabel,$data)) {
            return $this->db->insert_id();
         }
         else {
            return FALSE;
         }
      }
   }

   function delete($tabel, $where=null)
   {
      if ($where) $this->db->where($where);

      if ($this->db->delete($tabel)) {
         return TRUE;
      }
      else {
         return FALSE;
      }
   }

   function query($sql, $returnformat='rear')
   {
      $query = $this->db->query($sql);
      switch($returnformat) {
         case 'rear' :
            return $query->result_array();
         break;
         case 'roar' :
            return $query->row_array();
         break;
      }
   }

   function tahun($a=null,$b=null)
   {
      $a = ($a) ? $a : (date('Y')-5);
      $b = ($b) ? $b : date('Y');

      for ($i=$a; $i<=$b; $i++) {
         $tahun[$i] = $i;
      }

      return $tahun;
   }

   function bulan()
   {
      $bulan['01'] = 'Januari';
      $bulan['02'] = 'Februari';
      $bulan['03'] = 'Maret';
      $bulan['04'] = 'April';
      $bulan['05'] = 'Mei';
      $bulan['06'] = 'Juni';
      $bulan['07'] = 'Juli';
      $bulan['08'] = 'Agustus';
      $bulan['09'] = 'September';
      $bulan['10'] = 'Oktober';
      $bulan['11'] = 'November';
      $bulan['12'] = 'Desember';

      return $bulan;
   }
}