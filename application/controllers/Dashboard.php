<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends HX_Controller {

  public function __construct() {
    parent::__construct();
  }

  // halaman Dashboard yang akan dijalankan pertama kali
  public function index() {
    $load['_judul'] = 'Dashboard';

    // query 5 berita terakhir
    $param['select'] = 'berita.*, user.nama_lengkap as admin';
    $param['join']   = array(array('user','berita.id_user=user.id_user','left'));
    $param['order']  = 'tanggal_post DESC';
    $param['limit']  = 5;
    $param['offset'] = 0;

    // eksekusi query ke database
    $load['berita']  = $this->mm->get('berita',$param);

    // kirim data ke view Dashboard
    $this->view_publik('home/dashboard', $load);
  }

  // halaman hasil perangkingan responden
  public function hasil($offset=null) {
    $get     = $this->input->get();
    $like    = array();
    $get_na  = '';
    $get_tg1 = '';
    $get_tg2 = '';

    if (isset($get['nama']) && $get['nama']) {
      $get_na = $get['nama'];
      $like   = array(array('nama_penyakit',$get['nama']));
    }

    if (isset($get['tanggal_start']) && $get['tanggal_start']) {
      $get_tg1    = $get['tanggal_start'];
      $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
    }

    if (isset($get['tanggal_end']) && $get['tanggal_end']) {
      $get_tg2    = $get['tanggal_end'];
      $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
    }

    $fields['nama'] = array('label'=>'Cari Nama Penyakit','tipe'=>'text','value'=>$get_na);
    $fields['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
    $fields['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

    $load['pencarian'] = ($get) ? TRUE : FALSE;
    $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'dashboard/hasil'),$fields,$get);

    // parameter utk ambil data dr database
    $param['select'] = 'DISTINCT(hasil.id_responden), responden.nama_responden, responden.tanggal, jenis_responden.nama_jenis_responden as jenis_responden';
    $param['join']   = array(
      array('responden','jenis_responden.id_jenis_responden=responden.id_jenis_responden','left'),
      array('hasil','responden.id_responden=hasil.id_responden','right')
      );
    $param['order']  = 'nama_responden ASC';
    $param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;  
    if ((!empty($get_tg1)) && (!empty($get_tg2))) {
      $param['where']   = 'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
    } 
    // ambil data dari database
    $result   = $this->mm->get('jenis_responden',$param);
    foreach ($result as $key => $value) {
      $param            = array();
      $temp             = array();
      $param['select']  = 'penyakit.nama_penyakit, gejala.score';
      $param['join']    = array(
        array('hasil','gejala.id_gejala = hasil.id_gejala','left'),
        array('penyakit','gejala.id_penyakit = penyakit.id_penyakit','left'),
        );
      $param['where']   = 'hasil.id_responden="'.$value['id_responden'].'"';
      $param['order']   = 'penyakit.nama_penyakit ASC';
      $query            = $this->mm->get('gejala',$param);
       // Menghitung nilai bobot dari gejala
      foreach ($query as $k => $val) {
        if ($k === 0) {
          array_push($temp, $val);
        } else {
          foreach ($temp as $data => $v) {
            if (in_array($val['nama_penyakit'], $v)) {
              $temp[$data]['score'] += $val['score'];
              array_pop($temp);
            } else {
              array_push($temp, $val);
            }
          }
        }
      }
       // Mengurutkan nilai score tertinggi masing2 penyakit
      usort($temp, function($a, $b) {
        return $a['score'] <= $b['score'];
      });
         // Mengambil 1 index teratas
      array_splice($temp, 1);
      $result[$key]['penyakit']  = $temp[0]['nama_penyakit'];
      $result[$key]['score']     = $temp[0]['score'];
    }
    usort($result, function($a, $b) {
      return $a['score'] <= $b['score'];
    });
    $jml_data = count($result);

    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/hasil';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    $arr['nomor_hal']   = $jml_a;
    $arr['kunci']       = 'id_responden';
    $arr['master']      = null;

    $field['nama_responden']  = array('label'=>'Nama Responden','tipe'=>'text');
    $field['jenis_responden'] = array('label'=>'Jenis Responden','tipe'=>'text');
    $field['tanggal']         = array('label'=>'Tanggal Udate','tipe'=>'tanggal','format'=>'d M Y');
    $field['penyakit']        = array('label'=>'Penyakit','tipe'=>'text');

    $aksi['view']  = 'dashboard/hasil_penyakit';

        // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
    $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$field,$result,$aksi);

    $load['_judul']  = 'Data Hasil Perangkingan (<b class="text-warning">'.$jml_data.'</b>)';

    $this->view_publik('home/hx_view', $load);
  }

  public function hasil_penyakit($id, $offset=null) {
    $get    = $this->input->get();
    $like   = array();
    $get_na  = '';
    $get_tg1 = '';
    $get_tg2 = '';

    if (isset($get['nama']) && $get['nama']) {
       $get_na = $get['nama'];
       $like   = array(array('nama_penyakit',$get['nama']));
    }

    if (isset($get['tanggal_start']) && $get['tanggal_start']) {
       $get_tg1    = $get['tanggal_start'];
       $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
    }

    if (isset($get['tanggal_end']) && $get['tanggal_end']) {
       $get_tg2    = $get['tanggal_end'];
       $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
    }

    $fields['nama'] = array('label'=>'Cari Nama Penyakit','tipe'=>'text','value'=>$get_na);
    $fields['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
    $fields['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

    $load['pencarian'] = ($get) ? TRUE : FALSE;
    $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'dashboard/hasil_penyakit'),$fields,$get);

    $param['select'] = 'penyakit.id_penyakit, penyakit.nama_penyakit';
    $param['order']  = 'nama_penyakit ASC';
    $param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;
    $result          = $this->mm->get('penyakit',$param);

    foreach ($result as $key => $value) {
       $param           = array();
       $param['select'] = 'sum(gejala.score) as score';
       $param['join']   = array(
          array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left'),
          array('hasil','gejala.id_gejala=hasil.id_gejala','right')
          );
       if ((!empty($get_tg1)) && (!empty($get_tg2))) {
          $param['where']   = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'].'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
       } else {
          $param['where']  = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'];
       }
       $param['order']  = 'penyakit.nama_penyakit ASC';
       $param['like']   = $like;
       $param['limit']  = $this->limit;
       $param['offset'] = $offset;
       $query           = $this->mm->get('gejala',$param);
       if (empty($query[0]['score'])) {
          unset($result[$key]);
       } else {
          $result[$key]['score'] = $query[0]['score'];
          $result[$key]['id_responden'] = $id;
       }
    }
    usort($result, function($a, $b) {
      return $a['score'] <= $b['score'];
    });
    $jml_data = count($result);

    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/hasil_penyakit';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    $arr['nomor_hal']   = $jml_a;
    $arr['kunci']       = 'id_penyakit';
    $arr['master']      = 'id_responden';

    $field['nama_penyakit']    = array('label'=>'Nama Penyakit','tipe'=>'text');
    $field['score']           = array('label'=>'Score','tipe'=>'text');

    $aksi['view']  = 'dashboard/hasil_gejala';

        // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
    $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$field,$result,$aksi);

    $load['_judul']  = 'Data Hasil Perangkingan Penyakit (<b class="text-warning">'.$jml_data.'</b>)';

    $load['_url']   = 'hasil';

    $this->view_publik('home/hx_view', $load);
  }

  public function hasil_gejala($id, $id_responden, $offset=null) {
    $get    = $this->input->get();
    $like   = array();
    $get_na  = '';
    $get_tg1 = '';
    $get_tg2 = '';

    if (isset($get['nama']) && $get['nama']) {
       $get_na = $get['nama'];
       $like   = array(array('nama_penyakit',$get['nama']));
    }

    if (isset($get['tanggal_start']) && $get['tanggal_start']) {
       $get_tg1    = $get['tanggal_start'];
       $like_tg11  = array(array('tanggal_start',$get['tanggal_start']));
    }

    if (isset($get['tanggal_end']) && $get['tanggal_end']) {
       $get_tg2    = $get['tanggal_end'];
       $like_tg2   = array(array('tanggal_start',$get['tanggal_end']));
    }

    $fields['nama'] = array('label'=>'Cari Nama Gejala','tipe'=>'text','value'=>$get_na);
    $fields['tanggal_start'] = array('label'=>'Tanggal Start','tipe'=>'tanggal', 'value'=>$get_tg1);
    $fields['tanggal_end'] = array('label'=>'Tanggal End','tipe'=>'tanggal', 'value'=>$get_tg2);

    $load['pencarian'] = ($get) ? TRUE : FALSE;
    $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'dashboard/hasil_gejala'),$fields,$get);

    $param['select'] = 'hasil.id_gejala, gejala.nama_gejala, gejala.score';
    $param['join']   = array(
       array('gejala','hasil.id_gejala=gejala.id_gejala','left'),
       array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left')
       );
    if ((!empty($get_tg1)) && (!empty($get_tg2))) {
       $param['where']   = 'hasil.id_responden='.$id_responden.' AND penyakit.id_penyakit='.$id.'hasil.tanggal BETWEEN "'.$get_tg1.'" AND "'.$get_tg2.'"';
    } else {
       $param['where']   = 'hasil.id_responden='.$id_responden.' AND penyakit.id_penyakit='.$id;
    }
    $param['order']  = 'gejala.nama_gejala ASC';
    $param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;
    $result          = $this->mm->get('hasil',$param);

    usort($result, function($a, $b) {
      return $a['score'] <= $b['score'];
    });
    $jml_data = count($result);

    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/hasil_gejala';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    $arr['nomor_hal']   = $jml_a;
    $arr['kunci']       = 'id_gejala';
    $arr['master']      = null;

    $field['nama_gejala']    = array('label'=>'Nama Gejala','tipe'=>'text');
    $field['score']           = array('label'=>'Score','tipe'=>'text');

    // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
    $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$field,$result);

    $load['_judul']  = 'Data Hasil Perangkingan Gejala (<b class="text-warning">'.$jml_data.'</b>)';

    $load['_url']   = 'hasil';

    $this->view_publik('home/hx_view', $load);
  }

  public function responden($offset=null) {
    $get    = $this->input->get();
    $like   = array();
    $get_na = '';

    if (isset($get['nama']) && $get['nama']) {
       $get_na = $get['nama'];
       $like   = array(array('nama_responden',$get['nama']));
    }

    $fields['nama'] = array('label'=>'Cari Nama','tipe'=>'text','value'=>$get_na);

    $load['pencarian'] = ($get) ? TRUE : FALSE;
    $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'dashboard/responden'),$fields,$get);

    // parameter utk ambil data dr database
    $param['select'] = 'responden.*, jenis_responden.nama_jenis_responden as jenis_responden';
    $param['join']   = array(array('responden','jenis_responden.id_jenis_responden=responden.id_jenis_responden','right'));
    $param['order']  = 'nama_responden ASC';
    $param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;

    // ambil data dari database
    $result   = $this->mm->get('jenis_responden',$param);
    $jml_data = count($result);

    // parameter utk ambil data dr database
    $param           = array();
    $param['select'] = 'nama_jenis_responden';

    // ambil data dari database
    $load['penyakit']   = $this->mm->get('jenis_responden',$param);

    // menghitung jumlah data
    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/responden';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    $arr['nomor_hal']   = $jml_a;
    $arr['kunci']       = 'id_responden';
    $arr['master']      = null;

    $field['nama_responden']  = array('label'=>'Nama Responden','tipe'=>'text');
    $field['jenis_responden'] = array('label'=>'Jenis Responden','tipe'=>'text');
    $field['tanggal']         = array('label'=>'Tanggal Udate','tipe'=>'tanggal','format'=>'d M Y');

    $aksi['view']  = 'dashboard/perangkingan';

    // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
    $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$field,$result,$aksi);

    $load['_judul']  = 'Data Responden (<b class="text-warning">'.$jml_data.'</b>)';

    $this->view_publik('home/hx_responden', $load);
  }

  public function simpan_responden(){
    $post = $this->input->post();

    $values = $this->mm->get('jenis_responden',array('where'=>'nama_jenis_responden like "'.$post['jenis'].'"'),'roar');

    $data = array(
      'nama_responden' => $post['nama'],
      'id_jenis_responden' => $values['id_jenis_responden']
      );

    //proses simpan
    $save = $this->mm->save('responden',$data);

    //jika simpan sukses
    if ($save) {
       $pesan = hx_info('success','Posting sukses');
    }
    //jika gagal
    else {
       $pesan = hx_info('success','Posting gagal');
    }

    $this->session->set_flashdata('hx_info',$pesan);
    redirect('dashboard/responden');
  }

  public function perangkingan($id, $offset=null) {
    $get    = $this->input->get();
    $like   = array();
    $get_na = '';

    if (isset($get['nama_gejala']) && $get['nama_gejala']) {
      $get_na = $get['nama_gejala'];
      $like   = array(array('nama_gejala',$get['nama_gejala']));
    }

    $field['nama_gejala'] = array('label'=>'Cari Nama Gejala','tipe'=>'text','value'=>$get_na);

    $load['pencarian'] = ($get) ? TRUE : FALSE;
    $load['form_cari'] = $this->hx_tabel->set_pencarian(array('aksi'=>'dashboard/perangkingan/'.$id),$field,$get);

    $param['select'] = 'gejala.id_gejala, gejala.nama_gejala';  
    $param['order']  = 'gejala.nama_gejala ASC';
    $param['like']   = $like;
    $param['offset'] = $offset;

    $result          = $this->mm->get('gejala',$param);
    foreach ($result as $key => $value) {
       $param = array();
       $param['select']        = 'if(count(id_gejala) > 0,"YA","TIDAK") as status';
       $param['join']          = array(array('responden','hasil.id_responden=responden.id_responden','left'));
       $param['where']         = 'responden.id_responden="'.$id.'" AND hasil.id_gejala="'.$value['id_gejala'].'"';
       $query                  = $this->mm->get('hasil',$param,'roar');
       $result[$key]['status'] = $query['status'];
       $result[$key]['id_responden'] = $id;
    }
    $jml_data = count($result);

    // Menampilkan hasil dari perangkingan yang dilakukan
    $param           = array();
    $param['select'] = 'penyakit.id_penyakit, penyakit.nama_penyakit';
    $param['order']  = 'nama_penyakit ASC';
    $param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;
    $hasil          = $this->mm->get('penyakit',$param);

    foreach ($hasil as $key => $value) {
       $param           = array();
       $param['select'] = 'sum(gejala.score) as score';
       $param['join']   = array(
          array('penyakit','gejala.id_penyakit=penyakit.id_penyakit','left'),
          array('hasil','gejala.id_gejala=hasil.id_gejala','right')
          );
       $param['where']  = 'hasil.id_responden='.$id.' AND penyakit.id_penyakit='.$value['id_penyakit'];
       $param['order']  = 'penyakit.nama_penyakit ASC';
       $param['like']   = $like;
       $param['limit']  = $this->limit;
       $param['offset'] = $offset;
       $query           = $this->mm->get('gejala',$param);
       if (empty($query[0]['score'])) {
          unset($hasil[$key]);
       } else {
          $hasil[$key]['score'] = $query[0]['score'];
       }
    }
    usort($hasil, function($a, $b) {
      return $a['score'] <= $b['score'];
    });
    $jum_hsl  = count($hasil);

    // Mengambail data responden
    $param['select'] = 'responden.nama_responden, jenis_responden.nama_jenis_responden';  
    $param['order']  = 'responden.nama_responden ASC';
    $param['join']   = array(
          array('jenis_responden','responden.id_jenis_responden=jenis_responden.id_jenis_responden','left')
          );
    $param['where']  = 'responden.id_responden='.$id;

    $responden       = $this->mm->get('responden',$param);

    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/responden';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    $arr['nomor_hal']   = $jml_a;
    $arr['kunci']       = 'id_gejala';
    $arr['master']      = 'id_responden';

    $aksi['add']   = 'dashboard/simpan_hasil/add';
    $aksi['hapus'] = 'dashboard/simpan_hasil/delete/'.$id;

    $jml_x    = ($offset) ? $offset+1 : 1;
    $jml_y    = (($offset+count($hasil))!=$jum_hsl) ? $offset+$this->limit : $jum_hsl;

    $out['url_halaman'] = 'dashboard/responden';
    $out['jml_data']    = $jum_hsl;
    $out['jml_a']       = $jml_x;
    $out['jml_b']       = $jml_y;

    $hsl['nomor_hal']   = $jml_x;
    $hsl['kunci']       = 'id_penyakit';
    $hsl['master']      = null;

    $field['nama_gejala']  = array('label'=>'Nama Gejala','tipe'=>'text','attr'=>'required');
    $field['status']       = array('label'=>'Status Responden','tipe'=>'text', 'attr'=>'required');

    $field2['nama_penyakit']  = array('label'=>'Nama Penyakit','tipe'=>'text','attr'=>'required');
    $field2['score']          = array('label'=>'Score','tipe'=>'text','attr'=>'required');

    // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);
    $load['_tabel']  = $this->hx_tabel->set_tabel($arr,$field,$result,$aksi);

    $load['_judul']  = 'Data Gejala (<b class="text-warning">'.$jml_data.'</b>)';

    $load['_hasil']  = $hasil;
    $load['_detail'] = $responden[0];

    $load['_paging_hasil'] = $this->hx_tabel->set_halaman($out,$this->limit,4);
    $load['_tabel_hasil']  = $this->hx_tabel->set_tabel($hsl,$field2,$hasil);

    $load['_judul_hasil']  = 'Data Hasil Perangkingan Gejala (<b class="text-warning">'.$jum_hsl.'</b>)';

    $load['_url']   = 'responden';

    $this->view_publik('home/hx_view', $load);
  }

  public function simpan_hasil($aksi,$id,$fk) {
    $data = array();
    $admin   = $this->al['id_petugas'];
    if ($aksi == 'add') {
      $data = array(
        'id_responden' => $fk,
        'id_gejala'    => $id,
        'id_user'     => $admin
        );
      $values = $this->mm->get('hasil',array('where'=>'id_responden='.$fk.' AND id_gejala='.$id),'roar');
      if ($values) {
        $pesan = hx_info('warning','Data telah dipilih');
      } else {
        $save = $this->mm->save('hasil',$data);
        if ($save) {
          $pesan = hx_info('success','Data telah tersimpan');
        } else {
          $pesan = hx_info('danger','Data gagal tersimpan');
        }
      }
      $this->session->set_flashdata('hx_info',$pesan);
      redirect('dashboard/perangkingan/'.$fk);
    } else {
      $data = array(
        'id_responden' => $id,
        'id_gejala'    => $fk
        );
      $values = $this->mm->get('hasil',array('where'=>'id_responden='.$id.' AND id_gejala='.$fk),'roar');
      if ($values) {
        $del = $this->mm->delete('hasil',$data);
        if ($del) {
          $pesan = hx_info('success','Data telah dihapus');
        }
        else {
          $pesan = hx_info('danger','Data gagal dihapus');
        }
      } else {
        $pesan = hx_info('warning','Data telah dihapus');
      }
      $this->session->set_flashdata('hx_info',$pesan);
      redirect('dashboard/perangkingan/'.$id);
    }
   }

  // halaman berita
  public function berita($offset=null) {
    // parameter utk ambil data dr database
    $param['select'] = 'berita.*, user.nama_lengkap as admin';
    $param['join']   = array(array('user','berita.id_user=user.id_user','left'));
    $param['order']  = 'tanggal_post DESC';
           //$param['like']   = $like;
    $param['limit']  = $this->limit;
    $param['offset'] = $offset;

    $result   = $this->mm->get('berita',$param);
    $jml_data = $this->mm->count('berita',$param);
    $jml_a    = ($offset) ? $offset+1 : 1;
    $jml_b    = (($offset+count($result))!=$jml_data) ? $offset+$this->limit : $jml_data;

    $hal['url_halaman'] = 'dashboard/berita';
    $hal['jml_data']    = $jml_data;
    $hal['jml_a']       = $jml_a;
    $hal['jml_b']       = $jml_b;

    // generate HTML
    $load['_paging'] = $this->hx_tabel->set_halaman($hal,$this->limit,4);

    $load['result']  = $result;
    $load['_judul']  = 'Berita (<b class="text-warning">'.$jml_data.'</b>)';

    $this->view_publik('home/berita', $load);
  }

  // halaman baca berita
  public function berita_detail($id) {
    // detail berita
    $param['select'] = 'berita.*, user.nama_lengkap as admin';
    $param['join']   = array(array('user','berita.id_user=user.id_user','left'));
    $param['where']  = 'id_berita='.$id;

    $load['result']  = $this->mm->get('berita',$param,'roar');

    // berita lainnya
    $paras['select'] = 'berita.*, user.nama_lengkap as admin';
    $paras['join']   = array(array('user','berita.id_user=user.id_user','left'));
    $paras['order']  = 'tanggal_post DESC';
    $paras['where']  = 'id_berita!='.$id;
    $paras['limit']  = 5;
    $paras['offset'] = 0;

    $load['lainnya'] = $this->mm->get('berita',$paras);

    $load['_judul']  = $load['result']['judul_berita'];
    $load['_desc']   = substr($load['result']['isi_berita'],0,250);
    $load['_img']    = ($load['result']['gambar']) ? base_url('as/foto_berita/'.$load['result']['gambar']) : '';

    $this->view_publik('home/berita_detail',$load);
  }

  // pendaftar petugas
  public function daftar() {
    // sertakan library hx_form
    $this->load->library('hx_form');

    // defenisikan kolom isian form
    $field1['nama_lengkap']  = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
    $field1['tempat_lahir']  = array('label'=>'Tempat Lahir','tipe'=>'text','attr'=>'required');
    $field1['tanggal_lahir'] = array('label'=>'Tanggal Lahir','tipe'=>'tanggal','attr'=>'required');
    $field1['jenis_kelamin'] = array('label'=>'Jenis Kelamin','tipe'=>'radio','list'=>array('L'=>'Laki-laki','P'=>'Perempuan'));
    $field2['alamat']        = array('label'=>'Alamat','tipe'=>'textarea');
    $field2['no_telp']       = array('label'=>'No Telepon','tipe'=>'text');

    $field3['email']         = array('label'=>'Email <small><i>(Digunakan saat login)</i></small>','tipe'=>'text','attr'=>'required');
    $field3['password']      = array('label'=>'Password <small><i>(Digunakan saat login)</i></small>','tipe'=>'password','attr'=>'required');
    $field3['foto']          = array('label'=>'Foto Pribadi','tipe'=>'file');

    $load['kolom1'] = $this->hx_form->set_form('vertical',$field1,array());
    $load['kolom2'] = $this->hx_form->set_form('vertical',$field2,array());
    $load['kolom3'] = $this->hx_form->set_form('vertical',$field3,array());

    $load['_judul'] = 'Form Pendaftaran Petugas';

    // kirim data ke view daftar
    $this->view_publik('home/daftar', $load);
  }

  // proses simpan data petugas
  public function daftar_proses($edit=null) {
    $post = $this->input->post();

    // konversi tanggal
    $post['tanggal_lahir'] = hx_tgl_id_mysql($post['tanggal_lahir']);

    // jika ada password
    if ($post['password']) {
      $post['password'] = sha1($post['password']); //enkripsi password
    } else {
      unset($post['password']);
    }

    // jika ada foto maka upload foto
    if ($_FILES) {
      $rand = rand(111111111,999999999);
      $nama = 'petugas-foto-'.$rand;

      $config['upload_path']   = './as/foto_petugas/';
      $config['allowed_types'] = 'jpg|png';
      $config['file_name']     = $nama;

      $this->load->library('upload', $config);

      if ($this->upload->do_upload('foto')) {
        $file = $this->upload->data();
        $post['foto'] = $file['file_name'];
      }
    }

    // jika edit profil petugas
    if ($edit=='edit') {
      $save = $this->mm->save('petugas',$post,array('id_user'=>$this->al['id_petugas']));

      if ($save) {
        $pesan = hx_info('success','Perubahan data telah tersimpan');
        $this->session->set_flashdata('hx_info',$pesan);
        redirect('dashboard/profil_petugas');
      } else {
        $pesan = hx_info('success','Perubahan data gagal tersimpan');
        $this->session->set_flashdata('hx_info',$pesan);
        redirect('dashboard/profil_petugas');
      }
    } else { // jika daftar petugas

      $post['status'] = 'Nonaktif';

      // proses simpan ke database
      $save = $this->mm->save('user',$post);

      // jika simpan data sukses
      if ($save) {
        $load['_judul'] = 'Pendaftaran Sukses';
        $load['status'] = 'sukses';

        $this->view_publik('home/daftar_notifikasi', $load);

      } else { // jika gagal
        $load['_judul'] = 'Pendaftaran Gagal';
        $load['status'] = 'gagal';

        $this->view_publik('home/daftar_notifikasi', $load);

      }
    }
  }

  // halaman profil petugas
  public function profil_petugas() {
    if (empty($this->al)) redirect('dashboard/index');

    //profil petugas
    $param['where']  = 'id_user='.$this->al['id_petugas'];
    $load['result']  = $this->mm->get('user',$param,'roar');

    $load['_judul']  = 'Profil '.$this->al['nama'];

    $this->view_publik('home/profil',$load);
  }

  // halaman edit profil petugas
  public function edit_profil() {
    if (empty($this->al)) redirect('dashboard/index');

    $values = $this->mm->get('user',array('where'=>'id_user='.$this->al['id_petugas']),'roar');

    $this->load->library('hx_form');

    $field1['nama_lengkap']  = array('label'=>'Nama Lengkap','tipe'=>'text','attr'=>'required');
    $field1['tempat_lahir']  = array('label'=>'Tempat Lahir','tipe'=>'text','attr'=>'required');
    $field1['tanggal_lahir'] = array('label'=>'Tanggal Lahir','tipe'=>'tanggal','attr'=>'required');
    $field1['jenis_kelamin'] = array('label'=>'Jenis Kelamin','tipe'=>'radio','list'=>array('L'=>'Laki-laki','P'=>'Perempuan'));
    $field2['alamat']        = array('label'=>'Alamat','tipe'=>'textarea');
    $field2['no_telp']       = array('label'=>'No Telepon','tipe'=>'text');

    $field3['email']         = array('label'=>'Email <small><i>(Digunakan saat login)</i></small>','tipe'=>'text','attr'=>'required');
    $field3['password']      = array('label'=>'Password <small><i>(Digunakan saat login)</i></small>','tipe'=>'password');
    $field3['foto']          = array('label'=>'Foto Pribadi','tipe'=>'file');

    $load['kolom1'] = $this->hx_form->set_form('vertical',$field1,$values);
    $load['kolom2'] = $this->hx_form->set_form('vertical',$field2,$values);
    $load['kolom3'] = $this->hx_form->set_form('vertical',$field3,$values);

    $load['_judul'] = 'Edit Profil Petugas';

    $this->view_publik('home/edit_profil', $load);
  }

}