<?php 
function is_logged_in()
{
    $ci = get_instance();
    if(!$ci->session->userdata('email')){
        redirect('auth');
    }   
}

function is_admin()
{
    $ci = get_instance();
    $role = $ci->session->userdata('id_role');

    $status = true;

    if ($role != '1') {
        $status = false;
    }

    return $status;
}

function is_user()
{
    $ci = get_instance();
    $role = $ci->session->userdata('id_role');

    $status = true;

    if ($role != '2') {
        $status = false;
    }

    return $status;
}

function getHari($hari){
    
    switch($hari){
        case 'Sun':
            $hari_ini = "Minggu";
        break;
 
        case 'Mon':         
            $hari_ini = "Senin";
        break;
 
        case 'Tue':
            $hari_ini = "Selasa";
        break;
 
        case 'Wed':
            $hari_ini = "Rabu";
        break;
 
        case 'Thu':
            $hari_ini = "Kamis";
        break;
 
        case 'Fri':
            $hari_ini = "Jumat";
        break;
 
        case 'Sat':
            $hari_ini = "Sabtu";
        break;
        
        default:
            $hari_ini = "Tidak di ketahui";     
        break;
    }
 
    return $hari_ini;
 
}

function  getBulan($bln){
    switch  ($bln){
        case  1:
        return  "Januari";
        break;
        case  2:
        return  "Februari";
        break;
        case  3:
        return  "Maret";
        break;
        case  4:
        return  "April";
        break;
        case  5:
        return  "Mei";
        break;
        case  6:
        return  "Juni";
        break;
        case  7:
        return  "Juli";
        break;
        case  8:
        return  "Agustus";
        break;
        case  9:
        return  "September";
        break;
        case  10:
        return  "Oktober";
        break;
        case  11:
        return  "November";
        break;
        case  12:
        return  "Desember";
        break;
    }
}