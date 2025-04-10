<?php
use Carbon\Carbon;


    if(!function_exists('rupiah')){
        function rupiah($angka){
            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
            return $hasil_rupiah;
        }
    }
    if(!function_exists('badge_role')){
        function badge_role($role)
        {
          if ($role === 'admin') {
            return '<span class="badge badge-danger">Admin</span>';
          } elseif ($role === 'petugas') {
            return '<span class="badge badge-primary">Petugas</span>';
          } else {
            return '<span class="badge badge-secondary">Unknown</span>';
          }
        }
      }
 
      if(!function_exists('date_formater')){
        function date_formater($datetime, $timezone = 'Asia/Jakarta'){
          return Carbon::parse($datetime, $timezone)
              ->translatedFormat('d-m-Y H:i:s');
        }
      }